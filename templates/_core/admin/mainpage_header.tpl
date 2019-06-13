<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
{META}
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
<title>{SITENAME} - {L_MX_ADMIN}</title>
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}subSilver.css" type="text/css" >
<!-- Then load MX-Publisher template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}subSilver.css" type="text/css" >
<!-- Optionally, redefine some defintions for gecko browsers -->
<!-- BEGIN switch_gecko -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}gecko.css" type="text/css" >
<!-- END switch_gecko -->
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
{MX_ADDITIONAL_CSS}
{MX_ICON_CSS}
</head>
<body class="{S_CONTENT_DIRECTION}">
<table border="0" width="100%" cellspacing="1" cellpadding="4" class="forumline">
<tr>
<td><img src="{LOGO}" alt="logo MX-Publisher" /></td>
<td align="right"><h1>{ADMIN_TITLE}</h1></td>
</tr>
<tr>
<td>{L_LOGGED_IN_AS} <strong>{USERNAME}</strong> [&nbsp;<a href="{U_LOGOUT}">{L_LOGOUT}</a>&nbsp;]</td>
<td align="right"><a href="{U_PORTAL_ADMIN_INDEX}" target="main">{L_ADMIN_INDEX}</a> &bull;
	<a href="{U_PORTAL_INDEX}">{L_PORTAL_INDEX}</a>
</td>
</tr>
</table>
<p id="skip"><a href="#acp">{L_SKIP}</a></p>
