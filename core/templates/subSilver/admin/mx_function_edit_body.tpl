<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_MODULE}</td>
	  <td class="row2">{MODULE_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_FUNCTION_NAME}</td>
	  <td class="row2"><input type="text" size="45" name="function_name" value="{FUNCTION_NAME}" class="post" /></td>
	</tr>
	<tr> 
	<tr> 
	  <td class="row1">{L_FUNCTION_DESC}</td>
	  <td class="row2"><input type="text" size="45" name="function_desc" value="{FUNCTION_DESC}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FUNCTION_FILE}</td>
	  <td class="row2"><input type="text" size="45" name="function_file" value="{FUNCTION_FILE}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>

<br />
<h1>{L_PARAMETER_TITLE}</h1>

<P>{L_PARAMETER_TEXT}</p>
<br />
<form method="post" action="{S_ACTION}"><table width="100%" cellspacing="1" cellpadding="5" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop">{L_PARAMETER_ID}</th>
		<th class="thTop">{L_PARAMETER_DESC}</th>
		<th class="thTop">{L_PARAMETER_TYPE}</th>
		<th class="thTop">{L_PARAMETER_DEFAULT}</th>
		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN parameter -->
	<tr>
		<td class="{parameter.ROW_CLASS}">{parameter.PARAMETER_ID}</td>
		<td class="{parameter.ROW_CLASS}">{parameter.PARAMETER_DESC}</td>
		<td class="{parameter.ROW_CLASS}">{parameter.PARAMETER_TYPE}</td>
		<td class="{parameter.ROW_CLASS}">{parameter.PARAMETER_DEFAULT}</td>
		<td class="{parameter.ROW_CLASS}"><a href="{parameter.U_EDIT}">{L_EDIT}</a></td>
		<td class="{parameter.ROW_CLASS}"><a href="{parameter.U_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END parameter -->
	<tr>
		<td class="catBottom" colspan="7" align="center">{S_HIDDEN_FIELDS_PARAM}<input type="submit" name="add_param" value="{L_ADD}" class="mainoption" /></td>
	</tr>
</table></form>
		
<br clear="all" />

