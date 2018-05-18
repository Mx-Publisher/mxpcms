<table width="100%" cellpadding="4" cellspacing="0" border="0" class="forumline">
	<!-- BEGIN no_row -->
	<tr>
		<td class="row1" align="left" colspan="2">{no_row.L_NO_ITEMS}</td>
	</tr>
	<!-- END no_row -->
	<!-- BEGIN msg_row -->
	<tr>
		<td width="5%" class="row2" align="center">
			<span class="cattitle"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{msg_row.FOLDER_IMG}" width="19" height="18" alt="{msg_row.L_TOPIC_FOLDER_ALT}" title="{msg_row.L_TOPIC_FOLDER_ALT}" /></span>
		</td>
		<td class="row1" align="left">
			<span class="gen"><b><a href="{msg_row.U_PAGE}"  target="{U_TARGET}" class="genmed">{msg_row.LAST_PAGE}</a></b></span><br />
			<span class="genmed">&raquo;&nbsp;<a href="{msg_row.U_BLOCK}"  target="{U_TARGET}" class="genmed">{msg_row.LAST_BLOCK}</a></span><br />
			<span class="gensmall"><i>{msg_row.EXTRA}</i>{msg_row.L_BLOCK_UPDATED}{msg_row.EDITOR} ({msg_row.EDIT_TIME}</span>)
		</td>
	</tr>
	<!-- END msg_row -->
	<!--
	<tr valign="middle">
		<td align="center" class="catBottom" height="28" colspan="2">
			<a href="{U_URL_PREV}" class="cattitle"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/msg_prev.gif" border="0" width="19" height="18" alt="{L_MSG_PREV}" title="{L_MSG_PREV}" /></a>
			<a href="{U_URL_NEXT}" class="cattitle"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/msg_next.gif" border="0" width="19" height="18" alt="{L_MSG_NEXT}" title="{L_MSG_NEXT}" /></a>
		</td>
	</tr>
	-->
	<tr>
		<!-- <td align="center" valign="top"><span class="catBottom">{PAGE_NUMBER}</span></td> -->
		<td align="right" valign="top" nowrap="nowrap" colspan="2" class="catBottom"><span class="gensmall">{PAGINATION}</span></td>
	</tr>
</table>
