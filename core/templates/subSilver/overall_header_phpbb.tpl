<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- BEGIN switch_set_base -->
<base href="{U_PORTAL_ROOT_PATH}" >
<!-- END switch_set_base -->
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_PHPBB_STYLESHEET}" type="text/css" >
<!-- Then load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" >
<!-- Optionally, redefine some defintions for gecko browsers -->
<!-- BEGIN switch_gecko --><link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" ><!-- END switch_gecko -->

{MX_ADDITIONAL_CSS_FILES}
{MX_ICON_CSS}

<!-- BEGIN switch_enable_pm_popup -->
<script language="javascript" type="text/javascript"><!--
	if( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
// --></script>
<!-- END switch_enable_pm_popup -->

<script language="javascript" type="text/javascript"><!--
function checkSearch()
{
	if (document.search_block.search_engine.value == 'google')
	{
		window.open('http://www.google.com/search?q=' + document.search_block.search_keywords.value, '_google', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'site')
	{
		window.open('{U_SEARCH_SITE}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'kb')
	{
		window.open('{U_SEARCH_KB}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'pafiledb')
	{
		window.open('{U_SEARCH_PAFILEDB}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else
	{
		return true;
	}
}
// --></script>

<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
{MX_ADDITIONAL_JS_FILES}
{MX_ADDITIONAL_HEADER_TEXT}

</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="780" cellspacing="0" cellpadding="1" border="0" align="center" class="mx_main_table">
	<tr>
		<td class="bodyline">

			<table width="100%" cellspacing="0" cellpadding="2" border="0" class="mx_header_table">
				<tr>
					<td class="row3" width="25%" align="left" valign="top"><a href="{U_INDEX}"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/logo.gif" border="0" alt="{L_INDEX}" vspace="1"/></a></td>
					<td class="row3" width="50%" align="center" valign="middle">{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span></td>
					<td class="row3" width="25%" align="right" valign="top"><span class="sitetitle">{SITENAME}</span><br /><span class="sitetitle_desc">{SITE_DESCRIPTION}</span></td>
				</tr>
				<tr>
					<td class="row2" align="center" valign="middle" colspan="3">
						{OVERALL_NAVIGATION}
					</td>
				</tr>
				<tr>
					<td class="cat" align="center" valign="middle" colspan="3">
						<table cellspacing="1" cellpadding="1" border="0">
							<tr>
								<td align="center" valign="middle" nowrap >
									<a href="{U_INDEX}" class="mainmenu"><img src="{NAV_IMAGES_HOME}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu">{L_HOME}</a></span>
								</td>
								<td align="center" valign="middle" nowrap>
									<a href="{U_INDEX_FORUM}" class="mainmenu"><img src="{NAV_IMAGES_FORUM}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_INDEX_FORUM}" class="mainmenu">{L_FORUM}</a></span>
								</td>
								<td align="center" valign="middle" nowrap>
									<!-- BEGIN switch_user_logged_in -->
									<a href="{U_PROFILE}" class="mainmenu"><img src="{NAV_IMAGES_PROFILE}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a></span>
									<!-- END switch_user_logged_in -->
								</td>
								<td align="center" valign="middle" nowrap>
									<a href="{U_FAQ}" class="mainmenu"><img src="{NAV_IMAGES_FAQ}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a></span>
								</td>
								<!--
								<td align="center" valign="middle" nowrap>
									<a href="{U_SEARCH}" class="mainmenu"><img src="{NAV_IMAGES_SEARCH}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a></span>
								</td>
								-->
								<td align="center" valign="middle" nowrap>
									<a href="{U_MEMBERLIST}" class="mainmenu"><img src="{NAV_IMAGES_MEMBERS}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a></span>
								</td>
								<td align="center" valign="middle" nowrap>
									<a href="{U_GROUP_CP}" class="mainmenu"><img src="{NAV_IMAGES_GROUPS}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a></span>
								</td>
								<td align="center" valign="middle" nowrap>
								<!-- BEGIN switch_user_logged_in -->
									<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="{NAV_IMAGES_PRIVMSG}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu">{L_PRIVATEMSGS}</a></span>
									<!-- END switch_user_logged_in -->
								</td>
							</tr>

						</table>
					</td>
				</tr>

				<!-- BEGIN switch_view -->
				<tr>
					<td align="left" valign="bottom" colspan="3" ><span class="gensmall">{CURRENT_TIME}</span></td>
				</tr>
				<tr>
					<td align="left" valign="bottom" colspan="3" ><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
				</tr>
				<!-- END switch_view -->

			</table>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td align="center" valign="middle" nowrap>
						<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{NAV_IMAGES_LOGIN_LOGOUT}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}</a></span>
					</td>
					<td align="center" valign="middle" nowrap>
						<!-- BEGIN switch_user_logged_out -->
						<a href="{U_REGISTER}" class="mainmenu"><img src="{NAV_IMAGES_REGISTER}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="mainmenu"><a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a></span>
						<!-- END switch_user_logged_out -->
					</td>
					<td valign="top" align="right" width="100%" height="5" >
						<form name="search_block" method="post" action="{U_SEARCH}" onsubmit="return checkSearch()">
							<a href="{U_SEARCH}" class="gen"><span class="gen">{L_SEARCH}</span></a>:
							<input class="post" type="text" name="search_keywords" size="15" value="...?"
								onfocus="if(this.value=='...?'){this.value='';}"
								onblur="if(this.value==''){this.value='...?';}">
							<select class="post" name="search_engine">
								{L_SEARCH_SITE}
								{L_SEARCH_FORUM}
								{L_SEARCH_KB}
								{L_SEARCH_PAFILEDB}
								{L_SEARCH_GOOGLE}
							</select>
							<input type="hidden" name="search_fields" value="all">
							<input type="hidden" name="show_results" value="topics">
							<input class="mainoption" type="submit" value="{L_SEARCH}">
						</form>
					</td>
					<td valign="top" align="left" width="5" height="5" >&nbsp;</td>
				</tr>
			</table>

			<!-- BEGIN phpbb_stats -->
			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td align="left" valign="top" ><span class="gensmall">
						<!-- BEGIN switch_user_logged_in -->
						{LAST_VISIT_DATE}<br />
						<!-- END switch_user_logged_in -->
						{CURRENT_TIME}<br /></span>
					</td>
					<td align="right" valign="top" >
						<!-- BEGIN switch_user_logged_in -->
						<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
						<!-- END switch_user_logged_in -->
						<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
					</td>
				</tr>
			</table>
			<!-- END phpbb_stats -->
