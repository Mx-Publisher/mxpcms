<?php
/*
	COPYRIGHT 2012 Damien Keitel
		
	This file is part of Facebook For PhpBB Light.

    Facebook For PhpBB Light is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Facebook For PhpBB Light is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Facebook For PhpBB Light.  If not, see <http://www.gnu.org/licenses/>.*/

/**
* DO NOT CHANGE
*/
class ucp_fb4phpbb_light_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_fb4phpbb_light',
			'title'		=> 'UCP_FB4PHPBB_LIGHT',
			'version'	=> '1.0.1a',
			'modes'		=> array(
				'fb4phpbb_light'			=> array('title' => 'UCP_FB4PHPBB_LIGHT_FACEBOOK', 'auth' => '', 'cat' => array('UCP_FB4PHPBB_LIGHT')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>