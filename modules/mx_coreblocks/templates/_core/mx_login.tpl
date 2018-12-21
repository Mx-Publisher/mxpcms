<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<tr>
		<td class="row1" valign="middle" height="28">
			<span class="gensmall">
			<form action="{S_LOGIN_ACTION}" method="post">
				{L_USERNAME}:<br /><input class="post" type="text" name="username" size="10" /><br />
				{L_PASSWORD}:<br /><input class="post" type="password" name="password" size="10" /><br />
		  		<!-- BEGIN switch_allow_autologin -->
				<input class="text" type="checkbox" name="autologin" />&nbsp;{L_AUTO_LOGIN}<br />
				<!-- END switch_allow_autologin -->
				<!--<input type="checkbox" class="post" name="autologin" value="ON" />&nbsp;{L_AUTO_LOGIN}<br />-->
				<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
			</form>
			</span>
		</td>
	</tr>
</table>