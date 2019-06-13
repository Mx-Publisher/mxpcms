<!-- BEGIN ulist_open --><ul><!-- END ulist_open -->
<!-- BEGIN ulist_close --></ul><!-- END ulist_close -->

<!-- BEGIN olist_open --><ol type="{LIST_TYPE}"><!-- END olist_open -->
<!-- BEGIN olist_close --></ol><!-- END olist_close -->

<!-- BEGIN mlist_open --><ml style="list-style-type: {LIST_TYPE}"><!-- END olist_open -->
<!-- BEGIN mlist_close --></ml><!-- END olist_close -->

<!-- BEGIN listitem --><li><!-- END listitem -->

<!-- BEGIN quote_username_open --></span>
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr> 
	  <td><span class="genmed"><b>{USERNAME} {L_WROTE}:</b></span></td>
	</tr>
	<tr>
	  <td class="quote"><!-- END quote_username_open -->
<!-- BEGIN quote_open --></span>
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr> 
	  <td><span class="genmed"><b>{L_QUOTE}:</b></span></td>
	</tr>
	<tr>
	  <td class="quote"><!-- END quote_open -->
<!-- BEGIN quote_close --></td>
	</tr>
</table>
<span class="postbody"><!-- END quote_close -->

<!-- BEGIN code_open --></span>
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr> 
	  <td><span class="genmed"><b>{L_CODE}:</b></span></td>
	</tr>
	<tr>
	  <td class="code"><!-- END code_open -->
<!-- BEGIN code_close --></td>
	</tr>
</table>
<span class="postbody"><!-- END code_close -->


<!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open -->
<!-- BEGIN b_close --></span><!-- END b_close -->

<!-- BEGIN u_open --><span style="text-decoration: underline"><!-- END u_open -->
<!-- BEGIN u_close --></span><!-- END u_close -->

<!-- BEGIN i_open --><span style="font-style: italic"><!-- END i_open -->
<!-- BEGIN i_close --></span><!-- END i_close -->

<!-- BEGIN color_open --><span style="color: {COLOR}"><!-- END color_open -->
<!-- BEGIN color_close --></span><!-- END color_close -->

<!-- BEGIN size_open --><span style="font-size: {SIZE}px; line-height: normal"><!-- END size_open -->
<!-- BEGIN size_close --></span><!-- END size_close -->

<!-- BEGIN img --><img src="{URL}" border="0" /><!-- END img -->

<!-- BEGIN url --><a href="{URL}" target="_blank" class="postlink">{DESCRIPTION}</a><!-- END url -->

<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</a><!-- END email -->

<!-- BEGIN table --><div class="forumbg forumbg-table tables1 {IDENTIFIER}" style="width: {NUMBER}%"><div class="inner"><table class="table1">{TEXT}</table></div></div><!-- END table -->	
<!-- BEGIN table_open -->
<dl class="table1">
<dt></dt>
<dd>
<table class="table1" onclick="selectCode(this); return false;">
<!-- END table_open -->
<!-- BEGIN table_close -->
</table>
</dd>
</dl>
<!-- END table_close -->
<!-- BEGIN tr --><tr class="{IDENTIFIER}">{TEXT}</tr><!-- END tr -->	
<!-- BEGIN th --><th class="{IDENTIFIER}" style="width: {NUMBER}%">{TEXT}</th><!-- END th -->	
<!-- BEGIN td --><td class="{IDENTIFIER}" colspan="{NUMBER}">{TEXT}</td><!-- END td -->	
<!-- BEGIN td_open --><td class="{IDENTIFIER}"><!-- END td_open -->
<!-- BEGIN td_close --></td><!-- END td_close -->	
<!-- BEGIN cell_open --><td style="{CELL}"><!-- END cell_open -->
<!-- BEGIN cell_close --></td><!-- END cell_close -->
<!-- BEGIN thead --><thead>{TEXT}</thead><!-- END thead -->
<!-- BEGIN thead_open --><thead class="{IDENTIFIER}"><!-- END thead_open -->
<!-- BEGIN thead_close --></thead><!-- END thead_close -->	
<!-- BEGIN tbody --><tbody>{TEXT}</tbody><!-- END tbody -->
<!-- BEGIN tbody_open --><tbody class="{IDENTIFIER}"><!-- END tbody_open -->
<!-- BEGIN tbody_close --></tbody><!-- END tbody_close -->	
<!-- BEGIN center --><div style="width: 100%;text-align: center">{TEXT}</div><!-- END center -->
<!-- BEGIN center_open --><div style="width: 100%;text-align: center"><!-- END center_open  -->
<!-- BEGIN center_close --></div><!-- END center_close  -->
<!-- BEGIN align --><span style="text-align:{IDENTIFIER}; display:block;">{TEXT}</span><!-- END align -->
<!-- BEGIN marq_open --><marquee direction="{MARQ}" scrolldelay="120"><!-- END marq_open -->
<!-- BEGIN marq_close --></marquee><!-- END marq_close -->
<!-- BEGIN font_open --><span style="font-family:{FONT}"><!-- END font_open --> 
<!-- BEGIN font_close --></span><!-- END font_close --> 	
<!-- BEGIN float --><span style="float:{IDENTIFIER}">{TEXT}</span><!-- END float -->
<!-- BEGIN float_open --><span style="float:{IDENTIFIER}"><!-- END float_open -->
<!-- BEGIN float_close --></span><!-- END float_close -->				
<!-- BEGIN fa_open --><i aria-hidden="true"><div class="icon fa-<!-- END fa_open -->
<!-- BEGIN fa_close --> fa-fw"></div></i><!-- END fa_close -->
<!-- BEGIN fa_logo_open --><i class="icon fa-<!-- END fa_logo_open -->
<!-- BEGIN fa_logo_close --> fa-fw" aria-hidden="true" style="font-size: 60px;"></i><!-- END fa_logo_close -->
<!-- BEGIN poet_open --><div tag='{POET}' style='display:none'><!-- END poet_open -->
<!-- BEGIN poet_close --></div><script>doPoetry()</script><!-- END poet_close -->
<!-- BEGIN flash --><!-- URL's used in the movie-->
<!-- text used in the movie--> 
<!-- --> 
<div style="text-align:center;">
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH={WIDTH} HEIGHT={HEIGHT}> 
<PARAM NAME=movie VALUE="{URL}"><PARAM NAME=quality VALUE=high> <PARAM NAME=scale VALUE=noborder> <PARAM NAME=wmode VALUE=transparent> <PARAM NAME=bgcolor VALUE=#000000> 
  <EMBED src="{URL}" quality=high scale=noborder wmode=transparent bgcolor=#000000 WIDTH={WIDTH} HEIGHT={HEIGHT} TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">
</EMBED></OBJECT>
</div>
<!-- END flash --> 

<!-- BEGIN GVideo -->
<div style="text-align:center;">
<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="flv_video" name="flv_video" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" align="center" height="500" width="640">
        <param name="movie" value="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"></param>
<embed style="width:640px; height:500px;" id="VideoPlayback"
        align="middle" type="application/x-shockwave-flash"
        src="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"
        allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff"
        scale="noScale" salign="TL"  FlashVars="playerMode=embedded">
</embed>
</object><br />
<a href="http://video.google.com/googleplayer.swf?docId={GVIDEOID}" target="_blank">http://video.google.com/videoplay?docid={GVIDEOID}</a><br />
</div>
<!-- END GVideo -->

<!-- BEGIN ram -->
<embed src="{song_detail.SONG_URL}" align="center" width="{song_detail.WIDTH}" height="{song_detail.HEIGHT}" type="audio/x-pn-realaudio-plugin" console="cons" controls="ControlPanel" autostart="false">
</embed>
<!-- END ram -->

<!-- BEGIN youtube -->
<div style="text-align:center;">
<center>
<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="flv_video" name="flv_video" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" align="center" height="500" width="640">
<param name="movie" value="http://www.youtube.com/v/{YOUTUBEID}"></param>
	<param name="quality" value="high">
	<param name="play" value="true">
	<param name="loop" value="true">
	<param name="scale" value="showall">
	<param name="wmode" value="opaque">
	<param name="devicefont" value="false">
	<param name="bgcolor" value="#ffffff">
	<param name="menu" value="true">
	<param name="allowFullScreen" value="true">
	<param name="allowScriptAccess" value="always">
	<param name="salign" value="">   
   <center><embed src="http://www.youtube.com/v/{YOUTUBEID}" type="application/x-shockwave-flash" width="640" height="500"></embed></center>
</object>
</center><br />
<a href="http://youtube.com/watch?v={YOUTUBEID}" target="_blank">{YOUTUBELINK}</a></div><br />
<!-- END youtube -->

<!-- BEGIN scribd -->
<div style="text-align:center;">
<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="{SCRIBDID}" name="{SCRIBDID}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" height="500" width="640" align="center">
	<param name="movie"   value="{SCRIBDURL}">
	<param name="quality" value="high">
	<param name="play" value="true">
	<param name="loop" value="true">
	<param name="scale" value="showall">
	<param name="wmode" value="opaque">
	<param name="devicefont" value="false">
	<param name="bgcolor" value="#ffffff">
	<param name="menu" value="true">
	<param name="allowFullScreen" value="true">
	<param name="allowScriptAccess" value="always">
	<param name="salign" value="">
<embed src="{SCRIBDURL}" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" play="true" loop="true" scale="showall" wmode="opaque" devicefont="false" bgcolor="#ffffff" name="doc_326877108105255_object" menu="true" allowfullscreen="true" allowscriptaccess="always" salign="" type="application/x-shockwave-flash" align="middle"  height="500" width="100%"></embed>
</object>		
<a title="View Article / Book" href="{SCRIBDURL}" style="margin: 12px auto 6px auto; font-family: Helvetica,Arial,Sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; display: block; text-decoration: underline;">View Article / Book</a> 
</div><br />
<!-- END scribd -->

<!-- BEGIN ipaper -->
<div style="text-align:center;">
<script type="text/javascript" src="http://www.scribd.com/javascripts/view.js"></script>
<script type="text/javascript">
<!-- //
var docId = '{IPAPERID}';
var access_key = '{IPAPERKEY}';
var height = '{HEIGHT}';
var width = '{WIDTH}';

function iPaper(docId, access_key, height, width) {
	var scribd_doc = scribd.Document.getDoc(docId, access_key);	
	scribd_doc.addParam('height', height);
	scribd_doc.addParam('width', width);
	scribd_doc.write('embedded_flash');
}
//-->
</script>		
<a title="View Article / Book" href="{URL}" style="margin: 12px auto 6px auto; font-family: Helvetica,Arial,Sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; display: block; text-decoration: underline;">View Article / Book</a> 
</div>
<!-- END ipaper -->

<!-- BEGIN ipaper_open -->
<div style="text-align:center;">
</div>
<!-- END ipaper_open -->
<!-- BEGIN ipaper_close -->
<br />
<!-- END ipaper_close -->

<!-- BEGIN stream -->
<div style="text-align:center;">
<object id="wmp" width=300 height=70 classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"
codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0"
standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">
<param name="FileName" value="{URL}">
<param name="ShowControls" value="1">
<param name="ShowDisplay" value="0">
<param name="ShowStatusBar" value="1">
<param name="AutoSize" value="1">
<param name="autoplay" value="0">
<embed type="application/x-mplayer2"
pluginspage="http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp"
src="{URL}" name=MediaPlayer2 showcontrols=1 showdisplay=0 showstatusbar=1 autosize=1 autoplay=0 visible=1 animationatstart=0 transparentatstart=1 loop=0 height=70 width=300>
</embed>
</object>
</div>
<!-- END stream -->

<!-- BEGIN video -->
<div style="text-align:center;">
<div align="left"><embed src="{URL}" autoplay="false" width={WIDTH} height={HEIGHT}></embed></div>
</div>
<!-- END video -->

<!-- BEGIN hr --><hr noshade color='#000000' size='1'><!-- END hr -->

<!-- BEGIN fade_open -->
<span style="height: 1; Filter: Alpha(Opacity=100, FinishOpacity=0, Style=1, StartX=0, FinishX=100%)">
<!-- END fade_open -->

<!-- BEGIN fade_close -->
</span>
<!-- END fade_close -->