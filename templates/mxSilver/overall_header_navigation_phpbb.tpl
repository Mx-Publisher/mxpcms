<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta name="verify-v1" content="3ezS3iYCRNh3nu59s47WkxxXhKwAw2WKDUFrCmLbfEw=" />
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- BEGIN switch_set_base -->
<base href="{U_PORTAL_ROOT_PATH}" >
<!-- END switch_set_base -->
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- First load standard template *.css definition, located in the the phpbb template folder -->

<!-- Then load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" />
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" />

{MX_ADDITIONAL_CSS_FILES}
{MX_ADDITIONAL_CSS}
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

<script type="text/javascript">
//this will disable google traslate browsing frame, the page still will be traslated but real ip will be returned in Admin Index
if (top.location != self.location) top.location = self.location.href;
</script>

<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

{MX_ADDITIONAL_JS_FILES}
{MX_ADDITIONAL_HEADER_TEXT}

</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="1" border="0" align="center" class="mx_main_table">
	<tr>
		<td class="bodyline">

			<table width="100%" cellspacing="0" cellpadding="2" border="0" class="mx_header_table">
				<tr>
					<td class="row3" width="25%" align="left" valign="top"><a href="{U_INDEX}"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/logo_med.gif" border="0" alt="{L_INDEX}" vspace="1"/></a></td>
					<td class="row3" width="50%" align="center" valign="middle">{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span></td>
					<td class="row3" width="25%" align="right" valign="top"><span class="sitetitle">{SITENAME}</span><br /><span class="sitetitle_desc">{SITE_DESCRIPTION}</span></td>
				</tr>
				<tr>
					<td class="row2" align="center" valign="middle" colspan="3">
						{OVERALL_NAVIGATION}
					</td>
				</tr>
				<tr>
					<td class="row1" align="center" valign="middle" colspan="3">
						<table cellspacing="6" cellpadding="2" border="0" align="center">
							<tr>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu"><img src="{NAV_IMAGES_HOME}"  border="0" alt="{L_HOME}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX_FORUM}" class="mainmenu"><img src="{NAV_IMAGES_FORUM}"  border="0" alt="{L_FORUM}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu"><img src="{NAV_IMAGES_PROFILE}"  border="0" alt="{L_PROFILE}" hspace="3" /></a></span></td>
								<!-- <td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu"><img src="{NAV_IMAGES_HELP}" border="0" alt="{L_FAQ}" hspace="3" /></a></span></span></td> -->
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu"><img src="{NAV_IMAGES_SEARCH}" border="0" alt="{L_SEARCH}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu"><img src="{NAV_IMAGES_MEMBERS}" border="0" alt="{L_MEMBERLIST}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_GROUP_CP}" class="mainmenu"><img src="{NAV_IMAGES_GROUPS}" border="0" alt="{L_USERGROUPS}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="{NAV_IMAGES_PRIVMSG}" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" /></a></span></td>
							</tr>
							<tr>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu">{L_HOME}</a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX_FORUM}" class="mainmenu">{L_FORUM}</a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a></span></td>
								<!-- <td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a></span></td> -->
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu">{L_PRIVATEMSGS}</a></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- BEGIN editcp -->
				<tr>
					<td class="row2" align="center" valign="middle" colspan="3">
						<div class="editCP_switch" style="display: {editcp.EDITCP_SHOW};">
							<form action="{editcp.EDIT_ACTION}" method="post" class="mx_editform">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td align="right">
											{editcp.EDIT_IMG}
											{editcp.S_HIDDEN_FORM_FIELDS}
										</td>
									</tr>
								</table>
							</form>
						</div>
					</td>
				</tr>
				<!-- END editcp -->


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
					<td height="15" align="center" valign="middle" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_login.gif" border="0" alt="{L_LOGIN_LOGOUT}" hspace="1" /></a></span></td>
					<td height="15" align="center" valign="middle" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}&nbsp;</a></span></td>
					<!-- IF USER_LOGGED_OUT -->
					<td height="15" align="center" valign="middle" nowrap><a href="{U_REGISTER}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_register.gif" border="0" alt="{L_REGISTER}" hspace="3" /></a></span></td>
					<td height="15" align="center" valign="middle" nowrap><a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a></span></td>
					<!-- ENDIF -->
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

			<!-- IF PHPBB_STATS -->
			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td align="left" valign="top" ><span class="gensmall">
						<!-- IF USER_LOGGED_IN -->
						{LAST_VISIT_DATE}<br />
						<!-- ENDIF -->
						{CURRENT_TIME}<br /></span>
					</td>
					<td align="right" valign="top" >
						<!-- IF USER_LOGGED_IN -->
						<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
						<!-- ENDIF -->
						<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
					</td>
				</tr>
			</table>
			<!-- ENDIF -->
