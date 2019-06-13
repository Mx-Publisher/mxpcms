<!-- BEGIN use_comments -->
<table width="100%" cellpadding="4" cellspacing="1" class="forumline">
	<!--
  	<tr>
		<th class="thCornerL" colspan="2">{use_comments.L_COMMENTS}</th>
  	</tr>
  	-->
	<!-- BEGIN no_comments -->
  	<tr>
		<td colspan="2" class="row1" align="center"><span class="genmed">{use_comments.no_comments.L_NO_COMMENTS}</span></td>
  	</tr>
	<!-- END no_comments -->

	<!-- BEGIN text -->
	<!-- OLD STYLE
  	<tr>
		<td width="100" align="left" valign="top" class="row1"><span class="name">
			<b>{use_comments.text.POSTER}</b></span><hr /><br />
			<span class="postdetails">{use_comments.text.POSTER_RANK}<br />
			{use_comments.text.RANK_IMAGE}{use_comments.text.POSTER_AVATAR}</span><br />&nbsp;
		</td>
		<td class="row1" height="28" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="80%" valign="middle"><span class="genmed"><img src="{use_comments.text.ICON_MINIPOST_IMG}" width="12" height="9" border="0" />&nbsp;<b>{use_comments.text.TITLE}</b> </span><span class="genmed">({use_comments.text.TIME})</span></td>
					<td align="right">
					<!-- BEGIN auth_edit -->
					<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}"><img src="{use_comments.text.auth_edit.EDIT_IMG}" alt="{use_comments.text.auth_edit.L_COMMENT_EDIT}" title="{use_comments.text.auth_edit.L_COMMENT_EDIT}" border="0"></a>
					<!-- END auth_edit -->
					<!-- BEGIN auth_delete -->
					<a href="{use_comments.text.auth_delete.U_COMMENT_DELETE}"><img src="{use_comments.text.auth_delete.DELETE_IMG}" alt="{use_comments.text.auth_delete.L_COMMENT_DELETE}" title="{use_comments.text.auth_delete.L_COMMENT_DELETE}" border="0"></a>
					<!-- END auth_delete -->
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td colspan="2"valign="top"><span class="postbody">{use_comments.text.TEXT}</span></td>
				</tr>
			</table>
		</td>
  	</tr>
  	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="{use_comments.text.ICON_SPACER}" alt="" width="1" height="1" /></td>
  	</tr>
  	END OLD STYLE-->

  	<!-- SEMI OLD STYLE
		<tr>
			<td width="60%" valign="middle">
				<span class="genmed">
					<img src="{use_comments.text.ICON_MINIPOST_IMG}" width="12" height="9" border="0" />&nbsp;<i>{use_comments.text.TIME}</i>
				</span>
				<span class="genmed">
					({use_comments.text.POSTER})
				</span>
			</td>
			<td align="right">
			<!-- BEGIN auth_edit -->
			<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}">[{use_comments.text.auth_edit.L_COMMENT_EDIT}]</a>
			<!-- END auth_edit -->
			<!-- BEGIN auth_delete -->
			<a href="{use_comments.text.auth_delete.U_COMMENT_DELETE}">[{use_comments.text.auth_delete.L_COMMENT_DELETE}]</a>
			<!-- END auth_delete -->
			</td>
		</tr>
		<tr>
			<td colspan="2"><span class="cattitle">{use_comments.text.TITLE}</span></td>
		</tr>
		<tr>
			<td colspan="2"valign="top"><span class="genmed">{use_comments.text.TEXT}</span></td>
		</tr>
	END SEMI OLD -->

		<tr>
			<td ><span class="discreet">[{use_comments.text.TIME}]</span> &nbsp;<span class="cattitle">{use_comments.text.TITLE}</span></td>
			<td align="right">
			<!-- BEGIN auth_edit -->
			<a href="{use_comments.text.auth_edit.U_COMMENT_EDIT}">[{use_comments.text.auth_edit.L_COMMENT_EDIT}]</a>
			<!-- END auth_edit -->
			<!-- BEGIN auth_delete -->
			<a href="{use_comments.text.auth_delete.U_COMMENT_DELETE}">[{use_comments.text.auth_delete.L_COMMENT_DELETE}]</a>
			<!-- END auth_delete -->
			</td>
		</tr>
		<tr>
			<td colspan="2"valign="top"><span class="genmed">{use_comments.text.TEXT}</span> </td>
		</tr>

	<!-- END text -->
</table>

<!-- BEGIN comments_pag -->
<br />
<table width="100%" cellspacing="1" cellpadding="0" border="0">
  <tr>
	<td><span class="nav"><!--{use_comments.comments_pag.PAGE_NUMBER}--></span></td>
	<td align="right"><span class="nav">{use_comments.comments_pag.PAGINATION}</span></td>
  </tr>
</table>
<!-- END comments_pag -->

<!-- BEGIN auth_post -->
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  	<tr>
		<td><a href="{use_comments.auth_post.U_COMMENT_POST}">[{use_comments.auth_post.L_COMMENT_ADD}]</a></td>
  	</tr>
</table>
<br clear="all" />
<!-- END auth_post -->
<!-- END use_comments -->