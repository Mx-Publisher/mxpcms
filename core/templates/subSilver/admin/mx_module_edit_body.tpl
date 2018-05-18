<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_MODULE_NAME}</td>
	  <td class="row2"><input type="text" size="45" name="module_name" value="{MODULE_NAME}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_MODULE_DESC}</td>
	  <td class="row2"><input type="text" size="45" name="module_desc" value="{MODULE_DESC}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_MODULE_PATH}</td>
	  <td class="row2"><input type="text" size="45" name="module_path" value="{MODULE_PATH}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_MODULE_INCLUDE_ADMIN}</td>
	  <td class="row2"><input type="checkbox" size="45" name="module_include_admin" value="1" {CHECK_OPT}/></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />

