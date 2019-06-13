<center>
<h1>{L_SHOTCAST_SETTINGS}</h1>
<p>{L_SHOTCAST_SETTINGS_EXPLAIN}<br /></p>
</center>
<form enctype="multipart/form-data" action="{S_ACTION}" method="post">
<table width="640" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_SHOTCAST_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_SHOTCAST}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="shotcast_name" value="{STATION_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_STREAM}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="shotcast_host" value="{STATION_HOST}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PORT}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="shotcast_port" value="{STATION_PORT}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PASS}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="shotcast_pass" value="{STATION_PASS}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PLAY_LIST}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="play_list" value="{PLAY_LIST}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PLAY_HOST}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="play_host" value="{PLAY_HOST}" /></td>
	</tr>	
	<tr>
		<td class="row1"><p><b>{L_PLAY_ASX}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="play_asx" value="{PLAY_ASX}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PLAY_PORT}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="play_port" value="{PLAY_PORT}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PLAY_MOUNT}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="play_mount" value="{PLAY_MOUNT}" /></td>
	</tr>	
	<tr>
		<td class="row1"><p><b>{L_CASTER}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="caster" value="{S_CASTER}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_AUTOPLAY}</span></td>
		<td class="row2"><input type="radio" name="allow_autoplay" value="1" {ALLOW_AUTOPLAY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_autoplay" value="0" {ALLOW_AUTOPLAY_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_PICTURE_TYPE}:</b><br></p></td>
		<td class="row2">{S_PICTURE_TYPE}</td></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_FALLBACK_TO}:</b><br></p></td>
		<td class="row2">{S_FALLBACK_TO}</td></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_CAST_LOGO}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="64" size="54" name="logo" value="{DISPLAY_LOGO}" /></td>		
	</tr>	
	<tr>
		<td class="row1">{L_ALLOW_CURL}</span></td>
		<td class="row2"><input type="radio" name="allow_curl" value="1" {ALLOW_CURL_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_curl" value="0" {ALLOW_CURL_NO} /> {L_NO}</td>
	</tr>	
	<tr>
		<td class="row1"><p><b>{L_CHECK_PERIOD}:</b><br><span class="gensmall">{L_CHECK_PERIOD_EXPLAIN}</span></p></td>
		<td class="row2"><input type="text" maxlength="16" size="16" name="check_period" value="{CHECK_PERIOD}" /></td>
	</tr>
	<tr>
	  <td class="row1"><span class="genmed">{L_FORCE_ONLINE}:</span></td>
	  <td class="row2"><span class="genmed"><input type="radio" {FORCE_ON_ENABLED} name="force_online" value="1" />{L_YES}&nbsp;&nbsp;<input type="radio" {FORCE_ON_DISABLED} name="force_online" value="0" />{L_NO}</span></td>
	</tr>
  	<tr>
		<td class="row1">{L_SHOW_LISTEN}<br><span class="gensmall">{L_SHOW_LISTEN_INFO}</span></td>
		<td class="row2">
		<select name="show_listen_select" class="forminput">
		<option value="1"{S_LISTEN_YES}>{L_YES}</option>
		<option value="0"{S_LISTEN_NO}>{L_NO}</option>	
		</select></td>
  	</tr>
	<tr>
		<td class="row1"><p><b>{L_SKINPATH}:</b><br></p></td>
		<!-- <td class="row2"><input type="text" maxlength="255" size="8" name="SKINpath" value="{SKINPATH}" /></td> -->
		<td class="row2" width="50%">
			<select name="skin" multiple size="8">
    			<!-- BEGIN stylelist -->
			{stylelist.SKINPATH}
    			<!-- END stylelist -->
			</select>
		</td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_STREAM_TYPE}:</b><br></p></td>
		<td class="row2">{STREAM_TYPE}</td></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_SHOW_STATUS}:</b><br></p></td>
		<td class="row2">{SHOW_STATUS}</td></td>
	</tr>
	</tr>
        <tr>
                <td class="row1">{L_ALLOW_GUESTS}</span></td>
                <td class="row2"><input type="radio" name="allow_guests" value="1" {ALLOW_GUESTS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_guests" value="0" {ALLOW_GUESTS_NO} /> {L_NO}</td>
        </tr>
        <tr>
                <td class="row1">{L_GUESTNAME}<br><span class="gensmall">{L_GUESTNAME_EXPLAIN}</span></td>
                <td class="row2"><input class="post" type="text" name="guestname" value="{GUESTNAME}" size="12" maxlength="20" /></td>
        </tr>
	<tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}
			<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
			&nbsp;&nbsp;
			<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>
<br clear="all" />