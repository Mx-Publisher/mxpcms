<!-- IF SHOW_TITLE -->
<div class="forabg block inner">
	<span class="corners-bottom"></span>
</div>
<!-- ENDIF -->
<div class="clear" style="width:{BLOCK_SIZE}">
<!-- BEGIN forumrow -->
	<!-- IF (forumrow.S_IS_CAT and not forumrow.S_FIRST_ROW) or forumrow.S_NO_CAT  -->
			</ul>

			<span class="corners-bottom"><span></span></span></div>
		</div>
	<!-- ENDIF -->

	<!-- IF forumrow.S_IS_CAT or forumrow.S_FIRST_ROW  or forumrow.S_NO_CAT  -->
	<div class="forabg block">
		<div class="inner"><span class="corners-top"><span></span></span>
			<ul class="topiclist">
				<li class="header">
					<dl class="icon">
						<dt><!-- IF forumrow.S_IS_CAT --><a href="{forumrow.U_VIEWFORUM}">{forumrow.FORUM_NAME}</a><!-- ELSE -->{L_FORUM}<!-- ENDIF --></dt>
						<dd class="topics">{L_TOPICS}</dd>
						<dd class="posts">{L_POSTS}</dd>
						<dd class="lastpost"><span>{L_LAST_POST}</span></dd>
					</dl>
				</li>
			</ul>
			<ul class="topiclist forums">
	<!-- ENDIF -->

	<!-- IF not forumrow.S_IS_CAT -->
		<li class="row">
			<dl class="icon" style="background-image: url({forumrow.FORUM_FOLDER_IMG_SRC}); background-repeat: no-repeat;">
				<dt>
					<!-- IF forumrow.FORUM_IMAGE --><span class="forum-image">{forumrow.FORUM_IMAGE}</span><!-- ENDIF -->
					<a href="{forumrow.U_VIEWFORUM}" class="forumtitle">{forumrow.FORUM_NAME}</a><br />
					{forumrow.FORUM_DESC}
					<!-- IF forumrow.MODERATORS -->
						<br /><strong>{forumrow.L_MODERATOR_STR}:</strong> {forumrow.MODERATORS}
					<!-- ENDIF -->
					<!-- IF forumrow.SUBFORUMS --><br /><strong>{forumrow.L_SUBFORUM_STR}</strong> {forumrow.SUBFORUMS}<!-- ENDIF -->
				</dt>
				<!-- IF forumrow.CLICKS -->
					<dd class="redirect"><span>{L_REDIRECTS}: {forumrow.CLICKS}</span></dd>
				<!-- ELSEIF not forumrow.S_IS_LINK -->
					<dd class="topics">{forumrow.TOPICS} <dfn>{L_TOPICS}</dfn></dd>
					<dd class="posts">{forumrow.POSTS} <dfn>{L_POSTS}</dfn></dd>
					<dd class="lastpost"><span>
						<!-- IF forumrow.LAST_POST_TIME --><dfn>{L_LAST_POST}</dfn> {L_POST_BY_AUTHOR} {forumrow.LAST_POSTER_FULL}
						<a href="{forumrow.U_LAST_POST}">{LAST_POST_IMG}</a> <br />{L_POSTED_ON_DATE} {forumrow.LAST_POST_TIME}<!-- ELSE -->{L_NO_POSTS}<!-- ENDIF --></span>
					</dd>
				<!-- ENDIF -->
			</dl>
		</li>
	<!-- ENDIF -->

	<!-- IF forumrow.S_LAST_ROW -->
			</ul>

			<span class="corners-bottom"><span></span></span></div>
		</div>
	<!-- ENDIF -->

<!-- BEGINELSE -->
	<div class="panel">
		<div class="inner"><span class="corners-top"><span></span></span>
		<strong>{L_NO_FORUMS}</strong>
		<span class="corners-bottom"><span></span></span></div>
	</div>
<!-- END forumrow -->
	</div>
<span class="corners-bottom"><span></span></span></div>
</div>
