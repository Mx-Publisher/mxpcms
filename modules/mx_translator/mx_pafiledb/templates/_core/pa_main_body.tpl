<!-- INCLUDE pa_header.tpl -->
<table width="100%" cellpadding="2" cellspacing="2">
  <tr>
	<td valign="bottom">
		<span class="nav"><a href="{U_DOWNLOAD}" class="nav ask target-block_{BLOCK_ID}">{DOWNLOAD}</a></span>
	</td>
  </tr>
</table>

<!-- IF CAT_NAV_STANDARD -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  	<tr>
		<th class="thCornerL" width="6%">&nbsp;</th>
		<th class="thTop">&nbsp;{L_CATEGORY}&nbsp;</th>
		<th class="thCornerR" width="10%">&nbsp;{L_LAST_FILE}&nbsp;</th>
		<th class="thCornerR" width="8%">&nbsp;{L_FILES}&nbsp;</th>
  	</tr>
	<!-- BEGIN no_cat_parent -->
	<!-- IF no_cat_parent.IS_HIGHER_CAT -->
	<tr>
		<td class="cat" colspan="2" valign="middle"><a href="{no_cat_parent.U_CAT}" class="cattitle ask target-block_{BLOCK_ID}">{no_cat_parent.CAT_NAME}</a></td>
		<td class="rowpic" colspan="2" align="right">&nbsp;</td>
	</tr>
	<!-- ELSE -->
	<tr>
		<td class="row1" valign="middle" align="center"><a href="{no_cat_parent.U_CAT}" class="cattitle ask target-block_{BLOCK_ID}"><img src="{no_cat_parent.CAT_IMAGE}" border="0" alt="{no_cat_parent.CAT_NEW_FILE}"></a></td>
		<td class="row1" valign="middle" onmouseout="this.className='row1';" onmouseover="this.className='row2';" onclick="window.location.href='{no_cat_parent.U_CAT}';"><a href="{no_cat_parent.U_CAT}" class="cattitle ask target-block_{BLOCK_ID}">{no_cat_parent.CAT_NAME}</a><br><span class="genmed">{no_cat_parent.CAT_DESC}</span><span class="gensmall">{no_cat_parent.SUB_CAT}</span></b></td>
		<td class="row2" align="center" valign="middle" nowrap="nowrap"><span class="genmed">{no_cat_parent.LAST_FILE}</span></td>
		<td class="row2" align="center" valign="middle"><span class="genmed">{no_cat_parent.FILECAT}</span></td>
	</tr>
	<!-- ENDIF -->
	<!-- END no_cat_parent -->
  	<tr>
		<td class="cat" colspan="4">&nbsp;</td>
  	</tr>
</table>
<!-- ENDIF -->


<!-- IF CAT_NAV_SIMPLE -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  	<tr>
		<th class="thHead">{L_CATEGORY}</th>
  	</tr>
  	<tr>
  		<td class="row1">
			<table border="0" cellpadding="2" cellspacing="1" width="100%" >
			<!-- BEGIN catcol -->
				<tr>
				<!-- BEGIN no_cat_parent -->
					<td width="{WIDTH}%">
						<table border="0" cellpadding="2" cellspacing="2" width="100%">
							<tr>
								<td>
									<a href="{catcol.no_cat_parent.U_CAT}"><img src="{catcol.no_cat_parent.CAT_IMAGE}" alt="{catcol.no_cat_parent.CAT_NAME}" align="absmiddle" border="0" /></a>
								</td>
								<td width="100%" valign="middle" nowrap="nowrap">
									<a href="{catcol.no_cat_parent.U_CAT}"  class="cattitle">{catcol.no_cat_parent.CAT_NAME}</a>&nbsp;<span class="gensmall">({catcol.no_cat_parent.FILECAT})</span><br>
									{catcol.no_cat_parent.SUB_CAT}
								</td>
							</tr>
						</table>
					</td>
				<!-- END no_cat_parent -->
      			</tr>
			<!-- END catcol -->
			</table>
  	 	</td>
  	</tr>
</table>
<!-- ENDIF -->

<!-- INCLUDE pa_footer.tpl -->