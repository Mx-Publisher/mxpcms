<h1>{L_TITLE}</h1>
<p>{L_TITLE_EXPLAIN}</p>

<script language="javascript" type="text/javascript">
<!--
function recdays_onchange()
{
	var u_this = "{U_THIS}";
	u_this = u_this.replace(/recdays=([0-9]+)&/, "recdays="+document.frmLog.recdays.value+"&");
	document.location.href = u_this;
}
function recsort_onchange()
{
	var u_this = "{U_THIS}";
	u_this = u_this.replace(/recsort=(.+)&/, "recsort="+document.frmLog.recsort.value+"&");
	document.location.href = u_this;
}
function doOnDeleteConfirm(p_id)
{
	return confirm((p_id ? "{L_DELETE} id="+p_id : "{L_DELETE_ALL}")+". {L_ARE_YOU_SURE}");
}
function doOnDelete(p_id)
{
	return doOnDeleteConfirm(p_id);
}
function doOnDeleteAll()
{
	if( !doOnDeleteConfirm() )
	{
		return false;
	}
	document.location.href = "{U_DELETE_ALL}";
	return true;
}
// -->
</script>

<form name="frmLog">
<table border="0" cellpadding="2" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th class="thCornerL">&nbsp;{L_ID}&nbsp;</th>
		<th class="thTop">&nbsp;{L_TSTAMP}&nbsp;</th>
		<th class="thTop">&nbsp;{L_ERRNO}&nbsp;</th>
		<th class="thTop">&nbsp;{L_USERNAME}&nbsp;</th>
		<th class="thTop">&nbsp;{L_USER_IP}&nbsp;</th>
		<th class="thCornerR">&nbsp;{L_ACTION}&nbsp;</th>
	</tr>
	<tr>
		<th class="thCornerL" colspan="3">&nbsp;{L_REQUEST_URI}&nbsp;</th>
		<th class="thCornerR" colspan="3">&nbsp;{L_HTTP_REFERER}&nbsp;</th>
	</tr>
	<!-- BEGIN datarow -->
	<tr>
		<td class="row1" align="center"><span class="gensmall">{datarow.ID}</span></td>
		<td class="row1" align="center"><span class="gensmall">{datarow.TSTAMP}</span></td>
		<td class="row1" align="center"><span class="gensmall">{datarow.ERRNO}</span></td>
		<td class="row1" align="center"><span class="gensmall">{datarow.USERNAME}</span></td>
		<td class="row1" align="center"><span class="gensmall">{datarow.USER_IP}</span></td>
		<td class="row3" align="center"><span class="gensmall"><a href="{datarow.U_DELETE}" onClick="return doOnDelete({datarow.ID});">{L_DELETE}</a></span></td>
	</tr>
	<tr>
		<td class="row2" colspan="3" align="left"><span class="gensmall">{datarow.REQUEST_URI}</span></td>
		<td class="row2" colspan="3" align="left"><span class="gensmall"><a href="{datarow.HTTP_REFERER}" target="_referer">{datarow.HTTP_REFERER}</a></span></td>
	</tr>
	<!-- END datarow -->
	<tr>
		<td class="cat" colspan="3" align="center">
			<span class="gensmall">{L_SELECT_REC_DAYS}:</span>
			<select name="recdays" onchange="recdays_onchange();">{S_SELECT_REC_DAYS}</select>
		</td>
		<td class="cat" colspan="2" align="center">
			<span class="gensmall">{L_SORT}:</span>
			<select name="recsort" onchange="recsort_onchange();">{S_SELECT_REC_SORT}</select>
		</td>
		<td class="cat" align="center">
			<input type="button" class="liteoption" name="delete_all" value="{L_DELETE_ALL}" onClick="return doOnDeleteAll();" />
		</td>
	</tr>
</table>
</form>

<br clear="all" />