	<tr>
		<th class="thHead">{L_PANEL_TITLE}</th>
	</tr>
	<tr>
		<td class="genmed">{L_PANEL_TITLE_EXPLAIN}</td>
	</tr>
	<tr>
		<td align="center">
			{RESULT_MESSAGE}
		</td>
	</tr>


	<tr>
		<td align="center">

			<form action="{S_ACTION}" method="post">
			<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
				<tr>
					<th class="cat" align="left">{L_MAP_PAFILEDB}</th>
					<th class="cat" align="left">{L_MAP_MXBB}</th>
					<th class="cat" align="left"></th>
				</tr>
			<!-- BEGIN map_row -->
				<tr>
					<td class="row1" align="center" valign="top"><select name="map_cat_id_{map_row.CAT_ID}" class="post">{map_row.CAT_LIST}</span></td>
					<td class="row1" align="left" valign="top">{map_row.DYN_LIST}</td>
					<td class="row1" align="left" valign="top"><a href="{map_row.DELETE}">{map_row.L_DELETE}</a></td>
				</tr>
				<!-- END map_row -->
				<tr>
					<td class="cat" colspan="3" align="center">{S_HIDDEN_UPDATE_FIELDS}<input type="submit" name="submit" value="{L_EDIT}" class="mainoption" /></td>
				</tr>
			</table>
			</form>

			<form action="{S_ACTION}" method="post">
			<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
				<tr>
					<th class="cat" align="left">{L_MAP_PAFILEDB}</th>
					<th class="cat" align="left">{L_MAP_MXBB}</th>
				</tr>
				<tr>
					<td align="left" class="row1" width="50%"><select name="map_cat_id" class="post">{S_MAP_CAT_LIST}</select></td>
					<td align="left" class="row1" width="50%">{S_MAP_DYN_LIST}</td>
				</tr>
				<tr>
					<td class="cat" colspan="2" align="center">{S_HIDDEN_ADD_FIELDS}<input type="submit" name="submit" value="{L_ADD}" class="mainoption" /></td>
				</tr>
			</table>
			</form>

		</td>
	</tr>




