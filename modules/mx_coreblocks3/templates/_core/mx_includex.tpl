<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border-top:none;">
<!-- BEGIN iframe_mode -->
	<tr>
		<td class="row1" align="left">
			<iframe width="100%" height="{iframe_mode.IFRAME_HEIGHT}" src="{iframe_mode.FILE_URL}" frameborder="0">
				If you can see this, your browser doesn't understand IFRAME. However, we'll still <a href="{iframe_mode.FILE_URL}">link</a> you to the file.
			</iframe>
		</td>
	</tr>
<!-- END iframe_mode -->

<!-- BEGIN textfile_mode -->
	<tr>
		<td class="row1" align="left" >{textfile_mode.FILE_CONTENTS}</td>
	</tr>
<!-- END textfile_mode -->

<!-- BEGIN multimedia_mode -->
	<tr>
		<td class="row1" align="left">
			<div align="center">
				<object width="320" height="315" classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95">
					<param name="src" value="{multimedia_mode.MEDIA_URL}">
					<embed src="/directory/sample.wmv" {multimedia_mode.WIDTH} {multimedia_mode.HEIGHT}
						pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" type="video/x-ms-asf-plugin">
					</embed>
				</object>
				<!-- <embed type="application/x-mplayer2" src="{multimedia_mode.MEDIA_URL}" {multimedia_mode.HEIGHT} {multimedia_mode.WIDTH} border="0" autoplay="TRUE" controller="TRUE" pluginspage="http://www.microsoft.com/windows/windowsmedia/default.asp" ></embed> -->
			</div>
		</td>
	</tr>
<!-- END multimedia_mode -->

<!-- BEGIN pic_mode -->
	<tr>
		<td class="row1" align="left" >{pic_mode.FILE_CONTENTS}</td>
	</tr>
<!-- END pic_mode -->
</table>