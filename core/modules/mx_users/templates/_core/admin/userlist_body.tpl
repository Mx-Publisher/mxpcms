<script language="javascript" type="text/javascript">
<!--

function handleClick(id) {
	var obj = "";

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id);
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;

		if (!obj) {
			return 1;
		}
		else if (obj.style)
		{
			obj.style.display = ( obj.style.display != "none" ) ? "none" : "";
		}
		else
		{
			obj.visibility = "show";
		}
}
//-->
</script>

<h1>{L_TITLE}</h1>

<p>{L_DESCRIPTION}</p>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td align="left" nowrap="nowrap"><span class="gen"><b>[<a class="gen" href="{U_ADD_USER}" class="gen">{L_ADD_USER}</a>]</b></span></td>
		<td width="100%">&nbsp;</td>
		<td align="right" nowrap="nowrap"><span class="gen">{L_SORT_BY}</td>
		<td nowrap="nowrap"><select name="sort" class="post">
			<option {SORT_USER_ID} value="user_id">{L_USER_ID}</option>
			<option {SORT_ACTIVE} value="user_active">{L_ACTIVE}</option>
			<option {SORT_USERNAME} value="username">{L_USERNAME}</option>
			<option {SORT_JOINED} value="user_regdate">{L_JOINED}</option>
			<option {SORT_ACTIVTY} value="user_session_time">{L_ACTIVTY}</option>
			<option {SORT_USER_LEVEL} value="user_level">{L_USER_LEVEL}</option>
			<option {SORT_POSTS} value="user_posts">{L_POSTS}</option>
			<option {SORT_RANK} value="user_rank">{L_RANK}</option>
			<option {SORT_EMAIL} value="user_email">{L_EMAIL}</option>
		</select></td>
		<td nowrap="nowrap"><select name="order" class="post">
			<option {ORDER_ASC} value="ASC">{L_ASCENDING}</option>
			<option {ORDER_DESC} value="DESC">{L_DESCENDING}</option>
		</select></td>
		<td nowrap="nowrap"><span class="gen">{L_SHOW}</span></td>
		<td nowrap="nowrap"><input type="text" size="5" value="{S_SHOW}" name="show"></td>
		<td nowrap="nowrap">{S_HIDDEN_FIELDS}<input type="submit" value="{S_SORT}" name="change_sort" class="liteoption"></td>
	</tr>
</table>
</form>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<!-- BEGIN alphanumsearch -->
		<td align="left" width="{alphanumsearch.SEARCH_SIZE}"><span class="genmed">
			<a href="{alphanumsearch.SEARCH_LINK}" class="genmed">{alphanumsearch.SEARCH_TERM}</a>
		</span></td>
		<!-- END alphanumsearch -->
	</tr>
</table>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th width="13%">&nbsp;</th>
		<th width="22%">{L_USERNAME}</th>
		<th width="22%">{L_ACTIVE}</th>
		<th width="22%">{L_JOINED}</th>
		<th width="22%">{L_ACTIVTY}</th>
	</tr>
	<!-- BEGIN user_row -->
	<tr>
		<td class="{user_row.ROW_CLASS}" nowrap="nowrap"><input type="checkbox" name="{S_USER_VARIABLE}[]" value="{user_row.USER_ID}">&nbsp;&nbsp;&nbsp;<a href="javascript:handleClick('user{user_row.USER_ID}');">{L_OPEN_CLOSE}</a></td>
		<td class="{user_row.ROW_CLASS}"><span class="gen" {user_row.STYLE_COLOR}><b><a href="{user_row.U_PROFILE}" class="gen" {user_row.STYLE_COLOR}>{user_row.USERNAME}</a></b></span></td>
		<td class="{user_row.ROW_CLASS}"><span class="gen">{user_row.ACTIVE}</span></td>
		<td class="{user_row.ROW_CLASS}"><span class="gen">{user_row.JOINED}</span></td>
		<td class="{user_row.ROW_CLASS}"><span class="gen">{user_row.LAST_ACTIVITY}</span></td>
	</tr>
	<tr id="user{user_row.USER_ID}" style="display: none">
		<td class="{user_row.ROW_CLASS}" width="13%" align="center"><a href="mailto:{user_row.EMAIL}" class="gensmall">[{L_EMAIL}]</a><br /></td>
		<td class="{user_row.ROW_CLASS}" colspan="4" width="100%">
			<table  width="100%" cellpadding="3" cellspacing="1" border="0">
				<tr>
					<!-- BEGIN noninternal -->
					<td class="{user_row.ROW_CLASS}" width="33%"><span class="gen"><b>{L_RANK}:</b> {user_row.RANK} &nbsp; {user_row.I_RANK}</td>
					<!-- END noninternal -->
					<td class="{user_row.ROW_CLASS}" width="34%"><span class="gen"><b>{L_GROUP}:</b>
						<!-- BEGIN group_row -->
						<a href="{user_row.group_row.U_GROUP}" class="gen">{user_row.group_row.GROUP_NAME}</a> ({user_row.group_row.GROUP_STATUS})<br />
						<!-- END group_row -->
						<!-- BEGIN no_group_row -->
						{user_row.no_group_row.L_NONE}<br />
						<!-- END no_group_row -->
					</span></td>
					<!-- BEGIN noninternal -->
					<td class="{user_row.ROW_CLASS}" width="33%"><span class="gen"><b>{L_POSTS}:</b> {user_row.POSTS} &nbsp; <a href="{user_row.U_SEARCH}" class="gen" target="_blank">{L_FIND_ALL_POSTS}</a></span></td>
					<!-- END noninternal -->
				</tr>
				<!-- BEGIN noninternal -->
				<tr>
					<td class="{user_row.ROW_CLASS}"><span class="gen">
						<a href="{user_row.U_MANAGE}" class="gen">{L_MANAGE}</a><br />
						<a href="{user_row.U_PERMISSIONS}" class="gen">{L_PERMISSIONS}</a><br />
						<a href="{user_row.U_PM}" class="gen">{L_PM}</a>
					</span></td>
					<td class="{user_row.ROW_CLASS}">{user_row.I_AVATAR}</td>
					<td class="{user_row.ROW_CLASS}"><span class="gen"><b>{L_WEBSITE}:</b> <a href="{user_row.U_WEBSITE}" class="gen" target="_blank">{user_row.U_WEBSITE}</a></span></td>
				</tr>
				<!-- END noninternal -->
			</table>
		</td>
	</tr>
	<!-- END user_row -->
	<tr>
		<td class="catbottom" colspan="8">
			<select name="mode" class="post">
				<option value="">{L_SELECT}</option>
				<option value="delete">{L_DELETE}</option>
				<!-- BEGIN noninternal -->
				<option value="ban">{L_BAN}</option>
				<!-- END noninternal -->
				<option value="activate">{L_ACTIVATE_DEACTIVATE}</option>
				<option value="group">{L_ADD_GROUP}</option>
			</select>
			<input type="submit" name="go" value="{L_GO}" class="mainoption">
		</td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td align="left" width="50%"><span class="gen">{PAGE_NUMBER}</span></td>
		<td align="right" width="50%"><span class="gen">{PAGINATION}</span></td>
	</tr>
</table>
</form>

<br clear="all" />