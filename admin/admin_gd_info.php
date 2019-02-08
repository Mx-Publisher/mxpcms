<?php
/**
*
* @package MX-Publisher Core
* @version $Id$
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
*
* @Extra credits for this file
* Bicet (bicets@gmail.com)
*
*/

define('IN_ICYPHOENIX', true);

if (!empty($setmodules))
{
	$filename = basename(__FILE__);
	$module['4_Panel_system']['GD_Title'] = 'admin/' . $filename;
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if (!defined('PHP_EXT')) define('PHP_EXT', $phpEx);
if (!defined('MX_ROOT_PATH')) define('MX_ROOT_PATH', './../');
require('./pagestart.' . PHP_EXT);

$template->set_filenames(array('body' => 'admin/admin_gd_info_body.' . TPL_EXT));

if (function_exists('gd_info'))
{
	$gd_info_ary = gd_info();
}

$true = '<span style="color:green">' . $lang['GD_True'] . '</span>';
$false = '<span style="color:red">' . $lang['GD_False'] . '</span>';

if (count($gd_info_ary) == 0)
{				
	print_r('v souboryu nic neni');
}
else
{
	$counter = 0;
	//print_r($gd_info_ary);
	foreach($gd_info_ary as $gd_key => $gd_value)
	{				
		if (is_array($gd_value))
		{
			/*Convert the array to a string */
			$gd_value = print_r($gd_value, true);
		}
		
		if (ctype_digit(strval($gd_value)) || empty($gd_value))
		{
			$gd_value = !empty($gd_value) ? $true : $false;
		}
		
		$gd_info_ary[$gd_key] = $gd_value;
	}	
	$template->assign_vars(array( //#
			'VERSION' => $gd_info_ary['GD Version'],
			'FREETYPE_SUPPORT' =>  $gd_info_ary['FreeType Support'],
			'FREETYPE_LINKAGE' => $gd_info_ary['FreeType Linkage'],
			'T1LIB_SUPPORT' => $gd_info_ary['T1Lib Support'],
			'GIF_READ_SUPPORT' => $gd_info_ary['GIF Read Support'],
			'GIF_CREATE_SUPPORT' => $gd_info_ary['GIF Create Support'],
			'JPG_SUPPORT' => $gd_info_ary['JPEG Support'],
			'PNG_SUPPORT' => $gd_info_ary['PNG Support'],
			'WBMP_SUPPORT' => $gd_info_ary['WBMP Support'],
			'XBM_SUPPORT' => $gd_info_ary['XBM Support'],
			'WEBP_SUPPORT' => $gd_info_ary['WebP Support'],
			'JIS_MAPPED_SUPPORT' => $gd_info_ary['JIS-mapped Japanese Font Support'],
		)
	);
	$counter++;
}

$template->assign_vars(array(
	'L_TITLE' => $lang['GD_Title'],
	'L_DESCRIPTION' => $lang['GD_Description'],
	'L_VERSION' => $lang['GD_VERSION'],
	'L_FREETYPE_SUPPORT' => $lang['GD_Freetype_Support'],
	'L_FREETYPE_LINKAGE' => $lang['GD_Freetype_Linkage'],
	'L_T1LIB_SUPPORT' => $lang['GD_T1lib_Support'],
	'L_GIF_READ_SUPPORT' => $lang['GD_Gif_Read_Support'],
	'L_GIF_CREATE_SUPPORT' => $lang['GD_Gif_Create_Support'],
	'L_JPG_SUPPORT' => $lang['GD_Jpg_Support'],
	'L_PNG_SUPPORT' => $lang['GD_Png_Support'],
	'L_WBMP_SUPPORT' => $lang['GD_Wbmp_Support'],
	'L_XBM_SUPPORT' => $lang['GD_XBM_Support'],
	'L_WEBP_SUPPORT' => $lang['GD_WebP_Support'],	
	'L_JIS_MAPPED_SUPPORT' => $lang['GD_Jis_Mapped_Support'],

	)
);
$template->pparse('body');

//
// Send page footer.
//
include_once('./page_footer_admin.' . PHP_EXT);
?>