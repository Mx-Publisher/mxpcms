<?php
/**
* @package Facebook For PhpBB Light
* @copyright (c) 2012 Damien Keitel
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

//Don't load hook if not installed.
if (!isset($config['fb4phpbb_light_version']))
{
	return;
}
function fb4phpbb_light_not_current_user()
{
    global $cache, $db, $auth, $template, $config, $user, $phpEx, $phpbb_root_path;
    if (!class_exists('Facebook'))
    {
        include($phpbb_root_path . 'fb4phpbb_light/facebook_app/facebook.' . $phpEx);
    }
    $facebook = new Facebook(array(
        'appId'  => $config['fb4phpbb_light_appid'],
        'secret' => $config['fb4phpbb_light_secret'],
    ));
    $fb_me = $facebook->getUser();
    $sql = 'SELECT user_id
    FROM ' . USERS_TABLE
    . " WHERE user_fb4phpbb_light_fb_uid='$fb_me'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);
    $true = ($row['user_id'] !== $user->data['user_id']) ? true : false;	
    return $true;
}

function find_jquery()
{
    global $user;
    $not_found = true;
    $string = 'styles/' . rawurlencode($user->theme['theme_path']) . '/template/overall_header.html';

    $doc = new DOMDocument();
    @$doc->loadHTMLFile($string);

    $tags = $doc->getElementsByTagName('script');

    foreach ($tags as $tag) 
    {
        $attr = $tag->getAttribute('src');      
        if (preg_match('#jquery#is', $attr))
        { 
            $not_found =  false;
        }
    }
    return $not_found;
}

function find_jquery_ui()
{
    global $user;
    $not_found = true;
    $string = 'styles/' . rawurlencode($user->theme['theme_path']) . '/template/overall_header.html';

    $doc = new DOMDocument();
    @$doc->loadHTMLFile($string);

    $tags = $doc->getElementsByTagName('script');

    foreach ($tags as $tag) 
    {
        $attr = $tag->getAttribute('src');      
        if (preg_match('#jquery-ui#is', $attr))
        { 
            $not_found = false;
        }
    }
    return $not_found;
}

function fb4phpbb_light_init($appid, $lang) 
{
    global $cache, $db, $auth, $template, $config, $user;
    $user->add_lang('mods/fb4phpbb_light');
    $fbinit = '<div id="fb-root"></div>
        <style>
        #fblogin
        {    
            background: url("https://s-static.ak.fbcdn.net/images/connect_sprite.png") no-repeat scroll left -188px #29447E;
            display: inline-block;
            line-height: 14px;
            outline: medium none;
            padding: 0 0 0 1px;
        }
        #fblogin a
        {
            cursor: pointer;
            display: block;
            text-decoration:none;
            font-size: 11px;
            font-weight: bold;
            margin: 1px 1px 0 21px;
            padding: 2px 6px 3px;        
            background: url("https://s-static.ak.fbcdn.net/images/connect_sprite.png") repeat scroll 0 0 #5F78AB;
            text-decoration:none !important;
            color: #eeeeee !important;
            border-bottom: 1px solid #1A356E;
            border-top: 1px solid #879AC0;            
            -webkit-transition: color .06s ease-out; /* Saf3.2+, Chrome */
            -moz-transition: color .06s ease-out; /* Firefox 4+ */
            -ms-transition: color .06s ease-out; /* IE10+ */
            -o-transition: color .06s ease-out; /* Opera 10.5+ */
            transition: color .06s ease-out;
            -webkit-transition: border .06s ease-out; /* Saf3.2+, Chrome */
            -moz-transition: border .06s ease-out; /* Firefox 4+ */
            -ms-transition: border .06s ease-out; /* IE10+ */
            -o-transition: border .06s ease-out; /* Opera 10.5+ */
            transition: border .06s ease-out;
        }
        #fblogin a:focus, #fblogin a:hover 
        {
            color: #FFFFFF !important;
            text-decoration:none !important;
            border-bottom: 1px solid #879AC0;
            border-top: 1px solid #1A356E;
        }
        </style>
    
        <script>
        window.fbAsyncInit = function() 
        {
            FB.init(
            { 
                appId  : ' . $appid . ', 
                channelUrl : \''. generate_board_url() . '/language/' . $user->data['user_lang'] . '/channel.html\', // Channel File
                status : true, // check login status 
                cookie : true, // enable cookies to allow the server to access the session 
                xfbml  : true,  // parse XFBML
                oauth  : true, 
            });';
    $fbinit .= 'FB.getLoginStatus(function(response) 
            {';
    $fbinit .= ($user->data['user_id'] == ANONYMOUS || fb4phpbb_light_not_current_user() === true) ? '
                if (response.status === \'not_authorized\') 
                {
                    jQuery(\'.fb_button_text\').text("' . $user->lang['FACEBOOK_CREATE'] . '");
                }
                else if(response.status === \'connected\')
                {

                }':'';
    $fbinit .='
            });
        };               
        (function(d)
        {
            var js, id = \'facebook-jssdk\'; if (d.getElementById(id)) {return;}
            js = d.createElement(\'script\'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/'. $lang . '/all.js";
            d.getElementsByTagName(\'head\')[0].appendChild(js);
        }(document));              
    </script>';
    return $fbinit;
}
?>