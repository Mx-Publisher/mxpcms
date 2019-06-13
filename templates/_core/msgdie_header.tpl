<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
	<META name="robots" content="INDEX, FOLLOW">
	<META name="robots" content="INDEX, FOLLOW">
	<meta name="category"    content="general" />
	<meta name="robots"      content="index,follow" />
	<meta name="revisit-after" content="7 days" >
	<title>{SITENAME} :: {PAGE_TITLE}</title>
	
	<link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}_core.css" type="text/css" />

<!-- Optionally, redefine some defintions for gecko browsers -->
<style type="text/css">
<!--
/* General page style. The scroll bar colours only visible in IE5.5+ */
body {
	padding:0px; scrollbar-face-color: #BADBF5;
	scrollbar-highlight-color: #E3F0FB;
	scrollbar-shadow-color: #BADBF5;
	scrollbar-3dlight-color: #80BBEC;
	scrollbar-arrow-color:  #072978;
	scrollbar-track-color: #DAECFA;
	scrollbar-darkshadow-color: #4B8DF1;
	BACKGROUND: url('{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/images/backgroundbluelight.gif');
	COLOR: #000000;
	font-style:normal; font-variant:normal; font-weight:normal; font-size:10pt; font-family:Fixedsys, geneva, lucida, lucida grande, arial, helvetica, sans-serif; margin-left:10px; margin-right:10px; margin-top:5px; margin-bottom:10px
}
</style>

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
		window.open('/www.google.com/search?q=' + document.search_block.search_keywords.value, '_google', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'site')
	{
		window.open('../forum/index.php?page=5&mode=results&search_terms=all&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'kb')
	{
		window.open('../forum/index.php?page=&mode=search&search_terms=all&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'pafiledb')
	{
		window.open('../forum/index.php?page=&action=search&search_terms=all&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
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

//Arrow Head title
//change title text to your own
    var titletext="{words:index of} {info:dir} @ pubory"
    var thetext=""
    var started=false
    var step=0
    var times=1

    function welcometext()
    {
      times--
      if (times==0)
      {
        if (started==false)
        {
          started = true;
          document.title = titletext;
          setTimeout("anim()",1);
        }
        thetext = titletext;
      }
    }

    function showstatustext(txt)
    {
      thetext = txt;
      setTimeout("welcometext()",4000)
      times++
    }

    function anim()
    {
      step++
      if (step==7) {step=1}
      if (step==1) {document.title='>==='+thetext+'===<'}
      if (step==2) {document.title='=>=='+thetext+'==<='}
      if (step==3) {document.title='>=>='+thetext+'=<=<'}
      if (step==4) {document.title='=>=>'+thetext+'<=<='}
      if (step==5) {document.title='==>='+thetext+'=<=='}
      if (step==6) {document.title='===>'+thetext+'<==='}
      setTimeout("anim()",200);
    }

if (document.title)
window.onload=onload=welcometext

anLoggerToplabs=navigator.appName;	
if(navigator.appName.substring(0,9)=="Microsoft") {anLoggerToplabs="MSIE3";}

// --> </SCRIPT>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
</head>
<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="mx_main_table">
<body class="autoindex_body" bgcolor="#7EB5E8" text="#000000" link="#072978" vlink="#072978">


<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="mx_main_table">
	<tr>
		<td class="bodyline">
			
	<table width="100%" align="center">
	 <TR class="{file:tr_class}" VALIGN="TOP">
	  <TD WIDTH="20%" BGCOLOR="#C0FFFF"><B>File name</B></FONT>
	  &nbsp;  
	  </td>
	  <TD WIDTH="10%" BGCOLOR="#C0FFFF"><B>Size</B></FONT>
	  &nbsp;  
	  </td>
	  <TD WIDTH="20%" BGCOLOR="#C0FFFF"><B>Last update</B></FONT>
	  &nbsp;  
	  </td>
	  {if:description_file}  
	  <TD WIDTH="50%" BGCOLOR="#C0FFFF"><B>Description</B></FONT>
	  &nbsp;
	  </td>
	  {end if:description_file}  
	 </TR>
