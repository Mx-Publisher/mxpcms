<center><h1>{L_COUNTER_SETTINGS}</h1>
<p>{L_COUNTER_SETTINGS_EXPLAIN}<br /></p></center>

<form enctype="multipart/form-data" action="{S_ACTION}" method=post>
<table width="640" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_COUNTER_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_DIGITS}:</b><br></p></td>
		<td class="row2"><input type="text" maxlength="2" size="4" name="digits" value="{DIGITS}" /></td>
	</tr>
	<tr>
		<td class="row1"><p><b>{L_DIGITPATH}:</b><br></p></td>
		<!-- <td class="row2"><input type="text" maxlength="255" size="8" name="digitpath" value="{DIGITPATH}" /></td> -->
		<td class="row2" width="50%">
			<select name="digitpath" multiple size="8">
    			<!-- BEGIN digitpagelist -->
			{digitpagelist.DIGITPATH}
    			<!-- END digitpagelist -->
			</select>
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}
			<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
			&nbsp;&nbsp;
			<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>

<br>
</form>

<br>
<table width="40%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr><th class="thHead" colspan="7">{L_DIGITPREVIEW}</th></tr>
<tr><td class="row1" align="center">
    <!-- BEGIN digitpreview -->
	{digitpreview.DIGIT_IMAGE}
    <!-- END digitpreview -->
</tr></table>

<br clear="all" />
