<script language='javascript'>
    <!--
	function delete_item(theURL)
	{
       if (confirm('Are you sure you want to delete this item??'))
	   {
          window.location.href=theURL;
       }
       else
	   {
          alert ('No Action has been taken.');
       }
    }
	-->
</script>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" style="border-top:none;">

<!-- Main Navigation ------------------------------------------------------------- -->
<!-- IF VIRTUAL_NAVIGATION -->
	<!-- Drop Down style
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<form method="get" name="virtual_jumpbox" action="{S_ACTION_NAVIGATE}" onSubmit="if(document.virtual_jumpbox.virtual.value == -1){return false;}">
				{VIRTUAL_SELECT}
				<input type="hidden" name="page" value="{VIRTUAL_PAGE_ID}" />
				<input type="submit" class="mainoption" name="go_virtual" value="&raquo;" />
			</form>
		</td>
	</tr>
	-->
	<tr>
		<td class="row1">
			<table width="100%" cellpadding="2" cellspacing="0" border="0">

				<!-- BEGIN virtual_items -->
				<tr>
					<td style="border:none;" class="row1" valign="middle" height="10" align="left" colspan="2" onmouseout="this.className='row1';" onmouseover="this.className='row2';">{virtual_items.ICON}<span class="{virtual_items.STYLE}">&nbsp;<a href="{virtual_items.U_MENU_URL}" class="genmed" title="{virtual_items.NAME}">{virtual_items.NAME}</a></span></td>
				</tr>
				<!-- END virtual_items -->

			</table>
		</td>
	</tr>
<!-- ENDIF -->

<!-- My Page --------------------------------------------------------------------- -->
<!-- IF MY_PAGE -->
	<tr>
		<td class="cat">
			<span class="nav"><b>{L_VIRTUAL_CP}</b></span>
		</td>
	</tr>
	<tr>
		<td class="row1">
			<span class="genmed">{L_VIRTUAL_WELCOME} {VIRTUAL_NAME}. {L_VIRTUAL_INFO}</span>
		</td>
	</tr>
	<!-- IF VIRTUAL_PROJECT -->
	<form method="post" action="{S_ACTION_MANAGE}">
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<input type="text" class="post" name="project_name" size="20" />
			<p>
			<input type="hidden" name="rename" value="do" />
			<input type="hidden" name="id" value="{VIRTUAL_ID}" />
			<input type="submit" class="mainoption" name="submit" value="{L_VIRTUAL_EDIT}" />
		</td>
	</tr>
	</form>
	<!-- ENDIF -->
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<span class="genmed"><a class="genmed" href="javascript:delete_item('{U_DELETE}')">{L_VIRTUAL_DELETE}</a></span>
		</td>
	</tr>
<!-- ENDIF -->

<!-- Create New --------------------------------------------------------------------- -->
<!-- IF CREATE_NEW -->
<tr>
	<td class="cat" align="left" valign="middle" ><span class="nav"><b>{L_VIRTUAL_CREATE_INFO}</b></span></td>
</tr>
	<form method="post" action="{S_ACTION_MANAGE}">
	<!-- IF VIRTUAL_GROUP -->
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
				{GROUP_SELECT}
				<input type="hidden" name="page" value="{VIRTUAL_PAGE_ID}" />
		</td>
	</tr>
	<!-- ENDIF -->
	<!-- IF VIRTUAL_PROJECT -->
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<input type="text" class="post" name="project_name" size="20" />
		</td>
	</tr>
	<!-- ENDIF -->
	<tr>
		<td class="row1" align="center" valign="middle" height="28">
			<input type="hidden" name="create" value="do" />
			<input type="submit" class="mainoption" name="submit" value="{L_VIRTUAL_CREATE}" />
		</td>
	</tr>
	</form>
<!-- ENDIF -->
</table>