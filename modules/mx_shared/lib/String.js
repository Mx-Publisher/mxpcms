/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   js libs
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl
 * LICENSE:   BSD (revised)
 */
 
/* Strip whitespace from the beginning and end of a string  */
String.prototype.trim = function() {
    return this.replace(/^\s*|\s*$/g, "");
};

/* Strip whitespace from the beginning of a string */
String.prototype.ltrim = function() {
    return this.replace(/^\s*/g, "");
};

/* Strip whitespace from the end of a string */
String.prototype.rtrim = function() {
    return this.replace(/\s*$/g, "");
};

/* Count the number of substring occurrences */
String.prototype.substrCount = function(s) {
    return this.split(s).length - 1;
};

/* Check if string is an alphanumeric character */
String.prototype.isAlpha = function() {
    return (/^[a-z]$/i.test(this));
};

/* Check if string is a digit */
String.prototype.isDigit = function() {
    return (/^\d$/.test(this));
};

/* Check if string is numeric */
String.prototype.isNumeric = function() {
    return (/^\d+$/.test(this));
};

/*
 * Replace ? tokens with variables passed as arguments in a string.
 * When you are joining many strings with variables, this is a good way to keep the code clean
 * Examples:
 * var s = '<div id="'+id+'" class="'+className+'">'+innerText+'</div>';
 * var s = '<div id="?" class="?">?</div>'.format(id, className, innerText);
 */
String.prototype.format = function() {
    if (!arguments.length) { throw "String.format() failed, no arguments passed, this = "+this; }
    var tokens = this.split("?");
    if (arguments.length != (tokens.length - 1)) { throw "String.format() failed, tokens != arguments, this = "+this; }
    var s = tokens[0];
    for (var i = 0; i < arguments.length; ++i) {
        s += (arguments[i] + tokens[i + 1]);
    }
    return s;
};

/* Repeat string n times */
String.prototype.repeat = function(n) {
    var ret = "";
    for (var i = 0; i < n; ++i) {
        ret += this;
    }
    return ret;
};