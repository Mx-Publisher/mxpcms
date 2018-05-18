<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>


<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<tr>
  <th class="thHead" colspan="3">{BLOCK_TITLE}</th>
</tr>
<!-- BEGIN param_row -->
	<tr>
		<td class="row1">{param_row.PARAMETER_LABEL}<br />{param_row.PARAMETER_INFO}</td>
		<td class="row2">{param_row.PARAMETER_FIELD}</td>
	</tr>
<!-- END param_row -->

	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>

<br clear="all" />

