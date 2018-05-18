<?php
/**
 * Simple Machines Forum(SMF) Integration Hooks for SMF 2.0
 *
 * Use this to integrate your SMF version 2.0 forum with 3rd party software
 * If you need help using this script or integrating your forum with other
 * software, feel free to email andre@r2bconcepts.com
 *
 * @package   SMF 2.0 Integration Hooks
 * @author    Simple Machines http://www.simplemachines.org
 * @author    Andre Nickatina <andre@r2bconcepts.com>
 * @copyright 2011 Simple Machines
 * @link      http://www.simplemachines.org Simple Machines
 * @link      http://www.r2bconcepts.com Red2Black Concepts
 * @license   http://www.simplemachines.org/about/smf/license.php BSD
 * @version   0.1.1
 *
 * NOTICE OF LICENSE
 ***********************************************************************************
 * This file, and ONLY this file is released under the terms of the BSD License.   *
 *                                                                                 *
 * Redistribution and use in source and binary forms, with or without              *
 * modification, are permitted provided that the following conditions are met:     *
 *                                                                                 *
 * Redistributions of source code must retain the above copyright notice, this     *
 * list of conditions and the following disclaimer.                                *
 * Redistributions in binary form must reproduce the above copyright notice, this  *
 * list of conditions and the following disclaimer in the documentation and/or     *
 * other materials provided with the distribution.                                 *
 * Neither the name of Simple Machines LLC nor the names of its contributors may   *
 * be used to endorse or promote products derived from this software without       *
 * specific prior written permission.                                              *
 *                                                                                 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"     *
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE       *
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE      *
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE        *
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR             *
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE *
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)     *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT      *
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT   *
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. *
 **********************************************************************************/

/*
    This file includes functions that may help integration with other scripts
 	and programs. It defines several functions that are called
 	during SMF runtime. These functions are:
 	
    void smf_pre_load_function()
    - This hook is started immediately after the integrate_pre_include hook

    void smf_activate_function(string $username)
    - This hook is started in two instances.  Whenever the administrator approves
      members, each of those members' usernames is passed to the hook function
      for activation in the integrated system as well. The first instance is in
      the SMF admin panel, and the second is in the user profile
    
    void smf_change_member_data_function(array $memberNames, string $var, string $data)
    - This hook is started just before any changes are made to users profiles.
      It is started when an admin is changing multiple users in the admin panel,
      and also when a user is changing his own profile
      
    void smf_create_topic_function(array $msgOptions, array $topicOptions, array $posterOptions)
    - This hook is started right after a new topic post is entered into the SMF
      database. It passes all relevant posting information out to the integration
      hook function
    
	void smf_delete_member_function(int $id_member)
	- This hook is started just before a user is deleted from SMF
	
	void smf_exit_function(bool $do_footer && !WIRELESS)
	- This hook is started just before SMF exits. This hook is extremely important
      for true bridges, because in certain circumstances, the forum can becomes
      unwrapped from the integrated context without this hook. It will execute
      whatever code is in the hook function before exiting PHP
	
	string smf_fix_url_function(string $current_url)
	- This hook is started only in XML feeds. It expects a URL, and is expected
      to return an alternative URL based on the one passed to it
      
    void smf_load_theme_function()
    - This hook is started after SMF has defined its template layers, but before
      the template layers are used. It gives the integration a chance to alter
      the template layers before they are used
	
	void smf_login_function(string $user_settings['memberName'], string $_REQUEST['hash_passwrd'], int $modsettings['cookieTime'])
	- This hook is started after authentication in SMF, but before setting the SMF
      cookie. It's main use is setting the login cookie of an alternative system.
      Because the user is already authenticated in SMF at this point, there is
      very little need for further authentication checks
	
	void smf_logout_function(string $user_settings['memberName'])
	- This hook is started before the user entry is deleted from the SMF log
      online table, and the SMF cookie is dropped
	
	bool smf_outgoing_email_function(string $subject, string $message, string $headers)
	- This hook is started just before the output of the email is modified for sending.
      The message body is still plain text at this point
      
    void smf_output_error_function(string $message, string $error_type, int $error_level, string $file, int $line)
    - This hook is started after an error message is generated in SMF, but before
      SMF displays it
	
	void smf_personal_message_function(array $recipients, string $from['username'], string $subject, string $message)
	- This hook is started just before an SMF Personal Message is sent. It passes
      an array of recipients, the username of the sender, the subject, and the
      message body
	
	void smf_redirect_function(string $setLocation, bool $refresh)
	- This hook is started just before SMF redirects after a form submission.
      To avoid resubmission of form data, SMF uses its own redirect system. The
      $setLocation variable will be the URL to which to redirect, and the $refresh
      variable is a boolean determining whether a page refresh should be done
      after loading
	
	void smf_register_function(array $regOptions, array $theme_vars)
	- This hook is started just before a user is entered into SMF. It is one of the
      more powerful integration hooks, passing all necessary variables in an array
      for use in the integrated system
	
	void smf_reset_pass_function(string $old_username, string $new_username, string $password)
	- This hook is started only when a username or password is changed in SMF

	bool smf_validate_login_function(string $_REQUEST['user'], string $_REQUEST['hash_passwrd'], int $modsettings['cookieTime'])
	- This hook is started before checking for a valid SMF user on login. This
      gives the integrated application a chance to use the login credentials
      before SMF does. Something to keep in mind is that SMF hashes the password
      in SHA1 on the client side, so an unhashed password is not available to
      this function. A value of true or false returned from the function will
      continue as normal, and a value of 'retry' will redisplay the login form,
      with the message "Password security has recently been upgraded. Please login again."
	
    bool smf_verify_password_function(string $username, string $password)
    - This hook is started only when sensitive information may be getting changed.
      It is called when a user is changing his email address, and when an admin is
      using the SMF admin panel.  It validates the username and password against
      the integrated system before proceeding.  SMF expects a value of true if the
      authentication passes, and false if it fails

    int smf_verify_user_function()
    - This hook is started before checking the SMF cookie for a valid user.
      A valid SMF $ID_MEMBER is expected back from the hook function, or SMF
      will assume it should check the SMF cookie instead
    
    array smf_whos_online_function(array $actions)
    - This hook is started during the process of figuring out what each user is
      doing for the Whos online list. It expects text back depending on the
      variables in the query string of the page the user is viewing, which should
      all be passed in the $actions array
      
    array smf_session_save_function()
    - Not a hook, just a function to save your SMF session data and shut down the
      SMF session
      
    void smf_session_restore_function()
    - Not a hook. Use to reopen an SMF session (if you ended it) before your function ends.
      I just restores the $_SESSION variables and calls loadSession; might be unneccessary
 	
*/

//define the integration functions, comment out the ones you don't need
define('SMF_INTEGRATION_SETTINGS',
    serialize( array(
        /*
          This is the very first integration hook encountered in the workflow.
          It is started immediately after the loading of the SMF settings.
          So, if you need to include some scripting at the beginning of SMF,
          this can be done with this hook in a separate file, without any need
          for modifying the SMF code
        */
    //  'integrate_pre_include'        => 'somefile.php',
    //
    //   Hook Name                         Function Name (defined below)
        'integrate_pre_load'           => 'smf_pre_load_function',
        'integrate_activate'           => 'smf_activate_function',
	    'integrate_change_member_data' => 'smf_change_member_data_function',
	    'integrate_create_topic'       => 'smf_create_topic_function',
	    'integrate_delete_member'      => 'smf_delete_member_function',
	    'integrate_exit'               => 'smf_exit_function',
	    'integrate_fix_url'            => 'smf_fix_url_function',
        'integrate_load_theme'         => 'smf_load_theme_function',
	    'integrate_login'              => 'smf_login_function',
	    'integrate_logout'             => 'smf_logout_function',
	    'integrate_outgoing_email'     => 'smf_outgoing_email_function',
	    'integrate_personal_message'   => 'smf_personal_message_function',
	    'integrate_redirect'           => 'smf_redirect_function',
	    'integrate_register'           => 'smf_register_function',
	    'integrate_reset_pass'         => 'smf_reset_pass_function',
	    'integrate_validate_login'     => 'smf_validate_login_function',
        'integrate_verify_password'    => 'smf_verify_password_function',
        'integrate_verify_user'        => 'smf_verify_user_function',
        'integrate_whos_online'        => 'smf_whos_online_function',
    ))
);

/**
 * Pre load
 *
 * This hook is started immediately after the integrate_pre_include hook.
 * It serves much of the same type of purpose, but it calls a function rather
 * than including a file.
 *
 * Example of use: Modifying SMF settings to match those of an integrated system.
 *
 * @access       public
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_pre_load_function()
{
}

/**
 * Activate new member
 *
 * This hook is started in two instances. Whenever the administrator approves
 * members, each of those members' usernames is passed to the hook function for
 * activation in the integrated system as well. The first instance is in the
 * SMF admin panel, and the second is in the user profile.
 *
 * Example of use: A user has registered, and is awaiting admin approval of his
 * account to use both SMF and the integrated application.
 *
 * @access       public
 * @param        string $username the username of the member to activate
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_activate_function($username)
{
}

/**
 * Change member data
 *
 * This hook is started just before any changes are made to users profiles.
 * It is started when an admin is changing multiple users in the admin panel,
 * and also when a user is changing his own profile.
 * The $var array is similar to the $regOptions array in the integrate_register
 * hook. It contains all of the key names for the fields to be changed. The $data
 * array will contain the associated values for those keys.
 *
 * Example of use: A user changes his profile information, and that information
 * needs to be passed to the integrated system.
 *
 * @access       public
 * @param        int || int array $memberNames the member id(s) to be updated
 * @param        string $var the member data column to be updated ex. 'gender'
 * @param        string $data the data to be changed
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_change_member_data_function($memberNames, $var, $data)
{
}

/**
 * Create topic
 *
 * This hook is started right after a new topic post is entered into the SMF
 * database. It passes all relevant posting information out to the integration
 * hook function.
 *
 * Example of use: The forum has a "News" board, and all new topics posted in
 * that board are also news articles on the front page of a CMS.
 *
 * @access       public
 * @param        array $msgOptions
 * @param        array $topicOptions
 * @param        array $posterOptions
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_create_topic_function($msgOptions, $topicOptions, $posterOptions)
{
}

/**
 * Delete member
 *
 * This hook is started just before a user is deleted from SMF.
 *
 * Example of use: A user has deleted his account, or the admin has deleted a
 * user's account, and the account needs to be deleted in the integrated system
 * as well.
 *
 * @access       public
 * @param        int $id_member the member id
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_delete_member_function($id_member)
{
}

/**
 * Exit SMF
 *
 * This hook is started just before SMF exits. This hook is extremely important
 * for true bridges, because in certain circumstances, the forum can becomes
 * unwrapped from the integrated context without this hook. It will execute
 * whatever code is in the hook function before exiting PHP.
 *
 * Example of use: SMF is wrapped in a CMS, and the CMS needs to finish off its
 * execution before exit.
 *
 * @access       public
 * @param        bool $do_footer && !WIRELESS
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_exit_function($do_footer)
{
}

/**
 * Fix url
 *
 * This hook is started only in XML feeds. It expects a URL, and is expected to
 * return an alternative URL based on the one passed to it.
 *
 * Example of use: SMF is wrapped in a CMS, and the URL of the wrapped CMS needs
 * to appear in outgoing RSS feeds.
 *
 * @access       public
 * @param        string $currentUrl the current url
 * @return       string the modified url
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_fix_url_function($currentUrl)
{
}

/**
 * Load theme
 *
 * This hook is started after SMF has defined its template layers, but before
 * the template layers are used. It gives the integration a chance to alter the
 * template layers before they are used.
 *
 * Example of use: The forum is wrapped in a CMS, so the HTML headers need to
 * be omitted to remain W3C compliant.
 *
 * @access       public
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_load_theme_function()
{
}

/**
 * Login member
 *
 * This hook is started after authentication in SMF, but before setting the SMF
 * cookie. It's main use is setting the login cookie of an alternative system.
 * Because the user is already authenticated in SMF at this point, there is very
 * little need for further authentication checks.
 *
 * Example of use: A user has logged into SMF, and should also be logged into
 * the integrated system at the same time.
 *
 * @access       public
 * @param        string $memberName the members' SMF username
 * @param        string $hash_password the password already hashed
 * @param        string $cookieTime ($modsettings['cookieTime'])
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_login_function($memberName, $hash_password, $cookieTime)
{
}

/**
 * Logout member
 *
 * This hook is started before the user entry is deleted from the SMF log online
 * table, and the SMF cookie is dropped.
 *
 * Example of use: A user has logged out of SMF, and should also be logged out
 * of the integrated system at the same time.
 *
 * @access       public
 * @param        string $memberName the members' SMF username
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_logout_function($memberName)
{
}

/**
 * Outgoing email
 *
 * This hook is started just before the output of the email is modified for
 * sending. The message body is still plain text at this point.
 *
 * Example of use: The forum is wrapped in a CMS, so all of the URLs in outgoing
 * emails need to be rewritten to point to the CMS.
 *
 * @access       public
 * @param        string $subject the message subject
 * @param        string $message the message body (plain text)
 * @param        string $headers the email headers
 * @return       bool (false will cancel sending)
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_outgoing_email_function($subject, $message, $headers)
{
}

/**
 * Personal message
 *
 * This hook is started just before an SMF Personal Message is sent. It passes
 * an array of recipients, the username of the sender, the subject, and the
 * message body.
 *
 * Example of use: A user sends a PM, and that PM should appear in the integrated
 * system as well as SMF's PM system.
 *
 * @access       public
 * @param        array $recipients the usernames of the recipients
 * @param        string $from the username of the sender
 * @param        string $subject the personal message subject
 * @param        string $message the personal message
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_personal_message_function($recipients, $from, $subject, $message)
{
}

/**
 * Redirect
 *
 * This hook is started just before SMF redirects after a form submission. To
 * avoid resubmission of form data, SMF uses its own redirect system. The
 * $setLocation variable will be the URL to which to redirect, and the $refresh
 * variable is a boolean determining whether a page refresh should be done after
 * loading.
 *
 * Example of use: Similarly to the integrate_outgoing_email function above,
 * this can be used to rewrite redirection URLs back to a wrapped CMS page.
 *
 * @access       public
 * @param        string $setLocation the url to redirect to
 * @param        bool $refresh whether a page refresh should be done after loading
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_redirect_function($setLocation, $refresh)
{
}

/**
 * Register new member
 *
 * This hook is started just before a user is entered into SMF. It is one of the
 * more powerful integration hooks, passing all necessary variables in an array
 * for use in the integrated system.
 *
 * The $regOptions array by default will contain the following keys:
 *   memberName
 *   emailAddress
 *   passwd (SHA1 hash)
 *   passwordSalt
 *   posts
 *   dateRegistered
 *   memberIP
 *   memberIP2
 *   validation_code
 *   realName
 *   personalText
 *   pm_email_notify
 *   ID_THEME
 *   ID_POST_GROUP
 *
 * It is important to note that all text values will already be enclosed in single
 * quotes for ease of use in queries. More fields are available, and more are
 * added with the addition of mods like the Custom Profile Fields mod.
 *
 * Example of use: A user has registered in SMF, or an admin has created a user
 * in the SMF admin panel, and the user needs to be created in the integrated
 * system as well.
 *
 * @access       public
 * @param        array $regOptions the registration options (shown above)
 * @param        array $theme_vars the theme variables
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_register_function($regOptions, $theme_vars)
{
}

/**
 * Change username or password
 *
 * This hook is started only when a username or password is changed in SMF.
 *
 * Example of use: A user changes his password, so the password also needs to
 * change in the integrated system.
 *
 * @access       public
 * @param        type [$varname] description
 * @return       type description
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_reset_pass_function($oldUsername, $newUsername, $password)
{
}

/**
 * Validate login
 *
 * This hook is started before checking for a valid SMF user on login. This gives
 * the integrated application a chance to use the login credentials before SMF
 * does. Something to keep in mind is that SMF hashes the password in SHA1 on
 * the client side, so an unhashed password is not available to this function.
 *
 * A value of true or false returned from the function will continue as normal,
 * and a value of 'retry' will redisplay the login form, with the message
 * "Password security has recently been upgraded.  Please login again."
 *
 * Example of use: A user that exists in the integrated application but not in
 * SMF is attempting to login, so needs to be migrated to SMF before SMF has
 * a chance to authenticate. Something to keep in mind here is that SMF can
 * authenticate with many other types of hashes, so the hashed passwords of
 * other systems can typically be written directly to the SMF members table,
 * with the hook returning 'retry', which will automatically invoke SMF to
 * rewrite to its own hash on the second login attempt.
 *
 * @access       public
 * @param        string $username ($_REQUEST['user']) the members' username
 * @param        string $hash_password ($_REQUEST['hash_passwrd'])
 * @param        int $cookieTime ($modsettings['cookieTime'])
 * @return       bool || string 'retry'
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_validate_login_function($username, $hash_password, $cookieTime)
{
}

/**
 * Verify password in integrated system
 *
 * This hook is started only when sensitive information may be getting changed.
 * It is called when a user is changing his email address, and when an admin is
 * using the SMF admin panel. It validates the username and password against the
 * integrated system before proceeding. SMF expects a value of true if the
 * authentication passes, and false if it fails.
 *
 * Example of use: You want an added layer of security to authenticate user
 * changes and SMF admin panel access.
 *
 * @access       public
 * @param        string $username the members' username
 * @param        string $password this might be plain text OR SHA1 hashed depending
 *               on where it's called from. Use strlen($password) == 40 to check I guess
 * @return       bool whether the login passes the integrated systems' authentication
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_verify_password_function()
{
}

/**
 * Verify user
 *
 * This hook is started before checking the SMF cookie for a valid user. A valid
 * SMF $ID_MEMBER is expected back from the hook function, or SMF will assume
 * it should check the SMF cookie instead.
 *
 * Example of use: User is logged into a CMS, but not into SMF, so we want to
 * auto-login to SMF without the SMF cookie.
 *
 * @access       public
 * @return       int $id_member a valid SMF member id
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_verify_user_function()
{
}

/**
 * Who's online
 *
 * This hook is started during the process of figuring out what each user is doing
 * for the Whos Online list. It expects text back depending on the variables in
 * the query string of the page the user is viewing, which should all be passed
 * in the $actions array.
 *
 * Example of use: A user is accessing a page in an integrated system, and that
 * page should be reported correctly in the Whos online.
 *
 * @access       public
 * @param        array $actions the actions being performed
 * @return       array $data the corresponding results to display in Who's Online list
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_whos_online_function($actions)
{
}

/**
 * Session save and close
 *
 * This function was designed to save your SMF session data and end the session.
 * It will store the saved session information in an array it returns. This way
 * you can stop your session and use your integrated system, which might require
 * it's own session, or mess with the SMF session. You can use the session restore
 * function afterwards to restore the saved session data.
 *
 * Example of use: Your integrated system requires a session and you don't want
 * your SMF session to screw it up or vice versa. You use this function to save
 * your SMF session and restore it after you finish manipulating the other system.
 *
 * @access       public
 * @return       array $data the session data
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_session_save_function()
{
    $data = array();
    $data['SESSION']         = $_SESSION;

    //just in case
    $sessionId               = session_id();
    $sessionName             = session_name();
    $cookieParams            = session_get_cookie_params();
    $sessionSavePath         = session_save_path();
    $data['sessionId']       = $sessionId;
    $data['sessionName']     = $sessionName;
    $data['cookieParams']    = $cookieParams;
    $data['sessionSavePath'] = $sessionSavePath;

    //kill it
    if ('' != session_id()) {
        session_write_close();
    }

    $_SESSION = array();
    unset($_SESSION);

    return $data;
}

/**
 * Session restore
 *
 * This function was designed to restore your SMF session data.
 *
 * Example of use: You're done manipulating your integrated system and now you
 * want to restore SMF's session and get back to business as usual without any
 * session verification errors or dropped session/lost data
 *
 * @access       public
 * @param        array $data the session data to restore
 * @return       void
 * @link         http://www.r2bconcepts.com Red2Black Concepts
 * @since        0.1.0
 */
function smf_session_restore_function($data=array())
{
    //make sure our other session is closed now
    if ('' != session_id()) {
        session_write_close();
    }
    //put everything back where we found it
    session_set_cookie_params($data['cookieParams']['lifetime'], $data['cookieParams']['path'], $data['cookieParams']['domain'], $data['cookieParams']['secure'], $data['cookieParams']['httponly']);
    session_save_path($data['sessionSavePath']);
    session_name($data['sessionName']);
    session_id($data['sessionId']);
    session_set_save_handler('sessionOpen', 'sessionClose', 'sessionRead', 'sessionWrite', 'sessionDestroy', 'sessionGC');
    //resume the session
    session_start();

    //put the session variables back
    $_SESSION = $data['SESSION'];

    //restore php.ini settings and hopefully fix anything we missed
    loadSession();
}

?>
