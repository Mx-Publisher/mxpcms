<script type="text/javascript">
// <![CDATA[

var menu_state = 'shown';
/**
* Hiding/Showing the side menu
*/
function switch_menu()
{
	var menu = document.getElementById('menu');
	var main = document.getElementById('main');
	var toggle = document.getElementById('toggle');
	var handle = document.getElementById('toggle-handle');

	switch (menu_state)
	{
		// hide
		case 'shown':
			main.style.width = '93%';
			menu_state = 'hidden';
			menu.style.display = 'none';
			toggle.style.width = '20px';
			handle.style.backgroundImage = 'url({U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}admin/images/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			<!-- IF S_CONTENT_DIRECTION eq 'rtl' -->
				handle.style.backgroundPosition = '0% 50%';
				toggle.style.left = '96%';
			<!-- ELSE -->
				handle.style.backgroundPosition = '100% 50%';
				toggle.style.left = '0';
			<!-- ENDIF -->
		break;

		// show
		case 'hidden':
			main.style.width = '76%';
			menu_state = 'shown';
			menu.style.display = 'block';
			toggle.style.width = '5%';
			handle.style.backgroundImage = 'url({U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}admin/images/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			<!-- IF S_CONTENT_DIRECTION eq 'rtl' -->
				handle.style.backgroundPosition = '100% 50%';
				toggle.style.left = '75%';
			<!-- ELSE -->
				handle.style.backgroundPosition = '0% 50%';
				toggle.style.left = '15%';
			<!-- ENDIF -->
		break;
	}
}

// ]]>
</script>
<table border="1" width="100%" cellspacing="0" cellpadding="0" class="forumline">
<tr><td colspan="2">
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="forumline" style="border:none;">
<tr>
<th class="thCornerL">&nbsp;</th>
<!-- BEGIN tab -->
<th class="thHead"{tab.ACTIVE_TAB} style="cursor:pointer;white-space:nowrap;" onclick="window.location='{U_ADMIN_INDEX}&cat={tab.CATEGORY}{tab.PARAMS}';">{tab.L_TAB}</th>
<!-- END tab -->
<th class="thCornetR">&nbsp;</th>
</tr>

</table>
</td></tr>
<tr>
<td width="20%" valign="top" class="row1" style="border-left:none;">
<table border="0" width="100%" cellspacing="0" cellpadding="4" class="forumline" style="border:none;">
<!-- BEGIN category -->
<tr>
<th class="thHead">{category.ADMIN_CATEGORY}</th>
</tr>
<!-- BEGIN panel -->
<tr>
<td class="row1"{category.panel.A_PANEL}><a href="{category.panel.U_PANEL}">{category.panel.L_PANEL}</a></td>
</tr>
<!-- END panel -->
<!-- END category -->
</table>
</td>
<td width="80%" style="padding:6px;padding-left:12px;background-color:#E5E5E5;"><div>{ACTION_SCRIPT}</div>
{CONTENT_ACP}</td>
</tr>
</table>
