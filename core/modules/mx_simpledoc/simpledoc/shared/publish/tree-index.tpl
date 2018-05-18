<?php
$lang['TOC'] = 'Contents';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title><?php echo $title; ?></title>
    <script type="text/javascript">
    window.onload = function() {
        var query =  location.href.lastIndexOf('?') != -1 ? location.href.substr(location.href.lastIndexOf('?')+1) : '';
        document.getElementById("tree").src = "tree.html"+(query ? "?"+query : "");
        if (query) { document.getElementById("content").src = "html/"+query; }
    }
    </script>
</head>

<frameset cols="200,*" frameborder="no">
    <frame id="tree" name="tree" src="empty.html" frameborder="no">
    <frame id="content" name="content" src="empty.html" frameborder="no">
</frameset>

</html>