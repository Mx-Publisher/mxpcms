<script type="text/javascript">
function getCookie(name)
{
	var cookies = document.cookie;
	var start = cookies.indexOf(name + '=');
	if( start < 0 ) return null;
	var len = start + name.length + 1;
	var end = cookies.indexOf(';', len);
	if( end < 0 ) end = cookies.length;
	return unescape(cookies.substring(len, end));
}
function setCookie(name, value, expires, path, domain, secure)
{
	document.cookie = name + '=' + escape (value) +
		((expires) ? '; expires=' + ( (expires == 'never') ? 'Thu, 31-Dec-2099 23:59:59 GMT' : expires.toGMTString() ) : '') +
		((path)    ? '; path='    + path    : '') +
		((domain)  ? '; domain='  + domain  : '') +
		((secure)  ? '; secure' : '');
}
function delCookie(name, path, domain)
{
	if( getCookie(name) )
	{
		document.cookie = name + '=;expires=Thu, 01-Jan-1970 00:00:01 GMT' +
			((path)    ? '; path='    + path    : '') +
			((domain)  ? '; domain='  + domain  : '');
	}
}

function handleError() {
 	return true;
}

window.onerror = handleError;

function menuCat(id, mode, visible)
{
	this.cat_id = id;
	this.menu_mode = mode;
	this.status = visible != '' ? visible : 'none';
}
var menuCats = new Array();

function getObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}
function displayObj(obj, status)
{
	var x = getObj(obj);
	if( x && x.style ) x.style.display = status;
}

var queueInterval = 0;		// milliseconds between queued steps.
var execInterval = 0;
var queuedSteps;
var currentStep;

function queueStep(o, s)
{
	this.obj = o;
	this.status = s;
}
function execQueue()
{
	if( currentStep < queuedSteps.length )
	{
		var obj = queuedSteps[currentStep].obj;
		var status = queuedSteps[currentStep].status;
		displayObj(obj, status);
		if( menuCats[obj] ) menuCats[obj].status = status;
		currentStep++;
		setTimeout("execQueue();", execInterval);
	}
	else
	{
		execInterval = queueInterval;
	}
}
function onMenuCatClick(cat_id, type, init)
{
	var currentCat, currentStatus;
	var imageSCR = type+'image_'+cat_id;
	var strSubmitContent = '';

	parentCatMode = 'adminCat_';
	parentCatEditMode = 'adminCatEdit_';

	parentMenuEditMode = 'adminMenuEdit_';

	parentCat = parentCatMode + cat_id;
	parentCatEdit = parentCatEditMode + cat_id;

	parentMenuEdit = parentMenuEditMode + cat_id;

	currentCat = type + cat_id;

	currentStatus = menuCats[currentCat].status;

	queuedSteps = new Array();
	cookieArray = new Array();

	currentStep = 0;

	for( var forCat in menuCats )
	{
		if( (init == 'true' && (menuCats[forCat].status == 'block') && menuCats[forCat].menu_mode == parentCat) ||
			(init != 'true' &&
				( 	(currentCat == parentCat && menuCats[forCat].status == 'block') ||
					(currentCat == parentCatEdit && menuCats[forCat].menu_mode != parentCat && menuCats[forCat].status == 'block') ||

					(currentCat == parentMenuEdit && menuCats[forCat].menu_mode != parentCatMode && menuCats[forCat].status == 'block')
			 	)))
		{
			queuedSteps[currentStep++] = new queueStep(forCat, 'none');
			menuCats[forCat].status = 'none';

			forCatimage = menuCats[forCat].menu_mode+'image_'+menuCats[forCat].cat_id;
			if( document.images && document.images[forCatimage] )
			{
				document.images[forCatimage].src = '{IMG_URL_EXPAND}';
			}
		}
	}

	if( currentStatus == 'none' )
	{
		if (menuCats[parentCat] && menuCats[currentCat].menu_mode != parentMenuEditMode )
		{
			if (menuCats[parentCat].status == 'none')
			{
				queuedSteps[currentStep++] = new queueStep(parentCat, 'block');
				menuCats[parentCat].status = 'block';

				forCatimage = menuCats[parentCat].menu_mode+'image_'+menuCats[parentCat].cat_id;
				if( document.images && document.images[forCatimage] )
				{
					document.images[forCatimage].src = '{IMG_URL_CONTRACT}';
				}
			}
		}

		queuedSteps[currentStep++] = new queueStep(currentCat, 'block');
		menuCats[currentCat].status = 'block';

		if (currentCat == parentCat)
		{
			var	expdate = new Date();		// 72 Hours from now
			expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
			setCookie('{COOKIE_NAME}_'+type+'xxx_id', cat_id, expdate,
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
		delCookie('{COOKIE_NAME}_'+type+'xxx_id',
				('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
				('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}');
	}

	for( var forCat in menuCats )
	{
		if ( menuCats[forCat].status == 'block' )
		{
			strSubmitContent += forCat + ',';
		}
	}

	// Remove trailing separator
	strSubmitContent = strSubmitContent.substr(0, strSubmitContent.length - 1);

	setCookie('{COOKIE_NAME}_admincp_sitestates', strSubmitContent, expdate,
			('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
			('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
			('{COOKIE_SECURE}' == '0') ? false : true);

	currentStep = 0;
	setTimeout("execQueue();", execInterval);
}

// -->
</script>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr>
		<th class="thHead">{L_MENU_TITLE}</th>
	</tr>
	<tr>
		<td align="center">
			{RESULT_MESSAGE}
		</td>
	</tr>
	<!-- BEGIN catrow -->
 	<tr>
 		<td class="row1">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="forumline">
				<tr>
					<td width="50%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{catrow.CAT_ID}','adminCat_');">&nbsp;<img name="adminCat_image_{catrow.CAT_ID}" src="{catrow.IMG_URL}" border="0" align="absmiddle">
						<span class="cattitle"><b>{catrow.CAT_TITLE}</b></span><br /><span class="gensmall"><b>{catrow.CAT_DESC}</b></span>
					</td>
					<td width="15%" class="cat" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{catrow.CAT_ID}','adminCatEdit_');">
						&nbsp;<img name="adminCatEdit_image_{catrow.CAT_ID}" src="{catrow.IMG_URL_EDIT}" border="0" align="absmiddle">
						<span class="gen">{L_EDIT}</span>
					</td>
					<td width="20%" class="cat" align="center" valign="middle" nowrap="nowrap">
						<span class="gen"><a href="{catrow.U_CAT_MOVE_UP}">{L_MOVE_UP}</a> <a href="{catrow.U_CAT_MOVE_DOWN}">{L_MOVE_DOWN}</a></span>
					</td>
				</tr>

				<tr>
					<td colspan="3" class="row1">
						<div id="adminCat_{catrow.CAT_ID}" style="display:{catrow.VISIBLE};" class="genmed">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td bgcolor="#006699" width="10"></td>
								<td>
									<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">

										<!-- Cat Edit -->
										<tr>
											<td class="row1" colspan="5">
												<div id="adminCatEdit_{catrow.CAT_ID}" style="display:{catrow.VISIBLE_EDIT};" class="genmed" >
												<form name="form_adminCatEdit_{catrow.CAT_ID}" action="{S_ACTION}" method="post" >
												<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
													<tr>
														<td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{catrow.CAT_ID}','adminCatEdit_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{catrow.L_TITLE_EDIT}</span></td>
													</tr>

													<tr>
													  <td class="row1"><b>{catrow.L_CAT_TITLE}</b></td>
													  <td class="row2" colspan="2"><input type="text" size="25" name="cat_title" value="{catrow.E_CAT_TITLE}" /></td>
													</tr>
													<tr>
													  <td class="row1">{catrow.L_MENU_ACTIVE}</td>
													  <td class="row2">{catrow.S_MENU_ACTIVE}</td>
													</tr>
													<tr>
													  <td class="row1" colspan="2">{catrow.L_MENU_ACTION_ADV}</td>
													</tr>
													<tr>
													  <td class="row1" valign="top">{catrow.L_MENU_ICON}</td>
													  <td class="row2">{catrow.S_POSTICONS}</td>
													</tr>
													<tr>
													  <td class="row1">{catrow.L_MENU_ALT_ICON}</td>
													  <td class="row2"><input type="text" size="65" name="menu_alt_icon" value="{catrow.E_MENU_ALT_ICON}" class="post" /></td>
													</tr>
													<tr>
													  <td class="row1">{catrow.L_MENU_ALT_ICON_HOT}</td>
													  <td class="row2"><input type="text" size="65" name="menu_alt_icon_hot" value="{catrow.E_MENU_ALT_ICON_HOT}" class="post" /></td>
													</tr>
													<tr>
														<td class="row2" colspan="2" align="center">{catrow.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{catrow.S_SUBMIT}" class="liteoption" /></td>
													</tr>
												</table>
												</form>
												</div>
											</td>
										</tr>
										<!-- Cat Edit -->

										<!-- BEGIN nocat -->
										{catrow.nocat.NONE}
										<!-- END nocat -->

										<!-- BEGIN menurow -->
										<tr>
											<td class="row1" colspan="5">
												<table width="100%" cellpadding="0" cellspacing="0" border="0"  align="center">
													<tr>
														<td class="row2" width="5">&nbsp;</td>
														<td>
															<table width="100%" cellpadding="4" cellspacing="0" border="0"  align="center">

																<tr>
																	<td width="65%" class="{catrow.menurow.ROW_CLASS}" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{catrow.menurow.MENU_ID}','adminMenuEdit_');"><img name="adminMenuEdit_image_{catrow.menurow.MENU_ID}" src="{catrow.menurow.IMG_URL_EDIT}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_BLOCK}" border="0" align="absmiddle">
																		<span class="gensmall">{catrow.menurow.MENU_TITLE}</span><br /><span class="gensmall">{catrow.menurow.MENU_DESC}</span>
																	</td>
																	<td width="20%" class="{catrow.menurow.ROW_CLASS}" align="center" valign="middle">
																		<span class="gensmall"><a href="{catrow.menurow.U_MENU_MOVE_UP}">{L_MOVE_UP}</a> <a href="{catrow.menurow.U_MENU_MOVE_DOWN}">{L_MOVE_DOWN}</a></span>
																	</td>
																</tr>

																<!-- Menu Edit -->
																<tr>
																<td class="row1" colspan="3">
																<div id="adminMenuEdit_{catrow.menurow.MENU_ID}" style="display:{catrow.menurow.VISIBLE_EDIT};" class="genmed">
																<form name="form_adminMenuEdit_{catrow.menurow.MENU_ID}" action="{S_ACTION}" method="post">
																  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																	<tr>
																	  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{catrow.menurow.MENU_ID}','adminMenuEdit_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{catrow.menurow.L_TITLE_EDIT}</span></td>
																	</tr>
																	<tr>
																	  <td class="row1">{catrow.menurow.L_MENU_TITLE}</td>
																	  <td class="row2"><input type="text" size="45" name="menuname" value="{catrow.menurow.E_MENU_TITLE}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td class="row1">{catrow.menurow.L_MENU_ACTIVE}</td>
																	  <td class="row2">{catrow.menurow.S_MENU_ACTIVE}</td>
																	</tr>
																	<tr>
																	  <td class="row1" colspan="2">{catrow.menurow.L_MENU_ACTION_ADV}</td>
																	</tr>
																	<tr>
																	  <td class="row1" valign="top">{catrow.menurow.L_MENU_ICON}</td>
																	  <td class="row2">{catrow.menurow.S_POSTICONS}</td>
																	</tr>
																	<tr>
																	  <td class="row1">{catrow.menurow.L_MENU_ALT_ICON}</td>
																	  <td class="row2"><input type="text" size="65" name="menu_alt_icon" value="{catrow.menurow.E_MENU_ALT_ICON}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td class="row1">{catrow.menurow.L_MENU_ALT_ICON_HOT}</td>
																	  <td class="row2"><input type="text" size="65" name="menu_alt_icon_hot" value="{catrow.menurow.E_MENU_ALT_ICON_HOT}" class="post" /></td>
																	</tr>
																	<tr>
																	  	<td class="row2" colspan="2" align="center">{catrow.menurow.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{catrow.menurow.S_SUBMIT}" class="liteoption" /></td>
																	</tr>
																  </table>
																</form>
																</div>
																</td>
																</tr>
																<!-- Menu Edit -->

															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<!-- END menurow -->
									</table>
								</td>
							</tr>
						</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- END catrow -->
</table>

<script type="text/javascript">
<!-- BEGIN catrow -->
menuCats['adminCat_{catrow.CAT_ID}'] = new menuCat('{catrow.CAT_ID}', 'adminCat_', '{catrow.VISIBLE}');
menuCats['adminCatEdit_{catrow.CAT_ID}'] = new menuCat('{catrow.CAT_ID}', 'adminCatEdit_', '{catrow.VISIBLE_EDIT}' );

	<!-- BEGIN menurow -->
	menuCats['adminMenuEdit_{catrow.menurow.MENU_ID}'] = new menuCat('{catrow.menurow.MENU_ID}', 'adminMenuEdit_', '{catrow.menurow.VISIBLE_EDIT}');
	<!-- END menurow -->
<!-- END catrow -->
// -->
</script>

