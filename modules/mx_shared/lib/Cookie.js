/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   js libs
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl
 * LICENSE:   BSD (revised)
 */
 
/*
    examples:
    
    1) set cookie for an hour
    var c = new Cookie();
    c.set("test", "abc", 3600);
    
    2) delete cookie
    c.del("test");

    3) get cookie
    var test = c.get("test");

    Dependencies: String.trim()
*/
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
    this.set = function(name, value, seconds, path, domain, secure) {
        var cookie = (name + "=" + escape(value));
        if (seconds) {
            var date = new Date(new Date().getTime()+seconds*1000);
            cookie += ("; expires="+date.toGMTString());
        }
        cookie += (path    ? "; path="+path : "");
        cookie += (domain  ? "; domain="+domain : "");
        cookie += (secure  ? "; secure" : "");
        document.cookie = cookie;
    };
    this.del = function(name) {
        document.cookie = name + "=; expires=Thu, 01-Jan-70 00:00:01 GMT";
    };
}