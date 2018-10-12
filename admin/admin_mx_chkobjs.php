<?php
/**
*
* @package MX-Publisher Core
* @version $Id: admin_mx_chkobjs.php,v 1.30 2013/06/28 15:32:37 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

// ======================================================
//			[ ADMINCP COMMON INITIALIZATION ]
// ======================================================
if( !empty($setmodules) )
{
	$module['4_Panel_system']['4_1_Integrity'] = 'admin/' . basename(__FILE__);
	return;
}

//
// Security and Page header
//
@define('IN_PORTAL', 1);
$mx_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$no_page_header = TRUE;
require('./pagestart.' . $phpEx);

// ======================================================
//			[ GLOBAL DATA ]
// ======================================================
$main_title = "Check MX-Publisher Objects";
$main_desc  = "This utility allows you to check MX-Publisher object relationships.";
$main_info  = "This report shows the relations between MX-Publisher tables. " .
	"You'll see the object name next to its object identifier. " .
	"Whenever an object is missing (not found on the database), the row is marked with the symbol <font color=red>[?]</font>. " .
	"In this case, execute phpMyAdmin (or your favorite DB Control Center) and remove that row.<br /><br />" .
	"DISCLAIMER: This utility is released AS-IS. Please, ensure you have a working backup <u>before</u> you manually edit your DB.";

$check_args = array(
	array(
		'table' => FUNCTION_TABLE,
		'fkeys' => array(
			array(MODULE_TABLE, 'module_id', 'module_name'),
			array(FUNCTION_TABLE, 'function_id', 'function_name')
		)
	),
	array(
		'table' => PARAMETER_TABLE,
		'fkeys' => array(
			array(FUNCTION_TABLE, 'function_id', 'function_name'),
			array(PARAMETER_TABLE, 'parameter_id', 'parameter_name')
		)
	),
	array(
		'table' => BLOCK_TABLE,
		'fkeys' => array(
			array(FUNCTION_TABLE, 'function_id', 'function_name'),
			array(BLOCK_TABLE, 'block_id', 'block_title')
		)
	),
	array(
		'table' => BLOCK_SYSTEM_PARAMETER_TABLE,
		'fkeys' => array(
			array(BLOCK_TABLE, 'block_id', 'block_title'),
			array(PARAMETER_TABLE, 'parameter_id', 'parameter_name')
		)
	),
	array(
		'table' => COLUMN_TABLE,
		'fkeys' => array(
			array(PAGE_TABLE, 'page_id', 'page_name'),
			array(COLUMN_TABLE, 'column_id', 'column_title')
		)
	),
	array(
		'table' => COLUMN_BLOCK_TABLE,
		'fkeys' => array(
			array(COLUMN_TABLE, 'column_id', 'column_title'),
			array(BLOCK_TABLE, 'block_id', 'block_title')
		)
	)
);

// ======================================================
//			[ MAIN PROCESS ]
// ======================================================

//
// Check to see if we need to show the table selection box.
//
if ($mx_request_vars->is_request('check_mode'))
{
	$check_mode = $mx_request_vars->request('check_mode');
}
else
{
	if (!$mx_request_vars->is_get('mode'))
	{
		$select_options = '<select name="check_mode">';
		for( $i=0; $i < count($check_args); $i++ )
		{
			$selected = ( $i == $mx_request_vars->get('table', MX_TYPE_INT) ? ' selected="selected"' : '' );
			$select_options .= '<option value="'.$i.'"'.$selected.'>'.$check_args[$i]['table'].'</option>';
		}
		$select_options .= '</select>';

		mx_message_die(GENERAL_MESSAGE,
			'<p>'.$main_desc.'</p>' .
			'<form action="' . mx_append_sid(PORTAL_URL . "admin/admin_mx_chkobjs.$phpEx") . '" method="post"> ' .
			$select_options .
			' <input type="submit" name="submit" value="' . $lang['Submit'].'" class="mainoption" /></form>',
			$main_title );
	}

	$mode  = $mx_request_vars->get('mode', MX_TYPE_NO_TAGS);
	$tb    = $mx_request_vars->get('table', MX_TYPE_INT);
	$table = $check_args[$tb]['table'];
	$val0  = $mx_request_vars->get('val0', MX_TYPE_NO_TAGS);
	$val1  = $mx_request_vars->get('val1', MX_TYPE_NO_TAGS);
	$tab0  = $check_args[$tb]['fkeys'][0][0];
	$key0  = $check_args[$tb]['fkeys'][0][1];
	$tab1  = $check_args[$tb]['fkeys'][1][0];
	$key1  = $check_args[$tb]['fkeys'][1][1];

	switch($mode)
	{
		case 'delete':
			$sql = "DELETE FROM ".$table." WHERE $key0 = $val0 AND $key1 = $val1";
			$get_vars = '&amp;table='.$tb.
				'&amp;val0='.$val0.'&amp;val1='.$val1.
				'&amp;key0='.$key0.'&amp;key1='.$key1;
			$message = '<form method="post" action="' . basename(__FILE__) . '">' .
				'<table border="0" cellpadding="4" cellspacing="0">' .
					'<tr><td colspan="2"><b>' . $table . '</b></td></tr>' .
					'<tr><td><b>' . $key0 . ':</b>&nbsp;</td><td>[&nbsp;' . $val0 . '&nbsp;]</td></tr>' .
					'<tr><td><b>' . $key1 . ':</b>&nbsp;</td><td>[&nbsp;' . $val1 . '&nbsp;]</td></tr>' .
				'</table>&nbsp;<br />&nbsp;<br />' .
				'<div style="width:80%; padding:10px; border:solid red 1px;">' .
					'<b>' . $lang['Confirm'] . '</b>:<br />' . $sql . '<br />' .
					'<br />&nbsp;<br />' .
					'[ <a href="'.mx_append_sid(basename(__FILE__)."?check_mode=$tb").'">'.$lang['No'].'</a> ]' .
					'&nbsp;' .
					'[ <a href="'.mx_append_sid(basename(__FILE__).'?mode=db_delete'.$get_vars).'">'.$lang['Yes'].'</a> ]' .
				'</div><br />&nbsp;' .
				'</form>';
			mx_message_die(GENERAL_MESSAGE, $message, $my_script_title);
			break;
		case 'db_delete':
			$sql = "DELETE FROM ".$table." WHERE $key0 = $val0 AND $key1 = $val1";
			if( !chkobjs_dbQuery($sql) )
			{
				mx_message_die(GENERAL_ERROR, "Couldn't DELETE data from table : " . $table,
					"", __LINE__, __FILE__, $sql);
			}
			$check_mode = $tb;
			break;
		default:
			break;
	}
}

include_once('./page_header_admin.' . $phpEx);
check_relationship($check_mode);
include('./page_footer_admin.' . $phpEx);
exit;

// ======================================================
//			[ FUNCTIONS ]
// ======================================================

/**
 * Enter description here...
 *
 * @param unknown_type $tb
 */
function check_relationship($tb)
{
	global $db, $lang, $check_args, $main_title, $main_desc, $main_info;

	$table = $check_args[$tb]['table'];
	$fkeys = count($check_args[$tb]['fkeys']);
	for($i = 0; $i < $fkeys; $i++)
	{
		$ftab[] = $check_args[$tb]['fkeys'][$i][0];
		$fkey[] = $check_args[$tb]['fkeys'][$i][1];
		$fnam[] = $check_args[$tb]['fkeys'][$i][2];
	}

	//
	// Build the query and check the table relations.
	//
	$sql = "SELECT * FROM ".$table." ORDER BY ".implode(',', $fkey);
	$result = $db->sql_query($sql);

	if( !$result )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't obtain the data from database.", '', __LINE__, __FILE__, $sql);
	}

	$html='<h1>' . $main_title.'</h1>' . "\n";
	$html.='<p>' . $main_desc.'<br /><br />' . $main_info.'</p>' . "\n";

	$html.='<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline" align="center">' . "\n";
	$html.="\t" . '<tr>' . "\n";
	$html.=tbHead('td', 'catHead', 5, '<b>Checking Table: '.$table.'</b>');
	$html.="\t" . '</tr>' . "\n";
	$html.="\t" . '<tr>' . "\n";
	$html.=tbHead('td', 'cat', 5, '<a href="'.mx_append_sid(basename(__FILE__)."?table=$tb").'"><b>Go Back</b></a>');
	$html.="\t" . '</tr>' . "\n";

	$html.="\t" . '<tr>' . "\n";
	$html.=tbHead('th', 'thCornerL', 1, $fkey[0]);
	for($i = 0; $i < ($fkeys-1); $i++)
	{
		$html.=tbHead('th', 'thTop', 1, $fnam[$i]);
		$html.=tbHead('th', 'thTop', 1, $fkey[$i+1]);
	}
	$html.=tbHead('th', 'thTop', 1, $fnam[$fkeys-1]);
	$html.=tbHead('th', 'thCornerR', 1, $lang['Action']);
	$html.="\t" . '</tr>' . "\n";

	$row_count = 0;
	while( $row = $db->sql_fetchrow($result) )
	{
		$row_class = (($row_count % 2) == 0) ? 'row1' : 'row2';

		$html.= "\t" . '<tr>' . "\n";

		$get_vars = '&amp;table='.$tb;

		for($i = 0; $i < $fkeys; $i++)
		{
			$field = $fkey[$i];
			if( $ftab[$i] == $table )
			{
				$field_key = $row[$field];
				$fname = $fnam[$i];
				$field_value = $row[$fname];
			}
			else
			{
				if( !($field_value = chkobjs_dbFetchField($ftab[$i], $field.'='.$row[$field], $fnam[$i])) )
				{
					$field_key   = '<font color=red><b>'.$row[$field].'</b></font>';
					$field_value = '<font color=red><b>[?]</b></font>';
				}
				else
				{
					$field_key   = $row[$field];
				}
			}
			$get_vars .= '&amp;val'.$i.'='.$row[$field];
			$html.=tbItem('td', 'row1', 'center', $field_key);
			$html.=tbItem('td', 'row2', 'left'  , $field_value);
		}

		$onclick = 'onclick="return confirm(\'Are you sure you want to delete this object?\');"';
		$html.=tbItem('td', 'row1', 'center', '<a href="'.mx_append_sid(basename(__FILE__).'?mode=delete'.$get_vars).'" '.$onclick.'>'.$lang['Delete'].'</a>');
		$html.= "\t" . '</tr>' . "\n";
		$row_count++;
	}

	$html.="\t" . '<tr>' . "\n";
	$html.=tbHead('td', 'catBottom', 5, '<a href="'.mx_append_sid(basename(__FILE__)."?table=$tb").'"><b>Go Back</b></a>');
	$html.="\t" . '</tr>' . "\n";
	$html.='</table><br />' . "\n";

	$db->sql_freeresult($result);
	echo $html;
}

/**
 * Enter description here...
 *
 * @param unknown_type $td
 * @param unknown_type $class
 * @param unknown_type $colspan
 * @param unknown_type $text
 * @return unknown
 */
function tbHead($td, $class, $colspan, $text)
{
	return "\t\t" . '<'.$td.' class="'.$class.'" colspan="'.$colspan.'" align="center">'.$text.'</'.$td.'>' . "\n";
}

/**
 * Enter description here...
 *
 * @param unknown_type $td
 * @param unknown_type $class
 * @param unknown_type $align
 * @param unknown_type $text
 * @return unknown
 */
function tbItem($td, $class, $align, $text)
{
	return "\t\t" . '<'.$td.' class="'.$class.'" align="'.$align.'">'.$text.'</'.$td.'>' . "\n";
}

// ------------
// DB Utilities
//

/**
 * Enter description here...
 *
 * @param unknown_type $tbname
 * @param unknown_type $where
 * @param unknown_type $field
 * @return unknown
 */
function chkobjs_dbFetchField($tbname, $where, $field)
{
	$sql = "SELECT * FROM ".$tbname." WHERE ".$where;
	if( !($row = chkobjs_dbFetchRow($sql)) )
	{
		return false;
	}
	return $row[$field];
}

/**
 * Enter description here...
 *
 * @param unknown_type $sql
 * @return unknown
 */
function chkobjs_dbFetchRow($sql)
{
	global $db;
	if (!($result = $db->sql_query($sql)))
	{
		return false;
	}
		
	if (!($row = $db->sql_fetchrow($result)))
	{
		return false;
	}
	return $row;
}

/**
 * Enter description here...
 *
 * @param unknown_type $sql
 * @return unknown
 */
function chkobjs_dbQuery($sql)
{
	global $db;
	if (!($result = $db->sql_query($sql)))
	{
		return false;
	}
	return $result;
}
?>