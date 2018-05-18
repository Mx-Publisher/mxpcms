<!-- BEGIN switch_are_you_sure -->
<script language="javascript1.2" type="text/javascript"><!--
function areYouSure()
{
	return confirm('{L_ARE_YOU_SURE}');
}
//--></script>
<!-- END switch_are_you_sure -->
<form name="frmInstall" action="{S_FORM_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="catbottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input
<!-- BEGIN switch_are_you_sure -->
			onclick="return areYouSure();"
<!-- END switch_are_you_sure -->
			class="mainoption" type="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>
</form>