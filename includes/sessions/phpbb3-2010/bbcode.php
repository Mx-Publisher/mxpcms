<?php
/**
*
* @package Functions_phpBB
* @version $Id: bbcode.php,v 1.11 2009/07/12 05:13:00 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
*
*/

if (!defined('IN_PORTAL'))
{
	exit;
}

//
// Here comes a mxp version of original phpbb2 bbcode.php
// Last in file are the mxp wrapper functions
//

define("BBCODE_UID_LEN", 10);

// global that holds loaded-and-prepared bbcode templates, so we only have to do
// that stuff once.

$bbcode_tpl = null;
$bbcode_uid = null;

// Need to initialize the random numbers only ONCE
mt_srand( (double) microtime() * 1000000);

//
// Now load some bbcodes, to be extended for this backend (see below)
//
//include_once($mx_root_path . 'includes/mx_functions_bbcode.' . $phpEx); // BBCode associated functions
//

/**
 * MXP BBcodes
 * @package MX-Publisher
 */
class mx_bbcode
{
	var $smiley_path_url = '';
	var $smiley_root_path =	'';
	var $smilies_path = ''; 

	var $smiley_url = 'smiley_url';
	var $smiley_id = 'smiley_id';
	var $emotion = 'emotion';
	
	var $bbcode_uid = '';
	var $bbcode_bitfield = '';
	var $bbcode_cache = array();
	var $bbcode_template = array();

	var $bbcodes = array();

	var $template_bitfield;
	var $template_filename = '';
	
	var $site_url = '';
	var $document_id = '';
	var $access_key = '';
	var $height = 0;
	var $width = 0;

	/**
	* Constructor
	* Init bbcode cache entries if bitfield is specified
	*/
	function mx_bbcode($bitfield = '')
	{
		global $board_config, $phpbb_root_path;
		
		if ($bitfield)
		{
			$this->bbcode_bitfield = $bitfield;
			$this->bbcode_cache_init();
		}

		$this->smiley_path_url = PHPBB_URL; //change this to PORTAL_URL when shared folder will be removed
		$this->smiley_root_path =	$phpbb_root_path; //same here
		$board_config['smilies_path'] = str_replace("smiles", "smilies", $board_config['smilies_path']);
		$this->smilies_path = str_replace("//", "/", $board_config['smilies_path']);
		
	}
	
	/**
	* Second pass bbcodes
	*/
	function bbcode_second_pass(&$message, $bbcode_uid = '', $bbcode_bitfield = false)
	{
		if ($bbcode_uid)
		{
			$this->bbcode_uid = $bbcode_uid;
		}

		if ($bbcode_bitfield !== false)
		{
			//$this->bbcode_bitfield = $bbcode_bitfield;

			// Init those added with a new bbcode_bitfield (already stored codes will not get parsed again)
			$this->bbcode_cache_init();
		}

		//We are called from a Core block or non phpBB3, this should never be riched only when function is called direct
		if (!$this->bbcode_bitfield)
		{
			// Remove the uid from tags that have not been transformed into HTML
			/*
			if ($this->bbcode_uid)
			{
				$message = str_replace(':' . $this->bbcode_uid, '', $message);
			}
			*/
			return;
		}
		
		$str = array('search' => array(), 'replace' => array());
		$preg = array('search' => array(), 'replace' => array());

		$bitfield = new bitfield($this->bbcode_bitfield);
		$bbcodes_set = $bitfield->get_all_set();

		$undid_bbcode_specialchars = false;
		foreach ($bbcodes_set as $bbcode_id)
		{
			if (!empty($this->bbcode_cache[$bbcode_id]))
			{
				foreach ($this->bbcode_cache[$bbcode_id] as $type => $array)
				{
					foreach ($array as $search => $replace)
					{
						${$type}['search'][] = str_replace('$uid', $this->bbcode_uid, $search);
						${$type}['replace'][] = $replace;
					}

					if (sizeof($str['search']))
					{
						$message = str_replace($str['search'], $str['replace'], $message);
						$str = array('search' => array(), 'replace' => array());
					}

					if (sizeof($preg['search']))
					{
						// we need to turn the entities back into their original form to allow the
						// search patterns to work properly
						if (!$undid_bbcode_specialchars)
						{
							$message = str_replace(array('&#58;', '&#46;'), array(':', '.'), $message);
							$undid_bbcode_specialchars = true;
						}

						$message = preg_replace($preg['search'], $preg['replace'], $message);
						$preg = array('search' => array(), 'replace' => array());
					}
				}
			}
		}

		// Remove the uid from tags that have not been transformed into HTML
		$message = str_replace(':' . $this->bbcode_uid, '', $message);
	}

	/**
	* Init bbcode cache
	*
	* requires: $this->bbcode_bitfield
	* sets: $this->bbcode_cache with bbcode templates needed for bbcode_bitfield
	*/
	function bbcode_cache_init()
	{
		global $mx_user, $phpbb_root_path;

		if (empty($this->template_filename))
		{
			$this->template_bitfield = new bitfield($mx_user->theme['bbcode_bitfield']);
			$this->template_filename = $phpbb_root_path . 'styles/' . $mx_user->theme['template_path'] . '/template/bbcode.html';

			if (!@file_exists($this->template_filename))
			{
				trigger_error('The file ' . $this->template_filename . ' is missing.', E_USER_ERROR);
			}
		}

		$bbcode_ids = $rowset = $sql = array();

		$bitfield = new bitfield($this->bbcode_bitfield);
		$bbcodes_set = $bitfield->get_all_set();

		foreach ($bbcodes_set as $bbcode_id)
		{
			if (isset($this->bbcode_cache[$bbcode_id]))
			{
				// do not try to re-cache it if it's already in
				continue;
			}
			$bbcode_ids[] = $bbcode_id;

			if ($bbcode_id > NUM_CORE_BBCODES)
			{
				$sql[] = $bbcode_id;
			}
		}

		if (sizeof($sql))
		{
			global $db;

			$sql = 'SELECT *
				FROM ' . BBCODES_TABLE . '
				WHERE ' . $db->sql_in_set('bbcode_id', $sql);
			$result = $db->sql_query($sql, 3600);

			while ($row = $db->sql_fetchrow($result))
			{
				// To circumvent replacing newlines with <br /> for the generated html,
				// we use carriage returns here. They are later changed back to newlines
				$row['bbcode_tpl'] = str_replace("\n", "\r", $row['bbcode_tpl']);
				$row['second_pass_replace'] = str_replace("\n", "\r", $row['second_pass_replace']);

				$rowset[$row['bbcode_id']] = $row;
			}
			$db->sql_freeresult($result);
		}

		foreach ($bbcode_ids as $bbcode_id)
		{
			switch ($bbcode_id)
			{
				case 0:
					$this->bbcode_cache[$bbcode_id] = array(
						'str' => array(
							'[/quote:$uid]'	=> $this->bbcode_tpl('quote_close', $bbcode_id)
						),
						'preg' => array(
							'#\[quote(?:=&quot;(.*?)&quot;)?:$uid\]((?!\[quote(?:=&quot;.*?&quot;)?:$uid\]).)?#ise'	=> "\$this->bbcode_second_pass_quote('\$1', '\$2')"
						)
					);
				break;

				case 1:
					$this->bbcode_cache[$bbcode_id] = array(
						'str' => array(
							'[b:$uid]'	=> $this->bbcode_tpl('b_open', $bbcode_id),
							'[/b:$uid]'	=> $this->bbcode_tpl('b_close', $bbcode_id),
						)
					);
				break;

				case 2:
					$this->bbcode_cache[$bbcode_id] = array(
						'str' => array(
							'[i:$uid]'	=> $this->bbcode_tpl('i_open', $bbcode_id),
							'[/i:$uid]'	=> $this->bbcode_tpl('i_close', $bbcode_id),
						)
					);
				break;

				case 3:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'#\[url:$uid\]((.*?))\[/url:$uid\]#s'			=> $this->bbcode_tpl('url', $bbcode_id),
							'#\[url=([^\[]+?):$uid\](.*?)\[/url:$uid\]#s'	=> $this->bbcode_tpl('url', $bbcode_id),
						)
					);
				break;

				case 4:
					if ($mx_user->optionget('viewimg'))
					{
						$this->bbcode_cache[$bbcode_id] = array(
							'preg' => array(
								'#\[img:$uid\](.*?)\[/img:$uid\]#s'		=> $this->bbcode_tpl('img', $bbcode_id),
							)
						);
					}
					else
					{
						$this->bbcode_cache[$bbcode_id] = array(
							'preg' => array(
								'#\[img:$uid\](.*?)\[/img:$uid\]#s'		=> str_replace('$2', '[ img ]', $this->bbcode_tpl('url', $bbcode_id, true)),
							)
						);
					}
				break;

				case 5:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'#\[size=([\-\+]?\d+):$uid\](.*?)\[/size:$uid\]#s'	=> $this->bbcode_tpl('size', $bbcode_id),
						)
					);
				break;

				case 6:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'!\[color=(#[0-9a-f]{6}|[a-z\-]+):$uid\](.*?)\[/color:$uid\]!is'	=> $this->bbcode_tpl('color', $bbcode_id),
						)
					);
				break;

				case 7:
					$this->bbcode_cache[$bbcode_id] = array(
						'str' => array(
							'[u:$uid]'	=> $this->bbcode_tpl('u_open', $bbcode_id),
							'[/u:$uid]'	=> $this->bbcode_tpl('u_close', $bbcode_id),
						)
					);
				break;

				case 8:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'#\[code(?:=([a-z]+))?:$uid\](.*?)\[/code:$uid\]#ise'	=> "\$this->bbcode_second_pass_code('\$1', '\$2')",
						)
					);
				break;

				case 9:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'#(\[\/?(list|\*):[mou]?:?$uid\])[\n]{1}#'	=> "\$1",
							'#(\[list=([^\[]+):$uid\])[\n]{1}#'			=> "\$1",
							'#\[list=([^\[]+):$uid\]#e'					=> "\$this->bbcode_list('\$1')",
						),
						'str' => array(
							'[list:$uid]'		=> $this->bbcode_tpl('ulist_open_default', $bbcode_id),
							'[/list:u:$uid]'	=> $this->bbcode_tpl('ulist_close', $bbcode_id),
							'[/list:o:$uid]'	=> $this->bbcode_tpl('olist_close', $bbcode_id),
							'[*:$uid]'			=> $this->bbcode_tpl('listitem', $bbcode_id),
							'[/*:$uid]'			=> $this->bbcode_tpl('listitem_close', $bbcode_id),
							'[/*:m:$uid]'		=> $this->bbcode_tpl('listitem_close', $bbcode_id)
						),
					);
				break;

				case 10:
					$this->bbcode_cache[$bbcode_id] = array(
						'preg' => array(
							'#\[email:$uid\]((.*?))\[/email:$uid\]#is'			=> $this->bbcode_tpl('email', $bbcode_id),
							'#\[email=([^\[]+):$uid\](.*?)\[/email:$uid\]#is'	=> $this->bbcode_tpl('email', $bbcode_id)
						)
					);
				break;

				case 11:
					if ($mx_user->optionget('viewflash'))
					{
						$this->bbcode_cache[$bbcode_id] = array(
							'preg' => array(
								'#\[flash=([0-9]+),([0-9]+):$uid\](.*?)\[/flash:$uid\]#'	=> $this->bbcode_tpl('flash', $bbcode_id),
							)
						);
					}
					else
					{
						$this->bbcode_cache[$bbcode_id] = array(
							'preg' => array(
								'#\[flash=([0-9]+),([0-9]+):$uid\](.*?)\[/flash:$uid\]#'	=> str_replace('$1', '$3', str_replace('$2', '[ flash ]', $this->bbcode_tpl('url', $bbcode_id, true)))
							)
						);
					}
				break;

				case 12:
					$this->bbcode_cache[$bbcode_id] = array(
						'str'	=> array(
							'[/attachment:$uid]'	=> $this->bbcode_tpl('inline_attachment_close', $bbcode_id)
						),
						'preg'	=> array(
							'#\[attachment=([0-9]+):$uid\]#'	=> $this->bbcode_tpl('inline_attachment_open', $bbcode_id)
						)
					);
				break;
				
				
				default:
					if (isset($rowset[$bbcode_id]))
					{
						if ($this->template_bitfield->get($bbcode_id))
						{
							// The bbcode requires a custom template to be loaded
							if (!$bbcode_tpl = $this->bbcode_tpl($rowset[$bbcode_id]['bbcode_tag'], $bbcode_id))
							{
								// For some reason, the required template seems not to be available, use the default template
								$bbcode_tpl = (!empty($rowset[$bbcode_id]['second_pass_replace'])) ? $rowset[$bbcode_id]['second_pass_replace'] : $rowset[$bbcode_id]['bbcode_tpl'];
							}
							else
							{
								// In order to use templates with custom bbcodes we need
								// to replace all {VARS} to corresponding backreferences
								// Note that backreferences are numbered from bbcode_match
								if (preg_match_all('/\{(URL|LOCAL_URL|EMAIL|TEXT|SIMPLETEXT|IDENTIFIER|COLOR|NUMBER)[0-9]*\}/', $rowset[$bbcode_id]['bbcode_match'], $m))
								{
									foreach ($m[0] as $i => $tok)
									{
										$bbcode_tpl = str_replace($tok, '$' . ($i + 1), $bbcode_tpl);
									}
								}
							}
						}
						else
						{
							// Default template
							$bbcode_tpl = ($rowset[$bbcode_id]['second_pass_replace']) ? $rowset[$bbcode_id]['second_pass_replace'] : $rowset[$bbcode_id]['bbcode_tpl'];
						}

						// Replace {L_*} lang strings
						$bbcode_tpl = preg_replace('/{L_([A-Z_]+)}/e', "(!empty(\$mx_user->lang['\$1'])) ? \$mx_user->lang['\$1'] : ucwords(strtolower(str_replace('_', ' ', '\$1')))", $bbcode_tpl);

						if (!empty($rowset[$bbcode_id]['second_pass_replace']))
						{
							// The custom BBCode requires second-pass pattern replacements
							$this->bbcode_cache[$bbcode_id] = array(
								'preg' => array($rowset[$bbcode_id]['second_pass_match'] => $bbcode_tpl)
							);
						}
						else
						{
							$this->bbcode_cache[$bbcode_id] = array(
								'str' => array($rowset[$bbcode_id]['second_pass_match'] => $bbcode_tpl)
							);
						}
					}
					else
					{
						$this->bbcode_cache[$bbcode_id] = false;
					}
				break;
			}
		}
	}

	/**
	* Return bbcode template
	*/
	function bbcode_tpl($tpl_name, $bbcode_id = -1, $skip_bitfield_check = false)
	{
		static $bbcode_hardtpl = array();
		if (empty($bbcode_hardtpl))
		{
			global $mx_user;
			
			$bbcode_hardtpl = array(
				'b_open'	=> '<span style="font-weight: bold">',
				'b_close'	=> '</span>',
				'i_open'	=> '<span style="font-style: italic">',
				'i_close'	=> '</span>',
				'u_open'	=> '<span style="text-decoration: underline">',
				'u_close'	=> '</span>',
				'img'		=> '<center><img src="$1" alt="' . $mx_user->lang['IMAGE'] . '" /></center>',
				'size'		=> '<span style="font-size: $1%; line-height: normal">$2</span>',
				'color'		=> '<span style="color: $1">$2</span>',
				'email'		=> '<a href="mailto:$1">$2</a>'
			);
		}

		if ($bbcode_id != -1 && !$skip_bitfield_check && !$this->template_bitfield->get($bbcode_id))
		{
			return (isset($bbcode_hardtpl[$tpl_name])) ? $bbcode_hardtpl[$tpl_name] : false;
		}

		if (empty($this->bbcode_template))
		{
			if (($tpl = file_get_contents($this->template_filename)) === false)
			{
				trigger_error('Could not load bbcode template', E_USER_ERROR);
			}

			// replace \ with \\ and then ' with \'.
			$tpl = str_replace('\\', '\\\\', $tpl);
			$tpl = str_replace("'", "\'", $tpl);

			// strip newlines and indent
			$tpl = preg_replace("/\n[\n\r\s\t]*/", '', $tpl);

			// Turn template blocks into PHP assignment statements for the values of $bbcode_tpl..
			$this->bbcode_template = array();

			$matches = preg_match_all('#<!-- BEGIN (.*?) -->(.*?)<!-- END (?:.*?) -->#', $tpl, $match);

			for ($i = 0; $i < $matches; $i++)
			{
				if (empty($match[1][$i]))
				{
					continue;
				}

				$this->bbcode_template[$match[1][$i]] = $this->bbcode_tpl_replace($match[1][$i], $match[2][$i]);
			}
		}
		
		
		return (isset($this->bbcode_template[$tpl_name])) ? $this->bbcode_template[$tpl_name] : ((isset($bbcode_hardtpl[$tpl_name])) ? $bbcode_hardtpl[$tpl_name] : false);
	}

	/**
	* Return bbcode template replacement
	*/
	function bbcode_tpl_replace($tpl_name, $tpl)
	{
		global $mx_user;

		static $replacements = array(
			'quote_username_open'	=> array('{USERNAME}'	=> '$1'),
			'color'					=> array('{COLOR}'		=> '$1', '{TEXT}'			=> '$2'),
			'size'					=> array('{SIZE}'		=> '$1', '{TEXT}'			=> '$2'),
			'img'					=> array('{URL}'		=> '$1'),
			'flash'					=> array('{WIDTH}'		=> '$1', '{HEIGHT}'			=> '$2', '{URL}'		=> '$3'),
			'scribd'				=> array('{WIDTH}'		=> '$1', '{HEIGHT}'			=> '$2', '{SCRIBDURL}'	=> '$3'),
			'youtube'				=> array('{YOUTUBEID}'	=> '$1', '{YOUTUBELINK}'		=> '$2', '{WIDTH}'		=> '$3', '{HEIGHT}'			=> '$4'),			
			'ipaper'				=> array('{IPAPERID}'	=> '$1', '{IPAPERKEY}'		=> '$2', '{WIDTH}'		=> '$3', '{HEIGHT}'			=> '$4', '{IPAPERLINK}'	=> '$5'),			
			'url'					=> array('{URL}'		=> '$1', '{DESCRIPTION}'	=> '$2'),
			'size'					=> array('{ID}'			=> '$1', '{TEXT}'			=> '$2'),			
			'email'					=> array('{EMAIL}'		=> '$1', '{DESCRIPTION}'	=> '$2')
		);

		$tpl = preg_replace('/{L_([A-Z_]+)}/e', "(!empty(\$mx_user->lang['\$1'])) ? \$mx_user->lang['\$1'] : ucwords(strtolower(str_replace('_', ' ', '\$1')))", $tpl);

		if (!empty($replacements[$tpl_name]))
		{
			$tpl = strtr($tpl, $replacements[$tpl_name]);
		}

		return trim($tpl);
	}

	/**
	* Second parse list bbcode
	*/
	function bbcode_list($type)
	{
		if ($type == '')
		{
			$tpl = 'ulist_open_default';
			$type = 'default';
		}
		else if ($type == 'i')
		{
			$tpl = 'olist_open';
			$type = 'lower-roman';
		}
		else if ($type == 'I')
		{
			$tpl = 'olist_open';
			$type = 'upper-roman';
		}
		else if (preg_match('#^(disc|circle|square)$#i', $type))
		{
			$tpl = 'ulist_open';
			$type = strtolower($type);
		}
		else if (preg_match('#^[a-z]$#', $type))
		{
			$tpl = 'olist_open';
			$type = 'lower-alpha';
		}
		else if (preg_match('#[A-Z]#', $type))
		{
			$tpl = 'olist_open';
			$type = 'upper-alpha';
		}
		else if (is_numeric($type))
		{
			$tpl = 'olist_open';
			$type = 'arabic-numbers';
		}
		else
		{
			$tpl = 'olist_open';
			$type = 'arabic-numbers';
		}

		return str_replace('{LIST_TYPE}', $type, $this->bbcode_tpl($tpl));
	}

	/**
	* Second parse quote tag
	*/
	function bbcode_second_pass_quote($mx_username, $quote)
	{
		// when using the /e modifier, preg_replace slashes double-quotes but does not
		// seem to slash anything else
		$quote = str_replace('\"', '"', $quote);
		$mx_username = str_replace('\"', '"', $mx_username);

		// remove newline at the beginning
		if ($quote == "\n")
		{
			$quote = '';
		}

		$quote = (($mx_username) ? str_replace('$1', $mx_username, $this->bbcode_tpl('quote_username_open')) : $this->bbcode_tpl('quote_open')) . $quote;

		return $quote;
	}

	/**
	* Second parse code tag
	*/
	function bbcode_second_pass_code($type, $code)
	{
		// when using the /e modifier, preg_replace slashes double-quotes but does not
		// seem to slash anything else
		$code = str_replace('\"', '"', $code);

		switch ($type)
		{
			case 'php':
				// Not the english way, but valid because of hardcoded syntax highlighting
				if (strpos($code, '<span class="syntaxdefault"><br /></span>') === 0)
				{
					$code = substr($code, 41);
				}

			// no break;

			default:
				$code = str_replace("\t", '&nbsp; &nbsp;', $code);
				$code = str_replace('  ', '&nbsp; ', $code);
				$code = str_replace('  ', ' &nbsp;', $code);

				// remove newline at the beginning
				if (!empty($code) && $code[0] == "\n")
				{
					$code = substr($code, 1);
				}
			break;
		}

		$code = $this->bbcode_tpl('code_open') . $code . $this->bbcode_tpl('code_close');

		return $code;
	}
		

	/**
	 * Loads bbcode templates from the bbcode.tpl file of the current template set.
	 * Creates an array, keys are bbcode names like "b_open" or "url", values
	 * are the associated template.
	 * Probably pukes all over the place if there's something really screwed
	 * with the bbcode.tpl file.
	 *
	 * Nathan Codding, Sept 26 2001.
	  * This a temporary function
	 */
	function load_bbcode_template()
	{
		global $template;
		$tpl_filename = $template->make_filename('bbcode.tpl');
		$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));

		// replace \ with \\ and then ' with \'.
		$tpl = str_replace('\\', '\\\\', $tpl);
		$tpl  = str_replace('\'', '\\\'', $tpl);

		// strip newlines.
		$tpl  = str_replace("\n", '', $tpl);

		// Turn template blocks into PHP assignment statements for the values of $bbcode_tpls..
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$bbcode_tpls[\'\\1\'] = \'\\2\';', $tpl);

		$bbcode_tpls = array();

		eval($tpl);

		return $bbcode_tpls;
	}

	/**
	 * Prepares the loaded bbcode templates for insertion into preg_replace()
	 * or str_replace() calls in the bbencode_second_pass functions. This
	 * means replacing template placeholders with the appropriate preg backrefs
	 * or with language vars. NOTE: If you change how the regexps work in
	 * bbencode_second_pass(), you MUST change this function.
	 *
	 * Nathan Codding, Sept 26 2001
	 *
	  * This a temporary function
	 */
	function prepare_bbcode_template($bbcode_tpl)
	{
		global $document_id, $access_key, $height, $width;
		global $lang;

		$bbcode_tpl['olist_open'] = str_replace('{LIST_TYPE}', '\\1', $bbcode_tpl['olist_open']);

		$bbcode_tpl['color_open'] = str_replace('{COLOR}', '\\1', $bbcode_tpl['color_open']);

		$bbcode_tpl['size_open'] = str_replace('{SIZE}', '\\1', $bbcode_tpl['size_open']);

		$bbcode_tpl['quote_open'] = str_replace('{L_QUOTE}', $lang['Quote'], $bbcode_tpl['quote_open']);

		$bbcode_tpl['quote_username_open'] = str_replace('{L_QUOTE}', $lang['Quote'], $bbcode_tpl['quote_username_open']);
		$bbcode_tpl['quote_username_open'] = str_replace('{L_WROTE}', $lang['wrote'], $bbcode_tpl['quote_username_open']);
		$bbcode_tpl['quote_username_open'] = str_replace('{USERNAME}', '\\1', $bbcode_tpl['quote_username_open']);

		$bbcode_tpl['code_open'] = str_replace('{L_CODE}', $lang['Code'], $bbcode_tpl['code_open']);

		$bbcode_tpl['img'] = str_replace('{URL}', '\\1', $bbcode_tpl['img']);

		// We do URLs in several different ways..
		$bbcode_tpl['url1'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
		$bbcode_tpl['url1'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url1']);

		$bbcode_tpl['url2'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
		$bbcode_tpl['url2'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url2']);

		$bbcode_tpl['url3'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
		$bbcode_tpl['url3'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['url3']);

		$bbcode_tpl['url4'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
		$bbcode_tpl['url4'] = str_replace('{DESCRIPTION}', '\\3', $bbcode_tpl['url4']);

		$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);

		//Start more bbcode
		$bbcode_tpl['stream'] = str_replace('{URL}', '\\1', $bbcode_tpl['stream']);
		$bbcode_tpl['web'] = str_replace('{URL}', '\\1', $bbcode_tpl['web']);
		$bbcode_tpl['flash'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['flash']);
		$bbcode_tpl['flash'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['flash']);
		$bbcode_tpl['flash'] = str_replace('{URL}', '\\3', $bbcode_tpl['flash']);
		$bbcode_tpl['video'] = str_replace('{URL}', '\\3', $bbcode_tpl['video']);
		$bbcode_tpl['video'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['video']);
		$bbcode_tpl['video'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['video']);
		$bbcode_tpl['GVideo'] = str_replace('{GVIDEOID}', '\\1', $bbcode_tpl['GVideo']);
		$bbcode_tpl['GVideo'] = str_replace('{GVIDEOLINK}', $lang['Link'], $bbcode_tpl['GVideo']);
		$bbcode_tpl['youtube'] = str_replace('{YOUTUBEID}', '\\1', $bbcode_tpl['youtube']);
		$bbcode_tpl['youtube'] = str_replace('{YOUTUBELINK}', $lang['Link'], $bbcode_tpl['youtube']);
		$bbcode_tpl['youtube'] = str_replace('{WIDTH}', '\\3', $bbcode_tpl['youtube']);
		$bbcode_tpl['youtube'] = str_replace('{HEIGHT}', '\\4', $bbcode_tpl['youtube']);		
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERID}', '\\1', $bbcode_tpl['ipaper']);		
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERKEY}', '\\2', $bbcode_tpl['ipaper']);
		$bbcode_tpl['ipaper'] = str_replace('{WIDTH}', '\\3', $bbcode_tpl['ipaper']);
		$bbcode_tpl['ipaper'] = str_replace('{HEIGHT}', '\\4', $bbcode_tpl['ipaper']);	
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERLINK}', '\\5', $bbcode_tpl['ipaper']);
		//$bbcode_tpl['scribd'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['scribd']);
		//$bbcode_tpl['scribd'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['scribd']);
		$bbcode_tpl['scribd'] = str_replace('{SCRIBDID}', '\\1', $bbcode_tpl['scribd']);		
		$bbcode_tpl['scribd'] = str_replace('{SCRIBDURL}', $lang['Link'], $bbcode_tpl['scribd']);
		//Stop more bbcode

		define("BBCODE_TPL_READY", true);

		return $bbcode_tpl;
	}
	
	/**
	* custom version of nl2br which takes custom BBCodes into account
	*/
	function bbcode_nl2br($text)
	{
		// custom BBCodes might contain carriage returns so they
		// are not converted into <br /> so now revert that
		$text = str_replace(array("\n", "\r"), array('<br />', "\n"), $text);
		return $text;
	}	

	/**
	 * Does second-pass bbencoding. This should be used before displaying the message in
	 * a thread. Assumes the message is already first-pass encoded, and we are given the
	 * correct UID as used in first-pass encoding.
	 * This a temporary function
	 */
	function bbencode_second_pass($text, $uid = '', $bitfield = false)
	{
		global $lang, $bbcode_tpl;
		
		if ($uid)
		{
			$this->bbcode_uid = $uid;
		}

		if ($bitfield !== false)
		{
			$this->bbcode_bitfield = $bitfield;

			// Init those added with a new bbcode_bitfield (already stored codes will not get parsed again)
			$this->bbcode_cache_init();
		}		
	
		//Check if it's a phpBB3 block
		if ($bitfield)
		{
			$this->bbcode_second_pass($text, $uid, $bitfield);
		}
		
		//$text = str_replace(array("\n", "\r"), array('<br />', "\n"), $text);
			
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

		// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
		// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
		$text = " " . $text;

		// First: If there isn't a "[" and a "]" in the message, don't bother.
		if (! (strpos($text, "[") && strpos($text, "]")) )
		{
			// Remove padding, return.
			$text = substr($text, 1);
			return $text;
		}

		// Only load the templates ONCE..
		if (!defined("BBCODE_TPL_READY"))
		{
			// load templates from file into array.
			$bbcode_tpl = $this->load_bbcode_template();

			// prepare array for use in regexps.
			$bbcode_tpl = $this->prepare_bbcode_template($bbcode_tpl);
		}
		
		// [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.
		$text = $this->bbencode_second_pass_code($text, $uid, $bbcode_tpl);
		
		// [IPAPER] and [/IPAPER] for posting iPaper in your posts.
		$text = $this->bbencode_ipaper_pass_render($text, $uid, $bbcode_tpl);
		
		// [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.
		$text = str_replace("[quote:$uid]", $bbcode_tpl['quote_open'], $text);
		$text = str_replace("[/quote:$uid]", $bbcode_tpl['quote_close'], $text);

		// New one liner to deal with opening quotes with usernames...
		// replaces the two line version that I had here before..
		$text = preg_replace("/\[quote:$uid=\"(.*?)\"\]/si", $bbcode_tpl['quote_username_open'], $text);

		// [list] and [list=x] for (un)ordered lists.
		// unordered lists
		$text = str_replace("[list:$uid]", $bbcode_tpl['ulist_open'], $text);
		// li tags
		$text = str_replace("[*:$uid]", $bbcode_tpl['listitem'], $text);
		// ending tags
		$text = str_replace("[/list:u:$uid]", $bbcode_tpl['ulist_close'], $text);
		$text = str_replace("[/list:o:$uid]", $bbcode_tpl['olist_close'], $text);
		// Ordered lists
		$text = preg_replace("/\[list=([a1]):$uid\]/si", $bbcode_tpl['olist_open'], $text);

		// colours
		$text = preg_replace("/\[color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['color_open'], $text);
		$text = str_replace("[/color:$uid]", $bbcode_tpl['color_close'], $text);

		// size
		$text = preg_replace("/\[size=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['size_open'], $text);
		$text = str_replace("[/size:$uid]", $bbcode_tpl['size_close'], $text);

		// [b] and [/b] for bolding text.
		$text = str_replace("[b:$uid]", $bbcode_tpl['b_open'], $text);
		$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text);

		// [u] and [/u] for underlining text.
		$text = str_replace("[u:$uid]", $bbcode_tpl['u_open'], $text);
		$text = str_replace("[/u:$uid]", $bbcode_tpl['u_close'], $text);

		// [i] and [/i] for italicizing text.
		$text = str_replace("[i:$uid]", $bbcode_tpl['i_open'], $text);
		$text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text);
		
		//$text = str_replace('url:' . $uid, 'url', $text);
		
		// Patterns and replacements for URL and email tags..
		$patterns = array();
		$replacements = array();

		// [img]image_url_here[/img] code..
		// This one gets first-passed..
		$patterns[] = "#\[img:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
		$replacements[] = $bbcode_tpl['img'];

		// matches a [url]xxxx://www.phpbb.com[/url] code..
		$patterns[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
		$replacements[] = $bbcode_tpl['url1'];

		// [url]www.phpbb.com[/url] code.. (no xxxx:// prefix).
		$patterns[] = "#\[url\]((www|ftp)\.([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
		$replacements[] = $bbcode_tpl['url2'];

		// [url=xxxx://www.phpbb.com]phpBB[/url] code..
		$patterns[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
		$replacements[] = $bbcode_tpl['url3'];

		// [url=www.phpbb.com]phpBB[/url] code.. (no xxxx:// prefix).
		$patterns[] = "#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
		$replacements[] = $bbcode_tpl['url4'];

		// [email]user@domain.tld[/email] code..
		$patterns[] = "#\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#si";
		$replacements[] = $bbcode_tpl['email'];

		//Strat more bbcode

		// [stream]Sound URL[/stream] code..
		$patterns[] = "#\[stream:$uid\](.*?)\[/stream:$uid\]#si";
		$replacements[] = $bbcode_tpl['stream'];

		// [flash width=X height=X]Flash URL[/flash] code..
		$patterns[] = "#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\](.*?)\[/flash:$uid\]#si";
		$replacements[] = $bbcode_tpl['flash'];

		// [video width=X height=X]Video URL[/video] code..
		$patterns[] = "#\[video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\](.*?)\[/video:$uid\]#si";
		$replacements[] = $bbcode_tpl['video'];

		// [GVideo]GVideo URL[/GVideo] code..
	    $patterns[] = "#\[GVideo\]http://video.google.[A-Za-z0-9.]{2,5}/videoplay\?docid=([0-9A-Za-z-_]*)[^[]*\[/GVideo\]#is";
	    $replacements[] = $bbcode_tpl['GVideo'];

		// [youtube]www.youtube.com[/youtube] 
		$patterns[] = "#\[youtube\]http://(?:www\.)?youtube.com/watch\?v=([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#is";
	    $replacements[] = $bbcode_tpl['youtube'];

		// [youtube=xxxx://www.youtube.com]Youtube[/youtube] code..
		//$patterns[] = "#\[youtube=http://(?:www\.)?youtube.com/watch\?v=([0-9A-Za-z-_]{11})]([^?\n\r\t].*?)\[/youtube\]#is";
	    //$replacements[] = $bbcode_tpl['youtube'];
		
	    // [scribd]Scribd URL[/scribd] code..
		$patterns[] = "#\[scribd\]http://(?:d\.)?scribd.com/ScribdViewer.swf\?document_id=([0-9A-Za-z-_]*)[^[]*\[/scribd\]#is";		
		$replacements[] = $bbcode_tpl['scribd'];		

	    // [scribd]Scribd URL[/scribd] code..
	    $patterns[] = "#\[scribd id=([0-9A-Za-z-_]{8}) key=([0-9A-Za-z-_]{24})\](.*?)\[/scribd\]#is";
	    $replacements[] = $bbcode_tpl['scribd'];
		
	    // [ipaper]Scribd URL[/ipaper] code..
	    $patterns[] = "#\[ipaper\]http://(?:d\.)?scribd.com/ScribdViewer.swf\?document_id=([0-9A-Za-z-_]*)\&access_key=([0-9A-Za-z-_]*)[^[]*\[/ipaper\]#is";
	    $replacements[] = $bbcode_tpl['ipaper'];		

		//Stop more bbcode
		$text = preg_replace($patterns, $replacements, $text);

		// Remove the uid from tags that have not been transformed into HTML
		$text = str_replace(':' . $uid, '', $text);

		// Remove our padding from the string..
		$text = substr($text, 1);
		
		return $text;
		
	} // bbencode_second_pass()
	
	/**
	 * This is used to change a [*] tag into a [*:$uid] tag as part
	 * of the first-pass bbencoding of [list] tags. It fits the
	 * standard required in order to be passed as a variable
	 * function into bbencode_first_pass_pda().
	 */
	function replace_listitems($text, $uid)
	{
		$text = str_replace("[*]", "[*:$uid]", $text);

		return $text;
	}
	
	function make_bbcode_uid()
	{
		global $mx_backend;
		// Unique ID for this message..
		
		$uid = $mx_backend->dss_rand();
		
		// BBCode UID length fix
		@define('BBCODE_UID_LEN', (PORTAL_BACKEND == 'phpbb3') ? 8 : 10);		
		
		$uid = substr($uid, 0, BBCODE_UID_LEN);

		return $uid;
	}

	function bbencode_first_pass($text, $uid)
	{
		// pad it with a space so we can distinguish between FALSE and matching the 1st char (index 0).
		// This is important; bbencode_quote(), bbencode_list(), and bbencode_code() all depend on it.
		$text = " " . $text;

		// [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.
		$text = $this->bbencode_first_pass_pda($text, $uid, '[code]', '[/code]', '', true, '');
		
		// [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.
		$text = $this->bbencode_first_pass_pda($text, $uid, '[quote]', '[/quote]', '', false, '');
		$text = $this->bbencode_first_pass_pda($text, $uid, '/\[quote=\\\\&quot;(.*?)\\\\&quot;\]/is', '[/quote]', '', false, '', "[quote:$uid=\\\"\\1\\\"]");

		// [ipaper] and [/ipaper] for posting scribd embed bbcode in your posts.
		$text = $this->bbencode_first_pass_pda($text, $uid, '[ipaper]', '[/ipaper]', '', true, '');	
		
		// [youtube] and [/youtube] for posting scribd embed bbcode in your posts.
		$text = $this->bbencode_first_pass_pda($text, $uid, '[youtube]', '[/youtube]', '', true, '');

		// [scribd] and [/scribd] for posting scribd embed bbcode in your posts.		
		$text = $this->bbencode_first_pass_pda($text, $uid, '[scribd]', '[/scribd]', '', false, '');
		$text = $this->bbencode_first_pass_pda($text, $uid, '/\[scribd\\\\id=([0-9A-Za-z-_]{8})\\\\key=([0-9A-Za-z-_]{24})\](.*?)\]/is', '[/scribd]', '', false, '', "[scribd:$uid=\\\id=\\1\\\key=\\2\\\]");

		// [list] and [list=x] for (un)ordered lists.
		$open_tag = array();
		$open_tag[0] = "[list]";

		// unordered..
		$text = $this->bbencode_first_pass_pda($text, $uid, $open_tag, "[/list]", "[/list:u]", false, 'replace_listitems');

		$open_tag[0] = "[list=1]";
		$open_tag[1] = "[list=a]";

		// ordered.
		$text = $this->bbencode_first_pass_pda($text, $uid, $open_tag, "[/list]", "[/list:o]",  false, 'replace_listitems');

		// [color] and [/color] for setting text color
		$text = preg_replace("#\[color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/color\]#si", "[color=\\1:$uid]\\2[/color:$uid]", $text);

		// [size] and [/size] for setting text size
		$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);

		// [b] and [/b] for bolding text.
		$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);

		// [u] and [/u] for underlining text.
		$text = preg_replace("#\[u\](.*?)\[/u\]#si", "[u:$uid]\\1[/u:$uid]", $text);

		// [i] and [/i] for italicizing text.
		$text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text);

		// [img]image_url_here[/img] code..
		$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);

		//Start more bbcode
		$text = str_replace('url:' . $uid, 'url', $text);
		
		// [stream]Sound URL[/stream] code..
		$text = preg_replace("#\[stream\](.*?)\[/stream\]#si", "[stream:$uid]\\1[/stream:$uid]", $text);
		
		// [scribd width=X height=X]Scribd URL[/scribd] code..
		$text = preg_replace("#\[scribd width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\](([a-z]+?)://([^, \n\r]+))\[\/scribd\]#si","[scribd width=\\1 height=\\2:$uid\]\\3[/scribd:$uid]", $text);
	
		// [flash width=X height=X]Flash URL[/flash] code..
		$text = preg_replace("#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\](([a-z]+?)://([^, \n\r]+))\[\/flash\]#si","[flash width=\\1 height=\\2:$uid\]\\3[/flash:$uid]", $text);

		// [video width=X height=X]Video URL[/video] code..
		$text = preg_replace("#\[video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9])\](([a-z]+?)://([^, \n\r]+))\[\/video\]#si","[video width=\\1 height=\\2:$uid\]\\3[/video:$uid]", $text);

		//Stop more bbcode

		// Remove our padding from the string..
		return substr($text, 1);;

	} // bbencode_first_pass()	
	

	/**
	 * $text - The text to operate on.
	 * $uid - The UID to add to matching tags.
	 * $open_tag - The opening tag to match. Can be an array of opening tags.
	 * $close_tag - The closing tag to match.
	 * $close_tag_new - The closing tag to replace with.
	 * $mark_lowest_level - boolean - should we specially mark the tags that occur
	 * 					at the lowest level of nesting? (useful for [code], because
	 *						we need to match these tags first and transform HTML tags
	 *						in their contents..
	 * $func - This variable should contain a string that is the name of a function.
	 *				That function will be called when a match is found, and passed 2
	 *				parameters: ($text, $uid). The function should return a string.
	 *				This is used when some transformation needs to be applied to the
	 *				text INSIDE a pair of matching tags. If this variable is FALSE or the
	 *				empty string, it will not be executed.
	 * If open_tag is an array, then the pda will try to match pairs consisting of
	 * any element of open_tag followed by close_tag. This allows us to match things
	 * like [list=A]...[/list] and [list=1]...[/list] in one pass of the PDA.
	 *
	 * NOTES:	- this function assumes the first character of $text is a space.
	 *				- every opening tag and closing tag must be of the [...] format.
	 */
	function bbencode_first_pass_pda($text, $uid, $open_tag, $close_tag, $close_tag_new, $mark_lowest_level, $func, $open_regexp_replace = false)
	{
		$open_tag_count = 0;

		if (!$close_tag_new || ($close_tag_new == ''))
		{
			$close_tag_new = $close_tag;
		}

		$close_tag_length = strlen($close_tag);
		$close_tag_new_length = strlen($close_tag_new);
		$uid_length = strlen($uid);

		$use_function_pointer = ($func && ($func != ''));

		$stack = array();

		if (is_array($open_tag))
		{
			if (0 == count($open_tag))
			{
				// No opening tags to match, so return.
				return $text;
			}
			$open_tag_count = count($open_tag);
		}
		else
		{
			// only one opening tag. make it into a 1-element array.
			$open_tag_temp = $open_tag;
			$open_tag = array();
			$open_tag[0] = $open_tag_temp;
			$open_tag_count = 1;
		}

		$open_is_regexp = false;

		if ($open_regexp_replace)
		{
			$open_is_regexp = true;
			if (!is_array($open_regexp_replace))
			{
				$open_regexp_temp = $open_regexp_replace;
				$open_regexp_replace = array();
				$open_regexp_replace[0] = $open_regexp_temp;
			}
		}

		if ($mark_lowest_level && $open_is_regexp)
		{
			mx_message_die(GENERAL_ERROR, "Unsupported operation for bbcode_first_pass_pda().");
		}

		// Start at the 2nd char of the string, looking for opening tags.
		$curr_pos = 1;
		while ($curr_pos && ($curr_pos < strlen($text)))
		{
			$curr_pos = strpos($text, "[", $curr_pos);

			// If not found, $curr_pos will be 0, and the loop will end.
			if ($curr_pos)
			{
				// We found a [. It starts at $curr_pos.
				// check if it's a starting or ending tag.
				$found_start = false;
				$which_start_tag = "";
				$start_tag_index = -1;

				for ($i = 0; $i < $open_tag_count; $i++)
				{
					// Grab everything until the first "]"...
					$possible_start = substr($text, $curr_pos, strpos($text, ']', $curr_pos + 1) - $curr_pos + 1);

					//
					// We're going to try and catch usernames with "[' characters.
					//
					if( preg_match('#\[quote=\\\&quot;#si', $possible_start, $match) && !preg_match('#\[quote=\\\&quot;(.*?)\\\&quot;\]#si', $possible_start) )
					{
						// OK we are in a quote tag that probably contains a ] bracket.
						// Grab a bit more of the string to hopefully get all of it..
						if ($close_pos = strpos($text, '&quot;]', $curr_pos + 14))
						{
							if (strpos(substr($text, $curr_pos + 14, $close_pos - ($curr_pos + 14)), '[quote') === false)
							{
								$possible_start = substr($text, $curr_pos, $close_pos - $curr_pos + 7);
							}
						}
					}

					// Now compare, either using regexp or not.
					if ($open_is_regexp)
					{
						$match_result = array();
						if (preg_match($open_tag[$i], $possible_start, $match_result))
						{
							$found_start = true;
							$which_start_tag = $match_result[0];
							$start_tag_index = $i;
							break;
						}
					}
					else
					{
						// straightforward string comparison.
						if (0 == strcasecmp($open_tag[$i], $possible_start))
						{
							$found_start = true;
							$which_start_tag = $open_tag[$i];
							$start_tag_index = $i;
							break;
						}
					}
				}

				if ($found_start)
				{
					// We have an opening tag.
					// Push its position, the text we matched, and its index in the open_tag array on to the stack, and then keep going to the right.
					$match = array("pos" => $curr_pos, "tag" => $which_start_tag, "index" => $start_tag_index);
					array_push($stack, $match);
					//
					// Rather than just increment $curr_pos
					// Set it to the ending of the tag we just found
					// Keeps error in nested tag from breaking out
					// of table structure..
					//
					$curr_pos += strlen($possible_start);
				}
				else
				{
					// check for a closing tag..
					$possible_end = substr($text, $curr_pos, $close_tag_length);
					if (0 == strcasecmp($close_tag, $possible_end))
					{
						// We have an ending tag.
						// Check if we've already found a matching starting tag.
						if (sizeof($stack) > 0)
						{
							// There exists a starting tag.
							$curr_nesting_depth = sizeof($stack);
							// We need to do 2 replacements now.
							$match = array_pop($stack);
							$start_index = $match['pos'];
							$start_tag = $match['tag'];
							$start_length = strlen($start_tag);
							$start_tag_index = $match['index'];

							if ($open_is_regexp)
							{
								$start_tag = preg_replace($open_tag[$start_tag_index], $open_regexp_replace[$start_tag_index], $start_tag);
							}

							// everything before the opening tag.
							$before_start_tag = substr($text, 0, $start_index);

							// everything after the opening tag, but before the closing tag.
							$between_tags = substr($text, $start_index + $start_length, $curr_pos - $start_index - $start_length);

							// Run the given function on the text between the tags..
							if ($use_function_pointer)
							{
								$between_tags = $this->$func($between_tags, $uid);
							}

							// everything after the closing tag.
							$after_end_tag = substr($text, $curr_pos + $close_tag_length);

							// Mark the lowest nesting level if needed.
							if ($mark_lowest_level && ($curr_nesting_depth == 1))
							{
								if ($open_tag[0] == '[code]')
								{
									$code_entities_match = array('#<#', '#>#', '#"#', '#:#', '#\[#', '#\]#', '#\(#', '#\)#', '#\{#', '#\}#');
									$code_entities_replace = array('&lt;', '&gt;', '&quot;', '&#58;', '&#91;', '&#93;', '&#40;', '&#41;', '&#123;', '&#125;');
									$between_tags = preg_replace($code_entities_match, $code_entities_replace, $between_tags);
								}
								$text = $before_start_tag . substr($start_tag, 0, $start_length - 1) . ":$curr_nesting_depth:$uid]";
								$text .= $between_tags . substr($close_tag_new, 0, $close_tag_new_length - 1) . ":$curr_nesting_depth:$uid]";
							}
							else
							{
								if ($open_tag[0] == '[code]')
								{
									$text = $before_start_tag . '&#91;code&#93;';
									$text .= $between_tags . '&#91;/code&#93;';
								}
								else
								{
									if ($open_is_regexp)
									{
										$text = $before_start_tag . $start_tag;
									}
									else
									{
										$text = $before_start_tag . substr($start_tag, 0, $start_length - 1) . ":$uid]";
									}
									$text .= $between_tags . substr($close_tag_new, 0, $close_tag_new_length - 1) . ":$uid]";
								}
							}

							$text .= $after_end_tag;

							// Now.. we've screwed up the indices by changing the length of the string.
							// So, if there's anything in the stack, we want to resume searching just after it.
							// otherwise, we go back to the start.
							if (sizeof($stack) > 0)
							{
								$match = array_pop($stack);
								$curr_pos = $match['pos'];
	//							bbcode_array_push($stack, $match);
	//							++$curr_pos;
							}
							else
							{
								$curr_pos = 1;
							}
						}
						else
						{
							// No matching start tag found. Increment pos, keep going.
							++$curr_pos;
						}
					}
					else
					{
						// No starting tag or ending tag.. Increment pos, keep looping.,
						++$curr_pos;
					}
				}
			}
		} // while

		return $text;

	} // bbencode_first_pass_pda()

	/**
	 * Does second-pass bbencoding of the [code] tags. This includes
	 * running htmlspecialchars() over the text contained between
	 * any pair of [code] tags that are at the first level of
	 * nesting. Tags at the first level of nesting are indicated
	 * by this format: [code:1:$uid] ... [/code:1:$uid]
	 * Other tags are in this format: [code:$uid] ... [/code:$uid]
	  * This a temporary function
	 */
	function bbencode_second_pass_code($text, $uid, $bbcode_tpl)
	{
		global $lang;

		$code_start_html = $bbcode_tpl['code_open'];
		$code_end_html =  $bbcode_tpl['code_close'];

		// First, do all the 1st-level matches. These need an htmlspecialchars() run,
		// so they have to be handled differently.
		$match_count = preg_match_all("#\[code:1:$uid\](.*?)\[/code:1:$uid\]#si", $text, $matches);

		for ($i = 0; $i < $match_count; $i++)
		{
			$before_replace = $matches[1][$i];
			$after_replace = $matches[1][$i];

			// Replace 2 spaces with "&nbsp; " so non-tabbed code indents without making huge long lines.
			$after_replace = str_replace("  ", "&nbsp; ", $after_replace);
			// now Replace 2 spaces with " &nbsp;" to catch odd #s of spaces.
			$after_replace = str_replace("  ", " &nbsp;", $after_replace);

			// Replace tabs with "&nbsp; &nbsp;" so tabbed code indents sorta right without making huge long lines.
			$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);

			// now Replace space occurring at the beginning of a line
			$after_replace = preg_replace("/^ {1}/m", '&nbsp;', $after_replace);

			$str_to_match = "[code:1:$uid]" . $before_replace . "[/code:1:$uid]";

			$replacement = $code_start_html;
			$replacement .= $after_replace;
			$replacement .= $code_end_html;

			$text = str_replace($str_to_match, $replacement, $text);
		}

		// Now, do all the non-first-level matches. These are simple.
		$text = str_replace("[code:$uid]", $code_start_html, $text);
		$text = str_replace("[/code:$uid]", $code_end_html, $text);

		return $text;

	} // bbencode_second_pass_code()
	
	/**
	 * Rewritten by Florin C Bodin - July 10, 2009.	
	 * Description: Pass Embed Scibd iPaper in a post Pass
	 * Version: 0.2
	 * Original Author: Stuart Marsh
	 * Author URI: http://www.beardygeek.com
	 *  This should be used before displaying the message.
	 */	
	function bbencode_ipaper_pass_render($text, $uid, $bbcode_tpl)
	{
		global $document_id, $access_key, $height, $width;
		global $lang;
		
		$params = array('document_id','access_key','height','width');
		
		$ipaper_start_html = $bbcode_tpl['ipaper_open'];
		$ipaper_end_html =  $bbcode_tpl['ipaper_close'];
		
		// First, do all the 1st-level matches. 
		$match_count = preg_match_all("#\[ipaper:1:$uid\](.*?)\[/ipaper:1:$uid\]#si", $text, $matches);
		
		for ($i = 0; $i < $match_count; $i++)
		{
			
			$before_replace = $matches[1][$i];
			$after_replace = $matches[1][$i];
			
			//Remove  ipaper open and close bbcode tags.
			$before_replace  = str_replace(array($ipaper_start_html, $ipaper_end_html), "", $before_replace);
			$after_replace  = str_replace(array($ipaper_start_html, $ipaper_end_html), "", $after_replace);
			$after_replace = str_replace(array('&#8221;','&#8243;'), '', $after_replace);
			
			// Then, do the 2nd-level matches.				
			$total = preg_match_all("|([^?&#=]+)=([^?&#=]+)(#{0,}[^?&#=]*)|", $after_replace, $attributes, PREG_SET_ORDER);
			
			if ($total)
			{
				$this->ipaper_head();
			}
				
			$arguments[] = array();
					
			foreach ((array) $attributes as $elem)
			{
				if(!in_array($elem[$i], $params))
				{
					$arguments[$elem[1]] = $elem[2];
				}
			}					
			
			if ((!array_key_exists('document_id', $arguments)) && (!array_key_exists('access_key', $arguments)))
			{
				return '<div style="background-color:#f99; padding:10px;">Error: Required parameter "docId" or "access_key" is missing!</div>';
			}
				
			// First, do all the 1st-level matches.
			if (array_key_exists('document_id', $arguments))
			{
				$document_id = $arguments['document_id'];
			}
			else
			{
				$document_id = '';
			}
						
			if (array_key_exists('access_key', $arguments))
			{
				$access_key = $arguments['access_key'];
			}
			else
			{
				$access_key = 'key-';
			}
						
			if (array_key_exists('height', $arguments))
			{
				$height = $arguments['height'];
			}
			else
			{
				$height = 600;
			}
						
			if (array_key_exists('width', $arguments))
			{
				$width = $arguments['width'];
			}
			else
			{
				$width = 400;
			}		
							
			$after_replace = '';
			$after_replace .= "\n".'<p id="embedded_flash" style="text-align: center;"><a href="http://www.scribd.com">Scribd</a></p>'."\n";
			$after_replace .= '<script type="text/javascript">iPaper('.$document_id.', \''.$access_key.'\', '.$height.', '.$width.');</script>'."\n";
								
			$str_to_match = "[ipaper:1:$uid]" . $before_replace . "[/ipaper:1:$uid]";

			$replacement = $ipaper_start_html . $after_replace . $ipaper_end_html;

			$text = str_replace($str_to_match, $replacement, $text);
		
		}
	
		// Now, do all the non-first-level matches. These are simple.
		$text = str_replace("[ipaper:$uid]", $ipaper_start_html, $text);
		$text = str_replace("[/ipaper:$uid]", $ipaper_end_html, $text);
		
		return $text;

	} //bbencode_ipaper_pass_render()
	
	
	function ipaper_head()
	{
		// -------------------------------------------------------------------------
		// Extend page with additional header or footer data
		// Examples:
		//	$mx_page->add_css_file(); // Include style dependent *.css file, eg module_path/template_path/template/theme.css
		//	$mx_page->add_js_file( 'includes/js.js' ); // Relative to module_root
		//	$mx_page->add_header_text( 'header text' );
		//	$mx_page->add_footer_text( 'includes/test.txt', true ); // Relative to module_root
		//  Note: Included text from file (last example), will evaluate $theme and $mx_block->info variables.
		// -------------------------------------------------------------------------
	
		global $document_id, $access_key, $height, $width;
		global $mx_page;
		
		$addional_header_text = $header_text = "";
		
		$header_text .= '<script type="text/javascript" src="http://www.scribd.com/javascripts/view.js"></script>'."\n";
		$header_text .= '<script type="text/javascript">'."\n";
		$header_text .= '<!--'."\n";
		$header_text .= 'function iPaper(docId, access_key, height, width) {'."\n";
		$header_text .= 'var scribd_doc = scribd.Document.getDoc(docId, access_key);'."\n";
		$header_text .= 'scribd_doc.addParam(\'height\', height);'."\n";
		$header_text .= 'scribd_doc.addParam(\'width\', width);'."\n";
		$header_text .= 'scribd_doc.write(\'embedded_flash\');'."\n";
		$header_text .= '}'."\n";
		$header_text .= '//-->'."\n";
		$header_text .= '</script>';
		
		$addional_header_text .= "\n"."\n".$header_text;


		if (is_object($mx_page))
		{
			$mx_page->add_header_text($addional_header_text);	
		}		
	}		


	/**
	 * Rewritten by Nathan Codding - Feb 6, 2001.
	 * - Goes through the given string, and replaces xxxx://yyyy with an HTML <a> tag linking
	 * 	to that URL
	 * - Goes through the given string, and replaces www.xxxx.yyyy[zzzz] with an HTML <a> tag linking
	 * 	to http://www.xxxx.yyyy[/zzzz]
	 * - Goes through the given string, and replaces xxxx@yyyy with an HTML mailto: tag linking
	 *		to that email address
	 * - Only matches these 2 patterns either after a space, or at the beginning of a line
	 *
	 * Notes: the email one might get annoying - it's easy to make it more restrictive, though.. maybe
	 * have it require something like xxxx@yyyy.zzzz or such. We'll see.
	 * We can add here more phpBB3 stuff in time - Ory
	 */
	function make_clickable($text)
	{
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

		// pad it with a space so we can match things at the start of the 1st line.
		$ret = ' ' . $text;

		// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
		// xxxx can only be alpha characters.
		// yyyy is anything up to the first space, newline, comma, double quote or <
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);

		// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
		// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
		// zzzz is optional.. will contain everything up to the first space, newline,
		// comma, double quote or <.
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);

		// matches an email@domain type address at the start of a line, or after a space.
		// Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

		// Remove our padding..
		$ret = substr($ret, 1);

		return($ret);
	}

	/**
	 * Nathan Codding - Feb 6, 2001
	 * Reverses the effects of make_clickable(), for use in editpost.
	 * - Does not distinguish between "www.xxxx.yyyy" and "http://aaaa.bbbb" type URLs.
	 *
	 */
	function undo_make_clickable($text)
	{
		$text = preg_replace("#<!-- BBCode auto-link start --><a href=\"(.*?)\" target=\"_blank\">.*?</a><!-- BBCode auto-link end -->#i", "\\1", $text);
		$text = preg_replace("#<!-- BBcode auto-mailto start --><a href=\"mailto:(.*?)\">.*?</a><!-- BBCode auto-mailto end -->#i", "\\1", $text);

		return $text;

	}

	//
	// MXP Wrapper
	//

	/**
	 * bbcode to html.
	 *
	 * Convert the bbcode to html
	 *
	 * @param string $bbtext
	 * @param string $bbcode_uid
	 * @param boolean $smilies_on
	 * @return string
	 */
	function decode($mytext, $bbcode_uid, $smilies_on = true, $bbcode_bitfield = false)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx, $mx_page;
		
		//Do some checks
		$phpbb3_text = $bbcode_bitfield ? true : false;
		$bbcode_bitfield = ($bbcode_bitfield && (strlen($bbcode_bitfield) < 2)) ? false : $bbcode_bitfield;
		
		if ($bbcode_uid)
		{
			$mytext = $this->bbencode_second_pass($mytext, $bbcode_uid, $bbcode_bitfield);
		}
		
		if ($smilies_on && $phpbb3_text)
		{
			$mytext = $this->smilies3_pass($mytext);
		}
		else if ($smilies_on)
		{
			$mytext = $this->smilies_pass($mytext);
		}
		
		//$mytext = str_replace("\n", "\n<br />\n", $mytext);
		
		if ($mytext != '')
		{
			$mytext = $this->make_clickable($mytext);
		}		
		
		return $mytext;
	}

	/**
	 * Smilies pass.
	 *
	 * compatible with phpBB3 blocks
	 *
	 * @param string $message
	 * @return string
	 *
	*/	
	function smilies3_pass($message)
	{
		static $orig, $repl;
		global $board_config, $mx_root_path, $phpbb_root_path, $phpEx;

		if (!isset($orig))
		{
			global $db;
			$orig = $repl = array();

			$sql = 'SELECT * FROM ' . SMILIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
			}
			
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($row['code']))
				{
					continue;
				}

				// (assertion)
				$match[] = '(?<=^|[\n .])' . preg_quote($row['code'], '#') . '(?![^<>]*>)';
				$replace[] = '<!-- s' . $row['code'] . ' --><img src="{SMILIES_PATH}/' . $row['smiley_url'] . '" alt="' . $row['code'] . '" title="' . $row['emotion'] . '" /><!-- s' . $row['code'] . ' -->';
			}
			
			$db->sql_freeresult($result);			

			if (sizeof($match))
			{
				if ($max_smilies)
				{
					$num_matches = preg_match_all('#' . implode('|', $match) . '#', $message, $matches);
					unset($matches);

					if ($num_matches !== false && $num_matches > $max_smilies)
					{
						$this->warn_msg[] = sprintf($mx_user->lang['TOO_MANY_SMILIES'], $max_smilies);
						return;
					}
				}

				// Make sure the delimiter # is added in front and at the end of every element within $match
				$message = trim(preg_replace(explode(chr(0), '#' . implode('#' . chr(0) . '#', $match) . '#'), $replace, $message));
			}			
		}

		$message = str_replace("{SMILIES_PATH}", $this->smiley_path_url . $this->smilies_path . $smilies[$i][$this->smiley_url], ' ' . $message . ' ');
		
		return $message;
	}
	
	/**
	 * Smilies pass.
	 *
	 * compatible with phpBB2 blocks
	 *
	 * @param string $message
	 * @return string
	 *
	*/		
	function smilies_pass($message)
	{
		static $orig, $repl;
		global $board_config, $mx_root_path, $phpbb_root_path, $phpEx;

		if (!isset($orig))
		{
			global $db;
			$orig = $repl = array();

			$sql = 'SELECT * FROM ' . SMILIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
			}

			$smilies = $db->sql_fetchrowset($result);

			if (count($smilies))
			{
				@usort($smilies, 'smiley_sort');
			}

			for ($i = 0; $i < count($smilies); $i++)
			{
				$orig[] = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
				$repl[] = '<img src="' . $this->smiley_path_url . $board_config['smilies_path'] . '/' . $smilies[$i][$this->smiley_url] . '" alt="' . $smilies[$i][$this->emotion] . '" border="0" />';
			}
		}

		if (count($orig))
		{
			$message = preg_replace($orig, $repl, ' ' . $message . ' ');
			$message = substr($message, 1, -1);
		}

		return $message;
	}	

	/**
	 * phpBB Smilies pass.
	 *
	 * Hacking smilies_pass from phpbb/includes/bbcode.php
	 *
	 * NOTE: This is only kept for reference - not used.
	 *
	 * @param string $message
	 * @return string
	 */
	function mx_smilies_pass_old($message)
	{
		global $mx_page, $board_config, $phpbb_root_path, $phpEx;

		$smilies_path = $board_config['smilies_path'];
		$board_config['smilies_path'] = PHPBB_URL . $board_config['smilies_path'];
		$message = smilies_pass($message);
		$board_config['smilies_path'] = $smilies_path;
		return $message;
	}

	//
	// This function will prepare a posted message for
	// entry into the database.
	//
	function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
	{
		global $board_config, $html_entities_match, $html_entities_replace;

		//
		// Clean up the message
		//
		$message = trim($message);

		if ($html_on)
		{
			// If HTML is on, we try to make it safe
			// This approach is quite agressive and anything that does not look like a valid tag
			// is going to get converted to HTML entities
			$message = stripslashes($message);
			$html_match = '#<[^\w<]*(\w+)((?:"[^"]*"|\'[^\']*\'|[^<>\'"])+)?>#';
			$matches = array();

			$message_split = preg_split($html_match, $message);
			preg_match_all($html_match, $message, $matches);

			$message = '';

			foreach ($message_split as $part)
			{
				$tag = array(array_shift($matches[0]), array_shift($matches[1]), array_shift($matches[2]));
				$message .= preg_replace($html_entities_match, $html_entities_replace, $part) . clean_html($tag);
			}

			$message = addslashes($message);
			$message = str_replace('&quot;', '\&quot;', $message);
		}
		else
		{
			$message = preg_replace($html_entities_match, $html_entities_replace, $message);
		}

		if($bbcode_on && $bbcode_uid != '')
		{
			$message = $this->bbencode_first_pass($message, $bbcode_uid);
		}

		return $message;
	}
	
	//Core BBCode Starts

	/**
	 * Generate smilies.
	 *
	 * Hacking generate_smilies from phpbb/includes/functions_post(ing).php
	 *
	 * @param string $mode
	 * @param integer $page_id
	*
	* Fill smiley templates (or just the variables) with smilies, either in a window or inline
	*/
	function generate_smilies($mode, $forum_id)
	{
		global $mx_page, $board_config, $template, $mx_root_path, $phpbb_root_path, $phpEx;
		global $db, $lang, $images, $theme;
		global $user_ip, $session_length, $starttime;
		global $userdata, $phpbb_auth, $mx_user;

		$inline_columns = 4;
		$inline_rows = 5;
		$window_columns = 8;

		if ($mode == 'window')
		{
			$mx_user->init($user_ip, PAGE_INDEX);

			$gen_simple_header = TRUE;
			$page_title = $lang['Emoticons'];

			if ($forum_id)
			{
				$sql = 'SELECT forum_style
					FROM ' . FORUMS_TABLE . "
					WHERE forum_id = $forum_id";
				$result = $db->sql_query_limit($sql, 1);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$mx_user->setup('posting', (int) $row['forum_style']);
			}
			else
			{
				$mx_user->setup('posting');
			}

			include($mx_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'smiliesbody' => 'posting_smilies.html')
			);
		}

		$display_link = false;
		if ($mode == 'inline')
		{
			$sql = 'SELECT smiley_id
				FROM ' . SMILIES_TABLE . '
				WHERE display_on_posting = 0';
			$result = $db->sql_query_limit($sql, 1, 0, 3600);

			if ($row = $db->sql_fetchrow($result))
			{
				$display_link = true;
			}
			$db->sql_freeresult($result);
		}

		$last_url = '';

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE .
			(($mode == 'inline') ? ' WHERE display_on_posting = 1 ' : '') . '
			ORDER BY smiley_order';

		//phpBB2 code start
		if ($result = $db->sql_query($sql))
		{
			$num_smilies = 0;
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($rowset[$row['smiley_url']]))
				{
					$rowset[$row['smiley_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
					$rowset[$row['smiley_url']]['emoticon'] = $row['emoticon'];
					$num_smilies++;
				}
			}

			if ($num_smilies)
			{
				$smilies_count = ($mode == 'inline') ? min(19, $num_smilies) : $num_smilies;
				$smilies_split_row = ($mode == 'inline') ? $inline_columns - 1 : $window_columns - 1;

				$s_colspan = 0;
				$row = 0;
				$col = 0;

				while (list($smile_url, $data) = @each($rowset))
				{
					if (!$col)
					{
						$template->assign_block_vars('smilies_row', array());
					}

					$template->assign_block_vars('smilies_row.smilies_col', array(
						'SMILEY_CODE' => $data['code'],
						'SMILEY_IMG' => $this->smiley_path_url  . $board_config['smilies_path'] . '/' . $smile_url,
						'SMILEY_DESC' => $data['emoticon'])
					);

					$s_colspan = max($s_colspan, $col + 1);

					if ($col == $smilies_split_row)
					{
						if ($mode == 'inline' && $row == $inline_rows - 1)
						{
							break;
						}
						$col = 0;
						$row++;
					}
					else
					{
						$col++;
					}
				}

				if ($mode == 'inline' && $num_smilies > $inline_rows * $inline_columns)
				{
					$template->assign_block_vars('switch_smilies_extra', array());

					$template->assign_vars(array(
						'L_MORE_SMILIES' => $lang['More_emoticons'],
						'U_MORE_SMILIES' => mx3_append_sid(PHPBB_URL . "posting.$phpEx", "mode=smilies"))
					);
				}

				$template->assign_vars(array(
					'L_EMOTICONS' => $lang['Emoticons'],
					'L_CLOSE_WINDOW' => $lang['Close_window'],
					'S_SMILIES_COLSPAN' => $s_colspan)
				);
			}
		}

		if ($mode == 'window')
		{
			$template->pparse('smiliesbody');
			include($mx_root_path . 'includes/page_tail.'.$phpEx);
		}
	}
}
?>