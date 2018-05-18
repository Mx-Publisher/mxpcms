<?php
$lang['TOC'] = 'Table of Contents';
function build_tree_html($tree) {
    $ret = '';
    foreach ($tree as $id => $v) {
        $name = strpos($id, '/') !== false ? substr($id, (int)strrpos($id, '/')+1) : $id;
        if (is_array($v)) {
            $ret .= sprintf('<div class="folder" id="tree-%s">%s', $id, $name);
            $ret .= build_tree_html($tree[$id]);
            $ret .= '</div>';
        } else {
            $ret .= sprintf('<div class="doc" id="tree-%s"><a target="content" href="html/%s">%s</a></div>', $id, $id, substr($name, 0, -5));
        }
    }
    return $ret;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title><?php echo $lang['TOC']; ?></title>
    <link rel="stylesheet" type="text/css" href="shared/DynamicTree.css">
    <link rel="stylesheet" type="text/css" href="shared/common.css">
    <script type="text/javascript" src="shared/ie5.js"></script>
    <script type="text/javascript" src="shared/DynamicTree.js"></script>
</head>
<body>

<table cellspacing="0" cellpadding="0" width="100%" height="100%" id="main">
	<tr>
	<td id="left">
	    <div class="DynamicTree">
	        <div class="top"><?php echo $lang['TOC']; ?></div>
	        <div class="wrap" id="tree">
	            <?php echo build_tree_html($tree); ?>
	        </div>
	    </div>
	
	    <script type="text/javascript">
	    var tree = new DynamicTree("tree");
	    tree.path = "shared/images/";
	    tree.init();
	    var query =  location.href.lastIndexOf('?') != -1 ? location.href.substr(location.href.lastIndexOf('?')+1) : '';
	    if (query) {
	        tree.closeAll();
	        tree.openTo("tree-"+query);
	        tree.setActive("tree-"+query);
	    }
	    </script>
	</td>
	</tr>
</table>
	   
</body>
</html>