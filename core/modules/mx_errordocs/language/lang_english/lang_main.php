<?php
/**
*
* @package MX-Publisher Module - mx_errordocs
* @version $Id: lang_main.php,v 1.3 2010/10/16 04:06:53 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://www.MX-Publisher.com
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
$lang['ErrorDocs_Title'] = "HTTP Error %s: %s";
$lang['ErrorDocs_Referer'] = "You were referred from <a href=\"%1\$s\">%1\$s</a>";
$lang['ErrorDocs_ChkRequ'] = "Please, check your request for typing errors and retry.";
$lang['ErrorDocs_Logged'] = "Note: Information on this error event has been logged for later analysis.";
$lang['ErrorDocs_MoreInfo'] = "More Information on HTTP Error Codes:";

$lang['ErrorDocs_400_499'] = "Client Error, the request was invalid in some way.";
$lang['ErrorDocs_500_599'] = "Server Error, the server could not fulfil the (valid) request.";

$lang['ErrorDocs_Error'][0]['short'] = "Unknown";
$lang['ErrorDocs_Error'][0]['long'] = "The server response is sending an unknown error code. This condition may be temporary. You may try again later.<br />The address you entered or link you followed may have been mistyped. You may try retyping the address.";

//
// Client Errors...
//
$lang['ErrorDocs_Error'][400]['short'] = "Bad Request";
$lang['ErrorDocs_Error'][400]['long'] = "Your browser sent a request with a malformed Host Header bad syntax or that this server could not understand it.<br />You are discouraged from repeating the request without modification.";
$lang['ErrorDocs_Error'][401]['short'] = "Unauthorized";
$lang['ErrorDocs_Error'][401]['long'] = "The request requires user authentication.";
$lang['ErrorDocs_Error'][402]['short'] = "Payment Required";
$lang['ErrorDocs_Error'][402]['long'] = "This code is reserved for future use.";
$lang['ErrorDocs_Error'][403]['short'] = "Forbidden";
$lang['ErrorDocs_Error'][403]['long'] = "The server understood the request, but is refusing to fulfill it. The request is forbidden because of some unknown reason.<br />You shouldn't access this resource again.";
$lang['ErrorDocs_Error'][404]['short'] = "Not Found";
$lang['ErrorDocs_Error'][404]['long'] = "The server has not found any resources matching the Request-URI. This condition may be temporary. You may try again later.<br />The address you entered or link you followed may have been mistyped. You may try retyping the address.";
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