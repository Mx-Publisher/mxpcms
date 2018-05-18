<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>{L_INSTALLATION}</title>
<!--link rel="stylesheet" href="../templates/subSilver/subSilver.css" type="text/css"-->
<style type="text/css">
<!--
/*
  The original subSilver Theme for phpBB version 2+
  Created by subBlue design
  http://www.subBlue.com

  NOTE: These CSS definitions are stored within the main page body so that you can use the phpBB2
  theme administration centre. When you have finalised your style you could cut the final CSS code
  and place it in an external file, deleting this section to save bandwidth.
*/

/* General page style. The scroll bar colours only visible in IE5.5+ */
body {
	background-color: #E5E5E5;
	scrollbar-face-color: #DEE3E7;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #DEE3E7;
	scrollbar-3dlight-color: #D1D7DC;
	scrollbar-arrow-color:  #006699;
	scrollbar-track-color: #EFEFEF;
	scrollbar-darkshadow-color: #98AAB1;
}

	/*
  This is for the table cell above the Topics, Post & Last posts on the index.php page
  By default this is the fading out gradiated silver background.
  However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
		background-color: #FFFFFF;
		background-image: url(http://localhost/mx/forum/templates/subSilver/images/cellpic2.jpg);
		background-repeat: repeat-y;
}

/* Header cells - the blue and silver gradient backgrounds */
th	{
	color: #FFA34F; font-size: 11px; font-weight : bold;
	background-color: #006699; height: 25px;
	background-image: url(http://localhost/mx/forum/templates/subSilver/images/cellpic3.gif);
}

td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
			background-image: url(http://localhost/mx/forum/templates/subSilver/images/cellpic1.gif);
			background-color:#D1D7DC; border: #FFFFFF; border-style: solid; height: 28px;
}

/*
  Setting additional nice inner borders for the main table cells.
  The names indicate which sides the border will be on.
  Don't worry if you don't understand this, just ignore it :-)
*/
td.cat,td.catHead,td.catBottom {
	height: 29px;
	border-width: 0px 0px 0px 0px;
}
th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {
	font-weight: bold; border: #FFFFFF; border-style: solid; height: 28px;
}
td.row3Right,td.spaceRow {
	background-color: #D1D7DC; border: #FFFFFF; border-style: solid;
}

th.thHead,td.catHead { font-size: 12px; border-width: 1px 1px 0px 1px; }
th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }
th.thRight,td.catRight,td.row3Right	 { border-width: 0px 1px 0px 0px; }
th.thLeft,td.catLeft	  { border-width: 0px 0px 0px 1px; }
th.thBottom,td.catBottom  { border-width: 0px 1px 1px 1px; }
th.thTop	 { border-width: 1px 0px 0px 0px; }
th.thCornerL { border-width: 1px 0px 0px 1px; }
th.thCornerR { border-width: 1px 1px 0px 0px; }

/* The largest text used in the index page title and toptic title etc. */
.maintitle	{
	font-weight: bold; font-size: 22px; font-family: "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif;
	text-decoration: none; line-height : 120%; color : #000000;
}

/* General text */
.gen { font-size : 12px; }
.genmed { font-size : 11px; }
.gensmall { font-size : 10px; }
.gen,.genmed,.gensmall { color : #000000; }
a.gen,a.genmed,a.gensmall { color: #006699; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: #DD6900; text-decoration: underline; }

/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : 11px; color : #000000 }
a.mainmenu		{ text-decoration: none; color : #006699;  }
a.mainmenu:hover{ text-decoration: underline; color : #DD6900; }

/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: 12px ; letter-spacing: 1px; color : #006699}
a.cattitle		{ text-decoration: none; color : #006699; }
a.cattitle:hover{ text-decoration: underline; }

/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: 12px; color : #006699; }
a.forumlink 	{ text-decoration: none; color : #006699; }
a.forumlink:hover{ text-decoration: underline; color : #DD6900; }

/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav			{ font-weight: bold; font-size: 11px; color : #000000;}
a.nav			{ text-decoration: none; color : #006699; }
a.nav:hover		{ text-decoration: underline; }

/* titles for the topics: could specify viewed link colour too */
.topictitle,h1,h2	{ font-weight: bold; font-size: 11px; color : #000000; }
a.topictitle:link   { text-decoration: none; color : #006699; }
a.topictitle:visited { text-decoration: none; color : #5493B4; }
a.topictitle:hover	{ text-decoration: underline; color : #DD6900; }

/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name			{ font-size : 11px; color : #000000;}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : 10px; color : #000000; }

/* The content of the posts (body of text) */
.postbody { font-size : 12px; line-height: 18px}
a.postlink:link	{ text-decoration: none; color : #006699 }
a.postlink:visited { text-decoration: none; color : #5493B4; }
a.postlink:hover { text-decoration: underline; color : #DD6900}

/* Quote & Code blocks */
.code {
	font-family: Courier, 'Courier New', sans-serif; font-size: 11px; color: #006600;
	background-color: #FAFAFA; border: #D1D7DC; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

.quote {
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #444444; line-height: 125%;
	background-color: #FAFAFA; border: #D1D7DC; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

/* Copyright and bottom info */
.copyright		{ font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}
a.copyright		{ color: #444444; text-decoration: none;}
a.copyright:hover { color: #000000; text-decoration: underline;}

/* Form elements */
input,textarea, select {
	color : #000000;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-color : #000000;
}

/* The text input fields background colour */
input.post, textarea.post, select {
	background-color : #FFFFFF;
}

input { text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
	background-color : #EFEFEF;
	color : #000000;
	font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif;
}

/* The main submit button option */
input.mainoption {
	background-color : #FAFAFA;
	font-weight : bold;
}

/* None-bold submit button */
input.liteoption {
	background-color : #FAFAFA;
	font-weight : normal;
}

/* This is the line in the posting page which shows the rollover
  help line. This is actually a text box, but if set to be the same
  colour as the background no one will know ;)
*/
.helpline { background-color: #DEE3E7; border-style: none; }


.mxlink		{ background-color: #E5E5E5; border-style: none; font-weight: bold; font-size: 12px ; letter-spacing: 1px; color : #006699}


/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("../templates/subSilver/formIE.css"); 
-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td class="bodyline" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="../templates/subSilver/images/logo_mx-system.gif" border="0" alt="Forum Home" vspace="1" /></td>
						<td align="center" width="100%" valign="middle"><span class="maintitle">{L_INSTALLATION}</span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td colspan="2"><table width="90%" border="0" align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td><span class="gen">{L_INSTRUCTION_TEXT}</span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td width="100%"><table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
					<form action="{S_FORM_ACTION}" name="install_form" method="post">
					<!-- BEGIN switch_stage_one_install -->
					<tr>
						<th colspan="2">{L_INITIAL_CONFIGURATION}</th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DBMS}: </span></td>
						<td class="row2">{S_DBMS_SELECT}</td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_UPGRADE}:</span></td>
						<td class="row2">{S_UPGRADE_SELECT}</td>
					</tr>
					<tr>
						<th colspan="2">{L_DATABASE_CONFIGURATION}</th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DB_HOST}: </span></td>
						<td class="row2"><input type="text" name="dbhost" value="{DB_HOST}" /><span class="gen">{HOST_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DB_NAME}: </span></td>
						<td class="row2"><input type="text" name="dbname" value="{DB_NAME}" /><span class="gen">{DATABASE_NAME_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DB_USER}: </span></td>
						<td class="row2"><input type="text" name="dbuser" value="{DB_USER}" /><span class="gen">{DATABASE_USERNAME_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DB_PASSWORD}: </span></td>
						<td class="row2"><input type="password" name="dbpasswd" /><span class="gen">{DATABASE_PASSWORD_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_MX_DB_PREFIX}: </span></td>
						<td class="row2"><input type="text" name="mx_prefix" value="{MX_DB_PREFIX}" /><span class="gen">{MX_DB_PREFIX_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_DB_PREFIX}: </span></td>
						<td class="row2"><input type="text" name="prefix" value="{DB_PREFIX}" /><span class="gen">{DB_PREFIX_VALIDATE}</span></td>
					</tr>
					<tr>
						<th colspan="2">{L_PORTAL_CONFIGURATION}</th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_PHPBB_PATH}: </span><br /><span class="gensmall">{L_PATH_EXPLAIN}</span></td>
						<td class="row2"><input type="text" size="100" name="phpbb_path" value="{PHPBB_PATH}" /><br /><span class="gen">{PHPBB_PATH_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_PORTAL_URL}: </span><br /><span class="gensmall">{L_PORTAL_URL_EXPLAIN}</span></td>
						<td class="row2"><input type="text" size="100" name="portal_url" value="{PORTAL_URL}" /><br /><span class="gen">{PORTAL_URL_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_PHPBB_URL}: </span><br /><span class="gensmall">{L_URL_EXPLAIN}</span></td>
						<td class="row2"><input type="text" size="100" name="phpbb_url" value="{PHPBB_URL}" /><br /><span class="gen">{PHPBB_URL_VALIDATE}</span></td>
					</tr>
					<!-- END switch_stage_one_install -->
					<!-- BEGIN switch_error_install -->
					<tr>
						<th colspan="2">{L_ERROR_TITLE}</th>
					</tr>
					<!-- BEGIN error_install -->
					<tr>
						<td class="row1" align="center" colspan="2"><span class="gen" style="color:red;">{switch_error_install.error_install.ERROR}</span></td>
					</tr>
					<!-- END error_install -->
					<!-- END switch_error_install -->
					<!-- BEGIN switch_ftp_file -->
					<tr>
						<th colspan="2">{L_FTP_INFO}</th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_FTP_PATH}</span></td>
						<td class="row2"><input type="text" name="ftp_dir"></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_FTP_USER}</span></td>
						<td class="row2"><input type="text" name="ftp_user"></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_FTP_PASS}</span></td>
						<td class="row2"><input type="password" name="ftp_pass"></td>
					</tr>
					<!-- END switch_ftp_file -->
					<!-- BEGIN switch_ftp_option -->
					<tr>
						<th colspan="2">{L_CHOOSE_FTP}</th>
					</tr>
					<tr>
						<td class="row1" align="right" width="50%"><span class="gen">{L_ATTEMPT_FTP}</span></td>
						<td class="row2"><input type="radio" name="send_file" value="2"></td>
					</tr>
					<tr>
						<td class="row1" align="right" width="50%"><span class="gen">{L_SEND_FILE}</span></td>
						<td class="row2"><input type="radio" name="send_file" value="1"></td>
					</tr>
					<!-- END switch_ftp_option -->
					<!-- BEGIN switch_validate -->
					<tr>
						<th colspan="2">{L_TEMPLATELANGUAGE}</th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_TEMPLATE_VALIDATE}: </span></td>
						<td class="row2"><span class="gen">{TEMPLATE_VALIDATE}</span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen">{L_LANGUAGE_VALIDATE}: </span></td>
						<td class="row2"><span class="gen">{LANGUAGE_VALIDATE}</span></td>
					</tr>
					<tr> 
					  <td class="catbottom" align="center" colspan="2">
 					  {S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /> &nbsp;
					</form>
				  	<form action="{S_FORM_ACTION}" name="reset_form" method="post">
					  {S_HIDDEN_FIELDS_START}<input class="mainoption" type="submit" value="{L_SUBMIT_START}" /> &nbsp;
				  	</form>
				  	<form action="{S_FORM_ACTION}" name="install_form" method="post">
					<input type="hidden" name="dbhost" value="{DB_HOST}" />
					<input type="hidden" name="dbname" value="{DB_NAME}" />
					<input type="hidden" name="dbuser" value="{DB_USER}" />
					<input type="hidden" name="dbpasswd" value="{DB_PASSWD}"/>
					<input type="hidden" name="mx_prefix" value="{MX_DB_PREFIX}" />
					<input type="hidden" name="prefix" value="{DB_PREFIX}" />
					<input type="hidden" name="phpbb_path" value="{PHPBB_PATH}" />
					<input type="hidden" name="portal_url" value="{PORTAL_URL}" />
					<input type="hidden" name="phpbb_url" value="{PHPBB_URL}" />
					  {S_HIDDEN_FIELDS_INSTALL}<input class="mainoption" type="submit" value="{L_SUBMIT_INSTALL}" />
					</form>
					  </td>
					</tr>
					<!-- END switch_validate -->
					
					<!-- BEGIN switch_common_install -->
					<tr> 
					  <td class="catbottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
					</tr>
					<!-- END switch_common_install -->
					<!-- BEGIN switch_upgrade_install -->
					<tr>
						<td class="catbottom" align="center" colspan="2">{L_UPGRADE_INST}</td>
					</tr>
					<tr>
						<td class="catbottom" align="center" colspan="2"><input type="submit" name="upgrade_now" value="{L_UPGRADE_SUBMIT}" /></td>
					</tr>
					<!-- END switch_upgrade_install -->
				</form></table></td>
			</tr>
			<tr>
				<td> For further installation information, consult the main <a href="http://www.mx-system.com/forum/viewtopic.php?t=1224">installation documentation!</a></td>
			</tr>
		</table></td>
	</tr>
</table>

</body>
</html>
