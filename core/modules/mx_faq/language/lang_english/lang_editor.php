<?php
/***************************************************************************
 *			     lang_editor.php [English]
 *                              -------------------
 *     begin                : Apr 29 2007
 *     copyright            : (C) 2007 Selven based on http://www.phpBB.com format
 *     email                :
 *
 *     $Id: lang_editor.php,v 1.3 2008/02/01 04:21:47 orynider Exp $
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


$lang['editor'] = 'Edit Language';
$lang['editor_explain'] = 'This module allows you to edit and re-arrange your Rules &amp; FAQ . You <u>should not</u> remove or alter the section entitled <b>phpBB 2 Issues</b>.';

$lang['select_language'] = 'Choose the language of the file you want to edit';
$lang['retrieve'] = 'Retrieve File';

$lang['block_delete'] = 'Are you sure you want to delete this block?';
$lang['quest_delete'] = 'Are you sure you wish to delete this question (and its answer)?';

$lang['quest_edit'] = 'Edit Entries';
$lang['quest_create'] = 'Create New entry';

$lang['quest_edit_explain'] = 'Edit the entry. You can also change the category if you wish.';
$lang['quest_create_explain'] = 'Type the new title and text and press Submit.';

$lang['block'] = 'Category';
$lang['quest'] = 'Title';
$lang['answer'] = 'Text';

$lang['block_name'] = 'Category Name';
$lang['block_rename'] = 'Rename a Category';
$lang['block_rename_explain'] = 'Change the name of a category in the file';

$lang['block_add'] = 'Add Category';
$lang['quest_add'] = 'Add Entry';

$lang['no_quests'] = 'No entries in this Category. This will prevent any category after this one being displayed. Delete the category or add one or more entries.';
$lang['no_blocks'] = 'No category defined. Add a new category by typing a name below.';

$lang['write_file'] = 'Could not write to the language file!';
$lang['write_file_explain'] = 'You must make the faqs language files in language/lang_english/ and in all your language folders <i>writeable</i> to use this control panel. On UNIX, this means running <code>chmod 666 filename</code>. Most FTP clients can do through the properties sheet for a file, otherwise you can use telnet or SSH.';

?>