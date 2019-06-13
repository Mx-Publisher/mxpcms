<?php
 
if( !defined('IN_PORTAL') || !is_object($mx_block))
{

	define('IN_PORTAL', true);

	$mx_root_path = "../../";
	$module_root_path = "./";

	$phpEx = substr(strrchr(__FILE__, '.'), 1); 
	include_once($mx_root_path . 'common.'.$phpEx);

	//
	// Start session management
	//
	$mx_user->init($user_ip, PAGE_INDEX);
	//
	// End session management
	//

	$title = 'Media Player Radio';
	$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '315' );
	$is_block = FALSE;
}
else
{
	//
	// Read block Configuration
	//

	$title = $mx_block->block_info['block_title'];
	$block_size = ( isset($block_size) && !empty($block_size) ? $block_size : '100%' );

	if( is_object($mx_block))
	{
		$is_block = TRUE;
	}
}

define('IN_SHOTCAST', true);
require($module_root_path .'includes/common.'.$phpEx);
require($module_root_path . 'getinfo.'.$phpEx);

?>
<HTML>
<HEAD>
  <META http-equiv="pragma" content="no-cache">
  <META HTTP-EQUIV="refresh" CONTENT="60">
  <META name="robots" content="noindex">
<script>
<!--

/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/

//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
var limit="0:60"

if (document.images){
var parselimit=limit.split(":")
parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
if (!document.images)
return
if (parselimit==1)
window.location.reload()
else{ 
parselimit-=1
curmin=Math.floor(parselimit/60)
cursec=parselimit%60
if (curmin!=0)
curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
else
curtime=cursec+" seconds left until page refresh!"
window.status=curtime
setTimeout("beginrefresh()",1000)
}
}

window.onload=beginrefresh
//-->
</script>  
</HEAD>
<body>
<?php
if($radio->song())
{
	echo '<span style="font-weight : bold;">'.$radio->song().'</span>';
}
else
{
	echo '<span style="font-weight : bold;">'.$song[0].'</span>';
}
?>
</body>
</HTML>