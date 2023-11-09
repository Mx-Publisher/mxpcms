<?php
/**
*
* @package Tools
* @version $Id: mx_functions_tools.php,v 3.68 2023/11/09 08:42:24 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if (!defined('IN_PORTAL'))
{
	die("Hacking attempt in tools.");
}

/**
 * Class: mx_text.
 *
 * This class simplifies all text handling: display text on pages, formatting text for editing and storing.
 * - based on phpBB 2.0.x code
 *
 * Methods:
 * - display[_simple]: decode rich/simple text (from db) for display on normal pages
 * - decode[_simple]: decode rich/simple text for editing in form fields
 * - encode_preview[_simple]: encode rich/simple form data for preview
 * - encode[_simple|_username]: encode form data to be stored in db
 *
 * Note: Be sure to check in what format the methods expect its data
 * Note(2): Be sure to init the object before usage.
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class mx_text
{
	var	$orig_word = array();
	var	$replacement_word = array();

	var $highlight_match = '';
	var $highlight_match_color = '';
	var $highlight = '';

	var $bbcode_uid = ''; // set when encoding data

	//
	// Toggles
	//
	var $html_on = false;
	var $bbcode_on = true;
	var $smilies_on = false;
	var $links_on = true;
	var $images_on = true;

	var $allow_all_html_tags = false;

	/**
	 * Init.
	 *
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smilies_on
	 * @param unknown_type $links_on
	 * @param unknown_type $images_on
	 */
	function init($html_on = false, $bbcode_on = true, $smilies_on = false, $links_on = true, $images_on = true)
	{
		global $theme, $mx_cache;

		//
		// Toggles
		//
		$this->html_on = $html_on;
		$this->bbcode_on = $bbcode_on;
		$this->smilies_on = $smilies_on;
		$this->links_on = $links_on;
		$this->images_on = $images_on;

		//
		// Define censored word matches
		// Note: This is a workaraound for new Olympus style cache.
		//		
		static $censors;

		// We moved the word censor checks in here because we call this function quite often - and then only need to do the check once
		if (!isset($censors) || !is_array($censors))
		{
			global $mx_user;

			// We check here in future if the user is having viewing censors disabled (and also allowed to do so).
			if (!$mx_user->optionget('viewcensors'))
			{
				$censors = array();
			}
			else
			{
				$censors = $mx_cache->obtain_word_list();
			}
		}

		if (sizeof($censors))
		{
			$this->orig_word = $censors['match'];
			$this->replacement_word = $censors['replace'];
		}
		else
		{
			$this->orig_word = array();
			$this->replacement_word = array();
		}

		//
		// Was a highlight request part of the URI?
		//
		if (isset($_GET['highlight']))
		{
			// Split words and phrases
			$words = explode(' ', trim(htmlspecialchars($_GET['highlight'])));

			for($i = 0; $i < sizeof($words); $i++)
			{
				if (trim($words[$i]) != '')
				{
					$this->highlight_match .= (($this->highlight_match != '') ? '|' : '') . str_replace('*', '\w*', preg_quote($words[$i], '#'));
				}
			}
			unset($words);

			$this->highlight = urlencode($_GET['highlight']);
			$this->highlight_match = phpBB2::phpbb_rtrim($this->highlight_match, "\\");
		}

		//
		// Highlight match color
		//
		$this->highlight_match_color = isset($theme['fontcolor3']) ? $theme['fontcolor3'] : 'FFFFFF';

	}

	/**
	 * Display.
	 *
	 * @param string $text text (from db)
	 * @param string $bbcode_uid
	 */
	function display($text, $bbcode_uid = '')
	{
		global $mx_bbcode;
		
		//
		// strip html if reqd
		//ş
		if (!$this->html_on)
		{
			if ($text != '')
			{
				$text = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $text);
			}
		}
		
		//
		// BBCode if reqd
		//
		if ($text != '' && $bbcode_uid != '')
		{
			$text = ($this->bbcode_on) ? $mx_bbcode->bbencode_second_pass($text, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $text);
			//$text = ($this->bbcode_on) ? $mx_bbcode->decode($text, $bbcode_uid): preg_replace("/\:$bbcode_uid/si", '', $text);
		}
		

		if ($text != '')
		{
			$text = $mx_bbcode->make_clickable($text);
		}
		
		//
		// Parse smilies
		//
		if ($this->smilies_on)
		{
			if ($text != '')
			{
				$text = $mx_bbcode->smilies_pass($text);
			}
		}
		
		//
		// Highlight active words (primarily for search)
		//
		if ($this->highlight_match)
		{
			// This has been back-ported from 3.0 CVS
			/* $text = preg_replace('#(?!<.*)(?<!\w)(' . $this->highlight_match . ')(?!\w|[^<>]*>)#i', '<b style="color:#'.$this->highlight_match_color.'">\1</b>', $text);  */
		}

		//
		// Replace naughty words
		//
		if (count($this->orig_word))
		{
			if ($text != '')
			{
				/* $text = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$this->orig_word, \$this->replacement_word, '\\0')", '>' . $text . '<'), 1, -1)); */
			}

		}

		//
		// Replace newlines (we use this rather than nl2br because
		// till recently it wasn't XHTML compliant)
		//
		if ($text != '')
		{
			if ( !($this->html_on && !$this->bbcode_on) ) // If this is not a html textblock
			{
				$text = str_replace("\n", "\n<br />\n", $text);
			}
		}
		return $text;
	}

	/**
	 * Display simple text.
	 *
	 * Eg: titles, short descriptions etc
	 *
	 * @param unknown_type $text
	 */
	function display_simple($text)
	{
		if ( $text != '' )
		{
			$text = ( count($this->orig_word) ) ? preg_replace($this->orig_word, $this->replacement_word, $text) : $text;
		}

		return $text;
	}

	/**
	 * Decode rich text.
	 *
	 * Decode rich text for editing in form fields.
	 *
	 * @param unknown_type $text
	 * @param unknown_type $bbcode_uid
	 * @param unknown_type $refresh
	 */
	function decode($text, $bbcode_uid = '', $refresh = false)
	{
		if ($refresh)
		{
			//
			// This is raw _GET/_POST data
			//
			$text = ( !empty($text) ) ? htmlspecialchars(trim(stripslashes($text))) : '';
		}

		if ( $bbcode_uid != '' )
		{
			$text = preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $text);
		}

		$text = str_replace('<', '&lt;', $text);
		$text = str_replace('>', '&gt;', $text);
		$text = str_replace('<br />', "\n", $text);

		return $text;
	}

	/**
	 * Decode simple text.
	 *
	 * Decode simple text for editing in form fields.
	 *
	 * Eg: titles, usernames, short descriptions etc
	 *
	 * @param unknown_type $text
	 * @param unknown_type $refresh
	 */
	function decode_simple($text, $refresh = false)
	{

		if ($refresh)
		{
			//
			// This is raw _GET/_POST data
			//
			$text = ( !empty($text) ) ? htmlspecialchars(trim(stripslashes($text))) : '';
		}

		return $text;
	}

	/**
	 * Encode.
	 *
	 * Encode rich form data to be stored in db.
	 *
	 * Encode text to be db valid.
	 * Note: passed "text" should be raw _GET/_POST data
	 *
	 * @param unknown_type $text
	 * @return unknown
	 */
	function encode($text)
	{
		global $board_config, $userdata, $lang, $phpEx, $phpbb_root_path, $mx_bbcode;

		$this->bbcode_uid = '';

		//
		// Check message
		//
		if (!empty($text))
		{
			$this->bbcode_uid = ($this->bbcode_on) ? $mx_bbcode->make_bbcode_uid() : '';
			$text = $this->prepare_message(trim($text), $this->html_on, $this->bbcode_on, $this->smilies_on, $this->bbcode_uid);
		}

		return str_replace("\'", "''", $text);
	}

	/**
	 * Encode simple.
	 *
	 * encode simple form data to be stored in db.
	 *
	 * @param unknown_type $text
	 */
	function encode_simple($text)
	{
		global $board_config, $userdata, $lang, $phpEx, $phpbb_root_path;

		//
		// Check $text
		//
		if (!empty($text))
		{
			$text = htmlspecialchars(trim($text));
		}

		return str_replace("\'", "''", $text);
	}

	/**
	 * Encode username.
	 *
	 * Encode username form data to be stored in db.
	 *
	 * @param unknown_type $username
	 */
	function encode_username($username)
	{
		global $board_config, $userdata, $lang, $phpEx, $phpbb_root_path, $phpBB2;

		//
		// Check username
		//
		if (!empty($username))
		{
			$username = $phpBB2->phpbb_clean_username($username);

			if (!$userdata['session_logged_in'] || ($userdata['session_logged_in'] && $username != $userdata['username']))
			{
				include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

				$result = validate_username($username);
				if ($result['error'])
				{
					$error_msg .= (!empty($error_msg)) ? '<br />' . $result['error_msg'] : $result['error_msg'];
				}
			}
			else
			{
				$username = '';
			}
		}

		return str_replace("\'", "''", $username);
	}

	/**
	 * Encode preview.
	 *
	 * Encode rich form data for preview
	 *
	 * @param unknown_type $text
	 */
	function encode_preview($text)
	{
		global $html_entities_match, $html_entities_replace, $board_config, $mx_bbcode;

		if ($this->allow_all_html_tags)
		{
			$html_entities_match = array();
			$html_entities_replace = array();
			$board_config['allow_html_tags'] = '';
		}

		$text = ( !empty($text) ) ? htmlspecialchars(trim(stripslashes($text))) : '';

		$bbcode_uid = ( $this->bbcode_on ) ? $mx_bbcode->make_bbcode_uid() : '';
		$text = stripslashes($this->prepare_message(addslashes($this->unprepare_message($text)), $this->html_on, $this->bbcode_on, $this->smilies_on, $bbcode_uid));

		if( $this->bbcode_on )
		{
			$text = $mx_bbcode->bbencode_second_pass($text, $bbcode_uid);
		}

		if( !empty($this->orig_word) )
		{
			$text = ( !empty($text) ) ? preg_replace($this->orig_word, $this->replacement_word, $text) : '';
		}

		$text = $mx_bbcode->make_clickable($text);

		if( $this->smilies_on )
		{
			$text = $mx_bbcode->smilies_pass($text);
		}

		$text = str_replace("\n", '<br />', $text);

		return $text;
	}

	/**
	 * Encode preview simple.
	 *
	 * Encode simple form data for preview
	 *
	 * Eg: Works for titles, usernames, etc
	 *
	 * @param unknown_type $text
	 */
	function encode_preview_simple($text)
	{
		$text = ( !empty($text) ) ? htmlspecialchars(trim(stripslashes($text))) : '';

		if( !empty($this->orig_word) )
		{
			$text = ( !empty($text) ) ? preg_replace($this->orig_word, $this->replacement_word, $text) : '';
		}

		return $text;
	}

	/**
	 * Prepare message.
	 *
	 * This function will prepare a posted message for
	 * entry into the database.
	 * - borrowed from phpBB 2.0.21
	 *
	 * @param unknown_type $message
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smile_on
	 * @param unknown_type $bbcode_uid
	 * @return unknown
	 *
	 * @access private
	 */
	function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
	{
		global $board_config, $html_entities_match, $html_entities_replace, $mx_bbcode;

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

			if (!$this->allow_all_html_tags) // Bypass this check for typical (allow all) html text
			{
				$message = '';

				foreach ($message_split as $part)
				{
					$tag = array(array_shift($matches[0]), array_shift($matches[1]), array_shift($matches[2]));
					$message .= preg_replace($html_entities_match, $html_entities_replace, $part) . $this->clean_html($tag);
				}
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
			$message = $mx_bbcode->bbencode_first_pass($message, $bbcode_uid);
		}

		return $message;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $message
	 * @return unknown
	 *
	 * @access private
	 */
	function unprepare_message($message)
	{
		global $unhtml_specialchars_match, $unhtml_specialchars_replace;

		return preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $message);
	}

	/**
	* Called from within prepare_message to clean included HTML tags if HTML is
	* turned on for that post
	* @param array $tag Matching text from the message to parse
	*
	* @access private
	*/
	function clean_html($tag)
	{
		global $board_config;

		if (empty($tag[0]))
		{
			return '';
		}

		$allowed_html_tags = preg_split('/, */', strtolower($board_config['allow_html_tags']));
		$disallowed_attributes = '/^(?:style|on)/i';

		// Check if this is an end tag
		preg_match('/<[^\w\/]*\/[\W]*(\w+)/', $tag[0], $matches);
		if (sizeof($matches))
		{
			if (in_array(strtolower($matches[1]), $allowed_html_tags))
			{
				return  '</' . $matches[1] . '>';
			}
			else
			{
				return  htmlspecialchars('</' . $matches[1] . '>');
			}
		}

		// Check if this is an allowed tag
		if (in_array(strtolower($tag[1]), $allowed_html_tags))
		{
			$attributes = '';
			if (!empty($tag[2]))
			{
				preg_match_all('/[\W]*?(\w+)[\W]*?=[\W]*?(["\'])((?:(?!\2).)*)\2/', $tag[2], $test);
				for ($i = 0; $i < sizeof($test[0]); $i++)
				{
					if (preg_match($disallowed_attributes, $test[1][$i]))
					{
						continue;
					}
					$attributes .= ' ' . $test[1][$i] . '=' . $test[2][$i] . str_replace(array('[', ']'), array('&#91;', '&#93;'), htmlspecialchars($test[3][$i])) . $test[2][$i];
				}
			}
			if (in_array(strtolower($tag[1]), $allowed_html_tags))
			{
				return '<' . $tag[1] . $attributes . '>';
			}
			else
			{
				return htmlspecialchars('<' . $tag[1] . $attributes . '>');
			}
		}
		// Finally, this is not an allowed tag so strip all the attibutes and escape it
		else
		{
			return htmlspecialchars('<' .   $tag[1] . '>');
		}
	}
}

/**
 * Class: mx_tools.
 *
 * Handy function container. Include this file whenever needed, it's not included by default. Usage examples:
 * - mx_tools::resize_image($img, 50, 50);
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class mx_tools
{
	/**
	 * Sort multiarray.
	 *
	 * Misc function to sort arrays.
	 *
	 * @access public
	 * @param array $array
	 * @param unknown_type $num
	 * @param unknown_type $order
	 * @param unknown_type $left
	 * @param unknown_type $right
	 * @return unknown
	 */
	function qsort_multiarray($array, $num = 0, $order = 'ASC', $left = 0, $right = -1)
	{
		if( $right == -1 )
		{
			$right = count($array) - 1;
		}

		$links = $left;
		$rechts = $right;
		$mitte = $array[($left + $right) / 2][$num];

		if( $rechts > $links )
		{
			do {
				if( $order == 'ASC' )
				{
					while( $array[$links][$num]  < $mitte ) $links++;
					while( $array[$rechts][$num] > $mitte ) $rechts--;
				}
				else
				{
					while( $array[$links][$num]  > $mitte ) $links++;
					while( $array[$rechts][$num] < $mitte ) $rechts--;
				}
				if( $links <= $rechts )
				{
					$tmp = $array[$links];
					$array[$links++] = $array[$rechts];
					$array[$rechts--] = $tmp;
				}
	       } while( $links <= $rechts );

	       if( $left < $rechts ) $array = qsort_multiarray($array, $num, $order, $left,  $rechts);
	       if( $links < $right ) $array = qsort_multiarray($array, $num, $order, $links, $right);
		}
		return $array;
	}

	/**
	 * Ensure nocache headers.
	 *
	 * Use this function to write out proper headers on pages where the content should not be publicly cached
	 *
	 * @access public
	 */
	function header_nocache()
	{
	   // Only try to send out headers in case
	   // those were not sent already
	   if (!headers_sent()) {
	       header("Cache-Control: private");
	       header("Pragma: no-cache");
	   }
	}

	/**
	 * Generate custom spacer.
	 *
	 * Print an image for a sized spacer
	 *
	 * @access public
	 * @param unknown_type $width
	 * @param unknown_type $height
	 * @param unknown_type $return
	 * @param unknown_type $align
	 * @param unknown_type $extras
	 * @return unknown
	 */
	function spacer($width = 1, $height = 1, $return = FALSE, $align = FALSE, $extras = FALSE)
	{
	   $function = ($return ? "sprintf" : "printf");
	   return $function('<img src="%s/images/spacer.gif" width="%d" ' .
	                     'height="%d" border="0" alt=""%s%s />',
	       $_SERVER['STATIC_ROOT'],
	       $width,
	       $height,
	       ($align  ? " align=\"$align\" " : ""),
	       ($extras ? " $extras" : "")
	   );
	}

	/**
	 * Resize image.
	 *
	 * Resize the image using the output of make_image(), (considering possible HTML/XHTML image tag endings)
	 *
	 * @access public
	 * @param unknown_type $img
	 * @param unknown_type $width
	 * @param unknown_type $height
	 * @return unknown
	 */
	function resize_image($img, $width = 1, $height = 1)
	{
	   // Drop width and height values from image if available
	   $str = preg_replace('!width=\"([0-9]+?)\"!i',  '', $img);
	   $str = preg_replace('!height=\"([0-9]+?)\"!i', '', $str);

	   // Return image with new width and height added
	   return preg_replace(
	       '!/?>$!',
	       sprintf(' height="%s" width="%s" />', $height, $width),
	       $str
	   );
	}

	/**
	 * Make image.
	 *
	 * Return an <img /> tag for a given image file available on the server
	 *
	 * @access public
	 * @param unknown_type $file
	 * @param unknown_type $alt
	 * @param unknown_type $align
	 * @param unknown_type $extras
	 * @param unknown_type $dir
	 * @param unknown_type $border
	 * @param unknown_type $addsize
	 * @return unknown
	 */
	function make_image($file, $alt = FALSE, $align = FALSE, $extras = FALSE,
	                   $dir = '/images', $border = 0, $addsize = TRUE)
	{
	   // If no / was provided at the start of $dir, add it
	   $webdir = $_SERVER['STATIC_ROOT'] . ($dir{0} == '/' ? '' : '/') . $dir;

	   // Get width and height values if possible
	   if ($addsize && ($size = @getimagesize($_SERVER['DOCUMENT_ROOT'] . "$dir/$file"))) {
	       $sizeparams = ' ' . trim($size[3]);
	   } else {
	       $sizeparams = '';
	   }

	   // Convert right or left alignment to CSS float,
	   // but leave other alignments intact (for now)
	   if (in_array($align, array("right", "left"))) {
	       $align = ' style="float: ' . $align . ';"';
	   } elseif ($align) {
	       $align = ' align="' . $align . '"';
	   } else {
	       $align = '';
	   }

	   // Return with image built up
	   return sprintf('<img src="%s/%s" alt="%s"%s%s%s />',
	       $webdir,
	       $file,
	       ($alt    ? $alt : ''),
	       $sizeparams,
	       $align,
	       ($extras ? ' ' . $extras              : '')
	   );
	   return $image;
	}

	/**
	 * Print image.
	 *
	 * Print an <img /> tag out for a given file
	 *
	 * @access public
	 * @param unknown_type $file
	 * @param unknown_type $alt
	 * @param unknown_type $align
	 * @param unknown_type $extras
	 * @param unknown_type $dir
	 * @param unknown_type $border
	 */
	function print_image($file, $alt = FALSE, $align = FALSE, $extras = FALSE,
	                     $dir = '/images', $border = 0)
	{
	   echo make_image($file, $alt, $align, $extras, $dir, $border);
	}

	/**
	 * News image.
	 *
	 * Shortcut to usual news image printing (right floating image from the news dir with an alt and an URL)
	 *
	 * @access public
	 * @param unknown_type $URL
	 * @param unknown_type $image
	 * @param unknown_type $alt
	 */
	function news_image($URL, $image, $alt)
	{
	   echo "<a href=\"$URL\">" . make_image("news/$image", $alt, "right") . "</a>";
	}

	/**
	 * Make submit.
	 *
	 * Return HTML code for a submit button image
	 *
	 * @access public
	 * @param unknown_type $file
	 * @param unknown_type $alt
	 * @param unknown_type $align
	 * @param unknown_type $extras
	 * @param unknown_type $dir
	 * @param unknown_type $border
	 * @return unknown
	 */
	function make_submit($file, $alt = FALSE, $align = FALSE, $extras = FALSE,
	                     $dir = '/images', $border = 0)
	{
	   // Get an image without size info and convert the
	   // border attribute to use CSS, as border="" is not
	   // supported on <input> elements in [X]HTML
	   $img = make_image($file, $alt, $align, $extras, $dir, 0, FALSE);
	   $img = str_replace(
	       "border=\"$border\"",
	       "style=\"border: {$border}px;\"",
	       $img
	   );

	   // Return with ready input image
	   return '<input type="image"' . substr($img, 4);
	}

	/**
	 * Make link.
	 *
	 * Return a hiperlink to something within the site
	 *
	 * @access public
	 * @param unknown_type $url
	 * @param unknown_type $linktext
	 * @param unknown_type $target
	 * @param unknown_type $extras
	 * @return unknown
	 */
	function make_link ($url, $linktext = FALSE, $target = FALSE, $extras = FALSE)
	{
	   return sprintf("<a href=\"%s\"%s%s>%s</a>",
	       $url,
	       ($target  ? ' target="' . $target . '"' : ''),
	       ($extras  ? ' ' . $extras              : ''),
	       ($linktext ? $linktext                  : $url)
	   );
	}

	/**
	 * Print link.
	 *
	 * Print a hyperlink to something, within the site
	 *
	 * @access public
	 * @param unknown_type $url
	 * @param unknown_type $linktext
	 * @param unknown_type $target
	 * @param unknown_type $extras
	 */
	function print_link($url, $linktext = FALSE, $target = FALSE, $extras = FALSE)
	{
	   echo make_link($url, $linktext, $target, $extras);
	}

	//
	/**
	 * make_popup_link().
	 *
	 * return a hyperlink to something, within the site, that pops up a new window
	 *
	 * @access public
	 * @param unknown_type $url
	 * @param unknown_type $linktext
	 * @param unknown_type $target
	 * @param unknown_type $windowprops
	 * @param unknown_type $extras
	 * @return unknown
	 */
	function make_popup_link ($url, $linktext=false, $target=false, $windowprops="", $extras=false) {
	   return sprintf("<a href=\"%s\" target=\"%s\" onclick=\"window.open('%s','%s','%s');return false;\"%s>%s</a>",
	       htmlspecialchars($url),
	       ($target ? $target : "_new"),
	       htmlspecialchars($url),
	       ($target ? $target : "_new"),
	               $windowprops,
	       ($extras ? ' '.$extras : ''),
	       ($linktext ? $linktext : $url)
	   );
	}

	/**
	 * print_popup_link().
	 *
	 * print a hyperlink to something, within the site, that pops up a new window
	 *
	 * @access public
	 * @param unknown_type $url
	 * @param unknown_type $linktext
	 * @param unknown_type $windowprops
	 * @param unknown_type $target
	 * @param unknown_type $extras
	 */
	function print_popup_link($url, $linktext=false, $windowprops="", $target=false, $extras=false) {
	   echo make_popup_link($url, $linktext, $windowprops, $target, $extras);
	}

	/**
	 * Download link.
	 *
	 * Print a link for a downloadable file (including filesize)
	 *
	 * @access public
	 * @param unknown_type $file
	 * @param unknown_type $title
	 * @param unknown_type $showsize
	 * @param unknown_type $mirror
	 */
	function download_link($file, $title, $showsize = TRUE, $mirror = '')
	{
	   // Construct the download link for this site or a mirror site
	   $download_link = "get/$file/from/a/mirror";
	   if ($mirror != '') {
	       $download_link = $mirror . $download_link;
	   } else {
	       $download_link = "/" . $download_link;
	   }

	   // Print out the download link
	   print_link($download_link, $title);

	   // Size display is required
	   if ($showsize) {

	       // We have a full path or a relative to the distributions dir
	       if ($tmp = strrchr($file, "/")) {
	           $local_file = substr($tmp, 1, strlen($tmp));
	       } else {
	           $local_file = "distributions/$file";
	       }

	       // Try to get the size of the file
	       $size = @filesize($local_file);

	       // Print out size in bytes (if size is
	       // less then 1Kb, or else in Kb)
	       if ($size) {
	           echo ' [';
	           if ($size < 1024) {
	               echo number_format($size, 0, '.', ',') . 'b';
	           } else {
	               echo number_format($size/1024, 0, '.', ',') . 'Kb';
	           }
	           echo ']';
	       }
	   }
	}

	/**
	 * Clean.
	 *
	 * @access public
	 * @param unknown_type $var
	 * @return unknown
	 */
	function clean($var) {
	  return htmlspecialchars(get_magic_quotes_gpc() ? stripslashes($var) : $var);
	}

	/**
	 * Clean note.
	 *
	 * Clean out the content of one user note for printing to HTML
	 *
	 * @access public
	 * @param unknown_type $text
	 * @return unknown
	 */
	function clean_note($text)
	{
	   // Highlight PHP source
	   $text = highlight_php(trim($text), TRUE);

	   // Turn urls into links
	   $text = preg_replace(
	       '!((mailto:|(http|ftp|nntp|news):\/\/).*?)(\s|<|\)|"|\\|\'|$)!',
	       '<a href="\1" target="_blank">\1</a>\4',
	       $text
	   );

	   return $text;
	}


}
/**
 * Class: mx_form.
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class mx_form
{
	/**
	 * Items.
	 *
	 * Array containing the data for the form.
	 *
	 * @access private
	 * @var unknown_type
	 */
	var $items;

	/**
	 * Arrayname.
	 *
	 * Name of the form array.
	 *
	 * @access private
	 * @var unknown_type
	 */
	var $arrayname;

	/**
	 * Constructor.
	 *
	 * @access private
	 * @param unknown_type $items
	 * @return form
	 */
	function form( $items = array() )
	{
		if ( !empty( $items ) )
		{
			$this->items = $items;
			foreach ( $items as $item )
			{
				if ( $item[0] == "name" )
				{
					$this->arrayname = $item[1]; // getting the table name
					$name = true;
					break;
				}
			}
			if ( !isset( $name ) ) die( "The form hasn't got name parameter" );
		}
	}

	/**
	 * drawForm.
	 *
	 * Drawing the input form
	 * @access public
	 */
	function drawForm()
	{
		global $template, $lang;

		foreach ( $this->items as $item )
		{
			$item_label = '';
			$item_field = '';

			switch ( $item[0] )
			{
				case "text": // text form
					$item_label = $item[1];
					$item_field = '<input type="text" name="' . $this->arrayname . '[' . $item[2] . ']" size="' . $item[3] . '" value="' . $item[4] . '" class="post">';
				break;
				case "textarea": // textarea
					$item_label = $item[1];
					$item_field = '<textarea name="' . $this->arrayname . '[' . $item[2] . ']" class="post" wrap="on" cols="' . $item[3] . '" rows="' . $item[4] . '">' . $item[5] . '</textarea>';
				break;
				case "password": // password
					$item_label = $item[1];
					$item_field = '<input type="password" name="' . $this->arrayname . '[' . $item[2] . ']" size="' . $item[3] . '" value="' . $item[4] . '" class="post">';
				break;
				case "checkbox": // checkbox button
					$item_label = $item[1];
					if ( isset( $item[3] ) )
						$item_field = '<input type="checkbox" name="' . $this->arrayname . '[' . $item[2] . ']" value="1" checked>';
					else
						$item_field = '<input type="checkbox" name="' . $this->arrayname . '[' . $item[2] . ']" value="1"';
				break;
				case "select":
					$item_label = $item[1];
					$item_field = $item[2];
				break;
				case "file": // file upload field
					$item_label = $item[1];
					$item_field = '<input type="file" name="' . $item[2] . '" size="' . $item[3] . '" class="post">';
					$item_field .= '<input type="hidden" name="MAX_FILE_SIZE" value="' . $config->MaxUploadSize . '">';
					$item_field .= '<input type="hidden" name="' . $this->arrayname . '[fileupload]" value="' . $item[2] . '">';
					break;
				case "hidden": // hidden fields
					$item_label = '';
					$item_field = '<input type="hidden" name="' . $this->arrayname . '[' . $item[1] . ']" value="' . $item[2] . '">';
				break;
				case "submit": // defining the label for submit button
					$submit = $item[1];
					$submitname = $item[2];
					break;
				case "delete": // delete button
					$item_label = $item[1];
					$item_field = $item[2];
				break;
			}

			if ( ! empty( $item_field ) )
			{
				$template->assign_block_vars( "rows", array( 'LABEL' => $item_label,
						'FIELD' => $item_field,
				));
			}
		}
		$template->pparse( "body" );
	}

	/**
	 * Preinsert.
	 *
	 * If there is a file upload, it has got some extra parameter (e.g. file_type).
	 * These parameter are put here to the main array
	 *
	 * @access public
	 * @param unknown_type $pairs
	 * @param unknown_type $tabla
	 * @return unknown
	 */
	function preinsert( $pairs = array(), $tabla = "" )
	{
		global $config;

		foreach ( $pairs as $key => $value )
		{
			if ( $key == "fileupload" ) // special variable containing the prefix of the name of the uploaded file
			{
				$name = $value . "_name";
				$size = $value . "_size";
				$type = $value . "_type";
				$path = $value;
				global $$name, $$size, $$type, $$path;
				if ( $$size > $config->MaxUploadSize ) // checking the size of the uploaded file, you must set $config->MaxUploadSize
				{
					printf( "The uploaded file is too big. The maximal size is %d byte. <br>Please repeat the upload!", $config->MaxUploadSize );
					$this->drawform();
				}
				else
				{
					// let's put the values of the uploaded image to the main array
					$pairs[file_name] = $$name;
					$pairs[file_size] = $$size;
					$pairs[file_type] = $$type;
					$pairs[file_path] = $$path;
					if ( !empty( $tabla ) ) $this->insert( $pairs, $tabla ); // if you get table name, insert do everything to you
					else return( $pairs ); // if there's no table, we return with the finished array
					break;
				}
			}
		}
	}

	/**
	 * Insert.
	 *
	 * Method for inserting record to the database
	 *
	 * @access public
	 * @param unknown_type $pairs
	 * @param unknown_type $table
	 */
	function insert( $pairs, $table )
	{
		global $db;

		$sql = "INSERT INTO $table (";
		$first = true;
		foreach ( $pairs as $key => $value )
		{
			if ( $key != "id" || $key != "title" || $key != "submit" ) // everything except record ID,title,submit
			{
				if ( $first )
				{
					$value = "\"" . $value;
					$first = false;
				}
				else
				{
					$key = "," . $key;
					$value = ",\"" . $value;
				}
				$fields .= $key;
				$values .= $value . "\"";
			}
		}
		$sql .= $fields . ") VALUES(" . $values . ")";

		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't insert into $table ", "", __LINE__, __FILE__, $sql );
		}
	}

	/**
	 * Update.
	 *
	 * Method for updating records in the database
	 *
	 * @access public
	 * @param unknown_type $pairs
	 * @param unknown_type $table
	 * @param unknown_type $key
	 */
	function update( $pairs, $table, $key )
	{
		global $db;

		$sql = "UPDATE $table SET ";
		$first = true;
		foreach ( $pairs as $key => $value )
		{
			if ( $key != "id" || $key != "title" || $key != "submit" ) // everything except record ID,title,submit
			{
				if ( $first )
				{
					$sql .= "$key=\"$value\"";
					$first = false;
				}
				else
				{
					$sql .= ",$key=\"$value\"";
				}
			}
		}
		$sql .= " WHERE $key = $pairs[$key]";

		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't insert into $table ", "", __LINE__, __FILE__, $sql );
		}
	}

	/**
	 * Delete.
	 *
	 * Method for deleting record from a table
	 *
	 * @access public
	 * @param unknown_type $id
	 * @param unknown_type $table
	 * @param unknown_type $key
	 */
	function delete( $id, $table, $key )
	{
		global $db;

		$sql = "DELETE FROM $table WHERE $key =$id";
		if ( !$result = $db->sql_query( $sql ) )
		{
			mx_message_die( GENERAL_ERROR, "Couldn't delete $table information", "", __LINE__, __FILE__, $sql );
		}
	}
}

/**
 * Class: mx_text_formatting.
 *
 * Description
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 *
 */
class mx_text_formatting
{
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mytext
	 * @param unknown_type $do_url
	 * @param unknown_type $do_images
	 * @param unknown_type $do_wordwrap
	 * @return unknown
	 */
	function decode( $mytext = '', $do_url = true, $do_images = '300', $do_wordwrap = true )
	{
		global $board_config;

		if ( $do_url )
		{
			$mytext = $this->_magic_url( $mytext );
		}

		if ( $do_images > 0 )
		{
			$mytext = $this->_magic_img( $mytext, $do_images );
		}

		if ( $do_wordwrap )
		{
			$mytext = $this->_word_wrap_pass( $mytext );
		}

		return $mytext;
	}
	
	/**
	 * Enter description here...
	 *
	 * Replace magic urls of form http://xxx.xxx., www.xxx. and xxx@xxx.xxx.
	 * Cuts down displayed size of link if over 50 chars, turns absolute links
	 * into relative versions when the server/script path matches the link
	 *
	 * @access private
	 * @param unknown_type $url
	 * @return unknown
	 */
	function _magic_url($url)
	{
		global $board_config;
		// $url = stripslashes($url);
		if ($url)
		{
			$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
			$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim( $board_config['server_port'] ) . '/' : '/';

			$match = array();
			$replace = array();
			
			/**
			 * Sick and tired of these variables getting lost...
			 */
			$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
			$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');

			$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
			$unhtml_specialchars_replace = array('>', '<', '"', '&');
			
			// relative urls for this board
			$match[] = '#(^|[\n ])' . $server_protocol . trim( $board_config['server_name'] ) . $server_port . preg_replace( '/^\/?(.*?)(\/)?$/', '$1', trim( $board_config['script_path'] ) ) . '/([^ \t\n\r <"\']+)#i';
			$replace[] = '<a href="$1" target="_blank">$1</a>';
			// matches a xxxx://aaaaa.bbb.cccc. ...
			$match[] = '#(^|[\n ])([\w]+?://.*?[^ \t\n\r<"]*)#i';
			$replace[] = "'\$1<a href=\"\$2\" target=\"_blank\">' . ((strlen('\$2') > 25) ? substr(str_replace('http://','','\$2'), 0, 17) . '...' : '\$2') . '</a>'";
			// $replace[] = "'\$1<a href=\"\$2\" target=\"_blank\">' . ((strlen('\$2') > 25) ? substr(str_replace('http://','','\$2'), 0, 12) . ' ... ' . substr('\$2', -3) : '\$2') . '</a>'";
			// matches a "www.xxxx.yyyy[/zzzz]" kinda lazy URL thing
			$match[] = '#(^|[\n ])(www\.[\w\-]+\.[\w\-.\~]+(?:/[^ \t\n\r<"]*)?)#i';
			$replace[] = "'\$1<a href=\"http://\$2\" target=\"_blank\">' . ((strlen('\$2') > 25) ? substr(str_replace(' ', '%20', str_replace('http://','', '\$2')), 0, 17) . '...' : '\$2') . '</a>'";
			// $replace[] = "'\$1<a href=\"http://\$2\" target=\"_blank\">' . ((strlen('\$2') > 25) ? substr(str_replace(' ', '%20', str_replace('http://','', '\$2')), 0, 12) . ' ... ' . substr('\$2', -3) : '\$2') . '</a>'";
			// matches an email@domain type address at the start of a line, or after a space.
			$match[] = '#(^|[\n ])([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)#i';
			$replace[] = "'\$1<a href=\"mailto:\$2\">' . ((strlen('\$2') > 25) ? substr('\$2', 0, 15) . ' ... ' . substr('\$2', -5) : '\$2') . '</a>'";

			$url = preg_replace($match, $replace, $url);
			// Also fix already tagged links
			//$url = preg_replace( "/<a href=(.*?)>(.*?)<\/a>/i", "(strlen(\"\\2\") > 25 && !stristr(\"\\2\", \"<\") ) ? '<a href='.stripslashes(\"\\1\").'>'.substr(str_replace(\"http://\",\"\",\"\\2\"), 0, 17) . '...</a>' : '<a href='.stripslashes(\"\\1\").'>'.\"\\2\".'</a>'", $url );
			// $url = preg_replace("/<a href=(.*?)>(.*?)<\/a>/ie", "(strlen(\"\\2\") > 25 && !eregi(\"<\", \"\\2\") ) ? '<a href='.stripslashes(\"\\1\").'>'.substr(str_replace(\"http://\",\"\",\"\\2\"), 0, 12) . ' ... ' . substr(\"\\2\", -3).'</a>' : '<a href='.stripslashes(\"\\1\").'>'.\"\\2\".'</a>'", $url);
			return $url;
		}
		return $url;
	}

	/**
	 * Enter description here...
	 *
	 * Validates the img for block_size and resizes when needed
	 * run within a div tag to ensure the table layout is not broken
	 *
	 * @access private
	 * @param unknown_type $img
	 * @param unknown_type $do_images
	 * @return unknown
	 */
	function _magic_img( $img, $do_images = '300' )
	{
		global $board_config, $block_size;
		// $img = stripslashes($img);
		$image_size = $do_images;
		if ( $img )
		{
			// Also fix already tagged links
			// $img = preg_replace("/<img src=(.*?)(|border(.*?)|alt(.*?))>/ie", "'<br /><br /><center><img src='.stripslashes(\"\\1\").' width=\"'.makeImgWidth(trim(stripslashes(\"\\1\"))).'\" ></center><br />'", $img);
			$img = preg_replace( "/<img src=(.*?)>/i", "(substr_count(\"\\1\", \"smiles\") > 0 ) ? '<img src='.stripslashes(\"\\1\").'>' :

			'<div style=\" overflow: hidden; margin: 0px; padding: 0px; float: left; \">
			<img class=\"noenlarge\" src='.stripslashes(\"\\1\").' border=\"0\"  OnLoad=\"if(this.width > $image_size) { this.width = $image_size }\" onclick = \"full_img( this.src )\" alt=\" Click to enlarge \">
			</div>'", $img );
			return $img;
		}
		return $img;
	}

	/**
	 * Enter description here...
	 *
	 * Force Word Wrapping (by TerraFrost)
	 *
	 * @access private
	 * @param unknown_type $message
	 * @return unknown
	 */
	function _word_wrap_pass( $message )
	{
		$tempText = "";
		$finalText = "";
		$curCount = $tempCount = 0;
		$longestAmp = 9;
		$inTag = false;
		$ampText = "";

		for ( $num = 0;$num < strlen( $message );$num++ )
		{
			$curChar = $message{$num};

			if ( $curChar == "<" )
			{
				for ( $snum = 0;$snum < strlen( $ampText );$snum++ )
				$this->_addWrap( $ampText{$snum}, $ampText{$snum+1}, $finalText, $tempText, $curCount, $tempCount );
				$ampText = "";
				$tempText .= "<";
				$inTag = true;
			}
			elseif ( $inTag && $curChar == ">" )
			{
				$tempText .= ">";
				$inTag = false;
			}
			elseif ( $inTag )
			{
				$tempText .= $curChar;
			}
			elseif ( $curChar == "&" )
			{
				for ( $snum = 0;$snum < strlen( $ampText );$snum++ )
				$this->_addWrap( $ampText{$snum}, $ampText{$snum+1}, $finalText, $tempText, $curCount, $tempCount );
				$ampText = "&";
			}
			elseif ( strlen( $ampText ) < $longestAmp && $curChar == ";" &&
					( strlen( html_entity_decode( "$ampText;" ) ) == 1 || preg_match( '/^&#[0-9][0-9]*$/', $ampText ) ) )
			{
				$this->_addWrap( "$ampText;", $message{$num+1}, $finalText, $tempText, $curCount, $tempCount );
				$ampText = "";
			}
			elseif ( strlen( $ampText ) >= $longestAmp || $curChar == ";" )
			{
				for ( $snum = 0;$snum < strlen( $ampText );$snum++ )
				$this->_addWrap( $ampText{$snum}, $ampText{$snum+1}, $finalText, $tempText, $curCount, $tempCount );
				$this->_addWrap( $curChar, $message{$num+1}, $finalText, $tempText, $curCount, $tempCount );
				$ampText = "";
			}
			elseif ( strlen( $ampText ) != 0 && strlen( $ampText ) < $longestAmp )
			{
				$ampText .= $curChar;
			}
			else
			{
				$this->_addWrap( $curChar, $message{$num+1}, $finalText, $tempText, $curCount, $tempCount );
			}
		}

		return $finalText . $tempText;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $curChar
	 * @param unknown_type $nextChar
	 * @param unknown_type $finalText
	 * @param unknown_type $tempText
	 * @param unknown_type $curCount
	 * @param unknown_type $tempCount
	 */
	function _addWrap( $curChar, $nextChar, &$finalText, &$tempText, &$curCount, &$tempCount )
	{
		$softHyph = "&shy;";
		// $softHyph = "&emsp;";
		$maxChars = 10;
		$wrapProhibitedChars = "([{!;,:?}])";

		if ( $curChar == " " || $curChar == "\n" )
		{
			$finalText .= $tempText . $curChar;
			$tempText = "";
			$curCount = 0;
			$curChar = "";
		}elseif ( $curCount >= $maxChars )
		{
			$finalText .= $tempText . $softHyph;
			$tempText = "";
			$curCount = 1;
		}
		else
		{
			$tempText .= $curChar;
			$curCount++;
		}
		// the following code takes care of (unicode) characters prohibiting non-mandatory breaks directly before them.
		// $curChar isn't a " " or "\n"
		if ( $tempText != "" && $curChar != "" )
			$tempCount++;
		// $curChar is " " or "\n", but $nextChar prohibits wrapping.
		elseif ( ( $curCount == 1 && strstr( $wrapProhibitedChars, $curChar ) !== false ) ||
				( $curCount == 0 && $nextChar != "" && $nextChar != " " && $nextChar != "\n" && strstr( $wrapProhibitedChars, $nextChar ) !== false ) )
			$tempCount++;
		// $curChar and $nextChar aren't both either " " or "\n"
		elseif ( !( $curCount == 0 && ( $nextChar == " " || $nextChar == "\n" ) ) )
			$tempCount = 0;

		if ( $tempCount >= $maxChars && $tempText == "" )
		{
			$finalText .= "&nbsp;";
			$tempCount = 1;
			$curCount = 2;
		}

		if ( $tempText == "" && $curCount > 0 )
			$finalText .= $curChar;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $comments_text
	 * @param unknown_type $allow_images
	 * @param unknown_type $no_image_message
	 * @param unknown_type $allow_links
	 * @param unknown_type $no_link_message
	 * @return unknown
	 */
	function remove_images_links( $comments_text, $allow_images = false, $no_image_message = '[No image please]', $allow_links = false, $no_link_message = '[No links please]')
	{
		if ( $comments_text != '' )
		{
			if ( !$allow_images )
			{
				if ( preg_match( '/(<img src=)(.+?)(\>)/i', $comments_text ) )
				{
					$comments_text = preg_replace( '/(<img src=)(.+?)(\>)/i', $no_image_message, $comments_text );
				}

				if ( preg_match( '/(\[img\])([^\[]*)(\[\/img\])/i', $comments_text ) )
				{
					$comments_text = preg_replace( '/(\[img\])([^\[]*)(\[\/img\])/i', $no_image_message, $comments_text );
				}
			}

			if ( !$allow_links )
			{
				if ( preg_match( '/(\[url=(.*?)\])([^\[]*)(\[\/url\])/i', $comments_text ) )
				{
					$comments_text = preg_replace( '/(\[url=(.*?)\])([^\[]*)(\[\/url\])/i', $no_link_message, $comments_text );
				}

				if ( preg_match( '/(\[url\])([^\[]*)(\[\/url\])/i', $comments_text ) )
				{
					$comments_text = preg_replace( '/(\[url\])([^\[]*)(\[\/url\])/i', $no_link_message, $comments_text );
				}

				if ( preg_match( "#([\n ])http://www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,\t \n\r]*)?)#i", $comments_text ) )
				{
					$comments_text = preg_replace( "#([\n ])http://www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,\t \n\r]*)?)#i", $no_link_message, $comments_text );
				}

				if ( preg_match( "#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,\t \n\r]*)?)#i", $comments_text ) )
				{
					$comments_text = preg_replace( "#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,\t \n\r]*)?)#i", $no_link_message, $comments_text );
				}
			}
		}
		return $comments_text;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mytext
	 * @param unknown_type $length
	 * @param unknown_type $add_dots
	 * @return unknown
	 */
	function truncate_text( $mytext, $length = 200, $add_dots = true )
	{
		$do_trunc = false;
		if ( strlen( $mytext ) > $length )
		{
			$do_trunc = true;
			$mytext = substr( $mytext, 0, $length );
			$mytext = str_replace('<br />', '<br/>', $mytext);
			$mytext = substr( $mytext, 0, strrpos( $mytext, ' ' ) );
			$mytext = str_replace('<br/>', '<br />', $mytext);

			if ( $add_dots )
			{
				$mytext .= '...';
			}
		}
		//$return_data = array($mytext, $do_trunc);
		return $mytext;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mytext
	 * @param unknown_type $length
	 * @param unknown_type $add_dots
	 * @return unknown
	 */
	function split_text( $mytext, $length = 200, $add_dots = true, $key = '<!-- split -->' )
	{
		$do_trunc = false;
		$split_pos = strrpos($mytext, $key) > $length ? strrpos($mytext, $key) : $length;
		if ( strlen( $mytext ) > $split_pos )
		{
			$do_trunc = true;

		    $shortstring = substr($mytext, 0, $split_pos);
		    $lastdot = strrpos($shortstring, ".");
		    $lastspace = strrpos($shortstring, " ");
		    $shortstring = substr($shortstring, 0, ($lastdot > $lastspace? $lastdot : $lastspace));
			$shortstring = str_replace('<br/>', '<br />', $shortstring);

			if ( $add_dots )
			{
				$shortstring .= '...';
			}
			return $shortstring;
		}
		return $mytext;
	}
	
	/**
	* Truncates string while retaining special characters if going over the max length
	* The default max length is 60 at the moment
	* The maximum storage length is there to fit the string within the given length. The string may be further truncated due to html entities.
	* For example: string given is 'a "quote"' (length: 9), would be a stored as 'a &quot;quote&quot;' (length: 19)
	*
	* @param string $string The text to truncate to the given length. String is specialchared.
	* @param int $max_length Maximum length of string (multibyte character count as 1 char / Html entity count as 1 char)
	* @param int $max_store_length Maximum character length of string (multibyte character count as 1 char / Html entity count as entity chars).
	* @param bool $allow_reply Allow Re: in front of string
	* @param string $append String to be appended
	*/
	function truncate_string($string, $max_length = 60, $max_store_length = 255, $allow_reply = true, $append = '')
	{
		$chars = array();

		$strip_reply = false;
		$stripped = false;
		if ($allow_reply && strpos($string, 'Re: ') === 0)
		{
			$strip_reply = true;
			$string = substr($string, 4);
		}

		$_chars = utf8_str_split(htmlspecialchars_decode($string));
		$chars = array_map('utf8_htmlspecialchars', $_chars);

		// Now check the length ;)
		if (sizeof($chars) > $max_length)
		{
			// Cut off the last elements from the array
			$string = implode('', array_slice($chars, 0, $max_length - utf8_strlen($append)));
			$stripped = true;
		}

		// Due to specialchars, we may not be able to store the string...
		if (utf8_strlen($string) > $max_store_length)
		{
			// let's split again, we do not want half-baked strings where entities are split
			$_chars = utf8_str_split(htmlspecialchars_decode($string));
			$chars = array_map('utf8_htmlspecialchars', $_chars);

			do
			{
				array_pop($chars);
				$string = implode('', $chars);
			}
			while (!empty($chars) && utf8_strlen($string) > $max_store_length);
		}

		if ($strip_reply)
		{
			$string = 'Re: ' . $string;
		}

		if ($append != '' && $stripped)
		{
			$string = $string . $append;
		}

		return $string;
	} 		
}

define('MX_MAIL_MODE'						, 1);
define('MX_PM_MODE'							, 2);
define('MX_POST_MODE'						, 2);

define('MX_NEW_NOTIFICATION'				, 10);
define('MX_EDITED_NOTIFICATION'				, 11);
define('MX_APPROVED_NOTIFICATION'			, 12);
define('MX_UNAPPROVED_NOTIFICATION'			, 13);
define('MX_DELETED_NOTIFICATION'			, 14);

/*
* Includes
/*
if(!function_exists('prepare_message'))
{
	//include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions_post.' . $phpEx);
	mx_cache::load_file('functions_post', 'phpbb2');
}

if( !function_exists('add_search_words') )
{
	//include_once($mx_root_path . 'includes/shared/phpbb2/includes/functions_search.' . $phpEx);
	mx_cache::load_file('functions_search', 'phpbb2');
}
*/

/**
 * Class: mx_notification.
 *
 * This class will handle most PM/MAIL tasks.
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, $id: get all file/article data for this id
 * $mx_notification->init($mode, $id); // MODE: MX_PM_MODE/MX_MAIL_MODE
 *
 * // MODE: MX_PM_MODE/MX_MAIL_MODE, ACTION: MX_NEW_NOTIFICATION/MX_EDITED_NOTIFICATION/MX_APPROVED_NOTIFICATION/MX_UNAPPROVED_NOTIFICATION
 * $mx_notification->notify( $mode = MX_PM_MODE, $action = MX_NEW_NOTIFICATION, $to_id, $from_id, $subject, $message, $html_on, $bbcode_on, $smilies_on )
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class mx_notification
{
	//
	// PM/EMAIL Notification
	//
	var $subject = '';
	var $message = '';

	var $to_id = ''; // to one user
	var $to_ids = ''; // to many users
	var $from_id = '';
	var $html_on = 0;
	var $bbcode_on = 1;
	var $smilies_on = 1;
	var $wysiwyg_on = 0;
	
	var $bbcode_uid = '';
	var $bbcode_bitfield = '';	

	var $first_commnent = ''; // only used for phpBB comments
	var $next_commnent = '';

	//
	// Autogenerated comments [Optional]
	//
	var $data = array(); // all item data in one array (only needed when using automessages) [Optional]
	var $langs = array(); // generic lang keys (only needed when using automessages) [Optional]
	var $temp_url = ''; // (only needed when using automessages) [Optional]

	var $auto_message = ''; // for auto generated messages
	var $auto_message_update = ''; // for auto generated messages

	/**
	 * this will be replaced by the loaded module.
	 *
	 * If you are using automessages, this init must populate $lang, $data and $url_rewrite.
	 * If not, you need no init and may use the notify method as is.
	 *
	 * @param unknown_type $module_id
	 * @return unknown
	 */
	function init( $item_id = false )
	{
		return false;
	}

	/**
	 * Notification - email/PM.
	 *
	 * Note: This method may be used by itself (if subject and message is passed)
	 * to_id: to single user ($to_id > 0), to ALL admins ($to_id == 0) or to all members in group with group_id = -$to_id ($to_id < 0)
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $action
	 * @param unknown_type $to_id
	 * @param unknown_type $from_id
	 * @param unknown_type $subject
	 * @param unknown_type $message
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smilies_on
	 */
	function notify($mode = MX_PM_MODE, $action = MX_NEW_NOTIFICATION, $to_id = 0, $from_id = '', $subject = '', $message = '', $html_on = true, $bbcode_on = true, $smilies_on = true, $wysiwyg_on = false)
	{
		global $lang, $board_config, $pafiledb_config, $db, $phpbb_root_path, $mx_root_path, $phpEx, $userdata;

		//
		// Precheck
		//
		if (intval($to_id) > 0)
		{
			$this->to_ids = array('single' => intval($to_id)); // Notify specific user
		}
		else if(intval($to_id) == 0)
		{
		 	$this->to_ids = $this->_get_admins(); // Notify all admins (DEFAULT)
		}
		else if(intval($to_id) < 0)
		{
			$group_id = intval( -$to_id);
			$this->to_ids = $this->_get_users_in_group( $group_id ); // Notify all in group
		}
		else
		{
			mx_message_die(GENERAL_ERROR, 'Bad notify pars - no to_id');
		}

	    $this->from_id = empty($from_id) ? $userdata['user_id'] : $from_id;

		//
		// Toggles
		//
		$this->html_on = ($html_on) ? $html_on : $this->html_on;
		$this->bbcode_on = ($bbcode_on) ? $bbcode_on : $this->bbcode_on;
		$this->smilies_on = ($smilies_on) ? $smilies_on : $this->smilies_on;
		$this->allow_comment_wysiwyg = $pafiledb_config['allow_comment_wysiwyg']; 
		$this->wysiwyg_on = ($wysiwyg_on) ? $wysiwyg_on : $this->allow_comment_wysiwyg;
		$this->subject = $subject;
		$this->message = $message;

		//
		// Compose Subject
		//
		if (empty($this->subject) || empty($this->message))
		{
			if ( count($this->data) > 0 && count($this->langs) > 0 )
			{
				$this->_compose_auto_note($action);
			}
			else
			{
				mx_message_die(GENERAL_ERROR, 'Error: no subject or no message');
			}
		}

		//
		// Now send PM/MAIL
		//
		foreach ( $this->to_ids as $key => $id )
		{
			$this->to_id = $id;

		   	//
		   	// Why send PM/MAIL to yourself???
		   	//
		   	if ( $this->to_id == $this->from_id )
		   	{
		   	 	continue;
		   	}

			switch ( $mode )
			{
				case MX_MAIL_MODE:
					$this->_mailer();
				break;

				case MX_PM_MODE:
					$this->_insert_pm();
				break;

				default:
					mx_message_die(GENERAL_ERROR, 'Bad notify type');
			}
		}
	}

	/**
	 * Notification - PM
	 *
	 * based on wgErics good old insert_pm function
	 *
	 */
	function _insert_pm()
	{
		global $db, $lang, $user_ip, $mx_user, $board_config, $userdata, $phpbb_root_path, $phpEx, $mx_bbcode;

		//
		// get varibles ready
		//
		$msg_time = time();
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':
				$attach_sig = $userdata['user_attachsig'];
			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
				$attach_sig = ($board_config['allow_sig'] && $mx_user->data['user_sig']) ? TRUE : 0;
			break;
		}		
		
		$is_admin = ($userdata['user_level'] == ADMIN && $userdata['session_logged_in']) ? TRUE : 0;
		
		//
		//get 'to user's info
		/*
		$sql = "SELECT user_id, user_email
	      FROM " . USERS_TABLE . "
	      WHERE user_id = '" . $this->to_id . "'
	         AND user_id <> " . ANONYMOUS;

		if ( !($result = $db->sql_query($sql)) )
		{
			$error = TRUE;
			$error_msg = $lang['No_such_user'];
		}

		$to_userdata = $db->sql_fetchrow($result);
		*/
		$to_userdata = mx_get_userdata($this->to_id);

		$privmsg_subject = trim(strip_tags($this->subject));

		if ( empty($privmsg_subject) )
		{
			$error = TRUE;
			$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_subject'];
		}

		if ( !empty($this->message) )
		{
			if ( !$error )
			{
				if ( $this->bbcode_on )
				{
					$bbcode_uid = $mx_bbcode->make_bbcode_uid();
				}

				$privmsg_message = $this->prepare_message(addslashes($this->message), $this->html_on, $this->bbcode_on, $this->smilies_on, $bbcode_uid);
				$privmsg_message = str_replace('\\\n', '\n', $privmsg_message);
			}
		}
		else
		{
			$error = TRUE;
			$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_message'];
		}

		//
		// See if recipient is at their inbox limit
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':
			
				$sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
			      FROM " . PRIVMSGS_TABLE . "
			      WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
			            OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
			            OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
			         AND privmsgs_to_userid = " . $to_userdata['user_id'];
 			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			
			$sql = 'SELECT t.msg_id, COUNT(t.msg_id) as inbox_items, SUM(t.pm_unread) as oldest_post_time 
				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
					WHERE t.msg_id = p.msg_id
					AND t.user_id = ' . $to_userdata['user_id'] . '
					AND t.folder_id <> ' . PRIVMSGS_NO_BOX . '				
					ORDER BY p.message_time ASC';
				break;
		}
	
		//$result = $db->sql_query($sql); //To Do
		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die( GENERAL_ERROR, $lang['No_such_user'], '', __LINE__, __FILE__, $sql );			
		}	
		$db->sql_freeresult($result);
		
		$sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

		if ( $inbox_info = $db->sql_fetchrow($result) )
		{
			if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
			{
				$sql = "SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . "
					WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
	                  OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
	                  OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  )
					AND privmsgs_date = " . $inbox_info['oldest_post_time'] . "
					AND privmsgs_to_userid = " . $to_userdata['user_id'];

				if ( !$result = $db->sql_query($sql) )
				{
					//mx_message_die(GENERAL_ERROR, 'Could not find oldest privmsgs (inbox)', '', __LINE__, __FILE__, $sql);
				}

				$old_privmsgs_id = $db->sql_fetchrow($result);
				$old_privmsgs_id = $old_privmsgs_id['privmsgs_id'];

				$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . "
					WHERE privmsgs_id = $old_privmsgs_id";

				if ( !$db->sql_query($sql) )
				{
					//mx_message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs (inbox)'.$sql, '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TEXT_TABLE . "
					WHERE privmsgs_text_id = $old_privmsgs_id";

				if ( !$db->sql_query($sql) )
				{
					//mx_message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs text (inbox)', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':			
				$sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
					VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $privmsg_subject) . "', " . $this->from_id . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip', $this->html_on, $this->bbcode_on, $this->smilies_on, $attach_sig)";
				if ( !($result = $db->sql_query($sql_info)) )
				{
					mx_message_die(GENERAL_ERROR, "Could not insert/update private message sent info.", "", __LINE__, __FILE__, $sql_info);
				}
				$privmsg_sent_id = $db->sql_nextid();
				$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text) VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $privmsg_message) . "')";
				if ( !$db->sql_query($sql) )
				{
					mx_message_die(GENERAL_ERROR, "Could not insert/update private message sent text.", "", __LINE__, __FILE__, $sql);
				}
				
			   // Add to the users new pm counter
			   $sql = "UPDATE " . USERS_TABLE . "
			      SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . "
			      WHERE user_id = " . $to_userdata['user_id'];

			   if ( !$status = $db->sql_query($sql) )
			   {
			      mx_message_die(GENERAL_ERROR, 'Could not update private message new/read status for user', '', __LINE__, __FILE__, $sql);
			   }
			   
			   if ( $to_userdata['user_notify_pm'] && !empty($to_userdata['user_email']) && $to_userdata['user_active'] )
			   {
			      $script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
			      $script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
			      $server_name = trim($board_config['server_name']);
			      $server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
			      $server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
				  
			      // Include and initiate emailer
			      include_once($mx_root_path . 'includes/mx_functions_emailer.'.$phpEx);
			      $emailer = new mx_emailer($board_config['smtp_delivery']);
				  
			      $emailer->from($board_config['board_email']);
			      $emailer->replyto($board_config['board_email']);
				  
			      $emailer->use_template('privmsg_notify', $to_userdata['user_lang']);
			      $emailer->email_address($to_userdata['user_email']);
			      $emailer->set_subject($lang['Notification_subject']);
				  
			      $emailer->assign_vars(array(
			         'USERNAME' => $to_username,
			         'SITENAME' => $board_config['sitename'],
			         'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
					 
			         'U_INBOX' => $server_protocol . $server_name . $server_port . $script_name . '?folder=inbox')
			      );
				  
			      $emailer->send();
			      $emailer->reset();
			   }
			   //return;
			   $msg = $lang['Message_sent'] . '<br /><br />' . sprintf($lang['Click_return_inbox'], '<a href="' . mx_append_sid("privmsg.$phpEx?folder=inbox") . '">', '</a> ') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . mx_append_sid("index.$phpEx") . '">', '</a>');
			   mx_message_die(GENERAL_MESSAGE, $msg);			   
			   
			break;
			
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':
				
				if (!class_exists('parse_message'))
				{
					require($mx_root_path . 'includes/shared/phpbb3/includes/message_parser.' . $phpEx);
				}		
				
				$message_parser = new parse_message($privmsg_message);
				
				$message_parser->message = $privmsg_message;
				$message_parser->parse(true, true, true, false, false, true, true);
				
				$pm_data = array(
					'from_user_id'			=> $this->from_id,
					'from_user_ip'			=> $user->ip,
					'from_username'			=> $to_userdata['user_id'],
					'enable_sig'			=> $attach_sig,
					'enable_bbcode'			=> $this->bbcode_on,
					'enable_smilies'		=> $this->smilies_on,
					'enable_urls'			=> $this->html_on,
					'icon_id'				=> 0,
					'bbcode_bitfield'		=> $message_parser->bbcode_bitfield,
					'bbcode_uid'			=> $message_parser->bbcode_uid,
					'message'				=> $message_parser->message,
					'address_list'			=> array('u' => array($to_userdata['user_id'] => 'to')),
				);

				$this->submit_pm_phpbb3('post', $privmsg_subject, $pm_data, false);
			break;
		}			
	}

	/**
	 * Notification - email
	 *
	 */
	function _mailer()
	{
	   global $db, $lang, $user_ip, $board_config, $userdata, $phpbb_root_path, $mx_root_path, $phpEx, $mx_bbcode;

	   //
	   //get varibles ready
	   //
	   $msg_time = time();
	   $attach_sig = $userdata['user_attachsig'];

	   //
	   //get to users info
	   //
	   $sql = "SELECT user_id, user_email
	      FROM " . USERS_TABLE . "
	      WHERE user_id = '".$this->to_id."'
	         AND user_id <> " . ANONYMOUS;

	   if ( !($result = $db->sql_query($sql)) )
	   {
	      $error = TRUE;
	      $error_msg = $lang['No_such_user'];
	   }

	   $to_userdata = $db->sql_fetchrow($result);

	   $mail_subject = trim(strip_tags($this->subject));

	   if ( empty($mail_subject) )
	   {
	      $error = TRUE;
	      $error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_subject'];
	   }

	   if ( !empty($this->message) )
	   {
	      if ( !$error )
	      {
	         if ( $this->bbcode_on )
	         {
	            $bbcode_uid = $mx_bbcode->make_bbcode_uid();
	         }

	         $mail_message = $this->prepare_message($this->message, $this->html_on, $this->bbcode_on, $this->smilies_on, $bbcode_uid);
	         $mail_message = str_replace('\\\n', '\n', $mail_message);

	      }
	   }
	   else
	   {
	      $error = TRUE;
	      $error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_message'];
	   }

		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
	    $script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
	    $server_name = trim($board_config['server_name']);
	    $server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
	    $server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

	    //
	    // Include and initiate mailer
	    //
		include_once($mx_root_path . 'includes/mx_functions_emailer.'.$phpEx);
	    $emailer = new mx_emailer($board_config['smtp_delivery']);

	    //
	    // Mail
	    //
	    $emailer->from( $board_config['board_email'] );
	    $emailer->replyto( $board_config['board_email'] );

	    $emailer->email_address($to_userdata['user_email'] );
	    $emailer->set_subject( $mail_subject );
		$emailer->msg = $mail_message;

	    $emailer->send();
	    $emailer->reset();
	}

	/**
	 * Compose auto note
	 *
	 * @access private
	 * @param unknown_type $action
	 */
	function _compose_auto_note($action = '')
	{
		global $lang, $phpEx, $mx_backend;

		//
		// Toggle tags language replacemets
		//		
		static $bbcode_hardchar = array();
		if (empty($bbcode_hardchar))
		{
			if ($this->wysiwyg_on)
			{			
				$bbcode_hardchar = array(
					'b_open'	=> "<span style=\"font-weight: bold\">",
					'b_close'	=> "</span>",
					'i_open'	=> "<span style=\"font-style: italic\">",
					'i_close'	=> "</span>",
					'u_open'	=> "<span style=\"text-decoration: underline\">",
					'u_close'	=> "</span>",
					'url'		=> "<a href=" . $this->temp_url . ">" . $this->langs['read_full_item'] . "</a>",						
					'break'		=> "\n"						
				);			
			}
			elseif ($this->bbcode_on)
			{
				$bbcode_hardchar = array(
					'b_open'	=> "[b]", 	// To Do: Unique ID for this message (phpBB3 Backend)
					'b_close'	=> "[/b]",
					'i_open'	=> "[i]",
					'i_close'	=> "[/i]",
					'u_open'	=> "[u]",
					'u_close'	=> "[/u]",
					'url'		=> "[url=" . $this->temp_url . "]" . $this->langs['read_full_item'] . "[/url]",
					'break'		=> "<br />"					
				);			
			}			
			elseif ($this->html_on)
			{			
				$bbcode_hardchar = array(
					'b_open'	=> "<b>",
					'b_close'	=> "</b>",
					'i_open'	=> "<i>",
					'i_close'	=> "</i>",
					'u_open'	=> "<u>",
					'u_close'	=> "</u>",
					'url'		=> "<a href=" . $this->temp_url . ">" . $this->langs['read_full_item'] . "</a>",						
					'break'		=> "\n"						
				);			
			}				
			else
			{			
				$bbcode_hardchar = array(
					'b_open'	=> "",
					'b_close'	=> "",
					'i_open'	=> "",
					'i_close'	=> "",
					'u_open'	=> "",
					'u_close'	=> "",
					'url'		=> $this->langs['read_full_item'] . ": " . "\n" . $this->temp_url,						
					'break'		=> "\n"						
				);			
			}				
		}			
		$new_line_char = $bbcode_hardchar['break'];
			
		//
		// Compose phpBB post header
		//
		$this->auto_message = '';			
		$this->auto_message .= $bbcode_hardchar['b_open'] . $this->langs['item_title'] . ": " . $bbcode_hardchar['b_close'] . $this->data['item_title'] . $new_line_char;
		$this->auto_message .= $bbcode_hardchar['b_open'] . $this->langs['author'] . ": " . $bbcode_hardchar['b_close'] . $this->data['item_author'] . $new_line_char;
		$this->auto_message .= $bbcode_hardchar['b_open'] . $this->langs['item_description'] . ": " . $bbcode_hardchar['b_close'] . $bbcode_hardchar['i_open'] . $this->data['item_desc'] . $bbcode_hardchar['i_close'] . $new_line_char . $new_line_char;
			
		if ($action != MX_DELETED_NOTIFICATION)
		{
			$this->auto_message .= $new_line_char . $new_line_char . $bbcode_hardchar['b_open'] . $bbcode_hardchar['url'] . $bbcode_hardchar['b_close'];
		}			

		//
		// Update message
		//
		$this->auto_message_update = $bbcode_hardchar['i_open'] . $this->langs['edited_item_info'] . $this->data['item_editor'] . $bbcode_hardchar['i_close'] . $new_line_char . $new_line_char;

		//
		// Auto generated subject and message
		//
		switch ($action)
		{
			case MX_NEW_NOTIFICATION:
				$this->topic_title = $this->langs['module_title'] . ' - ' . $this->data['item_title'];
				$this->subject = $this->langs['module_title'] . ' - ' . $this->langs['notify_subject_new'];
				$this->message = $this->langs['notify_new_body'] . $new_line_char . $new_line_char . $this->auto_message;
		break;

			case MX_EDITED_NOTIFICATION:
				$this->topic_title = $this->langs['module_title'] . ' - ' . $this->data['item_title'];
				$this->subject = $this->langs['module_title'] . ' - ' . $this->langs['notify_subject_edited'];
				$this->message = $this->langs['notify_edited_body'] . $new_line_char . $new_line_char . $this->auto_message_update . $this->auto_message;
			break;
				case MX_APPROVED_NOTIFICATION:
				$this->subject = $this->langs['module_title'] . ' - ' . $this->langs['notify_subject_approved'];
				$this->message = $this->langs['notify_approved_body'] . $new_line_char . $new_line_char . $this->auto_message;
			break;

			case MX_UNAPPROVED_NOTIFICATION:
				$this->subject = $this->langs['module_title'] . ' - ' . $this->langs['notify_subject_unapproved'];
				$this->message = $this->langs['notify_unapproved_body'] . $new_line_char . $new_line_char . $this->auto_message;
			break;

			case MX_DELETED_NOTIFICATION:
				$this->subject = $this->langs['module_title'] . ' - ' . $this->langs['notify_subject_deleted'];
				$this->message = $this->langs['notify_deleted_body'] . $new_line_char . $new_line_char . $this->auto_message;
			break;

			default:
				mx_message_die(GENERAL_ERROR, 'Bad notify action');
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $get_all_userdata
	 * @return unknown
	 */
	function _get_admins( $get_all_userdata = false )
	{
		global $db;

		$admin_type = ADMIN;
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'phpbb2':
			case 'smf2':
			case 'mybb':
			
			$sql = "SELECT *
		       		FROM " . USERS_TABLE . "
		      		WHERE user_level = '$admin_type'";
				break;
				
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			
			$sql = "SELECT *
		       		FROM " . USERS_TABLE . "
		      		WHERE user_type = 1";
				break;
		}
		
		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain author data", '', __LINE__, __FILE__, $sql );
		}
		
		$user_ids_array = array();
		while( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $get_all_userdata )
			{
				$user_ids_array[] = $row;
			}
			else
			{
				$user_ids_array[] = $row['user_id'];
			}
		}
		return $user_ids_array;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $group_id
	 * @param unknown_type $get_all_userdata
	 * @return unknown
	 */
	function _get_users_in_group( $group_id, $get_all_userdata = false )
	{
		global $db;

		//
		// Get user information for this group
		//
		$sql = "SELECT u.username, u.user_id, ug.group_id
			FROM " . USERS_TABLE . " u, " . USER_GROUP_TABLE . " ug
			WHERE ug.group_id = $group_id
				AND u.user_id = ug.user_id
				AND ug.user_pending = 0
			ORDER BY u.user_id";

		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, 'Error getting user list for group', '', __LINE__, __FILE__, $sql);
		}

		$user_ids_array = array();
		while( $row = $db->sql_fetchrow( $result ) )
		{
			if ( $get_all_userdata )
			{
				$user_ids_array[] = $row;
			}
			else
			{
				$user_ids_array[] = $row['user_id'];
			}
		}
		return $user_ids_array;
	}
	
	/**
	* Submit PM
	*/
	function submit_pm_phpbb3($mode, $subject, &$data, $put_in_outbox = true)
	{
		global $db, $auth, $config, $phpEx, $template, $user, $phpbb_root_path;

		// We do not handle erasing pms here
		if ($mode == 'delete')
		{
			return false;
		}

		$current_time = time();

		// Collect some basic information about which tables and which rows to update/insert
		$sql_data = array();
		$root_level = 0;

		// Recipient Information
		$recipients = $to = $bcc = array();

		if ($mode != 'edit')
		{
			// Build Recipient List
			// u|g => array($user_id => 'to'|'bcc')
			$_types = array('u', 'g');
			foreach ($_types as $ug_type)
			{
				if (isset($data['address_list'][$ug_type]) && sizeof($data['address_list'][$ug_type]))
				{
					foreach ($data['address_list'][$ug_type] as $id => $field)
					{
						$id = (int) $id;

						// Do not rely on the address list being "valid"
						if (!$id || ($ug_type == 'u' && $id == ANONYMOUS))
						{
							continue;
						}

						$field = ($field == 'to') ? 'to' : 'bcc';
						if ($ug_type == 'u')
						{
							$recipients[$id] = $field;
						}
						${$field}[] = $ug_type . '_' . $id;
					}
				}
			}

			if (isset($data['address_list']['g']) && sizeof($data['address_list']['g']))
			{
				// We need to check the PM status of group members (do they want to receive PM's?)
				// Only check if not a moderator or admin, since they are allowed to override this user setting
				$sql_allow_pm = (!$auth->acl_gets('a_', 'm_') && !$auth->acl_getf_global('m_')) ? ' AND u.user_allow_pm = 1' : '';

				$sql = 'SELECT u.user_type, ug.group_id, ug.user_id
					FROM ' . USERS_TABLE . ' u, ' . USER_GROUP_TABLE . ' ug
					WHERE ' . $db->sql_in_set('ug.group_id', array_keys($data['address_list']['g'])) . '
						AND ug.user_pending = 0
						AND u.user_id = ug.user_id
						AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' .
						$sql_allow_pm;
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$field = ($data['address_list']['g'][$row['group_id']] == 'to') ? 'to' : 'bcc';
					$recipients[$row['user_id']] = $field;
				}
				$db->sql_freeresult($result);
			}

			if (!sizeof($recipients))
			{
				trigger_error('NO_RECIPIENT');
			}
		}

		$db->sql_transaction('begin');

		$sql = '';

		switch ($mode)
		{
			case 'reply':
			case 'quote':
				$root_level = ($data['reply_from_root_level']) ? $data['reply_from_root_level'] : $data['reply_from_msg_id'];

				// Set message_replied switch for this user
				$sql = 'UPDATE ' . PRIVMSGS_TO_TABLE . '
					SET pm_replied = 1
					WHERE user_id = ' . $data['from_user_id'] . '
						AND msg_id = ' . $data['reply_from_msg_id'];

			// no break

			case 'forward':
			case 'post':
			case 'quotepost':
				$sql_data = array(
					'root_level'		=> $root_level,
					'author_id'			=> $data['from_user_id'],
					'icon_id'			=> $data['icon_id'],
					'author_ip'			=> $data['from_user_ip'],
					'message_time'		=> $current_time,
					'enable_bbcode'		=> $data['enable_bbcode'],
					'enable_smilies'	=> $data['enable_smilies'],
					'enable_magic_url'	=> $data['enable_urls'],
					'enable_sig'		=> $data['enable_sig'],
					'message_subject'	=> $subject,
					'message_text'		=> $data['message'],
					'message_attachment'=> (!empty($data['attachment_data'])) ? 1 : 0,
					'bbcode_bitfield'	=> $data['bbcode_bitfield'],
					'bbcode_uid'		=> $data['bbcode_uid'],
					'to_address'		=> implode(':', $to),
					'bcc_address'		=> implode(':', $bcc)
				);
			break;

			case 'edit':
				$sql_data = array(
					'icon_id'			=> $data['icon_id'],
					'message_edit_time'	=> $current_time,
					'enable_bbcode'		=> $data['enable_bbcode'],
					'enable_smilies'	=> $data['enable_smilies'],
					'enable_magic_url'	=> $data['enable_urls'],
					'enable_sig'		=> $data['enable_sig'],
					'message_subject'	=> $subject,
					'message_text'		=> $data['message'],
					'message_attachment'=> (!empty($data['attachment_data'])) ? 1 : 0,
					'bbcode_bitfield'	=> $data['bbcode_bitfield'],
					'bbcode_uid'		=> $data['bbcode_uid']
				);
			break;
		}

		if (sizeof($sql_data))
		{
			$query = '';

			if ($mode == 'post' || $mode == 'reply' || $mode == 'quote' || $mode == 'quotepost' || $mode == 'forward')
			{
				$db->sql_query('INSERT INTO ' . PRIVMSGS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_data));
				$data['msg_id'] = $db->sql_nextid();
			}
			else if ($mode == 'edit')
			{
				$sql = 'UPDATE ' . PRIVMSGS_TABLE . '
					SET message_edit_count = message_edit_count + 1, ' . $db->sql_build_array('UPDATE', $sql_data) . '
					WHERE msg_id = ' . $data['msg_id'];
				$db->sql_query($sql);
			}
		}

		if ($mode != 'edit')
		{
			if ($sql)
			{
				$db->sql_query($sql);
			}
			unset($sql);

			$sql_ary = array();
			foreach ($recipients as $user_id => $type)
			{
				$sql_ary[] = array(
					'msg_id'		=> (int) $data['msg_id'],
					'user_id'		=> (int) $user_id,
					'author_id'		=> (int) $data['from_user_id'],
					'folder_id'		=> PRIVMSGS_NO_BOX,
					'pm_new'		=> 1,
					'pm_unread'		=> 1,
					'pm_forwarded'	=> ($mode == 'forward') ? 1 : 0
				);
			}

			$db->sql_multi_insert(PRIVMSGS_TO_TABLE, $sql_ary);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_new_privmsg = user_new_privmsg + 1, user_unread_privmsg = user_unread_privmsg + 1, user_last_privmsg = ' . time() . '
				WHERE ' . $db->sql_in_set('user_id', array_keys($recipients));
			$db->sql_query($sql);

			// Put PM into outbox
			if ($put_in_outbox)
			{
				$db->sql_query('INSERT INTO ' . PRIVMSGS_TO_TABLE . ' ' . $db->sql_build_array('INSERT', array(
					'msg_id'		=> (int) $data['msg_id'],
					'user_id'		=> (int) $data['from_user_id'],
					'author_id'		=> (int) $data['from_user_id'],
					'folder_id'		=> PRIVMSGS_OUTBOX,
					'pm_new'		=> 0,
					'pm_unread'		=> 0,
					'pm_forwarded'	=> ($mode == 'forward') ? 1 : 0))
				);
			}
		}

		// Set user last post time
		if ($mode == 'reply' || $mode == 'quote' || $mode == 'quotepost' || $mode == 'forward' || $mode == 'post')
		{
			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_lastpost_time = $current_time
				WHERE user_id = " . $data['from_user_id'];
			$db->sql_query($sql);
		}

		// Submit Attachments
		if (!empty($data['attachment_data']) && $data['msg_id'] && in_array($mode, array('post', 'reply', 'quote', 'quotepost', 'edit', 'forward')))
		{
			$space_taken = $files_added = 0;
			$orphan_rows = array();

			foreach ($data['attachment_data'] as $pos => $attach_row)
			{
				$orphan_rows[(int) $attach_row['attach_id']] = array();
			}

			if (sizeof($orphan_rows))
			{
				$sql = 'SELECT attach_id, filesize, physical_filename
					FROM ' . ATTACHMENTS_TABLE . '
					WHERE ' . $db->sql_in_set('attach_id', array_keys($orphan_rows)) . '
						AND in_message = 1
						AND is_orphan = 1
						AND poster_id = ' . $user->data['user_id'];
				$result = $db->sql_query($sql);

				$orphan_rows = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$orphan_rows[$row['attach_id']] = $row;
				}
				$db->sql_freeresult($result);
			}

			foreach ($data['attachment_data'] as $pos => $attach_row)
			{
				if ($attach_row['is_orphan'] && !isset($orphan_rows[$attach_row['attach_id']]))
				{
					continue;
				}

				if (!$attach_row['is_orphan'])
				{
					// update entry in db if attachment already stored in db and filespace
					$sql = 'UPDATE ' . ATTACHMENTS_TABLE . "
						SET attach_comment = '" . $db->sql_escape($attach_row['attach_comment']) . "'
						WHERE attach_id = " . (int) $attach_row['attach_id'] . '
							AND is_orphan = 0';
					$db->sql_query($sql);
				}
				else
				{
					// insert attachment into db
					if (!@file_exists($phpbb_root_path . $config['upload_path'] . '/' . basename($orphan_rows[$attach_row['attach_id']]['physical_filename'])))
					{
						continue;
					}

					$space_taken += $orphan_rows[$attach_row['attach_id']]['filesize'];
					$files_added++;

					$attach_sql = array(
						'post_msg_id'		=> $data['msg_id'],
						'topic_id'			=> 0,
						'is_orphan'			=> 0,
						'poster_id'			=> $data['from_user_id'],
						'attach_comment'	=> $attach_row['attach_comment'],
					);

					$sql = 'UPDATE ' . ATTACHMENTS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $attach_sql) . '
						WHERE attach_id = ' . $attach_row['attach_id'] . '
							AND is_orphan = 1
							AND poster_id = ' . $user->data['user_id'];
					$db->sql_query($sql);
				}
			}

			if ($space_taken && $files_added)
			{
				set_config_count('upload_dir_size', $space_taken, true);
				set_config_count('num_files', $files_added, true);
			}
		}

		// Delete draft if post was loaded...
		$draft_id = phpBB3::request_var('draft_loaded', 0);
		if ($draft_id)
		{
			$sql = 'DELETE FROM ' . DRAFTS_TABLE . "
				WHERE draft_id = $draft_id
					AND user_id = " . $data['from_user_id'];
			$db->sql_query($sql);
		}

		$db->sql_transaction('commit');

		// Send Notifications
		if ($mode != 'edit')
		{
			$this->pm_notification($mode, $data['from_username'], $recipients, $subject, $data['message']);
		}

		return $data['msg_id'];
	}

	/**
	* PM Notification
	*/
	function pm_notification($mode, $author, $recipients, $subject, $message)
	{
		global $db, $lang, $mx_user, $board_config, $phpbb_root_path, $mx_root_path, $phpEx, $phpbb_auth, $page_id;

		$subject = mx_censor_text($subject);

		unset($recipients[ANONYMOUS], $recipients[$mx_user->data['user_id']]);

		if (!sizeof($recipients))
		{
			return;
		}

		// Get banned User ID's
		$sql = 'SELECT ban_userid
			FROM ' . BANLIST_TABLE . '
			WHERE ' . $db->sql_in_set('ban_userid', array_map('intval', array_keys($recipients))) . '
				AND ban_exclude = 0';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			unset($recipients[$row['ban_userid']]);
		}
		$db->sql_freeresult($result);

		if (!sizeof($recipients))
		{
			return;
		}

		$sql = 'SELECT user_id, username, user_email, user_lang, user_notify_pm, user_notify_type, user_jabber
			FROM ' . USERS_TABLE . '
			WHERE ' . $db->sql_in_set('user_id', array_map('intval', array_keys($recipients)));
		$result = $db->sql_query($sql);

		$msg_list_ary = array();
		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['user_notify_pm'] == 1 && trim($row['user_email']))
			{
				$msg_list_ary[] = array(
					'method'	=> $row['user_notify_type'],
					'email'		=> $row['user_email'],
					'jabber'	=> $row['user_jabber'],
					'name'		=> $row['username'],
					'lang'		=> $row['user_lang']
				);
			}
		}
		$db->sql_freeresult($result);

		if (!sizeof($msg_list_ary))
		{
			return;
		}

	    //
	    // Include and initiate mailer
	    //
	    include_once($mx_root_path . 'includes/mx_functions_emailer.'.$phpEx);

		//
		// Let's do some checking to make sure that mass mail functions
		// are working in win32 versions of php.
		//
		if ( preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
		{
			$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

			// We are running on windows, force delivery to use our smtp functions
			// since php's are broken by default
			$board_config['smtp_delivery'] = 1;
			$board_config['smtp_host'] = @$ini_val('SMTP');
		}

		$emailer = new mx_emailer($board_config['smtp_delivery']);
		
		foreach ($msg_list_ary as $pos => $addr)
		{
			//$emailer->to($addr['email'], $addr['name']);
			//$emailer->im($addr['jabber'], $addr['name']);
			
			$emailer_from = $board_config['board_email'];
			$emailer_to = $addr['email'];
			$emailer_skip = ($emailer_to == $emailer_from) ? $emailer_to : false;			
			
		    //
		    // Mail
		    //
			$emailer->set_mail_html(true);	
			$emailer->use_template('privmsg_notify');
			$emailer->email_skip($emailer_skip);		
			$emailer->email_address($board_config['board_email']);
			$emailer->set_subject(htmlspecialchars_decode($subject));
			$emailer->extra_headers($email_antetes);		

			$emailer->assign_vars(array(
				'SITENAME' 		=> $board_config['sitename'],
				'BOARD_EMAIL' 	=> $board_config['board_email'],				
				'SUBJECT'		=> htmlspecialchars_decode($subject),
				'MESSAGE' 		=> $message,				
				'AUTHOR_NAME'	=> htmlspecialchars_decode($author),
				'USERNAME'		=> htmlspecialchars_decode($addr['name']),

				'U_INBOX'		=> PHPBB_URL . "/ucp.$phpEx?i=pm&folder=inbox")
			);

			$emailer->send();
			$emailer->reset();
		}
		
		unset($msg_list_ary);
		//$emailer->save_queue();
		unset($emailer);
		
		$msg = $lang['Message_sent'] . '<br /><br />' . sprintf($lang['Click_return_inbox'], '<a href="' . mx_append_sid(PHPBB_URL . "/ucp.$phpEx?i=pm&folder=inbox") . '">', '</a> ') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?page=' . $page_id) . '">', '</a>');

		mx_message_die(GENERAL_MESSAGE, $msg);		
		
	}
}

/**
 * Class module_cache.
 *
 * Generic module cache.
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class module_cache
{
	var $vars = '';
	var $vars_ts = array();
	var $modified = false;

	/**
	 * Enter description here...
	 *
	 * @return module_cache
	 */
	function module_cache($dir=false)
	{
		global $phpbb_root_path;
		global $mx_root_path, $module_root_path, $is_block, $phpEx;

		if (!$dir)
		{
			mx_message_die(GENERAL_ERROR, 'The module cache need a init dir.');
		}

		$this->cache_dir = $dir . 'cache/';
	}

	/**
	 * Enter description here...
	 *
	 */
	function load()
	{
		global $phpEx;
		@include( $this->cache_dir . 'data_global.' . $phpEx );
	}

	/**
	 * Enter description here...
	 *
	 */
	function unload()
	{
		$this->save();
		unset( $this->vars );
		unset( $this->vars_ts );
	}

	/**
	 * Enter description here...
	 *
	 */
	function save()
	{
		if ( !$this->modified )
		{
			return;
		}

		global $phpEx;
		$file = '<?php $this->vars=' . @$this->format_array( $this->vars ) . ";\n\$this->vars_ts=" . @$this->format_array( $this->vars_ts ) . ' ?>';

		if ( $fp = @fopen( $this->cache_dir . 'data_global.' . $phpEx, 'wb' ) )
		{
			@flock( $fp, LOCK_EX );
			fwrite( $fp, $file );
			@flock( $fp, LOCK_UN );
			fclose( $fp );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $expire_time
	 */
	function tidy( $expire_time = 0 )
	{
		global $phpEx;

		$dir = opendir( $this->cache_dir );
		while ( $entry = readdir( $dir ) )
		{
			if ( $entry{0} == '.' || substr( $entry, 0, 4 ) != 'sql_' )
			{
				continue;
			}

			if ( time() - $expire_time >= filemtime( $this->cache_dir . $entry ) )
			{
				unlink( $this->cache_dir . $entry );
			}
		}

		if ( file_exists( $this->cache_dir . 'data_global.' . $phpEx ) )
		{
			if (!sizeof($this->vars_ts))
			{
				$this->load();
			}

			foreach ( $this->vars_ts as $varname => $timestamp )
			{
				if ( time() - $expire_time >= $timestamp )
				{
					$this->destroy( $varname );
				}
			}
		}
		else
		{
			$this->vars = $this->vars_ts = array();
			$this->modified = true;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $varname
	 * @param unknown_type $expire_time
	 * @return unknown
	 */
	function get( $varname, $expire_time = 0 )
	{
		return ( $this->exists( $varname, $expire_time ) ) ? $this->vars[$varname] : null;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $varname
	 * @param unknown_type $var
	 */
	function put( $varname, $var )
	{
		$this->vars[$varname] = $var;
		$this->vars_ts[$varname] = time();
		$this->modified = true;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $varname
	 */
	function destroy( $varname )
	{
		if ( isset( $this->vars[$varname] ) )
		{
			$this->modified = true;
			unset( $this->vars[$varname] );
			unset( $this->vars_ts[$varname] );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $varname
	 * @param unknown_type $expire_time
	 * @return unknown
	 */
	function exists( $varname, $expire_time = 0 )
	{
		if ( !is_array( $this->vars ) )
		{
			$this->load();
		}

		if ( $expire_time > 0 && isset( $this->vars_ts[$varname] ) )
		{
			if ( $this->vars_ts[$varname] <= time() - $expire_time )
			{
				$this->destroy( $varname );
				return false;
			}
		}

		return isset( $this->vars[$varname] );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $array
	 * @return unknown
	 */
	function format_array($array)
	{
		$lines = array();
		foreach ($array as $k => $v)
		{
			if (is_array( $v ))
			{
				$lines[] = "'$k'=>" . $this->format_array($v);
			}
			elseif (is_int($v))
			{
				$lines[] = "'$k'=>$v";
			}
			elseif (is_bool($v))
			{
				$lines[] = "'$k'=>" . (($v) ? 'TRUE' : 'FALSE');
			}
			else
			{
				$lines[] = "'$k'=>'" . str_replace( "'", "\'", str_replace( '\\', '\\\\', $v ) ) . "'";
			}
		}
		return 'array(' . implode(',', $lines) . ')';
	}	
}


/**
 * Class mx_custom_field.
 *
 * This is a generic class for custom fields.
 *
 * @package Tools
 * @author Jon Ohlsson
 * @access public
 */
class mx_custom_field
{
	var $field_rowset = array();
	var $field_data_rowset = array();

	var $custom_table = KB_CUSTOM_TABLE;
	var $custom_data_table = KB_CUSTOM_DATA_TABLE;

	/**
	 * Constructor.
	 *
	 * @return mx_custom_field
	 */
	function mx_custom_field($custom_table, $custom_data_table)
	{
		$this->custom_table = $custom_table;
		$this->custom_data_table = $custom_data_table;
	}

	/**
	 * prepare data
	 *
	 */
	function init()
	{
		global $db;

		$sql = "SELECT *
			FROM " . $this->custom_table . "
			ORDER BY field_order ASC";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query Custom field', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$this->field_rowset[$row['custom_id']] = $row;
		}
		unset( $row );
		$db->sql_freeresult( $result );

		$sql = "SELECT *
			FROM " . $this->custom_data_table;

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt Query Custom field', '', __LINE__, __FILE__, $sql );
		}

		while ( $row = $db->sql_fetchrow( $result ) )
		{
			$this->field_data_rowset[$row['customdata_file']][$row['customdata_custom']] = $row;
		}

		unset( $row );

		$db->sql_freeresult( $result );
	}

	/**
	 * check if there is a data in the database.
	 *
	 * @return unknown
	 */
	function field_data_exist()
	{
		if ( !empty( $this->field_data_rowset ) )
		{
			return true;
		}
		return false;
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function field_exist()
	{
		if ( !empty( $this->field_rowset ) )
		{
			return true;
		}
		return false;
	}

	/**
	 * display data in the comment.
	 *
	 * @param unknown_type $file_id
	 * @return unknown
	 */
	function add_comment($file_id)
	{
		global $template;
		if ( $this->field_data_exist() )
		{
			if ( isset( $this->field_data_rowset[$file_id] ) )
			{
				$message = '';
				foreach( $this->field_data_rowset[$file_id] as $field_id => $data )
				{
					if ( !empty( $data['data'] ) )
					{
						switch ( $this->field_rowset[$field_id]['field_type'] )
						{
							case INPUT:
							case TEXTAREA:
							case RADIO:
							case SELECT:
								$field_data = $data['data'];
								break;
							case SELECT_MULTIPLE:
							case CHECKBOX:
								$field_data = @implode( ', ', unserialize( $data['data'] ) );
								break;
						}
						$message .= "\n" . "[b]" . $this->field_rowset[$field_id]['custom_name'] . ":[/b] " . $field_data . "\n";
					}
					else
					{
						global $db;

						$sql = "DELETE FROM " . $this->custom_data_table . "
							WHERE customdata_file = '$file_id'
							AND customdata_custom = '$field_id'";

						if ( !( $db->sql_query( $sql ) ) )
						{
							mx_message_die(GENERAL_ERROR, 'Could not delete custom data', '', __LINE__, __FILE__, $sql);
						}
					}
				}
				return $message;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * display data in the file page.
	 *
	 * @param unknown_type $file_id
	 * @return unknown
	 */
	function display_data( $file_id )
	{
		global $template;
		if ( $this->field_data_exist() )
		{
			if ( isset( $this->field_data_rowset[$file_id] ) )
			{
				foreach( $this->field_data_rowset[$file_id] as $field_id => $data )
				{
					if ( !empty( $data['data'] ) )
					{
						switch ( $this->field_rowset[$field_id]['field_type'] )
						{
							case INPUT:
							case TEXTAREA:
							case RADIO:
							case SELECT:
								$field_data = $data['data'];
								break;
							case SELECT_MULTIPLE:
							case CHECKBOX:
								$field_data = @implode( ', ', unserialize( $data['data'] ) );
								break;
						}

						$template->assign_block_vars( 'custom_field', array(
							'CUSTOM_NAME' => $this->field_rowset[$field_id]['custom_name'],
							'DATA' => $field_data )
						);
					}
					else
					{
						global $db;

						$sql = "DELETE FROM " . $this->custom_data_table . "
							WHERE customdata_file = '$file_id'
							AND customdata_custom = '$field_id'";

						if ( !( $db->sql_query( $sql ) ) )
						{
							mx_message_die( GENERAL_ERROR, 'Could not delete custom data', '', __LINE__, __FILE__, $sql );
						}
					}
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * display custom field and data in the add/edit page.
	 *
	 * @param unknown_type $file_id
	 * @return unknown
	 */
	function display_edit( $file_id = false )
	{
		$return = false;
		if ( $this->field_exist() )
		{
			foreach( $this->field_rowset as $field_id => $field_data )
			{
				switch ( $field_data['field_type'] )
				{
					case INPUT:
						$this->display_edit_input( $file_id, $field_id, $field_data );
					break;
					case TEXTAREA:
						$this->display_edit_textarea( $file_id, $field_id, $field_data );
					break;
					case RADIO:
						$this->display_edit_radio( $file_id, $field_id, $field_data );
					break;
					case SELECT:
						$this->display_edit_select( $file_id, $field_id, $field_data );
					break;
					case SELECT_MULTIPLE:
						$this->display_edit_select_multiple( $file_id, $field_id, $field_data );
					break;
					case CHECKBOX:
						$this->display_edit_checkbox( $file_id, $field_id, $field_data );
					break;
				}

				$return = true;
			}
		}
		return $return;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_input( $file_id, $field_id, $field_data )
	{
		global $template;
		$field_value_temp =  (!empty( $this->field_data_rowset[$file_id][$field_id]['data'] )) ? $this->field_data_rowset[$file_id][$field_id]['data'] : '';
		$field_value = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $field_value_temp ;
		$template->assign_block_vars( 'input', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'],
			'FIELD_VALUE' =>  $field_value )
		);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_textarea( $file_id, $field_id, $field_data )
	{
		global $template;
		$field_value_temp = ( !empty( $this->field_data_rowset[$file_id][$field_id]['data'] ) ) ? $this->field_data_rowset[$file_id][$field_id]['data'] : '';
		$field_value = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $field_value_temp ;
		$template->assign_block_vars( 'textarea', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'],
			'FIELD_VALUE' => $field_value )
		);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_radio( $file_id, $field_id, $field_data )
	{
		global $template;
		$template->assign_block_vars( 'radio', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'] )
		);

		$data_temp = ( !empty( $this->field_data_rowset[$file_id][$field_id]['data'] ) ) ? $this->field_data_rowset[$file_id][$field_id]['data'] : array();
		$data = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $data_temp ;
		$field_datas = ( !empty( $field_data['data'] ) ) ? unserialize( stripslashes( $field_data['data'] ) ) : array();

		if ( !empty( $field_datas ) )
		{
			foreach( $field_datas as $key => $value )
			{
				$template->assign_block_vars( 'radio.row', array(
					'FIELD_VALUE' => $value,
					'FIELD_SELECTED' => ( $data == $value ) ? ' checked="checked"' : '' )
				);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_select( $file_id, $field_id, $field_data )
	{
		global $template;
		$template->assign_block_vars( 'select', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'] )
		);

		$data_temp = ( !empty( $this->field_data_rowset[$file_id][$field_id]['data'] ) ) ? $this->field_data_rowset[$file_id][$field_id]['data'] : '';
		$data = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $data_temp ;
		$field_datas = ( !empty( $field_data['data'] ) ) ? unserialize( stripslashes( $field_data['data'] ) ) : array();

		if ( !empty( $field_datas ) )
		{
			foreach( $field_datas as $key => $value )
			{
				$template->assign_block_vars( 'select.row', array(
					'FIELD_VALUE' => $value,
					'FIELD_SELECTED' => ( $data == $value ) ? ' selected="selected"' : '' )
				);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_select_multiple( $file_id, $field_id, $field_data )
	{
		global $template;
		$template->assign_block_vars( 'select_multiple', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'] )
		);

		$data_temp = ( !empty( $this->field_data_rowset[$file_id][$field_id]['data'] ) ) ? unserialize( $this->field_data_rowset[$file_id][$field_id]['data'] ) : array();
		$data = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $data_temp ;
		$field_datas = ( !empty( $field_data['data'] ) ) ? unserialize( stripslashes( $field_data['data'] ) ) : array();

		if ( !empty( $field_datas ) )
		{
			foreach( $field_datas as $key => $value )
			{
				$selected = '';
				foreach( $data as $field_value )
				{
					if ( $field_value == $value )
					{
						$selected = '  selected="selected"';
						break;
					}
				}
				$template->assign_block_vars( 'select_multiple.row', array(
					'FIELD_VALUE' => $value,
					'FIELD_SELECTED' => $selected )
				);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_id
	 * @param unknown_type $field_id
	 * @param unknown_type $field_data
	 */
	function display_edit_checkbox( $file_id, $field_id, $field_data )
	{
		global $template;
		$template->assign_block_vars( 'checkbox', array(
			'FIELD_NAME' => $field_data['custom_name'],
			'FIELD_ID' => $field_data['custom_id'],
			'FIELD_DESCRIPTION' => $field_data['custom_description'] )
		);

		$data_temp = ( !empty( $this->field_data_rowset[$file_id][$field_id]['data'] ) ) ? unserialize( $this->field_data_rowset[$file_id][$field_id]['data'] ) : array();
		$data = !empty( $_POST['field'][$field_data['custom_id']] ) ? $_POST['field'][$field_data['custom_id']] : $data_temp ;
		$field_datas = ( !empty( $field_data['data'] ) ) ? unserialize( stripslashes( $field_data['data'] ) ) : array();

		if ( !empty( $field_datas ) )
		{
			foreach( $field_datas as $key => $value )
			{
				$checked = '';
				foreach( $data as $field_value )
				{
					if ( $field_value == $value )
					{
						$checked = ' checked';
						break;
					}
				}
				$template->assign_block_vars( 'checkbox.row', array(
					'FIELD_VALUE' => $value,
					'FIELD_CHECKED' => $checked )
				);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $field_type
	 * @param unknown_type $field_id
	 */
	function update_add_field( $field_type, $field_id = false )
	{
		global $db, $lang;

		$field_name = ( isset( $_POST['field_name'] ) ) ? htmlspecialchars( $_POST['field_name'] ) : '';
		$field_desc = ( isset( $_POST['field_desc'] ) ) ? htmlspecialchars( $_POST['field_desc'] ) : '';
		$regex = ( isset( $_POST['regex'] ) ) ? $_POST['regex'] : '';
		$data = ( isset( $_POST['data'] ) ) ? $_POST['data'] : '';
		$field_order = ( isset( $_POST['field_order'] ) ) ? $_POST['field_order'] : '';

		if ( $field_id )
		{
			$field_order = ( isset( $_POST['field_order'] ) ) ? intval( $_POST['field_order'] ) : '';
		}

		if ( !empty( $data ) )
		{
			$data = explode( "\n", htmlspecialchars( trim( $data ) ) );

			foreach( $data as $key => $value )
			{
				$data[$key] = trim( $value );
			}
			$data = addslashes( serialize( $data ) );
		}

		if ( empty( $field_name ) )
		{
			mx_message_die( GENERAL_ERROR, $lang['Missing_field'] );
		}

		if ( ( ( $field_type != INPUT && $field_type != TEXTAREA ) && empty( $data ) ) )
		{
			mx_message_die( GENERAL_ERROR, $lang['Missing_field'] );
		}

		if ( !$field_id )
		{
			$sql = "INSERT INTO " . $this->custom_table . " (custom_name, custom_description, data, regex, field_type)
				VALUES('" . $field_name . "', '" . $field_desc . "', '" . $data . "', '" . $regex . "', '" . $field_type . "')";

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not add the new fields', '', __LINE__, __FILE__, $sql );
			}

			$field_id = $db->sql_nextid();

			$sql = "UPDATE " . $this->custom_table . "
				SET field_order = '$field_id'
				WHERE custom_id = $field_id";

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not set the order for the giving field', '', __LINE__, __FILE__, $sql );
			}
		}
		else
		{
			$sql = "UPDATE " . $this->custom_table . "
				SET custom_name = '$field_name', custom_description = '$field_desc', data = '$data', regex = '$regex', field_order='$field_order'
				WHERE custom_id = $field_id";

			if ( !( $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Could not update information for the giving field', '', __LINE__, __FILE__, $sql );
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $field_id
	 */
	function delete_field( $field_id )
	{
		global $db;

		$sql = "DELETE FROM " . $this->custom_data_table . "
			WHERE customdata_custom = '$field_id'";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not delete custom data', '', __LINE__, __FILE__, $sql );
		}

		$sql = "DELETE FROM " . $this->custom_table . "
			WHERE custom_id = '$field_id'";

		if ( !( $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Could not delete the selected field', '', __LINE__, __FILE__, $sql );
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $field_id
	 * @return unknown
	 */
	function get_field_data( $field_id )
	{
		$return_array = $this->field_rowset[$field_id];
		$return_array['data'] = !empty( $return_array['data'] ) ? implode( "\n", unserialize( stripslashes( $return_array['data'] ) ) ) : '';
		return $return_array;
	}

	/**
	 * file data in custom field operations.
	 *
	 * @param unknown_type $file_id
	 */
	function file_update_data( $file_id )
	{
		global $db;
		$field = ( isset( $_POST['field'] ) ) ? $_POST['field'] : '';
		if ( !empty( $field ) )
		{
			foreach( $field as $field_id => $field_data )
			{
				if ( !empty( $this->field_rowset[$field_id]['regex'] ) )
				{
					if ( !preg_match( '#' . $this->field_rowset[$field_id]['regex'] . '#siU', $field_data ) )
					{
						$field_data = '';
					}
				}

				switch ( $this->field_rowset[$field_id]['field_type'] )
				{
					case INPUT:
					case TEXTAREA:
					case RADIO:
					case SELECT:
						$data = htmlspecialchars( $field_data );
						break;
					case SELECT_MULTIPLE:
					case CHECKBOX:
						$data = addslashes( serialize( $field_data ) );
						break;
				}

				$sql = "DELETE FROM " . $this->custom_data_table . "
					WHERE customdata_file = '$file_id'
					AND customdata_custom = '$field_id'";

				if ( !$db->sql_query( $sql ) )
				{
					mx_message_die( GENERAL_ERROR, 'Could not delete data from custom data table', '', __LINE__, __FILE__, $sql );
				}

				if ( !empty( $data ) )
				{
					$sql = "INSERT INTO " . $this->custom_data_table . " (customdata_file, customdata_custom, data)
						VALUES('$file_id', '$field_id', '$data')";

					if ( !$db->sql_query( $sql ) )
					{
						mx_message_die( GENERAL_ERROR, 'Could not add additional data', '', __LINE__, __FILE__, $sql );
					}
				}
			}
		}
	}
}

class phpbb_posts
{
	/**
	 * insert_phpbb_post.
	 *
	 * insert post for site updates, by netclectic - Adrian Cockburn & Jon Ohlsson
	 *
	 *   Description    :   This functions is used to insert a post into your phpbb forums.
	 *                      It handles all the related bits like updating post counts,
	 *                      indexing search words, etc.
	 *                      The post is inserted for a specific user, so you will have to
	 *                      already have a user setup which you want to use with it.
	 *
	 *                      If you're using the POST method to input data then you should call addslashes on
	 *                      your subject and message before calling insert_post - see test_insert_post for example.
	 *
	 *   Parameters     :   $subject            - the subject of the post (required)
	 *                      $message            - the message that will form the body of the post (required)
	 *                      $forum_id           - the forum the post is to be added to (required)
	 *                      $user_id            - the id of the user for the post (required)
	 *                      $user_name          - the username of the user for the post (required)
	 *                      $user_attach_sig    - should the user's signature be attached to the post (required)
	 *
	 *   Options Params :   $topic_id           - if topic_id is empty we 'newtopic', else
	 *                      $post_id         	- if post_id is passed then we 'editpost', if not we reply
	 *                      $subject_update_first   - if (this and next) not empty first topic post is updated
	 *                      $message_update_first   - if (this and previous) not empty first topic post is updated
	 *
	 *                      $topic_type         - defaults to POST_NORMAL, can also be POST_STICKY, POST_ANNOUNCE or POST_GLOBAL_ANNOUNCE
	 *                      $do_notification    - should users be notified of new posts (only valid for replies)
	 *                      $notify_user        - should the 'posting' user be signed up for notifications of this topic
	 *                      $current_time       - should the current time be used, if not then you should supply a posting time
	 *                      $error_die_function - can be used to supply a custom error function.
	 *                      $html_on = false    - should html be allowed (parsed) in the post text.
	 *                      $bbcode_on = true   - should bbcode be allowed (parsed) in the post text.
	 *                      $smilies_on = true  - should smilies be allowed (parsed) in the post text.
	 *
	 *   Returns        :   If the function succeeds without an error it will return an array containing
	 *                      the post id and the topic id of the new post. Any error along the way will result in either
	 *                      the normal phpbb message_die function being called or a custom die function determined
	 *                      by the $error_die_function parameter.
	 *
	 * @param unknown_type $subject
	 * @param unknown_type $message
	 * @param unknown_type $forum_id
	 * @param unknown_type $user_id
	 * @param unknown_type $user_name
	 * @param unknown_type $user_attach_sig
	 * @param unknown_type $topic_id
	 * @param unknown_type $post_id
	 * @param unknown_type $subject_update_first
	 * @param unknown_type $message_update_first
	 * @param unknown_type $bbcode_uid
	 * @param unknown_type $topic_type
	 * @param unknown_type $do_notification
	 * @param unknown_type $notify_user
	 * @param unknown_type $current_time
	 * @param unknown_type $error_die_function
	 * @param unknown_type $html_on
	 * @param unknown_type $bbcode_on
	 * @param unknown_type $smilies_on
	 * @return unknown
	 */
	function insert_phpbb_post(
		$subject,
	    $message,
	    $forum_id,
	    $user_id,
	    $user_name,
	    $user_attach_sig,
	    $topic_id = '',
	    $post_id = '',
	    $subject_update_first = '',
	    $message_update_first = '',
	    $bbcode_bitfield = 'cA==',
	    $bbcode_uid = 'cxx4izak',		
	    $topic_type = POST_NORMAL,
	    $do_notification = false,
	    $notify_user = false,
	    $current_time = 0,
	    $error_die_function = '',
	    $html_on = 0,
	    $bbcode_on = 1,
	    $smilies_on = 1)
	{
		global $db, $phpbb_root_path, $phpEx, $board_config, $user_ip, $portal_config, $lang, $userdata, $mx_user, $phpbb_auth, $mx_bbcode, $mx_backend;

		//
		// initialise some variables
		//
		$topic_vote = 0;
		$poll_title = '';
		$poll_options = '';
		$poll_length = '';
		$url = '';

	    $error_die_function = ($error_die_function == '') ? "mx_message_die" : $error_die_function;
	    $current_time = ($current_time == 0) ? time() : $current_time;

		//phpBB2 topic_title can have max 60 chars
	    $subject = addslashes(trim($subject));
		$subject = substr($subject, 0, 60);
		$subject = mx_censor_text($subject);

	    $username = addslashes(unprepare_message(trim($user_name)));
	    $username = phpBB2::phpbb_clean_username($username);
		

		// Unique ID for this message..
		$uid = $mx_backend->dss_rand();
		
		// BBCode UID length fix
		@define('BBCODE_UID_LEN', (PORTAL_BACKEND == 'phpbb3') ? 8 : 10);		
		
		$uid = substr($uid, 0, BBCODE_UID_LEN);
	
		
		// We do not handle erasing posts here
		if ($mode == 'delete')
		{
			return false;
		}

		$data = array();
			
		$mx_text_formatting = new mx_text_formatting();

		// First of all make sure the subject and topic title are having the correct length.
		// To achieve this without cutting off between special chars we convert to an array and then count the elements.
		$data['topic_title'] = $mx_text_formatting->truncate_string($subject);
		$data['post_id'] = $post_id;		

	    //
	    // We always require the forum_id
	    //
	    if (empty($forum_id))
	    {
	    	$error_die_function(GENERAL_ERROR, "no forum id: '$forum_id' - be sure to configure this category correctly in the AdminCP");
	    }
		
		//
		// Validate vars and find correct $mode
		//
	    if (empty($topic_id))
	    {
		    //
			// If $topic_id is empty we assume you want a new topic
			//
			$mode = 'newtopic';
			$post_mode = 'post';
			$update_message = true;			
	    }
		else if (empty($post_id))
		{
			//
			// If $post_id is empty we assume you want a 'reply'
			//
			$mode = 'reply';
			$post_mode = 'reply';
			$update_message = true;			

		}
		else
		{
			//
			// So this must be a 'editpost'
			// but is this first topic post or last post
			//
			$mode = 'editpost';
			$post_mode = 'edit';
			
			// Collect some basic information about which tables and which rows to update/insert
			$sql_data = $topic_row = array();
			$poster_id = ($mode == 'editpost') ? $data['poster_id'] : (int) $mx_user->data['user_id'];

			// Retrieve some additional information if not present
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':				
				break;

				case 'phpbb2':
				
					$sql = "SELECT topic_first_post_id, topic_last_post_id
			       		FROM " . TOPICS_TABLE . "
			      		WHERE topic_id = '$topic_id'";
				break;
				
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':											
					$sql = 'SELECT p.post_approved, t.topic_first_post_id, t.topic_last_post_id, t.topic_type, t.topic_replies, t.topic_replies_real, t.topic_approved
						FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
						WHERE t.topic_id = p.topic_id
							AND p.post_id = ' . $data['post_id'];					
						
				break;
			}
			
			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(GENERAL_ERROR, "Could not obtain first_post_id data", '', __LINE__, __FILE__, $sql);
			}						
			$topic_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
				
			$first_post_id = $topic_row['topic_first_post_id'];
			$last_post_id = $topic_row['topic_last_post_id'];

			$is_first_post = ($first_post_id == $post_id) ? true : false;
			$is_last_post = ($last_post_id == $post_id) ? true : false;

			switch (PORTAL_BACKEND)
			{
				case 'internal':
				break;

				case 'phpbb2':

					$data['topic_approved'] = (!$phpbb_auth->acl_get('f_noapprove', $forum_id) && !$phpbb_auth->acl_get('m_approve', $forum_id)) ? 0 : 1;
					$data['post_approved'] = (!$phpbb_auth->acl_get('f_noapprove', $forum_id) && !$phpbb_auth->acl_get('m_approve', $forum_id)) ? 0 : 1;
				break;

				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':										
					$data['topic_approved'] = $topic_row['topic_approved'];
					$data['post_approved'] = $topic_row['post_approved'];
				break;
			}			
	
			// This variable indicates if the user is able to post or put into the queue - it is used later for all code decisions regarding approval
			$post_approval = 1;
		}

		//
		// Now we have validated we have correct $mode and all required vars are set :-)
		// Lets start
		//

		//
		// New topic or updated first topic post
		//
		if ($mode == 'newtopic' || ($mode == 'editpost' && $is_first_post))
		{
			if ($mode == 'newtopic')
			{			
				switch (PORTAL_BACKEND)
				{
					case 'internal':
					case 'smf2':
					case 'mybb':					
					break;
					
					case 'phpbb2':
						//
						// Inserting new topic
						//
						$sql = "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type, topic_vote) VALUES ('$subject', " . $user_id . ", $current_time, $forum_id, " . TOPIC_UNLOCKED . ", $topic_type, $topic_vote)";
						
						if (!$db->sql_query($sql))
						{
							$error_die_function(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
						}
						
						$topic_id = $mode == 'newtopic' ? $db->sql_nextid() : $topic_id;						
					break;
					
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					case 'rhea':				
						/*
						if (!function_exists('submit_post'))
						{
							include_once($mx_root_path . 'includes/shared/phpbb3/includes/functions_posting.' . $phpEx);
						}					
						*/
						$post_data = array();
					
						// Determine some vars
						if (isset($user_id) && $user_id == ANONYMOUS)
						{
							$post_data['username'] = isset($username) ? $username : '';
						}

						$post_data['post_edit_locked']	= (isset($post_data['post_edit_locked'])) ? (int) $post_data['post_edit_locked'] : 0;
						$post_data['post_subject']		= (in_array($mode, array('quote', 'edit'))) ? $post_data['post_subject'] : ((isset($post_data['topic_title'])) ? $post_data['topic_title'] : '');
						$post_data['topic_time_limit']	= (isset($post_data['topic_time_limit'])) ? (($post_data['topic_time_limit']) ? (int) $post_data['topic_time_limit'] / 86400 : (int) $post_data['topic_time_limit']) : 0;
						$post_data['poll_length']		= (!empty($post_data['poll_length'])) ? (int) $post_data['poll_length'] / 86400 : 0;
						$post_data['poll_start']		= (!empty($post_data['poll_start'])) ? (int) $post_data['poll_start'] : 0;
						$post_data['icon_id']			= (!isset($post_data['icon_id']) || in_array($mode, array('quote', 'reply'))) ? 0 : (int) $post_data['icon_id'];
						$post_data['poll_options']		= array();
					
						$post_data['post_subject'] = $subject; 
						$post_data['topic_type'] = $topic_type; 
						$poll = array();
						
						$data = array(
							'topic_title'			=> (empty($post_data['topic_title'])) ? $post_data['post_subject'] : $post_data['topic_title'],
							'topic_first_post_id'	=> (isset($post_data['topic_first_post_id'])) ? (int) $post_data['topic_first_post_id'] : 0,
							'topic_last_post_id'	=> (isset($post_data['topic_last_post_id'])) ? (int) $post_data['topic_last_post_id'] : 0,
							'topic_time_limit'		=> (int) $post_data['topic_time_limit'],
							'topic_attachment'		=> (isset($post_data['topic_attachment'])) ? (int) $post_data['topic_attachment'] : 0,
							'post_id'				=> (int) $post_id,
							'topic_id'				=> (int) $topic_id,
							'forum_id'				=> (int) $forum_id,
							'icon_id'				=> (int) $post_data['icon_id'],
							'poster_id'				=> (int) $post_data['poster_id'],
							'enable_sig'			=> (bool) $post_data['enable_sig'],
							'enable_bbcode'			=> (bool) $post_data['enable_bbcode'],
							'enable_smilies'		=> (bool) $post_data['enable_smilies'],
							'enable_urls'			=> (bool) $post_data['enable_urls'],
							'enable_indexing'		=> (bool) $post_data['enable_indexing'],
							'message_md5'			=> (string) $message_md5,
							'post_time'				=> (isset($post_data['post_time'])) ? (int) $post_data['post_time'] : $current_time,
							'post_checksum'			=> (isset($post_data['post_checksum'])) ? (string) $post_data['post_checksum'] : md5($message),
							'post_edit_reason'		=> $post_data['post_edit_reason'],
							'post_edit_user'		=> ($mode == 'edit') ? $user->data['user_id'] : ((isset($post_data['post_edit_user'])) ? (int) $post_data['post_edit_user'] : 0),
							'forum_parents'			=> $post_data['forum_parents'],
							'forum_name'			=> $post_data['forum_name'],
							'notify'				=> $notify,
							'notify_set'			=> $post_data['notify_set'],
							'poster_ip'				=> (isset($post_data['poster_ip'])) ? $post_data['poster_ip'] : $mx_user->ip,
							'post_edit_locked'		=> (int) $post_data['post_edit_locked'],
							'message'				=> $mx_bbcode->bbcode_nl2br($message),
							'bbcode_bitfield'		=> $bbcode_bitfield,
							'bbcode_uid'			=> $bbcode_uid,
							'message'				=> $message,
							'attachment_data'		=> (!empty($attachment_data)) ? 1 : 0,
							'filename_data'			=> $filename_data,
							'topic_approved'		=> (isset($post_data['topic_approved'])) ? $post_data['topic_approved'] : false,
							'post_approved'			=> (isset($post_data['post_approved'])) ? $post_data['post_approved'] : false,
						); 
						
						$update_message = false;
									
						$topic_id = $this->submit_phpbb_post($post_mode, $post_data['post_subject'], $post_data['username'], $post_data['topic_type'], $poll, $data, $update_message);						
					break;
				}
			}
			else
			{
				//
				// Updating topic
				//
				$sql = "UPDATE " . TOPICS_TABLE . " SET topic_title = '$subject', topic_type = $topic_type WHERE topic_id = $topic_id";
				
				if (!$db->sql_query($sql))
				{
					$error_die_function(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
				}
				
				$topic_id = $mode == 'newtopic' ? $db->sql_nextid() : $topic_id;
			}			
			
		}

		//
		// remove search words for our edited post
		//
		if ($mode == 'editpost')
		{
			remove_search_post($post_id);
		}

		//
		// insert/update the post details using the topic id
		//
		if ( $mode == 'newtopic' || $mode == 'reply' )
		{
			$update_message = true;
		
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':				
				break;
				
				case 'phpbb2':
					$sql = "INSERT INTO " . POSTS_TABLE . " (topic_id, forum_id, poster_id, post_username, post_time, poster_ip, enable_bbcode, enable_html, enable_smilies, enable_sig) VALUES ($topic_id, $forum_id, " . $user_id . ", '$username', $current_time, '$user_ip', $bbcode_on, $html_on, $smilies_on, $user_attach_sig)";

					if (!$db->sql_query($sql))
					{
						$error_die_function(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
					}					
				break;

				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':				
				/*				
					$sql_data = array(
						'post_id'			=> (int) $post_id,
						'topic_id'			=> (int) $topic_id,
						'forum_id'			=> (int) $forum_id,
						'poster_id'			=> (int) $mx_user->data['user_id'],
						'icon_id'			=> (!empty($icon_id)) ? $icon_id : 0,
						'poster_ip'			=> $mx_user->ip,
						'post_time'			=> $current_time,
						'post_approved'		=> (!$phpbb_auth->acl_get('f_noapprove', $forum_id) && !$phpbb_auth->acl_get('m_approve', $forum_id)) ? 0 : 1,
						'enable_bbcode'		=> !empty($bbcode_on) ? $bbcode_on : 0,
						'enable_smilies'	=> !empty($smilies_on) ? $smilies_on : 0,
						'enable_magic_url'	=> !empty($bbcode_on) ? $bbcode_on : 0,
						'enable_sig'		=> $user_attach_sig,
						'post_username'		=> $username,
						'post_subject'		=> $subject,
						'post_text'			=> $mx_bbcode->bbcode_nl2br($message),
						'post_checksum'		=> md5($message),
						'post_attachment'	=> (!empty($attachment_data)) ? 1 : 0,
						'bbcode_bitfield'	=> $bbcode_bitfield,
						'bbcode_uid'		=> $bbcode_uid,
						'post_postcount'	=> ($phpbb_auth->acl_get('f_postcount', $forum_id)) ? 1 : 0,
						'post_edit_locked'	=> !empty($post_edit_locked) ? $post_edit_locked : 0
					);

					$sql = "INSERT INTO " . POSTS_TABLE . $db->sql_build_array('INSERT', $sql_data);
					
					if (!$db->sql_query($sql))
					{
						$error_die_function(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
					}					
					
				*/
				break;
			}

		}
		else
		{
			$edited_sql = !$is_last_post ? ", post_edit_time = $current_time, post_edit_count = post_edit_count + 1 " : "";

			$sql = "UPDATE " . POSTS_TABLE . "
				SET post_username = '$username', enable_bbcode = $bbcode_on, enable_smilies = $smilies_on, enable_sig = $user_attach_sig" . $edited_sql . "
				WHERE post_id = $post_id"; //Temp fix - removed html_on
				
			if (!$db->sql_query($sql))
			{
				$error_die_function(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
			}				
		}
		
		$post_id = $mode == 'newtopic' || $mode == 'reply' ? $db->sql_nextid() : $post_id;

		//
		// insert the actual post text for our new post
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':			
			break;

			case 'phpbb2':
				if ( $mode == 'newtopic' || $mode == 'reply' )
				{
					$sql = "INSERT INTO " . POSTS_TEXT_TABLE . " (post_id, post_subject, bbcode_uid, post_text) VALUES ($post_id, '$subject', '$bbcode_uid', '$message')";
				}
				else
				{
					$sql = "UPDATE " . POSTS_TEXT_TABLE . " SET post_text = '$message',  bbcode_uid = '$bbcode_uid', post_subject = '$subject' WHERE post_id = $post_id";
				}

				if ( !$db->sql_query( $sql ) )
				{
					$error_die_function( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
				}

			break;

			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':			
				//$topic_id = $this->submit_phpbb_post($post_mode, $post_data['post_subject'], $post_data['username'], $post_data['topic_type'], $poll, $data, $update_message);
			break;
		}

		//
		// update the post counts etc.
		//
		$newpostsql = ( $mode == 'newtopic' ) ? ',forum_topics = forum_topics + 1' : '';

		$sql = "UPDATE " . FORUMS_TABLE . " SET
	               forum_posts = forum_posts + 1,
	               forum_last_post_id = $post_id
	               $newpostsql
	           WHERE forum_id = $forum_id";

		if ( !$db->sql_query( $sql ) )
		{
			$error_die_function( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
		}

		//
		// update the first / last post ids for the topic
		//
		$first_post_sql = ( $mode == 'newtopic' ) ? ", topic_first_post_id = $post_id  " : ' , topic_replies=topic_replies+1';

		$sql = "UPDATE " . TOPICS_TABLE . " SET
	               topic_last_post_id = $post_id
	               $first_post_sql
	           WHERE topic_id = $topic_id";

		if ( !$db->sql_query( $sql ) )
		{
			$error_die_function( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
		}

		//
		// update the user's post count and commit the transaction
		//
		$sql = "UPDATE " . USERS_TABLE . " SET
	               user_posts = user_posts + 1
	           WHERE user_id = $user_id";

		if ( !$db->sql_query( $sql ) )
		{
			$error_die_function( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
		}

		//
		// add the search words for our new/edited post
		//
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':			
			break;

			case 'phpbb2':
				phpBB2::add_search_words('single', $post_id, stripslashes($message), stripslashes($subject));

			break;
			
			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':			
				//To do
			break;
		}

		//
		// update first topic post
		//
		if (!empty($topic_id) && !empty($subject_update_first) && !empty($message_update_first) )
		{
			if (empty($first_post_id))
			{
				$sql = "SELECT topic_first_post_id
			       		FROM " . TOPICS_TABLE . "
			      		WHERE topic_id = '$topic_id'";

				if ( !( $result = $db->sql_query( $sql ) ) )
				{
					mx_message_die( GENERAL_ERROR, "Could not obtain first_post_id data", '', __LINE__, __FILE__, $sql );
				}

				$row_tmp = $db->sql_fetchrow( $result );
				$first_post_id = $row_tmp['topic_first_post_id'];
			}

			//
			// Remove search words
			//
			remove_search_post($first_post_id);

			$sql = "UPDATE " . TOPICS_TABLE . " SET
		                topic_title = '$subject_update_first'
						WHERE topic_id = '$topic_id'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
			}

			$sql = "UPDATE " . POSTS_TEXT_TABLE . " SET
		                post_subject = '$subject_update_first',
						bbcode_uid = '$bbcode_uid',
						post_text = '$message_update_first'
						WHERE post_id = '$first_post_id'";

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql );
			}
			
			// Add search words
			switch (PORTAL_BACKEND)
			{
				case 'internal':
				case 'smf2':
				case 'mybb':				
				break;

				case 'phpbb2':
					phpBB2::add_search_words('single', $first_post_id, stripslashes($message_update_first), stripslashes($subject_update_first));

				break;
				case 'phpbb3':
				case 'olympus':
				case 'ascraeus':
				case 'rhea':				
					//To do
				break;
			}
		}

		//
		// do we need to do user notification
		//
	    if ( ($mode != 'newtopic') && $do_notification )
		{
			$post_data = array();
			user_notification( $mode, $post_data, $subject, $forum_id, $topic_id, $post_id, $notify_user );
		}

		//
		// if all is well then return the id of our new post
		//
		return array( 'post_id' => $post_id, 'topic_id' => $topic_id, 'notify' => $message_tmp );
	}
	
	/**
	* Submit Post
	*/
	function submit_phpbb_post($mode, $subject, $mx_username, $topic_type, &$poll, &$data, $update_message = true)
	{
		global $db, $phpbb_auth, $mx_user, $config, $phpEx, $template, $phpbb_root_path;

		// We do not handle erasing posts here
		if ($mode == 'delete')
		{
			return false;
		}
		
		$mx_text_formatting = new mx_text_formatting();

		$current_time = time();

		if ($mode == 'post')
		{
			$post_mode = 'post';
			$update_message = true;
		}
		else if ($mode != 'edit')
		{
			$post_mode = 'reply';
			$update_message = true;
		}
		else if ($mode == 'edit')
		{
			$post_mode = ($data['topic_replies_real'] == 0) ? 'edit_topic' : (($data['topic_first_post_id'] == $data['post_id']) ? 'edit_first_post' : (($data['topic_last_post_id'] == $data['post_id']) ? 'edit_last_post' : 'edit'));
		}
		
		// First of all make sure the subject and topic title are having the correct length.
		// To achieve this without cutting off between special chars we convert to an array and then count the elements.
		$subject = $mx_text_formatting->truncate_string($subject);
		$data['topic_title'] = $mx_text_formatting->truncate_string($data['topic_title']);

		// Collect some basic information about which tables and which rows to update/insert
		$sql_data = $topic_row = array();
		$poster_id = ($mode == 'edit') ? $data['poster_id'] : (int) $mx_user->data['user_id'];

		// Retrieve some additional information if not present
		if ($mode == 'edit' && (!isset($data['post_approved']) || !isset($data['topic_approved']) || $data['post_approved'] === false || $data['topic_approved'] === false))
		{
			$sql = 'SELECT p.post_approved, t.topic_type, t.topic_replies, t.topic_replies_real, t.topic_approved
				FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
				WHERE t.topic_id = p.topic_id
					AND p.post_id = ' . $data['post_id'];
			$result = $db->sql_query($sql);
			$topic_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$data['topic_approved'] = $topic_row['topic_approved'];
			$data['post_approved'] = $topic_row['post_approved'];
		}

		// Start the transaction here
		$db->sql_transaction('begin');


		// Collect Information
		switch ($post_mode)
		{
			case 'post':
			case 'reply':
				$sql_data[POSTS_TABLE]['sql'] = array(
					'forum_id'			=> ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id'],
					'poster_id'			=> (int) $mx_user->data['user_id'],
					'icon_id'			=> $data['icon_id'],
					'poster_ip'			=> $mx_user->ip,
					'post_time'			=> $current_time,
					'post_approved'		=> (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? 0 : 1,
					'enable_bbcode'		=> $data['enable_bbcode'],
					'enable_smilies'	=> $data['enable_smilies'],
					'enable_magic_url'	=> $data['enable_urls'],
					'enable_sig'		=> $data['enable_sig'],
					'post_username'		=> (!$mx_user->data['is_registered']) ? $mx_username : '',
					'post_subject'		=> $subject,
					'post_text'			=> $data['message'],
					'post_checksum'		=> $data['message_md5'],
					'post_attachment'	=> (!empty($data['attachment_data'])) ? 1 : 0,
					'bbcode_bitfield'	=> $data['bbcode_bitfield'],
					'bbcode_uid'		=> $data['bbcode_uid'],
					'post_postcount'	=> ($phpbb_auth->acl_get('f_postcount', $data['forum_id'])) ? 1 : 0,
					'post_edit_locked'	=> $data['post_edit_locked']
				);
			break;

			case 'edit_first_post':
			case 'edit':

			case 'edit_last_post':
			case 'edit_topic':

				// If edit reason is given always display edit info

				// If editing last post then display no edit info
				// If m_edit permission then display no edit info
				// If normal edit display edit info

				// Display edit info if edit reason given or user is editing his post, which is not the last within the topic.
				if ($data['post_edit_reason'] || (!$phpbb_auth->acl_get('m_edit', $data['forum_id']) && ($post_mode == 'edit' || $post_mode == 'edit_first_post')))
				{
					$sql_data[POSTS_TABLE]['sql'] = array(
						'post_edit_time'	=> $current_time,
						'post_edit_reason'	=> $data['post_edit_reason'],
						'post_edit_user'	=> (int) $data['post_edit_user'],
					);

					$sql_data[POSTS_TABLE]['stat'][] = 'post_edit_count = post_edit_count + 1';
				}

				// If the person editing this post is different to the one having posted then we will add a log entry stating the edit
				// Could be simplified by only adding to the log if the edit is not tracked - but this may confuse admins/mods
				if ($mx_user->data['user_id'] != $poster_id)
				{
					$log_subject = ($subject) ? $subject : $data['topic_title'];
					add_log('mod', $data['forum_id'], $data['topic_id'], 'LOG_POST_EDITED', $log_subject, (!empty($mx_username)) ? $mx_username : $mx_user->lang['GUEST']);
				}

				if (!isset($sql_data[POSTS_TABLE]['sql']))
				{
					$sql_data[POSTS_TABLE]['sql'] = array();
				}

				$sql_data[POSTS_TABLE]['sql'] = array_merge($sql_data[POSTS_TABLE]['sql'], array(
					'forum_id'			=> ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id'],
					'poster_id'			=> $data['poster_id'],
					'icon_id'			=> $data['icon_id'],
					'post_approved'		=> (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? 0 : $data['post_approved'],
					'enable_bbcode'		=> $data['enable_bbcode'],
					'enable_smilies'	=> $data['enable_smilies'],
					'enable_magic_url'	=> $data['enable_urls'],
					'enable_sig'		=> $data['enable_sig'],
					'post_username'		=> ($mx_username && $data['poster_id'] == ANONYMOUS) ? $mx_username : '',
					'post_subject'		=> $subject,
					'post_checksum'		=> $data['message_md5'],
					'post_attachment'	=> (!empty($data['attachment_data'])) ? 1 : 0,
					'bbcode_bitfield'	=> $data['bbcode_bitfield'],
					'bbcode_uid'		=> $data['bbcode_uid'],
					'post_edit_locked'	=> $data['post_edit_locked'])
				);

				if ($update_message)
				{
					$sql_data[POSTS_TABLE]['sql']['post_text'] = $data['message'];
				}

			break;
		}

		$post_approved = $sql_data[POSTS_TABLE]['sql']['post_approved'];
		$topic_row = array();

		// And the topic ladies and gentlemen
		switch ($post_mode)
		{
			case 'post':
				$sql_data[TOPICS_TABLE]['sql'] = array(
					'topic_poster'				=> (int) $mx_user->data['user_id'],
					'topic_time'				=> $current_time,
					'forum_id'					=> ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id'],
					'icon_id'					=> $data['icon_id'],
					'topic_approved'			=> (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? 0 : 1,
					'topic_title'				=> $subject,
					'topic_first_poster_name'	=> (!$mx_user->data['is_registered'] && $mx_username) ? $mx_username : (($mx_user->data['user_id'] != ANONYMOUS) ? $mx_user->data['username'] : ''),
					'topic_first_poster_colour'	=> $mx_user->data['user_colour'],
					'topic_type'				=> $topic_type,
					'topic_time_limit'			=> ($topic_type == POST_STICKY || $topic_type == POST_ANNOUNCE) ? ($data['topic_time_limit'] * 86400) : 0,
					'topic_attachment'			=> (!empty($data['attachment_data'])) ? 1 : 0,
				);

				if (isset($poll['poll_options']) && !empty($poll['poll_options']))
				{
					$sql_data[TOPICS_TABLE]['sql'] = array_merge($sql_data[TOPICS_TABLE]['sql'], array(
						'poll_title'		=> $poll['poll_title'],
						'poll_start'		=> ($poll['poll_start']) ? $poll['poll_start'] : $current_time,
						'poll_max_options'	=> $poll['poll_max_options'],
						'poll_length'		=> ($poll['poll_length'] * 86400),
						'poll_vote_change'	=> $poll['poll_vote_change'])
					);
				}

				$sql_data[USERS_TABLE]['stat'][] = "user_lastpost_time = $current_time" . (($phpbb_auth->acl_get('f_postcount', $data['forum_id'])) ? ', user_posts = user_posts + 1' : '');

				if ($topic_type != POST_GLOBAL)
				{
					if ($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id']))
					{
						$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts + 1';
					}
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_topics_real = forum_topics_real + 1' . (($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? ', forum_topics = forum_topics + 1' : '');
				}
			break;

			case 'reply':
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_replies_real = topic_replies_real + 1, topic_bumped = 0, topic_bumper = 0' . (($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? ', topic_replies = topic_replies + 1' : '') . ((!empty($data['attachment_data']) || (isset($data['topic_attachment']) && $data['topic_attachment'])) ? ', topic_attachment = 1' : '');

				$sql_data[USERS_TABLE]['stat'][] = "user_lastpost_time = $current_time" . (($phpbb_auth->acl_get('f_postcount', $data['forum_id'])) ? ', user_posts = user_posts + 1' : '');

				if (($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id'])) && $topic_type != POST_GLOBAL)
				{
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts + 1';
				}
			break;

			case 'edit_topic':
			case 'edit_first_post':

				$sql_data[TOPICS_TABLE]['sql'] = array(
					'forum_id'					=> ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id'],
					'icon_id'					=> $data['icon_id'],
					'topic_approved'			=> (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id'])) ? 0 : $data['topic_approved'],
					'topic_title'				=> $subject,
					'topic_first_poster_name'	=> $mx_username,
					'topic_type'				=> $topic_type,
					'topic_time_limit'			=> ($topic_type == POST_STICKY || $topic_type == POST_ANNOUNCE) ? ($data['topic_time_limit'] * 86400) : 0,
					'poll_title'				=> (isset($poll['poll_options'])) ? $poll['poll_title'] : '',
					'poll_start'				=> (isset($poll['poll_options'])) ? (($poll['poll_start']) ? $poll['poll_start'] : $current_time) : 0,
					'poll_max_options'			=> (isset($poll['poll_options'])) ? $poll['poll_max_options'] : 1,
					'poll_length'				=> (isset($poll['poll_options'])) ? ($poll['poll_length'] * 86400) : 0,
					'poll_vote_change'			=> (isset($poll['poll_vote_change'])) ? $poll['poll_vote_change'] : 0,

					'topic_attachment'			=> (!empty($data['attachment_data'])) ? 1 : (isset($data['topic_attachment']) ? $data['topic_attachment'] : 0),
				);

				// Correctly set back the topic replies and forum posts... only if the topic was approved before and now gets disapproved
				if (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id']) && $data['topic_approved'])
				{
					// Do we need to grab some topic informations?
					if (!sizeof($topic_row))
					{
						$sql = 'SELECT topic_type, topic_replies, topic_replies_real, topic_approved
							FROM ' . TOPICS_TABLE . '
							WHERE topic_id = ' . $data['topic_id'];
						$result = $db->sql_query($sql);
						$topic_row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);
					}

					// If this is the only post remaining we do not need to decrement topic_replies.
					// Also do not decrement if first post - then the topic_replies will not be adjusted if approving the topic again.

					// If this is an edited topic or the first post the topic gets completely disapproved later on...
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_topics = forum_topics - 1';
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts - ' . ($topic_row['topic_replies'] + 1);

					set_config('num_topics', $config['num_topics'] - 1, true);
					set_config('num_posts', $config['num_posts'] - ($topic_row['topic_replies'] + 1), true);
				}

			break;

			case 'edit':
			case 'edit_last_post':

				// Correctly set back the topic replies and forum posts... but only if the post was approved before.
				if (!$phpbb_auth->acl_get('f_noapprove', $data['forum_id']) && !$phpbb_auth->acl_get('m_approve', $data['forum_id']) && $data['post_approved'])
				{
					$sql_data[TOPICS_TABLE]['stat'][] = 'topic_replies = topic_replies - 1';
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts - 1';

					set_config('num_posts', $config['num_posts'] - 1, true);
				}

			break;
		}

		// Submit new topic
		if ($post_mode == 'post')
		{
			$sql = 'INSERT INTO ' . TOPICS_TABLE . ' ' .
				$db->sql_build_array('INSERT', $sql_data[TOPICS_TABLE]['sql']);
			$db->sql_query($sql);

			$data['topic_id'] = $db->sql_nextid();

			$sql_data[POSTS_TABLE]['sql'] = array_merge($sql_data[POSTS_TABLE]['sql'], array(
				'topic_id' => $data['topic_id'])
			);
			unset($sql_data[TOPICS_TABLE]['sql']);
		}

		// Submit new post
		if ($post_mode == 'post' || $post_mode == 'reply')
		{
			if ($post_mode == 'reply')
			{
				$sql_data[POSTS_TABLE]['sql'] = array_merge($sql_data[POSTS_TABLE]['sql'], array(
					'topic_id' => $data['topic_id'])
				);
			}

			$sql = 'INSERT INTO ' . POSTS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_data[POSTS_TABLE]['sql']);
			$db->sql_query($sql);
			$data['post_id'] = $db->sql_nextid();

			if ($post_mode == 'post')
			{
				$sql_data[TOPICS_TABLE]['sql'] = array(
					'topic_first_post_id'		=> $data['post_id'],
					'topic_last_post_id'		=> $data['post_id'],
					'topic_last_post_time'		=> $current_time,
					'topic_last_poster_id'		=> (int) $mx_user->data['user_id'],
					'topic_last_poster_name'	=> (!$mx_user->data['is_registered'] && $mx_username) ? $mx_username : (($mx_user->data['user_id'] != ANONYMOUS) ? $mx_user->data['username'] : ''),
					'topic_last_poster_colour'	=> $mx_user->data['user_colour'],
				);
			}

			unset($sql_data[POSTS_TABLE]['sql']);
		}

		$make_global = false;

		// Are we globalising or unglobalising?
		if ($post_mode == 'edit_first_post' || $post_mode == 'edit_topic')
		{
			if (!sizeof($topic_row))
			{
				$sql = 'SELECT topic_type, topic_replies, topic_replies_real, topic_approved, topic_last_post_id
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . $data['topic_id'];
				$result = $db->sql_query($sql);
				$topic_row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}

			// globalise/unglobalise?
			if (($topic_row['topic_type'] != POST_GLOBAL && $topic_type == POST_GLOBAL) || ($topic_row['topic_type'] == POST_GLOBAL && $topic_type != POST_GLOBAL))
			{
				if (!empty($sql_data[FORUMS_TABLE]['stat']) && implode('', $sql_data[FORUMS_TABLE]['stat']))
				{
					$db->sql_query('UPDATE ' . FORUMS_TABLE . ' SET ' . implode(', ', $sql_data[FORUMS_TABLE]['stat']) . ' WHERE forum_id = ' . $data['forum_id']);
				}

				$make_global = true;
				$sql_data[FORUMS_TABLE]['stat'] = array();
			}

			// globalise
			if ($topic_row['topic_type'] != POST_GLOBAL && $topic_type == POST_GLOBAL)
			{
				// Decrement topic/post count
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts - ' . ($topic_row['topic_replies_real'] + 1);
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_topics_real = forum_topics_real - 1' . (($topic_row['topic_approved']) ? ', forum_topics = forum_topics - 1' : '');

				// Update forum_ids for all posts
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET forum_id = 0
					WHERE topic_id = ' . $data['topic_id'];
				$db->sql_query($sql);
			}
			// unglobalise
			else if ($topic_row['topic_type'] == POST_GLOBAL && $topic_type != POST_GLOBAL)
			{
				// Increment topic/post count
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_posts = forum_posts + ' . ($topic_row['topic_replies_real'] + 1);
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_topics_real = forum_topics_real + 1' . (($topic_row['topic_approved']) ? ', forum_topics = forum_topics + 1' : '');

				// Update forum_ids for all posts
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET forum_id = ' . $data['forum_id'] . '
					WHERE topic_id = ' . $data['topic_id'];
				$db->sql_query($sql);
			}
		}

		// Update the topics table
		if (isset($sql_data[TOPICS_TABLE]['sql']))
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_data[TOPICS_TABLE]['sql']) . '
				WHERE topic_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}

		// Update the posts table
		if (isset($sql_data[POSTS_TABLE]['sql']))
		{
			$sql = 'UPDATE ' . POSTS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_data[POSTS_TABLE]['sql']) . '
				WHERE post_id = ' . $data['post_id'];
			$db->sql_query($sql);
		}

		// Update Poll Tables
		if (isset($poll['poll_options']) && !empty($poll['poll_options']))
		{
			$cur_poll_options = array();

			if ($poll['poll_start'] && $mode == 'edit')
			{
				$sql = 'SELECT *
					FROM ' . POLL_OPTIONS_TABLE . '
					WHERE topic_id = ' . $data['topic_id'] . '
					ORDER BY poll_option_id';
				$result = $db->sql_query($sql);

				$cur_poll_options = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$cur_poll_options[] = $row;
				}
				$db->sql_freeresult($result);
			}

			$sql_insert_ary = array();
			for ($i = 0, $size = sizeof($poll['poll_options']); $i < $size; $i++)
			{
				if (trim($poll['poll_options'][$i]))
				{
					if (empty($cur_poll_options[$i]))
					{
						// If we add options we need to put them to the end to be able to preserve votes...
						$sql_insert_ary[] = array(
							'poll_option_id'	=> (int) sizeof($cur_poll_options) + 1 + sizeof($sql_insert_ary),
							'topic_id'			=> (int) $data['topic_id'],
							'poll_option_text'	=> (string) $poll['poll_options'][$i]
						);
					}
					else if ($poll['poll_options'][$i] != $cur_poll_options[$i])
					{
						$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . "
							SET poll_option_text = '" . $db->sql_escape($poll['poll_options'][$i]) . "'
							WHERE poll_option_id = " . $cur_poll_options[$i]['poll_option_id'] . '
								AND topic_id = ' . $data['topic_id'];
						$db->sql_query($sql);
					}
				}
			}

			$db->sql_multi_insert(POLL_OPTIONS_TABLE, $sql_insert_ary);

			if (sizeof($poll['poll_options']) < sizeof($cur_poll_options))
			{
				$sql = 'DELETE FROM ' . POLL_OPTIONS_TABLE . '
					WHERE poll_option_id >= ' . sizeof($poll['poll_options']) . '
						AND topic_id = ' . $data['topic_id'];
				$db->sql_query($sql);
			}

			// If edited, we would need to reset votes (since options can be re-ordered above, you can't be sure if the change is for changing the text or adding an option
			if ($mode == 'edit' && sizeof($poll['poll_options']) != sizeof($cur_poll_options))
			{
				$db->sql_query('DELETE FROM ' . POLL_VOTES_TABLE . ' WHERE topic_id = ' . $data['topic_id']);
				$db->sql_query('UPDATE ' . POLL_OPTIONS_TABLE . ' SET poll_option_total = 0 WHERE topic_id = ' . $data['topic_id']);
			}
		}

		// Submit Attachments
		if (!empty($data['attachment_data']) && $data['post_id'] && in_array($mode, array('post', 'reply', 'quote', 'edit')))
		{
			$space_taken = $files_added = 0;
			$orphan_rows = array();

			foreach ($data['attachment_data'] as $pos => $attach_row)
			{
				$orphan_rows[(int) $attach_row['attach_id']] = array();
			}

			if (sizeof($orphan_rows))
			{
				$sql = 'SELECT attach_id, filesize, physical_filename
					FROM ' . ATTACHMENTS_TABLE . '
					WHERE ' . $db->sql_in_set('attach_id', array_keys($orphan_rows)) . '
						AND is_orphan = 1
						AND poster_id = ' . $mx_user->data['user_id'];
				$result = $db->sql_query($sql);

				$orphan_rows = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$orphan_rows[$row['attach_id']] = $row;
				}
				$db->sql_freeresult($result);
			}

			foreach ($data['attachment_data'] as $pos => $attach_row)
			{
				if ($attach_row['is_orphan'] && !in_array($attach_row['attach_id'], array_keys($orphan_rows)))
				{
					continue;
				}

				if (!$attach_row['is_orphan'])
				{
					// update entry in db if attachment already stored in db and filespace
					$sql = 'UPDATE ' . ATTACHMENTS_TABLE . "
						SET attach_comment = '" . $db->sql_escape($attach_row['attach_comment']) . "'
						WHERE attach_id = " . (int) $attach_row['attach_id'] . '
							AND is_orphan = 0';
					$db->sql_query($sql);
				}
				else
				{
					// insert attachment into db
					if (!@file_exists($phpbb_root_path . $config['upload_path'] . '/' . basename($orphan_rows[$attach_row['attach_id']]['physical_filename'])))
					{
						continue;
					}

					$space_taken += $orphan_rows[$attach_row['attach_id']]['filesize'];
					$files_added++;

					$attach_sql = array(
						'post_msg_id'		=> $data['post_id'],
						'topic_id'			=> $data['topic_id'],
						'is_orphan'			=> 0,
						'poster_id'			=> $poster_id,
						'attach_comment'	=> $attach_row['attach_comment'],
					);

					$sql = 'UPDATE ' . ATTACHMENTS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $attach_sql) . '
						WHERE attach_id = ' . $attach_row['attach_id'] . '
							AND is_orphan = 1
							AND poster_id = ' . $mx_user->data['user_id'];
					$db->sql_query($sql);
				}
			}

			if ($space_taken && $files_added)
			{
				set_config('upload_dir_size', $config['upload_dir_size'] + $space_taken, true);
				set_config('num_files', $config['num_files'] + $files_added, true);
			}
		}

		// we need to update the last forum information
		// only applicable if the topic is not global and it is approved
		// we also check to make sure we are not dealing with globaling the latest topic (pretty rare but still needs to be checked)
		if ($topic_type != POST_GLOBAL && !$make_global && ($post_approved || !$data['post_approved']))
		{
			// the last post makes us update the forum table. This can happen if...
			// We make a new topic
			// We reply to a topic
			// We edit the last post in a topic and this post is the latest in the forum (maybe)
			// We edit the only post in the topic
			// We edit the first post in the topic and all the other posts are not approved
			if (($post_mode == 'post' || $post_mode == 'reply') && $post_approved)
			{
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = ' . $data['post_id'];
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($subject) . "'";
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = ' . $current_time;
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = ' . (int) $mx_user->data['user_id'];
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape((!$mx_user->data['is_registered'] && $mx_username) ? $mx_username : (($mx_user->data['user_id'] != ANONYMOUS) ? $mx_user->data['username'] : '')) . "'";
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($mx_user->data['user_colour']) . "'";
			}
			else if ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies']))
			{
				// this does not _necessarily_ mean that we must update the info again,
				// it just means that we might have to
				$sql = 'SELECT forum_last_post_id, forum_last_post_subject
					FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . (int) $data['forum_id'];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				// this post is the latest post in the forum, better update
				if ($row['forum_last_post_id'] == $data['post_id'])
				{
					if ($post_approved && $row['forum_last_post_subject'] !== $subject)
					{
						// the only data that can really be changed is the post's subject
						$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_subject = \'' . $db->sql_escape($subject) . '\'';
					}
					else if ($data['post_approved'] !== $post_approved)
					{
						// we need a fresh change of socks, everything has become invalidated
						$sql = 'SELECT MAX(topic_last_post_id) as last_post_id
							FROM ' . TOPICS_TABLE . '
							WHERE forum_id = ' . (int) $data['forum_id'] . '
								AND topic_approved = 1';
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						// any posts left in this forum?
						if (!empty($row['last_post_id']))
						{
							$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.user_id, u.username, u.user_colour
								FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
								WHERE p.poster_id = u.user_id
									AND p.post_id = ' . (int) $row['last_post_id'];
							$result = $db->sql_query($sql);
							$row = $db->sql_fetchrow($result);
							$db->sql_freeresult($result);

							// salvation, a post is found! jam it into the forums table
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == ANONYMOUS) ? $row['post_username'] : $row['username']) . "'";
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
						}
						else
						{
							// just our luck, the last topic in the forum has just been turned unapproved...
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = 0';
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = ''";
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = 0';
							$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = 0';
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = ''";
							$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = ''";
						}
					}
				}
			}
		}
		else if ($make_global)
		{
			// somebody decided to be a party pooper, we must recalculate the whole shebang (maybe)
			$sql = 'SELECT forum_last_post_id
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . (int) $data['forum_id'];
			$result = $db->sql_query($sql);
			$forum_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// we made a topic global, go get new data
			if ($topic_row['topic_type'] != POST_GLOBAL && $topic_type == POST_GLOBAL && $forum_row['forum_last_post_id'] == $topic_row['topic_last_post_id'])
			{
				// we need a fresh change of socks, everything has become invalidated
				$sql = 'SELECT MAX(topic_last_post_id) as last_post_id
					FROM ' . TOPICS_TABLE . '
					WHERE forum_id = ' . (int) $data['forum_id'] . '
						AND topic_approved = 1';
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				// any posts left in this forum?
				if (!empty($row['last_post_id']))
				{
					$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.user_id, u.username, u.user_colour
						FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
						WHERE p.poster_id = u.user_id
							AND p.post_id = ' . (int) $row['last_post_id'];
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// salvation, a post is found! jam it into the forums table
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == ANONYMOUS) ? $row['post_username'] : $row['username']) . "'";
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
				}
				else
				{
					// just our luck, the last topic in the forum has just been globalized...
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = 0';
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = ''";
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = 0';
					$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = 0';
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = ''";
					$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = ''";
				}
			}
			else if ($topic_row['topic_type'] == POST_GLOBAL && $topic_type != POST_GLOBAL && $forum_row['forum_last_post_id'] < $topic_row['topic_last_post_id'])
			{
				// this post has a higher id, it is newer
				$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.user_id, u.username, u.user_colour
					FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
					WHERE p.poster_id = u.user_id
						AND p.post_id = ' . (int) $topic_row['topic_last_post_id'];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				// salvation, a post is found! jam it into the forums table
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_id = ' . (int) $row['post_id'];
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_post_time = ' . (int) $row['post_time'];
				$sql_data[FORUMS_TABLE]['stat'][] = 'forum_last_poster_id = ' . (int) $row['poster_id'];
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == ANONYMOUS) ? $row['post_username'] : $row['username']) . "'";
				$sql_data[FORUMS_TABLE]['stat'][] = "forum_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
			}
		}

		// topic sync time!
		// simply, we update if it is a reply or the last post is edited
		if ($post_approved)
		{
			// reply requires the whole thing
			if ($post_mode == 'reply')
			{
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_post_id = ' . (int) $data['post_id'];
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_poster_id = ' . (int) $mx_user->data['user_id'];
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_poster_name = '" . $db->sql_escape((!$mx_user->data['is_registered'] && $mx_username) ? $mx_username : (($mx_user->data['user_id'] != ANONYMOUS) ? $mx_user->data['username'] : '')) . "'";
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_poster_colour = '" . (($mx_user->data['user_id'] != ANONYMOUS) ? $db->sql_escape($mx_user->data['user_colour']) : '') . "'";
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($subject) . "'";
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_post_time = ' . (int) $current_time;
			}
			else if ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies']))
			{
				// only the subject can be changed from edit
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($subject) . "'";
			}
		}
		else if (!$data['post_approved'] && ($post_mode == 'edit_last_post' || $post_mode == 'edit_topic' || ($post_mode == 'edit_first_post' && !$data['topic_replies'])))
		{
			// like having the rug pulled from under us
			$sql = 'SELECT MAX(post_id) as last_post_id
				FROM ' . POSTS_TABLE . '
				WHERE topic_id = ' . (int) $data['topic_id'] . '
					AND post_approved = 1';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// any posts left in this forum?
			if (!empty($row['last_post_id']))
			{
				$sql = 'SELECT p.post_id, p.post_subject, p.post_time, p.poster_id, p.post_username, u.user_id, u.username, u.user_colour
					FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
					WHERE p.poster_id = u.user_id
						AND p.post_id = ' . (int) $row['last_post_id'];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				// salvation, a post is found! jam it into the topics table
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_post_id = ' . (int) $row['post_id'];
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_post_subject = '" . $db->sql_escape($row['post_subject']) . "'";
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_post_time = ' . (int) $row['post_time'];
				$sql_data[TOPICS_TABLE]['stat'][] = 'topic_last_poster_id = ' . (int) $row['poster_id'];
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_poster_name = '" . $db->sql_escape(($row['poster_id'] == ANONYMOUS) ? $row['post_username'] : $row['username']) . "'";
				$sql_data[TOPICS_TABLE]['stat'][] = "topic_last_poster_colour = '" . $db->sql_escape($row['user_colour']) . "'";
			}
		}

		// Update total post count, do not consider moderated posts/topics
		if ($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id']))
		{
			if ($post_mode == 'post')
			{
				set_config('num_topics', $config['num_topics'] + 1, true);
				set_config('num_posts', $config['num_posts'] + 1, true);
			}

			if ($post_mode == 'reply')
			{
				set_config('num_posts', $config['num_posts'] + 1, true);
			}
		}

		// Update forum stats
		$where_sql = array(POSTS_TABLE => 'post_id = ' . $data['post_id'], TOPICS_TABLE => 'topic_id = ' . $data['topic_id'], FORUMS_TABLE => 'forum_id = ' . $data['forum_id'], USERS_TABLE => 'user_id = ' . $mx_user->data['user_id']);

		foreach ($sql_data as $table => $update_ary)
		{
			if (isset($update_ary['stat']) && implode('', $update_ary['stat']))
			{
				$sql = "UPDATE $table SET " . implode(', ', $update_ary['stat']) . ' WHERE ' . $where_sql[$table];
				$db->sql_query($sql);
			}
		}

		// Delete topic shadows (if any exist). We do not need a shadow topic for an global announcement
		if ($make_global)
		{
			$sql = 'DELETE FROM ' . TOPICS_TABLE . '
				WHERE topic_moved_id = ' . $data['topic_id'];
			$db->sql_query($sql);
		}

		// Committing the transaction before updating search index
		$db->sql_transaction('commit');

		// Delete draft if post was loaded...
		$draft_id = phpBB3::request_var('draft_loaded', 0);
		if ($draft_id)
		{
			$sql = 'DELETE FROM ' . DRAFTS_TABLE . "
				WHERE draft_id = $draft_id
					AND user_id = {$mx_user->data['user_id']}";
			$db->sql_query($sql);
		}

		// Index message contents
		if ($update_message && $data['enable_indexing'])
		{
			// Select the search method and do some additional checks to ensure it can actually be utilised
			$search_type = basename($config['search_type']);

			if (!file_exists($phpbb_root_path . 'includes/search/' . $search_type . '.' . $phpEx))
			{
				trigger_error('NO_SUCH_SEARCH_MODULE');
			}

			if (!class_exists($search_type))
			{
				include("{$phpbb_root_path}includes/search/$search_type.$phpEx");
			}

			$error = false;
			$search = new $search_type($error);

			if ($error)
			{
				trigger_error($error);
			}

			$search->index($mode, $data['post_id'], $data['message'], $subject, $poster_id, ($topic_type == POST_GLOBAL) ? 0 : $data['forum_id']);
		}

		// Topic Notification, do not change if moderator is changing other users posts...
		if ($mx_user->data['user_id'] == $poster_id)
		{
			if (!$data['notify_set'] && $data['notify'])
			{
				$sql = 'INSERT INTO ' . TOPICS_WATCH_TABLE . ' (user_id, topic_id)
					VALUES (' . $mx_user->data['user_id'] . ', ' . $data['topic_id'] . ')';
				$db->sql_query($sql);
			}
			else if ($data['notify_set'] && !$data['notify'])
			{
				$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
					WHERE user_id = ' . $mx_user->data['user_id'] . '
						AND topic_id = ' . $data['topic_id'];
				$db->sql_query($sql);
			}
		}

		if ($mode == 'post' || $mode == 'reply' || $mode == 'quote')
		{
			// Mark this topic as posted to
			phpBB3::markread('post', $data['forum_id'], $data['topic_id'], $data['post_time']);
		}

		// Mark this topic as read
		// We do not use post_time here, this is intended (post_time can have a date in the past if editing a message)
		phpBB3::markread('topic', $data['forum_id'], $data['topic_id'], time());

		//
		if ($config['load_db_lastread'] && $mx_user->data['is_registered'])
		{
			$sql = 'SELECT mark_time
				FROM ' . FORUMS_TRACK_TABLE . '
				WHERE user_id = ' . $mx_user->data['user_id'] . '
					AND forum_id = ' . $data['forum_id'];
			$result = $db->sql_query($sql);
			$f_mark_time = (int) $db->sql_fetchfield('mark_time');
			$db->sql_freeresult($result);
		}
		else if ($config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			$f_mark_time = false;
		}

		if (($config['load_db_lastread'] && $mx_user->data['is_registered']) || $config['load_anon_lastread'] || $mx_user->data['is_registered'])
		{
			// Update forum info
			$sql = 'SELECT forum_last_post_time
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $data['forum_id'];
			$result = $db->sql_query($sql);
			$forum_last_post_time = (int) $db->sql_fetchfield('forum_last_post_time');
			$db->sql_freeresult($result);

			phpBB3::update_forum_tracking_info($data['forum_id'], $forum_last_post_time, $f_mark_time, false);
		}

		// Send Notifications
		if ($mode != 'edit' && $mode != 'delete' && ($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id'])))
		{
			phpBB3::user_notification($mode, $subject, $data['topic_title'], $data['forum_name'], $data['forum_id'], $data['topic_id'], $data['post_id']);
		}
		/*
		$params = $add_anchor = '';

		if ($phpbb_auth->acl_get('f_noapprove', $data['forum_id']) || $phpbb_auth->acl_get('m_approve', $data['forum_id']))
		{
			$params .= '&amp;t=' . $data['topic_id'];

			if ($mode != 'post')
			{
				$params .= '&amp;p=' . $data['post_id'];
				$add_anchor = '#p' . $data['post_id'];
			}
		}
		else if ($mode != 'post' && $post_mode != 'edit_first_post' && $post_mode != 'edit_topic')
		{
			$params .= '&amp;t=' . $data['topic_id'];
		}

		$url = (!$params) ? "{$phpbb_root_path}viewforum.$phpEx" : "{$phpbb_root_path}viewtopic.$phpEx";
		$url = mx3_append_sid($url, 'f=' . $data['forum_id'] . $params) . $add_anchor;
		*/
		return $data['topic_id'];
	}	
	
	/**
	 * Delete a post/poll.
	 *
	 * @param unknown_type $forum_id
	 * @param unknown_type $topic_id
	 * @param unknown_type $post_id
	 */
	function delete_phpbb_post($forum_id, $topic_id, $post_id)
	{
		global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
		global $userdata, $user_ip;
		
		$current_time = time();

		// Correctly set back the topic replies and forum posts... 
		$topic_update_sql = 'topic_replies = topic_replies - 1';
		$forum_update_sql = 'forum_posts = forum_posts - 1';
		//set_config_count('num_posts', -1, true);
		$user_update_sql = 'user_posts = user_posts - 1';
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			case 'phpbb2':
					
			break;

			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':		
				$topic_update_sql .= ', topic_last_view_time = ' . $current_time;
			break;
		}
		

		//
		// is this first topic post or last topic post
		//
		$sql = "SELECT topic_first_post_id, topic_last_post_id
		   		FROM " . TOPICS_TABLE . "
		   		WHERE topic_id = '$topic_id'";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain first_post_id data", '', __LINE__, __FILE__, $sql );
		}

		$row_tmp = $db->sql_fetchrow( $result );
		$first_post_id = $row_tmp['topic_first_post_id'];
		$last_post_id = $row_tmp['topic_last_post_id'];

		$is_first_post = ($first_post_id == $post_id) ? true : false;
		$is_last_post = ($last_post_id == $post_id) ? true : false;

		// Start delete
		$sql = "DELETE FROM " . POSTS_TABLE . "
			WHERE post_id = $post_id";

		if (!$db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}
		
		switch (PORTAL_BACKEND)
		{
			case 'internal':
			case 'smf2':
			case 'mybb':
			break;
			
			case 'phpbb2':

				$sql = "DELETE FROM " . POSTS_TEXT_TABLE . "
					WHERE post_id = $post_id";
				if (!$db->sql_query($sql))
				{
					mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}					
			break;

			case 'phpbb3':
			case 'olympus':
			case 'ascraeus':
			case 'rhea':
			break;
		}

		if ($is_last_post && $is_first_post)
		{
			$sql = "DELETE FROM " . TOPICS_TABLE . "
				WHERE topic_id = $topic_id
					OR topic_moved_id = $topic_id";

			if (!$db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
				WHERE topic_id = $topic_id";

			if (!$db->sql_query($sql))
			{
				mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}
		}

		remove_search_post($post_id);


		if ($is_last_post)
		{
			//Topic 
			$sql = "SELECT MAX(post_id) AS last_post_id
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$topic_update_sql .= ', topic_last_post_id = ' . $row['last_post_id'];
			}
			//Forums
			$sql = "SELECT MAX(post_id) AS last_post_id
				FROM " . POSTS_TABLE . "
				WHERE forum_id = $forum_id";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$forum_update_sql .= ($row['last_post_id']) ? ', forum_last_post_id = ' . $row['last_post_id'] : ', forum_last_post_id = 0';
			}
			
		}
		elseif ($is_first_post)
		{
			$sql = "SELECT MIN(post_id) AS first_post_id
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $topic_id";

			if (!($result = $db->sql_query($sql)))
			{
				mx_message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$topic_update_sql .= ', topic_first_post_id = ' . $row['first_post_id'];
			}
		}

		$sql = "UPDATE " . FORUMS_TABLE . " SET
			$forum_update_sql
			WHERE forum_id = $forum_id";

		if (!$db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " SET
				$topic_update_sql
				WHERE topic_id = " . $topic_id;

		if (!$db->sql_query($sql))
		{
			//mx_message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_posts = user_posts - 1
			WHERE user_id = " . $userdata['user_id'];

		if (!$db->sql_query($sql))
		{
			mx_message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $topic_id
	 */
	function delete_phpbb_topic($topic_id)
	{
		global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
		global $userdata, $user_ip;

		$sql = "SELECT *
		   		FROM " . POSTS_TABLE . "
		   		WHERE topic_id = '$topic_id'";

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain topic data", '', __LINE__, __FILE__, $sql );
		}

		while( $row = $db->sql_fetchrow( $result ) )
		{
			$this->delete_phpbb_post($row['forum_id'], $row['topic_id'], $row['post_id']);
		}
	}
}

/**
 * Generic Comments Class
 *
 */
class mx_comments extends phpbb_posts
{
	//
	// Comments
	//
	var $cid = ''; // comment id
	var $comments_type = ''; // internal or phpbb

	//
	// phpBB comments
	//
	var $forum_id = '';
	var $topic_id = '';

	//
	// Module vars
	//
	var $cat_id = '';
	var $item_id = ''; // Article or file id etc

	var $allow_wysiwyg = false;

	var $allow_comment_wysiwyg = false;
	var $allow_comment_bbcode = true;
	var $allow_comment_html = true;
	var $allow_comment_smilies = false;
	var $allow_comment_links = false;
	var $allow_comment_images = false;

	var $no_comment_image_message = '';
	var $no_comment_link_message = '';

	var $max_comment_subject_chars = '50';
	var $max_comment_chars = '400';
	var $split_key = '<!-- split -->';

	var $formatting_comment_truncate_links = false;
	var $formatting_comment_image_resize = 0;
	var $formatting_comment_wordwrap = false;

	var $images = array('icon_minipost'=>'', 'comment_post'=>'', 'icon_edit'=>'', 'icon_delpost'=>'');

	var $u_post = '';
	var $u_delete = '';
	var $u_edit = '';
	var $u_more = '';
	var $u_pagination = '';

	//
	// General
	//
	var $auth = array();

	var $pagination_action = '';
	var $pagination_target = '';

	var $comments_table = ''; // eg KB_COMMENTS_TABLE
	var $comments_table_parent_key = ''; // eg article_id

	var $start = 0;
	var $pagination_num = 5; // number of comments per page
	var $total_comments = ''; // total number of comments

	var $comments_row = array();

	/**
	 * Dummy entry. To be used by the extended comments class
	 *
	 */
	function init($item_data, $comments_type = 'internal')
	{
		return false;
	}

	/**
	 * Dummy entry. To be used by the extended comments class
	 *
	 * @param unknown_type $ranks
	 */
	function obtain_ranks( &$ranks )
	{
		global $db, $mx_cache;

		if (PORTAL_BACKEND != 'internal')
		{
			if ($mx_cache->exists('ranks'))
			{
				$ranks = $mx_cache->get('ranks');
			}
			else
			{
				$sql = "SELECT *
					FROM " . RANKS_TABLE . "
					ORDER BY rank_special, rank_min";

				if (!( $result = $db->sql_query($sql)))
				{
					mx_message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
				}

				$ranks = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$ranks[] = $row;
				}

				$db->sql_freeresult($result);
				$mx_cache->put('ranks', $ranks);
			}
		}
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function u_post()
	{
		global $mx_request_vars;
		$more = $mx_request_vars->is_request('virtual') ? '&virtual=' . $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : '';
		return mx_append_sid($this->u_post . $more);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cid
	 * @return unknown
	 */
	function u_edit($cid)
	{
		global $mx_request_vars;
		$more = $mx_request_vars->is_request('virtual') ? '&virtual=' . $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : '';
		return mx_append_sid($this->u_edit . '&cid='.$cid .$more);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cid
	 * @return unknown
	 */
	function u_delete($cid)
	{
		global $mx_request_vars;
		$more = $mx_request_vars->is_request('virtual') ? '&virtual=' . $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : '';
		return mx_append_sid($this->u_delete . '&cid='.$cid .$more);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cid
	 * @return unknown
	 */
	function u_more($cid)
	{
		global $mx_request_vars;
		$more = $mx_request_vars->is_request('virtual') ? '&virtual=' . $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : '';
		return mx_append_sid($this->u_more . '&cid='.$cid .$more);
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $page_num
	 * @return unknown
	 */
	function u_pagination($page_num)
	{
		global $mx_request_vars;
		$more = $mx_request_vars->is_request('virtual') ? '&virtual=' . $mx_request_vars->request('virtual', MX_TYPE_INT, 0) : '';
		return $this->u_pagination . $page_num . $more;
	}

	/**
	 * Get all internal comments.
	 *
	 */
	function display_comments()
	{
		switch ($this->comments_type)
		{
			case 'internal':
				$this->display_internal_comments();
			break;

			case 'phpbb':
				$this->display_phpbb_comments();
			break;

			default:
			mx_message_die(GENERAL_ERROR, 'Bad display comment arg');
		}
	}

	/**
	 * Get all internal comments.
	 *
	 */
	function display_internal_comments()
	{
		global $template, $lang, $board_config, $phpEx, $db, $userdata, $images, $mx_user;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $phpEx, $mx_request_vars, $portal_config;

		//
		// Request vars
		//
		$this->start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
		$page_num = $mx_request_vars->get('page_num', MX_TYPE_INT, '');
		$virtual_id = $mx_request_vars->get('virtual', MX_TYPE_INT, 0);

		//
		// Toggles
		//
		$bbcode_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_bbcode ? true : false) : false;
		$html_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_html ? true : false) : true;
		$smilies_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_smilies ? true : false) : false;

		//
		// page number (only used for bugs)
		//
		if ( !empty( $page_num ) )
		{
			$page_num = "&page_num=" . ( $page_num + 1 ) ;
		}
		else
		{
			$page_num = '';
		}

		//
		// Instantiate the mx_text and mx_text_formatting classes
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on); // Note: allowed_html_tags is altered above
		$mx_text->allow_all_html_tags = $this->allow_wysiwyg ? true : false;

		$mx_text_formatting = new mx_text_formatting();

		$template->assign_block_vars( 'use_comments', array(
			'L_COMMENTS' => $lang['Comments'],
		));

		//
		// Get all comments
		//
		$result = $this->get_internal_comments();

		$ranksrow = array();
		$this->obtain_ranks( $ranksrow );

		while ( $this->comments_row = $db->sql_fetchrow( $result ) )
		{
			$time = phpBB2::create_date( $board_config['default_dateformat'], $this->comments_row['comments_time'], $board_config['board_timezone'] );

			//
			// Decode comment for display
			//
			$comments_title = $mx_text->display_simple($this->comments_row['comments_title']);
			$comments_text = $mx_text->display($this->comments_row['comments_text'], $this->comments_row['comment_bbcode_uid']);

			//
			// Remove Images and/or links
			//
			if (!$this->allow_comment_images || !$this->allow_comment_links)
			{
				$comments_text = $mx_text_formatting->remove_images_links( $comments_text, $this->allow_comment_images, $this->no_comment_image_message, $this->allow_comment_links, $this->no_comment_link_message );
			}

			$poster = ( $this->comments_row['user_id'] == ANONYMOUS ) ? $lang['Guest'] : $this->comments_row['username'];
			$poster_avatar = '';

			if ( $this->comments_row['user_avatar_type'] && $poster_id != ANONYMOUS && $this->comments_row['user_allowavatar'] )
			{
				switch ( $this->comments_row['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_path'] . '/' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
					case USER_AVATAR_REMOTE:
						$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
					case USER_AVATAR_GALLERY:
						$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				}
			}

			//
			// Generate ranks, set them to empty string initially.
			//
			$poster_rank = '';
			$rank_image = '';
			if ( $this->comments_row['user_id'] == ANONYMOUS )
			{
			}
			else if ( $this->comments_row['user_rank'] )
			{
				for( $j = 0; $j < count( $ranksrow ); $j++ )
				{
					if ( $this->comments_row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $phpbb_root_path . RANKS_PATH . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}
			else
			{
				for( $j = 0; $j < count( $ranksrow ); $j++ )
				{
					if ( $this->comments_row['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $phpbb_root_path . RANKS_PATH . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}

			//
			// Text formatting
			//
			if ( $this->max_comment_subject_chars > 0 )
			{
				$comments_title = $mx_text_formatting->truncate_text( $comments_title, $this->max_comment_subject_chars, true );
			}

			if ( $this->max_comment_chars > 0 )
			{
				//$comments_text = $mx_text_formatting->truncate_text( $comments_text, $this->max_comment_chars, true );
				$comments_text = $mx_text_formatting->split_text( $comments_text, $this->max_comment_chars, true, $this->split_key );
			}

			if ( $this->formatting_comment_truncate_links || $this->formatting_comment_image_resize > 0 || $this->formatting_comment_wordwrap )
			{
				$comments_text = $mx_text_formatting->decode( $comments_text, $this->formatting_comment_truncate_links, intval($this->formatting_comment_image_resize), $this->formatting_comment_wordwrap );
			}

			$template->assign_block_vars( 'use_comments.text', array(
				'CID' => $this->comments_row['comments_id'],
				'L_POSTED' => $lang['Posted'],
				'L_COMMENT_SUBJECT' => $lang['Comment_subject'],
				'L_COMMENTS_NAME' => $lang['Name'],
				'POSTER' => $poster,
				'ICON_MINIPOST_IMG' => $this->images['icon_minipost'],
				'ICON_SPACER' => $images['mx_spacer'],
				'POSTER_RANK' => $poster_rank,
				'RANK_IMAGE' => $rank_image,
				'POSTER_AVATAR' => $poster_avatar,
				'TITLE' => $comments_title,
				'TIME' => $time,
				'TEXT' => $comments_text
			));

			if ( ( $this->auth['auth_edit'] && $this->comments_row['user_id'] == $userdata['user_id'] ) || $this->auth['auth_mod'] )
			{
				$template->assign_block_vars( 'use_comments.text.auth_edit', array(
					'L_COMMENT_EDIT' => $lang['Comment_edit'],
					'U_COMMENT_EDIT' => $this->u_edit($this->comments_row['comments_id']),
					'EDIT_IMG' => $this->images['icon_edit'],
					'B_EDIT_IMG' => $mx_user->create_button($this->images['icon_edit'], $lang['Comment_edit'], $this->u_edit($this->comments_row['comments_id'])),
				));
			}

			if ( ( $this->auth['auth_delete'] && $this->comments_row['user_id'] == $userdata['user_id'] ) || $this->auth['auth_mod'] )
			{
				$template->assign_block_vars( 'use_comments.text.auth_delete', array(
					'L_COMMENT_DELETE' => $lang['Comment_delete'],
					'U_COMMENT_DELETE' => $this->u_delete($this->comments_row['comments_id']),
					'DELETE_IMG' => $this->images['icon_delpost'],
					'B_DELETE_IMG' => $mx_user->create_button($this->images['icon_delpost'], $lang['Comment_delete'], $this->u_delete($this->comments_row['comments_id'])),
				));
			}

			if ( !empty($this->u_more) )
			{
				$template->assign_block_vars( 'use_comments.text.more', array(
					'L_COMMENT_MORE' => $lang['Comment_more'],
					'U_COMMENT_MORE' => $this->u_more($this->comments_row['comments_id']),
				));
			}
		}

		if ( ( $this->auth['auth_post'] ) || $this->auth['auth_mod'] )
		{
			$template->assign_block_vars( 'use_comments.auth_post', array(
				'L_COMMENT_ADD' => $lang['Comment_add'],
				'U_COMMENT_POST' => $this->u_post(),
				'REPLY_IMG' => $this->images['comment_post'],
				'B_REPLY_IMG' => $mx_user->create_button($this->images['comment_post'], $lang['Comment_add'], $this->u_post()),
			));
		}

		$num_of_replies = intval( $this->total_comments );
		//$pagination = phpBB2::generate_pagination( $this->u_pagination($page_num), $num_of_replies, $this->pagination_num, $this->start ) . '&nbsp;';
		$pagination = mx_generate_pagination( $this->u_pagination($page_num), $num_of_replies, $this->pagination_num, $this->start, true, true, true, false ) . '&nbsp;';
		if ($num_of_replies > 0)
		{
			$template->assign_block_vars( 'use_comments.comments_pag', array(
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $this->start / $this->pagination_num ) + 1 ), ceil( $num_of_replies / $this->pagination_num ) ),
				'L_GOTO_PAGE' => $lang['Goto_page'],
			));
		}

		$db->sql_freeresult( $result );
	}

	/**
	 * Get all phpBB comments in the comments topic.
	 *
	 */
	function display_phpbb_comments( )
	{
		global $template, $lang, $board_config, $phpEx, $db, $userdata, $images, $mx_user;
		global $mx_root_path, $module_root_path, $phpbb_root_path, $is_block, $phpEx, $mx_request_vars, $portal_config;

		if ( !isset($this->topic_id) || $this->topic_id < 0 )
		{
			mx_message_die(GENERAL_MESSAGE, 'no or bad topic id');
		}

		//
		// Ensure Item data topic_id is valid
		//
		$this->validate_topic_id();

		//
		// Request vars
		//
		$this->start = $mx_request_vars->get('start', MX_TYPE_INT, 0);
		$page_num = $mx_request_vars->get('page_num', MX_TYPE_INT, '');
		$virtual_id = $mx_request_vars->get('virtual', MX_TYPE_INT, 0);

		//
		// Toggles
		//
		$bbcode_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_bbcode ? true : false) : false;
		$html_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_html ? true : false) : true;
		$smilies_on = !$this->allow_comment_wysiwyg ? ($this->allow_comment_smilies ? true : false) : false;

		//
		// page number (only used for kb articles)
		//
		if ( !empty( $page_num ) )
		{
			$page_num = "&page_num=" . ( $page_num + 1 ) ;
		}
		else
		{
			$page_num = '';
		}

		//
		// Instantiate the mx_text and mx_text_formatting classes
		//
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on); // Note: allowed_html_tags is altered above
		$mx_text->allow_all_html_tags = $this->allow_wysiwyg ? true : false;

		$mx_text_formatting = new mx_text_formatting();

		$template->assign_block_vars( 'use_comments', array(
			'L_COMMENTS' => $lang['Comments'],
		));

		//
		// Get all comments
		//
		$result = $this->get_phpbb_comments();

		$ranksrow = array();
		$this->obtain_ranks( $ranksrow );

		while ( $this->comments_row = $db->sql_fetchrow( $result ) )
		{
			$poster_id = $this->comments_row['user_id'];
			$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $this->comments_row['username'];
			$time = phpBB2::create_date( $board_config['default_dateformat'], $this->comments_row['post_time'], $board_config['board_timezone'] );
			$poster_posts = ( $this->comments_row['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $this->comments_row['user_posts'] : '';
			$poster_from = ( $this->comments_row['user_from'] && $this->comments_row['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $this->comments_row['user_from'] : '';
			$poster_joined = ( $this->comments_row['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . phpBB2::create_date( $lang['DATE_FORMAT'], $this->comments_row['user_regdate'], $board_config['board_timezone'] ) : '';

			//
			// Handle anon users posting with usernames
			//
			if ( $poster_id == ANONYMOUS && $this->comments_row['post_username'] != '' )
			{
				$poster = $this->comments_row['post_username'];
				$poster_rank = $lang['Guest'];
			}

			//
			// Decode comment for display
			//
			$comments_title = $mx_text->display_simple($this->comments_row['post_subject']);
			$comments_text = $mx_text->display($this->comments_row['post_text'], $this->comments_row['bbcode_uid']);
			$user_sig = $mx_text->display($this->comments_row['user_sig'], $this->comments_row['user_sig_bbcode_uid']);

			//
			// Remove Images and/or links
			//
			if (!$this->allow_comment_images || !$this->allow_comment_links)
			{
				$comments_text = $mx_text_formatting->remove_images_links( $comments_text, $this->allow_comment_images, $this->no_comment_image_message, $this->allow_comment_links, $this->no_comment_link_message );
			}

			//
			// Text formatting
			//
			if ( $this->max_comment_subject_chars > 0 )
			{
				$comments_title = $mx_text_formatting->truncate_text( $comments_title, $this->max_comment_subject_chars, true );
			}

			if ( $this->max_comment_chars > 0 )
			{
				$comments_text = $mx_text_formatting->truncate_text( $comments_text, $this->max_comment_chars, true );
			}

			if ( $this->formatting_comment_truncate_links || $this->formatting_comment_image_resize > 0 || $this->formatting_comment_wordwrap )
			{
				$comments_text = $mx_text_formatting->decode( $comments_text, $this->formatting_comment_truncate_links, intval($this->formatting_comment_image_resize), $this->formatting_comment_wordwrap );
			}

			//
			// Editing information
			//
			if ( $this->comments_row['post_edit_count'] )
			{
				$l_edit_time_total = ( $this->comments_row['post_edit_count'] == 1 ) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];

				$l_edited_by = '<br /><br />' . sprintf( $l_edit_time_total, $poster, phpBB2::create_date( $board_config['default_dateformat'], $this->comments_row['post_edit_time'], $board_config['board_timezone'] ), $this->comments_row['post_edit_count'] );
			}
			else
			{
				$l_edited_by = '';
			}

			$poster_avatar = '';

			if ( $this->comments_row['user_avatar_type'] && $poster_id != ANONYMOUS && $this->comments_row['user_allowavatar'] )
			{
				switch ( $this->comments_row['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_path'] . '/' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
					case USER_AVATAR_REMOTE:
						$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
					case USER_AVATAR_GALLERY:
						$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $this->comments_row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				}
			}

			//
			// Generate ranks, set them to empty string initially.
			//
			$poster_rank = '';
			$rank_image = '';
			if ( $this->comments_row['user_id'] == ANONYMOUS )
			{
			}
			else if ( $this->comments_row['user_rank'] )
			{
				for( $j = 0; $j < count( $ranksrow ); $j++ )
				{
					if ( $this->comments_row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $phpbb_root_path . RANKS_PATH . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}
			else
			{
				for( $j = 0; $j < count( $ranksrow ); $j++ )
				{
					if ( $this->comments_row['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $phpbb_root_path . RANKS_PATH . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}

			$template->assign_block_vars( 'use_comments.text', array(
				'CID' => $this->comments_row['post_id'],
				'L_POSTED' => $lang['Posted'],
				'L_COMMENT_SUBJECT' => $lang['Comment_subject'],
				'L_COMMENTS_NAME' => $lang['Name'],
				'POSTER' => $poster,
				'ICON_MINIPOST_IMG' => $this->images['icon_minipost'],
				'ICON_SPACER' => $images['mx_spacer'],
				'POSTER_RANK' => $poster_rank,
				'RANK_IMAGE' => $rank_image,
				'POSTER_AVATAR' => $poster_avatar,
				'TITLE' => $comments_title,
				'TIME' => $time,
				'TEXT' => $comments_text
			));

			if ( ( $this->auth['auth_edit'] && $this->comments_row['user_id'] == $userdata['user_id'] ) || $this->auth['auth_mod'] )
			{
				$template->assign_block_vars( 'use_comments.text.auth_edit', array(
					'L_COMMENT_EDIT' => $lang['Comment_edit'],
					'U_COMMENT_EDIT' => $this->u_edit($this->comments_row['post_id']),
					'EDIT_IMG' => $this->images['icon_edit'],
					'B_EDIT_IMG' => $mx_user->create_button($this->images['icon_edit'], $lang['Comment_edit'], $this->u_edit($this->comments_row['post_id'])),
				));
			}

			if ( ( $this->auth['auth_delete'] && $this->comments_row['user_id'] == $userdata['user_id'] ) || $this->auth['auth_mod'] )
			{
				$template->assign_block_vars( 'use_comments.text.auth_delete', array(
					'L_COMMENT_DELETE' => $lang['Comment_delete'],
					'U_COMMENT_DELETE' => $this->u_delete($this->comments_row['post_id']),
					'DELETE_IMG' => $this->images['icon_delpost'],
					'B_DELETE_IMG' => $mx_user->create_button($this->images['icon_delpost'], $lang['Comment_delete'], $this->u_delete($this->comments_row['post_id'])),
				));
			}

		}

		if ( ( $this->auth['auth_post'] ) || $this->auth['auth_mod'] )
		{
			$template->assign_block_vars( 'use_comments.auth_post', array(
				'L_COMMENT_ADD' => $lang['Comment_add'],
				'U_COMMENT_POST' => $this->u_post(),
				'REPLY_IMG' => $this->images['comment_post'],
				'B_REPLY_IMG' => $mx_user->create_button($this->images['comment_post'], $lang['Comment_add'], $this->u_post()),
			));
		}

		$num_of_replies = intval( $this->total_comments );
		$pagination = phpBB2::generate_pagination( $this->u_pagination($page_num), $num_of_replies, $this->pagination_num, $this->start ) . '&nbsp;';

		if ($num_of_replies > 0)
		{
			$template->assign_block_vars( 'use_comments.comments_pag', array(
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf( $lang['Page_of'], ( floor( $this->start / $this->pagination_num ) + 1 ), ceil( $num_of_replies / $this->pagination_num ) ),
				'L_GOTO_PAGE' => $lang['Goto_page'],
			));
		}

		$db->sql_freeresult( $result );
	}

	/**
	 * Enter description here...
	 *
	 */
	function get_internal_comments()
	{
		global $db, $template, $lang;

		$sql = "SELECT COUNT(".$this->table_field_id.") AS number
			FROM " . $this->comments_table . "
			WHERE ".$this->table_field_id." = " . $this->item_id;

		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not obtain number of comments", '', __LINE__, __FILE__, $sql);
		}

		$this->total_comments = ( $row = $db->sql_fetchrow($result) ) ? intval($row['number']) : 0;

		$sql = 'SELECT c.*, u.*
			FROM ' . $this->comments_table . ' AS c
				LEFT JOIN ' . USERS_TABLE . " AS u ON c.poster_id = u.user_id
			WHERE c.".$this->table_field_id." = '" . $this->item_id . "'
			ORDER BY c.comments_id DESC";

		if ( $this->start > -1 && $this->pagination_num > 0 )
		{
			$sql .= " LIMIT $this->start, $this->pagination_num ";
		}

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, 'Couldnt select comments', '', __LINE__, __FILE__, $sql );
		}

		if ( !( $comment_number = $db->sql_numrows( $result ) ) )
		{
			$template->assign_block_vars( 'use_comments.no_comments', array(
				'L_NO_COMMENTS' => $lang['No_comments'],
			));
		}

		return $result;
	}

	/**
	 * Enter description here...
	 *
	 */
	function get_phpbb_comments()
	{
		global $db, $template, $lang;

		$sql = "SELECT COUNT(post_id) AS number
			FROM " . POSTS_TABLE . "
			WHERE topic_id = " . $this->topic_id;

		if ( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Could not obtain number of comments", '', __LINE__, __FILE__, $sql);
		}

		$this->total_comments = ( $row = $db->sql_fetchrow($result) ) ? intval($row['number']) : 0;


		//
		// Go ahead and pull all data for this topic
		//
		$sql = "SELECT u.*, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
			FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . ((PORTAL_BACKEND == 'phpbb2') ? POSTS_TEXT_TABLE : POSTS_TABLE) . " pt
			WHERE p.topic_id = '" . $this->topic_id . "'
				AND pt.post_id = p.post_id
				AND u.user_id = p.poster_id
				ORDER BY p.post_id DESC";

		if ( $this->start > -1 && $this->pagination_num > 0 )
		{
			$sql .= " LIMIT $this->start, $this->pagination_num ";
		}

		if ( !( $result = $db->sql_query( $sql ) ) )
		{
			mx_message_die( GENERAL_ERROR, "Could not obtain post/user information.", '', __LINE__, __FILE__, $sql );
		}

		if ( !( $comment_number = $db->sql_numrows( $result ) ) )
		{
			$template->assign_block_vars( 'use_comments.no_comments', array(
				'L_NO_COMMENTS' => $lang['No_comments'],
			));
		}

		return $result;
	}

	/**
	 * Enter description here...
	 *
	 */
	function validate_topic_id()
	{
		global $db;

		//
		// Validate the $this->topic_id value
		//
		$sql = "SELECT COUNT(*) AS total FROM " . TOPICS_TABLE . " WHERE topic_id = " . $this->topic_id;
		if( !($result = $db->sql_query($sql)) )
		{
			mx_message_die(GENERAL_ERROR, "Couldn't get block/Column information", '', __LINE__, __FILE__, $sql);
		}
		$count = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($count['total'] == 0 )
		{
			//
			// Update item with new topic_id
			//
			$sql = "UPDATE " . $this->item_table . "
				SET topic_id = '0'
			    WHERE ".$this->table_field_id." = ". $this->item_id;

			if ( !( $result = $db->sql_query( $sql ) ) )
			{
				mx_message_die( GENERAL_ERROR, 'Couldnt update item', '', __LINE__, __FILE__, $sql );
			}

			$db->sql_freeresult( $result );

			$this->topic_id = 0;
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $mode
	 * @param unknown_type $cid
	 * @param unknown_type $title
	 * @param unknown_type $comments_text
	 * @param unknown_type $user_id
	 * @param unknown_type $username
	 * @param unknown_type $user_attach_sig
	 * @param unknown_type $title_first
	 * @param unknown_type $comments_text_first
	 * @param unknown_type $comment_bbcode_uid
	 * @return unknown
	 */
	function post( $mode, $cid, $title = '', $comments_text = '', $user_id = '', $username = '', $user_attach_sig = '', $title_first = '', $comments_text_first = '', $comment_bbcode_uid = '')
	{
		$this->validate_topic_id();

		switch ($mode)
		{
			case 'delete_all':
				$return_data = $this->delete_phpbb_topic($this->topic_id );
				$this->validate_topic_id();
			break;

			case 'delete':
				$return_data = $this->delete_phpbb_post($this->forum_id, $this->topic_id, $cid );
				$this->validate_topic_id();
			break;

			case 'insert':
				$return_data = $this->insert_phpbb_post( $title, $comments_text, $this->forum_id, $user_id, $username, $user_attach_sig, $this->topic_id, '',  $title_first, $comments_text_first, $comment_bbcode_uid );
			break;

			case 'update':
				$return_data = $this->insert_phpbb_post( $title, $comments_text, $this->forum_id, $user_id, $username, $user_attach_sig, $this->topic_id, $cid, $title_first, $comments_text_first, $comment_bbcode_uid );
			break;

			default:
				mx_message_die(GENERAL_ERROR, 'bad post mode');
		}

		return $return_data;
	}
}

/**
 * Class: debug.
 *
 * Borrowed class from pl.gosu.php
 *
 * @package Tools
 * @author pl.gosu.php
 * @access public
 */
class debug
{
	/**
	 * pl.gosu.php/debug/printR.php
	 * created 2005-06-18 modified 2006-06-04
	 *
	 * @param unknown_type $var
	 */
	function printR($var)
	{
		while (ob_get_level())
		{
			ob_end_clean();
		}
		if (func_num_args() > 1)
		{
			$var = func_get_args();
		}

		echo '<pre>';
		$trace = array_shift((debug_backtrace()));
		echo "<b>Debugging <font color=red>".basename($trace['file'])."</font> on line <font color=red>{$trace['line']}</font></b>:\r\n";
		$file = file($trace['file']);
		echo "<div style='background: #f5f5f5; padding: 0.2em 0em;'>".htmlspecialchars($file[$trace['line']-1])."</div>\r\n";
		echo '<b>Type</b>: '.gettype($var)."\r\n";
		if (is_string($var))
		{
			echo "<b>Length</b>: ".strlen($var)."\r\n";
		}
		if (is_array($var))
		{
			echo "<b>Length</b>: ".count($var)."\r\n";
		}
		echo '<b>Value</b>: ';
		if (is_string($var))
		{
			echo htmlspecialchars($var);
		}
		else
		{
			$print_r = print_r($var, true);
			// str_contains < or >
			if ((strstr($print_r, '<') !== false) || (strstr($print_r, '>') !== false))
			{
				$print_r = htmlspecialchars($print_r);
			}
			echo $print_r;
		}
		echo '</pre>';
		exit;
	}
}
?>
