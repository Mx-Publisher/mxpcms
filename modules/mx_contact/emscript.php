<?php
/*
SELECT user_email
    FROM phpbb_users
    INTO OUTFILE '/email.csv'
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
*/	
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('viewforum');

$sql = " SELECT `user_email` FROM " . USERS_TABLE . "";

$result = $db->sql_query($sql);

$file = "./store/email.txt";

if(!file_exists($file))
{
    touch($file);
}

$method = 0;

while ($row = $db->sql_fetchrow($result))
{
    if(!Empty($row['user_email']))
    {
    $email = $row['user_email']."\n";
    if($method == 0)
    {
    $open = fopen($file, 'w') or die('can not open file');
    fwrite($open, $email) or die('can not write to file');
    fclose($open);
    }
    else 
    {
    $open = fopen($file, 'a') or die('can not open file');
    fputs($open, $email) or die('can not add to file');
    fclose($open);    
    }
    $method++;
    }
    else 
    {
        continue;
    }
}

$db->sql_freeresult($result);

?>
