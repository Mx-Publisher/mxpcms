<table width="{BLOCK_SIZE}" cellpadding="4" cellspacing="0" border="0" class="forumline" >
  		<tr> 
   		<form action="{S_ACTION}" method="post" >
 		<!-- BEGIN switch_not_admin --> 
 	 		 <th class="thHead" align="left" colspan="2">&nbsp;{L_TITLE}&nbsp;</th>
 		<!-- END switch_not_admin -->
 		<!-- BEGIN switch_admin -->
	  		<th class="thCornerL" align="left" >&nbsp;{L_TITLE}&nbsp;</th>
	  		<th class="thCornerR" align="right" >&nbsp;{EDIT_IMG}&nbsp;</th>
 		<!-- END switch_admin -->
		{S_HIDDEN_FORM_FIELDS}
		</form>
  		</tr>
		<!-- BEGIN catrow -->
		<tr> 
  	  <td class="row2" align="left" colspan="2"><span class="genmed"><a href="{catrow.U_URL_SHOW}" class="nav" border="0">{catrow.U_CAT_ICON}</a>&nbsp;<b>{catrow.CATEGORY}</b></span></td>
		</tr>
		<tr> 
  	  <td class="row1" valign="center" colspan="2"><span class="genmed">{catrow.DESCRIPTION}</span></td>
		</tr>
		<!-- BEGIN modulerow -->
		<tr> 
  	  <td class="row1" valign="center" colspan="2">{catrow.modulerow.U_MENU_ICON}<span class="genmed"><a href="{catrow.modulerow.U_MENU_MODULE}" target="{catrow.modulerow.U_LINK_TARGET}" class="genmed" alt="{catrow.modulerow.MENU_DESC}" title="{catrow.modulerow.MENU_DESC}">{catrow.modulerow.MENU_NAME}</a></span></td>
		</tr>
		<!-- END modulerow -->
		<!-- END catrow -->
 </table>
 
<br clear="all" />