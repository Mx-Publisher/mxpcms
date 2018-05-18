/**
*
* @package MX-Publisher Module - mx_phpbb
* @version $Id: readme.txt,v 1.2 2010/10/16 04:06:36 orynider Exp $
* @copyright (c) 2002-2006 [Markus, Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
*
*/

/********************************************************************************\
| Installation Instructions
\********************************************************************************/

Note: In order for this module to install you must have a working phpBB and mxBB installation.
phpbbroot refers to where your phpBB2 install is located, e.g in phpBB2/ or forum/


#
#-----[ OPEN ]------------------------------------------
#

phpbbroot/common.php

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ REPLACE WITH ]------------------------------------------
#

//+mxp
if( !defined('IN_ADMIN') )
{
	$mx_root_path = './../';
	if ((@include_once $mx_root_path . "modules/mx_phpbb/includes/forum_hack.$phpEx") === false)
	{
		die("Forum Integration (mx_phpbb) " . $mx_root_path . "modules/mx_phpbb/includes/forum_hack.$phpEx couldn't be opened.<br /> Please check if \$mx_root_path is defined correct.");
	}
}
//-mxp

?>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM


/********************************************************************************\
| Portal Setup
\********************************************************************************/

** Now, add the newly created mx_phpbb Block to a relevant portal page
and remove, the now redundant mx_forum block.

** By default, native phpBB urls are redirected to portal page 2. Visit the module adminCP for customization.


/********************************************************************************\
|	End Of Document
\********************************************************************************/