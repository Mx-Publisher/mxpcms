<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	  <tr>
	    <th class="thHead" colspan="2">META TAGS</th>
  	</tr>
<tr>
  <td class="row1">{L_TITLE}</td>
  <td class="row2"><input type="text" name="title" value="{TITLE}" size="32" /></td>
</tr>
<tr>
  <td class="row1">{L_AUTHOR}</td>
  <td class="row2"><input type="text" name="author" value="{AUTHOR}" size="32" /></td>
</tr>
<tr>
<td class="row1">{L_COPYRIGHT}</td>
<td class="row2"><input type="text" name="copyright" value="{COPYRIGHT}" size="32" /></td>
</tr>
<tr>
  <td class="row1">{L_KEYWORDS}<br />{L_KEYWORDS_EXPLAIN}</td>
  <td class="row2"><input type="text" name="keywords" value="{KEYWORDS}" size="65" /></td>
</tr>
<tr>
<td class="row1">{L_DESCRIPTION}</td>
<td class="row2"><input type="text" name="description" value="{DESCRIPTION}" size="65" /></td>
</tr>
<tr>
  <td class="row1">{L_LANGUAGE}</td>
  <td class="row2">{LANGUAGE}</td>
</tr>
<tr>
  <td class="row1">{L_RATING}</td>
  <td class="row2">{RATING}</td>
  
</tr>
<tr>
  <td class="row1">{L_ROBOTS}</td>
  <td class="row2">{ROBOTS_INDEX}&nbsp;{ROBOTS_FOLLOW}</td>
</tr>
<tr>
  <td class="row1">{L_PRAGMA}</td>
  <td class="row2">
    <input type="checkbox" name="pragma" value="1" {PRAGMA}/>
  </td>
</tr>
<tr>
  <td class="row1">{L_BOOKMARK}<br />{L_BOOKMARK_EXPLAIN}</td>
  <td class="row2">
    <input type="text" name="icon" value="{ICON}" size="34" />
  </td>

</tr>

</table>

<br />
<br />
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	  <tr>
	    <th class="thHead" colspan="2">{L_HTITLE}</th>
  	</tr>
	  <tr align="center">
       <TD class="row2">
          <textarea name="header" rows="6" cols="80">{HEADER}</textarea>
   	   </td>
	  </tr>
<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</table></FORM>
<br clear="all" />