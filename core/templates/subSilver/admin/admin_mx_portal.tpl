<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PORTAL_NAME}</td>
		<td class="row2" width="50%"><input type="text" maxlength="150" size="50" name="portal_name" value="{PORTAL_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_PORTAL_URL}</td>
		<td class="row2"><input type="text" maxlength="150" size="50" name="portal_url" value="{PORTAL_URL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_PORTAL_PHPBB_URL}</td>
		<td class="row2"><input type="text" maxlength="150" size="50" name="portal_phpbb_url" value="{PORTAL_PHPBB_URL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_TOP_PHPBB_LINKS}</td>
		<td class="row2"><input type="radio" name="top_phpbb_links" value="1" {S_TOP_PHPBB_LINKS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="top_phpbb_links" value="0" {S_TOP_PHPBB_LINKS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_MX_USE_CACHE}<br /><span class="gensmall">{L_MX_USE_CACHE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="mx_use_cache" value="1" {S_MX_USE_CACHE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="mx_use_cache" value="0" {S_MX_USE_CACHE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_MX_MOD_REWRITE}<br /><span class="gensmall">{L_MX_MOD_REWRITE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="mod_rewrite" value="1" {S_MX_MOD_REWRITE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="mod_rewrite" value="0" {S_MX_MOD_REWRITE_NO} /> {L_NO}</td>
	</tr>	
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
	</tr>
	<tr>
		<th class="thHead" colspan="2">{L_GENERAL_CONFIG_INFO}</th>
	</tr>
	<tr>
		<td class="row1">{L_PHPBB_RELATIVE_PATH}</td>
		<td class="row2">{PHPBB_RELATIVE_PATH}</td>
	</tr>
	<tr>
		<td class="row1">{L_PORTAL_VERSION}</td>
		<td class="row2">{PORTAL_VERSION}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_PHPBB_INFO}</th>
	</tr>
	<tr>
		<td class="row1">{L_PHPBB_VERSION}</td>
		<td class="row2">{PHPBB_VERSION}</td>
	</tr>
	<tr>
		<td class="row1">{L_PHPBB_SERVER_NAME}</td>
		<td class="row2">{PHPBB_SERVER_NAME}</td>
	</tr>
	<tr>
		<td class="row1">{L_PHPBB_SCRIPT_PATH}</td>
		<td class="row2">{PHPBB_SCRIPT_PATH}</td>
	</tr>
</table>
</form>
<br clear="all" />