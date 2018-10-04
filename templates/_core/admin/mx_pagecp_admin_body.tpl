<script type="text/javascript">
function menuCat(id, mode, visible)
{
	this.cat_id = id;
	this.menu_mode = mode;
	this.status = visible != '' ? visible : 'none';
}
var menuCats = new Array();

menuCats['adminPage_Template'] = new menuCat('Template', 'adminPage_', '{VISIBLE}');

<!-- BEGIN templates -->
menuCats['adminTemplateEdit_{templates.TEMPLATE_ID}'] = new menuCat('{templates.TEMPLATE_ID}', 'adminTemplateEdit_', '{templates.VISIBLE}');
menuCats['adminTemplateDelete_{templates.TEMPLATE_ID}'] = new menuCat('{templates.TEMPLATE_ID}', 'adminTemplateDelete_', '{templates.VISIBLE_DELETE}');

<!-- BEGIN columnrow -->
menuCats['adminTemplateColumnEdit_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}'] = new menuCat('{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}', 'adminTemplateColumnEdit_', '{templates.columnrow.VISIBLE}');
menuCats['adminTemplateColumnDelete_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}'] = new menuCat('{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}', 'adminTemplateColumnDelete_', '{templates.columnrow.VISIBLE_DELETE}');
<!-- END columnrow -->
<!-- END templates -->

<!-- BEGIN pages -->
menuCats['adminPage_{pages.PAGE_ID}'] = new menuCat('{pages.PAGE_ID}', 'adminPage_', '{pages.VISIBLE}');
menuCats['adminPageDelete_{pages.PAGE_ID}'] = new menuCat('{pages.PAGE_ID}', 'adminPageDelete_', '{pages.VISIBLE_DELETE}');
menuCats['adminPageEdit_{pages.PAGE_ID}'] = new menuCat('{pages.PAGE_ID}', 'adminPageEdit_', '{pages.VISIBLE_EDIT}');
menuCats['adminPageSettings_{pages.PAGE_ID}'] = new menuCat('{pages.PAGE_ID}', 'adminPageSettings_', '{pages.VISIBLE_SETTINGS}');
menuCats['adminPagePrivate_{pages.PAGE_ID}'] = new menuCat('{pages.PAGE_ID}', 'adminPagePrivate_', '{pages.VISIBLE_PRIVATE}');

<!-- BEGIN columnrow -->
menuCats['adminColumnEdit_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}'] = new menuCat('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}', 'adminColumnEdit_', '{pages.columnrow.VISIBLE}');
menuCats['adminColumnDelete_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}'] = new menuCat('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}', 'adminColumnDelete_', '{pages.columnrow.VISIBLE_DELETE}');
<!-- END columnrow -->
<!-- END pages -->

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

	parentPageMode = 'adminPage_';
	parentEditMode = 'adminPageEdit_';
	parentPrivateMode = 'adminPagePrivate_';
	parentDeleteMode = 'adminPageDelete_';
	parentSettingsMode = 'adminPageSettings_';
	parentTemplateMode = 'adminTemplateEdit_';

	parentPageCat = parentPageMode + cat_id;
	parentEditCat = parentEditMode + cat_id;
	parentPrivateCat = parentPrivateMode + cat_id;
	parentDeleteCat = parentDeleteMode + cat_id;
	parentSettingsCat = parentSettingsMode + cat_id;
	parentTemplateCat = parentTemplateMode + cat_id;

	currentCat = type + cat_id;

	currentStatus = menuCats[currentCat].status;

	queuedSteps = new Array();
	cookieArray = new Array();

	currentStep = 0;

	for( var forCat in menuCats )
	{
		if( (init == 'true' && (menuCats[forCat].status == 'block') && menuCats[forCat].menu_mode == parentPageMode) ||
			(init != 'true' &&
				( 	(currentCat == parentPageCat && menuCats[forCat].status == 'block' ) ||

					(currentCat == parentEditCat && menuCats[forCat].menu_mode != parentPageMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentPrivateCat && menuCats[forCat].menu_mode != parentPageMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentSettingsCat && menuCats[forCat].menu_mode != parentPageMode && menuCats[forCat].status == 'block') ||
					(currentCat == parentDeleteCat && menuCats[forCat].menu_mode != parentPageMode && menuCats[forCat].status == 'block') ||

					(currentCat == parentTemplateCat && menuCats[forCat].menu_mode != parentPageMode && menuCats[forCat].status == 'block') ||

					(currentCat != parentPageCat && forCat == currentCat && currentStatus == 'block')  )))
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
		if (menuCats[parentPageCat] && menuCats[forCat].menu_mode == parentPageMode)
		{
			alert(parentPageCat);
			if (menuCats[parentPageCat].status == 'none')
			{
				queuedSteps[currentStep++] = new queueStep(parentPageCat, 'block');
				menuCats[parentPageCat].status = 'block';

				forCatimage = menuCats[parentPageCat].menu_mode+'image_'+menuCats[parentPageCat].cat_id;
				if( document.images && document.images[forCatimage] )
				{
					document.images[forCatimage].src = '{IMG_URL_CONTRACT}';
				}
			}
		}

		queuedSteps[currentStep++] = new queueStep(currentCat, 'block');
		menuCats[currentCat].status = 'block';

		if (currentCat == parentPageCat)
		{
			var	expdate = new Date();		// 72 Hours from now
			expdate.setTime(expdate.getTime() + (72 * 60 * 60 * 1000));
			//setCookie('{COOKIE_NAME}_'+type+'page_id', cat_id, expdate,
			//	('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
			//	('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
			//	('{COOKIE_SECURE}' == '0') ? false : true);
		}

		if( document.images && document.images[imageSCR] )
		{
			document.images[imageSCR].src = '{IMG_URL_CONTRACT}';
		}
	}
	else
	{
		//delCookie('{COOKIE_NAME}_'+type+'page_id',
		//		('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
		//		('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}');
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

	setCookie('{COOKIE_NAME}_admincp_pagestates', strSubmitContent, expdate,
			('{COOKIE_PATH}'   == '') ? null : '{COOKIE_PATH}',
			('{COOKIE_DOMAIN}' == '') ? null : '{COOKIE_DOMAIN}',
			('{COOKIE_SECURE}' == '0') ? false : true);

	currentStep = 0;
	setTimeout("execQueue();", execInterval);
}

function doOnLoadMenuACP()
{
	var cat_id;

	if ( menuCats['adminPage_Template'].status == 'block' )
	{
			menuCats['adminPage_Template'].status = 'none';
			onMenuCatClick('Template', 'adminPage_', 'true');
	}
	else if( getObj('adminPage_' + '{NAV_PAGE_ID}') )
	{
		if ( '{NAV_PAGE_ID}' > 0 )
		{
			cat_id = '{NAV_PAGE_ID}';
		}
		else
		{
			cat_id = getCookie('{COOKIE_NAME}_adminPage_page_id');
		}

		if( menuCats['adminPage_'+cat_id] )
		{
			menuCats['adminPage_'+cat_id].status = 'none';
			onMenuCatClick(cat_id, 'adminPage_', 'true');
		}
	}

	if( oldOnLoadMenuACP )
	{
		oldOnLoadMenuACP();
	}
}

function checkForm() {
   	formErrors = '';
	var is_selected = false;

   	if (document.forms['DYNAMIC_LIST'].function_id.selectedIndex < 0) {
      	formErrors += "Select a function\r\n";
   	}
   	if (document.forms['DYNAMIC_LIST'].block_id.selectedIndex < 0) {
      	formErrors += "Select a block\r\n";
   	}
   	if (document.forms['DYNAMIC_LIST'].id.checked)
   	{
   		is_selected = true;
   	}
   	else
   	{
	   	for (i=0, n=document.forms['DYNAMIC_LIST'].id.length; i<n; i++) {
			if (document.forms['DYNAMIC_LIST'].id[i].checked || document.forms['DYNAMIC_LIST'].id.checked) {
			is_selected = true;
			continue;
			}
		}
   	}
   	if (!is_selected) {
      	formErrors += "Select a page column\r\n";
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

// -->
</script>

<!-- BEGIN pages -->
<!-- BEGIN has_columns -->
<!-- dynamic_select -->
<script type="text/javascript" src="../modules/mx_shared/lib/DynamicOptionList_comp.js"></script>
<script type="text/javascript" id="DYNAMIC_LIST">
var makeModule = new DynamicOptionList("module_id","function_id","block_id");
{DYNAMIC_FUNCTION_SETUP}
{DYNAMIC_BLOCK_SETUP}
{DYNAMIC_DEFAULT_SETUP}
</script>
<!-- dynamic_select -->
<!-- END has_columns -->
<!-- END pages -->

<script type="text/javascript">
function doOnLoadFunctions()
{
	doOnLoadMenuACP();
	<!-- BEGIN pages -->
	<!-- BEGIN is_page -->
	initDynamicOptionLists();
	<!-- END is_page -->
	<!-- END pages -->
}
window.onload = doOnLoadFunctions;
</script>
<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<form method="post" name="jumpbox" action="{S_ACTION}">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" >
					<tr>
						<td nowrap="nowrap" align="right">
							<span class="gensmall"><b>{L_QUICK_NAV}</b>&nbsp;
							<select name="page_id" class="forminput">{PAGE_SELECT_BOX}</select>
							<input type="submit" value="{S_SUBMIT}" class="liteoption" />
							</span>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
		<td align="center" colspan="3">{RESULT_MESSAGE}</td>
	</tr>
	<tr>
		<!-- BEGIN pages -->
		<!-- BEGIN is_new -->
		<th width="33%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPage_');">
		&nbsp;<img name="adminPage_image_{pages.PAGE_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp; {L_TITLE_NEW_PAGE}
		</th>
		<!-- END is_new -->

		<!-- BEGIN is_current -->
		<th width="33%" class="thHead" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPage_');">
		&nbsp;<img name="adminPage_image_{pages.PAGE_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp; {L_PAGE_TITLE} - {pages.PAGE_TITLE}
		</th>
		<!-- END is_current -->
		<!-- END pages -->

		<th width="33%" class="thHead" align="left" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('Template','adminPage_');">
		&nbsp;<img name="adminPage_image_Template" src="{IMG_URL}" border="0" align="absmiddle">&nbsp;{L_TITLE_TEMPLATE}
		</th>
 	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline" align="center">
	<tr>
 		<td class="row1">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td class="row1">
			 			<div id="adminPage_Template" style="display:{VISIBLE};" class="genmed">
			 			<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
							<tr>
								<td>
									<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
										<!-- BEGIN notemplates -->
										<tr>
											<td class="row1"><span class="gensmall">{nopages.NONE}</span></td>
										</tr>
										<!-- END notemplates -->

										<!-- BEGIN templates -->
									 	<tr>
									 		<td class="row1">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<!-- BEGIN new_template -->
														<td width="80%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{templates.TEMPLATE_ID}','adminTemplateEdit_');">&nbsp;<img name="adminTemplateEdit_image_{templates.TEMPLATE_ID}" src="{templates.IMG_URL}" border="0" align="absmiddle">&nbsp;{templates.TEMPLATE_ICON} <span class="cattitle">{templates.TEMPLATE_TITLE}</span></td>
														<!-- END new_template -->
														<!-- BEGIN current_template -->
														<td width="80%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{templates.TEMPLATE_ID}','adminTemplateEdit_');">&nbsp;<img name="adminTemplateEdit_image_{templates.TEMPLATE_ID}" src="{templates.IMG_URL}" border="0" align="absmiddle">&nbsp;{templates.TEMPLATE_ICON} <span class="cattitle">{templates.TEMPLATE_TITLE}</span></td>
														<!-- END current_template -->
														<td width="20%" class="catRight" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{templates.TEMPLATE_ID}','adminTemplateDelete_');">
															<!-- BEGIN delete -->
															<img name="adminTemplateDelete_image_{templates.TEMPLATE_ID}" src="{templates.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="gen">{L_DELETE}</span>
															<!-- END delete -->
														</td>
													</tr>

													<!-- Function Delete -->
													<tr>
														<td colspan="2" class="row1">
															<div id="adminTemplateDelete_{templates.TEMPLATE_ID}" style="display:{templates.VISIBLE_DELETE};" class="genmed">
														  	<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center" class="forumline">
																<tr>
															  		<td width="50%" align="center" colspan="2">{templates.MESSAGE_DELETE}</td>
																</tr>
														  	</table>
															</div>
														</td>
													</tr>
													<!-- Function Delete -->
													<tr>
														<td colspan="2" class="row1">
															<div id="adminTemplateEdit_{templates.TEMPLATE_ID}" style="display:{templates.VISIBLE};" class="genmed">

															<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">



																<!-- Template Edit -->
																<tr>
																	<td class="row1">
																		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																			<tr>
																				<td bgcolor="#006699" width="10"></td>
																				<td>

																					<form action="{S_ACTION}" method="post">
																					<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																						<tr>
																						  	<td width="50%" align="right" >{templates.L_TEMPLATE_NAME}</td>
																						  	<td><input type="text" size="45" name="template_name" value="{templates.E_TEMPLATE_TITLE}" class="post" /></td>
																						</tr>
																						<tr>
																						  	<td class="row2" colspan="2" align="center">{templates.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{templates.S_SUBMIT}" class="mainoption" /></td>
																						</tr>
																					</table>
																					</form>

																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<!-- Template Edit -->

																<!-- Template Main Panel -->
																<tr>
																	<td class="row1">

																		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																			<tr>
																				<td bgcolor="#006699" width="10"></td>
																				<td>

																					<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																						<tr>
																							<td class="row3">
																								<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">

																									<!-- BEGIN columnrow -->
																									<tr>
																										<td class="row3" width="100%" colspan="5">
																											<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center" class="forumline">
																												<tr>
																													<td width="70%" class="row3" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}','adminTemplateColumnEdit_');">&nbsp;<img name="adminTemplateColumnEdit_image_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}" src="{templates.columnrow.IMG_URL}" border="0" align="absmiddle">&nbsp;<img src="{IMG_ICON_PAGE_COLUMN}" border="0" align="absmiddle">&nbsp;<span class="topictitle"><b>{templates.columnrow.L_COLUMN}: <span class="cattitle">{templates.columnrow.COLUMN_TITLE}</span></b></span></td>
																													<td width="15%" class="row3" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}','adminTemplateColumnDelete_');">&nbsp;<img name="adminTemplateColumnDelete_image_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}" src="{templates.columnrow.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="gen">{templates.columnrow.L_DELETE}</span></td>
																													<td width="15%" class="row3" align="center" valign="middle" nowrap="nowrap"><span class="genmed"><a href="{templates.columnrow.U_COLUMN_MOVE_UP}">{templates.columnrow.L_MOVE_UP}</a> <a href="{templates.columnrow.U_COLUMN_MOVE_DOWN}">{templates.columnrow.L_MOVE_DOWN}</a></span></td>
																												</tr>

																												<!-- Function Delete -->
																												<tr>
																													<td colspan="3" class="row1">
																														<div id="adminTemplateColumnDelete_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}" style="display:{templates.columnrow.VISIBLE_DELETE};" class="genmed">
																													  	<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center" class="forumline">
																															<tr>
																														  		<td width="50%" align="center" colspan="2">{templates.columnrow.MESSAGE_DELETE}</td>
																															</tr>
																													  	</table>
																														</div>
																													</td>
																												</tr>
																												<!-- Function Delete -->

																												<!-- COLUMN EDIT -->
																												<tr>
																													<td colspan="3" class="row1">
																														<div id="adminTemplateColumnEdit_{templates.TEMPLATE_ID}_{templates.columnrow.COLUMN_ID}" style="display:{templates.columnrow.VISIBLE};" class="genmed">
																														<form action="{S_ACTION}" method="post">
																													  	<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																															<tr>
																															  <td width="50%" align="right">{templates.columnrow.L_COLUMN_NAME}</td>
																															  <td ><input type="text" size="25" name="column_title" value="{templates.columnrow.E_COLUMN_TITLE}" /></td>
																															</tr>
																															<tr>
																																<td width="50%" align="right">{templates.columnrow.L_COLUMN_SIZE}</td>
																																<td ><input type="text" maxlength="5" size="5" name="column_size" value="{templates.columnrow.E_COLUMN_SIZE}" /></td>
																															</tr>
																															<tr>
																															  <td class="row2" colspan="2" align="center">{templates.columnrow.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{templates.columnrow.S_SUBMIT}" class="mainoption" /></td>
																															</tr>
																														</table>
																														</form>
																														</div>
																													</td>
																												</tr>
																												<!-- COLUMN EDIT -->

																											</table>
																										</td>
																									</tr>

																									<tr>
																										<td colspan="5" height="1" class="spaceRow"><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}spacer.gif" alt="" width="1" height="1" /></td>
																									</tr>
																									<!-- END columnrow -->
																								</table>
																							</td>
																						</tr>
																					</table>

																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<!-- Template Main Panel -->


															</table>
															</div>
														</td>
													</tr>
												</table>


											</td>
										</tr>
									  	<!-- END templates -->
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

	<!-- BEGIN nopages -->
	<tr>
		<td class="row1"><span class="gensmall">{nopages.NONE}</span></td>
	</tr>
	<!-- END nopages -->

	<!-- BEGIN pages -->
 	<tr>
 		<td class="row1">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td colspan="6" class="row1">
						<div id="adminPage_{pages.PAGE_ID}" style="display:{pages.VISIBLE};" class="genmed">
						<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
							<tr>
								<td>
									<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<!-- BEGIN is_current -->
											<td width="50%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPage_');">&nbsp;<img  src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;{pages.PAGE_ICON} <span class="cattitle">{pages.PAGE_TITLE}</span> <span class="gensmall">{pages.PAGE_DESC}</span></td>
											<!-- END is_current -->
											<!-- BEGIN is_new -->
											<td width="50%" class="catLeft" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPage_');">&nbsp;<img  src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;{pages.PAGE_ICON} <span class="topictitle">{pages.PAGE_TITLE}</span> <span class="gensmall">{pages.PAGE_DESC}</span></td>
											<!-- END is_new -->
											<!-- BEGIN reload -->
											<td width="50%" class="catLeft" style="cursor:pointer;cursor:hand;">&nbsp;<img name="adminPage_image_{pages.PAGE_ID}" src="{IMG_URL_EXPAND}" border="0" align="absmiddle">&nbsp;{pages.PAGE_ICON} <a href="{pages.reload.U_PAGE_EDIT}"><span class="cattitle">{pages.PAGE_TITLE}</span></a> <span class="gensmall">{pages.PAGE_DESC}</span></td>
											<!-- END reload -->
											<td width="10%" class="cat" align="center">
												<!-- BEGIN is_page -->
												&nbsp;&nbsp;&nbsp;&nbsp;<span class="genmed"><a href="{pages.U_PREVIEW}" target="_blank">{L_PREVIEW}</a></span>
												<!-- END is_page -->
											</td>
											<td width="10%" class="cat" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPageEdit_');">
												<!-- BEGIN is_page -->
												&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminPageEdit_image_{pages.PAGE_ID}" src="{pages.IMG_URL_EDIT}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_EDIT}</span>
												<!-- END is_page -->
											</td>
											<td width="10%" class="cat" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPageSettings_');">
												<!-- BEGIN is_page -->
												&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminPageSettings_image_{pages.PAGE_ID}" src="{pages.IMG_URL_SETTINGS}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_SETTING}</span>
												<!-- END is_page -->
											</td>
											<td width="10%" class="cat" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPagePrivate_');">
												<!-- BEGIN is_page -->
												&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminPagePrivate_image_{pages.PAGE_ID}" src="{pages.IMG_URL_PRIVATE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_PERMISSIONS}</span>
												<!-- END is_page -->
											</td>
											<td width="10%" class="catRight" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPageDelete_');">
												<!-- BEGIN is_page -->
												&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminPageDelete_image_{pages.PAGE_ID}" src="{pages.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_DELETE}</span>
												<!-- END is_page -->
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<!-- Function Delete -->
							<tr>
								<td class="row1">
									<div id="adminPageDelete_{pages.PAGE_ID}" style="display:{pages.VISIBLE_DELETE};" class="genmed">
							  		<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
										<tr>
									  		<td width="50%" align="center" colspan="2">{pages.MESSAGE_DELETE}</td>
										</tr>
									</table>
									</div>
								</td>
							</tr>
							<!-- Function Delete -->

							<tr>
								<td>


									<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
										<!-- BEGIN is_page -->
										<!--
										<tr>
										  	<td class="cat" colspan="2" align="left" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPageEdit_');">&nbsp;&nbsp;<img name="adminPageEdit_image_{pages.PAGE_ID}" src="{pages.IMG_URL_EDIT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{pages.L_TITLE_EDIT}</span></td>
										</tr>
										-->
										<!-- END is_page -->

										<tr>
											<td class="row1">
												<!-- BEGIN is_page -->
												<div id="adminPageEdit_{pages.PAGE_ID}" style="display:{pages.VISIBLE_EDIT};" class="genmed">
												<!-- END is_page -->

												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td class="row3" width="5"></td>
														<td>

															<form action="{S_ACTION}" method="post">
															<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_TITLE}</td>
																  	<td><input type="text" size="45" name="page_name" value="{pages.E_PAGE_TITLE}" class="post" /></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_DESC}</td>
																  	<td><input type="text" size="45" name="page_desc" value="{pages.E_PAGE_DESC}" class="post" /></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_PARENT}</td>
																  	<td><select name="page_parent" class="forminput">{pages.E_PAGE_PARENT}" class="post" /></select></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_HEADER}</td>
																  	<td><input type="text" size="45" name="page_header" value="{pages.E_PAGE_HEADER}" class="post" /></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_FOOTER}</td>
																  	<td><input type="text" size="45" name="page_footer" value="{pages.E_PAGE_FOOTER}" class="post" /></td>
																</tr>
																<tr>
																	<td width="50%" align="right" >{L_DEFAULT_STYLE}</td>
																	<td>{pages.STYLE_SELECT}</td>
																</tr>
																<tr>
																	<td width="50%" align="right" >{L_OVERRIDE_STYLE}<br /><span class="gensmall">{L_OVERRIDE_STYLE_EXPLAIN}</span></td>
																	<td><input type="radio" name="mx_override_user_style" value="-1" {pages.OVERRIDE_STYLE_DEFAULT} /> {L_DEFAULT}&nbsp;&nbsp;<input type="radio" name="mx_override_user_style" value="1" {pages.OVERRIDE_STYLE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="mx_override_user_style" value="0" {pages.OVERRIDE_STYLE_NO} /> {L_NO}</td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_MAIN_LAYOUT}</td>
																  	<td><input type="text" size="45" name="page_main_layout" value="{pages.E_PAGE_MAIN_LAYOUT}" class="post" /></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_NAVIGATION_BLOCK}<br /><span class="gensmall">{L_NAVIGATION_BLOCK_EXPLAIN}</span></td>
																  	<td>{pages.E_NAVIGATION_BLOCK}</td>
																</tr>
																<tr>
																	<td width="50%" align="right">{L_PHPBB_STATS}<br /><span class="gensmall">{L_PHPBB_STATS_EXPLAIN}</span></td>
																	<td><input type="radio" name="phpbb_stats" value="-1" {pages.S_PHPBB_STATS_DEFAULT} /> {L_DEFAULT}&nbsp;&nbsp;<input type="radio" name="phpbb_stats" value="1" {pages.S_PHPBB_STATS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="phpbb_stats" value="0" {pages.S_PHPBB_STATS_NO} /> {L_NO}</td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_IP_FILTER}<br /><span class="gensmall">{L_IP_FILTER_EXPLAIN}</span></td>
																  	<td><textarea rows="5" cols="50" wrap="virtual" name="ip_filter" class="post" />{pages.IP_FILTER}</textarea></td>
																</tr>
																<!-- BEGIN template -->
															   	<tr>
															   	  	<td width="50%" align="right" >{pages.L_CHOOSE_PAGE_TEMPLATE}</td>
															   		<td>{pages.S_TEMPLATE_LIST}</td>
															    </tr>
															    <!-- END template -->
																<tr>
																  	<td width="50%" align="right" >{L_AUTH_TITLE}</td>
															  	  	<td>
																      <table width="100%" cellspacing="1" cellpadding="4" border="0" class="forumline">
																    	<tr>
																    	  <!-- BEGIN page_auth_titles -->
																    	  <th class="thTop">{pages.page_auth_titles.CELL_TITLE}</th>
																    	  <!-- END page_auth_titles -->
																    	</tr>
																		<!-- BEGIN page_auth_data -->
																    	<tr>
																    	  <td class="row1" align="center">{pages.page_auth_data.S_AUTH_LEVELS_SELECT}</td>
																    	</tr>
																   	    <!-- END page_auth_data -->
																      </table>
															  	 	</td>
																</tr>
																<tr>
																  	<td width="100%" align="center" colspan="2"><hr></td>
																</tr>
																<tr>
																  	<td width="50%" align="right" valign="top">{L_PAGE_ICON}</td>
																  	<td>{pages.S_PAGE_ICON}</td>
																</tr>
																<tr>
																  	<td width="50%" align="right" >{L_PAGE_ALT_ICON}</td>
																  	<td><input type="text" size="65" name="page_alt_icon" value="{pages.S_PAGE_ALT_ICON}" class="post" /></td>
																</tr>
																<tr>
																  	<td class="row2" colspan="2" align="center">{pages.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{pages.S_SUBMIT}" class="mainoption" /></td>
																</tr>
															</table>
															</form>

														</td>
													</tr>
												</table>
												<!-- BEGIN is_page -->
												</div>
												<!-- END is_page -->
											</td>
										</tr>
										<!-- Page Edit -->


										<!-- Page Private Auth -->
										<!-- BEGIN is_page -->
										<!--
										<tr>
										  	<td class="cat" colspan="2" align="left" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPagePrivate_');">&nbsp;&nbsp;<img name="adminPagePrivate_image_{pages.PAGE_ID}" src="{pages.IMG_URL_PRIVATE}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{pages.L_TITLE_PRIVATE}</span></td>
										</tr>
										-->
										<!-- END is_page -->
										<tr>
											<td class="row1">
												<div id="adminPagePrivate_{pages.PAGE_ID}" style="display:{pages.VISIBLE_PRIVATE};" class="genmed">

												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td class="row3" width="5"></td>
														<td>

															<form action="{S_ACTION}" method="post">
															<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																<tr>
															  	  	<td>
																      	<table width="100%" cellspacing="0" cellpadding="0" border="0">
																			<tr>
																				<td width="50%" class="row3" align="center" height="20" nowrap="nowrap"><b>{L_GROUPS}</b></td>
																				<td width="25%" class="row3" align="center" nowrap="nowrap"><b>{L_VIEW}</b></td>
																				<td width="25%" class="row3" align="center" nowrap="nowrap"><b>{L_IS_MODERATOR}</b></td>
																			</tr>
																			<tr>
																				<td class="row1" align="center" colspan="3">
																					<div style="overflow:auto; overflow-y:scroll; height:200px;">
																					<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																						<!-- BEGIN grouprow -->
																						<tr>
																							<td width="50%" class="{pages.grouprow.ROW_COLOR}" align="center"><span class="gen">{pages.grouprow.GROUP_NAME}</span></td>
																							<td width="25%" class="{pages.grouprow.ROW_COLOR}" align="center">
																								{pages.grouprow.VIEW_INPUT}
																							</td>
																							<td width="25%" class="{pages.grouprow.ROW_COLOR}" align="center">
																							<input name="moderator[]" type="checkbox" {pages.grouprow.MODERATOR_CHECKED} value="{pages.grouprow.GROUP_ID}" />
																							</td>
																						</tr>
																						<!-- END grouprow -->
																					</table>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>

																<tr>
																  	<td class="row2" colspan="2" align="center">{pages.S_HIDDEN_PRIVATE_FIELDS}<input type="submit" name="submit" value="{pages.S_SUBMIT}" class="mainoption" /></td>
																</tr>
															</table>
															</form>

														</td>
													</tr>
												</table>
												</div>
											</td>
										</tr>
										<!-- Page Edit -->




										<!-- Page Main Panel - Settings -->
										<!-- BEGIN is_page -->
										<!--
										<tr>
										  	<td class="cat" colspan="2" align="left" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}','adminPageSettings_');">&nbsp;&nbsp;<img name="adminPageSettings_image_{pages.PAGE_ID}" src="{pages.IMG_URL_SETTINGS}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{pages.L_TITLE_SETTINGS}</span></td>
										</tr>
										-->
										<!-- END is_page -->

										<tr>
											<td class="row1">
												<div id="adminPageSettings_{pages.PAGE_ID}" style="display:{pages.VISIBLE_SETTINGS};" class="genmed">

												<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td class="row3" width="5"></td>
														<td>


															<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
																<tr>
																	<td class="row3" width="5">&nbsp;</td>
																	<td>
																		<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">

																			<tr>
																				<td colspan="7" class="row2">

																				<!-- BEGIN has_columns -->
																				<!-- dynamic_select -->
																				<form name="DYNAMIC_LIST" method="post" action="{S_ACTION}" onsubmit="return checkForm(this)">
																				<table width="100%" cellpadding="2" cellspacing="0" border="0">
																				<tr>
																					<td width="10%" class="topictitle" colspan="2">{L_MODULE}:</td>
																					<td width="10%" class="topictitle" colspan="2">{L_FUNCTION}:</td>
																					<td width="10%" class="topictitle" colspan="2">{L_BLOCK}:</td>
																					<td width="70%" class="topictitle" >{L_COLUMN}:</td>
																				</tr>
																				<tr>
																					<td valign="top">
																						<select name="module_id" MULTIPLE size=5>
																							{DYNAMIC_MODULE_SELECT}
																						</select>
																					</td>
																					<td>&raquo;</td>
																					<td valign="top">
																						<select name="function_id" MULTIPLE size=5>
																							<script LANGUAGE="JavaScript">makeModule.printOptions("function_id")</script>
																						</select>
																					</td>
																					<td>&raquo;</td>
																					<td valign="top">
																						<select name="block_id" MULTIPLE size=5>
																							<script LANGUAGE="JavaScript">makeModule.printOptions("block_id")</script>
																						</select>
																					</td>
																					<td>&raquo;</td>
																					<td valign="middle">
																						{RADIO_COLUMN_LIST}
																					</td>
																				</tr>
																				<tr>
																					<td colspan="7" align="center">
																						<input type="button" value="{L_RESET}" onClick="this.form.reset(); resetDynamicOptionLists(this.form);" class="liteoption">
																						<input type="submit" value="{L_CREATE_BLOCK} &raquo; {L_COLUMN}" class="liteoption" />
																						{S_HIDDEN_DYN_FIELDS}
																					</td>
																				</tr>
																				</table>
																				</form>
																				<!-- dynamic_select -->
																				<!-- END has_columns -->

																				</td>
																			</tr>

																			<!-- BEGIN columnrow -->
																			<tr>
																				<td class="row3" width="100%" colspan="5">
																					<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center" class="forumline">
																						<tr>
																							<td width="50%" class="row3" colspan="2" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}','adminColumnEdit_');">
																								<img src="{IMG_ICON_PAGE_COLUMN}" border="0" align="absmiddle">&nbsp;<span class="topictitle"><b>{pages.columnrow.L_COLUMN}: <span class="cattitle">{pages.columnrow.COLUMN_TITLE}</span></b></span>
																							</td>
																							<td width="10%" class="row3" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}','adminColumnEdit_');">
																							<!-- BEGIN is_columnrow -->
																								&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminColumnEdit_image_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}" src="{pages.columnrow.IMG_URL_EDIT}" border="0" align="absmiddle">&nbsp;<span class="genmed">{L_EDIT}</span>
																							<!-- END is_columnrow -->
																							</td>
																							<td width="10%" class="row3" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}','adminColumnDelete_');">
																							<!-- BEGIN is_columnrow -->
																								&nbsp;&nbsp;&nbsp;&nbsp;<img name="adminColumnDelete_image_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}" src="{pages.columnrow.IMG_URL_DELETE}" border="0" align="absmiddle">&nbsp;<span class="genmed">{pages.columnrow.L_DELETE}</span>
																							<!-- END is_columnrow -->
																							</td>
																							<td width="10%" class="row3" align="center" valign="middle" nowrap="nowrap">
																							<!-- BEGIN is_columnrow -->
																								<span class="genmed"><a href="{pages.columnrow.U_COLUMN_MOVE_UP}">{pages.columnrow.L_MOVE_UP}</a> <a href="{pages.columnrow.U_COLUMN_MOVE_DOWN}">{pages.columnrow.L_MOVE_DOWN}</a></span>
																							<!-- END is_columnrow -->
																							</td>
																						</tr>

																						<!-- Function Delete -->
																						<tr>
																							<td colspan="5" class="row1">
																								<div id="adminColumnDelete_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}" style="display:{pages.columnrow.VISIBLE_DELETE};" class="genmed">
																						  		<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																									<tr>
																								  		<td width="50%" align="center" colspan="2">{pages.columnrow.MESSAGE_DELETE}</td>
																									</tr>
																								</table>
																								</div>
																							</td>
																						</tr>
																						<!-- Function Delete -->

																						<!-- COLUMN EDIT -->
																						<tr>
																							<td colspan="5" class="row1">
																								<div id="adminColumnEdit_{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}" style="display:{pages.columnrow.VISIBLE};" class="genmed">
																							  	<form action="{S_ACTION}" method="post">
																								<table width="100%" cellpadding="1" cellspacing="2" border="0" align="center">
																									<tr>
																									  	<td class="row2" colspan="2" align="center" style="cursor:pointer;cursor:hand;" onclick="onMenuCatClick('{pages.PAGE_ID}_{pages.columnrow.COLUMN_ID}','adminColumnEdit_');"><img src="{IMG_URL_CONTRACT}" border="0" align="absmiddle">&nbsp;<span class="topictitle">{pages.columnrow.L_TITLE}</span></td>
																									</tr>
																									<tr>
																									  <td width="50%" align="right">{pages.columnrow.L_COLUMN}</td>
																									  <td ><input type="text" size="25" name="column_title" value="{pages.columnrow.E_COLUMN_TITLE}" /></td>
																									</tr>
																									<tr>
																										<td width="50%" align="right">{pages.columnrow.L_COLUMN_SIZE}</td>
																										<td ><input type="text" maxlength="5" size="5" name="column_size" value="{pages.columnrow.E_COLUMN_SIZE}" /></td>
																									</tr>
																									<tr>
																									  <td class="row2" colspan="2" align="center">{pages.columnrow.S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{pages.columnrow.S_SUBMIT}" class="mainoption" /></td>
																									</tr>
																								</table>
																								</form>
																								</div>
																							</td>
																						</tr>
																						<!-- COLUMN EDIT -->

																					</table>
																				</td>
																			</tr>

																			<!-- BEGIN blockrow -->
																			<tr>
																				<td class="row1" >&nbsp;&nbsp;<img src="{pages.columnrow.blockrow.IMG_ICON_BLOCK}" border="0" align="absmiddle">&nbsp;<span class="gen">{pages.columnrow.blockrow.BLOCK_TITLE}</span> <span class="gensmall"><i>{pages.columnrow.blockrow.BLOCK_LAST_EDITED}</i></span> <span class="gensmall">{pages.columnrow.blockrow.BLOCK_DESC}</span></td>
																				<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.columnrow.blockrow.U_BLOCK_SETTING}"><span class="gensmall">{pages.columnrow.blockrow.L_SETTING}</span></a>&nbsp;</span></td>
																				<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.columnrow.blockrow.U_BLOCK_DELETE}"><span class="gensmall">{pages.columnrow.blockrow.L_REMOVE}</span></a></span></td>
																				<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.columnrow.blockrow.U_BLOCK_MOVE_UP}"><span class="gensmall">{L_MOVE_UP}</span></a> <a href="{pages.columnrow.blockrow.U_BLOCK_MOVE_DOWN}"><span class="gensmall">{L_MOVE_DOWN}</span></a></span></td>
																				<td class="row1" align="center" valign="middle"><span class="gen"><a href="{pages.columnrow.blockrow.U_BLOCK_RESYNC}"><span class="gensmall">{L_RESYNC}</span></a></span></td>
																			</tr>
																			<!-- END blockrow -->
																			<!-- BEGIN add_block -->
																			<!--
																			<tr>
																				<td colspan="5" class="row2"><form method="post" action="{S_ACTION}">{pages.columnrow.add_block.LIST_BLOCK} {pages.columnrow.add_block.S_HIDDEN_FIELDS}<input type="submit" class="liteoption"  name="submit" value="{pages.columnrow.add_block.S_SUBMIT}" /></form></td>
																			</tr>
																			-->
																			<tr>
																				<td class="row2" width="25%"><form method="post" action="{S_ACTION}"><input type="hidden" name="action_type" value="split" />{pages.columnrow.add_block.S_HIDDEN_FIELDS}<input type="submit" class="liteoption"  name="submit" value="{pages.columnrow.add_block.S_SUBMIT_SPLIT}" /></form></td>
																				<td class="row2" width="25%"><form method="post" action="{S_ACTION}"><input type="hidden" name="action_type" value="dynamic" />{pages.columnrow.add_block.S_HIDDEN_FIELDS}<input type="submit" class="liteoption"  name="submit" value="{pages.columnrow.add_block.S_SUBMIT_DYNAMIC}" /></form></td>
																				<td class="row2" width="25%"><form method="post" action="{S_ACTION}"><input type="hidden" name="action_type" value="virtual" />{pages.columnrow.add_block.S_HIDDEN_FIELDS}<input type="submit" class="liteoption"  name="submit" value="{pages.columnrow.add_block.S_SUBMIT_VIRTUAL}" /></form></td>
																				<td colspan="2" class="row2">&nbsp;</td>
																			</tr>
																			<tr>
																				<td class="row2" valign="top"><span class="gensmall">{pages.columnrow.add_block.S_SUBMIT_SPLIT_EXPLAIN}</span></td>
																				<td class="row2" valign="top"><span class="gensmall">{pages.columnrow.add_block.S_SUBMIT_DYNAMIC_EXPLAIN}</span></td>
																				<td class="row2" valign="top"><span class="gensmall">{pages.columnrow.add_block.S_SUBMIT_VIRTUAL_EXPLAIN}</span></td>
																				<td colspan="2" class="row2">&nbsp;</td>
																			</tr>
																			<!-- END add_block -->
																			<tr>
																				<td colspan="5" height="1" class="spaceRow"><img src="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}spacer.gif" alt="" width="1" height="1" /></td>
																			</tr>
																			<!-- END columnrow -->
																		</table>
																	</td>
																</tr>
															</table>

														</td>
													</tr>
												</table>
												</div>
											</td>
										</tr>
										<!-- Page Main Panel -->


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
  	<!-- END pages -->
</table>

<br clear="all" />