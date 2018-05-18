<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- IF SET_BASE --><base href="{U_PORTAL_ROOT_PATH}" ><!-- ENDIF -->
{META}
{NAV_LINKS}

<title>{SITENAME} :: {PAGE_TITLE}</title>

<!-- This should not be included direct from phpBB but later from MXP template folder wich means can be ported to internal backend with no change in this file -->

<!-- Load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" >

<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}admin/admin.css" type="text/css" >

<!-- IF GECKO -->
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" >
<!-- ENDIF -->

{MX_ADDITIONAL_CSS_FILES}
{MX_ICON_CSS}

<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
{MX_ADDITIONAL_JS_FILES}
{MX_ADDITIONAL_HEADER_TEXT}

</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>