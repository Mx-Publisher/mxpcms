<?php
//require '../../../config.php';
//$CONFIG['encoding'] is replaced by iso-8859-1
?>
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | request.js                                                         |
// | Functions for getting and saving data using XMLHttpRequest object. |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

/*
    Note (httpLoad): seems like IE always caches retrieved data until you close the browser,
    so when you call a few times the same url, it always returns the same, even
    if the content in the given url changed. There are 2 solutions: add to url
    some random query string or in the url script send NOCACHE headers.
*/

// returns: false|string(responseText)
function httpLoad(url) {
    var req;
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.open("GET", url, false);
        req.setRequestHeader('Accept-Charset','iso-8859-1');
        req.send(null);
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.open("GET", url, false);
            req.setRequestHeader('Accept-Charset','iso-8859-1');
            req.send();
        } else {
            alert("Could not create ActiveXObject (XMLHttpRequest)");
            return false;
        }
    } else {
        alert("Your browser does not support XMLHttpRequest object");
        return false;
    }
    if (req.status != 200) {
        alert("There was a problem while retrieving the data:\n" + req.statusText);
        req.abort();
        return false;
    }
    return req.responseText;
}

// returns: true|false|string(responseText)
function httpSave(url, data) {
    var req;
    var p;
    var content = "";
    if (data) {
        for (var p in data) {
            if (content) { content += "&"; }
            content += (p + "=" + escape(data[p]));
        }
    }
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.open("POST", url, false);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=iso-8859-1");
        req.send(content);
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.open("POST", url, false);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=iso-8859-1");
            req.send(content);
        } else {
            alert("Could not create ActiveXObject (XMLHttpRequest)");
            return false;
        }
    } else {
        alert("Your browser does not support XMLHttpRequest object");
        return false;
    }
    if (req.status != 200) {
        alert("There was a problem while sending the data:\n" + req.statusText);
        req.abort();
        return false;
    }
    if (req.responseText.length) {
    	alert(req.responseText);
        return false;
    }
    return true;
}