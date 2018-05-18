<table class="forumline" cellspacing="1" cellpadding="3" width="100%" style="border-top:none;">
	<tr>
		<td class="catHead" height="28" align="center"><a href="{U_PORTAL_FAQ}" class="nav">{L_PORTAL_FAQ}</a>d</td>
		<td class="catHead" height="28" align="center"><a href="{U_MODULE_FAQ}" class="nav">{L_MODULE_FAQ}</a></td>
		<td class="catHead" height="28" align="center"><a href="{U_FORUM_FAQ}" class="nav">{L_FORUM_FAQ}</a></td>
		<td class="catHead" height="28" align="center"><a href="{U_BBCODE_FAQ}" class="nav">{L_BBCODE_FAQ}</a></td>
	</tr>
	<tr>
		<td colspan="4" class="row1">
			<!-- BEGIN faq_block_link -->
			<span class="gen"><b>{faq_block_link.BLOCK_TITLE}</b></span><br />
			<!-- BEGIN faq_row_link -->
			<span class="gen"><a href="{faq_block_link.faq_row_link.U_FAQ_LINK}" class="postlink">{faq_block_link.faq_row_link.FAQ_LINK}</a></span><br />
			<!-- END faq_row_link -->
			<br />
			<!-- END faq_block_link -->
		</td>
	</tr>
	<tr>
		<td colspan="4" class="catBottom" height="28">&nbsp;</td>
	</tr>
<!-- BEGIN faq_block -->
	<tr>
		<td colspan="4" class="catHead" height="28" align="center"><span class="nav">{faq_block.BLOCK_TITLE}</span></td>
	</tr>
	<!-- BEGIN faq_row -->
	<tr>
		<td colspan="4" class="{faq_block.faq_row.ROW_CLASS}" align="left" valign="top"><span class="genmed"><a name="{faq_block.faq_row.U_FAQ_ID}"></a><b>{faq_block.faq_row.FAQ_QUESTION}</b></span><br /><span class="postbody">{faq_block.faq_row.FAQ_ANSWER}<br /><a class="postlink" href="#Top">{L_BACK_TO_TOP}</a></span></td>
	</tr>
	<tr>
		<td colspan="4" class="spaceRow" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END faq_row -->
<!-- END faq_block -->
</table>
