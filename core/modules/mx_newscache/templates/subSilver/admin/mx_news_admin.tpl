<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
 <tr>
	<th class="thHead" colspan="3">{L_NEWS_SETTINGS}</th>
 </tr>
	<tr>
		<td class="row1">{L_NEWS_BLOCK_TITLE}</td>
		<td class="row2"><input type="text" maxlength="255" size="30" name="News_Title" value="{NEWS_TITLE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_NEWS_XML_FILE}</td>
		<td class="row2"><input type="text" maxlength="255" size="70" name="News_Xml_File" value="{NEWS_XML_FILE}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_NEWS_FOLDER}</td>
		<td class="row2"><input type="text" maxlength="255" size="70" name="News_Folder" value="{NEWS_FOLDER}" /></td>
	</tr>

<tr>
	<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
</tr>

</table></form>

<br clear="all" />
