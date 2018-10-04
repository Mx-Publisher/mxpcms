<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- IF SET_BASE --><base href="{U_PORTAL_ROOT_PATH}" ><!-- ENDIF -->
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_PHPBB_STYLESHEET}" type="text/css" >
<!-- Then load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" >
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}mx_addon.css" type="text/css" >

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
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<div style="clear:both;margin: 0 auto;">
<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="mx_main_table">
	<tr>
		<td class="leftshadow" width="9" valign="top"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}theme/images/spacer.gif" alt="" width="9" height="1" /></td>
<div id="container_100">

	<!-- Either Simple top image ...
	<img src="{THEME_GRAPHICS}/header.jpg">
	End -->

	<!-- ...or put contents on background top image -->
	<table border="0" cellspacing="0" cellpadding="0" width="750" align="center">
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

	<td class="np-body" width="100%" valign="top">	
	
	<!-- ...or use Generated Navigation Menu -->

		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="mx_main_table">
			<tr>
				<td class="bodyline">

					<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mx_header_table">
						<tr>
							<td class="row2" align="center" valign="middle" colspan="3">
								{OVERALL_NAVIGATION}
							</td>
						</tr>
	<!-- Generated Navigation Menu -->						
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

					</table>
		</div>
		
		<div class="right">
			<span class="genmed"><a href="{U_LOGIN_LOGOUT}" class="genmed">{L_LOGIN_LOGOUT}</a></span>
			<!-- BEGIN switch_user_logged_out -->
			| <span class="genmed"><a href="{U_REGISTER}" class="genmed">{L_REGISTER}</a></span>
			<!-- END switch_user_logged_out -->
		</div>


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
	</div>