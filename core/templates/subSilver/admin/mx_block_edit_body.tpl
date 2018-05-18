<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_BLOCK_TITLE}</td>
	  <td class="row2"><input type="text" size="45" name="block_title" value="{BLOCK_TITLE}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_BLOCK_DESC}</td>
	  <td class="row2"><input type="text" size="45" name="block_desc" value="{BLOCK_DESC}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FUNCTION}</td>
	  <td class="row2">{S_FUNCTION_LIST}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_AUTH_TITLE}</td>
  	<td class="row2"> 
      <table cellspacing="1" cellpadding="4" border="0" class="forumline">
    	<tr> 
    	  <!-- BEGIN block_auth_titles -->
    	  <th class="thTop">{block_auth_titles.CELL_TITLE}</th>
    	  <!-- END block_auth_titles -->
    	</tr>
    	<tr>
   	    <!-- BEGIN block_auth_data -->
		<td>
		<table>
		<tr>
    	  	<td class="row1" align="center">{block_auth_data.S_AUTH_LEVELS_SELECT}</td>
		</tr>    	  
		<tr>
			<th class="thTop">{block_auth_data.L_AUTH_GROUP_LEVELS_SELECT}</th>
		</tr>
    	<tr>
    	  	<td class="row1" align="center">{block_auth_data.S_AUTH_GROUP_LEVELS_SELECT}</td>
		</tr>
		</table>
		</td>
		<!-- END block_auth_data -->
    	</tr>
      </table>
  	</td>
	</tr>

	<tr> 
	  <td class="row1">{L_COLUMN}</td>
	  <td class="row2">{S_COLUMN_LIST}</td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />

