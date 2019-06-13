<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" xml:lang="{S_USER_LANG}">
<head>

<meta name="browser" http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=2.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="blue" />
<meta content="text/html" charset="UTF-8" http-equiv="Content-Type" />
<meta name="GENERATOR" content="Kompozer" />

<title>{L_INSTALLATION}</title>

<!--
	  The original subSilver Theme for phpBB version 2+
	  Created by subBlue design
	  http://www.subBlue.com
	  Modified by: FlorinCB aka orynider ( https://www.phpbb.com/community/viewtopic.php?f=596&t=2491526 )
-->

<!-- IF S_ALLOW_CDN -->
<script>
	WebFontConfig = {
		google: {
			families: ['Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese']
		}
	};

	(function(d) {
		var wf = d.createElement('script'), s = d.scripts[0];
		wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js';
		wf.async = true;
		s.parentNode.insertBefore(wf, s);
	})(document);
</script>
<!-- ENDIF -->

<link href="{T_FONT_AWESOME_LINK}" rel="stylesheet" />
<link href="{T_STYLESHEET_LINK}" rel="stylesheet" />
<link href="{T_STYLESHEET_LANG_LINK}" rel="stylesheet" />

	<link href="{T_THEME_PATH}/bidi.css?assets_version={T_ASSETS_VERSION}" rel="stylesheet" />
<!-- ENDIF -->

<!-- IF S_PLUPLOAD -->
	<link href="{T_THEME_PATH}/plupload.css?assets_version={T_ASSETS_VERSION}" rel="stylesheet" />
<!-- ENDIF -->

<!-- IF S_COOKIE_NOTICE -->
	<link href="{T_ASSETS_PATH}/cookieconsent/cookieconsent.min.css?assets_version={T_ASSETS_VERSION}" rel="stylesheet" />
<!-- ENDIF -->

<!--[if lte IE 9]>
	<link href="{T_THEME_PATH}/tweaks.css?assets_version={T_ASSETS_VERSION}" rel="stylesheet" />
<![endif]-->

<!-- EVENT overall_header_head_append -->

<!-- EVENT overall_header_stylesheets_after -->

<!-- IF ENABLE_PM_POPUP -->
<script type="text/javascript"><!--
	if( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
// --></script>
<!-- ENDIF -->

<script type="text/javascript"><!--

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

<script language="javascript1.2" type="text/javascript"><!--
// Import the fancy styles for IE only (NS4.x doesn't use the @import function)
if( document.all ) { document.write('<sty'+'le type="text/css">\n'+
'body {\n'+
'	scrollbar-face-color: #DEE3E7;\n'+
'	scrollbar-highlight-color: #FFFFFF;\n'+
'	scrollbar-shadow-color: #DEE3E7;\n'+
'	scrollbar-3dlight-color: #D1D7DC;\n'+
'	scrollbar-arrow-color:  #006699;\n'+
'	scrollbar-track-color: #EFEFEF;\n'+
'	scrollbar-darkshadow-color: #98AAB1;\n'+
'}\n'+
'input, textarea, select {\n'+
'	border-top-width : 1px;\n'+
'	border-right-width : 1px;\n'+
'	border-bottom-width : 1px;\n'+
'	border-left-width : 1px;\n'+
'}\n'+
'input { text-indent : 2px; }\n'+
'input.button {\n'+
'	border-top-width : 1px;\n'+
'	border-right-width : 1px;\n'+
'	border-bottom-width : 1px;\n'+
'	border-left-width : 1px;\n'+
'}\n<'+'/'+'sty'+'le>'); }
//--></script>

</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center">
	<tr>
		<td class="bodyline" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
								<a href="http://mxpcms.sourceforge.net" target="_blank">
									<img src="{U_LOGO}" border="0" alt="MX-Publisher" vspace="1" />
								</a>
								</td>
								<td align="center" width="100%" valign="middle">
									<span class="maintitle">{L_INSTALLATION}</span>
								</td>
								<td align="center" valign="top">
									<span class="gensmall">{L_PORTAL_NAME}<br />v. {L_PORTAL_VERSION}</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="90%" border="0" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table border="0" align="center" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<span class="gen">{L_INSTRUCTION_TEXT}</span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">