	<div id="header">
	  	<div class="globalNav">
		&nbsp;
		<!-- BEGIN catrow -->
			<span class="genmed">{catrow.MENU_SEP}</span> <span class="cat-button{catrow.CURRENT}" onmouseout="this.className='cat-button{catrow.CURRENT}';" onmouseover="this.className='cat-button-current';"><a href="{catrow.U_CATEGORY_URL}" target="{catrow.U_CATEGORY_URL_TARGET}" title="{catrow.CATEGORY_DESC}">{catrow.CATEGORY_NAME}</a></span>
		<!-- END catrow -->
	  	</div>
	</div>

	<div id="subheader">
		<div class="left">
			<table cellpadding="2" cellspacing="0" border="0">
				<tr>
					<!-- BEGIN modulerow -->
					<td style="border:none;" class="" valign="center" onmouseout="this.className='';" onmouseover="this.className='nav-button-current';">
						{modulerow.U_MENU_ICON}<span class="menu-button{modulerow.CURRENT}"><a href="{modulerow.U_MENU_MODULE}" target="{modulerow.U_LINK_TARGET}" class="genmed" title="{modulerow.MENU_DESC}">{modulerow.MENU_NAME}</a></span>
					</td>
					<!-- END modulerow -->

