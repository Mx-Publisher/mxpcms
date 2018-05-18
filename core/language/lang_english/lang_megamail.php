<?php

/***************************************************************************
 *                            lang_megamail.php 
 *                              -------------------
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
$lang['Megamail_Explain'] = 'Here you can email a message to either all of your users, or all users of a specific group.  To do this, an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. <br />
This modified script will send the emails in several batches. This should circumvent timeout and server-load issues. The status of the mass mail sending will be saved in the db. You can close the window, when you want to pause mass-mail-sending (the current batch will be sent out). You can later simply continue where you left off.';
$lang['megamail_header'] = 'Your Email-Sessions';
$lang['megamail_id'] = 'Mail-ID';
$lang['megamail_batchstart'] = 'Processed';
$lang['megamail_batchsize'] = 'Mails per Batch';
$lang['megamail_batchwait'] = 'Pause';
$lang['megamail_created_message'] = 'The Mass Mail has been saved to the database.<br /><br/> To start sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['megamail_send_message'] = 'The Current Batch (%s - %s) has been sent .<br /><br/> To continue sending %sclick here%s or wait until the Meta-Refresh takes you there...';
$lang['megamail_status'] = 'Status';
$lang['megamail_proceed'] = '%sProceed now%s';
$lang['megamail_done'] = 'DONE';
$lang['megamail_none'] = 'No records were found.';

?>