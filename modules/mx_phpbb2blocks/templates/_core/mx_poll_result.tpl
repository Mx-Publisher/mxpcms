<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<tr>
		<td class="row1"><br clear="all" />
			<table cellspacing="0" cellpadding="4" border="0" align="center">
				<tr>
					<td align="center"><span class="gen"><a href="{U_URL}"><b>{POLL_QUESTION}</b></a></span></td>
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
											<td><img src="{VOTE_LCAP}" width="4" alt="" height="12" /></td>
											<td><img src="{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
											<td><img src="{VOTE_RCAP}" width="4" alt="" height="12" /></td>
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