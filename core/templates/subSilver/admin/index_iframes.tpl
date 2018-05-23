<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
{META}
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
<title>{ADMIN_TITLE}</title>
<!-- IF PHPBB -->
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_PHPBB_STYLESHEET}" type="text/css" >
<!-- ENDIF -->
<!-- Then load MX-Publisher template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" >
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}admin/admin.css" type="text/css" >
<!-- Optionally, redefine some defintions for gecko browsers -->
<!-- IF GECKO -->
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" >
<!-- ENDIF -->
<script type="text/javascript">
//this will disable proxi's in AdminCP
if (top.location != self.location) top.location = self.location.href;
</script>
</head>
<!-- frames -->
<frameset cols="190,*" rows="*" border="1" framespacing="0" frameborder="yes">
	<frame src="{S_FRAME_NAV}" name="nav" marginwidth="3" marginheight="3" scrolling="auto"></frame>
	<frame src="{S_FRAME_MAIN}" name="main" marginwidth="10" marginheight="10" scrolling="auto"></frame>
</frameset>
<!-- frames end -->
<noframes>
	<body bgcolor="#FFFFFF" text="#000000">
		frames not supported
	</body>
</noframes>
<table>
<tr>
<td>
<iframe width="192" height="1200" src="{S_FRAME_NAV}" name="nav" marginwidth="3" marginheight="3" scrolling="auto"></iframe>
</td>
<td>
<iframe width="1024" height="1200" src="{S_FRAME_MAIN}" name="main" marginwidth="10" marginheight="10" scrolling="auto"></frame>
</td>
</tr>
</table>
</html>