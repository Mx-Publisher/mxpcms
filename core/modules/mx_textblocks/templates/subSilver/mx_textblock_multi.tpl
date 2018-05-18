<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="0" border="0" class="{BLOCK_STYLE}">

	<!-- <tr> -->
		<!-- BEGIN switch_standard_style -->
		<!-- <th class="thHead" align="left" colspan="2">&nbsp;{L_TITLE}&nbsp;</th> -->
		<!-- END switch_standard_style -->
		<!-- BEGIN switch_no_style -->
		<!-- <td class="row1" align="left" colspan="2"><b>{L_TITLE}</b>&nbsp;</td> -->
		<!-- END switch_no_style -->
	<!-- </tr> -->

	<!-- BEGIN switch_toc -->
	<tr>
		<td class="row1" align="left" colspan="2"><br /><span class="topictitle">{L_TOC}</span><br /><hr /><span class="nav">
			<!-- BEGIN pages -->
			{switch_toc.pages.TOC_ITEM}
			<!-- END pages -->
		</span></td>
	</tr>
	<!-- END switch_toc -->

	<tr>
		<td class="row1" align="left" colspan="2"><span class="{TEXT_STYLE}">{U_TEXT}</span></td>
	</tr>

	<!-- BEGIN switch_pages -->
	<tr>
		<td class="row1" align="center" colspan="2"><span class="nav"><hr />{L_GOTO_PAGE}
			<!-- BEGIN pages -->
			{switch_pages.pages.PAGE_LINK}
			<!-- END pages -->
		</span></td>
	</tr>
	<!-- END switch_pages -->

</table>