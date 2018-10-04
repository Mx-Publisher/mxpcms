/*
 * MX-Publisher - common js
 */
 
function newImage(arg) {
	if (document.images) {
		rslt = new Image();
		rslt.src = arg;
		return rslt;
	}
}

function changeImages() {
	if (document.images ) {
		for (var i=0; i<changeImages.arguments.length; i+=2) {
			document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
		}
	}
}

function full_img(url) {
	var url = url;
	window.open(url,'','scrollbars=1,toolbar=0,resizable=1,menubar=0,directories=0,status=0, width=img.width, height=img.height');
	return;
}

function getCookie(name)
{
	var cookies = document.cookie;
	var start = cookies.indexOf(name + '=');
	if( start < 0 ) return null;
	var len = start + name.length + 1;
	var end = cookies.indexOf(';', len);
	if( end < 0 ) end = cookies.length;
	return unescape(cookies.substring(len, end));
}

function setCookie(name, value, expires, path, domain, secure)
{
	document.cookie = name + '=' + escape (value) +
		((expires) ? '; expires=' + ( (expires == 'never') ? 'Thu, 31-Dec-2099 23:59:59 GMT' : expires.toGMTString() ) : '') +
		((path)    ? '; path='    + path    : '') +
		((domain)  ? '; domain='  + domain  : '') +
		((secure)  ? '; secure' : '');
}

function delCookie(name, path, domain)
{
	if( getCookie(name) )
	{
		document.cookie = name + '=;expires=Thu, 01-Jan-1970 00:00:01 GMT' +
			((path)    ? '; path='    + path    : '') +
			((domain)  ? '; domain='  + domain  : '');
	}
}

function set_mx_cookie(in_listID, status)
{
    var expDate = new Date();
    // expires in 1 year
    expDate.setTime(expDate.getTime() + 31536000000);
    document.cookie = in_listID + "=" + escape(status) + "; expires=" + expDate.toGMTString();
}

function set_phpbb_cookie(cookieName, cookieValue, lifeTime, path, domain, isSecure)
{
    var expDate = new Date();
    // expires in 1 year
    expDate.setTime(expDate.getTime() + 31536000000);

	document.cookie = escape( cookieName ) + "=" + escape( cookieValue ) + 
		";expires=" + expDate.toGMTString() +
		( path ? ";path=" + path : "") + ( domain ? ";domain=" + domain : "") + 
		( isSecure == 1 ? ";secure" : "");
}