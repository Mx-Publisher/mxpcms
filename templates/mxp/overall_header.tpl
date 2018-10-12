<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html dir="{S_CONTENT_DIRECTION}">
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
<body>

<a name="top"></a>

<div id="container">

	<!-- Either Simple top image ...
	<img src="{THEME_GRAPHICS}/header.jpg">
	End -->

	<!-- ...or put contents on background top image -->
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr height="101">
			<td background="{THEME_GRAPHICS}/top.jpg" width="750">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr height="80">
						<td width="25%" align="left" valign="top">
							<!--<a href="{U_INDEX}"><img src="{LOGO}" border="0" alt="{L_INDEX}" vspace="1"/></a>-->
							<a href="{U_INDEX}"><img width="210" height="75" src="{THEME_GRAPHICS}spacer.gif" border=0 alt="{L_INDEX}" title="{L_INDEX}"></a>
						</td>
						<td width="50%" align="center" valign="middle">
							<!--{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span>-->
						</td>
						<td width="25%" align="right" valign="top"><span class="sitetitle">&nbsp;</td>
					</tr>
					<tr height="21">
						<td width="100%" align="left" valign="middle" colspan="3">
							<img width="5" height="1" src="{THEME_GRAPHICS}spacer.gif" border=0>
							<!--<span class="sitetitle_desc">{SITE_DESCRIPTION}</span>-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- End -->

	<!-- ...or use Generated Navigation Menu -->
	{OVERALL_NAVIGATION}
	<!-- Generated Navigation Menu -->

				</tr>
			</table>
		</div>
		<div class="right">
			<span class="genmed"><a href="{U_LOGIN_LOGOUT}" class="genmed">{L_LOGIN_LOGOUT}</a></span>
			<!-- BEGIN switch_user_logged_out -->
			| <span class="genmed"><a href="{U_REGISTER}" class="genmed">{L_REGISTER}</a></span>
			<!-- END switch_user_logged_out -->
		</div>
	</div>
