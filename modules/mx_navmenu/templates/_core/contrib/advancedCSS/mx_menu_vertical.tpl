<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/ie5.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/1.4/XulMenu.js"></script>

<style type="text/css">
<!--
#bar {
	background: #{T_TR_COLOR1};
    cursor: default;
}

.XulMenu {
    font-family: {T_FONTFACE1};
    font-size: 11px;
    -moz-user-select: none;
}
.XulMenu .button,
.XulMenu .button:hover,
.XulMenu .button-active,
.XulMenu .button-active:hover {
	text-align: left;
    line-height: normal;
    padding: 5px 6px 4px 6px;
    border: 1px solid #ECE9D8;
    color: {T_FONTFACE1};
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
.XulMenu .button img,
.XulMenu .button-active img{
    position: absolute;
    top: 4px;
    right: 2px;
    border: 0;
}
.XulMenu .item,
.XulMenu .item:hover,
.XulMenu .item-active,
.XulMenu .item-active:hover {
    background: {T_TR_COLOR1};
    line-height: normal;
    text-align: left;
    padding: 3px 20px 3px 20px;
    color: #000000;
    border: 1px {T_TR_COLOR1};
    border-style: solid solid solid solid;
    text-decoration: none;
    cursor: default;
    white-space: nowrap;
    display: block;
    position: relative;
}
.XulMenu .item:hover,
.XulMenu .item-active,
.XulMenu .item-active:hover {
    background: {T_TR_COLOR2};
    color: {T_FONTFACE1};
    border: 1px {T_TH_COLOR1};
    border-style: solid solid solid solid;
}
.XulMenu .section {
    background: {T_TR_COLOR1};
    border: 1px {T_TH_COLOR1};
    border-style: solid solid solid solid;
    padding: 2px 1px 1px 2px;
    position: absolute;
    visibility: hidden;
    z-index: -1;
}
.XulMenu .arrow {
    position: absolute;
    top: 7px;
    right: 8px;
    border: 0;
}

* html .XulMenu td { position: relative; } /* ie 5.0 fix */
-->
</style>

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline" style="border-top:none;">
    <tr>
        <td align="center" class="row1">
        <div id="bar">
			<table width="100%" cellspacing="0" cellpadding="0" id="menu{MENU_ID}" class="XulMenu">
			<!-- BEGIN catrow -->
		    <tr>
		        <td>
		            <a class="button" href="javascript:void(0)">{catrow.CATEGORY_NAME}<img class="arrow" src="{TEMPLATE_IMAGES_PATH}/arrow_right.gif" width="10" height="12" alt="" /></a>
		            <div class="section">
		            	<!-- BEGIN menurow -->
		                <a class="item" href="{catrow.menurow.U_MENU_URL}" target="{catrow.menurow.U_MENU_URL_TARGET}">{catrow.menurow.U_MENU_ICON}{catrow.menurow.MENU_NAME}</a>
		                <!-- END menurow -->
		            </div>
		        </td>
		    </tr>
		    <!-- END catrow -->
		    </table>
		</div>
		</td>
	</tr>
</table>