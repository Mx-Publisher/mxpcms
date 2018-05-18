<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border-top:none;">


	<!-- BEGIN catrow -->
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="row2" align="left">

						<table width="100%" cellpadding="2" cellspacing="0" border="0" >
							<tr>
								<td class="cat" align="center" width="10" style="border:none;">
									<!-- BEGIN switch_cat_on -->
									<span class="mx_rollup_button" onClick="mx_toggle(this, 'mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}', '{catrow.U_CAT_NAV_EXPAND}', '{catrow.U_CAT_NAV_CONTRACT}');"><img src="{catrow.U_CAT_NAV_CONTRACT}" border="0" /></span>
									<!-- END switch_cat_on -->
									<!-- BEGIN switch_cat_off -->
									<span class="mx_rollup_button" onClick="mx_toggle(this, 'mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}', '{catrow.U_CAT_NAV_EXPAND}', '{catrow.U_CAT_NAV_CONTRACT}');"><img src="{catrow.U_CAT_NAV_EXPAND}" border="0" /></span>
									<!-- END switch_cat_off -->
								</td>
								<td class="cat" align="left" width="100%" style="border:none;">
									<span class="nav">&nbsp;{catrow.CATEGORY}</span>
								</td>
							</tr>
						</table>

					</td>
				</tr>

				<!-- BEGIN switch_cat_desc -->
				<tr>
					<td class="row1" align="left" colspan="2"><span class="genmed">{catrow.switch_cat_desc.CAT_DESC}</span><hr /></td>
				</tr>
				<!-- END switch_cat_desc -->

			</table>
		</td>
	</tr>

	<!-- BEGIN switch_cat_on -->
	<tbody id="mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}" style="display: ;">
	<!-- END switch_cat_on -->

	<!-- BEGIN switch_cat_off -->
	<tbody id="mxNavCat_{catrow.BLOCK_ID}{catrow.CAT_ID}" style="display: none;">
	<!-- END switch_cat_off -->

	<tr>
		<td class="row1">
			<table width="100%" cellpadding="2" cellspacing="0" border="0">

				<!-- BEGIN menurow -->
				<tr>
					<td style="border:none;" class="row1" valign="middle" height="10" align="left" colspan="2" onmouseout="this.className='row1';" onmouseover="this.className='row2';" onclick="window.location.href='{catrow.menurow.U_MENU_URL}';">{catrow.menurow.U_MENU_ICON}<span class="{catrow.menurow.MENU_STYLE}">&nbsp;<a href="{catrow.menurow.U_MENU_URL}" target="{catrow.menurow.U_MENU_URL_TARGET}" class="genmed" title="{catrow.menurow.MENU_DESC}">{catrow.menurow.MENU_NAME}</a></span></td>
				</tr>
				<!-- END menurow -->

			</table>
		</td>
	</tr>

	</tbody>
	<!-- END catrow -->

</table>
