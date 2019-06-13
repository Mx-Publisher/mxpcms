<?php
/**
*
* @package StandAllone - Radiplayer.
* @version $Id: cd_cover_getter.php,v 1.1 2013/05/28 07:14:34 orynider Exp $
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

// Get image thingy by drknas...
function Search_Album($params, $title, $curl)
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
            return $parsed_xml;
        }
    }	
}

function get_wanted_data($parsed_xml)
{	
	$numOfItems = $parsed_xml->Items->TotalResults;
	if($numOfItems > 0)
	{
		$first = $parsed_xml->Items->Item[0];
		$wanted_data[] = $first->SmallImage->URL;
		$wanted_data[] = $first->DetailPageURL;
		return $wanted_data;
	}
	if($numOfItems < 1)
	{
		return false;
	}
}
?>