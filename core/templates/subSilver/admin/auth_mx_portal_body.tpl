
<h1>{L_AUTH_TITLE}</h1>

<p>{L_AUTH_EXPLAIN}</p>

<h2>{PORTAL_NAME}</h2>

<form method="post" action="{S_PORTALAUTH_ACTION}">
  <table cellspacing="1" cellpadding="4" border="0" align="center" class="portalline">
	<tr> 
	  <!-- BEGIN portal_auth_titles -->
	  <th class="thTop">{portal_auth_titles.CELL_TITLE}</th>
	  <!-- END portal_auth_titles -->
	</tr>
	<tr> 
	  <!-- BEGIN portal_auth_data -->
	  <td class="row1" align="center">{portal_auth_data.S_AUTH_LEVELS_SELECT}</td>
	  <!-- END portal_auth_data -->
	</tr>
	<tr> 
	  <td colspan="{S_COLUMN_SPAN}" align="center" class="row1"> <span class="gensmall">{U_SWITCH_MODE}</span></td>
	</tr>
	<tr>
	  <td colspan="{S_COLUMN_SPAN}" class="catBottom" align="center">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	  </td>
	</tr>
  </table>
</form>
