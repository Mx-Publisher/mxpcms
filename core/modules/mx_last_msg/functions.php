<?php
/***************************************************************************
 *                             functions.php
 *                            -------------------
 *   begin                : May, 2002
 *   copyright            : (C) 2002 MX-System
 *   email                : support@mx-system.com
 *
 *   $Id: functions.php,v 1.1 2005/05/06 06:48:06 jonohlsson Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/

function read_last_msg_config()
{
  global $db;

  $sql = "SELECT last_msg_number        ,
                 last_msg_display_date  ,
                 last_msg_display_forum ,
                 last_msg_length        ,
                 last_msg_target        ,
                 last_msg_align         
     FROM " . CONFIG_LAST_MSG_TABLE ;
  
  if ( !($result = $db->sql_query($sql)) )
  { 
    mx_message_die(GENERAL_ERROR, 'Could not obtain module configuration', '', __LINE__, __FILE__, $sql);
  } 
  
  $module_config = $db->sql_fetchrow($result);
  
  return $module_config;
}


?>
