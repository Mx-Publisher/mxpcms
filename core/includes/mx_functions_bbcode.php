<?php
/**
*
* @package Functions_phpBB
* @version $Id: mx_functions_bbcode.php,v 1.7 2013/09/04 04:32:03 orynider Exp $
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


class bbcode_base
{

	function bbcode()
	{
		$this->bbcode_uid = $this->make_bbcode_uid();
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
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERID}', '\\1', $bbcode_tpl['ipaper']);		
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERKEY}', '\\2', $bbcode_tpl['ipaper']);			
		$bbcode_tpl['ipaper'] = str_replace('{HEIGHT}', '\\3', $bbcode_tpl['ipaper']);	
		$bbcode_tpl['ipaper'] = str_replace('{WIDTH}', '\\4', $bbcode_tpl['ipaper']);
		$bbcode_tpl['ipaper'] = str_replace('{IPAPERLINK}', $lang['Link'], $bbcode_tpl['ipaper']);
		$bbcode_tpl['scribd'] = str_replace('{SCRIBDURL}', $lang['Link'], $bbcode_tpl['scribd']);
		//Stop more bbcode

		define("BBCODE_TPL_READY", true);

		return $bbcode_tpl;
	}

	/**
	 * Does second-pass bbencoding. This should be used before displaying the message in
	 * a thread. Assumes the message is already first-pass encoded, and we are given the
	 * correct UID as used in first-pass encoding.
	 * This a temporary function
	 */
	function bbencode_second_pass($text, $uid)
	{
		global $lang, $bbcode_tpl;

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

	//phpBB Temporary code ends
	
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
	function decode($bbtext, $bbcode_uid, $smilies_on = true)
	{
		global $mx_root_path, $phpbb_root_path, $phpEx, $mx_page;

		$mytext = stripslashes($bbtext);
		if (!empty($bbcode_uid))
		{
			$mytext = $this->bbencode_second_pass($mytext, $bbcode_uid);
		}
		if ($smilies_on)
		{
			$mytext = $this->smilies_pass($mytext);
		}
		$mytext = str_replace("\n", "\n<br />\n", $mytext);
		return $this->make_clickable($mytext);
	}

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

}
?>