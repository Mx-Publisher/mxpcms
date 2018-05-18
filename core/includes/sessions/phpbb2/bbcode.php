<?php
/**
*
* @package Functions_phpBB
* @version $Id: bbcode.php,v 1.5 2013/09/04 04:32:35 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL'))
{
	exit;
}

//
// Now load some bbcodes, to be extended for this backend (see below)
//
include_once($mx_root_path . 'includes/mx_functions_bbcode.' . $phpEx); // BBCode associated functions


/**
 * @package MX-Publisher
*/
class bitfield
{
	var $data;

	function bitfield($bitfield = '')
	{
		$this->data = base64_decode($bitfield);
	}

	/**
	*/
	function get($n)
	{
		// Get the ($n / 8)th char
		$byte = $n >> 3;

		if (strlen($this->data) >= $byte + 1)
		{
			$c = $this->data[$byte];

			// Lookup the ($n % 8)th bit of the byte
			$bit = 7 - ($n & 7);
			return (bool) (ord($c) & (1 << $bit));
		}
		else
		{
			return false;
		}
	}

	function set($n)
	{
		$byte = $n >> 3;
		$bit = 7 - ($n & 7);

		if (strlen($this->data) >= $byte + 1)
		{
			$this->data[$byte] = $this->data[$byte] | chr(1 << $bit);
		}
		else
		{
			$this->data .= str_repeat("\0", $byte - strlen($this->data));
			$this->data .= chr(1 << $bit);
		}
	}

	function clear($n)
	{
		$byte = $n >> 3;

		if (strlen($this->data) >= $byte + 1)
		{
			$bit = 7 - ($n & 7);
			$this->data[$byte] = $this->data[$byte] &~ chr(1 << $bit);
		}
	}

	function get_blob()
	{
		return $this->data;
	}

	function get_base64()
	{
		return base64_encode($this->data);
	}

	function get_bin()
	{
		$bin = '';
		$len = strlen($this->data);

		for ($i = 0; $i < $len; ++$i)
		{
			$bin .= str_pad(decbin(ord($this->data[$i])), 8, '0', STR_PAD_LEFT);
		}

		return $bin;
	}

	function get_all_set()
	{
		return array_keys(array_filter(str_split($this->get_bin())));
	}

	function merge($bitfield)
	{
		$this->data = $this->data | $bitfield->get_blob();
	}
}

/**
 * MXP BBcodes
 * @package MX-Publisher
 */
class mx_bbcode extends bbcode_base
{
	var $smiley_path_url = '';
	var $smiley_root_path =	'';
	var $smilies_path = '';

	var $smiley_url = 'smile_url';
	var $smiley_id = 'smilies_id';
	var $emotion = 'emoticon';

	var $bbcode_uid = '';
	var $bbcode_bitfield = '';
	var $bbcode_cache = array();
	var $bbcode_template = array();

	var $bbcodes = array();

	var $template_bitfield;
	var $template_filename = '';

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

		$this->smilies_path = str_replace("//", "/", $board_config['smilies_path']);
	}

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
	
		if (!$mytext)
		{
			return '';
		}
		
		$mytext = mx_censor_text($mytext);		
		
		//Do some checks
		$phpbb3_text = $bbcode_bitfield ? true : false;
		$bbcode_bitfield = ($bbcode_bitfield && (strlen($bbcode_bitfield) < 2)) ? false : $bbcode_bitfield;
		
		if (!empty($bbcode_uid))
		{
			$mytext = $this->bbencode_second_pass($mytext, $bbcode_uid, $bbcode_bitfield);
		}
		
		$mytext = str_replace(array("\n", "\r"), array('<br />', "\n"), $mytext);			
		$mytext = $this->bbcode_nl2br($mytext);
		
		//$mytext = smiley_text($mytext, !($flags & OPTION_FLAG_SMILIES));		
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

	//
	// This function will prepare a posted message for
	// entry into the database.
	//
	function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
	{
		global $board_config, $mx_bbcode, $mx_root_path, $phpEx, $html_entities_match, $html_entities_replace;

		//
		// Instantiate the mx_text class
		//
		include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smile_on);		
		
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
				$message .= preg_replace($html_entities_match, $html_entities_replace, $part) . $mx_text->clean_html($tag);
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
				'ipaper_open'	=> '<span>',
				'ipaper_close'	=> '</span>',				
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
			'ipaper_open'			=> array('{IPAPERCODE}'	=> '$1'),			
			'url'					=> array('{URL}'		=> '$1', '{DESCRIPTION}'	=> '$2'),
			'web'					=> array('{URL}'		=> '$1', '{DESCRIPTION}'	=> '$2'),
			'size'					=> array('{ID}'			=> '$1', '{TEXT}'			=> '$2'),			
			'email'					=> array('{EMAIL}'		=> '$1', '{DESCRIPTION}'	=> '$2')
		);

		$tpl = preg_replace_callback('/{L_([A-Z0-9_]+)}/', function ($match) use ($mx_user) {
			return (!empty($mx_user->lang[$match[1]])) ? $mx_user->lang($match[1]) : ucwords(strtolower(str_replace('_', ' ', $match[1])));
		}, $tpl);

		if (!empty($replacements[$tpl_name]))
		{
			$tpl = strtr($tpl, $replacements[$tpl_name]);
		}

		return trim($tpl);
	}

	
	/**
	* Init bbcode cache
	*
	* requires: $this->bbcode_bitfield
	* sets: $this->bbcode_cache with bbcode templates needed for bbcode_bitfield
	*/
	function bbcode_cache_init()
	{
		global $mx_user, $mx_root_path;

		if (empty($this->template_filename))
		{
			$this->template_bitfield = new bitfield(isset($mx_user->theme['bbcode_bitfield']) ? $mx_user->theme['bbcode_bitfield'] : 'kNg=');

			if (file_exists($mx_root_path . 'templates/' . $mx_user->template_name . '/template/bbcode.html'))
			{
				$this->template_filename = $mx_root_path . 'templates/' . $mx_user->template_name . '/template/bbcode.html';				
			}
			elseif (file_exists($mx_root_path . 'templates/' . $mx_user->template_name . '/template/bbcode.tpl'))
			{
				$this->template_filename = $mx_root_path . 'templates/' . $mx_user->template_name . '/template/bbcode.tpl';				
			}			
			if (file_exists($mx_root_path . 'templates/' . $mx_user->template_name . '/bbcode.tpl'))
			{
				$this->template_filename = $mx_root_path . 'templates/' . $mx_user->template_name . '/bbcode.tpl';				
			}
			elseif (file_exists($mx_root_path . 'templates/' . $mx_user->template_name . '/bbcode.html'))
			{
				$this->template_filename = $mx_root_path . 'templates/' . $mx_user->template_name . '/bbcode.html';				
			}			
			$this->template_filename2 = substr_count($this->template_filename, 'html') ? str_replace(".html", ".tpl", $this->template_filename) : str_replace(".tpl", ".html", $this->template_filename);
			if (!@file_exists($this->template_filename))
			{
				if (!@file_exists($this->template_filename2))
				{				
					trigger_error('The file ' . $this->template_filename . ', The file ' . $this->template_filename2 . ' is missing.', E_USER_ERROR);
				}
				else
				{
					$this->template_filename = $this->template_filename2;
				}				
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
								if (preg_match_all('/\{(URL|LOCAL_URL|WEB|IPAPERLINK|EMAIL|TEXT|SIMPLETEXT|IDENTIFIER|COLOR|NUMBER)[0-9]*\}/', $rowset[$bbcode_id]['bbcode_match'], $m))
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
		$text = str_replace(array("\n", "\r"), array('<br />', ""), $text);			
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
        $text = preg_replace($patterns, $replacements, $text);
        // align 
        $text = preg_replace("/\[align=(left|right|center|justify):$uid\]/si", $bbcode_tpl['align_open'], $text); 
        $text = str_replace("[/align:$uid]", $bbcode_tpl['align_close'], $text); 
        // marquee 
        $text = preg_replace("/\[marq=(left|right|up|down):$uid\]/si", $bbcode_tpl['marq_open'], $text); 
        $text = str_replace("[/marq:$uid]", $bbcode_tpl['marq_close'], $text); 
        // table 
        $text = preg_replace("/\[table=(.*?):$uid\]/si", $bbcode_tpl['table_open'], $text); 
        $text = str_replace("[/table:$uid]", $bbcode_tpl['table_close'], $text); 
        // cell 
        $text = preg_replace("/\[cell=(.*?):$uid\]/si", $bbcode_tpl['cell_open'], $text); 
        $text = str_replace("[/cell:$uid]", $bbcode_tpl['cell_close'], $text); 
        // center 
        $text = preg_replace("/\[center:$uid\]/si", $bbcode_tpl['center_open'], $text); 
        $text = str_replace("[/center:$uid]", $bbcode_tpl['center_close'], $text); 
       // font 
        $text = preg_replace("/\[font=(.*?):$uid\]/si", $bbcode_tpl['font_open'], $text); 
        $text = str_replace("[/font:$uid]", $bbcode_tpl['font_close'], $text); 
        // poet 
        $text = preg_replace("/\[poet(.*?):$uid\]/si", $bbcode_tpl['poet_open'], $text); 
        $text = str_replace("[/poet:$uid]", $bbcode_tpl['poet_close'], $text); 
       //[hr] 
        $text = str_replace("[hr:$uid]", $bbcode_tpl['hr'], $text); 
       // bbcode_box Mod 		
        // [fade] and [/fade] for faded text.
		$text = str_replace("[fade:$uid]", $bbcode_tpl['fade_open'], $text);
		$text = str_replace("[/fade:$uid]", $bbcode_tpl['fade_close'], $text);
        // real
        $patterns[] = "#\[ram:$uid\](.*?)\[/ram:$uid\]#si";
        $replacements[] = $bbcode_tpl['ram'];		
		// [stream]Sound URL[/stream] code..
		$patterns[] = "#\[stream:$uid\](.*?)\[/stream:$uid\]#si";
		$replacements[] = $bbcode_tpl['stream'];
        //web
        $patterns[] = "#\[web:$uid\](.*?)\[/web:$uid\]#si";
        $replacements[] = $bbcode_tpl['web'];	   
		// [flash width= height= loop= ] and [/flash] code..
        $patterns[] = "#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\](.*?)\[/flash:$uid\]#si";
        $replacements[] = $bbcode_tpl['flash'];
        // [flash width= height= loop= ] and [/flash] code..
        $patterns[10] = "#\[video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$uid\](.*?)\[/video:$uid\]#si";
        $replacements[10] = $bbcode_tpl['video'];		

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
	 * phpBB Smilies pass.
	 *
	 * Hacking smilies_pass from phpbb/includes/bbcode.php
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

			include($mx_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'smiliesbody' => 'posting_smilies.tpl')
			);
		}

		$sql = "SELECT emoticon, code, smile_url
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_id";
		if ($result = $db->sql_query($sql))
		{
			$num_smilies = 0;
			$rowset = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (empty($rowset[$row['smile_url']]))
				{
					$rowset[$row['smile_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
					$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
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
						'SMILEY_DESC' => isset($data['emoticon']) ? $data['emoticon'] : $row['emoticon'])
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