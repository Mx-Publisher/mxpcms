<?php
/**
*
* @package MX-Publisher Module - mx_clock
* @version $Id: mx_clock.php,v 1.12 2013/07/04 00:38:34 orynider Exp $
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
$digest_time_zone = $mx_block->get_parameters('digest_time_zone') ? $mx_block->get_parameters('digest_time_zone') : 'system'; //get time zone from server or local client system
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

$now_time = time();

$user_now_time = $now_time + $mx_user->timezone + $mx_user->dst;
//$user_tz_date = phpBB3::create_date('a', $user_now_time, $mx_user->data['user_timezone']);

// Check user dateformat for output
$twelve_hours = (strpos($mx_user->data['user_dateformat'], 'g') || strpos($mx_user->data['user_dateformat'], 'h')) ? true : 0;
$am_pm = (strpos($mx_user->data['user_dateformat'], 'a') || strpos($mx_user->data['user_dateformat'], 'A')) ? true : 0;

$zone_offset = (int) $mx_user->timezone + (int) $mx_user->dst;

$sign = ($zone_offset < 0) ? '-' : '+';
$time_offset = abs($zone_offset);

$offset_seconds	= $time_offset % 3600;
$offset_minutes	= $offset_seconds / 60;
$offset_hours	= ($time_offset - $offset_seconds) / 3600;

$offset_string	= sprintf("%s%02d:%02d", $sign, $offset_hours, $offset_minutes);

$user_now_date = gmdate("Y-m-d\TH:i:s", $now_time + $zone_offset) . $offset_string;

$gh = gmdate("H", $now_time + $zone_offset);
$gm = gmdate("i", $now_time + $zone_offset);
	
if($hour_mode == 12)
{
	$s_hours = ($gh < 10) ? '0'.$gh : $gh;
	$am_pm = ( $gh < 12 ) ? $mx_user->lang['AM'] : $mx_user->lang['PM'];
}
else
{
	for ($gh = 0; $gh < (($twelve_hours == true) ? 13 : 24); $gh++)
	{
		$s_hours = ($gh < 10) ? '0'.$gh : $gh;
	}
	$am_pm = "";
}

for ($gm = 0; $gm < 60; $gm++)
{
	$s_minutes = ($gm < 10) ? '0'.$i : $i;
}

if($digest_time_zone == 'server')
{
	$clock_name = $lang['server_time_zone'];
	$clock_swf = PORTAL_URL . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0&ggh='.$gh.'&gid=1&&ggm='.$gm.'&gha=1&fna=&ghb=0&ghf=0'.$clock_gcolor.'&gnu=http://localtimes.info/'.$comunity.'/'.$country.'/'.$province.'/'.$city.'/widget/'; 
}
else
{
	$clock_name = $lang['system_time_zone']; //client_time
	$clock_swf = PORTAL_URL . 'modules/mx_clock/clocks/'. (!empty($flv_file) ? $flv_file : $design . '.swf') . '?rnd=0'. $clock_gcolor; 
}

//
// BEGIN OUTPUT
//
// Europe/Romania/Bucharest/
// asia/Israel/Jerusalem/
//&gbc=0x000000&gfc=0xFF0000&gtc=0xFFFFFF //red
$template->set_filenames(array('body_clock' => 'clock_body.tpl'));
	
$template->assign_vars(array(
	'L_TITLE'	=> ( !empty($title) ? $title : $lang['clock_name']),
	'ONLINEDESIGN' => (!empty($design) ? $design : 'design01'),
	'COMUNITY'	=> ( !empty($comunity) ? $comunity : 'asia' ), //continent=North America
	'COUNTRY'	=> ( !empty($country) ? $country : 'Israel' ), //&country=United States
	'FLAGCODE'	=> ( !empty($country_code) ? $country_code : 'il'),
	'STATE'		=> ( !empty($province) ? $province  : $city), //&province=Massachusetts
	'CITY'		=> ( !empty($city) ? $city : 'Jerusalem' ), //&city=Boston
	'G_HOURS'	=> $gh,
	'G_MINUTES'	=> $gm,
	'GBC'		=> $gbc,
	'GFC'		=> $gfc,
	'GTC'		=> $gtc,	
	'COLOR_MODE'	=> $color_mode,
	'CLOCK_NAME'	=> $clock_name,
	'BLOCK_TITLE'	=> $title,
	'WMODE'		=> $flash_wmode,	
	'CLOCK_SWF'	=> $clock_swf,
	'CLOCK_IMG'	=> PORTAL_URL . 'modules/mx_clock/clocks/'. $flv_img,	
	'CLOCK_URL'	=> 'http://localtimes.info/acsw/design01.swf?ggh=0&gid=0&&ggm=0&rnd=0&gha=0&fna=0&ghb=0&ghf=0&gbc=0x4C2100&gfc=0xFFF6F0&gtc=0x000080&gnu=http://localtimes.info/'.$comunity.'/'.$country.'/'.$province.'/'.$city.'/widget/',
	'FLASH_WIDTH'	=> ( !empty($flash_width) ? $flash_width : '170' ),
	'FLASH_HEIGHT'	=> ( !empty($flash_height) ? $flash_height : '150' ),	
	'BLOCK_SIZE'	=> ( !empty($block_size) ? $block_size : '100%' ),
	'BLOCK_SIZE'	=> ( !empty($block_size) ? $block_size : '100%' )
));

$template->pparse('body_clock');

?>