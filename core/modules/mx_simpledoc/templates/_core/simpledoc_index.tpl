<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/common.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulMenu/XulMenu.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulMenu/ie5.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/DynamicTree.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulTabs/XulTabs.js"></script>
<!-- <script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/SimpleTextEditor/SimpleTextEditor.js"></script> -->
<script language="javascript" type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
   	tinyMCE.init({
	mode : "none",
	elements : "body",

						language : "{LANG}",
                        docs_language : "{LANG}",

                        apply_source_formatting : "true",
                        cleanup : "true",
                        inline_styles : "true",
                        convert_fonts_to_spans : "true",
                        fix_list_elements : "true",
                        fix_table_elements : "true",
                        force_p_newlines : "true",
                        remove_trailing_nbsp : "true",

                        plugins : "table,advimage,advlink,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",

                        theme : "advanced",
                        theme_advanced_blockformats : "p,h1,h2,h3,h4,h5,h6",

                        theme_advanced_fonts : "Verdana=verdana,arial,helvetica,sans-serif;Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace",

                        theme_advanced_buttons1_add_before : "newdocument,separator",
						theme_advanced_buttons1_add : "fontselect,fontsizeselect",

						theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor",
						theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",

						theme_advanced_buttons3_add_before : "tablecontrols,separator",
						theme_advanced_buttons3_add : "print,separator,ltr,rtl,separator,fullscreen",

						theme_advanced_disable : "",

						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",

						theme_advanced_path_location : "bottom",
						theme_advanced_statusbar_location : "bottom",

						content_css : "{TEMPLATE}",
						theme_advanced_styles : "Tiny Text=copyright;Small Text=gensmall;Normal Text=genmed;Big Text=gen;Code=code;Quote=quote",

						table_styles : "Layout=forumline",
						table_cell_styles : "Table cell 1=row1;Table cell 2=row2;Table cell 3=row3",
						table_row_styles : "Table row 1=oddrow",
						table_default_border : "0",

				      	document_base_url : "{PATH}index.php",
				      	relative_urls : "true",

				      	extended_valid_elements : "a[*],img[*],table[*],tr[*],td[*],div[*],form[*],input[*]"
	});
</script>

<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/management.js.php"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/request.js.php"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/debug.js"></script>

<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/ajax/AjaxRequest_comp.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/ajax/dhtmlHistory.js"></script>

<script type="text/javascript">
/* fix for IE not loading wysiwyg editor images */
/*
var imgs = ["bold.gif", "center.gif", "help.gif", "image.gif", "indent.gif", "italic.gif", "left.gif", "link.gif", "ol.gif", "outdent.gif", "right.gif", "ul.gif", "underline.gif", "viewsource.gif"];
for (var k = 0; k < imgs.length; ++k) {
    var image = new Image();
    image.src = "{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/SimpleTextEditor/images/"+imgs[k];
    imgs[k] = image;
}
*/
</script>

<script type="text/javascript">
function _mxBlock(id, page)
{
	this.block_id = id;
	this.page_id = page;
}
mxBlock = new _mxBlock('{BLOCK_ID}','{PAGE_ID}');
</script>



<style type="text/css">
<!--
/* SimpleDoc [www.gosu.pl], administration interface */
#menu { position: relative z-index: 10; }
#menu_top { height: 30px; padding: 15px 15px 0 15px; }

td.simpledoc_title { font-size: 13px; font-weight: bold; margin: 0; padding: 10px; margin-bottom: 0.6em; border: {T_TH_COLOR1} 1px solid; border-style: none none solid none; }
.nomargin { margin-bottom: 0; }
.hr { font-size: 0px; border-width: 1px; border-color: {T_TH_COLOR1}; border-style: solid none none none; margin-top: 2px; margin-bottom: 2px; }

#main { }
#left { padding: 15px 15px 15px 15px; border-right: 1px solid {T_TH_COLOR1}; vertical-align: top; }
#right { padding: 15px 15px 15px 15px; vertical-align: top; height: 100%; width: 100%;}
#tabs-loading, #tabs-saving { position: absolute; z-index: 10; display: none; opacity: 0.8; -moz-opacity: 0.8; filter: alpha(opacity=80); }

img { border: 0; }
ul { margin: 1em 0 1em 3em; padding: 0; }

#tabs-data,
#tabs-data table {
    font-family: {T_FONTFACE1};
    font-size: 11px;
    color: {T_BODY_TEXT};
    background: {T_TR_COLOR1};
    width: 100%;
}

.t0 { border: {T_TH_COLOR1} 1px solid; }
.t1 { background: {T_TR_COLOR2}; padding: 3px 8px; }
.t2 { background: {T_TR_COLOR2}: 3px 8px; }

#saved { color: {T_BODY_TEXT}; }

.error { color: red; }
.message { color: green; }
.note { font-weight: bold; }

.message-box { padding: 1em; background: {T_TD_COLOR2}; border: {T_TH_COLOR3} 1px solid; }

pre { background-color: {T_TR_COLOR2}; padding: 0.75em 1.5em; border: 1px solid {T_TH_COLOR1}; }
.contents { float: right; background-color: {T_TR_COLOR2}; padding: 0.75em; margin: 0 0 0.75em 0.75em; border: 1px solid {T_TH_COLOR1}; }
.contents ul { margin-left: 1.2em; margin-right: 0.75em; margin-bottom: 0; padding: 0; }

/* SimpleDoc [www.gosu.pl], style for DynamicTree */
.DynamicTree {
    font-family: {T_FONTFACE1};
    font-size: 11px;
    white-space: nowrap;
    cursor: default;
}
.DynamicTree .wrap1,
.DynamicTree .actions { -moz-user-select: none; }

.DynamicTree a,
.DynamicTree a:hover { color: {T_BODY_VLINK}; text-decoration: none; cursor: default; }

.DynamicTree .text { padding: 1px; cursor: pointer; }
.DynamicTree .text-active { color: {T_BODY_VLINK}; background: {T_TR_COLOR1};  padding: 1px; cursor: pointer; }

.DynamicTree div.folder img,
.DynamicTree div.doc img { border: 0; vertical-align: -30%; }
* html .DynamicTree .folder img,
* html .DynamicTree .doc img { vertical-align: -40%; }
.DynamicTree .section { background: url({MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/tree-branch.gif) repeat-y; display: none; }
.DynamicTree .last { background: none; }
.DynamicTree div.folder div.folder { margin-left: 18px; }
.DynamicTree div.doc div.doc, .DynamicTree div.folder div.doc { margin-left: 18px; }

.DynamicTree ul {}
.DynamicTree li.folder {}
.DynamicTree li.doc {}

.DynamicTree .actions {
    margin-top: 7px;
    margin-left: 0px;
    height: 20px;
    float:left;
}
.DynamicTree .actions_r {
    margin-top: 0px;
    margin-left: 0px;
    height: 20px;
    float:right;
}
.DynamicTree .tooltip {
    margin-top: 28px;
    margin-left: 0px;
    height: 5px;
}
.DynamicTree .moveUp,
.DynamicTree .moveDown,
.DynamicTree .moveLeft,
.DynamicTree .moveRight,
.DynamicTree .rename,
.DynamicTree .insert,
.DynamicTree .remove {
	margin-top: 4px;
    width: 20px;
    height: 20px;
    display: block;
    border: 1px solid {T_TH_COLOR1};
    cursor: default;
    float:left;
}
.DynamicTree .moveUp:hover,
.DynamicTree .moveDown:hover,
.DynamicTree .moveLeft:hover,
.DynamicTree .moveRight:hover,
.DynamicTree .insert:hover,
.DynamicTree .rename:hover,
.DynamicTree .remove:hover {
    background-color: {T_TR_COLOR1};
    border: 1px solid {T_TH_COLOR3};
}

.DynamicTree .top { font-weight: bold; padding-left: 0px; line-height: 20px; color: {T_BODY_TEXT}; border-width: 2px; border-color: {T_TH_COLOR2}; border-style: none none border-width: 1px; border-color: {T_TH_COLOR2}; border-style: none none solid none; margin-bottom: 5px;}
.DynamicTree .wrap1 { padding: 10px; border: 1px solid {T_TH_COLOR1}; width: 200px; }
.DynamicTree .wrap2 { margin-left: 2px; }

.DynamicTree #tree-insert-form { display: none; margin-top: 5em; }
.DynamicTree #tree-insert-form .label { text-align: right; width: 50px; padding-right: 8px; }
.DynamicTree #tree-insert-form .input { margin-bottom: 2px; padding-left: 3px; }
.DynamicTree #tree-insert-form select { margin-bottom: 2px; }
.DynamicTree #tree-insert-form .button { margin-top: 4px; }

.DynamicTree #tree-rename-form { display: none; margin-top: 5em; }
.DynamicTree #tree-rename-form .label { text-align: right; width: 50px; padding-right: 8px; }
.DynamicTree #tree-rename-form .input { margin-bottom: 2px; padding-left: 3px; }
.DynamicTree #tree-rename-form select { margin-bottom: 2px; }
.DynamicTree #tree-rename-form .button { margin-top: 4px; }

.XulMenu {
    font-family: georgia, tahoma, verdana;
    font-size: 11px;
    -moz-user-select: none;
}
.XulMenu .button,
.XulMenu .button:hover,
.XulMenu .button-active,
.XulMenu .button-active:hover {
    line-height: normal;
    padding: 4px 8px 3px 8px;
    border: 1px solid {T_TR_COLOR2};
    color: {T_BODY_TEXT};
    text-decoration: none;
    cursor: default;
    white-space: nowrap;
    display: block;
    position: relative;
}
.XulMenu .button:hover {
    border-color: #ffffff #ACA899 #ACA899 #ffffff;
}
.XulMenu .button-active,
.XulMenu .button-active:hover {
    border-color: #ACA899 #ffffff #ffffff #ACA899;
}
.XulMenu .item,
.XulMenu .item:hover,
.XulMenu .item-active,
.XulMenu .item-active:hover {
    background: #ffffff;
    line-height: normal;
    padding: 3px 30px 3px 20px;
    color: #000000;
    text-decoration: none;
    cursor: default;
    white-space: nowrap;
    display: block;
    position: relative;
}
.XulMenu .item:hover,
.XulMenu .item-active,
.XulMenu .item-active:hover {
    background: #316AC5;
    color: #ffffff;
}
.XulMenu .section {
    background: #ffffff;
    border: 1px solid;
    border-color: #F1EFE2 #716F64 #716F64 #F1EFE2;
    padding: 2px 1px 1px 2px;
    position: absolute;
    visibility: hidden;
    z-index: -1;
    margin-top: 25px;
}
.XulMenu .arrow {
    position: absolute;
    top: 7px;
    right: 8px;
    border: 0;
}
.XulMenu .hr {
    font-size: 0px;
    border-width: 1px;
    border-color: #aca899;
    border-style: solid none none none;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 4px;
    margin-right: 4px;
}

* html .XulMenu td { position: relative; } /* ie 5.0 fix */

/* SimpleDoc [www.gosu.pl], style for tabs */
.XulTabs .wrap1 { height: 23px; }
.XulTabs .wrap1 td { vertical-align: bottom; }
.XulTabs .tab,
.XulTabs .tab:hover,
.XulTabs .tab-active,
.XulTabs .tab-active:hover {
    text-decoration: none;
    padding: 3px 10px 3px 10px;
    border-top: 1px solid {T_TH_COLOR1};
    border-left: 1px solid {T_TH_COLOR1};
    color: {T_BODY_LINK};
    cursor: default;
    white-space: nowrap;
    display: block;
}
.XulTabs .tab:hover {
    border-top: 2px solid {T_BODY_VLINK};
    padding-top: 2px;
}
.XulTabs .tab-active,
.XulTabs .tab-active:hover {
    border-top: 3px solid {T_BODY_VLINK};
    padding-top: 2px;
    padding-bottom: 4px;
    font-weight: bold;
}
.XulTabs .view {
    border-right: 1px solid {T_TH_COLOR1};
}
.XulTabs .content {
    border: 1px solid {T_TH_COLOR1};
    background: {T_TR_COLOR1};
    width: 100%;
    height: 100%;
}
.XulTabs .wrap2 {
    vertical-align: top;
    padding: 15px;
}
.XulTabs .data {
    display: none;
}

* html .XulTabs .tab,
* html .XulTabs .tab:hover,
* html .XulTabs .tab-active,
* html .XulTabs .tab-active:hover { width: 100%; }

/* SimpleDoc [www.gosu.pl], style for texteditor */
/*
.ste { background-color: #ffffff; }
.ste .bar {  padding: 3px; border: {T_TH_COLOR1} 1px; border-style: solid solid none solid; }
.ste .frame { background: #ffffff; border: 1px solid; border-color: {T_TH_COLOR1}; }
.ste .frame iframe {  background: #ffffff; width: 100%; height: 300px; }
.ste img { background: #ffffff; border: 0; }
.ste .button { background: #ffffff; padding: 1px; border: {T_TH_COLOR1} 1px solid; }
.ste .button-hover { background: #ffffff; padding: 1px; border: 1px solid; border-color: {T_TH_COLOR3} }
.ste .button-click { background: #ffffff; padding: 1px; border: 1px solid; border-color: {T_TH_COLOR3} }
.ste .separator {background: #ffffff; width: 0px; height: 18px; border-left: {T_TH_COLOR1} 1px solid; border-right: {T_TH_COLOR3} 1px solid; margin: 0 5px; }
.ste .source {  color: {T_BODY_TEXT}; padding-top: 5px; }
*/
-->
</style>

<table cellspacing="1" cellpadding="0" width="100%" height="100%" class="forumline" style="border-top:none;">
<tr>
	<td class="row1">
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr>
			    <td class="cat">
					<div id="menu">
					    <table cellspacing="0" cellpadding="0" class="XulMenu">
					    <tr>
					        <td>
					            <a class="button" href="javascript:void(0)">{L_PROJECT}</a>
					            <div class="section">
					                <a class="item" href="{MODE_MANAGE_URL}">{L_MANAGEMENT}</a>
					                <a class="item" href="{MODE_PUBLISH_URL}">{L_PUBLISH}</a>
					                <div class="hr"></div>
					                <a class="item" href="{MODE_IMPORT_URL}">{L_IMPORT_CONTENT}</a>
					                <a class="item" href="{MODE_EXPORT_URL}">{L_EXPORT_CONTENT}</a>
					                <div class="hr"></div>
					                <a class="item" href="{MODE_VIEW_URL}">{L_DOC_VIEW}</a>
					            </div>
					        </td>
					        <td>
					            <a class="button" href="javascript:void(0)">{L_HELP}</a>
					            <div class="section">
					                <a class="item" href="javascript:void(window.open('{MX_ROOT_PATH}{MODULE_ROOT_PATH}docs/help-contents.html', 'Contents', 'width=400,height=400,scrollbars=yes'))">{L_CONTENTS}</a>
					                <a class="item" href="javascript:void(window.open('{MX_ROOT_PATH}{MODULE_ROOT_PATH}docs/help-about.html', 'Contents', 'width=400,height=400,scrollbars=yes'))">{L_ABOUT}</a>
					            </div>
					        </td>
					    </tr>
					    </table>
					</div>
					<script type="text/javascript">var menu = new XulMenu("menu"); menu.zIndex.visible = 10; menu.init();</script>

			    </td>
			</tr>
			<tr>
			    <td id="top" class="simpledoc_title">
			        <span class="nomargin">{L_PROJECT_NAME} - {L_MANAGEMENT} {VIEW_DOC}</span>
			    </td>
			</tr>
			<tr>
			    <td>
			        <!-- MAIN -->
			        <table cellspacing="0" cellpadding="0" width="100%" height="100%" id="main">
			        <tr>
			            <td id="left" class="rowxx">
			                <div class="DynamicTree">
							    <table cellspacing="0" cellpadding="0">
							    <tr>
							        <td class="row2">
					                    <div class="wrap1">
					                        <div class="top">{L_TOC}</div>
					                        <div class="row2">
					                            <div id="tree">
					                                {TREE_HTML}
					                            </div>
					                        </div>
					                    </div>
					        			<script type="text/javascript">var tree = new DynamicTree("tree"); tree.path = "{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/"; tree.init();</script>

					                </td>
					            </tr>
					            </table>
			                    <div class="actions">
			                        <a id="tree-moveUp" class="moveUp" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/moveUp.gif" width="20" height="20" alt=""></a>
			                        <a id="tree-moveDown" class="moveDown" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/moveDown.gif" width="20" height="20" alt=""></a>
			                        <a id="tree-moveLeft" class="moveLeft" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/moveLeft.gif" width="20" height="20" alt=""></a>
			                        <a id="tree-moveRight" class="moveRight" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/moveRight.gif" width="20" height="20" alt=""></a>
			                    </div>
			                    <div class="actions_r">
			                        <a id="tree-insert" class="insert" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/insert.gif" width="20" height="20" alt=""></a>
			                        <a id="tree-rename" class="rename" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/rename.gif" width="20" height="20" alt=""></a>
			                        <a id="tree-remove" class="remove" href="javascript:void(0)"><img src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/delete.gif" width="20" height="20" alt=""></a>
			                    </div>
				                    <div class="tooltip" id="tree-tooltip"></div>
			                    <div id="tree-rename-form">
			                        <form action="javascript:void(0)" method="get">
			                            <table cellspacing="0" cellpadding="0">
			                            <tr>
			                                <td class="label">{L_NAME}</td>
			                                <td><input class="input" size="18" id="tree-rename-name" name="tree-rename-name" type="text" value="" /></td>
			                            </tr>
			                            <tr>
			                                <td colspan="2" align="center">
			                                    <input id="tree-rename-button" class="button" type="button" value="Rename" />
			                                    <input id="tree-rename-cancel" type="button" value="Cancel" />
			                                </td>
			                            </tr>
			                            </table>
			                        </form>
			                    </div>
			                    <div id="tree-insert-form">
			                        <form action="javascript:void(0)" method="get">
			                            <table cellspacing="0" cellpadding="0">
			                            <tr id="tree-insert-where-div">
			                                <td class="label">{L_WHERE}</td>
			                                <td><select id="tree-insert-where" name="tree-insert-where" class="where"><option value="before">{L_BEFORE}</option><option value="after">{L_AFTER}</option></select></td>
			                            </tr>
			                            <tr>
			                                <td class="label">{L_TYPE}</td>
			                                <td><select id="tree-insert-type" name="tree-insert-type"><option value="doc">{L_DOCUMENT}</option><option value="folder">{L_FOLDER}</option></select></td>
			                            </tr>
			                            <tr>
			                                <td class="label">{L_NAME}</td>
			                                <td><input class="input" size="18" id="tree-insert-name" name="tree-insert-name" type="text" value="" /></td>
			                            </tr>
			                            <tr>
			                                <td colspan="2" align="center">
			                                    <input id="tree-insert-button" class="button" type="button" value="Insert" />
			                                    <input id="tree-insert-cancel" type="button" value="Cancel" />
			                                </td>
			                            </tr>
			                            </table>
			                        </form>
			                    </div>
			                </div>
			                <script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/init_main.js"></script>
			            </td>
			            <td id="right" class="row1">
			                <table cellspacing="0" cellpadding="0" width="100%" height="100%" id="tabs" class="XulTabs">
			                <tr>
			                    <td class="wrap1">
			                        <table cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td class="row2"><a id="tab1" class="tab" href="javascript:void(0)" onclick="documentInfo(); this.blur();">{L_DOC_INFO}</a></td>
			                            <td class="row2"><a id="tab2" class="tab right" href="javascript:void(0)" onclick="editContent(); this.blur();">{L_EDIT_CONTENT}</a></td>
			                            <td class="row2"><a id="tab3" class="tab view" href="javascript:void(0)" onclick="documentPreview(); this.blur();">{L_DOC_PREVIEW}</a></td>
			                            </tr>
			                        </table>
			                    </td>
			                    <td align="right">
			                        <input id="openEditContent" type="checkbox" value="1" onclick="this.checked ? setCookie('openEditContent', 1, COOKIE_YEAR) : delCookie('openEditContent'); this.blur();"> {L_DEFAULT_EDIT}
			                    </td>
			                </tr>
			                <tr>
			                    <td colspan="2">
			                        <table cellspacing="0" cellpadding="0" class="content">
			                        <tr>
			                            <td class="wrap2">
			                                <div id="tabs-data"></div>
			                            </td>
			                        </tr>
			                        </table>
			                        <div id="tabs-loading">{L_LOADING}</div>
			                        <div id="tabs-saving">{L_SAVING}</div>
			                    </td>
			                </tr>
			                </table>
			            </td>
			        </tr>
			        </table>
			    </td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript">
if (getCookie("openEditContent")) el('openEditContent').checked = "checked";
</script>

