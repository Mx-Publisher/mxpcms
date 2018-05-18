<?php
/** ------------------------------------------------------------------------
 *		Subject				: mxBB - a fully modular portal and CMS (for phpBB) 
 *		Author				: Jon Ohlsson and the mxBB Team
 *		Credits				: The phpBB Group & Marc Morisette
 *		Copyright          	: (C) 2002-2005 mxBB Portal
 *		Email             	: jon@mxbb-portal.com
 *		Project site		: www.mxbb-portal.com
 * -------------------------------------------------------------------------
 * 
 *    $Id: mx_form.php,v 1.1 2010/10/10 14:59:41 orynider Exp $
 */

/**
 * This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 */

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

class form
{
	var $items; // array containing the data for the form 
	var $arrayname; // name of the form array 
	
	function form( $items = array() )
	{
		if ( !empty( $items ) )
		{
			$this->items = $items;
			foreach ( $items as $item )
			{
				if ( $item[0] == "name" )
				{
					$this->arrayname = $item[1]; // getting the table name 
					$name = true;
					break;
				}
			}
			if ( !isset( $name ) ) die( "The form hasn't got name parameter" );
		}
	}

	function drawForm() // drawing the input form
	{
		global $template, $lang;

		foreach ( $this->items as $item )
		{
			$item_label = '';
			$item_field = '';

			switch ( $item[0] )
			{
				case "text": // text form
					$item_label = $item[1];
					$item_field = '<input type="text" name="' . $this->arrayname . '[' . $item[2] . ']" size="' . $item[3] . '" value="' . $item[4] . '" class="post">';
					break;
				case "textarea": // textarea
					$item_label = $item[1];
					$item_field = '<textarea name="' . $this->arrayname . '[' . $item[2] . ']" class="post" wrap="on" cols="' . $item[3] . '" rows="' . $item[4] . '">' . $item[5] . '</textarea>';
					break;

				case "password": // password
					$item_label = $item[1];
					$item_field = '<input type="password" name="' . $this->arrayname . '[' . $item[2] . ']" size="' . $item[3] . '" value="' . $item[4] . '" class="post">';

					/*          case "radio": // radio button 
            $item_label = $item[1]; 
            foreach ($item[3] as $key=>$value) 
            { 
              if (isset($item[4]) && $item[4]==$key) 
              { 
                $item_field .= '<input type="radio" name="' . $this->arrayname . '['. $item[2] . ']" value="' . $key . '" checked >' .. $value; 
              } 
              else 
              { 
                $item_field .= '<input type="radio" name="' . $this->arrayname . '['. $item[2] . ']" value="' . $key . '" >'. $value; 
              } 
            } 
*/
					break;
				case "checkbox": // checkbox button
					$item_label = $item[1];

					if ( isset( $item[3] ) )
						$item_field = '<input type="checkbox" name="' . $this->arrayname . '[' . $item[2] . ']" value="1" checked>';
					else
						$item_field = '<input type="checkbox" name="' . $this->arrayname . '[' . $item[2] . ']" value="1"';

					break;
				case "select":
					$item_label = $item[1];
					$item_field = $item[2];

					break;
				case "file": // file upload field
					$item_label = $item[1];
					$item_field = '<input type="file" name="' . $item[2] . '" size="' . $item[3] . '" class="post">';
					$item_field .= '<input type="hidden" name="MAX_FILE_SIZE" value="' . $config->MaxUploadSize . '">';
					$item_field .= '<input type="hidden" name="' . $this->arrayname . '[fileupload]" value="' . $item[2] . '">';
					break;
				case "hidden": // hidden fields
					$item_label = '';
					$item_field = '<input type="hidden" name="' . $this->arrayname . '[' . $item[1] . ']" value="' . $item[2] . '">';
					break;
				case "submit": // defining the label for submit button
					$submit = $item[1];
					$submitname = $item[2];
					break;
				case "delete": // delete button
					$item_label = $item[1];
					$item_field = $item[2];
					break;
			}

			if ( ! empty( $item_field ) )
			{
				$template->assign_block_vars( "rows", array( 'LABEL' => $item_label,
						'FIELD' => $item_field, 
						) );
			}
		}

		$template->pparse( "body" );
	}

	/* If is there a file upload, it has got some extra parameter (e.g. file_type). 
    * These parameter are put here to the main array 
    */
	function preinsert( $pairs = array(), $tabla = "" )
	{
		global $config;

		foreach ( $pairs as $key => $value )
		{
			if ( $key == "fileupload" ) // special variable containing the prefix of the name of the uploaded file
			{
				$name = $value . "_name";
				$size = $value . "_size";
				$type = $value . "_type";
				$path = $value;
				global $$name, $$size, $$type, $$path;
				if ( $$size > $config->MaxUploadSize ) // checking the size of the uploaded file, you must set $config->MaxUploadSize
				{
					printf( "The uploaded file is too big. The maximal size is %d byte. <br>Please repeat the upload!", $config->MaxUploadSize );
					$this->drawform();
				}
				else
				{ 
					// let's put the values of the uploaded image to the main array
					$pairs[file_name] = $$name;
					$pairs[file_size] = $$size;
					$pairs[file_type] = $$type;
					$pairs[file_path] = $$path;
					if ( !empty( $tabla ) ) $this->insert( $pairs, $tabla ); // if you get table name, insert do everything to you 
					else return( $pairs ); // if there's no table, we return with the finished array 
					break;
				}
			}
		}
	}

	function insert( $pairs, $table ) // method for inserting record to the database
	{
		global $db;

		$sql = "INSERT INTO $table (";
		$first = true;
		foreach ( $pairs as $key => $value )
		{
			if ( $key != "id" || $key != "title" || $key != "submit" ) // everything except record ID,title,submit
			{
				if ( $first )
				{
					$value = "\"" . $value;
					$first = false;
				}
				else
				{
					$key = "," . $key;
					$value = ",\"" . $value;
				}
				$fields .= $key;
				$values .= $value . "\"";
			}
		}
		$sql .= $fields . ") VALUES(" . $values . ")";

		if ( !$result = $db->sql_query( $sql ) )
		{
			message_die( GENERAL_ERROR, "Couldn't insert into $table ", "", __LINE__, __FILE__, $sql );
		}
	}

	function update( $pairs, $table, $key ) // method for updating records in the database
	{
		global $db;

		$sql = "UPDATE $table SET ";
		$first = true;
		foreach ( $pairs as $key => $value )
		{
			if ( $key != "id" || $key != "title" || $key != "submit" ) // everything except record ID,title,submit
			{
				if ( $first )
				{
					$sql .= "$key=\"$value\"";
					$first = false;
				}
				else
				{
					$sql .= ",$key=\"$value\"";
				}
			}
		}
		$sql .= " WHERE $key = $pairs[$key]";

		if ( !$result = $db->sql_query( $sql ) )
		{
			message_die( GENERAL_ERROR, "Couldn't insert into $table ", "", __LINE__, __FILE__, $sql );
		}
	}

	function delete( $id, $table, $key ) // method for deleting record from a table
	{
		global $db;

		$sql = "DELETE FROM $table WHERE $key =$id";
		if ( !$result = $db->sql_query( $sql ) )
		{
			message_die( GENERAL_ERROR, "Couldn't delete $table information", "", __LINE__, __FILE__, $sql );
		}
	}
}

?>