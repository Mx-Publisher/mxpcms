<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_PAGE_ID}</td>
	  <td class="row2"><input type="text" size="5" name="page_id_new" value="{PAGE_ID}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_PAGE_NAME}</td>
	  <td class="row2"><input type="text" size="45" name="page_name" value="{PAGE_NAME}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_PAGE_ICON}</td>
	  <td class="row2">{PAGE_ICON}</td>
	</tr>
	<tr> 
	  <td class="row1">{L_PAGE_HEADER}</td>
	  <td class="row2"><input type="text" size="45" name="page_header" value="{PAGE_HEADER}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_AUTH_TITLE}</td>
  	<td class="row2"> 
      <table cellspacing="1" cellpadding="4" border="0" class="forumline">
    	<tr> 
    	  <!-- BEGIN page_auth_titles -->
    	  <th class="thTop">{page_auth_titles.CELL_TITLE}</th>
    	  <!-- END page_auth_titles -->
    	</tr>
		<!-- BEGIN page_auth_data -->
    	<tr>
    	  <td class="row1" align="center">{page_auth_data.S_AUTH_LEVELS_SELECT}</td>
    	</tr>
		<tr>
			<th class="thTop">{page_auth_data.L_AUTH_GROUP_LEVELS_SELECT}</th>
		</tr>
    	<tr>
    	  <td class="row1" align="center">{page_auth_data.S_AUTH_GROUP_LEVELS_SELECT}</td>
    	</tr>
   	    <!-- END page_auth_data -->
      </table>
  	</td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />

