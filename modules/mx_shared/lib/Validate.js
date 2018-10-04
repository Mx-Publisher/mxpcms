/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   js libs
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl
 * LICENSE:   BSD (revised)
 */
 
// +----------------------------------------------------------------+
// | Some useful functions for string validation.                   |
// | Author: Cezary Tomczak [www.gosu.pl]                           |
// | Free for any use as long as all copyright messages are intact. |
// +----------------------------------------------------------------+

/* yyyy-mm-dd */
function isDate(s) {
    if (!(/^\d{4,4}-\d{2,2}-\d{2,2}$/.test(s))) { return false; }
    var a = s.split("-");
    var d = new Date(a[0], Number(a[1])-1, a[2]);
    d = [d.getFullYear().toString(), (d.getMonth()+1).toString(), d.getDate().toString()];
    if (!d[0].length || !d[1].length || !d[2].length) { return false; }
    if (d[1].length == 1) { d[1] = "0"+d[1]; }
    if (d[2].length == 1) { d[2] = "0"+d[2]; }
    return a[0] == d[0] && a[1] == d[1] && a[2] == d[2];
}
/* hh:mm:ss */
function isHour(s) {
    if (!(/^\d{2,2}:\d{2,2}:\d{2,2}$/.test(s))) { return false; }
    var a = s.split(":");
    a[0] = Number(a[0]);
    a[1] = Number(a[1]);
    a[2] = Number(a[2]);
    return a[0] >= 0 && a[0] <= 23 &&
        a[1] >= 0 && a[1] <= 59 &&
        a[2] >= 0 && a[2] <= 59;
}
/* yyyy-mm-dd hh:mm:ss */
function isDateIso(s) {
    if (!(/^\d{4,4}-\d{2,2}-\d{2,2} \d{2,2}:\d{2,2}:\d{2,2}$/.test(s))) { return false; }
    var a = s.split(" ");
    return isDate(a[0]) && isHour(a[1]);
}
/* ignore whitespace */
function isEmpty(s) {
    return !Boolean(s.replace(/^\s*|\s*$/g, "").length);
}
/* ignore whitespace */
function isNonEmpty(s) {
    return Boolean(s.replace(/^\s*|\s*$/g, "").length);
}
/* -0.01, 10, 10.45 - ok
   01, 00.1, .1, 0.0.0 - bad */
function isNumber(s) {
    if (s.length && s.charAt(0) == "-") { return isNumber(s.substr(1)); }
    if (!(/^[\d.]+$/.test(s))) { return false; }
    if (s.indexOf(".") != -1 && (s.indexOf(".") != s.lastIndexOf("."))) { return false; }
    if (s.charAt(0) == ".") { return false; }
    if (s.length >= 2 && s.charAt(0) == "0" && s.charAt(1) != ".") { return false; }
    return !isNaN(s);
}
function isEmail(s) {
    return (/^\w+@\w+\.[\w.]+$/.test(s) && s.charAt(s.length-1) != ".");
}
/* isHttpAddress("gosu.pl") - true
   isHttpAddress("www.gosu.pl") - true
   isHttpAddress("www.gosu.pl", 1) - false
   isHttpAddress("https://gosu.pl", 1) - true */
function isHttpAddress(s, full) {
    if (full) {
        return (/^http(s)?:\/\/(www\.)?\w+\.[\w.]+$/.test(s) && s.charAt(s.length-1) != ".");
    } else {
        return (/^(http(s)?:\/\/)?(www\.)?\w+\.[\w.]+$/.test(s) && s.charAt(s.length-1) != ".");
    }
}
/* checkSize("12", 4, 16) - true
   checkSize("12", null, 16) - true
   checkSize("12", 4, null) - true
   checkSize("12", 13) - false */
function checkSize(s, min, max) {
    var n = Number(s);
    if (typeof min == "number") {
        if (n < min) { return false; }
    }
    if (typeof max == "number") {
        if (n > max) { return false; }
    }
    return true;
}
/* checkLength("abcdef", 4, 9) - true
   checkLength("abcdef", null, 9) - true
   checkLength("abcdef", 4, null) - true
   checkLength("abcdef", null, 5) - false */
function checkLength(s, min, max) {
    if (typeof min == "number") {
        if (s.length < min) { return false; }
    }
    if (typeof max == "number") {
        if (s.length > max) { return false; }
    }
    return true;
}
/* round("12.567", 0) == "13"
   round("12.567", 1) == "12.6"
   round("12.567", 2) == "12.57"
   round("12.565", 2) == "12.56" */
function round(s, n) {
    return String(Number(s).toFixed(n));
}
function isPesel(pesel) {
    if (pesel.length != 11 || !(/^\d+$/.test(pesel))) { return false; }
    var steps = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
    var sum_nb = 0, sum_m, sum_c;
    for (var x = 0; x < 10; ++x) {
        sum_nb += steps[x] * pesel[x];
    }
    sum_m = 10 - sum_nb % 10;
    if (sum_m == 10) { sum_c = 0; }
    else { sum_c = sum_m; }
    return (sum_c == pesel[10]);
}
function isRegon(regon) {
    var steps = [8, 9, 2, 3, 4, 5, 6, 7];
    regon = regon.replace(/-/g, "");
    regon = regon.replace(/ /g, "");
    if (regon.length != 9) { return false; }
    var sum_nb = 0, sum_m;
    for (var x = 0; x < 8; ++x) {
        sum_nb += steps[x] * regon[x];
    }
    sum_m = sum_nb % 11;
    if (sum_m == 10) { sum_m = 0; }
    return (sum_m == regon[8]);
}
function isNip(nip) {
    var steps = [6, 5, 7, 2, 3, 4, 5, 6, 7];
    nip = nip.replace(/-/g, "");
    nip = nip.replace(/ /g, "");
    if (nip.length != 10) { return false; }
    var sum_nb = 0, sum_m;
    for (var x = 0; x < 9; ++x) {
        sum_nb += steps[x] * nip[x];
    }
    sum_m = sum_nb % 11;
    if (sum_m == 10) { sum_m = 0; }
    return (sum_m == nip[9]);
}