<?php
global $phpEx;
include_once dirname(__FILE__) . '/Handler.' . $phpEx;
$__ErrorHandler = new ErrorHandler;
set_error_handler(array(&$__ErrorHandler, 'raiseError'));

?>