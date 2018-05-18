
<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form method="post" action="{S_ACTION}"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="6">{L_MENU_TITLE}</th>
	</tr>
	<!-- BEGIN blockrow -->
	<tr> 
		<td class="row2"><span class="gen">{blockrow.BLOCK_TITLE}</span><br /><span class="gensmall">{blockrow.BLOCK_DESC}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{blockrow.U_BLOCK_EDIT}">{L_EDIT}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{blockrow.U_BLOCK_SETTING}">{blockrow.L_SETTING}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{blockrow.U_BLOCK_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<!-- END blockrow -->
	<tr>
		<td colspan="7" class="row2"><input type="text" name="block_name" /> <input type="submit" class="liteoption"  name="{S_ADD_BLOCK_SUBMIT}" value="{L_CREATE_BLOCK}" /></td>
	</tr>
</table></form>
