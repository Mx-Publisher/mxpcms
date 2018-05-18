<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<tr>
		<!-- BEGIN catrow -->
		<td class="row1" align="left" width="{CAT_WIDTH}" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="row2">
						<table width="100%" cellpadding="2" cellspacing="0" border="0">
							<tr>
								<td class="cat" width="10" align="center" valign="middle" style="border:none;">
									<span class="mx_rollup_button" onClick="mx_toggle(this, 'mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}', '{catrow.U_CAT_NAV_EXPAND}', '{catrow.U_CAT_NAV_CONTRACT}');"><img src="{catrow.U_CAT_NAV_DYNAMIC}" border="0" /></span>
								</td>
								<td class="cat" align="left" width="100%" style="border:none;">
									<span class="nav"><b>&nbsp;{catrow.CATEGORY}</b></span>
								</td>
							</tr>
							<tr>
								<td class="row1" align="left" colspan="2"><span class="genmed">{catrow.DESCRIPTION}</span></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tbody id="mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}" style="display: {catrow.CAT_SHOW};">
				<tr>
					<td class="row1" style="border:none;">
						<table width="100%" cellpadding="2" cellspacing="0" border="0">				
			
							<!-- BEGIN modulerow -->
							<tr>
								<td style="border:none;" class="row1" valign="middle" colspan="2" onmouseout="this.className='row1';" onmouseover="this.className='row2';">{catrow.modulerow.U_MENU_ICON}<span class="{catrow.modulerow.MENU_STYLE}"><a href="{catrow.modulerow.U_MENU_MODULE}" target="{catrow.modulerow.U_LINK_TARGET}" class="genmed" title="{catrow.modulerow.MENU_DESC}">{catrow.modulerow.MENU_NAME}</a></span></td>
							</tr>
							<!-- END modulerow -->
			
						</table>
					</td>
				</tr>
				</tbody>		
			</table>
		</td>
		<!-- END catrow -->
	</tr>
</table>
