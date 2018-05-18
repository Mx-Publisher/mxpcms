<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<!-- BEGIN switch_is_admin -->
	<tr>
		<td class="cat" align="center" valign="middle" ><span class="gensmall"> {switch_is_admin.L_CHANGE_NOW} </span></td>
	</tr>
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<form method="post" action="{ACTION_URL}">
				{switch_is_admin.STYLE_SELECT}&nbsp;&nbsp;<br />
				<input type="submit" class="mainoption" name="change_default_theme" value="{L_CHANGE_NOW}" />
			</form>
		</td>
	</tr>
	<!-- END switch_is_admin -->
	<!-- BEGIN switch_is_user -->
	<tr>
		<td class="cat" align="center" valign="middle" ><span class="gensmall"> {switch_is_user.L_CHANGE_NOW} </span></td>
	</tr>
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<form method="post" action="{ACTION_URL}">
				{switch_is_user.STYLE_SELECT}&nbsp;&nbsp;<br />
				<input type="submit" class="mainoption" name="change_user_theme" value="{L_CHANGE_NOW}" />
			</form>
		</td>
	</tr>
	<!-- END switch_is_user -->
</table>