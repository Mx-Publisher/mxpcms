<style type="text/css">
<!--
.click-menu {
    width: 100%;
}
.click-menu .box1 {
	background: url("{IMG_EXPAND}") no-repeat;
	background-position: 4px 4px;
    background-color: {T_TR_COLOR2};
    color: {T_BODY_LINK};
    font-weight: bold;
    font-size: 12px;
    font-family: {T_FONTFACE1};
    padding: 6px 21px;
    border-width: 0px;
    border-color: {T_TH_COLOR1};
    border-style: solid solid solid solid;
    cursor: default;
    position: relative;
}
.click-menu .box1-hover {
	background: url("{IMG_EXPAND}") no-repeat;
	background-position: 4px 4px;
    background-color: {T_TR_COLOR1};
    color: {T_BODY_VLINK};
    font-weight: bold;
    font-size: 12px;
    font-family: {T_FONTFACE1};
    padding: 6px 21px;
    border-width: 0px;
    border-color: {T_TH_COLOR1};
    border-style: solid solid solid solid;
    cursor: default;
    position: relative;
}
.click-menu .box1-open {
	background: url("{IMG_CONTRACT}") no-repeat;
	background-position: 4px 4px;
    background-color: {T_TR_COLOR2};
    color: {T_BODY_VLINK};
    font-weight: bold;
    font-size: 12px;
    font-family: {T_FONTFACE1};
    padding: 6px 21px;
    border-width: 0px;
    border-color: {T_TH_COLOR1};
    border-style: solid solid none solid;
    cursor: default;
    position: relative;
}
.click-menu .box1-open-hover {
	background: url("{IMG_CONTRACT}") no-repeat;
	background-position: 4px 4px;
    background-color: {T_TR_COLOR2};
    color: {T_BODY_VLINK};
    font-weight: bold;
    font-size: 12px;
    font-family: {T_FONTFACE1};
    padding: 6px 21px;
    border-width: 0px;
    border-color: {T_TH_COLOR1};
    border-style: solid solid none solid;
    cursor: default;
    position: relative;
}
.click-menu .box1 img, .click-menu .box1-hover img, .click-menu .box1-open img, .click-menu .box1-open-hover img {
    position: absolute;
    top: 6px;
    right: 6px;
}
.click-menu .section {
    background-color: {T_TR_COLOR1};
    font-family: {T_FONTFACE1};
    font-size: 12px;
    line-height: 15px;
    padding: 5px 5px 6px 5px;
    border-width: 0px;
    border-color: {T_TH_COLOR1};
    border-style: none solid solid solid;
    display: none;
    position: absolute;
    left: 15px;
}
.click-menu .section a {
    color: {T_BODY_LINK};
    text-decoration: none;
    white-space: nowrap;
}
.click-menu .section a:hover {
    color: {T_BODY_VLINK};
    text-decoration: none;
    white-space: nowrap;
}
.click-menu .box2 {
}
.click-menu .box2-hover {
    background: {T_TR_COLOR2};
}
.click-menu .section .active,
.click-menu .section .active:hover {
    color: {T_BODY_VLINK};
}
-->
</style>

<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/1.3/ClickShowHideMenu.js"></script>

			<table cellspacing="0" cellpadding="0" id="click-menu{MENU_ID}" class="click-menu">

			<tr>
				<!-- BEGIN catrow -->
			    <td class="row1" align="left" width="{CAT_WIDTH}" valign="top">
				    <table width="100%" cellpadding="0" cellspacing="0" border="0">
				    	<tr>
				    		<td class="cat" style="border:none;">
				        		<div class="box1"><span class="nav">&nbsp;{catrow.CATEGORY}</span></div>
				    		</td>
				    	</tr>
				    </table>
			        <div class="section">
				    <table cellpadding="0" cellspacing="0" border="0">
				    	<tr>
				    		<!-- BEGIN menurow -->
				    		<td>
				        		<div class="box2">{catrow.menurow.U_MENU_ICON}<a href="{catrow.menurow.U_MENU_URL}" target="{catrow.menurow.U_MENU_URL_TARGET}">{catrow.menurow.MENU_NAME}</a></div>
				        	</td>
				        	<!-- END menurow -->
				    	</tr>
				    </table>
			        </div>

			    </td>
			    <!-- END catrow -->
			</tr>

			</table>
<!--
    this.box1Hover = true;
    this.box2Hover = true;
    this.highlightActive = false;
-->

<script type="text/javascript">
 var clickMenu1 = new ClickShowHideMenu('click-menu' + '{MENU_ID}');
    clickMenu1.box1Hover = true;
    clickMenu1.box2Hover = true;
 	clickMenu1.highlightActive = false;
 	//clickMenu1.init_id = 0; // Initiate menu
 clickMenu1.init();

</script>