<?php
/**
*
* @package MX-Publisher Module - mx_textblocks
* @version $Id: mx_docembed_code.php,v 3.20 2020/02/24 03:32:09 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if( !defined('IN_PORTAL') || !is_object($mx_block))
{
	die("Hacking attempt");
}

//
// Virtual Blog Mode
//
if ($mx_page->is_virtual)
{
	if ($mx_request_vars->is_request('virtual'))
	{
		$mx_block->virtual_init($mx_request_vars->get('virtual', MX_TYPE_INT, 0), true);
	}
	else
	{
		//$mx_block->show_title = false;
		//$mx_block->show_block = false;
	}
}

//
// Read Block Settings
//
$title = $mx_block->block_info['block_title'];
$b_description = $mx_block->block_info['block_desc'];

//
// Get the current MX page.
//
$page_id = $mx_request_vars->request('page', MX_TYPE_INT, 1);
$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, '');

// check parameter for block count
$doc_ids 		= $mx_block->get_parameters('doc_ids');
$doc_ids 		= preg_match('<,>', $doc_ids) ? explode(',', $doc_ids) : $doc_ids;
$nested_docs_count = sizeof($doc_ids);
$doc_title 		= $mx_block->get_parameters('title');
//$mx_split_block 	= new mx_block();
$host 			= $mx_block->get_parameters('Host');
$doc_hosting_site = (mb_strlen($mx_block->get_parameters('doc_hosting_site')) > 1) ? $mx_block->get_parameters('doc_hosting_site') : $host;
$api_key 		= $mx_block->get_parameters('api_key');
$access_key 	= $mx_block->get_parameters('access_key');
$session_key 	= $mx_block->get_parameters('session_key');
$user_id 		= $mx_block->get_parameters('user_id');
$username 		= $mx_block->get_parameters('username');
$password 		= $mx_block->get_parameters('password');
$admin_user 	= $mx_block->get_parameters('admin_user');
$admin_pass 	= $mx_block->get_parameters('admin_pass');
$secret 		= $mx_block->get_parameters('secret');
$width 			= $mx_block->get_parameters('width');
$height 		= $mx_block->get_parameters('height'); 
//
// Instantiate the mx_text class
//
include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
$mx_text = new mx_text();
$mx_text->init(true, false, false);
if (is_object($mx_page))
{
	// -------------------------------------------------------------------------
	// Extend User Style with module lang and images
	// Usage:  $mx_user->extend(LANG, IMAGES)
	// Switches:
	// - LANG: MX_LANG_MAIN (default), MX_LANG_ADMIN, MX_LANG_ALL, MX_LANG_NONE
	// - IMAGES: MX_IMAGES (default), MX_IMAGES_NONE
	// -------------------------------------------------------------------------
	$mx_user->extend(MX_LANG_MAIN, MX_IMAGES_NONE);
	$mx_page->add_copyright( 'MX-Publisher Text-Blocks Module' );
}
// **********************************************************************
// Read language definition
// **********************************************************************
/* Temp fix for reading other language using extend() 
for Anonymouse users and browser prefered language */
if( !file_exists($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx) )
{
	include($module_root_path . 'language/lang_english/lang_main.' . $phpEx);
}
else
{
	include($module_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
}

//
// Decode for display
//
$title = ((mb_strlen($lang[str_replace(' ', '_', $title)]) !== 0) ? $lang[str_replace(' ', '_', $title)] : $language->lang($title));
$title = $mx_text->display($title);

switch ($doc_hosting_site)
{
	/* MX-Publisher Module Parameter */		
	/* get_list_static("{parameter_id}) */
	case 'lib.store.yahoo.net':
		$iframe_class = 'yahoo_iframe_embed';
		
	break;
	case 'scribd.com':
		$iframe_class = 'scribd_iframe_embed';
	break;
	case 'app.box.com':
		$iframe_class = 'box_iframe_embed';	
	break;
	case 'docs.google.com':
		$iframe_class = 'google_iframe_embed';
	break;		
	case 'drive.google.com':
		$iframe_class = 'drive_iframe_embed';
		
	break;
	case 'sites.google.com': 
		$iframe_class = 'sites_iframe_embed';
		
	break;
	case 'adobe.com':
		$iframe_class = 'adobedtm_iframe_embed';
		
	break;		
	case 'docs.sharefile.com':
		$iframe_class = 'sharefile_iframe_embed';
		
	break;
	case 'app.gitbook.com':
		$iframe_class = 'gitbook_iframe_embed';
		
	break;		
	
	/*  default parameter_value  */
	default:			
		$iframe_class = 'iframe_embed';		
		
	break;
	/* localhost */
	case false:
		$iframe_class = 'iframe';				
		
	break;
}

//
// Start output of page
//
$template->set_filenames(array('body_block' => 'mx_docembed_html.'.$tplEx));

$template->assign_vars(array(
	'BLOCK_SIZE'			=> ( !empty($block_size) ? $block_size : '100%' ),
	'L_TITLE' 				=> $title,
	'L_DESC'				=> $b_description,
	'U_URL' 				=> mx_append_sid(PORTAL_URL . 'index.' . $phpEx . '?block_id=' . $block_id),
	'doc_hosting_site' 		=> $doc_hosting_site,
	'api_key' 				=> $api_key,
	'access_key' 			=> $access_key,
	'session_key' 			=> $session_key,
	'user_id' 				=> $user_id,
	'username' 				=> $username, //Florin-C-Bodin
	'user_name' 			=> str_replace('-', ' ', $username),
	'password' 				=> $password,
	'iframe_class' 			=> $iframe_class,
	'admin_user' 			=> $admin_user,
	'admin_pass' 			=> $admin_pass,
	'secret' 				=> $secret,
	'width' 				=> $width,
	'height' 				=> $height,
	'T_TR_COLOR1' 			=> '#'.$mx_user->theme['tr_color1'],
	'T_TR_COLOR2' 			=> '#'.$mx_user->theme['tr_color2'],
	'T_TR_COLOR3' 			=> '#'.$mx_user->theme['tr_color3'],
	'T_BODY_LINK' 			=> '#'.$mx_user->theme['body_link'],
	'T_BODY_VLINK' 			=> '#'.$mx_user->theme['body_vlink'],
	'T_TH_COLOR1' 			=> '#'.$mx_user->theme['th_color1'],
	'doc_title' 			=> $doc_title,
	'doc-title' 			=> str_replace(' ', '-', $doc_title),
	'docs_count' 			=> $nested_docs_count,	
	'BLOCK_ID' 				=> $block_id,
	'S_HIDDEN_FORM_FIELDS'	=> $s_hidden_fields)
);

if (1 < $nested_docs_count)
{
	for ($cell = 0; $cell < $nested_docs_count; $cell++) 
	{
		$inner_doc_id = $doc_ids[$cell];
		settype($inner_doc_id, 'integer');
				
		switch ($doc_hosting_site)
		{
			/* MX-Publisher Module Parameter */		
			/* get_list_static("{parameter_id}) */
			case 'lib.store.yahoo.net':
				$src = 'https://lib.store.yahoo.net/'.$inner_doc_id.'/pub?embedded=true';	
			break;
			case 'scribd.com':
				$src = 'https://www.scribd.com/embeds/'.$inner_doc_id.'/content?start_page=1&view_mode=scroll&access_key='.$access_key;
			break;
			case 'app.box.com':
				$src = 'https://app.box.com/s/'.$inner_doc_id.'/pub?embedded=true';	
			break;
			case 'docs.google.com':	
				$src = 'https://docs.google.com/document/d/e/'.$inner_doc_id.'/pub?embedded=true';
			break;		
			case 'drive.google.com':
				$src = 'https://drive.google.com/document/d/e/'.$inner_doc_id.'/pub?embedded=true';		
			break;
			case 'sites.google.com':
				$src = 'https://sites.google.com/document/d/e/'.$inner_doc_id.'/pub?embedded=true';			
			break;
			case 'adobe.com':
				$src = 'https://xd.adobe.com/embed/'.$inner_doc_id.'/';			
			break;		
			case 'docs.sharefile.com':
				$src = 'https://docs.sharefile.com/'.$inner_doc_id.'/pub?embedded=true';				
			break;
			case 'app.gitbook.com':
				$src = 'https://app.gitbook.com/'.$inner_doc_id.'/pub?embedded=true';			
			break;		
			
			/*  default parameter_value  */
			default:			
				$src = 'https://'.$doc_hosting_site.'/'.$inner_doc_id.'/pub?embedded=true';		
				
			break;
			/* localhost */
			case false:
				$src = 'https://'.$doc_hosting_site.'/'.$inner_doc_id.'/pub?embedded=true';							
			break;
		}
		
		// output a placement table for each single block and the optional space
		$template->assign_block_vars('docrow', array(	
			'DOC_HREF_SRC' 			=> $src,
			'DOC_HOSTING_SITE' 		=> 'https://'.$doc_hosting_site,
			'DOC_ID' 				=> $inner_doc_id)
		);	
	}
}
else
{
	settype($doc_ids, 'integer');	
	
	switch ($doc_hosting_site)
	{
		/* MX-Publisher Module Parameter */		
		/* get_list_static("{parameter_id}) */
		case 'lib.store.yahoo.net':
			$src = 'https://lib.store.yahoo.net/'.$doc_ids.'/pub?embedded=true';	
		break;
		case 'scribd.com':
			$src = 'https://www.scribd.com/embeds/'.$doc_ids.'/content?start_page=1&view_mode=scroll&access_key='.$access_key;
		break;
		case 'app.box.com':
			$src = 'https://app.box.com/s/'.$doc_ids.'/pub?embedded=true';	
		break;
		case 'docs.google.com':	
			$src = 'https://docs.google.com/document/d/e/'.$doc_ids.'/pub?embedded=true';
		break;		
		case 'drive.google.com':
			$src = 'https://drive.google.com/document/d/e/'.$doc_ids.'/pub?embedded=true';		
		break;
		case 'sites.google.com':
			$src = 'https://sites.google.com/document/d/e/'.$doc_ids.'/pub?embedded=true';			
		break;
		case 'adobe.com':
			//ie: a2bd0a96-f6bc-4a5b-8ae4-e7b7e2ae5856-f7ee
			$src = 'https://xd.adobe.com/embed/'.$doc_ids.'/';			
		break;		
		case 'docs.sharefile.com':
			$src = 'https://docs.sharefile.com/'.$doc_ids.'/pub?embedded=true';				
		break;
		case 'app.gitbook.com':
			$src = 'https://app.gitbook.com/'.$doc_ids.'/pub?embedded=true';			
		break;		
			
		/*  default parameter_value  */
		default:			
			$src = 'https://'.$doc_hosting_site.'/'.$doc_ids.'/pub?embedded=true';				
		break;
		/* localhost */
		case false:
			$src = 'https://'.$doc_hosting_site.'/'.$doc_ids.'/pub?embedded=true';							
		break;
	}
	
	// output a placement table for each single block and the optional space
	$template->assign_block_vars('docrow', array(
		'DOC_HREF_SRC' 			=> $src,
		'DOC_HOSTING_SITE' 		=> 'https://'.$doc_hosting_site,		
		'DOC_ID' 				=> $doc_ids)
	);	
}
$template->pparse('body_block');
?>
