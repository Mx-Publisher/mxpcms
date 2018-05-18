<?php
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | raw.php                                                            |
// | Raw html files template.                                           |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

IoDir::create($TMP, $CHMOD_DIR);
$files = IoDir::readFull($SECTION);

foreach ($files as $file) {
    if ($file == $TMP) continue;
    if ($this->get_name($file) == $SORT) continue;
    
    $id = substr($file, strlen($SECTION.'/'));
    $real_id = substr($file, strlen($CONTENT.'/'));
    $file2 = $TMP .'/'. $id;
    
    if (IoFile::exists($file)) {
        IoFile::write($file2, $this->fetch_document($real_id));
        IoFile::chmod($file2, $CHMOD_FILE);
    } else if (IoDir::exists($file)) {
        IoDir::create($file2, $CHMOD_DIR);
    }
}

?>