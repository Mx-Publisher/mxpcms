<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css">

<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center"> 
	<tr> 
 		<td class="bodyline">

		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr> 
 				<td align="left" valign="top" width="25%"><a href="{U_INDEX_PORTAL}"><img src="{MX_ROOT_PATH}/{TEMPLATE_ROOT_PATH}/images/banner_mx-system.gif" border="0" alt="{L_INDEX}" vspace="1"/></a><br /><span class="genmed"><b>{SITENAME}</b></span><br /><span style="font-size: 5pt;">{SITE_DESCRIPTION}<br />&nbsp; </span></td>
 				<td align="center" valign="middle" width="50%">{PAGE_ICON}<span style="font-family: Arial; letter-spacing: 0.6em; font-variant: small-caps; font-weight: bolder; font-size: 18pt; color: {T_FONTCOLOR1}"> {L_FORUM} </span><hr></td>
				<td align="right" width="25%" valign="top"></td>
			</tr> 
			<tr> 
				<td align="center" width="100%" valign="middle" colspan="3">
				<table cellspacing="6" cellpadding="2" border="0">
					<tr> 
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX_PORTAL}" class="mainmenu"><img src="{MX_ROOT_PATH}/{TEMPLATE_ROOT_PATH}/images/page_icons/nav_home.gif"  border="0" alt="{L_HOME}" hspace="3" /></a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu"><img src="{MX_ROOT_PATH}/{TEMPLATE_ROOT_PATH}/images/page_icons/nav_forum.gif"  border="0" alt="{L_FORUM}" hspace="3" /></a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_profile.gif"  border="0" alt="{L_PROFILE}" hspace="3" /></a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_help.gif" border="0" alt="{L_FAQ}" hspace="3" /></a></span></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_search.gif" border="0" alt="{L_SEARCH}" hspace="3" /></a></span></td>
            <td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_members.gif" border="0" alt="{L_MEMBERLIST}" hspace="3" /></a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_email.gif" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" /></a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_login.gif" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" /></span></td>
	
						<!-- BEGIN switch_user_logged_out -->
						<td height="15" align="center" valign="top" nowrap><a href="{U_REGISTER}" class="mainmenu"><img src="{MX_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_register.gif" border="0" alt="{L_REGISTER}" hspace="3" /></a></span></td>
						&nbsp;
						<!-- END switch_user_logged_out -->
						</td>
					</tr>
					<tr> 
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX_PORTAL}" class="mainmenu">{L_INDEX}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu">{L_FORUM}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu">{L_PRIVATEMSGS}</a></span></td>
						<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}&nbsp;</span></td>

						<!-- BEGIN switch_user_logged_out -->
						<td height="15" align="center" valign="top" nowrap><a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a></span></td>
						<!-- END switch_user_logged_out -->
						</td>
				</table>
	      </td>
			</tr>
    </td>
 </tr>
</table>

<br />
