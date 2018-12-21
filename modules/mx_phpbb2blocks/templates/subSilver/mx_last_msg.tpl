<div class="forabg block">

<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<!-- BEGIN no_row -->
	<tr>
		<td width="{BLOCK_SIZE}" class="row1" align="left" colspan="2">{no_row.L_NO_ITEMS}</td>
	</tr>
	<!-- END no_row -->
	<!-- BEGIN msg_row -->
	<tr>
		<td class="row2" align="center">
			<span class="cattitle">
			<!-- IF msg_row.FOLDER_IMG -->
				<div style="float:left">
					<img src="{msg_row.FOLDER_IMG}" width="19" height="18" alt="{msg_row.L_TOPIC_FOLDER_ALT}" title="{msg_row.L_TOPIC_FOLDER_ALT}" />
				</div>
				<!-- ENDIF -->
			</span>
		</td>
	</tr>
	<tr>
		<td class="row1" width="120" align="{U_ALIGN}">

				<dt class="blockbody bg1 content">
					<b><a href="{msg_row.U_LAST_MSG}" target="{U_TARGET}" title="{msg_row.LAST_MSG_ALT}" class="genmed">{msg_row.LAST_MSG}</a></b><br />
					<a href="{msg_row.U_FORUM}" target="{U_TARGET}" title="{msg_row.FORUM_NAME_ALT}" class="gensmall">{msg_row.FORUM_NAME}</a>
				</dt>
				<dt class="blockbody bg2 content" style="text-align:right">
					<span style="white-space:nowrap">{msg_row.LAST_MSG_DATE}</span>
					<span style="white-space:nowrap">{msg_row.TOPIC_AUTHOR} {msg_row.LAST_POST_AUTHOR}{msg_row.LAST_POST_IMG}</span>
				</dt>

		</td>
	</tr>
	<!-- END msg_row -->
	<tr valign="middle">
		<td align="right" valign="top" nowrap="nowrap" colspan="2" height="28" class="cat"><span class="gensmall">{PAGINATION}</span></td>
	</tr>
</table>

</div>