<script type="text/javascript" src="../modules/mx_shared/lib/DynamicOptionList_comp.js"></script>
<script type="text/javascript">
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

<!-- BEGIN module -->
menuCats['adminModule_{module.MODULE_ID}'] = new menuCat('{module.MODULE_ID}', 'adminModule_', '{module.VISIBLE}');
	<!-- BEGIN function -->
	menuCats['adminFunction_{module.function.FUNCTION_ID}'] = new menuCat('{module.function.FUNCTION_ID}', 'adminFunction_', '{module.function.VISIBLE_FUNC}');
	menuCats['adminFunctionDelete_{module.function.FUNCTION_ID}'] = new menuCat('{module.function.FUNCTION_ID}', 'adminFunctionDelete_', '{module.function.VISIBLE_DELETE}');
	menuCats['adminParameter_{module.function.FUNCTION_ID}'] = new menuCat('{module.function.FUNCTION_ID}', 'adminParameter_', '{module.function.VISIBLE_PAR}');
	menuCats['adminBlock_{module.function.FUNCTION_ID}'] = new menuCat('{module.function.FUNCTION_ID}', 'adminBlock_', '{module.function.VISIBLE_BLOCK}');
		<!-- BEGIN parameter -->
			menuCats['adminParEdit_{module.function.parameter.PARAMETER_ID}'] = new menuCat('{module.function.parameter.PARAMETER_ID}', 'adminParEdit_', '{module.function.parameter.VISIBLE}');
			menuCats['adminParDelete_{module.function.parameter.PARAMETER_ID}'] = new menuCat('{module.function.parameter.PARAMETER_ID}', 'adminParDelete_', '{module.function.parameter.VISIBLE_DELETE}');
			<!-- END parameter -->
		<!-- BEGIN block -->
			menuCats['adminEdit_{module.function.block.BLOCK_ID}'] = new menuCat('{module.function.block.BLOCK_ID}', 'adminEdit_', '{module.function.block.VISIBLE_EDIT}');
			menuCats['adminPrivate_{module.function.block.BLOCK_ID}'] = new menuCat('{module.function.block.BLOCK_ID}', 'adminPrivate_', '{module.function.block.VISIBLE_PRIVATE}');
			menuCats['adminBlockDelete_{module.function.block.BLOCK_ID}'] = new menuCat('{module.function.block.BLOCK_ID}', 'adminBlockDelete_', '{module.function.block.VISIBLE_DELETE}');
			<!-- BEGIN settings -->
			menuCats['adminSettings_{module.function.block.BLOCK_ID}'] = new menuCat('{module.function.block.BLOCK_ID}', 'adminSettings_', '{module.function.block.VISIBLE_SETTINGS}');
			<!-- END settings -->
		<!-- END block -->
	<!-- END function -->
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

	parentModuleMode = 'adminModule_';
	parentFunctionMode = 'adminBlock_';
	parentFuncEditMode = 'adminFunction_';
	parentFuncParMode = 'adminParameter_';
	parentFuncDeleteMode = 'adminFunctionDelete_';
	parentBlockEditMode = 'adminEdit_';
	parentBlockPrivateMode = 'adminPrivate_';
	parentBlockDeleteMode = 'adminBlockDelete_';

	parentModuleCat = parentModuleMode + cat_id;
	parentFunctionCat = parentFunctionMode + cat_id;
	parentFuncEditCat = parentFuncEditMode + cat_id;
	parentFuncParCat = parentFuncParMode + cat_id;
	parentFuncDeleteCat = parentFuncDeleteMode + cat_id;
	parentBlockEditCat = parentBlockEditMode + cat_id;
	parentBlockPrivateCat = parentBlockPrivateMode + cat_id;
	parentBlockDeleteCat = parentBlockDeleteMode + cat_id;

	currentCat = type + cat_id;

	currentStatus = menuCats[currentCat].status;

	queuedSteps = new Array();
	cookieArray = new Array();

	currentStep = 0;

	for( var forCat in menuCats )
	{
		if( (init == 'true' && (menuCats[forCat].status == 'block') && menuCats[forCat].menu_mode == parentModuleMode) ||
			(init != 'true' &&
				( 	(currentCat == parentModuleCat && menuCats[forCat].status == 'block') ||

					(currentCat == parentFunctionCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].status == 'block') ||

					(currentCat == parentFuncEditCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentFuncParCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentFuncDeleteCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||

					(currentCat == parentBlockEditCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentBlockPrivateCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentBlockDeleteCat && menuCats[forCat].menu_mode != parentModuleMode && menuCats[forCat].menu_mode != parentFunctionMode && menuCats[forCat].status == 'block') ||

					(currentCat != parentModuleCat && currentCat != parentFunctionCat && forCat == currentCat && currentStatus == 'block') 	)))
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

		if (currentCat == parentModuleCat)
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

function checkForm() {
   formErrors = '';
   if (document.forms['function'].function_name.value.length < 2) {
      formErrors += "Fill out the function title\r\n";
   }
   if (document.forms['function'].function_desc.value.length < 2) {
      formErrors += "Fill out the function description\r\n";
   }
   if (document.forms['function'].function_file.value.length < 2) {
      formErrors += "Fill out the function file\r\n";
   }

   if (formErrors) {
      alert(formErrors);
      return false;
   } else {
   		if(bbstyle){
      		bbstyle(-1);
   		}
      //formObj.preview.disabled = true;
      //formObj.submit.disabled = true;
      return true;
   }
}

var	oldOnLoadMenuACP = window.onload;
window.onload = doOnLoadMenuACP;

// -->
</script>

<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<form method="post" name="jumpbox" action="{S_ACTION}">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" >
					<tr>
						<td align="left">
							<!--
							<span class="gensmall"><b>{L_INCLUDE_ALL}:</b>&nbsp;
							<input type="radio" name="include_all" value="1" {S_INCLUDE_ALL_YES} /> {L_YES}&nbsp;<input type="radio" name="include_all" value="0" {S_INCLUDE_ALL_NO} /> {L_NO}

							<input type="submit" value="{S_SUBMIT}" class="liteoption" />

							<br />
							-->
							<span class="gensmall"><b>{L_INCLUDE_BLOCK_QUICKEDIT}:</b>&nbsp;
							<input type="radio" name="include_block_quickedit" value="1" {S_INCLUDE_BLOCK_QUICKEDIT_YES} /> {L_YES}&nbsp;<input type="radio" name="include_block_quickedit" value="0" {S_INCLUDE_BLOCK_QUICKEDIT_NO} /> {L_NO}

							&nbsp;&nbsp;

							<span class="gensmall"><b>{L_INCLUDE_BLOCK_PRIVATE}:</b>&nbsp;
							<input type="radio" name="include_block_private" value="1" {S_INCLUDE_BLOCK_PRIVATE_YES} /> {L_YES}&nbsp;<input type="radio" name="include_block_private" value="0" {S_INCLUDE_BLOCK_PRIVATE_NO} /> {L_NO}

							<input type="submit" value="{S_SUBMIT}" class="liteoption" />
							</span>
						</td>
						<td nowrap="nowrap" align="right">
							<span class="gensmall"><b>{L_QUICK_NAV}</b>&nbsp;
							{MODULE_SELECT_BOX}
							<input type="submit" value="{S_SUBMIT}" class="liteoption" />
							</span>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>

<div id="admincp">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
		<td align="center">
			{RESULT_MESSAGE}
		</td>
	</tr>
	<tr>
		<th class="thHead">{L_TITLE}</th>
	</tr>
	<!-- BEGIN nomodule -->
	<tr>
		<td class="row1"><span class="gensmall">{nomodule.NONE}</span></td>
	</tr>
	<!-- END nomodule -->

	<!-- BEGIN module -->

	<!-- BEGIN allmodules -->
	<tr>
		<td bgcolor="#006699" height="5">&nbsp;</td>
	</tr>
	<!-- END allmodules -->
	<tr>
		<td class="row1">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr title="ddd">
					<!-- BEGIN is_current -->
					<td width="70%" colspan="3" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.MODULE_ID}','adminModule_');"><img name="adminModule_image_{module.MODULE_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_MODULE}" border="0" align="absmiddle"> <span class="cattitle"> {module.MODULE_TITLE}</span> <span class="gensmall">{module.MODULE_DESC}</span></td>
					<!-- END is_current -->
					<!-- BEGIN reload -->
					<td width="70%" colspan="3" class="catLeft" style="cursor:pointer;cursor:hand;"><img name="adminModule_image_{module.MODULE_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_MODULE}" border="0" align="absmiddle"> <a href="{module.reload.U_MODULE_EDIT}"><span class="cattitle">{module.MODULE_TITLE}</span></a> <span class="gensmall">{module.MODULE_DESC}</span></td>
					<!-- END reload -->
					<td width="30%" class="catRight" align="right" valign="middle"><img src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;<span class="cattitle"><a href="{module.U_MODULE_EDIT}">{L_EDIT}</a></span></td>
				</tr>

				<tr>
					<td colspan="4" class="row3">
						<div id="adminModule_{module.MODULE_ID}" style="display:none;" class="genmed">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td bgcolor="#006699" width="10"></td>
								<td>
									<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
									<!-- BEGIN nofunction -->
										<tr>
											<td colspan="5" class="row1"><span class="gensmall">{module.nofunction.NONE}</span></td>
										</tr>
									<!-- END nofunction -->
									<!-- BEGIN function -->
										<tr>
											<td class="row1" colspan="5">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
													<tr>
														<td class="row2" width="5">&nbsp;</td>
														<td>
															<table width="100%" cellpadding="4" cellspacing="0" border="0"  align="center">
																<tr>
																	<td width="70%" class="row2" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','{module.function.COOKIE_TAG}');"><img name="{module.function.COOKIE_TAG}image_{module.function.FUNCTION_ID}" src="{module.function.IMG_URL_FUNC}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_FUNCTION}" border="0" align="absmiddle">&nbsp;{module.function.FUNCTION_TITLE} <span class="gensmall">{module.function.FUNCTION_DESC}</span></td>
																	<td width="10%" class="row2" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminFunction_');">
																	<!-- BEGIN is_function -->
																		<img name="adminFunction_image_{module.function.FUNCTION_ID}" src="{module.function.IMG_URL_FUNC}" border="0" align="absmiddle">&nbsp;<span class="genmed"><b>{L_EDIT}</b></span>
																	<!-- END is_function -->
																	</td>
																	<td width="10%" class="row2" align="center" valign="middle" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminParameter_');" >
																	<!-- BEGIN is_function -->
																		<img name="adminParameter_image_{module.function.FUNCTION_ID}" src="{module.function.IMG_URL_PAR}" border="0" align="absmiddle">&nbsp;<span class="genmed"><b>{module.function.L_EDIT_PAR}</b></span>
																	<!-- END is_function -->
																	</td>
																	<td width="10%" class="row2" align="center" valign="middle" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminFunctionDelete_');" >
																	<!-- BEGIN is_function -->
																		<img name="adminFunctionDelete_image_{module.function.FUNCTION_ID}" src="{module.function.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed"><b>{module.function.L_DELETE}</b></span>
																	<!-- END is_function -->
																	</td>
																</tr>

																<!-- Function Delete -->
																<tr>
																<td colspan="5" class="row1">
																<div id="adminFunctionDelete_{module.function.FUNCTION_ID}" style="display:{module.function.VISIBLE_DELETE};" class="genmed">
																  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																	<tr>
																	  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminFunctionDelete_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_DELETE}</span></td>
																	</tr>
																	<tr>
																	  <td width="50%" align="center" colspan="2">{module.function.MESSAGE_DELETE}</td>
																	</tr>
																  </table>
																</div>
																</td>
																</tr>
																<!-- Function Delete -->

																<!-- Function Settings -->
																<tr>
																<td class="row1" colspan="4">
																<div id="adminFunction_{module.function.FUNCTION_ID}" style="display:{module.function.VISIBLE_FUNC};" class="genmed">
																<form id="form_adminFunction_{module.function.FUNCTION_ID}" action="{S_ACTION}" method="post">
																  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																	<tr>
																	  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminFunction_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.function.L_TITLE}</span></td>
																	</tr>
																	<!--
																	<tr>
																	  <td width="50%" align="right" >{module.function.L_MODULE}</td>
																	  <td >{module.function.E_MODULE_SELECT}</td>
																	</tr>
																	-->
																	<tr>
																	  <td width="50%" align="right" >{module.function.L_FUNCTION_TITLE}</td>
																	  <td ><input type="text" size="45" name="function_name" value="{module.function.E_FUNCTION_TITLE}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td width="50%" align="right" >{module.function.L_FUNCTION_DESC}</td>
																	  <td ><input type="text" size="45" name="function_desc" value="{module.function.E_FUNCTION_DESC}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td width="50%" align="right" >{module.function.L_FUNCTION_FILE}</td>
																	  <td ><input type="text" size="45" name="function_file" value="{module.function.E_FUNCTION_FILE}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td width="50%" align="right" >{module.function.L_FUNCTION_ADMIN_FILE}</td>
																	  <td ><input type="text" size="45" name="function_admin" value="{module.function.E_FUNCTION_ADMIN_FILE}" class="post" /></td>
																	</tr>
																	<tr>
																	  <td class="row2" colspan="2" align="center">{module.function.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{module.function.S_SUBMIT}" class="liteoption" /></td>
																	</tr>
																  </table>
																</form>
																</div>
																</td>
																</tr>
																<!-- Function Settings -->

																<!-- Parameter Settings -->
																<tr>
																	<td colspan="4" class="row1">
																	<div id="adminParameter_{module.function.FUNCTION_ID}" style="display:{module.function.VISIBLE_PAR};" class="genmed">
																	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
																		<tr>
																			<td class="row3" width="1">&nbsp;</td>
																			<td>
																				<form method="post" action="{S_ACTION}">
																				<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center" >
																					<tr>
																					  <td class="row3" colspan="5" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.FUNCTION_ID}','adminParameter_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.function.L_TITLE_PAR}</span></td>
																					</tr>
																					<tr>
																						<td width="40%" class="row2"><span class="topictitle">{module.function.parameter.L_PARAMETER_TITLE}</span></td>
																						<td width="20%" class="row2"><span class="topictitle">{module.function.parameter.L_PARAMETER_TYPE}</span></td>
																						<td width="40%" colspan="3" class="row2" align="center"><span class="topictitle">{module.function.parameter.L_ACTION}</span></td>
																					</tr>

																					<!-- BEGIN noparameter -->
																					<tr>
																						<td colspan="5" class="row1"><span class="gensmall">{module.function.noparameter.NONE}</span></td>
																					</tr>
																					<!-- END noparameter -->

																					<!-- BEGIN parameter -->
																					<tr>
																						<td width="40%" class="{module.function.parameter.ROW_CLASS}" style="cursor:pointer;cursor:hand;" onclick=" onMenuCatClick('{module.function.parameter.PARAMETER_ID}','adminParEdit_');">
																							<img src="{IMG_ICON_PARAMETER}" border="0" align="absmiddle">&nbsp;{module.function.parameter.PARAMETER_TITLE}
																						</td>
																						<td width="20%" class="{module.function.parameter.ROW_CLASS}">
																						<!-- BEGIN is_parameter -->
																						{module.function.parameter.PARAMETER_TYPE}
																						<!-- END is_parameter -->
																						</td>
																						<td width="10%" class="{module.function.parameter.ROW_CLASS}" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.parameter.PARAMETER_ID}','adminParEdit_');">
																						<!-- BEGIN is_parameter -->
																							<img name="adminParEdit_image_{module.function.parameter.PARAMETER_ID}" src="{module.function.parameter.IMG_URL}" border="0" align="absmiddle">&nbsp;
																						<!-- END is_parameter -->
																						{module.function.parameter.L_EDIT}</td>
																						<td width="10%" class="{module.function.parameter.ROW_CLASS}" align="center" valign="middle" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.parameter.PARAMETER_ID}','adminParDelete_');" >
																						<!-- BEGIN is_parameter -->
																							<img name="adminParDelete_image_{module.function.parameter.PARAMETER_ID}" src="{module.function.parameter.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed"><b>{module.function.parameter.L_DELETE}</b></span>
																						<!-- END is_parameter -->
																						</td>
																						<td width="20%" class="{module.function.parameter.ROW_CLASS}" align="center" valign="middle"><span class="gen">
																						<!-- BEGIN is_parameter -->
																							<a href="{module.function.parameter.U_MOVE_UP}"><span class="gensmall">{L_MOVE_UP}</span></a> <a href="{module.function.parameter.U_MOVE_DOWN}"><span class="gensmall">{L_MOVE_DOWN}</span></a></span>
																						<!-- END is_parameter -->
																						</td>

																					</tr>

																					<!-- Parameter Delete -->
																					<tr>
																					<td colspan="5" class="row1">
																					<div id="adminParDelete_{module.function.parameter.PARAMETER_ID}" style="display:{module.function.parameter.VISIBLE_DELETE};" class="genmed">
																					  <table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																						<tr>
																						  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.parameter.PARAMETER_ID}','adminParDelete_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_DELETE}</span></td>
																						</tr>
																						<tr>
																						  <td width="50%" align="center" colspan="2">{module.function.parameter.MESSAGE_DELETE}</td>
																						</tr>
																					  </table>
																					</div>
																					</td>
																					</tr>
																					<!-- Parameter Delete -->

																					<!-- Parameter EDIT -->
																					<tr>
																					<td colspan="5" class="row1">
																					<div id="adminParEdit_{module.function.parameter.PARAMETER_ID}" style="display:{module.function.parameter.VISIBLE};" class="genmed">
																					<form action="{S_ACTION}" method="post">
																					  <table width="100%" cellpadding="2" cellspacing="1" border="0" align="center">
																						<tr>
																						  <td class="row3" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.parameter.PARAMETER_ID}','adminParEdit_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.function.parameter.L_EDIT}</span></td>
																						</tr>
																						<tr>
																						  <td width="50%" align="right">{module.function.parameter.L_PARAMETER_TITLE}</td>
																						  <td><input type="text" size="45" name="parameter_name" value="{module.function.parameter.E_PARAMETER_TITLE}" class="post" /></td>
																						</tr>
																						<tr>
																						<!--
																						<tr>
																						  <td width="50%" align="right">{module.function.parameter.L_FUNCTION}</td>
																						  <td>{module.function.parameter.E_FUNCTION_SELECT}</td>
																						</tr>
																						-->
																						<tr>
																						  <td width="50%" align="right">{module.function.parameter.L_PARAMETER_TYPE}</td>
																						  <td>{module.function.parameter.E_PARAMETER_TYPE}</td>
																						</tr>
																						<tr>
																							<td width="50%" align="right">{module.function.parameter.L_PARAMETER_AUTH}</span></td>
																							<td><input type="radio" name="parameter_auth" value="1" {module.function.parameter.E_PARAMETER_AUTH_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="parameter_auth" value="0" {module.function.parameter.E_PARAMETER_AUTH_NO} /> <span class="gensmall">{L_NO}</span></td>
																						</tr>
																						<tr>
																						  <td width="50%" align="right">{module.function.parameter.L_PARAMETER_DEFAULT}</td>
																						  <td><input type="text" size="45" name="parameter_default" value="{module.function.parameter.E_PARAMETER_DEFAULT}" class="post" /></td>
																						</tr>
																						<tr>
																						  <td width="50%" align="right">{module.function.parameter.L_PARAMETER_FUNCTION}<br /><br /><span class="gensmall">{module.function.parameter.L_PARAMETER_FUNCTION_EXPLAIN}</span></td>
																						  <td><textarea rows="20" cols="100" wrap="virtual" name="parameter_function" class="post" />{module.function.parameter.E_PARAMETER_FUNCTION}</textarea></td>
																						</tr>
																						<tr>
																						  <td class="row3" colspan="2" align="center">{module.function.parameter.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{module.function.parameter.S_SUBMIT}" class="mainoption" /></td>
																						</tr>
																					  </table>
																					</form>
																					</div>
																					</td>
																					</tr>

																					<!-- END parameter -->

																					</table>
																					</form>
																			  	</td>
																			</tr>
																		</table>
																		</div>
																  	</td>
																</tr>
																<!-- Parameter Settings -->

															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>


										<tr>
											<td colspan="4" class="row1">
												<div id="adminBlock_{module.function.FUNCTION_ID}" style="display:{module.function.VISIBLE_BLOCK};" class="genmed">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">

												<!-- BEGIN noblock -->
												<tr>
													<td colspan="5" class="row1"><span class="gensmall">{module.function.noblock.NONE}</span></td>
												</tr>
												<!-- END noblock -->
												<!-- BEGIN block -->
												<tr>
													<td width="50%" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminEdit_');" class="row1">
														&nbsp;&nbsp;&nbsp;&nbsp;<img src="{IMG_ICON_BLOCK}" border="0" align="absmiddle">&nbsp;<span class="gen">{module.function.block.BLOCK_TITLE}</span> <span class="gensmall"><i>{module.function.block.BLOCK_LAST_EDITED}</i></span> <span class="gensmall">{module.function.block.BLOCK_DESC}</span>
													</td>
													<td width="15%" align="right" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminEdit_');" class="row1">
													<!-- BEGIN is_block -->
													&nbsp;&nbsp;&nbsp;&nbsp;
													<!-- BEGIN include_block_edit -->
														<img name="adminEdit_image_{module.function.block.BLOCK_ID}" src="{module.function.block.IMG_URL_EDIT}" border="0" align="absmiddle">&nbsp;<span class="genmed">{module.function.block.L_EDIT}</span>
													<!-- END include_block_edit -->
													<!-- END is_block -->
													</td>
													<td width="15%" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminPrivate_');" class="row1">
													<!-- BEGIN is_block -->
													&nbsp;&nbsp;&nbsp;&nbsp;
													<!-- BEGIN include_block_private -->
														<img name="adminPrivate_image_{module.function.block.BLOCK_ID}" src="{module.function.block.IMG_URL_PRIVATE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{module.function.block.L_PERMISSIONS_ADV}</span>
													<!-- END include_block_private -->
													<!-- END is_block -->
													</td>
													<td width="10%" class="row1" align="center" valign="middle">
													<!-- BEGIN is_block -->
														<span class="gensmall"><a href="{module.function.block.U_BLOCK_SETTINGS}">{module.function.block.L_SETTINGS}</a></span>
													<!-- END is_block -->
													</td>
													<td width="10%" class="row1" align="center" valign="middle" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminBlockDelete_');" >
													<!-- BEGIN is_block -->
														<img name="adminBlockDelete_image_{module.function.block.BLOCK_ID}" src="{module.function.block.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{module.function.block.L_DELETE}</span>
													<!-- END is_block -->
													</td>
												</tr>

												<!-- Block Delete -->
												<tr>
													<td colspan="5" class="row1">
														<div id="adminBlockDelete_{module.function.block.BLOCK_ID}" style="display:{module.function.block.VISIBLE_DELETE};" class="genmed">
												  		<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
															<tr>
													  			<td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminBlockDelete_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{L_DELETE}</span></td>
															</tr>
															<tr>
												  				<td width="50%" align="center" colspan="2">{module.function.block.MESSAGE_DELETE}</td>
															</tr>
												 		</table>
														</div>
													</td>
												</tr>
												<!-- Block Delete -->

												<!-- Block Quick Edit -->
												<tr>
													<td colspan="5">
														<div id="adminEdit_{module.function.block.BLOCK_ID}" style="display:{module.function.block.VISIBLE_EDIT};" class="genmed">
														<form action="{S_ACTION}" method="post">
														<table width="100%" cellpadding="2" cellspacing="1" border="0" align="center">
															<tr>
															  <td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminEdit_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.function.block.L_TITLE}</span></td>
															</tr>
															<tr>
															 	<td class="row1" width="50%" align="right"><b>{module.function.block.L_BLOCK_TITLE}</b></td>
															 	<td class="row1"><input type="text" size="65" name="block_title" value="{module.function.block.E_BLOCK_TITLE}" class="post" /></td>
															</tr>
															<tr>
															 	<td class="row1" width="50%" align="right"><b>{module.function.block.L_BLOCK_DESC}</b></td>
															 	<td class="row1"><input type="text" size="65" name="block_desc" value="{module.function.block.E_BLOCK_DESC}" class="post" /></td>
															</tr>

															<tr>
																<td class="row1" width="50%" align="right"><b>{module.function.block.L_SHOW_TITLE}</b><br /><span class="gensmall">{module.function.block.L_SHOW_TITLE_EXPLAIN}</span></td>
																<td class="row1"><input type="radio" name="show_title" value="1" {module.function.block.S_SHOW_TITLE_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="show_title" value="0" {module.function.block.S_SHOW_TITLE_NO} /> <span class="gensmall">{L_NO}</span></td>
															</tr>
															<tr>
																<td class="row1" width="50%" align="right"><b>{module.function.block.L_SHOW_STATS}</b><br /><span class="gensmall">{module.function.block.L_SHOW_STATS_EXPLAIN}</span></td>
																<td class="row1"><input type="radio" name="show_stats" value="1" {module.function.block.S_SHOW_STATS_YES} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_stats" value="0" {module.function.block.S_SHOW_STATS_NO} /> <span class="gensmall">{L_NO}</span></td>
															</tr>
															<tr>
																<td class="row1" width="50%" align="right"><b>{module.function.block.L_SHOW_BLOCK}</b><br /><span class="gensmall">{module.function.block.L_SHOW_BLOCK_EXPLAIN}</span></td>
																<td class="row1"><input type="radio" name="show_block" value="1" {module.function.block.S_SHOW_BLOCK_YES} /> <span class="gensmall">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_block" value="0" {module.function.block.S_SHOW_BLOCK_NO} /> <span class="gensmall">{L_NO}</span></td>
															</tr>
															<tr>
																<td class="row1" width="50%" align="right"><b>{module.function.block.L_AUTH_TITLE}</b><br /><span class="gensmall">{module.function.block.L_AUTH_TITLE_EXPLAIN}</span></td>
																<td class="row1">
																	<table cellspacing="1" cellpadding="4" border="0">
																		<tr>
																		   	<!-- BEGIN block_auth_titles -->
																			<td class="row3" align="center"><span class="topictitle">{module.function.block.block_auth_titles.CELL_TITLE}</span></td>
																		    <!-- END block_auth_titles -->
																		    </tr>
																		<tr>
																		   	<!-- BEGIN block_auth_data -->
																			<td>
																				<table>
																					<tr>
																			    	  	<td class="row1" align="center">{module.function.block.block_auth_data.S_AUTH_LEVELS_SELECT}</td>
																					</tr>
																				</table>
																			</td>
																			<!-- END block_auth_data -->
																	    </tr>
																	 </table>
																</td>
															</tr>
															<tr>
																<td class="row1" width="50%" align="right">{module.function.block.L_COLUMN}</td>
																<td class="row1">{module.function.block.S_COLUMN_LIST}</td>
															</tr>
															<tr>
																<td class="row2" colspan="2" align="center">{module.function.block.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{module.function.block.S_SUBMIT}" class="mainoption" /></td>
															</tr>
														</table>
														</form>
														<hr>
														</div>
													</td>
												</tr>
												<!-- Block Edit -->


												<!-- Block PRIVATE Auth -->
												<tr>
													<td colspan="5">
														<div id="adminPrivate_{module.function.block.BLOCK_ID}" style="display:{module.function.block.VISIBLE_PRIVATE};" class="genmed">
														<form action="{S_ACTION}" method="post">
														<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
															<tr>
															  <td class="row2" colspan="4" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{module.function.block.BLOCK_ID}','adminPrivate_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{module.function.block.L_TITLE}</span></td>
															</tr>
															<tr>
																<td width="40%" class="row3" align="center" height="25" nowrap="nowrap"><b>{L_GROUPS}</b></td>
																<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_VIEW}</b></td>
																<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_EDIT}</b></td>
																<td width="20%" class="row3" align="center" nowrap="nowrap"><b>{L_IS_MODERATOR}</b></td>
															</tr>
															<tr>
																<td class="row1" align="center" colspan="4">
																	<div style="overflow:auto; overflow-y:scroll; height:150px;">
																	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																		<!-- BEGIN grouprows -->
																			{module.function.block.grouprows.GROUP_ROWS}
																		<!-- END grouprows -->
																	</table>
																	</div>
																</td>
															</tr>
															<tr>
																<td class="catBottom" height="25" align="center" colspan="4">{module.function.block.S_HIDDEN_PRIVATE_FIELDS}<input type="submit" name="submit" value="{module.function.block.S_SUBMIT}" class="mainoption" /></td>
															</tr>
														</table>
														</form>
														<hr>
														</div>
													</td>
												</tr>
												<!-- Block PRIVATE Auth -->


												<!-- END block -->
												</table>
											</td>
										</tr>

									<!-- END function -->
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
	<!-- END module -->
</table>
</div>