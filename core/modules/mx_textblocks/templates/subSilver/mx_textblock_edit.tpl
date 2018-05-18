<script language="JavaScript" type="text/javascript">
<!--
// bbCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav  = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_win   = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac    = (clientPC.indexOf("mac")!=-1);


// Helpline texts
b_help = "{L_BBCODE_B_HELP}";
i_help = "{L_BBCODE_I_HELP}";
u_help = "{L_BBCODE_U_HELP}";
q_help = "{L_BBCODE_Q_HELP}";
c_help = "{L_BBCODE_C_HELP}";
l_help = "{L_BBCODE_L_HELP}";
o_help = "{L_BBCODE_O_HELP}";
p_help = "{L_BBCODE_P_HELP}";
w_help = "{L_BBCODE_W_HELP}";
a_help = "{L_BBCODE_A_HELP}";
s_help = "{L_BBCODE_S_HELP}";
f_help = "{L_BBCODE_F_HELP}";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

// Shows the help texts in the helpline window
function helpline(help) {
	document.post.helpbox.value = eval(help + "_help");
}


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function checkForm() {

	formErrors = false;    

	if (document.post.Text.value.length < 2) {
		formErrors = "{L_EMPTY_BLOCK_INFO}";
	}

	if (document.post.block_title.value.length < 2) {
		formErrors = "{L_EMPTY_BLOCK_TITLE}";
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function emoticon(text) {
	text = ' ' + text + ' ';
	if (document.post.Text.createTextRange && document.post.Text.caretPos) {
		var caretPos = document.post.Text.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		document.post.Text.focus();
	} else {
	document.post.Text.value  += text;
	document.post.Text.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			document.post.Text.value += bbopen + bbclose;
			document.post.Text.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		document.post.Text.focus();
		return;
	} else {
		document.post.Text.value += bbopen + bbclose;
		document.post.Text.focus();
		return;
	}
	storeCaret(document.post.Text);
}


function bbstyle(bbnumber) {

	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			document.post.Text.value += bbtags[butnumber + 1];
			buttext = eval('document.post.addbbcode' + butnumber + '.value');
			eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		document.post.Text.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
		theSelection = document.selection.createRange().text; // Get text selection
		
	if (theSelection) {
		// Add tags around selection
		document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
		document.post.Text.focus();
		theSelection = '';
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				document.post.Text.value += bbtags[butnumber + 1];
				buttext = eval('document.post.addbbcode' + butnumber + '.value');
				eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			document.post.Text.focus();
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			document.post.Text.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		document.post.Text.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval('document.post.addbbcode'+bbnumber+'.value += "*"');
		document.post.Text.focus();
		return;
	}
	storeCaret(document.post.Text);
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

//-->
</script>

<!-- BEGIN tinyMCE -->
<script language="javascript" type="text/javascript" src="../../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
   tinyMCE.init({
      mode : "textareas",
      theme : "advanced",
      theme_advanced_toolbar_location : "top",
      plugins : "table",
      theme_advanced_buttons3_add_before : "tablecontrols, separator"
   });
</script>
<!-- END tinyMCE -->

<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">

{POST_PREVIEW_BOX}
{ERROR_BOX}


<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>{L_POST_A}</b></th>
	</tr>
<!--
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_BLOCK_TITLE}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="block_title" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{BLOCK_TITLE}" />
		</span> </td>
	</tr>
-->
	<tr> 
	 	<td class="row1" width="30%"><span class="gen"><b>{L_BLOCK_TITLE}</b></span></td>
	 	<td class="row2"><input type="text" size="65" name="block_title" value="{E_BLOCK_TITLE}" class="post" /></td>
	</tr>

   	<tr> 
	 	<td class="row1" width="30%"><span class="gen">{L_BLOCK_DESC}</span></td>
	 	<td class="row2"><input type="text" size="65" name="block_desc" value="{E_BLOCK_DESC}" class="post" /></td>
	</tr>

	<tr>
		<td class="row1" width="30%"><span class="gen">{L_SHOW_TITLE}</span><br /><span class="gensmall">{L_SHOW_TITLE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="show_title" value="1" {S_SHOW_TITLE_YES} /> <span class="gen">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="show_title" value="0" {S_SHOW_TITLE_NO} /> <span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
        <td class="row1" width="30%"><span class="gen">{L_SHOW_STATS}</span></td> 
        <td class="row2"><input type="radio" name="show_stats" value="1" {S_SHOW_STATS_YES} /> <span class="gen">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_stats" value="0" {S_SHOW_STATS_NO} /> <span class="gen">{L_NO}</span></td> 
    </tr>
    	
	<tr> 
        <td class="row1" width="30%"><span class="gen">{L_SHOW_BLOCK}</span></td> 
        <td class="row2"><input type="radio" name="show_block" value="1" {S_SHOW_BLOCK_YES} /> <span class="gen">{L_YES}&nbsp;&nbsp;</span><input type="radio" name="show_block" value="0" {S_SHOW_BLOCK_NO} /> <span class="gen">{L_NO}</span></td> 
    </tr>
	<tr> 
	  <td class="row1" valign="top"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td><span class="gen"><b>{L_BLOCK_INFO}</b></span> </td>
		  </tr>
		  <tr> 
			<td valign="middle" align="center"> <br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle"> 
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
				</tr>
				<!-- END switch_smilies_extra -->
			  </table>
			</td>
		  </tr>
		</table>
	  </td>
	  <td class="row2" valign="top"><span class="gen">
		<table width="450" border="0" cellspacing="0" cellpadding="2">
		<!-- BEGIN switch_bbcodes -->
		  <tr align="center" valign="middle"> 
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline('o')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"> 
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td><span class="genmed"> &nbsp;{L_FONT_COLOR}: 
					<select name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="{T_FONTCOLOR1}" class="genmed">{L_COLOR_DEFAULT}</option>
					  <option style="color:darkred; background-color: {T_TD_COLOR1}" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
					  <option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
					  <option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
					  <option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
					  <option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
					  <option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
					  <option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
					  <option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
					  <option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
					  <option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
					  <option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
					  <option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
					  <option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="genmed">{L_FONT_TINY}</option>
					  <option value="9" class="genmed">{L_FONT_SMALL}</option>
					  <option value="12" selected class="genmed">{L_FONT_NORMAL}</option>
					  <option value="18" class="genmed">{L_FONT_LARGE}</option>
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>
					</span></td>
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onMouseOver="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
<!-- END switch_bbcodes -->
		  <tr> 
			<td colspan="9"><span class="gen"> 
			  <textarea name="{BLOCK_TEXT_NAME}" rows="40" cols="35" wrap="virtual" style="width:550px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{BLOCK_INFO}</textarea>
			  </span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
	<tr> 
	  <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"><span class="gen"> </span> 
		<table cellspacing="0" cellpadding="1" border="0">
		  <!-- BEGIN switch_allow_bbcode -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_ALLOW_BBCODE}</span></td>
				<td class="row2" width="50%"><input type="radio" name="allow_bbcode" value="TRUE" {S_ALLOW_BBCODE_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="allow_bbcode" value="FALSE" {S_ALLOW_BBCODE_NO} /> <span class="gensmall">{L_NO}</span></td>
			</tr>
		  <!-- END switch_allow_bbcode -->
		  <!-- BEGIN switch_allow_html -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_ALLOW_HTML}</span></td>
				<td class="row2" width="50%"><input type="radio" name="allow_html" value="TRUE" {S_ALLOW_HTML_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="allow_html" value="FALSE" {S_ALLOW_HTML_NO} /> <span class="gensmall">{L_NO}</span></td>
			</tr>
		  <!-- END switch_allow_html -->
		  <!-- BEGIN switch_html_tags -->
			<tr> 
			 	<td class="row2" width="30%"><span class="genmed">{L_HTML_TAGS}</span></td>
			 	<td class="row2"><input type="text" size="35" name="html_tags" value="{S_HTML_TAGS}" class="post" /></td>
			</tr>
		  <!-- END switch_html_tags -->		  
		  <!-- BEGIN switch_allow_smilies -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_ALLOW_SMILIES}</span></td>
				<td class="row2" width="50%"><input type="radio" name="allow_smilies" value="TRUE" {S_ALLOW_SMILIES_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="allow_smilies" value="FALSE" {S_ALLOW_SMILIES_NO} /> <span class="gensmall">{L_NO}</span></td>
			</tr>
		  <!-- END switch_allow_smilies -->		  
		  <!-- BEGIN switch_block_style -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_BLOCK_STYLE}</span><br /><span class="gensmall">{L_BLOCK_STYLE_EXPLAIN}</span></td>
				<td class="row2" width="50%"><input type="radio" name="block_style" value="TRUE" {S_BLOCK_STYLE_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="block_style" value="FALSE" {S_BLOCK_STYLE_NO} /> <span class="gensmall">{L_NO}</span></td>
			</tr>
		  <!-- END switch_block_style -->
		  <!-- BEGIN switch_text_style -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_TEXT_STYLE}</span><br /><span class="gensmall">{L_TEXT_STYLE_EXPLAIN}</span></td>
				<td class="row2" width="50%">{S_TEXT_STYLE} </td>
			</tr>
		  <!-- END switch_text_style -->
		  <!-- BEGIN switch_title_style -->
			<tr>
				<td class="row2" width="50%"><span class="genmed">{L_TITLE_STYLE}</span><br /><span class="gensmall">{L_TITLE_STYLE_EXPLAIN}</span></td>
				<td class="row2" width="50%"><input type="radio" name="title_style" value="TRUE" {S_TITLE_STYLE_YES} /> <span class="gensmall">{L_YES}</span>&nbsp;&nbsp;<input type="radio" name="title_style" value="FALSE" {S_TITLE_STYLE_NO} /> <span class="gensmall">{L_NO}</span></td>
			</tr>
		  <!-- END switch_title_style -->
		</table>
	  </td>
	</tr>
 	<!-- BEGIN switch_block_admin -->
 	<tr> 
 	  <td class="row1">{L_COLUMN}</td>
 	  <td class="row2"><select name="columnid">{S_COLUMN_LIST}</select></td>
 	</tr>
 	<!-- END switch_block_admin -->
	{POLLBOX} 
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
	</tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>

