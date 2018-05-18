
<h1>{L_MENU_TITLE}</h1>

<p>{L_MENU_EXPLAIN}</p>

<form method="post" action="{S_MENU_ACTION}"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="7">{L_MENU_TITLE}</th>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<td class="catLeft" ><span class="cattitle"><b><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></b></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{catrow.U_CAT_EDIT}">{L_EDIT}</a></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{catrow.U_CAT_DELETE}">{L_DELETE}</a></span></td>
		<td class="cat" align="center" valign="middle" nowrap="nowrap"><span class="gen"><a href="{catrow.U_CAT_MOVE_UP}">{L_MOVE_UP}</a> <a href="{catrow.U_CAT_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="catRight" align="center" valign="middle"><span class="gen">&nbsp</span></td>
	</tr>
	<!-- BEGIN menurow -->
	<tr> 
		<td class="row2"><span class="gen"><a href="{catrow.menurow.U_VIEWMENU}" target="_new">{catrow.menurow.MENU_NAME}</a></span><br /><span class="gensmall">{catrow.menurow.MENU_DESC}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{catrow.menurow.U_MENU_EDIT}">{L_EDIT}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.menurow.U_MENU_DELETE}">{L_DELETE}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{catrow.menurow.U_MENU_MOVE_UP}">{L_MOVE_UP}</a> <a href="{catrow.menurow.U_MENU_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.menurow.U_MENU_RESYNC}">{L_RESYNC}</a></span></td>
	</tr>
	<!-- END menurow -->
	<tr>
		<td colspan="7" class="row2"><input type="text" name="{catrow.S_ADD_MENU_NAME}" /> <input type="submit" class="liteoption"  name="{catrow.S_ADD_MENU_SUBMIT}" value="{L_CREATE_MENU}" /></td>
	</tr>
	<tr>
		<td colspan="7" height="1" class="spaceRow"><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END catrow -->
	<tr>
		<td colspan="7" class="catBottom"><input type="text" name="categoryname" />&nbsp;{S_SHOW_CAT}&nbsp;<input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
	</tr>
	<tr>
		<td colspan="7" class="cat" align="center" valign="middle"><span class="gen"><a href="{U_RETURN}">{L_RETURN}</a></span></td>
	</tr>
</table></form>
