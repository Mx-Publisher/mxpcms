<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="0" border="0" class="forumline">
	<!-- BEGIN no_row -->
	<tr>
		<td class="row1" align="left" colspan="2">{no_row.L_NO_ITEMS}</td>
	</tr>
	<!-- END no_row -->
	<!-- BEGIN msg_row -->
	<tr>
		<td class="row2" align="center"><span class="cattitle"><img src="{msg_row.FOLDER_IMG}" width="19" height="18" alt="{msg_row.L_TOPIC_FOLDER_ALT}" title="{msg_row.L_TOPIC_FOLDER_ALT}" /></span></td>
		<td class="row1" align="{U_ALIGN}"><span class="genmed"><b><a href="{msg_row.U_LAST_MSG}" target="{U_TARGET}" class="genmed">{msg_row.LAST_MSG}</a></b></span><br /><span class="genmed"><a href="{msg_row.U_FORUM}" target="{U_TARGET}" class="genmed">{msg_row.FORUM_NAME}</a></span><br />
		<div align="right"><span class="gensmall" nowrap="nowrap">{msg_row.LAST_MSG_DATE}</span><span class="gensmall" nowrap="nowrap"> {msg_row.TOPIC_AUTHOR} {msg_row.LAST_POST_AUTHOR}{msg_row.LAST_POST_IMG}</span></div></td>
	</tr>
	<!-- END msg_row -->
	<tr valign="middle">
	<!--
		<td align="center" class="catBottom" height="28" colspan="2">
			<a href="{U_URL_PREV}" class="cattitle"><img src="{TEMPLATE_ROOT_PATH}images/msg_prev.gif" border="0" width="19" height="18" alt="{L_MSG_PREV}" title="{L_MSG_PREV}" /></a>
			<a href="{U_URL_NEXT}" class="cattitle"><img src="{TEMPLATE_ROOT_PATH}images/msg_next.gif" border="0" width="19" height="18" alt="{L_MSG_NEXT}" title="{L_MSG_NEXT}" /></a>
		</td>
	-->
	<!-- <td align="center" valign="top"><span class="catBottom">{PAGE_NUMBER}</span></td> -->
		<td align="right" valign="top" nowrap="nowrap" colspan="2" height="28" class="catBottom"><span class="gensmall">{PAGINATION}</span></td>
	</tr>
</table>