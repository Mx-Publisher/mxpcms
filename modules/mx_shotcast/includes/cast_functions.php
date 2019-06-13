<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: cast_functions.php,v 1.1 2013/05/28 07:14:34 orynider Exp $
* @copyright (c) 2006-2013 Little Frog, FlorinCB [aka OryNider], drknas 
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
// History:
// Little Frog (v 1.x - 2.x)
// OryNider (v 1.x - 3.x)
// DrKnas (Current maintainer v 4.0 -)
// OryNider (v 4.2 - 5.0-dev)

if( !defined('IN_PORTAL') )
{
	die("Hacking attempt");
}

if (!function_exists('obj_to_array'))
{

function asc2hex($temp)
{
	$data = "";
	$len = @strlen($temp);
	for ($i = 0; $i < $len; $i++) $data .= sprintf("%02x", ord(substr($temp, $i, 1)));
	return $data;
}

function check($temp)
{
	$data = "";
	$len = strlen($temp);
	for ($i = 0; $i < $len; $i+=2) $data .= chr(hexdec(substr($temp, $i, 2)));
	return $data;
}

function clean_string($text)
{
	// Control characters
   $text = preg_replace("/[^[:space:]a-zA-Z0-9åäöÅÄÖ.,-:]/", " ", $text);
   $text = preg_replace("/[^[:space:]a-zA-Z0-9îãâºþÎÃÂªÞ.,-:]/", " ", $text);

	// we need to reduce multiple spaces to a single one   
   $text = preg_replace('/\s+/', ' ', $text);
   
	// we can use trim here as all the other space characters should have been turned
	// into normal ASCII spaces by now   
   return trim($text);
}

function clean_string_alpha_num($string)
{
	//For compatibility
	return clean_string($string);
}

function curl_file_get_contents($url)
{
	if(!function_exists('curl_exec'))
	{
		return false;
	}
	$c = curl_init();
	@curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	//echo curl_getinfo($c, CURLINFO_HTTP_CODE);
	@curl_setopt($c, CURLOPT_URL, $url);
	$contents = curl_exec($c);
	$err = curl_error($c);
	////die("$url");
	@curl_close($c);
	if ($contents)
	{
		return $contents;
	}
	else
	{
		return false;
	}			
}

function obj_to_array($obj)
{
	$array = (@is_object($obj)) ? (array)$obj : $obj;
	foreach($array as $k=>$v)
	{
		if(@is_object($v) OR @is_array($v))	$array[$k] = obj_to_array($v);
	}
	return $array;
}

function file_get_contents_utf8($fn) 
{ 
    $opts = array( 
        'http' => array( 
            'method'=>"GET", 
            'header'=>"Content-Type: text/html; charset=utf-8",
			'timeout' => 60			
        ) 
    );
    $context = stream_context_create($opts); 
    $result = file_get_contents($fn, false, $context); 
    return $result; 
}

function title_sitename($domain) 
{
	$domaintmp = explode(".", $domain);
	$y = count($domaintmp) - 1;
	$r = "";
	for ($a = 0; $y > $a; $a++) 
	{
		$r .= $domaintmp[$a].".";
	}
	$r = str_replace("http://", "", $r);
	return $r;
}
function title_sitesufix($domain) 
{
	$domaintmp = explode(".", $domain);

	$y = count($domaintmp) - 1;
	$r = $domaintmp[$y];
	$r = str_replace("/", "", $r);	
	return $r;
}
//get website url of the current song title if such...
function song_siteInfo($artist, $song, $default_value, $getInfo = 'url_picture') 
{
	static $a_www, $s_www;
	$a_www = explode("www.", $artist);
	//$a_www = !empty($a_www[1]) ? explode("http://", $song) : $a_www;
	$a_www = empty($a_www[1]) ? explode(".org", $artist) : $a_www;
	$a_www = empty($a_www[1]) ? explode(".com", $artist) : $a_www;	
	$s_www = explode("www.", $song);
	//$s_www = !empty($s_www[1]) ? explode("http://", $song) : $s_www;
	$s_www = empty($s_www[1]) ? explode(".org", $song) : $s_www;
	$s_www = empty($s_www[1]) ? explode(".com", $song) : $s_www;	
    if (!empty($a_www[1]))
    {
		$url_info = "http://".title_sitename($artist).title_sitesufix($artist)."/";
		$url_picture = $url_info."favicon.ico";
		//$url_picture = $default_value;		
    }
    elseif (!empty($s_www[1]))
    {
		$url_info = "http://".title_sitename($song).title_sitesufix($song)."/";
		$url_picture = $url_info."favicon.ico";
		//$url_picture = $default_value;
    }
    else
    {
		$url_info = $default_value;
		$url_picture = $default_value;
    }	
	return $$getInfo;
}
//get information of the current song title use amazone's API
function aws_signed_request($params, $title, $curl)
{
	static $response, $request;
    $method = "GET";
    $host = "ecs.amazonaws.com";
    $uri = "/onca/xml";
    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = "0ZYCZQTQW9GRW4AY2602";
    $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
    $params["Version"] = "2013-05-16";
    ksort($params);
    $canonicalized_query = array();
    foreach ($params as $param=>$value)
    {
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
    }
    $canonicalized_query = implode("&", $canonicalized_query);
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, "LFpXAmTy+mZjDWISXr7bGkTVMapgrgUorRKEUOin", True));
    $signature = str_replace("%7E", "~", rawurlencode($signature));
    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
	
	if($curl == "yes")
	{
		$response = curl_file_get_contents($request);		
	}	
    $response = @file_get_contents($request);
	/*
 	if(!$response)
	{
		$fp = @fsockopen($host, 80, $errno, $errstr, 5);	
		@fputs($fp,"GET /".$uri."?".$canonicalized_query."&Signature=".$signature." HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
		while(!feof($fp))
		{
			$response .= fgets($fp, 1000);
		}
		$response = substr($response, 7);
		$response = substr($response, 0, strlen($response) - 6);		
	}   
	*/
    if ($response === false)
    {
        return false;
    }
    else
    {
        $parsed_xml = @simplexml_load_string($response);
        if ($parsed_xml === false)
        {
            return false;
        }
        else
        {
			//print_r($parsed_xml);
            return $parsed_xml;
        }
    }
}
// Get image thingy by drknas...
function aws_search_album($params, $title, $curl)
{
	static $response, $request;
    $method = "GET";
    $host = "ecs.amazonaws.com";
    $uri = "/onca/xml";
    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = "0ZYCZQTQW9GRW4AY2602";
    $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
    $params["Version"] = "2013-05-16";
    ksort($params);
    $canonicalized_query = array();
    foreach ($params as $param=>$value)
    {
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
    }
    $canonicalized_query = implode("&", $canonicalized_query);
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, "LFpXAmTy+mZjDWISXr7bGkTVMapgrgUorRKEUOin", true));
    $signature = str_replace("%7E", "~", rawurlencode($signature));
    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
	
	if($curl == "yes")
	{
		$response = curl_file_get_contents($request);		
	}	
    if ($response === false)
    {
		$response = @file_get_contents($request);
    }
    if ($response === false)
    {
		$canonicalized_query = "Service=AWSECommerceService&AWSAccessKeyId=0ZYCZQTQW9GRW4AY2602&AssociateTag=knas-20&Operation=ItemSearch&ResponseGroup=Medium,Offers&SearchIndex=Music&Keywords=".$title."&ItemPage=";		
		$fp = @fsockopen($host, 80, $errno, $errstr, 5);
		if($fp)
		{		
			@fputs($fp,"GET /".$uri."?".$canonicalized_query." HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
			while(!feof($fp))
			{
				$response .= fgets($fp, 1000);
			}
			$response = substr($response, 7);
			$response = substr($response, 0, strlen($response) - 6);			
		}
    }	
    if ($response === false)
    {
        return false;
    }
    else
    {
        $parsed_xml = @simplexml_load_string($response);
        if ($parsed_xml === false)
        {
            return false;
        }
        else
        {
			//print_r($parsed_xml);
            return $parsed_xml;
        }
    }	
}
function aws_get_wanted_data($parsed_xml)
{	
	$numOfItems = $parsed_xml->Items->TotalResults;
	$wanted_data = array();
	if($numOfItems > 0)
	{
		$first = $parsed_xml->Items->Item[0];
		$wanted_data[0] = $first->SmallImage->URL;
		$wanted_data[1] = $first->DetailPageURL;
		return $wanted_data;
	}
	if($numOfItems < 1)
	{
		return false;
	}
}
//get information of the current song use amazone's API by Ory (but yet put here only for refrence)
function aws_searchInfo($artist, $song, $title, $getInfo = 'url_picture', $url_picture = 'nochange', $search = 'DigitalMusic')
{
	static $url_info, $album_url;
	global $curl;
	$parsed_xml = $url_picture; 
	$parsed_xml = aws_signed_request(array("AssociateTag"=>"knas-20","Operation"=>"ItemSearch","SearchIndex"=>$search,"ResponseGroup"=>"Medium,Offers","Keywords"=>clean_string_alpha_num($title)), $title, $curl);
	$data = @is_object($parsed_xml) ? aws_get_wanted_data($parsed_xml) : "";			
	if(is_array($data))
	{
		$url_picture = $data[0];
		$url_info = $data[1];
	}
	else
	{	
		return $default;
	}		
	return $$getInfo;
}
//get information of the current song use last.fm's API
function aws_getInfo($artist, $song, $method = 'track', $getInfo = 'url_picture', $default = 'nochange')
{
	static $image_s, $album_url, $request;
	global $curl, $skininfo; 
    $host = "http://ws.audioscrobbler.com";
    $uri = "/2.0/";
    $api_keyId = "470df9d6f46d4c28d221483ffdcf6062";
	$request = str_replace('#','', $host.$uri.'?method=track.getInfo&api_key='.$api_keyId.'&artist='.urlencode($artist).'&track='.urlencode($song));
	
	$xml = @simplexml_load_file($request, 'SimpleXMLElement', LIBXML_NOCDATA);
	//print_r($xml);
	if (!is_object($xml))
	{	
		return $default;
	}
	$xml = obj_to_array($xml);
	if (!is_array($xml))
	{	
		return $default;
	}	
	if(!empty($xml[$method]['album']['image']))
	{
		//Picture size taken from skin configuration; Valid values are: 0 for small; 1 for medium; 2 for large; and 3 for eXtrem large;
		$skininfo['image'] = !empty($skininfo['image']) ? $skininfo['image'] : 0;	
		$skinimage = $xml[$method]['album']['image'][$skininfo['image']];
	}
	if(!empty($xml[$method]['wiki']['summary']))
	{
		$wikisummary = $xml[$method]['wiki']['summary'];
		$wikicontent = $xml[$method]['wiki']['content'];
	}
	if(!empty($xml[$method]['album']['title']))
	{
		$album_title = $xml[$method]['album']['title'];
		$album_url = $xml[$method]['album']['url'];
	}
	$lastfm_url = $xml[$method]['url'];
	if(!empty($xml[$method]['artist']['url']))
	{
		$artist_url = $xml[$method]['artist']['url'];
	}
	$url_picture = !empty($skinimage) ? $skinimage : $default;
	$url_info = !empty($album_url) ? $album_url : $default;	
	return $$getInfo;
}

}

?>