
<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>

<form action="{S_FORUM_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_DEFAULT_PAGES_TITLE}<br /><span class="gensmall">{L_DEFAULT_PAGES_TITLE_EXPLAIN}</span></th>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_INTEGRATION_ENABLED}<br /><span class="gensmall">{L_PHPBB_INTEGRATION_ENABLED_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="enable_module" value="1" {PHPBB_INTEGRATION_ENABLED_YES} /><span class="gensmall">{L_PHPBB_INTEGRATION_ENABLED_YES}&nbsp;<input type="radio" name="enable_module" value="0" {PHPBB_INTEGRATION_ENABLED_NO} /><span class="gensmall">{L_PHPBB_INTEGRATION_ENABLED_NO}</span></td>
	</tr>	
	<tr>
		<td class="row1" width="50%">{L_PHPBB_OVERRIDE_DEFAULT_PAGES}<br /><span class="gensmall">{L_PHPBB_OVERRIDE_DEFAULT_PAGES_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="override_default_pages" value="1" {OVERRIDE_DEFAULT_PAGES_CHECKBOX_YES} /><span class="gensmall">{L_PHPBB_OVERRIDE_DEFAULT_PAGES_YES}&nbsp;<input type="radio" name="override_default_pages" value="0" {OVERRIDE_DEFAULT_PAGES_CHECKBOX_NO} /><span class="gensmall">{L_PHPBB_OVERRIDE_DEFAULT_PAGES_NO}</span></td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_INDEX}<br /><span class="gensmall">{L_PHPBB_EXPLAIN}</span></td>
		<td class="row2" width="50%">{PHPBB_INDEX}</td>
	</tr>	
	<tr>
	  <th class="thHead" colspan="2">{L_DEFAULT_PAGES_MORE_TITLE}<br /><span class="gensmall">{L_DEFAULT_PAGES_MORE_TITLE_EXPLAIN}</span></th>
	</tr>	
	<tr>
		<td class="row1" width="50%">{L_PHPBB_MEMBERLIST}<br /><span class="gensmall">{L_DEFAULT_PAGES_PROFILECP}</span></td>
		<td class="row2" width="50%">{PHPBB_MEMBERLIST}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_PRIVMSG}<br /><span class="gensmall">{L_DEFAULT_PAGES_PROFILECP}</span></td>
		<td class="row2" width="50%">{PHPBB_PRIVMSG}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_PROFILE}<br /><span class="gensmall">{L_DEFAULT_PAGES_PROFILECP}</span></td>
		<td class="row2" width="50%">{PHPBB_PROFILE}</td>
	</tr>	
	<tr>
		<td class="row1" width="50%">{L_PHPBB_GROUPCP}</td>
		<td class="row2" width="50%">{PHPBB_GROUPCP}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_SEARCH}</td>
		<td class="row2" width="50%">{PHPBB_SEARCH}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_LOGIN}</td>
		<td class="row2" width="50%">{PHPBB_LOGIN}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_FAQ}</td>
		<td class="row2" width="50%">{PHPBB_FAQ}</td>
	</tr>	
	<tr>
		<td class="row1" width="50%">{L_PHPBB_VIEWONLINE}</td>
		<td class="row2" width="50%">{PHPBB_VIEWONLINE}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PHPBB_OTHER}</td>
		<td class="row2" width="50%">{PHPBB_OTHER}</td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
</form>
