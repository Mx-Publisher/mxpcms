<?php
/** 
*
* @package phpBB2
* @version $Id: profile_clocks.php,v 1.1 2013/04/26 14:11:51 orynider Exp $
* @copyright (c) 2001 The phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
	
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);
//
// End session management
//

if ( !$userdata['session_logged_in'] )
{
	redirect("login.".$phpEx."?redirect=profile.".$phpEx."&mode=editprofile&ucp=preferences"); 
	exit; 
}


//
// Read a listing of uploaded clocks ...
//
$dir = @opendir($phpbb_root_path . 'images/clock/');
while($file = @readdir($dir))
{
	if( !@is_dir(phpbb_realpath($phpbb_root_path . 'images/clock/' . $file)) )
	{
		if ($file == "." || $file == ".." || $file == "index.htm" || $file == "index.html" || $file == "Thumbs.db")
		{
			continue;
		}
		$clock[] = $file;
	}
}
@closedir($dir);
sort($clock);


//
// Format the clocks into table for display ...
//
$max_cols = 4;
$max_rows = ( (sizeof($clock) -  1) / $max_cols );
$max_rows = ( $max_rows * $max_cols == sizeof($clock) ) ? $max_rows : $max_rows + 1;
$k = 0;
$clocks = '<table width="100%" cellpadding="4" cellspacing="1" align="center">';
for ($i=1; $i <= $max_rows; $i++)
{
	$clocks .= '<tr>';
	for ($j=0; $j < $max_cols; $j++)
	{
		if ( $k < sizeof($clock))
		{
			$clocks .= '<td align="center" valign="top"><embed src="' . $phpbb_root_path . 'images/clock/' . $clock[$k] . '" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100" height="100"></embed><br />' . str_replace('.swf', '', $clock[$k]) . '</td>';
		}
		$k++;
	}
	$clocks .= '</tr>';
}
$clocks .= '</table>';


//
// Generate page ...
//
$gen_simple_header = TRUE; 
$page_title = $lang['Clock_format']; 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

$template->assign_vars(array( 
      'L_CLOSE_WINDOW' => $lang['Close_window'], 
      'L_MESSAGE' => $clocks)
); 

$template->set_filenames(array( 
      'body' => 'privmsgs_popup.tpl')
); 

$template->pparse('body'); 

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>