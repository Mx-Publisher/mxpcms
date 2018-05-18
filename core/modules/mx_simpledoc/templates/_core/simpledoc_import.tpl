<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/common.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/shared/XulMenu/XulMenu.js"></script>

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
	<td class="row2">
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
					        <!--
					        <td>
					            <a class="button" href="javascript:void(0)">{L_OPTIONS}</a>
					            <div class="section">
					                <a class="item" href="{MODE_SETTINGS_URL}">{L_SETTINGS}</a>
					            </div>
					        </td>
					        -->
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
			        <span class="nomargin">{L_PROJECT_NAME} - {L_IMPORT_CONTENT}</span>
			    </td>				
			</tr>
			<tr>
			    <td id="left" class="row1">
			    <form action="{MODE_IMPORT_URL}" method="post" enctype="multipart/form-data">
			    <table>
			    <tr>
			        <td>{L_ZIP_FILE}</td>
			        <td><input type="file" name="zip_file" size="30"></td>
			    </tr>
			    <tr>
			        <td colspan="2"><input type="submit" name="submit" value="{L_ZIP_IMPORT}" onclick="return validateForm(this.form)"></td>
			    </tr>
			    </table>
			    </form>
				
			    <script type="text/javascript" src="{MX_ROOT_PATH}{MODULE_ROOT_PATH}simpledoc/includes/js/form.js"></script>
			    <script type="text/javascript">
			    function validateForm(form) {
			        if (!form.elements["zip_file"].value) { alert("{L_ZIP_FILE_REQUIRED}"); return false; }
			        return true;
			    }
			    </script>
						
				    
			    <p>{L_ZIP_INFO}</p>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>