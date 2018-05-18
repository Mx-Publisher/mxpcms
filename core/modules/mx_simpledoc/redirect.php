<?php
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache")
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Please stand by ..</title>
    <script type="text/javascript">
    window.onload = function() {
        setTimeout(function(){ location = "<?php echo @$_GET['url']; ?>"; }, 2000);
    }
    </script>
</head>
<body>

<table cellspacing="0" cellpadding="0" width="100%" height="100%">
<tr>
    <td align="center" valign="middle">
        <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="message-box" align="center">
                    <?php echo @$_GET['msg']; ?><br><br>
                    Please wait while we transfer you ..<br>
                    (<a href="<?php echo @$_GET['url']; ?>">Or click here if you do not wish to wait</a>)
                </div>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

</body>
</html>