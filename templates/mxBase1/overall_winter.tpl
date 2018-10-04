<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_HEAD_STYLESHEET}" type="text/css" >
<!-- Then load addon template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}mx_addon.css" type="text/css" >

<!-- Optionally, redefine some defintions for gecko browsers -->
<!-- BEGIN switch_gecko -->
<link rel="stylesheet" href="{TEMPLATE_ROOT_PATH}/gecko.css" type="text/css" > 
<!-- END switch_gecko -->

<!-- BEGIN switch_enable_pm_popup -->
<script language="javascript" type="text/javascript"><!--
	if( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
// --></script>
<!-- END switch_enable_pm_popup -->

<script language="javascript" type="text/javascript"><!--

function newImage(arg) {
	if (document.images) {
		rslt = new Image();
		rslt.src = arg;
		return rslt;
	}
}

function changeImages() {
	if (document.images ) {
		for (var i=0; i<changeImages.arguments.length; i+=2) {
			document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
		}
	}
}

function set_mx_cookie(in_listID, status)
{
    var expDate = new Date();
    // expires in 1 year
    expDate.setTime(expDate.getTime() + 31536000000);
    document.cookie = in_listID + "=" + escape(status) + "; expires=" + expDate.toGMTString();
}

function set_phpbb_cookie(cookieName, cookieValue, lifeTime, path, domain, isSecure)
{
    var expDate = new Date();
    // expires in 1 year
    expDate.setTime(expDate.getTime() + 31536000000);

	document.cookie = escape( cookieName ) + "=" + escape( cookieValue ) + 
		";expires=" + expDate.toGMTString() +
		( path ? ";path=" + path : "") + ( domain ? ";domain=" + domain : "") + 
		( isSecure == 1 ? ";secure" : "");
}

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

function full_img(url) {
	var url = url;
	window.open(url,'','scrollbars=1,toolbar=0,resizable=1,menubar=0,directories=0,status=0, width=img.width, height=img.height');
	return;
}
			
// --></script>
<script language="javascript" type="text/javascript" src="templates/rollout.js"></script>
<script language="javascript" type="text/javascript" src="templates/rollout_main.js"></script>
<script language="javascript" type="text/javascript" src="templates/dynifs.js"></script>
<SCRIPT language=javascript>
// Author: Eric King Url: http://redrival.com/eak/index.shtml
// This script is free to use as long as this info is left in
// Courtesy of SimplytheBest.net - http://simplythebest.net/scripts/
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable=no'
win = window.open(mypage,myname,settings)
}
</SCRIPT>
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<script type="text/javascript">

/******************************************
* Snow Effect Script- By Altan d.o.o. (http://www.altan.hr/snow/index.html)
* Visit Dynamic Drive DHTML code library (http://www.dynamicdrive.com/) for full source code
* Last updated Nov 9th, 05' by DD. This notice must stay intact for use
******************************************/
  
  //Configure below to change URL path to the snow image
  var snowsrc="snow.gif"
  // Configure below to change number of snow to render
  var no = 10;
  // Configure whether snow should disappear after x seconds (0=never):
  var hidesnowtime = 0;
  // Configure how much snow should drop down before fading ("windowheight" or "pageheight")
  var snowdistance = "pageheight";

///////////Stop Config//////////////////////////////////

  var ie4up = (document.all) ? 1 : 0;
  var ns6up = (document.getElementById&&!document.all) ? 1 : 0;

	function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
	}

  var dx, xp, yp;    // coordinate and position variables
  var am, stx, sty;  // amplitude and step variables
  var i, doc_width = 800, doc_height = 600; 
  
  if (ns6up) {
    doc_width = self.innerWidth;
    doc_height = self.innerHeight;
  } else if (ie4up) {
    doc_width = iecompattest().clientWidth;
    doc_height = iecompattest().clientHeight;
  }

  dx = new Array();
  xp = new Array();
  yp = new Array();
  am = new Array();
  stx = new Array();
  sty = new Array();
  snowsrc=(snowsrc.indexOf("dynamicdrive.com")!=-1)? "snow.gif" : snowsrc
  for (i = 0; i < no; ++ i) {  
    dx[i] = 0;                        // set coordinate variables
    xp[i] = Math.random()*(doc_width-50);  // set position variables
    yp[i] = Math.random()*doc_height;
    am[i] = Math.random()*20;         // set amplitude variables
    stx[i] = 0.02 + Math.random()/10; // set step variables
    sty[i] = 0.7 + Math.random();     // set step variables
		if (ie4up||ns6up) {
      if (i == 0) {
        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"; VISIBILITY: visible; TOP: 15px; LEFT: 15px;\"><a href=\"http://dynamicdrive.com\"><img src='"+snowsrc+"' border=\"0\"><\/a><\/div>");
      } else {
        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"; VISIBILITY: visible; TOP: 15px; LEFT: 15px;\"><img src='"+snowsrc+"' border=\"0\"><\/div>");
      }
    }
  }

  function snowIE_NS6() {  // IE and NS6 main animation function
    doc_width = ns6up?window.innerWidth-10 : iecompattest().clientWidth-10;
		doc_height=(window.innerHeight && snowdistance=="windowheight")? window.innerHeight : (ie4up && snowdistance=="windowheight")?  iecompattest().clientHeight : (ie4up && !window.opera && snowdistance=="pageheight")? iecompattest().scrollHeight : iecompattest().offsetHeight;
    for (i = 0; i < no; ++ i) {  // iterate for every dot
      yp[i] += sty[i];
      if (yp[i] > doc_height-50) {
        xp[i] = Math.random()*(doc_width-am[i]-30);
        yp[i] = 0;
        stx[i] = 0.02 + Math.random()/10;
        sty[i] = 0.7 + Math.random();
      }
      dx[i] += stx[i];
      document.getElementById("dot"+i).style.top=yp[i]+"px";
      document.getElementById("dot"+i).style.left=xp[i] + am[i]*Math.sin(dx[i])+"px";  
    }
    snowtimer=setTimeout("snowIE_NS6()", 10);
  }

	function hidesnow(){
		if (window.snowtimer) clearTimeout(snowtimer)
		for (i=0; i<no; i++) document.getElementById("dot"+i).style.visibility="hidden"
	}
		

if (ie4up||ns6up){
    snowIE_NS6();
		if (hidesnowtime>0)
		setTimeout("hidesnow()", hidesnowtime*1000)
		}

</script>

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="mx_main_table">
	<tr>
		<td class="bodyline">

			<table width="100%" cellspacing="0" cellpadding="5" border="0" class="mx_header_table">
				<tr>
					<td class="row2" width="25%" align="center" valign="top">
					</td>
					<td class="row2" width="37%" align="center" valign="top">
					<!--webbot CLIENTSIDE bot="Ws4FpEx" MODULEID="'Default (Project)\meniu1_off.xws'" PREVIEW="&lt;img src='meniu1/meniu1.gif?00741EED' editor='Webstyle4' border='0'&gt;" startspan  --><script src="templates/xaramenu.js"></script><script Webstyle4 src="meniu1/meniu1.js"></script><noscript><img src="meniu1/meniu1.gif?00741EED" editor="Webstyle4"></noscript>
					<!--webbot bot="Ws4FpEx" endspan i-checksum="22443"  -->
					</td>
					<td class="row2" width="38%" align="right" valign="top"></td>
				</tr>
				<tr>
					<td class="row2" width="25%" align="left" valign="top"><a href="{U_INDEX}"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/logo_mxBB.gif" border="0" alt="{L_INDEX}" vspace="1"/></a></td>
					<td class="row2" width="50%" align="center" valign="middle">{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span><hr class="hrtop"></td>
					<td class="row2" width="25%" align="right" valign="top"><span class="sitetitle"><b>{SITENAME}</b></span><br /><span class="sitetitle_desc">{SITE_DESCRIPTION}&nbsp; </span></td>
				</tr>
				<tr>
					<td class="row1" align="center" valign="middle" colspan="3">
						<table cellspacing="6" cellpadding="2" border="0">
							<tr>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_home.gif"  border="0" alt="{L_HOME}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_INDEX_FORUM}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_forum.gif"  border="0" alt="{L_FORUM}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_profile.gif"  border="0" alt="{L_PROFILE}" hspace="3" /></a></span></td>
								<!-- <td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}/images/page_icons/nav_help.gif" border="0" alt="{L_FAQ}" hspace="3" /></a></span></span></td> -->
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_SEARCH}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_search.gif" border="0" alt="{L_SEARCH}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_MEMBERLIST}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_members.gif" border="0" alt="{L_MEMBERLIST}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_GROUP_CP}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_settings.gif" border="0" alt="{L_USERGROUPS}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_email.gif" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" /></a></span></td>
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_login.gif" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" /></a></span></td>

								<!-- BEGIN switch_user_logged_out -->
								<td height="15" align="center" valign="top" nowrap><a href="{U_REGISTER}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_register.gif" border="0" alt="{L_REGISTER}" hspace="3" /></a></span></td>
								&nbsp;
								<!-- END switch_user_logged_out -->
								<td align="center" valign="top" nowrap><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/menu_icons/icon_radio.gif" border="0" alt="Radio Live" hspace="3" /></td>
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
								<td height="15" align="center" valign="top" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}&nbsp;</a></span></td>

								<!-- BEGIN switch_user_logged_out -->
								<td height="15" align="center" valign="top" nowrap><a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a></span></td>
								<!-- END switch_user_logged_out -->
								<td align="center" valign="top" nowrap><a href="http://radio.ministry.ro/radioplayer/radioplayer.php?lang=&z=wmp" class="mainmenu" onclick="NewWindow(this.href,'name','350','130','no');return false">Radio Live</a></td>
							</tr>
						</table>
					</td>
				</tr>

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
					<td valign="top" align="left" width="5" height="5" >&nbsp;</td>
					<td valign="top" align="right" width="100%" height="5" >
						<form name="search_block" method="post" action="{U_SEARCH}" onsubmit="return checkSearch()">
							<a href="{U_SEARCH}"><span class="gen">{L_SEARCH}</span></a>:
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
							<input class="mainoption" type="submit" value="Search">
						</form>
					</td>
					<td valign="top" align="left" width="5" height="5" >&nbsp;</td>
				</tr>
			</table>

			<!-- BEGIN phpbb_stats -->
			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td align="left" valign="top" ><span class="gensmall">
						<!-- BEGIN switch_user_logged_in -->
						{LAST_VISIT_DATE}<br />
						<!-- END switch_user_logged_in -->
						{CURRENT_TIME}<br /></span>
					</td>
					<td align="right" valign="top" >
						<!-- BEGIN switch_user_logged_in -->
						<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
						<!-- END switch_user_logged_in -->
						<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
					</td>
				</tr>
			</table>
			<!-- END phpbb_stats -->
			