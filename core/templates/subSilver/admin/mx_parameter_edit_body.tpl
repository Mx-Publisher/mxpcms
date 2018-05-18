<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_FUNCTION}</td>
	  <td class="row2">{FUNCTION_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_PARAMETER_NAME}</td>
	  <td class="row2"><input type="text" size="45" name="parameter_name" value="{PARAMETER_NAME}" class="post" /></td>
	</tr>
	<tr> 
	<tr> 
	  <td class="row1">{L_PARAMETER_DESC}&nbsp;</td>
	  <td class="row2">{PARAMETER_DESC}&nbsp;</td>
	</tr>
	<tr> 
	  <td class="row1">{L_PARAMETER_TYPE}</td>
	  <td class="row2">{PARAMETER_TYPE}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_PARAMETER_DEFAULT}</td>
	  <td class="row2"><input type="text" size="45" name="parameter_default" value="{PARAMETER_DEFAULT}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_PARAMETER_FUNCTION}</td>
	  <td class="row2"><textarea rows="20" cols="100" wrap="virtual" name="parameter_function" class="post" />{PARAMETER_FUNCTION}</textarea></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>

	
<br clear="all" />

