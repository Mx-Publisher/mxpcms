<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<td>
			<div id="admintabs">
				<ul>
				<li id="general_title_tab"><a href="javascript:selectPart('general_title')">{L_GENERAL_TITLE}</a></li>
				<li id="comments_title_tab"><a href="javascript:selectPart('comments_title')">{L_COMMENTS_TITLE}</a></li>
				<li id="notifications_title_tab"><a href="javascript:selectPart('notifications_title')">{L_NOTIFICATIONS_TITLE}</a></li>
				</ul>
			</div>
		</td>
	</tr>
</table>

<fieldset id="general_title">
<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<!-- TITLE ------------------------------------------------------------------------------------------- -->
	  	<th class="thHead" colspan="2">&nbsp;{L_GENERAL_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_MODULE_NAME}<br /><span class="gensmall">{L_MODULE_NAME_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input text="text" name="module_name" value="{MODULE_NAME}" size="20" maxlength="50" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ENABLE_MODULE}<br /><span class="gensmall">{L_ENABLE_MODULE_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="enable_module" value="1" {S_ENABLE_MODULE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="enable_module" value="0" {S_ENABLE_MODULE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_WYSIWYG_PATH}<br /><span class="gensmall">{L_WYSIWYG_PATH_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input text="text" name="wysiwyg_path" value="{WYSIWYG_PATH}" size="20" maxlength="50" /></td>
	</tr>
  	<tr>
		<td align="center" class="cat" colspan="2"><input class="liteoption" type="submit" value="{L_SUBMIT}" name="submit" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
  	</tr>
</table>
</fieldset>
<fieldset id="comments_title">
<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<!-- TITLE ------------------------------------------------------------------------------------------- -->
	  	<th class="thHead" colspan="2">&nbsp;{L_COMMENTS_TITLE}<br /><span class="gensmall">{L_COMMENTS_TITLE_EXPLAIN}</span></th>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_INTERNAL_COMMENTS}<br /><span class="gensmall">{L_INTERNAL_COMMENTS_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="internal_comments" value="1" {S_INTERNAL_COMMENTS_INTERNAL} {S_READONLY} /> {L_INTERNAL_COMMENTS_INTERNAL}&nbsp;&nbsp;<input type="radio" name="internal_comments" value="0" {S_INTERNAL_COMMENTS_PHPBB} {S_READONLY} /> {L_INTERNAL_COMMENTS_PHPBB}</td>
	</tr>
    <tr>
		<td class="row1" width="50%">{L_FORUM_ID}<br /><span class="gensmall">{L_FORUM_ID_EXPLAIN}</span></td>
		<td class="row2" width="50%">{FORUM_LIST}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_COMMENTS_PAG}<br /><span class="gensmall">{L_COMMENTS_PAG_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input class="post" type="text" name="comments_pagination" value="{COMMENTS_PAG}" size="5" maxlength="4" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_WYSIWYG}<br /><span class="gensmall">{L_ALLOW_COMMENT_WYSIWYG_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="allow_comment_wysiwyg" value="1" {S_ALLOW_COMMENT_WYSIWYG_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_wysiwyg" value="0" {S_ALLOW_COMMENT_WYSIWYG_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_HTML}<br /><span class="gensmall">{L_ALLOW_COMMENT_HTML_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input class="radio" type="radio" name="allow_comment_html" value="1" {S_ALLOW_COMMENT_HTML_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_html" value="0" {S_ALLOW_COMMENT_HTML_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOWED_COMMENT_HTML_TAGS}<br /><span class="gensmall">{L_ALLOWED_HTML_TAGS_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input text="text" name="allowed_comment_html_tags" value="{ALLOWED_COMMENT_HTML_TAGS}" size="15" maxlength="50" /></td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_BBCODE}<br /><span class="gensmall">{L_ALLOW_BBCODE_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="allow_comment_bbcode" value="1" {S_ALLOW_COMMENT_BBCODE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_bbcode" value="0" {S_ALLOW_COMMENT_BBCODE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_SMILIES}<br /><span class="gensmall">{L_ALLOW_SMILIES_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="allow_comment_smilies" value="1" {S_ALLOW_COMMENT_SMILIES_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_smilies" value="0" {S_ALLOW_COMMENT_SMILIES_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_IMAGES}<br /><span class="gensmall">{L_ALLOW_IMAGES_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="allow_comment_images" value="1" {S_ALLOW_COMMENT_IMAGES_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_images" value="0" {S_ALLOW_COMMENT_IMAGES_NO} /> {L_NO}</td>
	</tr>
  	<tr>
		<td class="row1">{L_COMMENT_IMAGES_MESSAGE}<br><span class="gensmall">{L_COMMENT_IMAGES_MESSAGE_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" size="50" name="no_comment_image_message" value="{COMMENT_MESSAGE_IMAGE}" /></td>
  	</tr>
	<tr>
		<td class="row1" width="50%">{L_ALLOW_COMMENT_LINKS}<br /><span class="gensmall">{L_ALLOW_COMMENT_LINKS_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="allow_comment_links" value="1" {S_ALLOW_COMMENT_LINKS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_comment_links" value="0" {S_ALLOW_COMMENT_LINKS_NO} /> {L_NO}</td>
	</tr>
  	<tr>
		<td class="row1">{L_COMMENT_LINKS_MESSAGE}<br><span class="gensmall">{L_COMMENT_LINKS_MESSAGE_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" size="50" name="no_comment_link_message" value="{COMMENT_MESSAGE_LINK}" /></td>
  	</tr>
	<tr>
		<td class="row1" width="50%">{L_COMMENT_FORMAT_WORDWRAP}<br /><span class="gensmall">{L_COMMENT_FORMAT_WORDWRAP_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="formatting_comment_wordwrap" value="1" {S_COMMENT_FORMAT_WORDWRAP_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="formatting_comment_wordwrap" value="0" {S_COMMENT_FORMAT_WORDWRAP_NO} /> {L_NO}</td>
	</tr>
  	<tr>
		<td class="row1">{L_COMMENT_FORMAT_IMAGE_RESIZE}<br><span class="gensmall">{L_COMMENT_FORMAT_IMAGE_RESIZE_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" size="50" name="formatting_comment_image_resize" value="{COMMENT_FORMAT_IMAGE_RESIZE}" /></td>
  	</tr>
	<tr>
		<td class="row1" width="50%">{L_COMMENT_FORMAT_TRUNCATE_LINKS}<br /><span class="gensmall">{L_COMMENT_FORMAT_TRUNCATE_LINKS_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="formatting_comment_truncate_links" value="1" {S_COMMENT_FORMAT_TRUNCATE_LINKS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="formatting_comment_truncate_links" value="0" {S_COMMENT_FORMAT_TRUNCATE_LINKS_NO} /> {L_NO}</td>
	</tr>
  	<tr>
		<td class="row1">{L_COMMENT_MAX_SUBJECT_CHAR}<br><span class="gensmall">{L_COMMENT_MAX_SUBJECT_CHAR_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" size="50" name="max_comment_subject_chars" value="{COMMENT_MAX_SUBJECT_CHAR}" /></td>
  	</tr>
  	<tr>
		<td class="row1">{L_COMMENT_MAX_CHAR}<br><span class="gensmall">{L_COMMENT_MAX_CHAR_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" size="50" name="max_comment_chars" value="{COMMENT_MAX_CHAR}" /></td>
  	</tr>
  	<tr>
		<td align="center" class="cat" colspan="2"><input class="liteoption" type="submit" value="{L_SUBMIT}" name="submit" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
  	</tr>
</table>
</fieldset>
<fieldset id="notifications_title">
<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<!-- TITLE ------------------------------------------------------------------------------------------- -->
	  	<th class="thHead" colspan="2">&nbsp;{L_NOTIFICATIONS_TITLE}</th>
	</tr>

	<tr>
		<td class="row1" width="50%">{L_NOTIFY}<br /><span class="gensmall">{L_NOTIFY_EXPLAIN}</span></td>
		<td class="row2" width="50%"><input type="radio" name="notify" value="0" {S_NOTIFY_NONE} />{L_NONE}&nbsp; &nbsp;<input type="radio" name="notify" value="2" {S_NOTIFY_EMAIL} />{L_EMAIL}&nbsp; &nbsp;<input type="radio" name="notify" value="1" {S_NOTIFY_PM} />{L_PM}</td>
	</tr>
	<tr>
		<td class="row1" width="50%">{L_NOTIFY_GROUP}<br /><span class="gensmall">{L_NOTIFY_GROUP_EXPLAIN}</span></td>
		<td class="row2" width="50%">{NOTIFY_GROUP}</td>
	</tr>
  	<tr>
		<td align="center" class="cat" colspan="2"><input class="liteoption" type="submit" value="{L_SUBMIT}" name="submit" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
  	</tr>
</table>
</fieldset>
</form>

<br clear="all" />
<script type="text/javascript">
<!--
function admingetObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}
function adminsetNone(part)
{
	admingetObj(part + '_tab').className = '';
	admingetObj(part).style.display = 'none';

}
function adminsetBlock(part)
{
	admingetObj(part + '_tab').className = 'activetab';
	admingetObj(part).style.display = 'block';

}
function selectPart(part)
{
	adminsetNone('general_title');
	adminsetNone('comments_title');
	adminsetNone('notifications_title');


	adminsetBlock(part);
}

selectPart('general_title');

// -->
</script>