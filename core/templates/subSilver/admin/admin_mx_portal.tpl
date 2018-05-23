<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td>
			<div id="admintabs">
				<ul>
				<li id="gen_sett_tab"><a href="javascript:selectPart('gen_sett')">{L_GENERAL_SETTINGS}</a></li>
				<li id="style_sett_tab"><a href="javascript:selectPart('style_sett')">{L_STYLE_SETTINGS}</a></li>
				<li id="config_info_tab"><a href="javascript:selectPart('config_info')">INFO</a></li>
				</ul>
			</div>
		</td>
	</tr>
</table>

<fieldset id="gen_sett">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_PORTAL_NAME}</td>
		<td class="row2" width="50%"><input type="text" maxlength="150" size="50" name="portal_name" value="{PORTAL_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_PORTAL_STATUS}<br /><span class="gensmall">{L_PORTAL_STATUS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="portal_status" value="1" {S_PORTAL_STATUS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="portal_status" value="0" {S_PORTAL_STATUS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_DISABLED_MESSAGE}</td>
		<td class="row2" width="50%"><textarea rows="5" cols="50" wrap="virtual" name="disabled_message" class="post" />{DISABLED_MESSAGE}</textarea></td>
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
		<td class="row1">{L_SERVER_NAME}</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="server_name" value="{SERVER_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SERVER_PORT}<br /><span class="gensmall">{L_SERVER_PORT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="5" size="5" name="server_port" value="{SERVER_PORT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SCRIPT_PATH}<br /><span class="gensmall">{L_SCRIPT_PATH_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="script_path" value="{SCRIPT_PATH}" /></td>
	</tr>	
	<tr>
		<td class="row1">{L_DATE_FORMAT}<br /><span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="default_dateformat" value="{DEFAULT_DATEFORMAT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SYSTEM_TIMEZONE}</td>
		<td class="row2">{TIMEZONE_SELECT}</td>
	</tr>
	<tr>
		<td class="row1">{L_ENABLE_GZIP}</td>
		<td class="row2"><input type="radio" name="gzip_compress" value="1" {GZIP_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="gzip_compress" value="0" {GZIP_NO} /> {L_NO}</td>
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
</table>
</fieldset>
<fieldset id="portal_back">
</fieldset>
<fieldset id="cookie_sett">
</fieldset>
<fieldset id="style_sett">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_STYLE_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_DEFAULT_LANG}</td>
		<td class="row2">{LANG_SELECT}</td>
	</tr>
	<tr>
		<td class="row1">{L_DEFAULT_STYLE}</td>
		<td class="row2">{STYLE_SELECT}</td>
	</tr>
	<tr>
		<td class="row1">{L_OVERRIDE_STYLE}<br /><span class="gensmall">{L_OVERRIDE_STYLE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="mx_override_user_style" value="1" {OVERRIDE_STYLE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="mx_override_user_style" value="0" {OVERRIDE_STYLE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DEFAULT_ADMIN_STYLE}</td>
		<td class="row2">{ADMIN_STYLE_SELECT}</td>
	</tr>
	<tr>
		<td class="row1">{L_OVERALL_HEADER}</td>
		<td class="row2"><input type="text" maxlength="150" size="50" name="overall_header" value="{OVERALL_HEADER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_OVERALL_FOOTER}</td>
		<td class="row2"><input type="text" maxlength="150" size="50" name="overall_footer" value="{OVERALL_FOOTER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_MAIN_LAYOUT}</td>
		<td class="row2"><input type="text" maxlength="150" size="50" name="main_layout" value="{MAIN_LAYOUT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_NAVIGATION_BLOCK}</td>
		<td class="row2">{NAVIGATION_BLOCK}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOP_PHPBB_LINKS}</td>
		<td class="row2"><input type="radio" name="top_phpbb_links" value="1" {S_TOP_PHPBB_LINKS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="top_phpbb_links" value="0" {S_TOP_PHPBB_LINKS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOWED_TAGS}<br /><span class="gensmall">{L_ALLOWED_TAGS_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="30" maxlength="255" name="allow_html_tags" value="{HTML_TAGS}" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">
		{S_HIDDEN_FIELDS}
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;
		&nbsp;
		<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</fieldset>
<fieldset id="email_sett">
</fieldset>
<fieldset id="config_info">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
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
</fieldset>
</form>
<br clear="all" />
<script type="text/javascript">
<!--
function admingetObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}
function adminsetNone(part)
{
	admingetObj(part + '_tab').className = '';
	admingetObj(part).style.display = 'none';

}
function adminsetBlock(part)
{
	admingetObj(part + '_tab').className = 'activetab';
	admingetObj(part).style.display = 'block';

}
function selectPart(part)
{
	adminsetNone('gen_sett');
	adminsetNone('style_sett');
	adminsetNone('config_info');


	adminsetBlock(part);
}

selectPart('gen_sett');

// -->
</script>
