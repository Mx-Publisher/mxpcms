
<h1>{L_EDIT_COLUMN}</h1>

<p>{L_EDIT_COLUMN_EXPLAIN}</p>

<form action="{S_FORUM_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_EDIT_COLUMN}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_COLUMN}</td>
	  <td class="row2"><input type="text" size="25" name="column_title" value="{COLUMN_TITLE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_COLUMN_SIZE}</td>
		<td class="row2"><input type="text" maxlength="5" size="5" name="column_size" value="{COLUMN_SIZE}" /></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />
