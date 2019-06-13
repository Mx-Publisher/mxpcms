<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}" lang="{S_USER_LANG}" xml:lang="{S_USER_LANG}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta name="verify-v1" content="3ezS3iYCRNh3nu59s47WkxxXhKwAw2WKDUFrCmLbfEw=" />
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- BEGIN switch_set_base -->
<base href="{U_PORTAL_ROOT_PATH}" >
<!-- END switch_set_base -->
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- First load standard template *.css definition, located in the the phpbb template folder -->
<!-- link rel="stylesheet" href="{U_PHPBB_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_PHPBB_STYLESHEET}" type="text/css" / -->

<style type="text/css">
<!--
/* General markup styles
---------------------------------------- */
* {
	font-size: 100%;
}

body, div, p, th, td, li, dd {
	voice-family: "\"}\"";
	voice-family: inherit;
}

html {
	color: #536482;
	background: #DBD7D1;
	/* Always show a scrollbar for short pages - stops the jump when the scrollbar appears. non-ie browsers */
	height: 100%;
	margin-bottom: 1px;
}

body {
	/* Text-Sizing with ems: http://www.clagnut.com/blog/348/ */
	font-family: Helvetica, Lucida Grande, Verdana, Arial, sans-serif;
	color: #536482;
	background:#ecf0f6; 
	margin:6px 10px;
	padding:0;
	scrollbar-3dlight-color:#d1d7dc;
	scrollbar-arrow-color:#006699;
	scrollbar-darkshadow-color:#98aab1;
	scrollbar-face-color:#dee3e7;
	scrollbar-highlight-color:#ffffff;
	scrollbar-shadow-color:#dee3e7;
	scrollbar-track-color:#efefef
}

/* General font families for common tags */
font,th,td,p { font-family: Trebuchet MS, Lucida Grande, Verdana, Helvetica, Arial, sans-serif; }

img {
	border: 0;
}

h1 {
	font-family: Trebuchet MS, Helvetica, sans-serif;
	font-size: 1.70em;
	font-weight: normal;
	color: #333333;
}

h2, caption {
	font-family: Trebuchet MS, Helvetica, sans-serif;
	font-size: 1.40em;
	font-weight: normal;
	color: #115098;
	text-align: left;
	margin-top: 25px;
}

.rtl h2, .rtl caption {
	text-align: right;
}

h3, h4 {
	font-family: Trebuchet MS, Helvetica, sans-serif;
	font-size: 1.20em;
	text-decoration: none;
	line-height: 1.20em;
	margin-top: 25px;
}

p {
	margin-bottom: 0.7em;
	line-height: 1.40em;
	font-size: 1em;
}

ul {
	list-style: disc;
	margin: 0 0 1em 2em;
}

.rtl ul {
	margin: 0 2em 1em 0;
}

hr {
	border: 0 none;
	border-top: 1px dashed #999999;
	margin-bottom: 5px;
	padding-bottom: 5px;
	height: 1px;
}

.small {
	font-size: 0.9em;
}

/* Main blocks
---------------------------------------- */

#wrap {
	padding: 0 0 15px 0;
}

#page-header {
	clear: both;
	text-align: right;
	background: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/mxbb_logo.gif") top left no-repeat;
	height: 49px;
	font-size: 0.95em;
	margin-bottom: 10px;
}

.rtl #page-header {
	text-align: left;
	background: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/phpbb_logo.gif") top right no-repeat;
}

#page-header h1 {
	color: #767676;
	font-family: Trebuchet MS, Helvetica, sans-serif;
	font-size: 1.70em;
	padding-top: 10px;
}

#page-header p {
	font-size: 1.00em;
}

#page-header p#skip {
	display: none;
}

#page-body {
	clear: both;
}

#page-footer {
	clear: both;
	font-size: 0.75em;
	text-align: center;
}

#content {
	padding: 30px 10px 10px;
	position: relative;
}

#content h1 {
	color: #115098;
	line-height: 1.2em;
	margin-bottom: 0;
}

#main {
	float: left;
	width: 76%;
	margin: 0 0 0 3%;
	min-height: 350px;
}

.rtl #main {
	float: right;
	margin: 0 3% 0 0;
}

* html #main {
	height: 350px;
}

.simple-page-body {
	padding: 0;
	padding-right: 10px;
	min-width: 0;
}

/* Tabbed menu
	Based on: http://www.alistapart.com/articles/slidingdoors2/
----------------------------------------*/

#tabs {
	line-height: normal;
	margin: 0 0 -6px 7px;
	min-width: 600px;
}

.rtl #tabs {
	margin: 0 7px -6px 0;
}

#tabs ul {
	margin:0;
	padding: 0;
	list-style: none;
}

#tabs li {
	display: inline;
	margin: 0;
	padding: 0;
	font-size: 0.85em;
	font-weight: bold;
}

#tabs a {
	float: left;
	background:url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_tabs1.gif") no-repeat 0% -34px;
	margin: 0 1px 0 0;
	padding: 0 0 0 7px;
	text-decoration: none;
	position: relative;
}

.rtl #tabs a {
	float: right;
}

#tabs a span {
	float: left;
	display: block;
	background: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_tabs2.gif") no-repeat 100% -34px;
	padding: 7px 10px 4px 4px;
	color: #767676;
	white-space: nowrap;
	font-family: Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	font-weight: bold;
}

.rtl #tabs a span {
	float: right;
}

/* Commented Backslash Hack hides rule from IE5-Mac \*/
#tabs a span, .rtl #tabs a span { float:none;}
/* End hack */

#tabs a:hover span {
	color: #BC2A4D;
}

#tabs #activetab a, #tabs .activetab a {
	background-position: 0 0;
	border-bottom: 1px solid #DCDEE2;
}

#tabs #activetab a span, #tabs .activetab a span {
	background-position: 100% 0;
	padding-bottom: 5px;
	color: #23649F;
}

#tabs a:hover {
	background-position: 0 -69px;
}

#tabs a:hover span {
	background-position: 100% -69px;
}

#tabs #activetab a:hover span, #tabs .activetab a:hover span {
	color: #115098;
}


/* Main Panel
---------------------------------------- */

#acp {
	margin: 4px 0;
	padding: 3px 1px;
	background-color: #FFFFFF;
	border: 1px #999999 solid;
}

.panel {
	background: #F3F3F3 url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/innerbox_bg.gif") repeat-x top;
	padding: 0;
}

span.corners-top, span.corners-bottom,
span.corners-top span, span.corners-bottom span {
	font-size: 1px;
	line-height: 1px;
	display: block;
	height: 5px;
	background-repeat: no-repeat;
}

span.corners-top {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_left.gif");
	background-position: 0 0;
	margin: -4px -2px 0;
}

span.corners-top span {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_right.gif");
	background-position: 100% 0;
}

span.corners-bottom {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_left.gif");
	background-position: 0 100%;
	margin: 0 -2px -4px;
	clear: both;
}

span.corners-bottom span {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_right.gif");
	background-position: 100% 100%;
}

/* WinIE tweaks \*/
* html span.corners-top, * html span.corners-bottom { background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_left.gif"); }
* html span.corners-top span, * html span.corners-bottom span { background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_right.gif"); }
/* End tweaks */

/* Sub-navigation Menu
---------------------------------------- */

/* Toggle */

#toggle {
	padding: 5px;
	width: 5%;
	height: 100px;
	position: absolute;
	left: 15%;
	top: 28px;
	margin-left: 2px;
}

#toggle-handle {
	display: block;
	width: 18px;
	height: 19px;
	float: right;
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/toggle.gif");
}

/* Menu */
#menu {
	float: left;
	width: 100%;
	font-size: 1.00em;
	padding: 0;
	border-right: 1px solid #CCCFD3;
}

.rtl #menu {
	float: right;
	border: none;
	border-left: 1px solid #CCCFD3;
}

#menu p {
	font-size: 0.85em;
}

#menu ul {
	list-style: none;
	margin: 0;
	padding: 0;
}

/* Default list state */
#menu li {
	padding: 0;
	margin: 0;
	font-size: 0.85em;
	font-weight: bold;
	display: inline;
}

/* Link styles for the sub-section links */
#menu li span {
	display: block;
	padding: 3px 3px 3px 8px;
	margin: 1px 0;
	text-decoration: none;
	font-weight: normal;
	color: #138ECB;
}

.rtl #menu li span {
	padding: 3px 8px 3px 3px;
}

#menu li a:hover, #menu li a:hover span {
	text-decoration: none;
	background-color: #FFFFFF;

	color: #BC2A4D;
}

#menu li a:active, #menu li a:active span {
	color: #F632A0;
}

#menu li#activemenu a span {
	text-decoration: none;
	font-weight: bold;
	color: #1180B7;
	background: transparent url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_right.gif") 0% 50% no-repeat;
}

.rtl #menu li#activemenu a span {
	background: transparent url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_left.gif") 100% 50% no-repeat;
}

#menu li#activemenu a:hover span, #menu li#activemenu span {
	text-decoration: none;
	font-weight: bold;
	color: #BC2A4D;
	background: #FFFFFF url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_right.gif") 1% 50% no-repeat;
}

.rtl #menu li#activemenu a:hover span, .rtl #menu li#activemenu span {
	background: #FFFFFF url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_left.gif") 99% 50% no-repeat;
}

#menu li a:active, #menu li a:active span, #menu li#activemenu a:active span {
	color: #F632A0;
}

#menu li span.completed {
	text-decoration: none;
	padding: 3px 3px 3px 12px;
	background: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_down.gif") 1% 50% no-repeat;
}

.rtl #menu li span.completed {
	text-decoration: none;
	padding: 3px 12px 3px 3px;
	background: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/arrow_down.gif") 99% 50% no-repeat;
}

#menu li.header {
	font-family: Tahoma, Helvetica, sans-serif;
	display: block;
	font-weight: bold;
	color: #115098;
	border-bottom: 1px solid #327AA5;
	padding: 4px 0 2px;
	margin-top: 15px;
	text-transform: uppercase;
	font-size: 0.75em;
}

/* General form styles
----------------------------------------*/

fieldset {
	margin: 15px 0;
	padding: 10px;
	border-top: 1px solid #D7D7D7;
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
	border-left: 1px solid #D7D7D7;
	background-color: #FFFFFF;
	position: relative;
}

.rtl fieldset {
	border-top: 1px solid #D7D7D7;
	border-right: 1px solid #D7D7D7;
	border-bottom: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
}

* html fieldset {
	padding: 0 10px 5px 10px;
}

fieldset p {
	font-size: 0.85em;
}

legend {
	padding: 1px 0;
	font-family: Trebuchet MS, Tahoma, Arial, Verdana, Sans-serif;
	font-weight: bold;
	color: #115098;
	margin-top: -.4em;
	position: relative;
	text-transform: none;
	line-height: 1.2em;
	top: 0;
	vertical-align: middle;
}

/* Hide from macIE \*/
legend { top: -1.2em; }
/* end */

* html legend {
	margin: 0 0 -10px -7px;
	line-height: 1em;
	font-size: .85em;
}

/* Holly hack, .rtl comes after html */
* html .rtl legend {
	margin: 0;
	margin-right: -7px;
}

/* Form elements */
input, textarea {
	vertical-align: middle;
}

input,textarea, select {
	color : #000000;
	font: normal 11px; 
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	border-color : #000000;
}

/* The text input fields background colour */
input.post, textarea.post, select {
	background-color : #FFFFFF;
}

input { text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
	background-color : #EFEFEF;
	color : #000000;
	font-size: 11px; 
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
}

/* The main submit button option */
input.mainoption {
	background-color : #FAFAFA;
	font-weight : bold;
}

/* None-bold submit button */
input.liteoption {
	background-color : #FAFAFA;
	font-weight : normal;
}

.rtl input, .rtl textarea {
	border-left: 1px solid #D5D5C8;
	border-top: 1px solid #AFAEAA;
	border-right: 1px solid #AFAEAA;
	border-bottom: 1px solid #D5D5C8;
}

input.langvalue, textarea.langvalue {
	width: 90%;
}

optgroup, select {
	font-family: Trebuchet MS, Verdana, Helvetica, Arial, sans-serif;
	font-weight: normal;
	font-style: normal;
	cursor: pointer;
	vertical-align: middle;
	width: auto;
	color: #000;
}

optgroup {
	font-size: 1.00em;
	font-weight: bold;
}

option {
	padding: 0 1em 0 0;
	color: #000;
}

option.disabled-option {
	color: #aaa;
}

.rtl option {
	padding: 0 0 0 1em;
}

.sep {
	font-weight: bold;
}

.username-coloured {
	font-weight: bold;
}

label {
	cursor: pointer;
	padding: 0 5px 0 0;
}

.rtl label {
	padding: 0 0 0 5px;
}

label input {
	vertical-align: middle;
}

label img {
	vertical-align: middle;
}

fieldset.quick, p.quick {
	margin: 0 0 5px;
	padding: 5px 0 0;
	border: none;
	background-color: transparent;
	text-align: right;
}

.rtl fieldset.quick, .rtl p.quick {
	text-align: left;
}

fieldset.quick legend {
	display: none;
}

fieldset.tabulated {
	background: none;
	margin: 0;
	padding: 0;
	padding-top: 5px;
	border: 0;
}

fieldset.tabulated legend {
	display: none;
}

fieldset.nobg {
	margin: 15px 0 0 0;
	padding: 0;
	border: none;
	background-color: transparent;
}

fieldset.display-options {
	margin: 15px 0 2px 0;
	padding: 0 0 4px 0;
	border: none;
	background-color: transparent;
	text-align: center;
	font-size: 0.75em;
}

fieldset.display-options select, fieldset.display-options input, fieldset.display-options label {
	font-size: 1.10em;
	vertical-align: middle;
}

select option.disabled {
	background-color: #bbb;
	color: #fff;
}

/* Special case inputs */
select#board_timezone,
select#full_folder_action {
	width: 95%;
}

/* Definition list layout for forms
	Other general def. list properties defined in prosilver_main.css
---------------------------------------- */

dl {
	font-family: Trebuchet MS, Verdana, Helvetica, Arial, sans-serif;
	font-size: 1.10em;
}

dt {
	float: left;
	width: auto;
}

.rtl dt {
	float: right;
}

dd { color: #666666;}
dd + dd { padding-top: 5px;}
dt span { padding: 0 5px 0 0;}
.rtl dt span { padding: 0 0 0 5px;}

dt .explain { font-style: italic;}

dt label {
	font-size: 1.00em;
	text-align: left;
	font-weight: bold;
	color: #4A5A73;
}

.rtl dt label {
	text-align: right;
}

dd label {
	font-size: 1.00em;
	white-space: nowrap;
	margin: 0 10px 0 0;
	color: #4A5A73;
}

.rtl dd label {
	margin: 0 0 0 10px;
}

html>body dd label input { vertical-align: text-bottom;}	/* Tweak for Moz to align checkboxes/radio buttons nicely */

dd input {
	font-size: 1.00em;
	max-width: 100%;
}

dd select {
	font-size: 100%;
	width: auto;
	max-width: 100%;
}

dd textarea {
	font-size: 0.90em;
	width: 90%;
}

dd select {
	width: auto;
	font-size: 1.00em;
}

fieldset dl {
	margin-bottom: 10px;
	font-size: 0.85em;
}

fieldset dt {
	width: 45%;
	text-align: left;
	border: none;
	border-right: 1px solid #CCCCCC;
	padding-top: 3px;
}

.rtl fieldset dt {
	text-align: right;
	border: none;
	border-left: 1px solid #CCCCCC;
}

fieldset dd {
	margin: 0 0 0 45%;
	padding: 0 0 0 5px;
	border: none;
	border-left: 1px solid #CCCCCC;
	vertical-align: top;
	font-size: 1.00em;
}

.rtl fieldset dd {
	margin: 0 45% 0 0;
	padding: 0 5px 0 0;
	border: none;
	border-right: 1px solid #CCCCCC;
}

dd.full, .rtl dd.full {
	margin: 0;
	border: 0;
	padding: 0;
	padding-top: 3px;
	text-align: center;
	width: 95%;
}

/* Hover highlights for form rows */
fieldset dl:hover dt, fieldset dl:hover dd {
	border-color: #666666;
}

fieldset dl:hover dt label {
	color: #000000;
}

fieldset dl dd label:hover {
	color: #BC2A4D;
}

input:focus, textarea:focus {
	border: 1px solid #BC2A4D;
	background-color: #E9E9E2;
	color: #BC2A4D;
}

/* Submit button fieldset or paragraph
---------------------------------------- */
fieldset.submit-buttons {
	text-align: center;
	border: none;
	background-color: transparent;
	margin: 0;
	padding: 4px;
	margin-top: -1px;
}

p.submit-buttons {
	text-align: center;
	margin: 0;
	padding: 4px;
	margin-top: 10px;
}

fieldset.submit-buttons input, p.submit-buttons input {
	padding: 3px 2px;
}

fieldset.submit-buttons legend {
	display: none;
}

/* Input field styles
---------------------------------------- */

input.radio, input.permissions-checkbox {
	width: auto !important;
	background-color: transparent;
	border: none;
	cursor: default;
}

input.full,
textarea.full {
	width: 99%;
}

* html input.full, * html textarea.full { width: 95%;}
input.medium { width: 50%;}
input.narrow { width: 25%;}
input.tiny { width: 10%;}
input.autowidth { width: auto !important;}
.box2 .inputbox { background-color: #E9E9E9;}

/* Form button styles
---------------------------------------- */

a.button1, input.button1, input.button3,
a.button2, input.button2 {
	width: auto !important;
	padding: 1px 3px 0 3px;
	font-family: Lucida Grande, Trebuchet MS, Verdana, Helvetica, Arial, sans-serif;
	color: #000;
	font-size: 0.85em;
	background: #EFEFEF url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_button.gif") repeat-x top;
	cursor: pointer;
}

a.button1, input.button1 {
	font-weight: bold;
	border: 1px solid #666666;
}

/* Alternative button */

a.button2, input.button2 {
	border: 1px solid #666666;
}

/* <a> button in the style of the form buttons */

a.button1, a.button1:link, a.button1:visited, a.button1:active,
a.button2, a.button2:link, a.button2:visited, a.button2:active {
	text-decoration: none;
	color: #000000;
	padding: 4px 8px;
}

/* Hover states */

a.button1:hover, input.button1:hover,
a.button2:hover, input.button2:hover {
	border: 1px solid #BC2A4D;
	background: #EFEFEF url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_button.gif") repeat bottom;
	color: #BC2A4D;
}

input.disabled {
	font-weight: normal;
	color: #666666;
}

/* Pagination
---------------------------------------- */
.pagination {
	height: 1%; /* IE tweak (holly hack) */
	width: auto;
	text-align: right;
	margin-top: 5px;
	font-size: 0.85em;
	padding-bottom: 2px;
}

.rtl .pagination {
	text-align: left;
}

.pagination strong,
.pagination b {
	font-weight: normal;
}

.pagination span.page-sep {
	display:none;
}

.pagination span strong {
	padding: 0 2px;
	margin: 0 2px;
	font-weight: normal;
	color: #FFFFFF;
	background: #4692BF;
	border: 1px solid #4692BF;
}

.pagination span a, .pagination span a:link, .pagination span a:visited, .pagination span a:active {
	font-weight: normal;
	font-size: 0.85em;
	text-decoration: none;
	color: #5C758C;
	margin: 0 2px;
	padding: 0 2px;
	background: #ECEDEE;
	border: 1px solid #B4BAC0;
}

.pagination span a:hover {
	border-color: #368AD2;
	background: #368AD2;
	color: #FFFFFF;
	text-decoration: none;
}

.pagination img {
	vertical-align: middle;
}


/* Action Highlighting
---------------------------------------- */

.successbox, .errorbox {
	padding: 8px;
	margin: 10px 0;
	color: #FFFFFF;
	text-align: center;
}

.success {
	color: #228822;
}

.error {
	color: #BC2A4D;
}

.successbox {
	background-color: #228822;
}

.errorbox {
	background-color: #BC2A4D;
}

* html .errorbox, * html .successbox { height: 1%; } /* Pixel shift fix for IE */

.successbox h3, .errorbox h3 {
	color: #FFFFFF;
	margin: 0 0 0.5em;
	font-size: 1.10em;
	font-family: Lucida Grande, Trebuchet MS, Verdana, Helvetica, Arial, sans-serif;
}

.successbox p, .errorbox p {
	color: #FFFFFF;
	font-size: 0.85em;
	margin-bottom: 0;
}

.errorbox a:link, .errorbox a:active, .errorbox a:visited,
.successbox a:link, .successbox a:active, .successbox a:visited {
	color: #DBD7D1;
	text-decoration: underline;
	font-weight: bold;
}

.errorbox a:hover, .successbox a:hover {
	color: #FFFFFF;
	text-decoration: none;
	font-weight: bold;
}

/* Special cases for the error page */
#errorpage #page-header a {
	font-weight: bold;
	line-height: 6em;
}

#errorpage #content {
	padding-top: 10px;
}

#errorpage #content h1 {
	color: #DF075C;
}

#errorpage #content h2 {
	margin-top: 20px;
	margin-bottom: 5px;
	border-bottom: 1px solid #CCCCCC;
	padding-bottom: 5px;
	color: #333333;
}

/* Tooltip for permission roles */
.tooltip {
	width: 200px;
	color: #000;
	text-align: center;
	border: 1px solid #AAA;
}

.tooltip span.top {
	background: #EFEFEF;
	font-weight: bold;
	padding: 2px;
}

.tooltip span.bottom {
	padding: 5px;
	color: #000000;
	background: #FFFFFF;
}

/*
 Format Buttons for signature editor
*/
#format-buttons {
	margin: 15px 0 2px 0;
}

#format-buttons input, #format-buttons select {
	vertical-align: middle;
}

/* Nice method for clearing floated blocks without having to insert any extra markup
	From http://www.positioniseverything.net/easyclearing.html */
.clearfix:after, #tabs:after, .row:after, #content:after, fieldset dl:after, #page-body:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}

/* Hide from Mac IE, Windows IE uses this as it doesn't support the :after method above \*/
.clearfix, #tabs, .row, #content, fieldset dl, #page-body {
	height: 1%;
}
/* End hide */

/* Syntax Highlighting
---------------------------------------- */
.sourcenum {
	color: gray;
	font-family: Monaco, Courier New, monospace;
	font-size: 1.25em;
	font-weight: bold;
	line-height: 1.20em;
	text-align: right;
	padding: 0;
}

.rtl .sourcenum {
	text-align: left;
}

.source {
	font-family: Monaco, Courier New, monospace;
	font-size: 1.25em;
	line-height: 1.20em;
	padding: 0;
}

.syntaxbg {
	color: #FFFFFF;
}

.syntaxcomment {
	color: #FF8000;
}

.syntaxdefault {
	color: #0000BB;
}

.syntaxhtml {
	color: #000000;
}

.syntaxkeyword {
	color: #007700;
}

.syntaxstring {
	color: #DD0000;
}

/* General links  */

a:link, a:visited {
	color: #105289;
	text-decoration: none;
}

a:hover {
	color: #BC2A4D;
	text-decoration: underline;
}

a:active {
	color: #368AD2;
	text-decoration: none;
}

hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px; }


/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: #FFFFFF; border: 1px #98AAB1 solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: #FFFFFF; border: 2px #006699 solid; }

.postimage {
	cursor: pointer;
	cursor: hand;
}
.postimage:hover {
	background-color: #C2CFE5;
	cursor: pointer;
	cursor: hand;
}

/* Table styles
---------------------------------------- */
th { background: #70AED3 url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/gradient2b.gif") bottom left repeat-x; }


.rtl th, .rtl td {
	text-align: right;
}


table.type2 th {
	color: #115098;
}

table.type2 td {
	font-size: 1em;
}

table.type2 td.name {
	vertical-align: middle;
}

table.type3  {
	float: right;
	width: 300px;
	border: none;
	background-color: transparent;
}

.rtl table.type3 {
	float: left;
}

table.type3 thead th {
	background-color: transparent;
	border-top: none;
	text-align: center;
	color: #115098;
	font-size: 0.85em;
	font-weight: normal;
	text-transform: none;
}

table.type3 tbody th {
	border-top: none;
	text-align: left;
	text-transform: none;
	border: none;
	font-size: 0.90em;
	font-weight: normal;
	width: 100%;
}

.rtl table.type3 tbody th {
	text-align: right;
}

table.type3 td {
	text-align: center;
}

th.name {
	text-align: left;
	width: auto;
}

.rtl th.name {
	text-align: right;
}

td.name {
	text-align: left;
	font-weight: bold;
}

.rtl td.name {
	text-align: right;
}

.entry {
	text-align: left;
	font-weight: normal;
}

.rtl .entry {
	text-align: right;
}

.spacer {
	background-color: #DBDFE2;
	height: 1px;
	line-height: 1px;
}

/* Round cornered boxes and backgrounds
---------------------------------------- */
.headerbar {
	background: #ebebeb none repeat-x 0 0;
	color: #FFFFFF;
	margin-bottom: 4px;
	padding: 0 5px;
}

.navbar {
	background-color: #ebebeb;
	padding: 0 10px;
}

.forabg {
	background: #b1b1b1 none repeat-x 0 0;
	margin-bottom: 4px;
	padding: 0 5px;
	clear: both;
}

.forumbg {
	background: #ebebeb none repeat-x 0 0;
	margin-bottom: 4px;
	padding: 0 5px;
	clear: both;
}

.forabg {
	background-color: #0076b1;
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_list.gif");
}

.forumbg {
	background-color: #12A3EB;
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/bg_header.gif");
}

.bg1 { background-color: #eaedf4; }
.bg2 { background-color: #d9e2ec; }
.bg3 { background-color: #cedcec; }
.bg4 { background-color: #E4E8EB; }

span.corners-top, span.corners-bottom, span.corners-top span, span.corners-bottom span {
	font-size: 1px;
	line-height: 1px;
	display: block;
	height: 5px;
	background-repeat: no-repeat;
}

span.corners-top {
	background-image: none;
	background-position: 0 0;
	margin: 0 -5px;
}

span.corners-top span {
	background-image: none;
	background-position: 100% 0;
}

span.corners-bottom {
	background-image: none;
	background-position: 0 100%;
	margin: 0 -5px;
	clear: both;
}

span.corners-bottom span {
	background-image: none;
	background-position: 100% 100%;
}

span.corners-top {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_left.png");
}

span.corners-top span {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_right.png");
}

span.corners-bottom {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_left.png");
}

span.corners-bottom span {
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/corners_right.png");
}

/* Main table cell colours and backgrounds */
.row1 { background-color: #eaedf4; }
.row2,.helpline { background-color: #d9e2ec; }
.row3 { background-color: #cedcec; }
td.spacerow { background-color: #cad9ea; }
.row4 { background-color: #E4E8EB; }
.col1 { background-color: #DCEBFE; }
.col2 { background-color: #F9F9F9; }

/*
  This is for the table cell above the Topics, Post & Last posts on the index.php page
  By default this is the fading out gradiated silver background.
  However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
		background-color: #FFFFFF;
		background-image: url({U_PHPBB_ROOT_PATH}templates/subSilver/images/cellpic2.jpg);
		background-repeat: repeat-y;
}

/* Header cells - the blue and silver gradient backgrounds */
th	{
	color: #FFA34F; font-weight : bold;
	background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/cellpic3.gif"); 
}

td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
			background-image: url("{U_PHPBB_ROOT_PATH}templates/subSilver/images/cellpic1.gif");
			background-color:#D1D7DC; border: #FFFFFF; border-style: solid; height: 24px;
}


/*
  Setting additional nice inner borders for the main table cells.
  The names indicate which sides the border will be on.
  Don't worry if you don't understand this, just ignore it :-)
*/
td.cat,td.catHead,td.catBottom {
	height: 26px;
	border-width: 0px 0px 0px 0px;
}
th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {
	font-weight: bold; border: #FFFFFF; border-style: solid; height: 24px; }
td.row3Right,td.spaceRow {
	background-color: #D1D7DC; border: #FFFFFF; border-style: solid; }

th.thHead,td.catHead { font-size: 12px; border-width: 1px 1px 0px 1px; }
th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }
th.thRight,td.catRight,td.row3Right	 { border-width: 0px 1px 0px 0px; }
th.thLeft,td.catLeft	  { border-width: 0px 0px 0px 1px; }
th.thBottom,td.catBottom  { border-width: 0px 1px 1px 1px; }
th.thTop	 { border-width: 1px 0px 0px 0px; }
th.thCornerL { border-width: 1px 0px 0px 1px; }
th.thCornerR { border-width: 1px 1px 0px 0px; }


/* The largest text used in the index page title and toptic title etc. */
.maintitle,h1,h2	{
			font-weight: bold; font-size: 22px; font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
			text-decoration: none; line-height : 120%; color : #000000;
}


/* General text */
.gen { font-size : 15px; }
.genmed { font-size : 14px; }
.gensmall { font-size : 12px; }
.gen,.genmed,.gensmall { color : #000000; }
a.gen,a.genmed,a.gensmall { color: #006699; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: #DD6900; text-decoration: underline; }


/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : 11px; color : #000000 }
a.mainmenu		{ text-decoration: none; color : #006699;  }
a.mainmenu:hover{ text-decoration: underline; color : #DD6900; }


/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: 12px ; letter-spacing: 1px; color : #006699}
a.cattitle		{ text-decoration: none; color : #006699; }
a.cattitle:hover{ text-decoration: underline; }


/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: 12px; color : #006699; }
a.forumlink 	{ text-decoration: none; color : #006699; }
a.forumlink:hover{ text-decoration: underline; color : #DD6900; }


/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav			{ font-weight: bold; font-size: 11px; color : #000000;}
a.nav			{ text-decoration: none; color : #006699; }
a.nav:hover		{ text-decoration: underline; }


/* titles for the topics: could specify viewed link colour too */
.topictitle			{ font-weight: bold; font-size: 11px; color : #000000; }
a.topictitle:link   { text-decoration: none; color : #006699; }
a.topictitle:visited { text-decoration: none; color : #5493B4; }
a.topictitle:hover	{ text-decoration: underline; color : #DD6900; }


/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name			{ font-size : 11px; color : #000000;}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : 10px; color : #000000; }


/* The content of the posts (body of text) */
.postbody { 
	font-size : 15px;
	font-family: Trebuchet MS, Helvetica, Arial, Times, sans-serif;
}
a.postlink:link	{ text-decoration: none; color : #006699 }
a.postlink:visited { text-decoration: none; color : #5493B4; }
a.postlink:hover { text-decoration: underline; color : #DD6900}


/* Quote & Code blocks */
.code {
	font-family: Courier, Courier New, Trebuchet MS, sans-serif; font-size: 11px; color: #006600;
	background-color: #FAFAFA; border: #D1D7DC; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

.quote {
	font-family: Verdana, Arial, Helvetica, Trebuchet MS, sans-serif; font-size: 11px; color: #444444; line-height: 125%;
	background-color: #FAFAFA; border: #D1D7DC; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}


/* Copyright and bottom info */
.copyright		{ font-size: 10px; font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}
a.copyright		{ color: #444444; text-decoration: none;}
a.copyright:hover { color: #000000; text-decoration: underline;}


/* This is the line in the posting page which shows the rollover
  help line. This is actually a text box, but if set to be the same
  colour as the background no one will know ;)
*/
.helpline { background-color: #DEE3E7; border-style: none; }

/* This is the style used for the top page title. */
.pagetitle	{
	font-weight: bold;
	font-size: 30px;
	font-family: Comic Sans MS, Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	text-decoration: none;
	line-height : 120%;
	color : #000066;
	font-variant: small-caps;
	text-transform: capitalize;
	letter-spacing: 5px;
	vertical-align: 20%;
}

/* This is the style used for the top site title. */
.sitetitle	{
	font-family: Trebuchet MS, Arial; 
	letter-spacing: 0.6em; 
	font-variant: small-caps; 
	font-weight: bolder; 
	font-size: 11pt; 
	color: #000066;
}

/* This is the style used for the top site title. */
.sitetitle_desc	{
	font-size: 7px;
}

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("{U_PHPBB_ROOT_PATH}templates/subSilver/formIE.css");
-->
</style>
<!-- Then load mxBB template *.css definition for mx, located in the the portal template folder -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_MXBB_STYLESHEET}" type="text/css" />
<!-- Optionally, redefine some defintions for gecko browsers -->
<link rel="stylesheet" href="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}{T_GECKO_STYLESHEET}" type="text/css" />

{MX_ADDITIONAL_CSS_FILES}
{MX_ADDITIONAL_CSS}
{MX_ICON_CSS}

<!-- BEGIN switch_enable_pm_popup -->
<script language="javascript" type="text/javascript"><!--
	if( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
// --></script>
<!-- END switch_enable_pm_popup -->

<script language="javascript" type="text/javascript"><!--
function checkSearch()
{
	if (document.search_block.search_engine.value == 'google')
	{
		window.open('http://www.google.com/search?q=' + document.search_block.search_keywords.value, '_google', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'site')
	{
		window.open('{U_SEARCH_SITE}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'kb')
	{
		window.open('{U_SEARCH_KB}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else if (document.search_block.search_engine.value == 'pafiledb')
	{
		window.open('{U_SEARCH_PAFILEDB}&search_keywords=' + document.search_block.search_keywords.value, '_self', '');
		return false;
	}
	else
	{
		return true;
	}
}
// --></script>

<script type="text/javascript">
//this will disable google traslate browsing frame, the page still will be traslated but real ip will be returned in Admin Index
if (top.location != self.location) top.location = self.location.href;
</script>

<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Common.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/lib/Toggle.js"></script>
<script language="javascript" type="text/javascript" src="{U_PORTAL_ROOT_PATH}modules/mx_shared/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

{MX_ADDITIONAL_JS_FILES}
{MX_ADDITIONAL_HEADER_TEXT}

</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="1" border="0" align="center" class="mx_main_table">
	<tr>
		<td class="bodyline">

			<table width="100%" cellspacing="0" cellpadding="2" border="0" class="mx_header_table">
				<tr>
					<td class="row3" width="25%" align="left" valign="top"><a href="{U_INDEX}"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/logo_med.gif" border="0" alt="{L_INDEX}" vspace="1"/></a></td>
					<td class="row3" width="50%" align="center" valign="middle">{PAGE_ICON}<span class="pagetitle">{PAGE_TITLE}</span></td>
					<td class="row3" width="25%" align="right" valign="top"><span class="sitetitle">{SITENAME}</span><br /><span class="sitetitle_desc">{SITE_DESCRIPTION}</span></td>
				</tr>
				<tr>
					<td class="row2" align="center" valign="middle" colspan="3">
						{OVERALL_NAVIGATION}
					</td>
				</tr>
				<!-- BEGIN editcp -->
				<tr>
					<td class="row2" align="center" valign="middle" colspan="3">
						<div class="editCP_switch" style="display: {editcp.EDITCP_SHOW};">
							<form action="{editcp.EDIT_ACTION}" method="post" class="mx_editform">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td align="right">
											{editcp.EDIT_IMG}
											{editcp.S_HIDDEN_FORM_FIELDS}
										</td>
									</tr>
								</table>
							</form>
						</div>
					</td>
				</tr>
				<!-- END editcp -->


				<!-- BEGIN switch_view -->
				<tr>
					<td align="left" valign="bottom" colspan="3" ><span class="gensmall">{CURRENT_TIME}</span></td>
				</tr>
				<tr>
					<td align="left" valign="bottom" colspan="3" ><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
				</tr>
				<!-- END switch_view -->

			</table>

			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td height="15" align="center" valign="middle" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_login.gif" border="0" alt="{L_LOGIN_LOGOUT}" hspace="1" /></a></span></td>
					<td height="15" align="center" valign="middle" nowrap><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}&nbsp;</a></span></td>
					<!-- IF USER_LOGGED_OUT -->
					<td height="15" align="center" valign="middle" nowrap><a href="{U_REGISTER}" class="mainmenu"><img src="{U_PORTAL_ROOT_PATH}{TEMPLATE_ROOT_PATH}images/page_icons/nav_register.gif" border="0" alt="{L_REGISTER}" hspace="3" /></a></span></td>
					<td height="15" align="center" valign="middle" nowrap><a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a></span></td>
					<!-- ENDIF -->
					<td valign="top" align="right" width="100%" height="5" >
						<form name="search_block" method="post" action="{U_SEARCH}" onsubmit="return checkSearch()">
							<a href="{U_SEARCH}" class="gen"><span class="gen">{L_SEARCH}</span></a>:
							<input class="post" type="text" name="search_keywords" size="15" value="...?"
								onfocus="if(this.value=='...?'){this.value='';}"
								onblur="if(this.value==''){this.value='...?';}">
							<select class="post" name="search_engine">
								{L_SEARCH_SITE}
								{L_SEARCH_FORUM}
								{L_SEARCH_KB}
								{L_SEARCH_PAFILEDB}
								{L_SEARCH_GOOGLE}
							</select>
							<input type="hidden" name="search_fields" value="all">
							<input type="hidden" name="show_results" value="topics">
							<input class="mainoption" type="submit" value="{L_SEARCH}">
						</form>
					</td>
					<td valign="top" align="left" width="5" height="5" >&nbsp;</td>
				</tr>
			</table>

			<!-- IF PHPBB_STATS -->
			<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
				<tr>
					<td align="left" valign="top" ><span class="gensmall">
						<!-- IF USER_LOGGED_IN -->
						{LAST_VISIT_DATE}<br />
						<!-- ENDIF -->
						{CURRENT_TIME}<br /></span>
					</td>
					<td align="right" valign="top" >
						<!-- IF USER_LOGGED_IN -->
						<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
						<!-- ENDIF -->
						<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
					</td>
				</tr>
			</table>
			<!-- ENDIF -->
