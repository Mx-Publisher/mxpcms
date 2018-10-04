/**
*
* @package MX-Publisher Module - Core
* @version $Id: readme.txt,v 1.1 2010/09/13 07:54:47 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/********************************************************************************\
| Installation Instructions
\********************************************************************************/

Note: In order for this module to install you must have a working Core installation.


#
#-----[ OPEN ]------------------------------------------
#

index.php

#
#-----[ FIND ]------------------------------------------
#

//
// Output header
//
include( $mx_root_path . 'includes/page_header.' . $phpEx );

#
#-----[ REPLACE WITH ]------------------------------------------
#

//
// Output header
//
include( $mx_root_path . 'includes/page_header.' . $phpEx );

//
// - AutoIndexer Check
//
// Check if autoindex storage directory acess
//
if ($mx_request_vars->is_get('dir'))
{
	$autoindex_root_path = $mx_root_path . "storage/";
	
	$forward_to = $_SERVER['QUERY_STRING'];

	if( preg_match("/^dir=([a-z0-9\.#\/\?&=\+\-_]+)/si", $forward_to, $forward_matches) )
	{
		$forward_to = ( !empty($forward_matches[3]) ) ? $forward_matches[3] : $forward_matches[1];
		$forward_match = explode('&', $forward_to);

		if(count($forward_match) > 1)
		{
			for($i = 1; $i < count($forward_match); $i++)
			{
				if( !ereg("sid=", $forward_match[$i]) )
				{
					if( $forward_page != '' )
					{
						$forward_page .= '&';
					}
					$forward_page .= $forward_match[$i];
				}
			}
			$forward_page = $forward_match[0] . '?' . $forward_page;
		}
		else
		{
			$forward_page = $forward_match[0];
		}
	}
	$forward_to = $forward_page ? "?dir=".$forward_page : '';
	mx_redirect(mx_append_sid($autoindex_root_path."index.$phpEx".$forward_to, false), 'Storage folders request', 'Click %sHere%s to acces requested storage folders.');
}
//
// - AutoIndexer Check
//

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM


/********************************************************************************\
| Portal Setup
\********************************************************************************/

** By default, dir storage urls are redirected to portal storage folder.


/********************************************************************************\
|	End Of Document
\********************************************************************************/