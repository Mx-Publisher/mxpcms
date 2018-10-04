<?php
/**
*
* @package MX-Publisher Module - mx_coreblocks
* @version $Id: mx_includex.php,v 1.15 2008/10/04 07:04:38 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.mx-publisher.com
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

$iframe_mode = $mx_block->get_parameters( 'x_mode' );

$x_mode = ( ($iframe_mode == 'x_listen') ? $mx_request_vars->get('x_mode', MX_TYPE_NO_TAGS, $iframe_mode) : $iframe_mode );

$x_1 = ( $iframe_mode == 'x_listen' ? $mx_request_vars->get('x_1', MX_TYPE_NO_TAGS, $mx_block->get_parameters('x_1')) : $mx_block->get_parameters( 'x_1' ));
$x_2 = ( $iframe_mode == 'x_listen' ? $mx_request_vars->get('x_2', MX_TYPE_NO_TAGS, $mx_block->get_parameters('x_2')) : $mx_block->get_parameters( 'x_2' ));
$x_3 = ( $iframe_mode == 'x_listen' ? $mx_request_vars->get('x_3', MX_TYPE_NO_TAGS, $mx_block->get_parameters('x_3')) : $mx_block->get_parameters( 'x_3' ));

//
// Start output of page
//
$template->set_filenames(array(
	'includex_block' => 'mx_includex.tpl')
);

$template->assign_vars(array(
	'BLOCK_SIZE' => ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' => ( !empty($lang[$title]) ? $lang[$title] : $title )
));

switch( $x_mode )
{
	case 'x_listen':		// Listen
		break;

	case 'x_iframe':		// Iframe
		$file_url = $x_1;

		if ( substr_count($file_url, 'http://') == 0 )
		{
			$file_url = PORTAL_URL . $file_url;
		}

		$template->assign_block_vars('iframe_mode', array(
			'FILE_URL' => $file_url,
			'IFRAME_HEIGHT' => $x_2
		));
		break;

	case 'x_textfile':		// Textfile
		$file = $x_1;
		ob_start();
		@readfile($mx_root_path . $file);
		$file_contents = ob_get_contents();
		ob_clean();

		$template->assign_block_vars('textfile_mode', array(
			'FILE_CONTENTS' => $file_contents
		));
		break;

	case 'x_multimedia':	// Multimedia
		$template->assign_block_vars('multimedia_mode', array(
			'MEDIA_URL' => PORTAL_URL . $x_1,
			'WIDTH' => !empty($x_2) ? 'width="'.$x_2.'"' : '',
			'HEIGHT' => !empty($x_3) ? 'height="'.$x_3.'"' : ''
		));
		break;

	case 'x_pic':			// Pic
		$template->assign_block_vars('pic_mode', array(
			'FILE_CONTENTS' => $file_contents
		));
		break;

	case 'x_format':		// Formatted file
		// not ready ;) do nothing
		break;

	default:				// Hidden
		$mx_block->show_title = false;
		$mx_block->show_block = false;
		return;
}

$template->pparse('includex_block');
?>