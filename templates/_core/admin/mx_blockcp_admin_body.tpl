<!-- BEGIN dynamic_select -->
<script type="text/javascript" src="{MX_DYN_PATH}modules/mx_shared/lib/DynamicOptionList_comp.js"></script>
<script id="DYNAMIC_LIST">
<!--
window.onload = initDynamicOptionLists;
var makeModule = new DynamicOptionList("module_id","function_id","block_id");
{DYNAMIC_FUNCTION_SETUP}
{DYNAMIC_BLOCK_SETUP}
{DYNAMIC_DEFAULT_SETUP}
// -->
</script>
<!-- END dynamic_select -->

<script language="javascript" type="text/javascript">
<!--
function blockcp_getCookie(name)
{
	var cookies = document.cookie;
	var start = cookies.indexOf(name + '=');
	if( start < 0 ) return null;
	var len = start + name.length + 1;
	var end = cookies.indexOf(';', len);
	if( end < 0 ) end = cookies.length;
	return unescape(cookies.substring(len, end));
}

function blockcp_setCookie(name, value, expires, path, domain, secure)
{
	document.cookie = name + '=' + escape (value) +
		((expires) ? '; expires=' + ( (expires == 'never') ? 'Thu, 31-Dec-2099 23:59:59 GMT' : expires.toGMTString() ) : '') +
		((path)    ? '; path='    + path    : '') +
		((domain)  ? '; domain='  + domain  : '') +
		((secure)  ? '; secure' : '');
}

function blockcp_delCookie(name, path, domain)
{
	if( blockcp_getCookie(name) )
	{
		document.cookie = name + '=;expires=Thu, 01-Jan-1970 00:00:01 GMT' +
			((path)    ? '; path='    + path    : '') +
			((domain)  ? '; domain='  + domain  : '');
	}
}

function blockcp_menuCat(id, mode, visible)
{
	this.cat_id = id;
	this.menu_mode = mode;
	this.status = visible != '' ? visible : 'none';
}
var blockcp_menuCats = new Array();

blockcp_menuCats['adminBlockCP_general_add'] = new blockcp_menuCat('general_add', 'adminBlockCP_', '{VISIBLE_GENERAL_ADD}');
blockcp_menuCats['adminBlockCP_general'] = new blockcp_menuCat('general', 'adminBlockCP_', '{VISIBLE_GENERAL}');
blockcp_menuCats['adminBlockCP_settings'] = new blockcp_menuCat('settings', 'adminBlockCP_', '{VISIBLE_SETTINGS}');
blockcp_menuCats['adminBlockCP_private'] = new blockcp_menuCat('private', 'adminBlockCP_', '{VISIBLE_PRIVATE}');
blockcp_menuCats['adminBlockCP_delete'] = new blockcp_menuCat('delete', 'adminBlockCP_', '{VISIBLE_DELETE}');

function blockcp_getObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}

function displayObj(obj, status)
{
	var x = blockcp_getObj(obj);
	if( x && x.style ) x.style.display = status;
}

var blockcp_queueInterval = 0;		// milliseconds between queued steps.
var blockcp_execInterval = 0;
var blockcp_queuedSteps;
var blockcp_currentStep;

function blockcp_queueStep(o, s)
{
	this.obj = o;
	this.status = s;
}

function blockcp_execQueue()
{
	if( blockcp_currentStep < blockcp_queuedSteps.length )
	{
		var obj = blockcp_queuedSteps[blockcp_currentStep].obj;
		var status = blockcp_queuedSteps[blockcp_currentStep].status;
		displayObj(obj, status);
		if( blockcp_menuCats[obj] ) blockcp_menuCats[obj].status = status;
		blockcp_currentStep++;
		setTimeout("blockcp_execQueue();", blockcp_execInterval);
	}
	else
	{
		blockcp_execInterval = blockcp_queueInterval;
	}
}

function blockcp_onMenuCatClick(cat_id, type, init)
{
	var currentCat, currentStatus;
	var imageSCR = type+'image_'+cat_id;

	parentMode = 'adminBlockCP_';

	parentCat = parentMode + cat_id;

	currentCat = type + cat_id;

	currentStatus = blockcp_menuCats[currentCat].status;

	blockcp_queuedSteps = new Array();
	cookieArray = new Array();

	blockcp_currentStep = 0;

	for( var forCat in blockcp_menuCats )
	{
		if( (init == 'true' && (blockcp_menuCats[forCat].status == 'block') && blockcp_menuCats[forCat].menu_mode == parentMode) ||
			(init != 'true' &&
				( 	(currentCat == parentCat && blockcp_menuCats[forCat].status == 'block' )  )))
		{
			blockcp_queuedSteps[blockcp_currentStep++] = new blockcp_queueStep(forCat, 'none');
			blockcp_menuCats[forCat].status = 'none';

			forCatimage = blockcp_menuCats[forCat].menu_mode+'image_'+blockcp_menuCats[forCat].cat_id;
			if( document.images && document.images[forCatimage] )
			{
				document.images[forCatimage].src = '{IMG_URL_EXPAND}';
			}
		}
	}

	if( currentStatus == 'none' )
	{
		if (blockcp_menuCats[parentCat])
		{
			if (blockcp_menuCats[parentCat].status == 'none')
			{
				blockcp_queuedSteps[blockcp_currentStep++] = new blockcp_queueStep(parentCat, 'block');
				blockcp_menuCats[parentCat].status = 'block';

				forCatimage = blockcp_menuCats[parentCat].menu_mode+'image_'+blockcp_menuCats[parentCat].cat_id;
				if( document.images && document.images[forCatimage] )
				{
					document.images[forCatimage].src = '{IMG_URL_CONTRACT}';
				}
			}
		}

		blockcp_queuedSteps[blockcp_currentStep++] = new blockcp_queueStep(currentCat, 'block');
		blockcp_menuCats[currentCat].status = 'block';

		if (currentCat == parentCat)
		{
			var	expdate = new Date();		// 72 Hours from now
			expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
			blockcp_setCookie('{COOKIE_NAME}_'+type+'mode', cat_id, expdate,
				('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
				('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
				('{COOKIE_SECURE}' == '0') ? false : true);
		}

		if( document.images && document.images[imageSCR] )
		{
			document.images[imageSCR].src = '{IMG_URL_CONTRACT}';
		}
	}
	else
	{
		blockcp_delCookie('{COOKIE_NAME}_'+type+'mode',
				('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
				('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}');
	}

	blockcp_currentStep = 0;
	setTimeout("blockcp_execQueue();", blockcp_execInterval);
}

function require_refresh()
{
	displayObj('adminBlockCP_require_refresh', 'none');
	displayObj('adminBlockCP_require_refresh_info', 'block');
}

function checkForm(form)
{
   var formErrors = '';

   if (form.block_title.value.length < 2)
   {
      	formErrors += "Fill out the block title\r\n";
   }

   if (formErrors && do_check)
   {
   		do_check = false
      	alert(formErrors);
      	return false;
   }
   else
   {
      	return true;
   }
}

function preFormCheck()
{
	do_check = true;
}

// -->
</script>

<!-- BEGIN mx_blockcp -->
<table border="0" cellspacing="10" cellpadding="0" width="100%" class="mx_body_table">
	<tr valign="top">
		<td>
<!-- END mx_blockcp -->

<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<!-- BEGIN dynamic_select -->
<form name="DYNAMIC_LIST" method="post" action="{S_ACTION}">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
	<td width="10%" class="topictitle" colspan="2">{L_MODULE}:</td>
	<td width="10%" class="topictitle" colspan="2">{L_FUNCTION}:</td>
	<td width="10%" class="topictitle" colspan="2">{L_BLOCK}:</td>
	<td width="5%">&nbsp;</td>
	<td width="65%">&nbsp;</td>
</tr>
<tr>
	<td valign="top">
		<select name="module_id" MULTIPLE size=5" onClick="require_refresh();">
			{DYNAMIC_MODULE_SELECT}
		</select>
	</td>
	<td>&raquo;</td>
	<td valign="top">
		<select name="function_id" MULTIPLE size=5" onClick="require_refresh();">
			<script LANGUAGE="JavaScript">makeModule.printOptions("function_id")</script>
		</select>
	</td>
	<td>&raquo;</td>
	<td valign="top">
		<select name="block_id" size=5 onClick="require_refresh();">
			<script LANGUAGE="JavaScript">makeModule.printOptions("block_id")</script>
		</select>
	</td>
	<td>&raquo;</td>
	<td align="center">
		<input type="submit" value="{S_UPDATE}" class="mainoption" /><br /><br />
		<input type="button" value="{S_RESET}" onClick="this.form.reset(); resetDynamicOptionLists(this.form);" class="liteoption">
		{S_HIDDEN_DYN_FILEDS}
	</td>
	<td>&nbsp;</td>
</tr>
</table>
</form>
<!-- END dynamic_select -->

{POST_PREVIEW_BOX}
{ERROR_BOX}

<div id="adminBlockCP_require_refresh" style="display:block;" class="genmed">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" style="border-bottom:none;" align="center">
	<tr>
		<td align="center" colspan="5">{RESULT_MESSAGE}</td>
	</tr>
	<tr>
		<!-- BEGIN blockcp_general_adds -->
		<th width="20%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="blockcp_onMenuCatClick('general_add','adminBlockCP_');">
			&nbsp;&nbsp;<img name="adminBlockCP_image_general_add" src="{IMG_URL_GENERAL_ADD}" border="0" align="absmiddle">&nbsp;{blockcp_general_adds.L_TITLE}
		</th>
		<!-- END blockcp_general_adds -->
		<!-- BEGIN blockcp_general -->
		<th width="20%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="blockcp_onMenuCatClick('general','adminBlockCP_');">
			&nbsp;&nbsp;<img name="adminBlockCP_image_general" src="{IMG_URL_GENERAL}" border="0" align="absmiddle">&nbsp;{blockcp_general.L_TITLE}
		</th>
		<!-- END blockcp_general -->
		<!-- BEGIN blockcp_settings -->
		<th width="20%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="blockcp_onMenuCatClick('settings','adminBlockCP_');">
			&nbsp;&nbsp;<img name="adminBlockCP_image_settings" src="{IMG_URL_SETTINGS}" border="0" align="absmiddle">&nbsp;{blockcp_settings.L_TITLE}
		</th>
		<!-- END blockcp_settings -->
		<!-- BEGIN blockcp_permissions -->
		<th width="20%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="blockcp_onMenuCatClick('private','adminBlockCP_');">
			&nbsp;&nbsp;<img name="adminBlockCP_image_private" src="{IMG_URL_PRIVATE}" border="0" align="absmiddle">&nbsp;{blockcp_permissions.L_TITLE}
		</th>
		<!-- END blockcp_permissions -->
		<!-- BEGIN blockcp_delete -->
		<th width="20%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="blockcp_onMenuCatClick('delete','adminBlockCP_');">
			&nbsp;&nbsp;<img name="adminBlockCP_image_delete" src="{IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;{blockcp_delete.L_TITLE}
		</th>
		<!-- END blockcp_delete -->
	</tr>
</table>

<div id="adminBlockCP_general_add" style="display:{VISIBLE_GENERAL_ADD};" class="genmed">
<!-- BEGIN blockcp_general_adds -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline" style="border-top:none;">
 	<tr>
 		<td class="row1" colspan="2">
 				<form action="{S_ACTION}" method="post" onsubmit="return checkForm(this)">
	 			<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
					<tr>
					 	<td class="row1" width="50%" align="right"><b>{L_BLOCK_TITLE}</b></td>
					 	<td class="row1"><input type="text" size="65" name="block_title" value="" class="post" /></td>
					</tr>

					<tr>
					 	<td class="row1" width="50%" align="right"><b>{L_BLOCK_DESC}</b></td>
					 	<td class="row1"><input type="text" size="65" name="block_desc" value="" class="post" /></td>
					</tr>
					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_TITLE}</b><br /><span class="gensmall">{L_SHOW_TITLE_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_title" value="1" {S_SHOW_TITLE_YES_ADD} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="show_title" value="0" {S_SHOW_TITLE_NO_ADD} /> <span class="gensmall">{L_NO}</span></td>
					</tr>

					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_STATS}</b><br /><span class="gensmall">{L_SHOW_STATS_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_stats" value="1" {S_SHOW_STATS_YES_ADD} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_stats" value="0" {S_SHOW_STATS_NO_ADD} /> <span class="gensmall">{L_NO}</span></td>
					</tr>

					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_BLOCK}</b><br /><span class="gensmall">{L_SHOW_BLOCK_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_block" value="1" {S_SHOW_BLOCK_YES_ADD} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_block" value="0" {S_SHOW_BLOCK_NO_ADD} /> <span class="gensmall">{L_NO}</span></td>
					</tr>

					<tr>
					  	<td class="row1" width="50%" align="right">
						  		<b>{L_AUTH_TITLE}</b><br /><span class="gensmall">{L_AUTH_TITLE_EXPLAIN}</span>
					  	</td>
						<td class="row1">

							<table cellspacing="1" cellpadding="4" border="0">
								<tr>
									<!-- BEGIN block_auth_titles -->
									<td class="row3" align="center"><span class="topictitle">{blockcp_general_adds.block_auth_titles.CELL_TITLE}</span></td>
									<!-- END block_auth_titles -->
								</tr>
								<tr>
								<!-- BEGIN block_auth_data -->
									<td>
										<table>
											<tr>
									    	  	<td class="row1" align="center">{blockcp_general_adds.block_auth_data.S_AUTH_LEVELS_SELECT}</td>
											</tr>
										</table>
									</td>
								<!-- END block_auth_data -->
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td class="row1" height="25" align="center" colspan="2">{blockcp_general_adds.S_HIDDEN_FIELDS}<input onClick="preFormCheck()" type="submit" name="submit" value="{blockcp_general_adds.S_SUBMIT}" class="mainoption" />{CANCEL}</td>
					</tr>
				</table>
				</form>

		</td>
	</tr>
</table>
<!-- END blockcp_general_adds -->
</div>

<div id="adminBlockCP_general" style="display:{VISIBLE_GENERAL};" class="genmed">
<!-- BEGIN blockcp_general -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline" style="border-top:none;">
 	<tr>
 		<td class="row1" colspan="2">
 				<form action="{S_ACTION}" method="post" onsubmit="return checkForm(this)">
	 			<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
					<tr>
					 	<td class="row1" width="50%" align="right"><b>{L_BLOCK_TITLE}</b></td>
					 	<td class="row1"><input type="text" size="65" name="block_title" value="{E_BLOCK_TITLE}" class="post" /></td>
					</tr>

					<tr>
					 	<td class="row1" width="50%" align="right"><b>{L_BLOCK_DESC}</b></td>
					 	<td class="row1"><input type="text" size="65" name="block_desc" value="{E_BLOCK_DESC}" class="post" /></td>
					</tr>
					<!-- BEGIN is_mod -->
					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_TITLE}</b><br /><span class="gensmall">{L_SHOW_TITLE_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_title" value="1" {S_SHOW_TITLE_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="show_title" value="0" {S_SHOW_TITLE_NO} /> <span class="gensmall">{L_NO}</span></td>
					</tr>

					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_STATS}</b><br /><span class="gensmall">{L_SHOW_STATS_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_stats" value="1" {S_SHOW_STATS_YES} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_stats" value="0" {S_SHOW_STATS_NO} /> <span class="gensmall">{L_NO}</span></td>
					</tr>

					<tr>
						<td class="row1" width="50%" align="right"><b>{L_SHOW_BLOCK}</b><br /><span class="gensmall">{L_SHOW_BLOCK_EXPLAIN}</span></td>
						<td class="row1"><input type="radio" name="show_block" value="1" {S_SHOW_BLOCK_YES} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_block" value="0" {S_SHOW_BLOCK_NO} /> <span class="gensmall">{L_NO}</span></td>
					</tr>
					<!-- END is_mod -->

					<tr>
					  	<td class="row1" width="50%" align="right">
						  	<!-- BEGIN is_auth -->
						  		<b>{L_AUTH_TITLE}</b><br /><span class="gensmall">{L_AUTH_TITLE_EXPLAIN}</span>
						  	<!-- END is_auth -->
					  	</td>
						<td class="row1">

							<table cellspacing="1" cellpadding="4" border="0">
								<tr>
									<!-- BEGIN block_auth_titles -->
									<td class="row3" align="center"><span class="topictitle">{blockcp_general.block_auth_titles.CELL_TITLE}</span></td>
									<!-- END block_auth_titles -->
								</tr>
								<tr>
								<!-- BEGIN block_auth_data -->
									<td>
										<table>
											<tr>
									    	  	<td class="row1" align="center">{blockcp_general.block_auth_data.S_AUTH_LEVELS_SELECT}</td>
											</tr>
										</table>
									</td>
								<!-- END block_auth_data -->
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td class="row1" height="25" align="center" colspan="2">{blockcp_general.S_HIDDEN_FIELDS}<input type="submit" onClick="preFormCheck()" name="submit" value="{blockcp_general.S_SUBMIT}" class="mainoption" />{CANCEL}</td>
					</tr>
				</table>
				</form>

		</td>
	</tr>
</table>
<!-- END blockcp_general -->
</div>

<div id="adminBlockCP_settings" style="display:{VISIBLE_SETTINGS};" class="genmed">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline" style="border-top:none;">
<!-- BEGIN blockcp_panel -->
 	<tr>
 		<td class="row1" colspan="2">
			{blockcp_panel.BLOCKCP_PANELS}

		</td>
	</tr>
<!-- END blockcp_panel -->

<!-- BEGIN blockcp_settings -->
 	<tr>
 		<td class="row1" colspan="2">
 				<form action="{S_ACTION}" method="post" name="post">
 				<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
					<tr>
						<td class="row2" colspan="2">
							<table cellspacing="0" cellpadding="1" border="0" width="100%">

								<!-- BEGIN no_settings -->
								<tr>
									<td class="row1" width="50%" align="right"></td>
									<td class="row1">{blockcp_settings.no_settings.INFO}</td>
								</tr>
								<!-- END no_settings -->

								{BLOCKCP_PARAMETERS}

							</table>
						</td>
					</tr>

					<tr>
						<td class="row1" height="25" align="center" colspan="2">{blockcp_settings.S_HIDDEN_FIELDS}<input type="submit" name="submit_pars" value="{blockcp_settings.S_SUBMIT}" class="mainoption" />{CANCEL}</td>
					</tr>

				</table>
				</form>
		</td>
	</tr>
<!-- END blockcp_settings -->
</table>
</div>

<div id="adminBlockCP_private" style="display:{VISIBLE_PRIVATE};" class="genmed">
<!-- BEGIN blockcp_permissions -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline" style="border-top:none;">
 	<tr>
 		<td class="row1" colspan="2" width="100%">
				<form action="{S_ACTION}" method="post">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr>
						<td width="40%" class="row3" align="center" height="25" nowrap="nowrap"><b>{L_GROUPS}</b></td>
						<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_VIEW}</b></td>
						<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_EDIT}</b></td>
						<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_IS_MODERATOR}</b></td>
					</tr>
					<tr>
						<td class="row1" align="center" colspan="4">
							<div style="overflow:auto; overflow-y:scroll; height:200px;">
							<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
								<!-- BEGIN grouprows -->
									{blockcp_permissions.grouprows.GROUP_ROWS}
								<!-- END grouprows -->
							</table>
							</div>
						</td>
					</tr>
					<tr>
						<td class="row1" height="25" align="center" colspan="4">{blockcp_permissions.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{blockcp_permissions.S_SUBMIT}" class="mainoption" />{CANCEL}</td>
					</tr>
				</table>
				</form>
		</td>
	</tr>
</table>
<!-- END blockcp_permissions -->
</div>

<div id="adminBlockCP_delete" style="display:{VISIBLE_DELETE};" class="genmed">
<!-- BEGIN blockcp_delete -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline" style="border-top:none;">
<tr>
	<td colspan="2" class="row1">
		<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
			<tr>
				<td width="50%" align="center" colspan="2">{blockcp_delete.MESSAGE_DELETE}</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<!-- END blockcp_delete -->
</div>

</div>

<div id="adminBlockCP_require_refresh_info" style="display:none;" class="genmed">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="forumline">
<tr>
	<td colspan="2" class="row1">
		<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
			<tr>
				<td width="50%" align="center" colspan="2">{L_UPDATE}</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</div>

<!-- BEGIN mx_blockcp -->
		</td>
	</tr>
</table>
<!-- END mx_blockcp -->