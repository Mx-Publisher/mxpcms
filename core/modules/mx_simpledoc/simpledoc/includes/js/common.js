// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | common.js                                                          |
// | Some common help functions used all over the project.              |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

function element(id) { return document.getElementById(id); }
function elem(id) { return document.getElementById(id); }
function el(id) { return document.getElementById(id); }

/* Check whether array contains given string */
Array.prototype.contains = function(s) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === s) { return true; }
    }
    return false;
};

/* Finds the index of the first occurence of item in the array, or -1 if not found */
Array.prototype.indexOf = function(item) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === item) { return i; }
    }
    return -1;
};

/* Get the last element from the array */
Array.prototype.getLast = function() {
    return this[this.length-1];
};

/* Remove element with given index (mutates) */
Array.prototype.removeByIndex = function(index) {
    this.splice(index, 1);
};

/* Remove elements with such value (mutates) */
Array.prototype.removeByValue = function(value) {
    var i, indexes = [];
    for (i = 0; i < this.length; i++) {
        if (this[i] === value) { indexes.push(i); }
    }
    for (i = indexes.length - 1; i >= 0; i--) {
        this.splice(indexes[i], 1);
    }
};

/* Push an element at specified index */
Array.prototype.pushAtIndex = function(el, index) {
    this.splice(index, 0, el);
};

/* Strip whitespace from the beginning and end of a string  */
String.prototype.trim = function() {
    return this.replace(/^\s*|\s*$/g, "");
};

/* Count the number of substring occurrences */
String.prototype.substrCount = function(s) {
    return this.split(s).length - 1;
};

// Getting, Setting and Deleteing cookies.
// Author: Cezary Tomczak [www.gosu.pl]
// Note: name cannot contain 2 chars: =;
function Cookie() {
    this.get = function(name) {
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; ++i) {
            var a = cookies[i].split("=");
            if (a.length == 2) {
                a[0] = a[0].trim();
                a[1] = a[1].trim();
                if (a[0] == name) {
                    return unescape(a[1]);
                }
            }
        }
        return "";
    };
    this.set = function(name, value, seconds, path) {
        var cookie = (name + "=" + escape(value));
        if (seconds) {
            var date = new Date(new Date().getTime()+seconds*1000);
            cookie += ("; expires="+date.toGMTString());
        }
        cookie += (path    ? "; path="+path : "");
        document.cookie = cookie;
    };
    this.del = function(name, path) {
        var cookie = (name + "=");
        cookie += (path    ? "; path="+path : "");
        cookie += "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        document.cookie = cookie;
    };
}

var COOKIE_MONTH = 3600*24*30;
var COOKIE_YEAR = 3600*24*30*12;

function getCookie(name) {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; ++i) {
        var a = cookies[i].split("=");
        if (a.length == 2) {
            a[0] = a[0].trim();
            a[1] = a[1].trim();
            if (a[0] == name) {
                return unescape(a[1]);
            }
        }
    }
    return "";
}
function setCookie(name, value, seconds, path) {
    var cookie = (name + "=" + escape(value));
    if (seconds) {
        var date = new Date(new Date().getTime()+seconds*1000);
        cookie += ("; expires="+date.toGMTString());
    }
    cookie += (path    ? "; path="+path : "");
    document.cookie = cookie;
}
function delCookie(name, path) {
    var cookie = (name + "=");
    cookie += (path    ? "; path="+path : "");
    cookie += "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    document.cookie = cookie;
}

function addEvent(obj, event, func) {
    if (obj.addEventListener) { obj.addEventListener(event, func, false); }
    else if (obj.attachEvent) { obj.attachEvent("on"+event, func); }
}