<table width="{BLOCK_SIZE}" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr>
		<th class="thHead" align="center">&nbsp;{L_TITLE}&nbsp;</th>
	</tr>
	<tr>
		<td>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border:none; padding:4px;">
	<tr>
		<!-- BEGIN switch_listeners_list_on -->
		<td class="row1" align="center" valign="middle" rowspan="3">
		<!-- END switch_listeners_list_on -->
		<!-- BEGIN switch_listeners_list_off -->
		<td class="row1" align="center" valign="middle" rowspan="2">
		<!-- END switch_listeners_list_off -->
			<a href="javascript:void(0);" onClick="window.open('{S_MOREINFO}','','scrollbars=no,resizable=yes,width=350,height=112')"><img src="{SHOTCAST_IMG}" alt="{L_VERSION}" border="0" /></a>
		</td>
		<td class="row1" align="left">
			<span class="gensmall">{TOTAL_LISTENERS_ONLINE}, {TOTAL_LISTENERS_PEAK}</span>
		</td>
	</tr>
	<tr>
		<td class="row1" align="left">
			<span class="gensmall">
				<!-- BEGIN switch_user_logged_out -->
				[ {L_LOGIN_TO_LISTEN_STATION} ]
				<!-- END switch_user_logged_out -->
				<!-- BEGIN switch_user_logged_in -->
				[ <a href="javascript:void(0);" onClick="window.open('{S_LISTEN_STATION}', 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=1, width=320, height=142 left = 100, top = 100')">{L_CLICK_TO_LISTEN_STATION}</a> ]<br />
				<a href="javascript:void(0);" onClick="window.open('{S_LISTEN_WMP}', 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=1, width=320, height=142 left = 100, top = 100')"><img src="{WMP_IMG}" alt="{L_CLICK_TO_LISTEN_WMP}" border="0" /></a>
				<a href="javascript:void(0);" onClick="window.open('{S_LISTEN_REAL}', 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=1, width=320, height=142 left = 100, top = 100')"><img src="{REAL_IMG}" alt="{L_CLICK_TO_LISTEN_REAL}" border="0" /></a>
				<!-- END switch_user_logged_in -->
				<!-- BEGIN switch_user_listening -->
				[ {L_ALREADY_LISTENING} ]
				<!-- END switch_user_listening -->
			</span>
		</td>
	</tr>
	<!-- BEGIN switch_listeners_list_on -->
	<tr>
		<td class="row1" align="left">
			<span class="gensmall">{LISTENERS_LIST}</span>
		</td>
	</tr>
	<!-- END switch_listeners_list_on -->
</table>

		</td>
	</tr>
</table>

<br clear="all" />
