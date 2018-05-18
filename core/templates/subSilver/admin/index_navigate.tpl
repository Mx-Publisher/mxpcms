<script language="javascript" type="text/javascript">
<!--

/*************************************************************
 *	DHTML Slide Menu for ACP MOD
 *
 *	Copyright (C) 2004, Markus (phpMiX)
 *	This script is released under GPL License.
 *	Feel free to use this script (or part of it) wherever you need
 *	it ...but please, give credit to original author. Thank you. :-)
 *	We will also appreciate any links you could give us.
 *
 *	Enjoy! ;-)
 *
 *  This MOD is adapted for mxBB adminCP, by Jon
 *************************************************************/

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

function menuCat(id, rows, mode)
{
	this.cat_id = id;
	this.cat_rows = rows;
	this.menu_mode = mode;
	this.status = 'none';
}
var menuCats = new Array();

<!-- BEGIN module_portal -->
<!-- BEGIN catrow -->
menuCats['menuPortal_{module_portal.catrow.MENU_CAT_ID}'] = new menuCat('{module_portal.catrow.MENU_CAT_ID}', {module_portal.catrow.MENU_CAT_ROWS}, 'menuPortal_');
<!-- END catrow -->
<!-- END module_portal -->

<!-- BEGIN module_mx -->
<!-- BEGIN catrow -->
menuCats['menuMX_{module_mx.catrow.MENU_CAT_ID}'] = new menuCat('{module_mx.catrow.MENU_CAT_ID}', {module_mx.catrow.MENU_CAT_ROWS}, 'menuMX_');
<!-- END catrow -->
<!-- END module_mx -->

<!-- BEGIN module_phpbb -->
<!-- BEGIN catrow -->
menuCats['menuphpBB_{module_phpbb.catrow.MENU_CAT_ID}'] = new menuCat('{module_phpbb.catrow.MENU_CAT_ID}', {module_phpbb.catrow.MENU_CAT_ROWS}, 'menuphpBB_');
<!-- END catrow -->
<!-- END module_phpbb -->

function getObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}
function displayObj(obj, status)
{
	var x = getObj(obj);
	if( x && x.style ) x.style.display = status;
}

var queueInterval = 20;		// milliseconds between queued steps.
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

	currentCat = type + cat_id;
	currentStatus = menuCats[currentCat].status;

	queuedSteps = new Array();
	currentStep = 0;

	for( var catName in menuCats )
	{
		if( (menuCats[catName].menu_mode == type && menuCats[catName].status == 'block'))
		{
			for( var i=(menuCats[catName].cat_rows-1); i >= 0; i-- )
			{
				queuedSteps[currentStep++] = new queueStep(catName+'_'+i, 'none');
			}
			queuedSteps[currentStep++] = new queueStep(catName, 'none');
			menuCats[catName].status == 'none';

			if( document.images && document.images['image_' + catName] )
			{
				document.images['image_' + catName].src = '{IMG_URL_EXPAND}';
			}
		}
	}

	if( currentStatus == 'none' )
	{
		queuedSteps[currentStep++] = new queueStep(currentCat, 'block');
		for( var i=0; i < menuCats[currentCat].cat_rows; i++ )
		{
			queuedSteps[currentStep++] = new queueStep(currentCat+'_'+i, 'block');
		}
		menuCats[currentCat].status == 'block';

		var	expdate = new Date();		// 72 Hours from now
		expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
		setCookie('{COOKIE_NAME}_'+type+'cat_id', cat_id, expdate,
				('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
				('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
				('{COOKIE_SECURE}' == '0') ? false : true);

		if( document.images && document.images['image_' + currentCat] )
		{
			document.images['image_' + currentCat].src = '{IMG_URL_CONTRACT}';
		}
	}
	else
	{
		delCookie('{COOKIE_NAME}_'+type+'cat_id',
				('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
				('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}');
	}
	currentStep = 0;
	setTimeout("execQueue();", execInterval);
}

function doOnLoadMenuACP()
{
	var cat_id;

	if( getObj('menuPortal_0') )
	{
		cat_id = getCookie('{COOKIE_NAME}_menuPortal_cat_id');
		if( !menuCats['menuPortal_'+cat_id] )
		{
			cat_id = 0;
		}
		else
		{
			menuCats['menuPortal_'+cat_id].status = 'none';
		}
		onMenuCatClick(cat_id, 'menuPortal_', 'true');
	}

	if( getObj('menuMX_0') )
	{
		cat_id = getCookie('{COOKIE_NAME}_menuMX_cat_id');
		if( !menuCats['menuMX_'+cat_id] )
		{
			cat_id = 0;
		}
		else
		{
			menuCats['menuMX_'+cat_id].status = 'none';
		}
	}

	if( getObj('menuphpBB_0') )
	{
		cat_id = getCookie('{COOKIE_NAME}_menuphpBB_cat_id');
		if( !menuCats['menuphpBB_'+cat_id] )
		{
			cat_id = 0;
		}
		else
		{
			menuCats['menuphpBB_'+cat_id].status = 'none';
		}
	}

	if( oldOnLoadMenuACP )
	{
		oldOnLoadMenuACP();
	}
}
var	oldOnLoadMenuACP = window.onload;
window.onload = doOnLoadMenuACP;

// -->
</script>

<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" ><a href="{U_INDEX}" target="_parent"><img src="{LOGO}" border="0" /></a></td>
	</tr>
	<tr>
		<td align="center" >
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
				<tr>
					<th class="thHead"><b>{L_ADMIN}</b></th>
				</tr>
				<tr>
					<td class="row1"><span class="genmed"><a href="{U_ADMIN_INDEX}" target="main" class="genmed">{L_ADMIN_INDEX}</a></span></td>
				</tr>
				<tr>
					<td class="row1"><span class="genmed"><a href="{U_PORTAL_INDEX}" target="_parent" class="genmed">{L_PORTAL_INDEX}</a></span></td>
				</tr>
				<tr>
					<td class="row1"><span class="genmed"><a href="{U_FORUM_INDEX}" target="_parent" class="genmed">{L_FORUM_INDEX}</a></span></td>
				</tr>
				<tr>
					<td class="row1"><span class="genmed"><a href="{U_FORUM_INDEX}" target="main" class="genmed">{L_PREVIEW_FORUM}</a></span></td>
				</tr>
				<tr>
					<td class="row1"><span class="genmed"><a href="{U_PORTAL_INDEX}" target="main" class="genmed">{L_PREVIEW_PORTAL}</a></span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" >
			<!-- BEGIN module_portal -->
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
				<tr>
					<th class="thHead"><b>{module_portal.L_MX_PORTAL}</b></th>
				</tr>
				<!-- BEGIN catrow -->
				<tr>
					<td class="catSides" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module_portal.catrow.MENU_CAT_ID}','menuPortal_');"><img name="image_menuPortal_{module_portal.catrow.MENU_CAT_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<span class="cattitle"><a>{module_portal.catrow.ADMIN_CATEGORY}</a></span></td>
				</tr>
				<tr>
					<td class="row1">
						<div id="menuPortal_{module_portal.catrow.MENU_CAT_ID}" style="display:none;">
							<table width="100%" cellpadding="4" cellspacing="1" border="0" class="bodyline">
							<!-- BEGIN modulerow -->
							<tr>
								<td class="row1"><div id="menuPortal_{module_portal.catrow.MENU_CAT_ID}_{module_portal.catrow.modulerow.ROW_COUNT}" style="display:block;" class="genmed"><a href="{module_portal.catrow.modulerow.U_ADMIN_MODULE}"  target="main" class="genmed">{module_portal.catrow.modulerow.ADMIN_MODULE}</a></div></td>
							</tr>
							<!-- END modulerow -->
							</table>
						</div>
					</td>
				</tr>
				<!-- END catrow -->
			</table>
			<!-- END module_portal -->
		</td>
	</tr>
	<tr>
		<td align="center" >
			<!-- BEGIN module_mx -->
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
				<tr>
					<th class="thHead"><b>{module_mx.L_MX_MODULES}</b></th>
				</tr>
				<!-- BEGIN catrow -->
				<tr>
					<td class="catSides" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module_mx.catrow.MENU_CAT_ID}', 'menuMX_');"><img name="image_menuMX_{module_mx.catrow.MENU_CAT_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<span class="cattitle">{module_mx.catrow.ADMIN_CATEGORY}</span></td>
				</tr>
				<tr>
					<td class="row1">
						<div id="menuMX_{module_mx.catrow.MENU_CAT_ID}" style="display:none;">
							<table width="100%" cellpadding="4" cellspacing="1" border="0" class="bodyline">
							<!-- BEGIN modulerow -->
							<tr>
								<td class="row1"><div id="menuMX_{module_mx.catrow.MENU_CAT_ID}_{module_mx.catrow.modulerow.ROW_COUNT}" style="display:block;" class="genmed"><a href="{module_mx.catrow.modulerow.U_ADMIN_MODULE}"  target="main" class="genmed">{module_mx.catrow.modulerow.ADMIN_MODULE}</a></div></td>
							</tr>
							<!-- END modulerow -->
							</table>
						</div>
					</td>
				</tr>
				<!-- END catrow -->
			</table>
			<!-- END module_mx -->
		</td>
	</tr>
	<tr>
		<td align="center" >
			<!-- BEGIN module_phpbb -->
			<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
				<tr>
					<th class="thHead"><b>{module_phpbb.L_PHPBB}</b></th>
				</tr>
				<!-- BEGIN catrow -->
				<tr>
					<td class="catSides" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module_phpbb.catrow.MENU_CAT_ID}', 'menuphpBB_');"><img name="image_menuphpBB_{module_phpbb.catrow.MENU_CAT_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<span class="cattitle">{module_phpbb.catrow.ADMIN_CATEGORY}</span></td>
				</tr>
				<tr>
					<td class="row1">
						<div id="menuphpBB_{module_phpbb.catrow.MENU_CAT_ID}" style="display:none;">
							<table width="100%" cellpadding="4" cellspacing="1" border="0" class="bodyline">
							<!-- BEGIN modulerow -->
							<tr>
								<td class="row1"><div id="menuphpBB_{module_phpbb.catrow.MENU_CAT_ID}_{module_phpbb.catrow.modulerow.ROW_COUNT}" style="display:block;" class="genmed"><a href="{module_phpbb.catrow.modulerow.U_ADMIN_MODULE}"  target="main" class="genmed">{module_phpbb.catrow.modulerow.ADMIN_MODULE}</a></div></td>
							</tr>
							<!-- END modulerow -->
							</table>
						</div>
					</td>
				</tr>
				<!-- END catrow -->
			</table>
			<!-- END module_phpbb -->
		</td>
	</tr>
</table>

