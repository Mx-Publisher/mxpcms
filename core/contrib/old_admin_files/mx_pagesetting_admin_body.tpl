
<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form method="post" action="{S_PAGE_ACTION}">
 <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
 		<th class="thHead" colspan="6">{L_PAGE}&nbsp;&nbsp; {PAGELIST}&nbsp;&nbsp;<input type="submit" class="mainoption" name="cangenow" value="{L_CHANGE_NOW}" />  </th>     
	</tr>
</table>
</form>

<form method="post" action="{S_ACTION}">
	<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="6">{L_TITLE}</th>
	</tr>
	<!-- BEGIN columnrow -->
	<tr>
		<td class="catLeft" ><span class="cattitle"><b><a href="{columnrow.U_VIEWCOLUMN}">{columnrow.COLUMN_DESC}</a></b></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{columnrow.U_COLUMN_EDIT}">{L_EDIT}</a></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{columnrow.U_COLUMN_EDIT}">{L_SETTING}</a></span></td>
		<td class="cat" align="center" valign="middle"><span class="gen"><a href="{columnrow.U_COLUMN_DELETE}">{L_DELETE}</a></span></td>
		<td class="cat" align="center" valign="middle" nowrap="nowrap"><span class="gen"><a href="{columnrow.U_COLUMN_MOVE_UP}">{L_MOVE_UP}</a> <a href="{columnrow.U_COLUMN_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="catRight" align="center" valign="middle"><span class="gen">&nbsp</span></td>
	</tr>
	<!-- BEGIN blockrow -->
	<tr> 
		<td class="row2"><span class="gen">{columnrow.blockrow.BLOCK_NAME}</span><br /><span class="gensmall">{columnrow.blockrow.BLOCK_DESC}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{columnrow.blockrow.U_BLOCK_EDIT}">{L_EDIT}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{columnrow.blockrow.U_BLOCK_SETTING}">{columnrow.blockrow.L_SETTING}</a>&nbsp;</span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{columnrow.blockrow.U_BLOCK_DELETE}">{L_DELETE}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{columnrow.blockrow.U_BLOCK_MOVE_UP}">{L_MOVE_UP}</a> <a href="{columnrow.blockrow.U_BLOCK_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{columnrow.blockrow.U_BLOCK_RESYNC}">{L_RESYNC}</a></span></td>
	</tr>
	<!-- END blockrow -->
	<tr>
		<td colspan="7" class="row2">{columnrow.LIST_BLOCK} {columnrow.S_HIDDEN_FIELDS}<input type="submit" class="liteoption"  name="{columnrow.S_ADD_BLOCK_SUBMIT}" value="{L_CREATE_BLOCK}" /></td>
	</tr>
	<tr>
		<td colspan="7" height="1" class="spaceRow"><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END columnrow -->
	<tr>
		<td colspan="7" class="catBottom"><input type="text" name="columnname" /> <input type="submit" class="liteoption"  name="addcolumn" value="{L_CREATE_COLUMN}" /></td>
	</tr>
	<tr>
		<td colspan="7" class="catBottom"><input type="text" name="pagename" /> <input type="submit" class="liteoption"  name="addpage" value="{L_CREATE_PAGE}" /></td>
	</tr>

</table></form>
