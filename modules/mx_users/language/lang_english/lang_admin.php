<?php
/**
*
* @package MX-Publisher Module - mx_users
* @version $Id: lang_admin.php,v 1.6 2013/06/28 15:39:51 orynider Exp $
* @copyright (c) 2002-2008 [Adam Alkins (http://www.rasadam.com), Jon Ohlsson] MX-Publisher Project Team
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
*/

//
// adminCP index
//
$lang['phpbb2admin'] = 'Users and Groups';
$lang['1_phpbb2admin_Userlist'] = 'Users';
$lang['2_phpbb2admin_Groups'] = 'Groups';
$lang['3_Prune_Inactive_Users'] = 'Prune Users';
$lang['4_Prune_user_posts'] = 'Prune Posts';

//
// User Management
//
$lang['User_admin'] = 'User Administration';
$lang['User_admin_explain'] = 'Here you can change your users\' information and certain options. To modify the users\' permissions, please use the user and group permissions system.';

$lang['Look_up_user'] = 'Look up user';

$lang['Admin_user_fail'] = 'Couldn\'t update the user\'s profile.';
$lang['Admin_user_updated'] = 'The user\'s profile was successfully updated.';
$lang['Admin_user_added'] = 'The user has been added.';
$lang['Click_return_useradmin'] = 'Click %sHere%s to return to User Administration';

$lang['User_delete'] = 'Delete this user';
$lang['User_delete_explain'] = 'Click here to delete this user; this cannot be undone.';
$lang['User_deleted'] = 'User was successfully deleted.';

$lang['User_status'] = 'User is active';
$lang['User_allowpm'] = 'Can send Private Messages';
$lang['User_allowavatar'] = 'Can display avatar';

$lang['Admin_avatar_explain'] = 'Here you can see and delete the user\'s current avatar.';

$lang['User_special'] = 'Special admin-only fields';
$lang['User_special_explain'] = 'These fields are not able to be modified by the users.  Here you can set their status and other options that are not given to users.';

$lang['MX_user_is_admin'] = 'User is site admin';

//
// Group Management
//
$lang['Group_administration'] = 'Group Administration';
$lang['Group_admin_explain'] = 'From this panel you can administer all your usergroups. You can delete, create and edit existing groups. You may choose moderators, toggle open/closed group status and set the group name and description';
$lang['Error_updating_groups'] = 'There was an error while updating the groups';
$lang['Updated_group'] = 'The group was successfully updated';
$lang['Added_new_group'] = 'The new group was successfully created';
$lang['Deleted_group'] = 'The group was successfully deleted';
$lang['New_group'] = 'Create new group';
$lang['Edit_group'] = 'Edit group';
$lang['group_name'] = 'Group name';
$lang['group_description'] = 'Group description';
$lang['group_moderator'] = 'Group moderator';
$lang['group_status'] = 'Group status';
$lang['group_open'] = 'Open group';
$lang['group_closed'] = 'Closed group';
$lang['group_hidden'] = 'Hidden group';
$lang['group_delete'] = 'Delete group';
$lang['group_delete_check'] = 'Delete this group';
$lang['submit_group_changes'] = 'Submit Changes';
$lang['reset_group_changes'] = 'Reset Changes';
$lang['No_group_name'] = 'You must specify a name for this group';
$lang['No_group_moderator'] = 'You must specify a moderator for this group';
$lang['No_group_mode'] = 'You must specify a mode for this group, open or closed';
$lang['No_group_action'] = 'No action was specified';
$lang['delete_group_moderator'] = 'Delete the old group moderator?';
$lang['delete_moderator_explain'] = 'If you\'re changing the group moderator, check this box to remove the old moderator from the group.  Otherwise, do not check it, and the user will become a regular member of the group.';
$lang['Click_return_groupsadmin'] = 'Click %sHere%s to return to Group Administration.';
$lang['Select_group'] = 'Select a group';
$lang['Look_up_group'] = 'Manage group';
$lang['Look_up_groupcp'] = 'Group members';

//
// Admin Userlist
//
$lang['Userlist'] = 'User list';
$lang['Userlist_description'] = 'View a complete list of your users and perform various actions on them';

$lang['Add_group'] = 'Add to a Group';
$lang['Add_group_explain'] = 'Select which group to add the selected users to';

$lang['Open_close'] = 'Open/Close';
$lang['Active'] = 'Active';
$lang['Group'] = 'Group(s)';
$lang['Rank'] = 'Rank';
$lang['Last_activity'] = 'Last Activity';
$lang['Never'] = 'Never';
$lang['User_manage'] = 'Manage';
$lang['Find_all_posts'] = 'Find All Posts';

$lang['Select_one'] = 'Select One';
$lang['Ban'] = 'Ban';
$lang['Activate_deactivate'] = 'Activate/De-activate';

$lang['User_id'] = 'User id';
$lang['User_level'] = 'User Level';
$lang['Ascending'] = 'Ascending';
$lang['Descending'] = 'Descending';
$lang['Show'] = 'Show';
$lang['All'] = 'All';

$lang['Member'] = 'Member';
$lang['Pending'] = 'Pending';

$lang['Confirm_user_ban'] = 'Are you sure you want to ban the selected user(s)?';
$lang['Confirm_user_deleted'] = 'Are you sure you want to detele the selected user(s)?';

$lang['User_status_updated'] = 'User(s) status updated successfully!';
$lang['User_banned_successfully'] = 'User(s) banned successfully!';
$lang['User_deleted_successfully'] = 'User(s) deleted successfully!';
$lang['User_add_group_successfully'] = 'User(s) added to group successfully!';

$lang['Click_return_userlist'] = 'Click %shere%s to return to the User List';

//
// Pruning
//
$lang['Prune_user_posts'] = 'Prune User Posts';
$lang['Prune_explain'] = 'Welcome to the prune user posts Admin module addon for phpBB. This script allows you to prune posts based on a wide range of criteria.';
$lang['Forums_to_prune'] = 'Forums to Prune';
$lang['Forums_to_prune_explain'] = 'Check the box to prune posts in that forum. You can check multiple forums. (Note for large forums: You should only do a couple of forums at a time if you\'re pruning many posts)';
$lang['Users_to_prune'] = 'Users to Prune';
$lang['Username_explain'] = 'Prune posts made by this specific user';
$lang['All_users_explain'] = 'Prune posts by all users';
$lang['Banned_users'] = 'Banned users';
$lang['Banned_users_explain'] = 'Prune posts made by all users that have been banned (as per the banlist)';
$lang['Group'] = 'Group';
$lang['Group_explain'] = 'Prune posts made by users in this specific group';
$lang['IP_explain'] = 'Prune posts made by a specific ip address (xxx.xxx.xxx.xxx), wildcard (xxx.xxx.xxx.*) or range (xxx.xxx.xxx.xxx-yyy.yyy.yyy.yyy). Note: the last quad .255 is considered the range of all the IPs in that quad. If you enter 10.0.0.255, it is just like entering 10.0.0.* (No IP is assigned .255 for that matter, it is reserved). Where you may encounter this is in ranges, 10.0.0.5-10.0.0.255 is the same as "10.0.0.*" . You should really enter 10.0.0.5-10.0.0.254 .';
$lang['Banned_IPs'] = 'Banned IP Addresses';
$lang['Banned_IPs_explain'] = 'Prune posts made by all IPs in the banned list.';
$lang['Guest_posters'] = 'Guest Posters';
$lang['Guest_posters_explain'] = 'Prune posts made by guest posters only (Users not logged in).';
$lang['Date_criteria'] = 'Date Criteria';
$lang['Before'] = 'Before';
$lang['On'] = 'On';
$lang['After'] = 'After';
$lang['the_last'] = 'the last';
$lang['Seconds'] = 'Seconds';
$lang['Minutes'] = 'Minutes';
$lang['By_time_explain'] = 'Prune posts based on the above time. Please note only whole numbers are accepted, there is no reason to use decimals. (If you need .5 days, input 12 and select hours).';
$lang['ddmmyyyy'] = '(dd/mm/yyyy)';
$lang['Date_explain'] = 'Prune posts on above date criteria. Note dates are limited to roughly 1970 - 2038 (4 Bit unix timestamp limit)';
$lang['to'] = 'to';
$lang['Range_explain'] = 'Prune posts between both dates. Dates are subject to above limits.';
$lang['All_posts_explain'] = 'Prune all posts regardless of time.';
$lang['Pruning_options'] = 'Pruning Options';
$lang['Prune_remove_topics'] = 'Remove Topics by User(s)?';
$lang['Prune_remove_topics_explain'] = 'If the user(s) you selected started the topic and others have replied to the topic, would you like the entire topic removed?';
$lang['Exempt_stickies'] = 'Exempt Stickies?';
$lang['Exempt_stickies_explain'] = 'Do not prune posts in stickied topics.';
$lang['Exempt_announcements'] = 'Exempt Announcements?';
$lang['Exempt_announcements_explain'] = 'Do not prune posts in Announcements.';
$lang['Exempt_open'] = 'Exempt Open Topics?';
$lang['Exempt_open_explain'] = 'Do not prune posts in topics that are still open. (e.g. Select this as yes to prune locked topics only)';
$lang['Exempt_polls'] = 'Exempt Polls?';
$lang['Exempt_polls_explain'] = 'Do not prune posts in topics with Polls.';
$lang['Adjust_post_counts'] = 'Adjust Post Counts?';
$lang['Adjust_post_counts_explain'] = 'Update user\'s post counts to reflect posts that were deleted.';
$lang['Update_search'] = 'Update Search Tables?';
$lang['Update_search_explain'] = 'Whether posts should be removed from the search tables. If you select No, you will need to manually rebuild the search tables. You should only select No if you have a very large board on a very slow server pruning many posts.';

$lang['Prune_invalid_mode'] = 'Unable to Prune - Invalid mode';
$lang['Prune_invalid_IP'] = 'Invalid IP Address entered';
$lang['Prune_invalid_date'] = 'Invalid date entered.';
$lang['Prune_invalid_range'] = 'Invalid IP Range entered';
$lang['No_banned_IPs'] = 'There are no banned IP Addresses';
$lang['No_forums_selected'] = 'Unable to start pruning - No forums were selected';
$lang['Prune_no_posts'] = 'Unable to start pruning - No posts were found to prune';

$lang['Prune_finished'] = 'Pruning successfully completed.<br /><br />Return to the <a href="%s">Prune User Posts</a> page.<br /><br />Return to the <a href="%s">Admin Index</a>.';

//
// Prune Inactive Users by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
//
$lang['Click_return_userprune'] = 'Click %sHere%s to return to Prune Inactive Users';
$lang['Prune_users_page_title'] = 'Prune Inactive Users';
$lang['Prune_users_page_explain'] = 'This is a list of users fetched by the query you created. Select the users that you want to prune below and hit submit. If you would would like to notify the user that his account is inactive, click email on the user\'s row.';
$lang['Prune_users_Confirm_message'] = 'Are you sure you want to delete these users?';
$lang['Prune_users_Confirm_last_visit'] = 'Last Visit';
$lang['Prune_users_Confirm_select_all_none'] = 'Select All/None';
$lang['Prune_users_selected'] = 'Selected';
$lang['Never'] = 'Never';
$lang['All_Time'] = 'All Time';
$lang['Seven_days'] = 'Seven days ago';
$lang['Ten_days'] = 'Ten days ago';
$lang['Two_weeks'] = 'Two weeks ago';
$lang['One_month'] = 'One month ago';
$lang['Two_months'] = 'Two months ago';
$lang['Three_months'] = 'Three months ago';

$lang['Notify_user'] = 'Notify';
$lang['user_regdate'] = 'Registered';
$lang['user_active'] = 'Activated';
$lang['user_posts'] = 'Posts';
$lang['Prune_users_sql_explain'] = 'Build your search criteria using the form below.';
$lang['Build_Query'] = 'Build Query';
$lang['Build_Your_Query'] = 'Build your query';
$lang['last_visit_explain'] = 'Scan for users that have not logged in since the selected number of days ago. Use "Never" to find users that have never logged in.';
$lang['user_regdate_explain'] = 'Set a limit for the user registration dates. For example, if you use the "Active" check below, you might want to give users a few days to click their activation email first. The default limit is 7 days, meaning that users are given a 7 day window to complete thier registration before they are removed.';
$lang['user_active_explain'] = 'Use this option to mark users that have not activated their accounts, or that have become inactive for some other reason.';
$lang['user_posts_explain'] = 'Set a criteria for marking users based on post count. The most common setting is for "zero post" users.';
$lang['Your_account_is_inactive'] = 'Your account is inactive.';
?>