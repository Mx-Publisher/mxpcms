/********************************************************************************\
|
|	subject				: mxBB-Portal, CMS & portal, module
|	name				: mx_counter
|	begin            		: January, 2007
|	copyright			: (C) 2002-2007 mxBB
|	mxBB project site		: www.mx-publisher.com
|
|	author				: OryNider (see additional credit below)
|	author site			: http://pubory.uv.ro/
|	author email           		: orynider@rdslink.ro
|
|	additional credit		: Some ideeas of this module are originaly based on the
|					  [ABD] Counter MOD by Andareed (and_a_reed@hotmail.com)
|
|	description			: This module / block basically,
|					  it is a graphical counter, but integrates into mxBB.
|					  It integrates into the AdminCP, and options like digit lengh,
|					  digit image locations, and counter value can be modified.
|					  It also uses a cookie, so that only truly unique visitors are counted.
|					  The original MOD used a counter.dat file to store the informations,
|					  this version uses the database to do that, more then that
|					  this module uses normal template files instead of just echo.
|
|********************************************************************************|
|
|   @package mxBB Portal Module - mx_phpCA
|   @version $Id: readme.txt,v 1.2 2008/06/03 20:09:34 jonohlsson Exp $
|   @copyright (c) 2002-2007 [OryNider] mxBB Development Team
|   @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
|
\********************************************************************************/

/********************************************************************************\
|	Installation Instructions
\********************************************************************************/

Note:  In order for this module to install you must have a working phpBB and mxBB
	installation.

1)	Copy the folder:
		mx_counter
	into your:
		{mxBB install}\modules\
	folder on your web server.

2)	From your website enter mxBB Admin Control Panel.

3)	Under mxBB-Portal click on Management.

4)	Now click on Modules Setup.

5)	Under Module Administration use the pull down menu and choose:
		mx_counter

6)	Press the Install Module button

7)	If you have followed the instructions correctly you should now be able to
	create Mx Counter blocks for inclusion on your pages.

8)	chmod 777 upload/chasers/, upload/images/ and upload/payments/

/********************************************************************************\
|	End Of Document
\********************************************************************************/