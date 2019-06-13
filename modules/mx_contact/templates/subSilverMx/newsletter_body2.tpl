<STYLE type=text/css>
.gen {
	FONT-SIZE: 14px; FONT-FAMILY: Arial, Helvetica, sans-serif;
    padding: 15px;
}
.genmed {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif;
    padding: 15px;
}
.gensmall {
	FONT-SIZE: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif;
    padding: 15px;
}
.style1 {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; FONT-FAMILY: Arial, Helvetica, sans-serif;
    padding: 15px;
}
.style2 {
	FONT-SIZE: 14px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.style4 {
	FONT-SIZE: 12px
}
.style5 {
	FONT-FAMILY: Arial, Helvetica, sans-serif
}
.style6 {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
</STYLE>
<!-- ****************************************************************** -->

<div>
 
<!-- executa formularul in cazul in care variabilele sunt empty -->

<!-- IF USER_LOGGED_OUT -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
 <TBODY>
 <TR bgColor=#cccccc>
	<td class="row2" align="center" colspan="2" class=style1  nowrap="nowrap">
	<span class="gensmall" nowrap="nowrap"><a>{L_INTRODUCTION}</a></span>
	</td>
  </tr>
  </TBODY>
</table>

<br />
<!-- ENDIF -->

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
 <form method="POST" enctype="{S_FORM_ENCTYPE}" action="{S_SUBMIT_ACTION}">
  <TR>
	<TD class=style1 colspan="2" class="catHead" height="25" bgColor=#ffffff colSpan="3">
		<span class="gensmall"><a>{L_NEWSLETTER_FORM}</a></span><br />
		<span class="gensmall"><a>{L_EXPLAIN_NEWSLETTER_FORM}</a></span>
	</td>
  </tr>
  <TR>
	<TD class=style1 bgColor=#f0f0f0  class="row2" colspan="2"><span class="gensmall">{L_FIELDS_REQUIRED}</span></td>
  </tr>
  <TR>
<!-- IF USER_LOGGED_IN -->
	<TD class=style1 bgColor=#f0f0f0  class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
	<TD class=style1 class="row2"><span class="gen"><b>{USERNAME}</b></span></td>
<!-- ENDIF -->
  </tr>
  <TR> 
	<TD class=style1 bgColor=#f0f0f0 class="row1">
	<label for="real_name"><span class="gen"><b>{L_REAL_NAME}</b></span></label>
<!-- IF USER_LOGGED_OUT -->
		<br /><span class="gensmall">{L_REAL_NAME_EXPLAIN}</span>
<!-- ENDIF -->
	</td>
	<TD class="row2">
		<input class="inputbox autowidth" type="text" id="real_name" name="real_name" size="48" maxlength="50" />
	</td>
  </tr>
  <TR>
	<TD witdh="10%" class=style1 bgColor=#f0f0f0 class="row1" nowrap="nowrap"><label for="institution"><span class="gen"><b>{L_INSTITUTION}</b></span></label><br />
		<span class="gensmall">{L_EXPLAIN_INSTITUTION}</span></td>
	<td class="row2"><input class="inputbox autowidth" type="text" id="institution" name="institution" size="48" maxlength="50" /></td>
  </tr>
  <TR>
	<TD witdh="10%"  class=style1 bgColor=#f0f0f0 class="row1" nowrap="nowrap"><label for="phone"><span class="gen"><b>{L_PHONE}</b></span></label><br />
		<span class="gensmall">{L_EXPLAIN_PHONE}</span></td>
	<td class="row2"><input class="inputbox autowidth" type="text" id="phone" name="phone" size="48" maxlength="50" /></td>
  </tr>
  <TR>
	<TD witdh="10%"  class=style1 bgColor=#f0f0f0 class="row1" nowrap="nowrap"><label for="fax"><span class="gen"><b>{L_FAX}</b></span></label><br />
		<span class="gensmall">{L_EXPLAIN_FAX}</span></td>
	<td class="row2"><input class="inputbox autowidth" type="text" id="fax" name="fax" size="48" maxlength="50" /></td>
  </tr>
  <TR>
	<TD witdh="10%" class=style1 bgColor=#f0f0f0 class="row1" nowrap="nowrap"><label for="email"><span class="gen"><b>{L_EMAIL}</b></span></label><br />
		<span class="gensmall">{L_EXPLAIN_EMAIL}</span></td>
	<td class="row2"><input class="inputbox autowidth" type="text" id="email" name="email" size="48" maxlength="50" /></td>
  </tr>  
    <TR>
	<TD class=style1 bgColor=#f0f0f0 class="row1" valign="top"><label for="feedback"><span class="gen"><b>{L_COMMENTS}</b></span></label><br />
		<span class="gensmall">{L_COMMENTS_EXPLAIN}{L_FLOOD_EXPLAIN}{L_COMMENTS_LIMIT}</span></td>
	<td class="row2"><textarea id="feedback" name="feedback" rows="8" cols="35" onkeydown="readout.value=this.value.length;" onkeyup="readout.value=this.value.length;"></textarea>
		<script type="text/javascript"><!--
			document.write('<br /><input name="readout" type="text" size="4" value="0" tabindex="-1" readonly="readonly" /><span class="gensmall">{L_CHARS}</span>');
		--></script>
	</td>
  </tr>  
<!-- BEGIN permit_attachments -->
  <TR>
	<TD class=style1 bgColor=#f0f0f0 class="row1" valign="top"><label for="attachment"><span class="gen"><b>{L_ATTACHMENT}</b></span></label><br />
		<span class="gensmall">{L_ATTACHMENT_EXPLAIN}</span></td>
	<td class="row2"><input type="file" id="attachment" name="attachment" size="48" /></td>
  </tr>
<!-- END permit_attachments -->
<!-- BEGIN captcha -->
  <TR>
	<TD class=style1 bgColor=#f0f0f0 class="row1" valign="top"><label for="code"><span class="gen"><b>{L_CAPTCHA}</b></span></label><br />
		<span class="gensmall">{L_CAPTCHA_EXPLAIN}</span></td>
	<td class="row2"><img src="{CAPTCHA}" alt="" /><br />
		<input class="inputbox autowidth" type="text" id="code" name="code" size="10" maxlength="6" /></td>
  </tr>
<!-- END captcha -->
  <TR>
    <TD bgColor=#f0f0f0 class="style1">{L_AGREEMENT}</TD>
    <TD bgColor=#DADADA colSpan=2 height=30> 
	<input name="newsletter" type="checkbox" value="{YES}" checked /><span class="style2">{L_AGREEMENT_EXPLAIN} </span>
	</TD>
  </TR>
  <TR> 
	<td class="row2" align="center" colspan="2">
		<span class="gensmall"><b>{L_NOTIFY_IP}</b></span></td>
  </tr>
  <TR>
	<td class="catBottom" colspan="2" align="center">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
  </tr>
 </form>
 
</table>

</div>
<br clear="all" />