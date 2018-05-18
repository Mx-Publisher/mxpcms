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
   	border: 1px {T_TH_COLOR1};
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
   	border: 1px {T_TH_COLOR1};
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
   	border: 1px {T_TH_COLOR1};
   	border-style: solid solid solid solid;
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
   	border: 1px {T_TH_COLOR1};
   	border-style: solid solid solid solid;
    cursor: default;
    position: relative;
}
.click-menu .box1 img, .click-menu .box1-hover img, .click-menu .box1-open img, .click-menu .box1-open-hover img {
    position: absolute;
    top: 6px;
    right: 6px;
}
.click-menu .section {
    background: {T_TR_COLOR1};
    font-family: {T_FONTFACE1};
    font-size: 12px;
    line-height: 15px;
    padding: 5px 5px 6px 5px;
   	border: 0px {T_TH_COLOR1};
   	border-style: none solid solid solid;
    display: none;
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

<!-- <script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_mygosumenu/ie5.js"></script>-->
<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/1.3/ClickShowHideMenu.js"></script>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border-top:none;">
    <tr>
        <td align="center" class="row1">
			<table width="100%" cellspacing="1" cellpadding="0" id="click-menu{MENU_ID}" class="click-menu">
			<!-- BEGIN catrow -->
			<tr>
			    <td align="left">
				    <table width="100%" cellpadding="0" cellspacing="0" border="0">
				    	<tr>
				    		<td style="border:none;">
				        		<div class="box1"><span class="nav">&nbsp;{catrow.CATEGORY}</span></div>
				    		</td>
				    	</tr>
				    </table>
			        <div class="section">
			        	<!-- BEGIN modulerow -->
			            <div class="box2">{catrow.modulerow.U_MENU_ICON}<a href="{catrow.modulerow.U_MENU_MODULE}" target="{catrow.modulerow.U_LINK_TARGET}">{catrow.modulerow.MENU_NAME}</a></div>
			        	<!-- END modulerow -->
			        </div>
			    </td>
			</tr>
			<!-- END catrow -->
			</table>
		</td>
	</tr>
</table>