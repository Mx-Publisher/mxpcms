<table border="0" cellpadding="0" cellspacing="0" class="forumline" width="100%">
	<tr>
		<td class="catHead" align="center"><span class="cattitle">{L_ADMIN_STATISTICS}</span></td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border:none;">
				<tr>
					<th width="25%" class="thCornerL" align="center"><b>{L_STATISTIC}</b></td>
					<th width="25%" class="thTop" align="center"><b>{L_VALUE}</b></td>
					<th width="25%" class="thTop" align="center"><b>{L_STATISTIC}</b></td>
					<th width="25%" class="thCornerR" align="center"><b>{L_VALUE}</b></td>
				</tr>
				<!-- BEGIN adminrow -->
				<tr>
					<td class="row2" align="center"><span class="gen">{adminrow.STATISTIC}</span></td>
					<td class="row1" align="center"><span class="gen">{adminrow.VALUE}</span></td>
					<td class="row2" align="center"><span class="gen">{adminrow.STATISTIC2}</span></td>
					<td class="row1" align="center"><span class="gen">{adminrow.VALUE2}</span></td>
				</tr>
				<!-- END adminrow -->
			</table>
		</td>
	</tr>
</table>
<br clear="all" />
<table border="0" cellpadding="0" cellspacing="0" class="forumline" width="100%">
	<tr>
		<td class="catHead" align="center"><span class="cattitle">{L_TOP_POSTERS}</span></td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border:none;">
				<tr>
					<th class="thCornerL" align="center" width="10%"><b>{L_RANK}</b></th>
					<th class="thTop" align="center" width="20%"><b>{L_USERNAME}</b></th>
					<th class="thTop" align="center" width="10%"><b>{L_POSTS}</b></th>
					<th class="thTop" align="center" width="10%"><b>{L_PERCENTAGE}</b></th>
					<th class="thCornerR" align="center" width="50%"><b>{L_GRAPH}</b></th>
				</tr>
				<!-- BEGIN users -->
				<tr>
					<td class="{users.CLASS}" align="center"><span class="gen">{users.RANK}</span></td>
					<td class="{users.CLASS}" align="center"><span class="gen"><a href="{users.URL}">{users.USERNAME}</a></span></td>
					<td class="{users.CLASS}" align="center"><span class="gen">{users.POSTS}</span></td>
					<td class="{users.CLASS}" align="center"><span class="gen">{users.PERCENTAGE}%</span></td>
					<td class="{users.CLASS}" align="left">
						<table cellspacing="0" cellpadding="0" border="0" align="left">
							<tr>
								<td align="right"><img src="{LEFT_GRAPH_IMAGE}" width="4" height="12" alt="{users.PERCENTAGE}%" title="{users.PERCENTAGE}%" /></td>
							</tr>
						</table>
						<table cellspacing="0" cellpadding="0" border="0" align="left" width="{users.BAR}%">
							<tr>
								<td><img src="{GRAPH_IMAGE}" width="100%" height="12" alt="{users.PERCENTAGE}%" title="{users.PERCENTAGE}%" /></td>
							</tr>
						</table>
						<table cellspacing="0" cellpadding="0" border="0" align="left">
							<tr>
								<td align="left"><img src="{RIGHT_GRAPH_IMAGE}" width="4" height="12" alt="{users.PERCENTAGE}%" title="{users.PERCENTAGE}%" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- END users -->
			</table>
		</td>
	</tr>
</table>
<br clear="all" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="50%" style="padding-right:2px;">
			<table border="0" cellpadding="0" cellspacing="0" class="forumline" width="100%">
				<tr>
					<td class="catHead" align="center"><span class="cattitle">{L_MOST_VIEWED}</span></td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border:none;">
							<tr>
								<th class="thCornerL" align="left" width="5%"><b>{L_RANK}</b></th>
								<th class="thTop" align="center" width="20%"><b>{L_VIEWS}</b></th>
								<th class="thCornerR" align="center" width="75%"><b>{L_TOPIC}</b></th>
							</tr>
							<!-- BEGIN topicviews -->
							<tr>
								<td class="{topicviews.CLASS}" align="left"><span class="gen">{topicviews.RANK}</span></td>
								<td class="{topicviews.CLASS}" align="center"><span class="gen">{topicviews.VIEWS}</span></td>
								<td class="{topicviews.CLASS}" align="left"><span class="gen"><a href="{topicviews.URL}">{topicviews.TITLE}</a></span></td>
							</tr>
							<!-- END topicviews -->
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" width="50%" style="padding-left:2px;">
			<table border="0" cellpadding="0" cellspacing="0" class="forumline" width="100%">
				<tr>
					<td class="catHead" align="center"> <span class="cattitle">{L_MOST_ACTIVE}</span></td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border:none;">
							<tr>
								<th class="thCornerL" align="left" width="5%"><b>{L_RANK}</b></th>
								<th class="thTop" align="center" width="20%"><b>{L_REPLIES}</b></th>
								<th class="thCornerR" align="center" width="75%"><b>{L_TOPIC}</b></th>
							</tr>
							<!-- BEGIN topicreplies -->
							<tr>
								<td class="{topicreplies.CLASS}" align="left"><span class="gen">{topicreplies.RANK}</span></td>
								<td class="{topicreplies.CLASS}" align="center"><span class="gen">{topicreplies.REPLIES}</span></td>
								<td class="{topicreplies.CLASS}" align="left"><span class="gen"><a href="{topicreplies.URL}">{topicreplies.TITLE}</a></span></td>
							</tr>
							<!-- END topicreplies -->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>