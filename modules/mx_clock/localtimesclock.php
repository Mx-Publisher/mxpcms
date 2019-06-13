<?php
/**
*
* @package MX-Publisher Module - mx_clock
* @version $Id: localtimesclock.php,v 1.6 2013/04/26 14:11:51 orynider Exp $
* @copyright (c) 2002-2006 [Florin Bodin] mxp-cms team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$flash_width = $mx_block->get_parameters('flash_width');
$flash_height = $mx_block->get_parameters('flash_height');
$hour_mode = $mx_block->get_parameters('hour_mode') ? $mx_block->get_parameters('hour_mode') : '12';
$flv_file = $mx_block->get_parameters('flv_file') ? $mx_block->get_parameters('flv_file') : 'clock.swf';
$flv_img =  $mx_block->get_parameters('flv_img') ? $mx_block->get_parameters('flv_img') : 'clock.swf';
$design = $mx_block->get_parameters('design') ? $mx_block->get_parameters('design') : 'design01';
$localtimes = $mx_block->get_parameters('localtimes') ? $mx_block->get_parameters('localtimes') : 'local'; //us
$digest_time_zone = $mx_block->get_parameters('digest_time_zone') ? $mx_block->get_parameters('digest_time_zone') : 'system'; //get time zone from server or local system
$flash_wmode_trasparent = $mx_block->get_parameters('flash_wmode_trasparent');
$comunity = $mx_block->get_parameters('comunity');
$country_code = $mx_block->get_parameters('country_code');
$country = $mx_block->get_parameters('country');
$province = $mx_block->get_parameters('province');
$city = $mx_block->get_parameters('city');

$gbc = '0x0F0200';
$gfc = '0xFFFFFF';
$gtc = '0x000080';

$gbc = '0xb1b1b1';
$gfc = '0xebebeb';
$gtc = '0x000080';

$bc = 'FFB200';
$fc = '010E54';
$tc = 'F7FAFC';

//$gbc = '0x'.$bc;
//$gfc = '0x'.$fc;
//$gtc = '0x'.$tc;

if($flash_wmode_trasparent == 'normal')
{
	$color_mode = 'bgcolor';
	$flash_wmode = $gfc;
	// $flash_wmode = 'opaque';	
	$clock_gcolor = '&gbc='.$gbc.'&gfc='.$gfc.'&gtc='.$gtc;
}
else
{
	$color_mode = 'wmode';
	$flash_wmode = 'transparent';
	$clock_gcolor = '&gbc='.$gbc.'&gfc='.$gfc;	
}

//&widget_number=110
$widget_nr = substr(strrchr($design, 'design'), 6).'0';

if (!$_GET['print']) // Do not "fix" with reuest wrapper!!
{
	$mx_user->set_module_default_style('_core'); // For compatibility with core 2.8.x
}
//
// Load language files.
//
//$mx_user->set_module_lang_path($module_root_path); //Language File Location
if (is_object($mx_page))
{
	$mx_user->extend(MX_LANG_ALL, MX_IMAGES_NONE);
	$mx_page->add_copyright( 'MXP Media Center Module' );		
}
//$mx_page->add_css_file('mx_clock.css'); // Include style dependent *.css file, eg module_path/template_path/template/theme.css
//$mx_page->add_js_file($module_root_path . 'music_clock/clock.js'); // Relative to module_root

$now_time = time();
$zone_offset = (int) $mx_user->timezone + (int) $mx_user->dst;
$gh = gmdate("H", $now_time + $zone_offset);
$gm = gmdate("i", $now_time + $zone_offset);

if(($digest_time_zone == 'server') && ($flv_file != 'clock.swf'))
{
	$clock_name = $lang['server_time_zone'];
	$clock_swf = 'http://localtimes.info/acsw/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'.$clock_gcolor.'&ggh='.$gh.'&gid=1&&ggm='.$gm.'&rnd=0&gha=1&fna=&ghb=0&ghf=0&gnu=http://localtimes.info/'.$comunity.'/'.$country.'/'.$province.'/'.$city.'/widget/'; 
}
else if(($digest_time_zone == 'server') && ($flv_file == 'clock.swf'))
{
	$clock_name = $lang['server_time_zone'];
	$clock_swf = PORTAL_URL . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0&ggh='.$gh.'&gid=1&&ggm='.$gm.'&gha=1&fna=&ghb=0&ghf=0'.$clock_gcolor.'&gnu=http://localtimes.info/'.$comunity.'/'.$country.'/'.$province.'/'.$city.'/widget/'; 
}
else if(($localtimes == 'local') && ($flv_file != 'clock.swf'))
{
	$clock_name = $lang['system_time_zone']; //client_time
	$clock_swf = 'http://localtimes.info/acsw/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'.$clock_gcolor.'&ggh='.$gh.'&gid=1&&ggm='.$gm.'&rnd=0&gha=1&fna=&ghb=0&ghf=0&gnu=http://localtimes.info/'.$comunity.'/'.$country.'/'.$province.'/'.$city.'/widget/'; 	
}
else if(($localtimes == 'local') && ($flv_file == 'clock.swf'))
{
	$clock_name = $lang['system_time_zone']; //client_time
	$clock_swf = PORTAL_URL . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'. $clock_gcolor; 
}
else if($flv_file != 'clock.swf')
{
	$clock_name = $lang['system_time_zone']; //client_time
	$clock_swf = 'http://localtimes.info/acsw/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'; 
}
else
{
	$clock_name = $lang['system_time_zone']; //client_time
	$clock_swf = PORTAL_URL . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'. $clock_gcolor; 
}

//if(!file_exists($mx_root_path . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf')))
//{
//}

//
// BEGIN OUTPUT
//
// Europe/Romania/Bucharest/
// asia/Israel/Jerusalem/
//&gbc=0x000000&gfc=0xFF0000&gtc=0xFFFFFF //red
$template_tmp = ($localtimes == 'local') ?  array('localtimes_body' => 'localtimesclock.tpl') : array('localtimes_body' => 'ustimesclock.tpl');
$template_tmp = ($localtimes == 'us') ?  array('localtimes_body' => 'ustimesclock.tpl') : array('localtimes_body' => 'localtimesclock.tpl');
$template->set_filenames($template_tmp);
	
$template->assign_vars(array(
	'L_TITLE'	=> (!empty($title) ? $title : $city),
	'WMODE'		=> $flash_wmode,
	'COLOR_MODE'	=> $color_mode,
	'WIDGET_NUMBER'	=> $widget_nr,
	'ONLINEDESIGN' => (!empty($design) ? $design : 'design01'),
	'COMUNITY'	=> ( !empty($comunity) ? $comunity : 'asia' ), //continent=North America
	'FLAGCODE'	=> ( !empty($country_code) ? $country_code : 'il'),	
	'COUNTRY'	=> ( !empty($country) ? $country : 'Israel' ), //&country=United States
	'STATE'		=> ( !empty($province) ? $province  : $city), //&province=Massachusetts
	'CITY'		=> ( !empty($city) ? $city : 'Jerusalem' ), //&city=Boston
	'GBC'		=> $gbc,
	'GFC'		=> $gfc,
	'GTC'		=> $gtc,
	'GF3'		=> $bc,
	'GF2'		=> $fc,
	'GF1'		=> $tc,	
	'CLOCK_NAME'	=> $lang['clock_name'],	
	'CLOCK_SWF'	=> $clock_swf,
	'CLOCK_IMG'	=> PORTAL_URL . 'modules/mx_clock/clocks/'. $flv_img,	
	'CLOCK_URL'	=> $clock_swf,
	'FLASH_WIDTH'	=> ( !empty($flash_width) ? $flash_width : '170' ),
	'FLASH_HEIGHT'	=> ( !empty($flash_height) ? $flash_height : '150' ),	
	'BLOCK_SIZE'	=> ( !empty($block_size) ? $block_size : '100%' ),
	'BLOCK_SIZE'	=> ( !empty($block_size) ? $block_size : '100%' )	
));

$template->pparse('localtimes_body');

?>