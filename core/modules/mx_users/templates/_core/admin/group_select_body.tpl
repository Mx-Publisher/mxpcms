
<h1>{L_GROUP_TITLE}</h1>

<p>{L_GROUP_EXPLAIN}</p>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_GROUP_SELECT}</th>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center">

			<form method="post" action="{S_GROUP_ACTION}">
			<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
				<!-- BEGIN select_box -->
				<tr>
					<td class="row1" align="center">{S_GROUP_SELECT}&nbsp;&nbsp;<input type="submit" name="edit" value="{L_LOOK_UP}" class="mainoption" />&nbsp;</td>
				</tr>
				<!-- END select_box -->
			</table>
			</form>

		</td>
		<td class="row1" width="50%" align="center">

			<form method="post" action="{S_GROUPCP_ACTION}">
			<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
				<!-- BEGIN select_box -->
				<tr>
					<td class="row1" align="center">{S_GROUP_SELECT}&nbsp;&nbsp;<input type="submit" name="edit" value="{L_CP_UP}" class="mainoption" />&nbsp;</td>
				</tr>
				<!-- END select_box -->
			</table>
			</form>

		</td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="center" colspan="2">
			<form method="post" action="{S_GROUP_ACTION}">
			<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
				<tr>
					<td class="catBottom" align="center">{S_HIDDEN_FIELDS}<input type="submit" class="liteoption" name="new" value="{L_CREATE_NEW_GROUP}" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
