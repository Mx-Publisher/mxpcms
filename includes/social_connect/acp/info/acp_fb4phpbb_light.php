<?php
/*
	COPYRIGHT 2009 Michael J Goonawardena
		
	This file is part of ConSof Alternate Login.

    ConSof Alternate Login is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    ConSof Alternate Login is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ConSof Alternate Login.  If not, see <http://www.gnu.org/licenses/>.*/

class acp_fb4phpbb_light_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_fb4phpbb_light',
			'title'		=> 'ACP_FB4PHPBB_LIGHT',
			'version'	=> '1.0.1a',
			'modes'		=> array(
				'fb4phpbb_light'		=> array('title' => 'ACP_FB4PHPBB_LIGHT_SETTINGS', 'auth' => 'acl_a_user', 'cat' => array('ACP_CAT_USERS')),
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