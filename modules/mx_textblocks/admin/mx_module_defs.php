<?php
/**
*
* @package MX-Publisher Module - mx_textblocks
* @version $Id: mx_module_defs.php,v 1.33 2013/07/02 02:24:04 orynider Exp $
* @copyright (c) 2002-2008 [Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/********************************************************************************\
| Class: mx_module_defs
| The mx_module_defs object provides additional module block parameters...
\********************************************************************************/
class mx_module_defs
{
	// ------------------------------
	// Private Methods
	//
	//

	// ===================================================
	// define module specific block parameters
	// ===================================================
	function get_parameters($type_row = '')
	{
		global $lang;

		if (empty($type_row))
		{
			$type_row = array();
		}

		$type_row['phpBBTextBlock'] = !empty($lang['ParType_phpBBTextBlock']) ? $lang['ParType_phpBBTextBlock'] : "phpBB TextBlock";
		$type_row['CustomizedTextBlock'] = !empty($lang['ParType_CustomizedTextBlock']) ? $lang['ParType_CustomizedTextBlock'] : "Customized TextBlock";
		$type_row['WysiwygTextBlock'] = !empty($lang['ParType_WysiwygTextBlock']) ? $lang['ParType_WysiwygTextBlock'] : "Wysiwyg TextBlock";

		return $type_row;
	}

	// ===================================================
	// Submit custom parameter field and data
	// ===================================================
	function submit_module_parameters( $parameter_data, $block_id )
	{
		global $mx_request_vars, $db, $board_config, $mx_cache, $mx_blockcp, $mx_root_path, $phpbb_root_path, $phpEx;
		global $html_entities_match, $html_entities_replace, $mx_admin;

		$parameter_value = $mx_request_vars->post($parameter_data['parameter_name']);
		$parameter_opt = '';

		switch ( $parameter_data['parameter_type'] )
		{
			case 'phpBBTextBlock':
				$bbcode_on = $board_config['allow_bbcode'] ? true : false;
				$html_on = $board_config['allow_html'] ? true : false;
				$smilies_on = $board_config['allow_smilies'] ? true : false;

				break;
			case 'CustomizedTextBlock':
				$bbcode_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_bbcode']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_bbcode']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_bbcode']['parameter_value'] == 'TRUE';
				$html_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_html']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_html']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_html']['parameter_value'] == 'TRUE';
				$smilies_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_smilies']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_smilies']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_smilies']['parameter_value'] == 'TRUE';
				$board_config['allow_html_tags'] = $mx_request_vars->is_post($mx_blockcp->block_parameters['html_tags']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['html_tags']['parameter_id'], MX_TYPE_NO_TAGS) : $mx_blockcp->block_parameters['html_tags']['parameter_value'];

				break;
			case 'WysiwygTextBlock':
				$bbcode_on = false;
				$html_on = true;
				$smilies_on = false;
				$bbcode_uid = '';

				break;
		}

		//
		// Instantiate the mx_text class
		//
		include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);
		$mx_text->allow_all_html_tags = $parameter_data['parameter_type'] = 'WysiwygTextBlock' ? true : false;

		//
		// Encode for db storage
		//
		$parameter_value = $mx_text->encode($parameter_value);
		$parameter_opt = $mx_text->bbcode_uid;

		//
		// Add search words
		//
		$mx_admin->mx_remove_search_post($block_id);

		$block_config_temp = $mx_cache->read( $block_id, MX_CACHE_BLOCK_TYPE );
		$block_info_temp = $block_config_temp[$block_id]['block_info'];
		$block_title = $block_info_temp['block_title'];

		$mx_admin->mx_add_search_words('single', $block_id, $parameter_value, $block_title);

		return array('parameter_value' => $parameter_value, 'parameter_opt' => $parameter_opt);
	}

	// ===================================================
	// Display cuztom parameter field and data in the Block Control Panel
	// ===================================================
	function display_module_parameters( $parameter_data, $block_id )
	{
		global $template, $mx_blockcp, $mx_root_path, $theme, $lang;
		global $mx_page, $mx_request_vars, $mx_blockcp;

		//
		// Virtual Hack
		//
		if ($mx_page->is_virtual && $mx_request_vars->request('virtual'))
		{
			$virtual_id = $mx_request_vars->request('virtual', MX_TYPE_INT, 0);
			if (!$mx_blockcp->virtual_init($virtual_id, true))
			{
				$mx_blockcp->virtual_create($virtual_id);
			}
			$mx_blockcp->virtual_id = $virtual_id;
			foreach($mx_blockcp->block_virtual_parameters as $parameter_name => $data)
			{
				$parameter_data = $data;
			}
		}

		switch ( $parameter_data['parameter_type'] )
		{
			case 'phpBBTextBlock':
				$this->display_edit_phpBBTextBlock( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
			case 'CustomizedTextBlock':
				$this->display_edit_CustomizedTextBlock( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
			case 'WysiwygTextBlock':
				$this->display_edit_WysiwygTextBlock( $block_id, $parameter_data['parameter_id'], $parameter_data );
				break;
		}
	}

	function display_edit_phpBBTextBlock( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpbb_root_path, $phpEx, $mx_table_prefix, $table_prefix;
		global $mx_request_vars, $mx_bbcode;

		$parameter_value = $mx_request_vars->is_post('preview') ? $mx_request_vars->post($parameter_data['parameter_name'], MX_TYPE_NO_TAGS) : $parameter_data['parameter_value'];
		$bbcode_uid = $mx_request_vars->is_post('preview') ? '' : $parameter_data['parameter_opt'];

		//
		// Toggles
		//
		$bbcode_on = $board_config['allow_bbcode'] ? true : false;
		$html_on = $board_config['allow_html'] ? true : false;
		$smilies_on = $board_config['allow_smilies'] ? true : false;

		//
		// Instantiate the mx_text class
		//
		include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);

		if ($mx_request_vars->is_post('preview'))
		{
			//
			// Encode for preview
			//
			$preview_text = $mx_text->encode_preview($parameter_value);

			$template->assign_vars(array(
				'TEXT' => $preview_text
			));

			$template->assign_block_vars('preview', array());

			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, '', true);
		}
		else
		{
			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, $bbcode_uid);

		}

		//
		// HTML, BBCode & Smilies toggle selection
		//
		$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

		if( $bbcode_on)
		{
			$template->assign_block_vars('switch_bbcodes', array());
		}

		if( $smilies_on)
		{
			$mx_bbcode->generate_smilies('inline', PAGE_INDEX);
			$template->assign_block_vars('switch_smilies', array());
		}

		$template->assign_vars(array(
			// BBcodes
			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'],
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],

			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'],

			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
			'L_STYLES_TIP' => $lang['Styles_tip'],

			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . PHPBB_URL . mx_append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
			'SMILIES_STATUS' => $smilies_status,

			'L_PREVIEW' => $lang['Preview'],

			// To sync script and textarea select field
			'SELECT_NAME' =>  $parameter_data['parameter_name'],

			'TEXTAREA_BBCODES_XTRA' => $bbcode_on ? 'onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"' : '',
		));

		$template->assign_block_vars('textblock', array(
			'PARAMETER_TITLE' => ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TYPE' => ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_EXPLAIN' => ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? '<br />' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"]  : '',
			'TEXT' => $parameter_value
		));

		$template->pparse('parameter');
	}

	function display_edit_CustomizedTextBlock( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpbb_root_path, $phpEx, $mx_table_prefix, $table_prefix, $html_entities_match, $html_entities_replace;
		global $mx_request_vars, $mx_bbcode;

		$parameter_value = $mx_request_vars->is_post('preview') ? $mx_request_vars->post($parameter_data['parameter_name'], MX_TYPE_NO_TAGS) : $parameter_data['parameter_value'];
		$bbcode_uid = $mx_request_vars->is_post('preview') ? '' : $parameter_data['parameter_opt'];

		//
		// Toggles ?????????????????
		//
		$bbcode_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_bbcode']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_bbcode']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_bbcode']['parameter_value'] == 'TRUE';
		$html_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_html']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_html']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_html']['parameter_value'] == 'TRUE';
		$smilies_on = $mx_request_vars->is_post($mx_blockcp->block_parameters['allow_smilies']['parameter_id']) ? $mx_request_vars->post($mx_blockcp->block_parameters['allow_smilies']['parameter_id'], MX_TYPE_NO_TAGS) == 'TRUE' : $mx_blockcp->block_parameters['allow_smilies']['parameter_value'] == 'TRUE';

		//
		// Instantiate the mx_text class
		//
		include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);

		if ($mx_request_vars->is_post('preview'))
		{
			//
			// Encode for preview
			//
			$preview_text = $mx_text->encode_preview($parameter_value);

			$template->assign_vars(array(
				'TEXT' => $preview_text
			));

			$template->assign_block_vars('preview', array());

			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, '', true);
		}
		else
		{
			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, $bbcode_uid);
		}

		//
		// HTML, BBCode & Smilies toggle selection
		//
		$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

		if( $bbcode_on)
		{
			$template->assign_block_vars('switch_bbcodes', array());
		}

		if( $smilies_on)
		{
			$mx_bbcode->generate_smilies('inline', PAGE_INDEX);
			$template->assign_block_vars('switch_smilies', array());
		}

		$template->assign_vars(array(
			// BBcodes
			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'],
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],

			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'],

			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
			'L_STYLES_TIP' => $lang['Styles_tip'],
			'L_PREVIEW' => $lang['Preview'],

			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . PHPBB_URL . mx_append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
			'SMILIES_STATUS' => $smilies_status,

			// To sync script and textarea select field
			'SELECT_NAME' =>  $parameter_data['parameter_name'],

			'TEXTAREA_BBCODES_XTRA' => $bbcode_on ? 'onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"' : '',
		));

		$template->assign_block_vars('textblock', array(
			'PARAMETER_TITLE' => ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TYPE' => ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_EXPLAIN' => ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? '<br />' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"]  : '',
			'TEXT' => $parameter_value
		));

		$template->pparse('parameter');
	}

	function display_edit_WysiwygTextBlock( $block_id, $parameter_id, $parameter_data )
	{
		global $template, $board_config, $db, $theme, $lang, $images, $mx_blockcp, $mx_root_path, $phpbb_root_path, $phpEx, $mx_table_prefix, $table_prefix, $html_entities_match, $html_entities_replace;
		global $mx_request_vars;

		$parameter_value = $mx_request_vars->is_post('preview') ? $mx_request_vars->post($parameter_data['parameter_name'], MX_TYPE_NO_TAGS) : $parameter_data['parameter_value'];
		$bbcode_uid = $mx_request_vars->is_post('preview') ? '' : $parameter_data['parameter_opt'];

		//
		// Toggles
		//
		$bbcode_on = false;
		$html_on = true;
		$smilies_on = false;

		//
		// Instantiate the mx_text class
		//
		include_once($mx_root_path . 'includes/mx_functions_tools.'.$phpEx);
		$mx_text = new mx_text();
		$mx_text->init($html_on, $bbcode_on, $smilies_on);

		//
		// Allow all html tags
		// Fix: Setting 'emtpy' enables all
		//
		$mx_text->allow_all_html_tags = true;

		if ($mx_request_vars->is_post('preview'))
		{
			//
			// Encode for preview
			//
			$preview_text = $mx_text->encode_preview($parameter_value);

			$template->assign_vars(array(
				'TEXT' => $preview_text
			));

			$template->assign_block_vars('preview', array());

			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, '', true);
		}
		else
		{
			//
			// Decode for form editing
			//
			$parameter_value = $mx_text->decode($parameter_value, $bbcode_uid);

		}

		//
		// HTML, BBCode & Smilies toggle selection
		//
		$html_status = ( $html_on ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ( $bbcode_on ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ( $smilies_on ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];

		$template->set_filenames(array(
			'parameter' => 'admin/mx_module_parameters.tpl')
		);

     	$convert = array(
      		'arabic'               => 'ar',
      		'bulgarian'               => 'bg',
      		'catalan'               => 'ca',
      		'czech'                  => 'cs',
      		'danish'               => 'da',
      		'german'               => 'de',
      		'english'               => 'en',
      		'estonian'               => 'et',
      		'finnish'               => 'fi',
      		'french'               => 'fr',
      		'greek'                  => 'el',
      		'spanish_argentina'            => 'es[_-]ar',
      		'spanish'               => 'es',
      		'gaelic'               => 'gd',
      		'galego'               => 'gl',
      		'gujarati'               => 'gu',
      		'hebrew'               => 'he',
      		'hindi'                  => 'hi',
      		'croatian'               => 'hr',
     		'hungarian'               => 'hu',
      		'icelandic'               => 'is',
      		'indonesian'               => 'id',
      		'italian'               => 'it',
      		'japanese'               => 'ja',
      		'korean'               => 'ko',
      		'latvian'               => 'lv',
      		'lithuanian'               => 'lt',
      		'macedonian'               => 'mk',
	      	'dutch'                  => 'nl',
      		'norwegian'               => 'no',
      		'punjabi'               => 'pa',
      		'polish'               => 'pl',
      		'portuguese_brazil'            => 'pt[_-]br',
      		'portuguese'               => 'pt',
      		'romanian'               => 'ro',
      		'russian'               => 'ru',
      		'slovenian'               => 'sl',
      		'albanian'               => 'sq',
      		'serbian'               => 'sr',
      		'slovak'               => 'sv',
      		'swedish'               => 'sv',
      		'thai'                  => 'th',
      		'turkish'               => 'tr',
      		'ukranian'               => 'uk',
      		'urdu'                  => 'ur',
      		'viatnamese'               => 'vi',
      		'chinese_traditional_taiwan'         => 'zh[_-]tw',
      		'chinese_simplified'            => 'zh',
      	);

      	$user_lang = $userdata['user_lang'];

      	if ( !file_exists( $mx_root_path . 'modules/mx_shared/tinymce/jscripts/tiny_mce/langs/' . $convert[$user_lang] . '.js' ) )
      	{
     		$user_lang = $board_config['default_lang'];

     		if ( !file_exists( $mx_root_path . 'modules/mx_shared/tinymce/jscripts/tiny_mce/langs/' . $convert[$user_lang] . '.js' ) )
         	{
            	$user_lang = 'english';
         	}
      	}

      	$tiny_lang = $convert[$user_lang];

      	//
      	// This switch is for enabling the wysiwyg html editor addon "tiny mce". to disable this feature
      	// either remove this section or delete the modules/tinymce folder
      	//
      	if ( file_exists($mx_root_path . 'modules/mx_shared/tinymce/jscripts/tiny_mce/tiny_mce.js') )
      	{
         	$langcode = mx_get_langcode();

         	if ($mx_blockcp->auth_mod)
         	{
	         	$template->assign_block_vars( "tinyMCE_admin", array(
	            	'PATH' => $mx_root_path,
	            	'LANG' => $tiny_lang,
	            	'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
	         	));
         	}
         	else
         	{
	         	$template->assign_block_vars( "tinyMCE", array(
	            	'PATH' => $mx_root_path,
	            	'LANG' => $tiny_lang,
	            	'TEMPLATE' => $mx_root_path . 'templates/'. $theme['template_name'] . '/' . $theme['head_stylesheet']
	         	));
         	}
      	}

		$parameter_field = '<textarea rows="30" cols="150" wrap="virtual" name="' . $parameter_id . '" class="post">' . $parameter_value . '</textarea>';

		$template->assign_vars(array(
			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . PHPBB_URL . mx_append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
			'SMILIES_STATUS' => $smilies_status,
			'L_PREVIEW' => $lang['Preview'],

			//
			// To sync script and textarea select field
			//
			'SELECT_NAME' =>  $parameter_data['parameter_name'],
		));

		$template->assign_block_vars('textblock', array(
			'PARAMETER_TITLE' => ( !empty($lang[$parameter_data['parameter_name']]) ) ? $lang[$parameter_data['parameter_name']] : $parameter_data['parameter_name'],
			'PARAMETER_TYPE' => ( !empty($lang["ParType_".$parameter_data['parameter_type']]) ) ? $lang["ParType_".$parameter_data['parameter_type']] : '',
			'PARAMETER_TYPE_EXPLAIN' => ( !empty($lang["ParType_".$parameter_data['parameter_type'] . "_info"]) ) ? '<br />' . $lang["ParType_".$parameter_data['parameter_type'] . "_info"]  : '',
			'TEXT' => $parameter_data['parameter_value']
		));

		$template->pparse('parameter');
	}
}
?>