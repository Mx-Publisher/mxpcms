<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: lang_main.php,v 1.3 2010/10/16 04:06:54 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

//
// RFC2616 - Hypertext Transfer Protocol -- HTTP/1.1
// Status Code Definitions
// http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10
//

//
// ErrorDocs v.1.0.0
//
$lang['ErrorDocs_Title'] = "HTTP Fel %s: %s";
$lang['ErrorDocs_Referer'] = "Du hänvisades från <a href=\"%1\$s\">%1\$s</a>";
$lang['ErrorDocs_ChkRequ'] = "Vänligen kontrollera din adress.";
$lang['ErrorDocs_Logged'] = "Notera: Felet har loggats för senare analys.";
$lang['ErrorDocs_MoreInfo'] = "Mer information om HTTP-felkoder:";

$lang['ErrorDocs_400_499'] = "Klientfel, anropet var fel på något sätt.";
$lang['ErrorDocs_500_599'] = "Serverfel, servern kunde inte utföra åtgärden.";

$lang['ErrorDocs_Error'][0]['short'] = "Okänd";
$lang['ErrorDocs_Error'][0]['long'] = "Servern skickade ett okänt felmeddelande. Detta beteende är förmodligen tillfälligt. Försök igen senare.<br />Kontrollera att du angav en giltig adress.";

//
// Client Errors...
//
$lang['ErrorDocs_Error'][400]['short'] = "Felaktigt anrop";
$lang['ErrorDocs_Error'][400]['long'] = "Din webbläsare skickade en felformaterad Host Header (fel syntax) eller så förstod inte servern anropet.<br />Du uppmnanas att inte fortsätta anropa på detta sätt.";
$lang['ErrorDocs_Error'][401]['short'] = "Inte tillåten";
$lang['ErrorDocs_Error'][401]['long'] = "Du saknar rättigheter att utföra detta anrop.";
$lang['ErrorDocs_Error'][402]['short'] = "Payment Required";
$lang['ErrorDocs_Error'][402]['long'] = "This code is reserved for future use.";
$lang['ErrorDocs_Error'][403]['short'] = "Förbjuden";
$lang['ErrorDocs_Error'][403]['long'] = "The server understood the request, but is refusing to fulfill it. The request is forbidden because of some unknown reason.<br />You shouldn't access this resource again.";
$lang['ErrorDocs_Error'][404]['short'] = "Hittades inte :(";
$lang['ErrorDocs_Error'][404]['long'] = "Sidan hittades inte. Detta kan bero på ett tillfälligt fel. Försök igen senare.<br />Kontrollera att du angav en giltig adress.";
$lang['ErrorDocs_Error'][405]['short'] = "Method Not Allowed";
$lang['ErrorDocs_Error'][405]['long'] = "The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.";
$lang['ErrorDocs_Error'][406]['short'] = "Not Acceptable";
$lang['ErrorDocs_Error'][406]['long'] = "The resource identified by the request is only capable of generating response entities which have content characteristics not acceptable according to the accept headers sent in the request.";
$lang['ErrorDocs_Error'][407]['short'] = "Proxy Authentication Required";
$lang['ErrorDocs_Error'][407]['long'] = "The client must first authenticate itself with the proxy.";
$lang['ErrorDocs_Error'][408]['short'] = "Request Timeout";
$lang['ErrorDocs_Error'][408]['long'] = "The client did not produce a request within the time that the server was prepared to wait. The client MAY repeat the request without modifications at any later time.";
$lang['ErrorDocs_Error'][409]['short'] = "Conflict";
$lang['ErrorDocs_Error'][409]['long'] = "The request could not be completed due to a conflict with the current state of the resource.";
$lang['ErrorDocs_Error'][410]['short'] = "Gone";
$lang['ErrorDocs_Error'][410]['long'] = "The requested resource is no longer available at the server and no forwarding address is known. This condition is expected to be considered permanent.";
$lang['ErrorDocs_Error'][411]['short'] = "Length Required";
$lang['ErrorDocs_Error'][411]['long'] = "The server refuses to accept the request without a defined Content- Length. The client MAY repeat the request if it adds a valid Content-Length header field containing the length of the message-body in the request message.";
$lang['ErrorDocs_Error'][412]['short'] = "Precondition Failed";
$lang['ErrorDocs_Error'][412]['long'] = "The precondition given in one or more of the request-header fields evaluated to false when it was tested on the server.";
$lang['ErrorDocs_Error'][413]['short'] = "Request Entity Too Large";
$lang['ErrorDocs_Error'][413]['long'] = "The server is refusing to process a request because the request entity is larger than the server is willing or able to process.";
$lang['ErrorDocs_Error'][414]['short'] = "Request-URI Too Long";
$lang['ErrorDocs_Error'][414]['long'] = "The server is refusing to service the request because the Request-URI is longer than the server is willing to interpret.";
$lang['ErrorDocs_Error'][415]['short'] = "Unsupported Media Type";
$lang['ErrorDocs_Error'][415]['long'] = "The server is refusing to service the request because the entity of the request is in a format not supported by the requested resource for the requested method.";
$lang['ErrorDocs_Error'][416]['short'] = "Requested Range Not Satisfiable";
$lang['ErrorDocs_Error'][416]['long'] = "None of the range-specifier values in this field overlap the current extent of the selected resource, and the request did not include an If-Range request-header field.";
$lang['ErrorDocs_Error'][417]['short'] = "Expectation Failed";
$lang['ErrorDocs_Error'][417]['long'] = "The expectation given in an Expect request-header field could not be met by this server, or, if the server is a proxy, the server has unambiguous evidence that the request could not be met by the next-hop server.";

//
// Server Errors...
//
$lang['ErrorDocs_Error'][500]['short'] = "Internal Server Error";
$lang['ErrorDocs_Error'][500]['long'] = "The server encountered an unexpected condition which prevented it from fulfilling the request.";
$lang['ErrorDocs_Error'][501]['short'] = "Not Implemented";
$lang['ErrorDocs_Error'][501]['long'] = "The server does not support the functionality required to fulfill the request. This is the appropriate response when the server does not recognize the request method and is not capable of supporting it for any resource.";
$lang['ErrorDocs_Error'][502]['short'] = "Bad Gateway";
$lang['ErrorDocs_Error'][502]['long'] = "The server, while acting as a gateway or proxy, received an invalid response from the upstream server it accessed in attempting to fulfill the request.";
$lang['ErrorDocs_Error'][503]['short'] = "Service Unavailable";
$lang['ErrorDocs_Error'][503]['long'] = "The server is currently unable to handle the request due to a temporary overloading or maintenance of the server.";
$lang['ErrorDocs_Error'][504]['short'] = "Gateway Timeout";
$lang['ErrorDocs_Error'][504]['long'] = "The server, while acting as a gateway or proxy, did not receive a timely response from the upstream server specified by the URI (e.g. HTTP, FTP, LDAP) or some other auxiliary server (e.g. DNS) it needed to access in attempting to complete the request.";
$lang['ErrorDocs_Error'][505]['short'] = "HTTP Version Not Supported";
$lang['ErrorDocs_Error'][505]['long'] = "The server does not support, or refuses to support, the HTTP protocol version that was used in the request message.";

//
// That's all Folks!
// -------------------------------------------------
?>