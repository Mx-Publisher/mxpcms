			<style type="text/css">
			<!--
			.nav-cat .nav-button {
			    border-width: 1px;
			    border-color: {T_TH_COLOR1};
			    border-style: none none solid none;
			    position: relative;
			}
			.nav-cat .nav-button-current {
				background-color: {T_TR_COLOR1};
			    border-width: 1px;
			    border-color: {T_TH_COLOR1};
			    border-style: solid solid none solid;
			    position: relative;
			}
			td.nav-button {
				background-color: {T_TR_COLOR1};
			}
			td.nav-button-current {
				background-color: {T_TR_COLOR2};
			}
			* html .nav-cat td { position: relative; } /* ie 5.0 fix */
			-->
			</style>			
			
			<table width="100%" cellpadding="0" cellspacing="1" border="0">
				<tr>
					<td class="cat">
						<table cellpadding="0" cellspacing="0" border="0" class="nav-cat" align="center" valign="top">
							<tr>
								<!-- BEGIN catrow -->
								<td align="left" valign="top">
									<div class="nav-button{catrow.CURRENT}">
									<table cellpadding="5" cellspacing="0" border="0">
										<tr>
											<td width="100%" height="30" style="border:none; text-align:center;">
												{catrow.U_MENU_ICON}{catrow.CATEGORY}
											</td>
										</tr>
									</table>
									</div>
								</td>
								<!-- END catrow -->
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<table cellpadding="5" cellspacing="0" border="0" align="center">
				<tr>
					<!-- BEGIN menurow -->
					<td align="center" valign="middle">
						<div class="nav-button{menurow.CURRENT}" onmouseout="this.className='nav-button{menurow.CURRENT}';" onmouseover="this.className='nav-button-current';">{menurow.U_MENU_ICON}<a href="{menurow.U_MENU_URL}" target="{menurow.U_MENU_URL_TARGET}">{menurow.MENU_NAME}</a></div>
					</td>
					<!-- END menurow -->
				</tr>
			</table>