<div class="textbody">
<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">
	<!-- BEGIN no_glance_news_and_recent -->
	<tr>
		<td class="row1" align="left" colspan="2">{no_glance_news_and_recent.L_NO_ITEMS}</td>
	</tr>
	<!-- END no_glance_news_and_recent -->
	<!-- BEGIN switch_glance_news -->
	<tr>
		<td class="catLeft" height="28"><span class="cattitle">{NEWS_HEADING}</span></td>
    </tr>
    <tr>
	    <td class="row1" valign="top"><span class="genmed">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<!-- END switch_glance_news -->
		<!-- BEGIN latest_news -->
		<tr>
			<td class="row2" align="center">
				<span class="cattitle">
					{latest_news.NEWEST_POST_IMG}
				</span>
			</td>
			<td class="row1" align="left" valign="top" width="100%">
			<span class="genmed" style="font-weight: bold;"><a title="{L_LAST_REPLY}: {latest_news.LAST_POST_TIME}" href="{latest_news.U_VIEW_TOPIC}" class="genmed">{latest_news.TOPIC_TITLE}</a></span>
			<br />
				<dd style="float:right">
					<span class="gensmall" nowrap="nowrap">{latest_news.TOPIC_TIME}</span>
				</dd>
			</td>
		</tr>
		<!-- END latest_news -->
	<!-- BEGIN switch_glance_news -->
		<tr valign="middle">
			<td align="right" valign="top" nowrap="nowrap" colspan="2" height="28" class="cat"><span class="gensmall">{switch_glance_news.PREV_URL}&nbsp;&nbsp;{switch_glance_news.NEXT_URL}&nbsp;&nbsp;</span></td>
		</tr>
		</table>
	</span></td>
    </tr>
	<!-- END switch_glance_news -->
	<!-- BEGIN switch_glance_recent -->
    <tr>
		<td class="catLeft" height="28"><span class="cattitle">{RECENT_HEADING}</span></td>
    </tr>
    <tr> 
        <td class="row1" valign="top" height="100%"><span class="genmed">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<!-- END switch_glance_recent -->
	<!-- BEGIN latest_topics -->
	<tr>
		<td class="row2" align="center">
			<span class="cattitle">
				{latest_topics.NEWEST_POST_IMG}
			</span>
		</td>
		<td class="row1" align="left">
			<span class="genmed">
				<span class="genmed" style="font-weight: bold;"><a href="{latest_topics.U_VIEW_TOPIC}" title="{L_POSTED}: {latest_topics.TOPIC_TIME}" class="genmed">{latest_topics.TOPIC_TITLE}</a></span>
			</span><br />
			<span class="gensmall">
				<a href="{latest_topics.U_VIEW_FORUM}" title="{latest_topics.FORUM_TITLE}" class="gensmall">{latest_topics.FORUM_TITLE}</a>
			</span>
			<div align="right">
				<span class="gensmall" nowrap="nowrap">
					{latest_topics.LAST_POST_TIME}
				</span><br />
				<span class="gensmall" nowrap="nowrap"> 
					{latest_topics.TOPIC_AUTHOR_FULL} {latest_topics.LAST_POSTER_FULL}
				</span>
			</div>
			<div valign="top" align="right">
				<span class="gensmall" nowrap="nowrap">
					({latest_topics.TOPIC_REPLIES}) {L_COMMENTS}
				</span>
			</div>
		</td>
	</tr>
	<!-- END latest_topics -->
	<!-- BEGIN switch_glance_recent -->
		<tr valign="middle">
			<td align="right" valign="top" nowrap="nowrap" colspan="2" height="28" class="cat"><span class="gensmall">{switch_glance_recent.PREV_URL}&nbsp;&nbsp;{switch_glance_recent.NEXT_URL}&nbsp;&nbsp;</span></td>
		</tr>
		</table>
	</span></td>
	</tr>
	<!-- END switch_glance_recent -->
</table>
</div>