<style type="text/css">
<!--
.ddm1 {
    font: 11px {T_FONTFACE1};
}
.ddm1 .item1,
.ddm1 .item1:hover,
.ddm1 .item1-active,
.ddm1 .item1-active:hover {
	background: {T_TR_COLOR1};
    padding: 5px 6px 5px 6px;
    text-decoration: none;
    display: block;
    position: relative;
    white-space: nowrap;
}
.ddm1 .item1 {
	text-align: left;
    color: {T_BODY_LINK};
   	border: 1px {T_TR_COLOR1};
   	border-style: solid solid solid solid;
}
.ddm1 .item1:hover,
.ddm1 .item1-active,
.ddm1 .item1-active:hover {
    background: {T_TR_COLOR2};
    color: {T_BODY_VLINK};
   	border: 1px {T_TH_COLOR1};
	border-style: solid solid solid solid;
}
.ddm1 .item2,
.ddm1 .item2:hover {
	background: {T_TR_COLOR1};
    padding: 5px 6px 5px 6px;
    text-decoration: none;
    display: block;
    white-space: nowrap;
    border: 1px {T_TR_COLOR1};
    border-style: solid solid solid solid;
}
.ddm1 .item2 {
	text-align: left;
    color: {T_BODY_LINK};
}
.ddm1 .item2:hover {
    background: {T_TR_COLOR2};
    color: {T_BODY_VLINK};
    border: 1px {T_TH_COLOR1};
    border-style: solid solid solid solid;
}
.ddm1 .section {
	background: {T_TR_COLOR1};
    border: 1px {T_TH_COLOR1};
    border-style: solid solid solid solid;
    position: absolute;
    visibility: hidden;
    z-index: -1;
    white-space: nowrap;
}
.ddm1 .left, .ddm1 .left:hover { border-style: solid none solid solid; }
.ddm1 .right, .ddm1 .right:hover { border-style: solid solid solid none; }

* html .ddm1 td { position: relative; } /* ie 5.0 fix */
-->
</style>

<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/ie5.js"></script>
<script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/mygosumenu/1.0/DropDownMenu1.js"></script>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline" style="border-top:none;">
    <tr>
        <td align="left" class="row1">

			<table cellspacing="0" cellpadding="0" id="menu{MENU_ID}" class="ddm1">
		    <tr>
		    	<!-- BEGIN catrow -->
		        <td>
		            <a class="item1" href="{catrow.CATEGORY_URL}">{catrow.CATEGORY_NAME}</a>
		            <div class="section">
		            	<!-- BEGIN menurow -->
		                <a class="item2" href="{catrow.menurow.U_MENU_URL}" target="{catrow.menurow.U_MENU_URL_TARGET}">{catrow.menurow.U_MENU_ICON} {catrow.menurow.MENU_NAME}</a>
		                <!-- END menurow -->
		            </div>
		        </td>
		        <!-- END catrow -->
		    </tr>
		    </table>

		</td>
	</tr>
</table>