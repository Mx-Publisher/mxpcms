// Forms, some help functions.
// Author: Cezary Tomczak [www.gosu.pl]

// submit button must have name "submit" to get this working
window.onload = function() {
    document.forms[0].onsubmit = function() {
        if (!document.forms[0].submit.disabled) {
            document.forms[0].submit.disabled = true;
            return true;
        }
        return false;
    };
};

function isNumber(s) {
    if (s.length && s.charAt(0) == "-") { return isNumber(s.substr(1)); }
    if (!(/^[\d.]+$/.test(s))) { return false; }
    if (s.indexOf(".") != -1 && (s.indexOf(".") != s.lastIndexOf("."))) { return false; }
    if (s.charAt(0) == ".") { return false; }
    if (s.length >= 2 && s.charAt(0) == "0" && s.charAt(1) != ".") { return false; }
    return !isNaN(s);
}