<script type="text/javascript">
function menuCat(id, mode, visible)
{
	this.cat_id = id;
	this.menu_mode = mode;
	this.status = visible != '' ? visible : 'none';
}
var menuCats = new Array();

<!-- BEGIN module -->
menuCats['adminModule_{module.MODULE_ID}'] = new menuCat('{module.MODULE_ID}', 'adminModule_', '{module.VISIBLE}');
menuCats['adminModuleUpgrade_{module.MODULE_ID}'] = new menuCat('{module.MODULE_ID}', 'adminModuleUpgrade_', '{module.VISIBLE_UPGRADE}');
menuCats['adminModuleExport_{module.MODULE_ID}'] = new menuCat('{module.MODULE_ID}', 'adminModuleExport_', '{module.VISIBLE_EXPORT}');
menuCats['adminModuleDelete_{module.MODULE_ID}'] = new menuCat('{module.MODULE_ID}', 'adminModuleDelete_', '{module.VISIBLE_DELETE}');
<!-- END module -->

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

	parentCatMode = 'adminModule_';
	parentCat = parentCatMode + cat_id;

	currentCat = type + cat_id;

	currentStatus = menuCats[currentCat].status;

	queuedSteps = new Array();
	cookieArray = new Array();

	currentStep = 0;

	for( var forCat in menuCats )
	{
		if( (init == 'true' && (menuCats[forCat].status == 'block') && menuCats[forCat].menu_mode == parentCatMode) ||
			(init != 'true' &&
				( 	(menuCats[forCat].status == 'block') 	)))
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

		queuedSteps[currentStep++] = new queueStep(currentCat, 'block');
		menuCats[currentCat].status = 'block';

		if (currentCat == parentCat)
		{
			var	expdate = new Date();		// 72 Hours from now
			expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
			setCookie('{COOKIE_NAME}_'+type+'module_id', cat_id, expdate,
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
		delCookie('{COOKIE_NAME}_'+type+'module_id',
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

	setCookie('{COOKIE_NAME}_admincp_blockstates', strSubmitContent, expdate,
			('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
			('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
			('{COOKIE_SECURE}' == '0') ? false : true);

	currentStep = 0;
	setTimeout("execQueue();", execInterval);
}

function doOnLoadMenuACP()
{
	var cat_id;

	if( getObj('adminModule_' + '{NAV_MODULE_ID}') )
	{
		if ( '{NAV_MODULE_ID}' > 0 )
		{
			cat_id = '{NAV_MODULE_ID}';
		}
		else
		{
			cat_id = getCookie('{COOKIE_NAME}_adminModule_module_id');
		}

		if( menuCats['adminModule_'+cat_id] )
		{
			menuCats['adminModule_'+cat_id].status = 'none';
			onMenuCatClick(cat_id, 'adminModule_', 'true');
		}
	}

	if( oldOnLoadMenuACP )
	{
		oldOnLoadMenuACP();
	}
}

function checkForm(form) {
   formErrors = '';
   if (form.module_name.value.length < 2) {
      formErrors += "Fill out the module title\r\n";
   }
   if (form.module_desc.value.length < 2) {
      formErrors += "Fill out the module description\r\n";
   }
   if (form.module_path.value.length < 2) {
      formErrors += "Fill out the module path\r\n";
   }

   if (formErrors) {
      alert(formErrors);
      return false;
   } else {
      return true;
   }
}

var	oldOnLoadMenuACP = window.onload;
window.onload = doOnLoadMenuACP;

// -->
</script>

<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form method="post" name="jumpbox" action="{S_ACTION}">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td nowrap="nowrap" align="right"><span class="gensmall"><b>{L_QUICK_NAV}</b>&nbsp;
				{MODULE_SELECT_BOX}
				<input type="submit" value="{S_SUBMIT}" class="liteoption" /></span>
			</td>
		</tr>
	</table>
</form>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
		<td align="center" colspan="5">{RESULT_MESSAGE}</td>
	</tr>
	<tr>
		<th class="thHead" colspan="5">{L_TITLE}</th>
	</tr>
	<tr>
      <td class="catBottom" colspan="5" align="center">
      	<form action="{S_ACTION}" method="post">
      		{S_MODULE_INSTALL_LIST}
			{S_HIDDEN_MODULE_INSTALL_FIELDS}
			<input class="mainoption" type="submit" name="import_pack" value="{L_IMPORT_PACK}">
      	</form>
      </td>
   </tr>
	<!-- BEGIN module -->
	<tr title="{L_TITLE}">
		<td width="40%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModule_');">&nbsp;<span class="cattitle"><img name="adminModule_image_{module.MODULE_ID}" src="{module.IMG_URL}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_MODULE}" border="0" align="absmiddle"> {module.MODULE_TITLE}</span> <span class="gensmall">{module.MODULE_DESCRIPTION}</span><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gensmall"><i>{module.MODULE_VERSION}</i></span></td>
		<td width="15%" class="cat" align="center" valign="middle">
			<!-- BEGIN settings -->
			<img src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<span class="cattitle"><a href="{module.U_MODULE}">{L_SETTING}</a></span>
			<!-- END settings -->
		</td>
		<td width="15%" class="cat" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleUpgrade_');">
			<!-- BEGIN settings -->
			<img name="adminModuleUpgrade_image_{module.MODULE_ID}" src="{module.IMG_URL_UPGRADE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_UPGRADE_PACK}</span>
			<!-- END settings -->
		</td>
		<td width="15%" class="cat" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleExport_');">
			<!-- BEGIN settings -->
			<img name="adminModuleExport_image_{module.MODULE_ID}" src="{module.IMG_URL_EXPORT}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_EXPORT_PACK}</span>
			<!-- END settings -->
		</td>
		<td width="15%" class="catRight" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleDelete_');">
			<!-- BEGIN settings -->
			<img name="adminModuleDelete_image_{module.MODULE_ID}" src="{module.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_UNINSTALL}</span>
			<!-- END settings -->
		</td>
	</tr>

					<!-- Module Delete -->
					<tr>
					<td colspan="5" class="row1">
					<div id="adminModuleDelete_{module.MODULE_ID}" style="display:{module.VISIBLE_DELETE};" class="genmed">
					  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
						<tr>
						  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleDelete_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_UNINSTALL}</span></td>
						</tr>
						<tr>
						  <td width="50%" align="center" colspan="2">{module.MESSAGE_DELETE}</td>
						</tr>
					  </table>
					</div>
					</td>
					</tr>
					<!-- Module Delete -->

					<!-- Module Upgrade -->
					<tr>
					<td colspan="5" class="row1">
					<div id="adminModuleUpgrade_{module.MODULE_ID}" style="display:{module.VISIBLE_UPGRADE};" class="genmed">
					  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
						<tr>
						  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleUpgrade_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_UPGRADE_PACK}</span></td>
						</tr>
						<tr>
						  <td width="50%" align="center" colspan="2">{module.MESSAGE_UPGRADE}</td>
						</tr>
					  </table>
					</div>
					</td>
					</tr>
					<!-- Module Upgrade -->

					<!-- Module Export -->
					<tr>
					<td colspan="5" class="row1">
					<div id="adminModuleExport_{module.MODULE_ID}" style="display:{module.VISIBLE_EXPORT};" class="genmed">
					  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
						<tr>
						  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModuleExport_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_EXPORT_PACK}</span></td>
						</tr>
						<tr>
						  <td width="50%" align="center" colspan="2">{module.MESSAGE_EXPORT}</td>
						</tr>
					  </table>
					</div>
					</td>
					</tr>
					<!-- Module Export -->

					<!-- Module Settings -->
					<tr>
					<td colspan="5" class="row1">
					<div id="adminModule_{module.MODULE_ID}" style="display:{module.VISIBLE};" class="genmed">
					<form action="{S_ACTION}" onsubmit="return checkForm(this)" name="post" method="post">
					  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
						<tr>
						  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModule_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.L_TITLE}</span></td>
						</tr>
						<tr>
						  <td width="50%" align="right" >{L_MODULE_NAME}</td>
						  <td ><input type="text" size="50" name="module_name" value="{module.E_MODULE_NAME}" class="post" /></td>
						</tr>
						<tr>
						  <td width="50%" align="right" >{L_MODULE_DESC}</td>
						  <td ><input type="text" size="50" name="module_desc" value="{module.E_MODULE_DESC}" class="post" /></td>
						</tr>
						<tr>
						  <td width="50%" align="right" >{L_MODULE_PATH}</td>
						  <td ><input type="text" size="50" name="module_path" value="{module.E_MODULE_PATH}" class="post" /></td>
						</tr>
						<tr>
						  <td width="50%" align="right" >{L_MODULE_INCLUDE_ADMIN}</td>
						  <td ><input type="checkbox" size="45" name="module_include_admin" value="1" {module.E_MODULE_INCLUDE_CHECK_OPT}/></td>
						</tr>
						<tr>
						  <td class="row2" colspan="2" align="center">{module.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{module.S_SUBMIT}" class="liteoption" /></td>
						</tr>
					  </table>
					</form>
					</div>
					</td>
					</tr>
					<!-- Module Settings -->

	<!-- END module -->
   </table>


