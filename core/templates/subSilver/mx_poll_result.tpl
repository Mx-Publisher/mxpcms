<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="0" border="0" class="forumline">
	<tr>
		<th class="thHead" align="left">&nbsp;{L_TITLE}&nbsp;</th>
	</tr>
	<tr>
		<td class="row1"><br clear="all" />
			<table cellspacing="0" cellpadding="4" border="0" align="center">
				<tr>
					<td align="center"><span class="gen"><b>{POLL_QUESTION}</b></span></td>
				</tr>
				<tr>
					<td align="center">
						<table cellspacing="0" cellpadding="2" border="0">
							<!-- BEGIN poll_option -->
							<tr>
								<td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
							</tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/vote_lcap.gif" width="4" alt="" height="12" /></td>
											<td><img src="{U_PHPBB_ROOT_PATH}{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
											<td><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/vote_rcap.gif" width="4" alt="" height="12" /></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center"><span class="gensmall">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;[{poll_option.POLL_OPTION_RESULT}]</span></td>
							</tr>
							<!-- END poll_option -->
						</table>
					</td>
				</tr>
				<tr>
					<td align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
				</tr>
			</table>
			<br clear="all" />
		</td>
	</tr>
</table>
<br clear="all" />