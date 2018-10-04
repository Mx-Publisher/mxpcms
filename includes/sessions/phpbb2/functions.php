<?php
/**
*
* @package Auth
* @version $Id: functions.php,v 1.2 2013/06/28 15:33:47 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

if ( !defined( 'IN_PORTAL' ) )
{
	die( "Hacking attempt" );
}

/**
 * Get 'Poll Select' html select list.
 *
 * Quick and handy function to generate a dropdown select list for current phpbb polls
 *
 * @param string $default_poll select idfield = id
 * @param string $select_name select name
 * @return string (html)
 */
function poll_select($default_poll, $select_name = 'Poll_Topic_id')
{
	global $db;

	$style_select = '<select name="' . $select_name . '">';
	$selected = ( $default_poll == 0 ) ? ' selected="selected"' : '';
	$style_select .= '<option value="0"' . $selected . '>' . 'The most recent' . "</option>\n";

	$sql = "SELECT topic_id, vote_text
		FROM " . VOTE_DESC_TABLE . "
		ORDER BY vote_text, topic_id";

	if( !($result = $db->sql_query($sql)) )
	{
		mx_message_die(GENERAL_ERROR, "Couldn't query polls table", '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['topic_id'] == $default_poll ) ? ' selected="selected"' : '';
		$style_select .= '<option value="' . $row['topic_id'] . '"' . $selected . '>' . $row['vote_text'] . "</option>\n";
	}
	$style_select .= '</select>';

	unset($row);
	$db->sql_freeresult($result);
	return $style_select;
}
?>