<?
/***************************************************************************
 *                       lang_faq_module.php
 *                              -------------------
 *     begin                : Sat jul 12 2003
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_faq_module.php,v 1.4 2008/02/01 04:21:24 orynider Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
$sql = "SELECT * FROM " . MODULE_TABLE . " ORDER BY module_id";
$result = $db -> sql_query($sql);
if (!$result) {
	mx_message_die(GENERAL_ERROR, "Couldn't obtain modules from database", "", __LINE__, __FILE__, $sql);
} 
$module = $db -> sql_fetchrowset($result);
for( $i=0; $i < count($module); $i++)
{
if (file_exists($module[$i]['module_path'].'language/lang_' . $board_config['default_lang'] . '/lang_faq.php'))
{
include ($module[$i]['module_path'].'language/lang_' . $board_config['default_lang'] . '/lang_faq.php');
}
elseif (file_exists($module[$i]['module_path'].'language/lang_english/lang_faq.php'))
{
include ($module[$i]['module_path'].'language/lang_english/lang_faq.php');
};
};
?>