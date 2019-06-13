In includes/sessions/phpbb2/core.php

FIND

		//
		// Grab phpBB global variables, re-cache if necessary
		// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
		// - true: enable cache, false: disable cache
		$board_config = $this->obtain_phpbb_config(false);

REPLACE WITH

		if( @file_exists($phpbb_root_path . 'includes/class_config.' . $phpEx) && @file_exists($phpbb_root_path . 'includes/class_groups.' . $phpEx) )
		{
			include($mx_root_path . 'includes/mx_functions_ch.'.$phpEx);
		}
		else
		{
			//
			// Grab phpBB global variables, re-cache if necessary
			// - optional parameter to enable/disable cache for config data. If enabled, remember to refresh the MX-Publisher cache whenever updating phpBB config settings
			// - true: enable cache, false: disable cache
			$board_config = $this->obtain_phpbb_config(false);
		}