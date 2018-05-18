<script language="javascript" type="text/javascript" src="{U_CFAQ_JSLIB}"></script>
<noscript>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center" style="border-top:none;">
	<tr>
		<td class="row1" align="center"><span class="gen"><br />{L_CFAQ_NOSCRIPT}<br />&nbsp;</span></td>
	</tr>
</table>
</noscript>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center" style="border-top:none;">
	<tr>
		<td class="catHead" height="28" align="center"><a href="{U_PORTAL_FAQ}" class="nav">{L_PORTAL_FAQ}</a></td>
		<td class="catHead" height="28" align="center"><a href="{U_MODULE_FAQ}" class="nav">{L_MODULE_FAQ}</a></td>
		<td class="catHead" height="28" align="center"><a href="{U_FORUM_FAQ}" class="nav">{L_FORUM_FAQ}</a></td>
		<td class="catHead" height="28" align="center"><a href="{U_BBCODE_FAQ}" class="nav">{L_BBCODE_FAQ}</a></td>
	</tr>
<!-- BEGIN faq_block -->
	<tr>
		<td colspan="4" class="catHead" height="28" align="center"><span class="nav">{faq_block.BLOCK_TITLE}</span></td>
	</tr>
	<!-- BEGIN faq_row -->
	<tr>
 		<td colspan="4" class="{faq_block.faq_row.ROW_CLASS}" align="left" valign="top">
 			<div onclick="return CFAQ.display('faq_a_{faq_block.faq_row.U_FAQ_ID}', false);" style="width:100%;cursor:pointer;cursor:hand;">
				<span class="genmed"><a class="genmed" href="javascript:void(0)" onclick="return CFAQ.display('faq_a_{faq_block.faq_row.U_FAQ_ID}', true);" onfocus="this.blur();"><b>{faq_block.faq_row.FAQ_QUESTION}</b></span></a>
 			</div>
 			<div id="faq_a_{faq_block.faq_row.U_FAQ_ID}" style="display:none;">
				<table class="bodyline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
					<tr>
						<td class="spaceRow"><img src="templates/subSilver/images/spacer.gif" alt="" width="0" height="0" /></td>
					</tr>
					<tr><td align="left" valign="top"><span class="postbody">{faq_block.faq_row.FAQ_ANSWER}<br /></span></td></tr>
					<tr>
						<td class="spaceRow"><img src="templates/subSilver/images/spacer.gif" alt="" width="0" height="0" /></td>
					</tr>
				</table>
			</div>
 		</td>
	</tr>
	<!-- END faq_row -->
<!-- END faq_block -->
</table>
