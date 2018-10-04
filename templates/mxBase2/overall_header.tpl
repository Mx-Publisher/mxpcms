<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- IF SET_BASE --><base href="{U_PORTAL_ROOT_PATH}" ><!-- ENDIF -->
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- IF PHPBB -->
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_PHPBB_STYLESHEET}" type="text/css" >
<!-- ENDIF -->
<!-- Then load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" >
<!-- Optionally, redefine some defintions for gecko browsers -->
<!-- IF GECKO -->
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" >
<!-- ENDIF -->
{MX_ADDITIONAL_CSS_FILES}
{MX_ICON_CSS}

<!-- IF ENABLE_PM_POPUP -->
<script language="javascript" type="text/javascript"><!--
	if( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
// --></script>
<!-- ENDIF -->

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
	<table border="0" cellspacing="0" cellpadding="0" width=100%>
		<tr height="100">
			<td background="{THEME_GRAPHICS}/top.jpg" width="750">
				<table border=0 cellspacing=0 cellpadding=0 width="100%">
					<tr height="80">
						<td width="25%" align="left" valign="top">
							<!--<a href="{U_INDEX}"><img src="{LOGO}" border="0" alt="{L_INDEX}" vspace="1"/></a>-->
							<a href="{U_INDEX}"><img width="100" height="70" src="{THEME_GRAPHICS}spacer.gif" border=0 alt="{L_INDEX}" title="{L_INDEX}"></a>
						</td>
						<td width="50%" align="center" valign="middle">
							{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span>
						</td>
						<td width="25%" align="right" valign="top"><span class="sitetitle">&nbsp;</td>
					</tr>
					<tr height="20">
						<td width="100%" align="left" valign="top" colspan="3">
							<img width="20" height="1" src="{THEME_GRAPHICS}spacer.gif" border=0>
							<span class="sitetitle_desc">{SITE_DESCRIPTION}</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- End -->

	<div id="header">
	  	<div class="globalNav">
	  		<!-- Either Template Based Navigation Menu...
	  		<span class="genmed"><a href="{U_INDEX}" class="genmed"><img src="{NAV_IMAGES_HOME}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_INDEX}" class="genmed">{L_HOME}</a></span>
	  		| <span class="genmed"><a href="{U_INDEX_FORUM}" class="genmed"><img src="{NAV_IMAGES_FORUM}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_INDEX_FORUM}" class="genmed">{L_FORUM}</a></span>
			<!-- IF USER_LOGGED_IN -->
	  		| <span class="genmed"><a href="{U_PROFILE}" class="genmed"><img src="{NAV_IMAGES_PROFILE}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_PROFILE}" class="genmed">{L_PROFILE}</a></span>
			<!-- ENDIF -->
	  		| <span class="genmed"><a href="{U_SEARCH}" class="genmed"><img src="{NAV_IMAGES_SEARCH}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_SEARCH}" class="genmed">{L_SEARCH}</a></span>
	  		| <span class="genmed"><a href="{U_FAQ}" class="genmed"><img src="{NAV_IMAGES_FAQ}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_FAQ}" class="genmed">{L_FAQ}</a></span>
	  		| <span class="genmed"><a href="{U_MEMBERLIST}" class="genmed"><img src="{NAV_IMAGES_MEMBERS}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_MEMBERLIST}" class="genmed">{L_MEMBERLIST}</a></span>
	  		| <span class="genmed"><a href="{U_GROUP_CP}" class="genmed"><img src="{NAV_IMAGES_GROUPS}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_GROUP_CP}" class="genmed">{L_USERGROUPS}</a></span>
			<!-- IF USER_LOGGED_IN -->
	  		| <span class="genmed"><a href="{U_PRIVATEMSGS}" class="genmed"><img src="{NAV_IMAGES_PRIVMSG}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a></span><span class="genmed"><a href="{U_PRIVATEMSGS}" class="genmed">{L_PRIVATEMSGS}</a></span>
			<!-- ENDIF -->
			End -->

			<!-- ...or use Manual Navigation Menu
			<span class="genmed"><a href="{U_INDEX}" class="genmed">{L_HOME}</a></span>
			| <span class="genmed"><a href="{U_INDEX_FORUM}" class="genmed">{L_FORUM}</a></span>
			End -->

			<!-- ...or use Generated Navigation Menu -->
			{OVERALL_NAVIGATION}
			<!-- Generated Navigation Menu -->

	  	</div>
	</div>

	<div id="subheader">
		<div class="left">
			<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{NAV_IMAGES_LOGIN_LOGOUT}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="genmed"><a href="{U_LOGIN_LOGOUT}" class="genmed">{L_LOGIN_LOGOUT}</a></span>
			<!-- IF USER_LOGGED_OUT -->
			<a href="{U_REGISTER}" class="mainmenu"><img src="{NAV_IMAGES_REGISTER}" class="mx_icon" border="0" alt="" hspace="1" align="middle" /></a><span class="genmed"><a href="{U_REGISTER}" class="genmed">{L_REGISTER}</a></span>
			<!-- ENDIF -->
		</div>
		<div class="right">
			<form name="search_block" method="post" action="{U_SEARCH}" onsubmit="return checkSearch()">
				<a href="{U_SEARCH}" class="gen"><span class="gen">{L_SEARCH}</span></a>:
				<input class="post" type="text" name="search_keywords" size="15" value="...?"
					onfocus="if(this.value=='...?'){this.value='';}"
					onblur="if(this.value==''){this.value='...?';}">
				<select class="post" name="search_engine">
					{L_SEARCH_SITE}
					<!-- {L_SEARCH_FORUM} -->
					{L_SEARCH_KB}
					{L_SEARCH_PAFILEDB}
					{L_SEARCH_GOOGLE}
				</select>
				<input type="hidden" name="search_fields" value="all">
				<input type="hidden" name="show_results" value="topics">
				<input class="mainoption" type="submit" value="Search">
			</form>
		</div>
	</div>