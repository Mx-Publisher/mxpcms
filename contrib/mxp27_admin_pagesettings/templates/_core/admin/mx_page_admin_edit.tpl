
<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form method="post" action="{S_ACTION}"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="5">{L_TITLE}</th>
	</tr>

  <!-- BEGIN pages -->
  <tr>
    <td class="row1">
		<img src="{pages.ICON}">
    <span class="genmed"><a href="{pages.U_PAGES}">{pages.ID}</a>  <a href="{pages.U_PAGES}">{pages.NAME}</a></span>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.U_EDIT}">{L_EDIT}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.U_SETTING}">{L_SETTING}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{pages.U_DELETE}">{L_DELETE}</a></span></td>
  </tr>
  <!-- END pages -->
	<tr>
		<td colspan="7" class="catBottom"><input type="text" name="page_name" /> <input type="submit" class="liteoption"  name="addpage" value="{L_CREATE_PAGE}" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}
</form>

<br clear="all" />