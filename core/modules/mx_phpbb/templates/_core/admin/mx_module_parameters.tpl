				<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>

				<tr>
					<td width="100%" colspan="2">
						<!-- BEGIN switch_forums_phpbb -->
						<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
							<tr>
								<th align="center" class="thTop" colspan="2" nowrap="nowrap" colspan="2">&nbsp;{L_NEWS_FORUMS}&nbsp;</th>
							</tr>
						<!-- END switch_forums_phpbb -->
							<!-- BEGIN catrow -->
							<tr>
								<td class="cat" align="center"><a href="#" onClick="toggle('cat_{catrow.CAT_ID}', '{MX_IMAGES_ROOT}'); return false;"><img src="{MX_IMAGES_ROOT}contract.gif" border="0" id="cat_{catrow.CAT_ID}_img" /></a>
								<td class="cat" ><span class="cattitle">{catrow.CAT_NAME}</span></td>
							</tr>
							<tbody id="cat_{catrow.CAT_ID}">
								<!-- BEGIN forumrow_phpbb -->
								<tr>
									<td class="row1" align="center" valign="top"><input type="checkbox" name="{SELECT_NAME}[{catrow.forumrow_phpbb.FORUM_ID}]" value="1" {catrow.forumrow_phpbb.CHECKED} /></td>
									<td class="row1" align="left" valign="top"><span class="forumlink">{catrow.forumrow_phpbb.FORUM_NAME}</span><br /><span class="gensmall">{catrow.forumrow_phpbb.FORUM_DESC}</span></td>
								</tr>
								<!-- END forumrow_phpbb -->
							</tbody>
							<!-- END catrow -->
						<!-- BEGIN switch_forums_phpbb -->
						</table>
						<!-- END switch_forums_phpbb -->
					</td>
				</tr>


