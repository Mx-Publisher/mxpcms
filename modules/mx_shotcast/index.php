<?php
$args = "";
if(isset($_GET["language"]))
{
	$language = $_GET["language"];
	$args .= (($args == '') ? '?' : '&amp;' ) . 'language='.$language;	
}
elseif(isset($_GET["lang"]))
{
	$language = $_GET["lang"];
	$args .= (($args == '') ? '?' : '&amp;' ) . 'lang='.$language;	
}
if(isset($_GET["skin"]))
{
	$radio_skin = $_GET["skin"];
	$args .= (($args == '') ? '?' : '&amp;' ) . 'skin='.$radio_skin;	
}
elseif(isset($_GET["style"]))
{
	$radio_skin = $_GET["style"];
	$args .= (($args == '') ? '?' : '&amp;' ) . 'style='.radio_skin;	
}
if(isset($_GET["config"]))
{
	$config_get = $_GET["config"];
	$args .= (($args == '') ? '?' : '&amp;' ) . 'config='.$config_get;	
}
print "
<html>
<head>
<script type=\"text/javascript\">
<!--
function radio_player() 
{
	props=window.open('radioplayer.php".$args."', 'poppage', 'toolbars=0, scrollbars=0, location=0, statusbars=0, menubars=0, resizable=1, width=320, height=142 left = 100, top = 100');
}
// -->
</script>
<title>Radio Player</title>
</head>
<body>
<center>
<br><br>
<a href=\"javascript:radio_player()\">Radio player</a>
</center>
</body>
</html>
";
?> 

