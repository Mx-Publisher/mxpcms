<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/common.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulMenu/XulMenu.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulMenu/ie5.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/DynamicTree.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulTabs/XulTabs.js"></script>

<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/management.js.php"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/request.js.php"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/debug.js"></script>

<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/ajax/AjaxRequest_comp.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/ajax/dhtmlHistory.js"></script>

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
#left { width: 500px; padding: 15px 15px 15px 15px; border-right: 1px solid {T_TH_COLOR1}; vertical-align: top; }
#right { padding: 15px 15px 15px 15px; vertical-align: top; height: 100%; width: 100%;}
#tabs-loading, #tabs-saving { position: absolute; z-index: 10; display: none; opacity: 0.8; -moz-opacity: 0.8; filter: alpha(opacity=80); }

img { border: 0; }
ul { margin: 1em 0 1em 3em; padding: 0; }

#tabs-data,
#tabs-data table {
    font-family: {T_FONTFACE1};
    color: {T_BODY_TEXT};
    background: {T_TR_COLOR1};
    width: 100%;
}

.t0 { border: {T_TH_COLOR1} 1px solid; }
.t1 { background: {T_TR_COLOR2}; padding: 3px 8px; }
.t2 { background: {T_TR_COLOR2}: padding: 3px 8px; }

#saved { color: {T_BODY_TEXT}; }

.error { color: red; }
.message { color: green; }
.note { font-weight: bold; }

.message-box { padding: 1em; background: {T_TD_COLOR2}; border: {T_TH_COLOR3} 1px solid; }

pre { background-color: {T_TR_COLOR2}; padding: 0.75em 1.5em; border: 1px solid {T_TH_COLOR1}; }
.contents { float: right;  background-color: {T_TR_COLOR2}; padding: 0.75em; margin: 0 0 0.75em 0.75em; border: 1px solid {T_TH_COLOR1}; }
.contents ul { list-style: none; margin-left: 0.5em; margin-right: 0.9em; margin-bottom: 2px; margin-top: 0px; padding: 5px; text-indent: -0.9em; }

.sectioncontents { padding: 0em; margin: 0 0 0 0; }
.sectioncontents ul { list-style: none; margin-left: 1.5em; margin-right: 0.5em; margin-bottom: 2px; margin-top: 0px; padding: 1px;}
.sectioncontents a { color: {T_BODY_LINK}; text-decoration: none; }
.sectioncontents a:hover { color: {T_BODY_VLINK}; text-decoration: underline; cursor: hand; }


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
.DynamicTree a:hover { color: {T_BODY_VLINK}; text-decoration: none; cursor: hand; }

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
.DynamicTree .tooltip {
    margin-top: 28px;
    margin-left: 0px;
    height: 5px;
}
.DynamicTree .moveUp,
.DynamicTree .moveDown,
.DynamicTree .moveLeft,
.DynamicTree .moveRight,
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
-->
</style>

<table cellspacing="1" cellpadding="0" width="100%" height="100%" class="forumline" style="border-top:none;">
<tr>
	<td class="row1">
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td class="rowxx">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
					    <td id="top" class="simpledoc_title">
					        <span class="nomargin">{L_PROJECT_NAME} {MANAGE}</span>
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
					                    	</td>
					                    </tr>
					                   </table>
					                </div>
					                <script type="text/javascript">var tree = new DynamicTree("tree"); tree.path = "{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/DynamicTree/images/"; tree.init();</script>
					                <script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/init_view.js"></script>
					            </td>
					            <td id="right" class="row1">
					                <table cellspacing="0" cellpadding="0" width="100%" height="100%" id="tabs" class="XulTabs">
					                <tr>
					                    <td colspan="2">
					                        <table cellspacing="0" cellpadding="0" class="content">
					                        <tr>
					                            <td class="wrap2">
					                                <div id="tabs-loading">{L_LOADING}</div>
					                                <div id="tabs-saving">{L_SAVING}</div>
					                                <div id="tabs-data"></div>
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
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
