<table width="{BLOCK_SIZE}" align="center" cellpadding="3" cellspacing="1" border="0" class="forumline" style="border-top:none;">
<!-- Clock Code: Start -->
  <tr>
    <td class="catHead" colspan="1" align="center">
			<div id="title" style="text-align: center;">
				<span class="topictitle">{CLOCK_NAME}</span><hr />
			</div>
	</td>
  </tr>
  <tr>
	<td class="row1" align="center" valign="middle">
	<div id="flashplayer" align="center">
	<SCRIPT LANGUAGE="JavaScript">
function AC_AddExtension(src, ext)
{
  if (src.indexOf('?') != -1)
    return src.replace(/\?/, ext+'?'); 
  else
    return src + ext;
}
function AC_Generateobj(objAttrs, params, embedAttrs, parElement) 
{ 
  var str = '<object ';
  for (var i in objAttrs)
    str += i + '="' + objAttrs[i] + '" ';
  str += '>';
  for (var i in params)
    str += '<param name="' + i + '" value="' + params[i] + '" /> ';
  str += '<embed ';
  for (var i in embedAttrs)
    str += i + '="' + embedAttrs[i] + '" ';
  str += ' ></embed></object>';
  if( parElement == "" ) {
	document.write(str);
  } else {
	if( document.getElementById(parElement) ) document.getElementById(parElement).innerHTML = str;
  }
}
function loadFlash() {
  var ret = 
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs, '');
}
function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();    
    switch (currArg){	
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":	
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblClick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "width":
      case "height":
      case "align":
      case "vspace": 
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "id":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}
loadFlash('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0',
'width','{FLASH_WIDTH}','height','{FLASH_HEIGHT}',
'src','http://localtimes.info/acsw/{DESIGN}?ggh=18&gid=&&ggm=9&rnd=0&gha=0&fna=&ghb=0&ghf=0&gbc={GBC}&gfc={GFC}&gtc={GTC}&gnu=http://localtimes.info/{COMUNITY}/{COUNTRY}/{CITY}/widget/',
'allowScriptAccess','always','quality','high','wmode','transparent','pluginspage','http://www.macromedia.com/go/getflashplayer',
'movie','http://localtimes.info/acsw/{DESIGN}?ggh=18&gid=&&ggm=9&rnd=0&gha=0&fna=&ghb=0&ghf=0&gbc={GBC}&gfc={GFC}&gtc={GTC}&gnu=http://localtimes.info/COMUNITY}/{COUNTRY}/{CITY}/widget/');
	</SCRIPT>
</div> 
	
	</td>
  </tr>
<!-- Clock Code: End -->
</table>
