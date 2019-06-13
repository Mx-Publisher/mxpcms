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
			document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"{FLASH_WIDTH}\" height=\"{FLASH_HEIGHT}\" align=\"center\">")
			document.writeln("<param name=movie value=\"{CLOCK_SWF}\">");
			document.writeln("<param name=FLASHVARS value=zoomtype=3 />	");
			document.writeln("<param name={COLOR_MODE} value={WMODE}>");
			document.writeln("<param name=quality value=high>");
			document.writeln("<param name=allowfullscreen value=true /");
			document.writeln("<param name=bgcolor value=000000 /");			
			document.writeln("<embed src=\"{CLOCK_SWF}\" {COLOR_MODE}=\"{WMODE}\" quality=high pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"{FLASH_WIDTH}\" height=\"{FLASH_HEIGHT}\">");
			document.writeln("</embed>");
			document.writeln("</object>");
		</SCRIPT>
	</div>
	</td>
  </tr>
<!-- Clock Code: End -->
</table>
