<?php
/***************************************************************************
 *                            lang_main.php [Hebrew]
 *                              -------------------
 *     begin                   : Sat Dec 16 2000
 *     copyright             : (C) 2001 The phpBB Group
 *     translation            :תורגם על ידי אתר ה phpBBHebrew - phpBBheb.com
 *     email                   : support@phpbb.com
 *
 *     $Id: lang_main.php,v 1.85.2.15 2003/06/10 00:31:19 psotfx Exp $
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

//
// CONTRIBUTORS:
//	 Add your details here if wanted, e.g. Name, username, email address, website
// 2002-08-27  Philip M. White        - fixed many grammar problems
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = "utf-8"; //"iso-8859-8-I";
$lang['DIRECTION'] = "Rtl";
$lang['LEFT'] = "right";
$lang['RIGHT'] = "left";
$lang['DATE_FORMAT'] =  "d/m/Y ב- H:i:s"; // This should be changed to the default date format for your language, php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
$lang['TRANSLATION'] = '<a href="http://www.phpbbheb.com" target="_blank">תורגם על ידי צוות </a> גירסה 1.0.20';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = "פורום";
$lang['Category'] = "קטגוריה";
$lang['Topic'] = "נושא";
$lang['Topics'] = "נושאים";
$lang['Replies'] = "תגובות";
$lang['Views'] = "צפיות";
$lang['Post'] = "הודעה";
$lang['Posts'] = "הודעות";
$lang['Posted'] = "נשלח";
$lang['Username'] = "שם משתמש";
$lang['Password'] = "סיסמה";
$lang['Email'] = "דואר אלקטרוני";
$lang['Poster'] = "שולח";
$lang['Author'] = "מחבר";
$lang['Time'] = "זמן";
$lang['Hours'] = "שעות";
$lang['Message'] = "הודעה";

$lang['1_Day'] = "יום אחד";
$lang['7_Days'] = "שבעה ימים";
$lang['2_Weeks'] = "שבועיים";
$lang['1_Month'] = "חודש אחד";
$lang['3_Months'] = "שלושה חודשים";
$lang['6_Months'] = "חצי שנה";
$lang['1_Year'] = "שנה";

$lang['Go'] = "עבור";
$lang['Jump_to'] = "עבור";
$lang['Submit'] = "שליחה";
$lang['Reset'] = "איפוס";
$lang['Cancel'] = "ביטול";
$lang['Preview'] = "תצוגה מקדימה";
$lang['Confirm'] = "אישור";
$lang['Spellcheck'] = "בדיקת איות";
$lang['Yes'] = "כן";
$lang['No'] = "לא";
$lang['Enabled'] = "פעיל";
$lang['Disabled'] = "לא פעיל";
$lang['Error'] = "שגיאה";

/* ------------------------------------------------- */
$lang['Goto_page'] = 'מעבר לדף';
$lang['Post_by_author'] = 'על ידי';
$lang['Posted_on_date'] = 'בתאריך';
$lang['In'] = 'ב';

$lang['Statistics'] = 'סטטיסטיקות';
$lang['Legend'] = 'מקרא';
$lang['Posted_articles_zero_total'] = "המשתמשים בפורום לא שלחו אף הודעה"; // Number of posts
$lang['Posted_articles_total'] = "המשתמשים בפורום שלחו בסך הכל <b>%d</b> הודעות"; // Number of posts
$lang['Posted_article_total'] = "המשתמשים בפורום שלחו הודעה אחת בלבד"; // Number of posts
$lang['Registered_users_zero_total'] = "אין משתמשים רשומים במערכת"; // # registered users
$lang['Registered_users_total'] = "בקהילה יש <b>%d</b> משתמשים רשומים"; // # registered users
$lang['Registered_user_total'] = "בקהילה יש משתמש <b>אחד</b> רשום"; // # registered users
$lang['Newest_user'] = "המשתמש החדש ביותר בקהילה הוא:: <b>%s%s%s</b>"; // a href, username, /a

$lang['Rules_moderate'] = "אתה <b>יכול</b> %sלנהל פורום זה%s"; // %s replaced by a href links, do not remove! 

$lang['Quick_mod'] = 'Quick-mod tools:';

$lang['Search_forums'] = 'Search within';
// ------------------------------------------------- */

$lang['Next'] = "הבא";
$lang['Previous'] = "הקודם";
$lang['Goto_page'] = "עבור לעמוד";
$lang['Joined'] = "הצטרף בתאריך";
$lang['IP_Address'] = "כתובת IP";

$lang['Select_forum'] = "בחר פורום";
$lang['View_latest_post'] = "צפה בהודעה האחרונה";
$lang['View_newest_post'] = "צפה בהודעה החדשה ביותר";
$lang['Page_of'] = "עמוד <b>%d</b> מתוך <b>%d</b>"; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = "מספר ICQ";
$lang['AIM'] = "AIM";
$lang['MSNM'] = "MSN Messenger";
$lang['YIM'] = "Yahoo! Messenger";
$lang['Forum_Index'] = "עמוד ראשי";  // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = "שליחת הודעה חדשה";
$lang['Reply_to_topic'] = "תגובה להודעה";
$lang['Reply_with_quote'] = "תגובה עם ציטוט";

$lang['Click_return_topic'] = "לחץ %sכאן%s כדי לחזור להודעה"; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = "לחץ %sכאן%s כדי לנסות שוב";
$lang['Click_return_forum'] = "לחץ %sכאן%s כדי לחזור לפורום";
$lang['Click_view_message'] = "לחץ %sכאן%s כדי לראות את הודעתך";
$lang['Click_return_modcp'] = "לחץ %sכאן%s כדי לחזור ללוח הבקרה למנהלים";
$lang['Click_return_group'] = "לחץ %sכאן%s כדי לחזור לעמוד המידע על קבוצות משתמשים";

$lang['Admin_panel'] = "עבור ללוח הבקרה למנהלים";

$lang['Board_disable'] = "לא ניתן להיכנס לפורומים. אנא נסה מאוחר יותר";


//
// Global Header strings
//
$lang['Registered_users'] = "משתמשים רשומים:";
$lang['Browsing_forum'] = "משתמשים מחוברים לפורום:";
$lang['Online_users_zero_total'] = "אין משתמשים מחוברים :: ";
$lang['Online_users_total'] = "סך הכל יש <b>%d</b> משתמשים מחוברים :: ";
$lang['Online_user_total'] = "סך הכל יש משתמש <b>אחד</b> מחובר :: ";
$lang['Reg_users_zero_total'] = "אין משתמשים רשומים, ";
$lang['Reg_users_total'] = "%d משתמשים רשומים, ";
$lang['Reg_user_total'] = "משתמש רשום אחד, ";
$lang['Hidden_users_zero_total'] = "אין משתמשים בלתי נראים ו-";
$lang['Hidden_user_total'] = "משתמש בלתי נראה אחד ו- ";
$lang['Hidden_users_total'] = "%d משתמשים בלתי נראים ו- ";
$lang['Guest_users_zero_total'] = "0 אורחים";
$lang['Guest_users_total'] = "%d אורחים";
$lang['Guest_user_total'] = "%d אורח";
$lang['Record_online_users'] = "מספר הגולשים הרב ביותר שהיו מחוברים בו זמנית לפורומים הוא: <b>%s</b> גולשים בתאריך %s";

$lang['Admin_online_color'] = "%sמנהל ראשי%s";
$lang['Mod_online_color'] = "%sמנהל%s";

$lang['You_last_visit'] = "ביקרת לאחרונה ב- %s"; // %s replaced by date/time
$lang['Current_time'] = "השעה כעת היא %s"; // %s replaced by time

$lang['Search_new'] = "הצג הודעות מאז ביקורך האחרון";
$lang['Search_your_posts'] = "הצג את הודעותיך";
$lang['Search_unanswered'] = "הצג הודעות ללא תגובה";

$lang['Register'] = "הרשמה";
$lang['Profile'] = "כרטיס אישי";
$lang['Edit_profile'] = "ערוך את הכרטיס האישי שלך";
$lang['Search'] = "חיפוש";
$lang['Memberlist'] = "רשימת חברים";
$lang['FAQ'] = "שאלות נפוצות";
$lang['BBCode_guide'] = "מדריך BBCode";
$lang['Usergroups'] = "קבוצות משתמשים";
$lang['Last_Post'] = "הודעה אחרונה";
$lang['Moderator'] = "מנהל";
$lang['Moderators'] = "מנהלים";

//
// Stats block text
//
$lang['Posted_articles_zero_total'] = "המשתמשים בפורום לא שלחו אף הודעה"; // Number of posts
$lang['Posted_articles_total'] = "המשתמשים בפורום שלחו בסך הכל <b>%d</b> הודעות"; // Number of posts
$lang['Posted_article_total'] = "המשתמשים בפורום שלחו הודעה אחת בלבד"; // Number of posts
$lang['Registered_users_zero_total'] = "אין משתמשים רשומים במערכת"; // # registered users
$lang['Registered_users_total'] = "בקהילה יש <b>%d</b> משתמשים רשומים"; // # registered users
$lang['Registered_user_total'] = "בקהילה יש משתמש <b>אחד</b> רשום"; // # registered users
$lang['Newest_user'] = "המשתמש החדש ביותר בקהילה הוא:: <b>%s%s%s</b>"; // a href, username, /a
$lang['No_new_posts_last_visit'] = "אין הודעות חדשות מאז ביקורך האחרון";
$lang['No_new_posts'] = "אין הודעות חדשות";
$lang['New_posts'] = "יש הודעות חדשות";
$lang['New_post'] = "יש הודעה חדשה";
$lang['No_new_posts_hot'] = "אין הודעות חמות חדשות";
$lang['New_posts_hot'] = "יש הודעות חמות חדשות";
$lang['No_new_posts_locked'] = "אין הודעות נעולות חדשות";
$lang['New_posts_locked'] = "יש הודעות נעולות חדשות";
$lang['Forum_is_locked'] = "הפורום נעול";


//
// Login
//
$lang['Enter_password'] = "הזן שם משתמש וסיסמה";
$lang['Login'] = "התחבר";
$lang['Logout'] = "התנתק";

$lang['Forgotten_password'] = "שכחתי את הסיסמה שלי";

$lang['Log_me_in'] = "זכור סיסמה";

$lang['Error_login'] = "הסיסמה או שם המשתמש אינם נכונים או שאינם פעילים";


//
// Index page
//
$lang['Index'] = "עמוד ראשי";
$lang['No_Posts'] = "אין הודעות";
$lang['No_forums'] = "לקהילה זו אין פורומים";

$lang['Private_Message'] = "מסר אישי";
$lang['Private_Messages'] = "מסרים אישיים";
$lang['Who_is_Online'] = "מי מחובר";

$lang['Mark_all_forums'] = "סמן את כל ההודעות בכל הפורומים כהודעות שנקראו";
$lang['Forums_marked_read'] = "כל ההודעות בכל הפורומים סומנו כהודעות שנקראו";



//
// Viewforum
//
$lang['View_forum'] = "הצגת פורום";

$lang['Forum_not_exist'] = "הפורום שבחרת אינו קיים";
$lang['Reached_on_error'] = "הגעת לעמוד זה בעקבות שגיאה בעמוד הקודם";

$lang['Display_topics'] = "הצג נושאים קודמים";
$lang['All_Topics'] = "כל הנושאים";

$lang['Topic_Announcement'] = "<b>הכרזה:</b>";
$lang['Topic_Sticky'] = "<b>דביק:</b>";
$lang['Topic_Moved'] = "<b>הועבר:</b>";
$lang['Topic_Poll'] = "<b>[ משאל ]</b>";

$lang['Mark_all_topics'] = "סמן את כל הנושאים בפורום זה כנושאים שנקראו";
$lang['Topics_marked_read'] = "הנושאים בפורום הזה סומנו כנושאים שנקראו";

$lang['Rules_post_can'] = "אתה <b>יכול</b> לשלוח הודעות בפורום זה";
$lang['Rules_post_cannot'] = "אתה <b>לא יכול</b> לשלוח הודעות בפורום זה";
$lang['Rules_reply_can'] = "אתה <b>יכול</b> להגיב להודעות בפורום זה";
$lang['Rules_reply_cannot'] = "אתה <b>לא יכול</b> להגיב להודעות בפורום זה";
$lang['Rules_edit_can'] = "אתה <b>יכול</b> לערוך את הודעותיך בפורום זה";
$lang['Rules_edit_cannot'] = "אתה <b>לא יכול</b> לערוך את הודעותיך בפורום זה";
$lang['Rules_delete_can'] = "אתה <b>יכול</b> למחוק את הודעותיך בפורום זה";
$lang['Rules_delete_cannot'] = "אתה <b>לא יכול</b> למחוק את הודעותיך בפורום זה";
$lang['Rules_vote_can'] = "אתה <b>יכול</b> להצביע למשאלים בפורום זה";
$lang['Rules_vote_cannot'] = "אתה <b>לא יכול</b> להצביע למשאלים בפורום זה";
$lang['Rules_moderate'] = "אתה <b>יכול</b> %sלנהל פורום זה%s"; // %s replaced by a href links, do not remove! 

$lang['No_topics_post_one'] = "אין הודעות בפורום הנוכחי<br /> לחץ על הקישור <b>שלח הודעה</b> שמופיע בעמוד למעלה כדי לשלוח הודעה חדשה.";

//
// Viewtopic
//
$lang['View_topic'] = "צפייה בנושא";

$lang['Guest'] = 'אורח';
$lang['Post_subject'] = "כותרת הודעה";
$lang['View_next_topic'] = "צפה בנושא הבא";
$lang['View_previous_topic'] = "צפה בנושא הקודם";
$lang['Submit_vote'] = "שלח הצבעה";
$lang['View_results'] = "ראה תוצאות";

$lang['No_newer_topics'] = "אין נושאים חדשים יותר בפורום זה";
$lang['No_older_topics'] = "אין נושאים ישנים יותר בפורום זה";
$lang['Topic_post_not_exist'] = "ההודעה שביקשת לא נמצאה";
$lang['No_posts_topic'] = "לא קיימות תגובות לנושא הנוכחי";

$lang['Display_posts'] = "הצג הודעות קודמות";
$lang['All_Posts'] = "כל ההודעות";
$lang['Newest_First'] = "חדשות קודם";
$lang['Oldest_First'] = "ישנות קודם";

$lang['Back_to_top'] = "חזור למעלה";

$lang['Read_profile'] = "צפה בכרטיס האישי של המשתמש"; 

$lang['Visit_website'] = "בקר באתר הבית של המשתמש";
$lang['ICQ_status'] = "מצב איי-סיי-קיו";
$lang['Edit_delete_post'] = "ערוך/מחק הודעה זו";
$lang['View_IP'] = "ראה כתובת IP של השולח";

$lang['wrote'] = "כתב"; // proceeds the username and is followed by the quoted text
$lang['Quote'] = "ציטוט"; // comes before bbcode quote output.
$lang['Code'] = "קוד"; // comes before bbcode code output.

$lang['Edited_time_total'] = "נערך בפעם אחרונה על-ידי %s בתאריך %s, נערך סך הכל פעם אחת"; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = "נערך בפעם אחרונה על-ידי  %s בתאריך %s, נערך בסך הכל %d פעמים"; // Last edited by me on 12 Oct 2001, edited 2 times in total

$lang['Lock_topic'] = "נעל נושא זה";
$lang['Unlock_topic'] = "שחרר נושא זה";
$lang['Move_topic'] = "העבר נושא זה";
$lang['Delete_topic'] = "מחק נושא זה";
$lang['Split_topic'] = "פצל נושא זה";

$lang['Stop_watching_topic'] = "הפסק את הצפייה בנושא הנוכחי";
$lang['Start_watching_topic'] = "צפה בתגובות של הנושא הנוכחי";
$lang['No_longer_watching'] = "אתה כבר לא צופה בנושא זה";
$lang['You_are_watching'] = "אתה עכשיו צופה בנושא זה";

$lang['Total_votes'] = "סך הכול הצבעות";

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = "גוף הודעה";
$lang['Topic_review'] = "ההודעה שעליה אתה מגיב";

$lang['No_post_mode'] = "אין מצב נושא מסויים"; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)

$lang['Post_a_new_topic'] = "שליחת נושא חדש";
$lang['Post_a_reply'] = "שליחת תגובה";
$lang['Post_topic_as'] = "שליחת נושא באופן";
$lang['Edit_Post'] = "עריכת נושא";
$lang['Options'] = "אפשרויות";

$lang['Post_Announcement'] = "הכרזה";
$lang['Post_Sticky'] = "דביק";
$lang['Post_Normal'] = "רגיל";

$lang['Confirm_delete'] = "האם אתה בטוח שברצונך למחוק את ההודעה הנוכחית?";
$lang['Confirm_delete_poll'] = "האם אתה בטוח שברצונך למחוק את המשאל הנוכחי?";

$lang['Flood_Error'] = "אינך יכול לשלוח הודעה נוספת בזמן כל כך קצר מאז הודעתך האחרונה. אנא נסה במועד מאוחר יותר";
$lang['Empty_subject'] = "אתה חייב לציין את הנושא של ההודעה החדשה";
$lang['Empty_message'] = "אתה חייב לכתוב את התוכן של ההודעה";
$lang['Forum_locked'] = "הפורום נעול. אינך יכול להוסיף הודעות, לכתוב תגובות ולערוך הודעות של עצמך";
$lang['Topic_locked'] = "ההודעה נעולה. אינך יכול לכתוב תגובות או לערוך את ההודעה, אם אתה כתבת אותה";
$lang['No_post_id'] = "אתה חייב לבחור את ההודעה שאותה אתה רוצה לערוך";
$lang['No_topic_id'] = "אתה חייב לבחור את ההודעה שעליה אתה רוצה להגיב";
$lang['No_valid_mode'] = "אתה יכול רק לשלוח הודעות, תגובות , לערוך את ההודעות שלך ולכתוב הודעות עם ציטוט, יש פעולות שאינך מורשה לעשות. אנא חזור ונסה שנית";
$lang['No_such_post'] = "הודעה זו אינה קיימת. חזור ונסה שנית";
$lang['Edit_own_posts'] = "מצטערים אבל אתה יכול לערוך הודעות שאתה כתבת בלבד";
$lang['Delete_own_posts'] = "איתך הסליחה, אך אתה יכול למחוק הודעות שאתה כתבת בלבד";
$lang['Cannot_delete_replied'] = "איתך הסליחה, אך אינך יכול למחוק הודעות שיש תגובות עליהן";
$lang['Cannot_delete_poll'] = "מצטערים אבל אינך יכול למחוק משאל פעיל";
$lang['Empty_poll_title'] = "אתה חייב לכתוב את שאלת המשאל";
$lang['To_few_poll_options'] = 'אתה חייב להזין לפחות שתי אפשרויות על מנת לקיים את המשאל';
$lang['To_many_poll_options'] = 'הזנת למעלה מכמות האפשרויות המירבית אנא צמצם את האפשרויות';
$lang['Post_has_no_poll'] = 'להודעה זו אין משאל';
$lang['Already_voted'] = 'כבר הצבעת למשאל זה';
$lang['No_vote_option'] = 'אתה חייב לפרט את האפשרויות כאשר אתה מצביע';

$lang['Add_poll'] = "הוסף משאל";
$lang['Add_poll_explain'] = "אם אין ברצונך לצרף משאל להודעתך השאר שדה זה ריק";
$lang['Poll_question'] = "שאלת המשאל";
$lang['Poll_option'] = "אפשרויות המשאל";
$lang['Add_option'] = "הוסף אפשרות";
$lang['Update'] = "עדכן";
$lang['Delete'] = "מחק";
$lang['Poll_for'] = "תקופת פעילות המשאל";
$lang['Days'] = "ימים"; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '(הקש 0 או השאר ריק כפי שהוא על מנת שהמשאל לא יוגבל בזמן)';
$lang['Delete_poll'] = 'מחק משאל';

$lang['Disable_HTML_post'] = 'בטל הצגת HTML בהודעה זו';
$lang['Disable_BBCode_post'] = 'בטל הצגת BBCode בהודעה זו';
$lang['Disable_Smilies_post'] = 'בטל הצגת מחוות בהודעה זו';

$lang['HTML_is_ON'] = 'HTML <u>פעיל</u>';
$lang['HTML_is_OFF'] = 'HTML <u>לא פעיל</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s <u>פעיל</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = '%sBBCode%s <u>לא פעיל</u>';
$lang['Smilies_are_ON'] = 'מחוות <u>פעילות</u>';
$lang['Smilies_are_OFF'] = 'מחוות <u>לא פעילות</u>';

$lang['Attach_signature'] = 'צרף חתימה (את החתימה ניתן לשנות באמצעות הכרטיס האישי)';
$lang['Notify'] = 'יידע אותי כאשר יש תגובה חדשה';
$lang['Delete_post'] = 'מחק הודעה זו';

$lang['Stored'] = 'הודעתך נוספה בהצלחה';
$lang['Deleted'] = 'הודעתך נמחקה בהצלחה';
$lang['Poll_delete'] = 'המשאל שיצרת נמחק בהצלחה';
$lang['Vote_cast'] = 'הצבעתך נתקבלה בהצלחה';

$lang['Topic_reply_notification'] = 'יידע בדואר האלקטרוני כאשר מתקבלת תגובה חדשה להודעה';

$lang['bbcode_b_help'] = 'תמליל מודגש: [b]תמליל[/b] או (alt+b)';
$lang['bbcode_i_help'] = 'תמליל נטוי: [i]תמליל[/i] או (alt+i)';
$lang['bbcode_u_help'] = 'תמליל עם קו תחתי: [u]תמליל[/u] או (alt+u)';
$lang['bbcode_q_help'] = 'תמליל מצוטט: [quote]תמליל[/quote] או (alt+q)';
$lang['bbcode_c_help'] = 'תצוגת קוד: [code]קוד[/code] או (alt+c)';

$lang['bbcode_l_help'] = 'תצוגת רשימה: [list]תמליל[/list] או (alt+l)';
$lang['bbcode_o_help'] = 'תצוגת רשימה ממויינת: [list=]text[/list] או (alt+o)';

$lang['bbcode_p_help'] = 'הוסף תמונה: [img]כתובת תמונה[/img] או (alt+p)';
$lang['bbcode_w_help'] = 'הוסף כתובת: [url]כתובת[/url] או [url=כתובת]תמליל מקושר[/url] או (alt+w)';
$lang['bbcode_a_help'] = 'סגור את כל תגי ה- BBCode הפתוחים';
$lang['bbcode_s_help'] = 'צבע גופן: [color=red]תמליל[/color] או להשתמש במפת צבעי אינטרנט כמו color=#FF0000';
$lang['bbcode_f_help'] = 'גודל גופן: [size=x-small]תמליל קטן[/size]';

$lang['Emoticons'] = 'מחוות';
$lang['More_emoticons'] = 'הצג מחוות נוספות';

$lang['Font_color'] = 'צבע גופן';
$lang['color_default'] = 'ברירת מחדל';
$lang['color_dark_red'] = 'אדום כהה';
$lang['color_red'] = 'אדום';
$lang['color_orange'] = 'כתום';
$lang['color_brown'] = 'חום';
$lang['color_yellow'] = 'צהוב';
$lang['color_green'] = 'ירוק';
$lang['color_olive'] = 'ירוק זית';
$lang['color_cyan'] = 'תכלת';
$lang['color_blue'] = 'כחול';
$lang['color_dark_blue'] = 'כחול כהה';
$lang['color_indigo'] = 'סגול כהה';
$lang['color_violet'] = 'סגול';
$lang['color_white'] = 'לבן';
$lang['color_black'] = 'שחור';

$lang['Font_size'] = 'גודל גופן';
$lang['font_tiny'] = 'קטן מאוד';
$lang['font_small'] = 'קטן';
$lang['font_normal'] = 'רגיל';
$lang['font_large'] = 'גדול';
$lang['font_huge'] = 'גדול מאוד';

$lang['Close_Tags'] = 'סגור תגים';
$lang['Styles_tip'] = 'עצה: סגנונות יכולים להתווסף במהירות לתמליל שבחרת';


//
// Private Messaging
//
$lang['Private_Messaging'] = "מסרים אישיים";

$lang['Login_check_pm'] = "התחבר כדי לבדוק מסרים אישיים";
$lang['New_pms'] = 'יש לך %d מסרים אישיים חדשים'; // You have 2 new messages
$lang['New_pm'] = 'יש לך מסר אישי חדש'; // You have 1 new message
$lang['No_new_pm'] = 'אין לך מסרים אישיים חדשים';
$lang['Unread_pms'] = 'יש לך %d מסרים אישיים שלא נקראו';
$lang['Unread_pm'] = 'יש לך מסר אישי אחד שלא נקרא';
$lang['No_unread_pm'] = 'אין לך מסרים אישיים שלא נקראו';
$lang['You_new_pm'] = "מסר אישי חדש מחכה לך בתיבת דואר נכנס";
$lang['You_new_pms'] = "מסרים אישיים חדשים מחכים לך בתיבת דואר נכנס";
$lang['You_no_new_pm'] = "אין מסרים אישיים חדשים";


$lang['Unread_message'] = 'הודעה שלא נקראה';
$lang['Read_message'] = 'הודעה שנקראה';

$lang['Read_pm'] = 'קרא הודעה';
$lang['Post_new_pm'] = 'שלח הודעה';
$lang['Post_reply_pm'] = 'הגב להודעה';
$lang['Post_quote_pm'] = 'צטט הודעה';
$lang['Edit_pm'] = 'ערוך הודעה';

$lang['Inbox'] = 'תיבת דואר נכנס';
$lang['Outbox'] = 'תיבת דואר יוצא';
$lang['Savebox'] = 'דואר שמור';
$lang['Sentbox'] = 'תיבת דואר שנשלח';
$lang['Flag'] = 'מצב';
$lang['Subject'] = 'נושא';
$lang['From'] = 'השולח';
$lang['To'] = 'הנמען';
$lang['Date'] = 'תאריך';
$lang['Mark'] = 'סמן';
$lang['Sent'] = 'נשלח';
$lang['Saved'] = 'נשמר';
$lang['Delete_marked'] = 'מחק את ההודעות המסומנות';
$lang['Delete_all'] = 'מחק הכול';
$lang['Save_marked'] = 'שמור את ההודעות המסומנות';
$lang['Save_message'] = 'שמור הודעה';
$lang['Delete_message'] = 'מחק הודעה';

$lang['Display_messages'] = 'הצג הודעות ישנות'; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'כל ההודעות';

$lang['No_messages_folder'] = 'אין לך הודעות בתיבה זו';

$lang['PM_disabled'] = 'מערכת המסרים אישיים מבוטלת';
$lang['Cannot_send_privmsg'] = 'איתך הסליחה, אך המנהל הראשי מנע ממך מלשלוח מסרים אישיים';
$lang['No_to_user'] = "אתה חייב לציין את שם המשתמש שאליו תישלח ההודעה";
$lang['No_such_user'] = "שם המשתמש אינו קיים במערכת";

$lang['Disable_HTML_pm'] = "בטל קוד HTML בהודעה";
$lang['Disable_BBCode_pm'] = "בטל BBCode בהודעה";
$lang['Disable_Smilies_pm'] = "בטל מחוות בהודעה";

$lang['Message_sent'] = "הודעתך נשלחה";

$lang['Click_return_inbox'] = "לחץ %sכאן%s כדי לחזור לתיבת ההודעות הנכנסות שלך";
$lang['Click_return_index'] = "לחץ %sכאן%s כדי לחזור לעמוד הראשי של הפורומים";

$lang['Send_a_new_message'] = "שלח מסר אישי חדש";
$lang['Send_a_reply'] = "הגב על מסר אישי";
$lang['Edit_message'] = "ערוך מסר אישי";

$lang['Notification_subject'] = "מסר אישי חדשה הגיע";

$lang['Find_username'] = "מציאת שם משתמש";
$lang['Find'] = "חיפוש";
$lang['No_match'] = "לא נמצאו התאמות";

$lang['No_post_id'] = "לא צויין מספר הזיהוי של ההודעה";
$lang['No_such_folder'] = "לא קיימת תיקיה כזאת";
$lang['No_folder'] = "התייקיה המסויימת לא נמצאה";

$lang['Mark_all'] = "סמן הכל";
$lang['Unmark_all'] = "בטל סימון מהכל";

$lang['Confirm_delete_pm'] = "האם אתה בטוח שברצונך למחוק את ההודעה הנוכחית?";
$lang['Confirm_delete_pms'] = "האם אתה בטוח שברצונך למחוק את ההודעה שבחרת?";

$lang['Inbox_size'] = "תיבת הדואר הנכנס שלך %d%% מלאה"; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = "תיבת הדואר היוצא שלך %d%% מלאה";
$lang['Savebox_size'] = "תיבת הדואר השמור שלך %d%% מלאה";

$lang['Click_view_privmsg'] = "לחץ %sכאן%s כדי לבדוק את הדואר הנכנס שלך";


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = "צופה בכרטיס האישי של :: %s"; // %s is username 
$lang['About_user'] = "הכול על %s"; // %s is username

$lang['Preferences'] = "העדפות";
$lang['Items_required'] = "שדה שמסומן ב - * הוא שדה חובה אלא אם כתוב אחרת";
$lang['Registration_info'] = "פרטי הרשמה";
$lang['Profile_info'] = "פרטי כרטיס האישי";
$lang['Profile_info_warn'] = "מידע זה יוצג לכל חברי האתר";
$lang['Avatar_panel'] = "ניהול הדמות האישית";
$lang['Avatar_gallery'] = "גלריית הדמויות האישיות";

$lang['Website'] = "אתר פרטי";
$lang['Location'] = "מיקום";
$lang['Contact'] = "צור קשר עם";
$lang['Email_address'] = "כתובת דואר אלקטרוני";
$lang['Send_private_message'] = "שלח מסר אישי";
$lang['Hidden_email'] = "[ בלתי נראה ]";
$lang['Interests'] = "תחומי עניין";
$lang['Occupation'] = "מקצוע"; 
$lang['Poster_rank'] = "דירוג משתמש";

$lang['Total_posts'] = "סך הכל הודעות";
$lang['User_post_pct_stats'] = "%.2f%% בסך הכל";
$lang['User_post_day_stats'] = "%.2f הודעות ליום";
$lang['Search_user_posts'] = "מצא את כל ההודעות של %s";

$lang['No_user_id_specified'] = "איתך הסליחה, אך משתמש זה אינו קיים";
$lang['Wrong_Profile'] = "אינך יכול לערוך כרטיס האישי שלא שלך.";

$lang['Only_one_avatar'] = 'ניתן לבחור רק דמות אישית אחת';
$lang['File_no_data'] = 'הקובץ בכתובת שהבאת אינו מכיל מידע';
$lang['No_connection_URL'] = 'אין אפשרות ליצור קשר עם הכתובת שהבאת';
$lang['Incomplete_URL'] = 'הכתובת שהבאת הוקשה ככתובת בלתי מלאה';
$lang['Wrong_remote_avatar_format'] = 'הכתובת של הדמות האישית אינה תקינה';
$lang['No_send_account_inactive'] = 'איתך סליחה, אך סיסמתך איננה יכולה להישלח משום שחשבונך איננו פעיל ברגע זה. אנא פנה למנהל-על ליותר מידע';

$lang['Always_smile'] = 'מחוות יהיו תמיד פעילות';
$lang['Always_html'] = 'HTML יהיה תמיד פעיל';
$lang['Always_bbcode'] = ' BBCode תמיד יהיה פעיל';
$lang['Always_add_sig'] = 'תמיד צרף חתימה למכתבייך';
$lang['Always_notify'] = 'יידע אותי תמיד כאשר יש תגובות';
$lang['Always_notify_explain'] = 'שלח דואר אלקטרוני כאשר מישהו מגיב להודעות שאתה שלחת. ניתן לשנות זאת זמנית בזמן השליחה.';

$lang['Board_style'] = "סגנון הפורום";
$lang['Board_lang'] = "שפת הפורום";
$lang['No_themes'] = "אין סגנונות במסד הנתונים";
$lang['Timezone'] = "אזור זמן";
$lang['Date_format'] = "סדר הצגת התאריך";
$lang['Date_format_explain'] = "השימוש נעשה בעזרת הפקודה  <a href=\"http://www.php.net/date\" target=\"_other\">()date</a> בשפת המפענח PHP.";
$lang['Signature'] = "חתימה";
$lang['Signature_explain'] = "החתימה היא תמליל שיכול להיות מצורף בסוף כל הודעה של המשתמש. מוגבל ל- %d תווים.";
$lang['Public_view_email'] = "תמיד הצג את כתובת הדואר האלקטרוני שלי";

$lang['Current_password'] = "סיסמה נוכחית";
$lang['New_password'] = "סיסמה חדשה";
$lang['Confirm_password'] = "חזור על הסיסמה";
$lang['Confirm_password_explain'] = "אתה חייב לחזור על הסיסמה הנוכחית אם אתה רוצה לשנות אותה או את הדואר האלקטרוני";
$lang['password_if_changed'] = "אם ברצונך לשנות סיסמה, הזן כאן את הסיסמה החדשה";
$lang['password_confirm_if_changed'] = "אתה צריך לאשר את הסיסמה רק אם שינית אותה בשדה הקודם";

$lang['Avatar'] = 'דמות אישית';
$lang['Avatar_explain'] = "מציג דמות אישית בפרטי המשתמש בכל הודעה. ניתן להציג תמונה אחת כל פעם, והרוחב לא יהיה יותר גדול מ %d פיקסלים והגובה לא יותר מ %d
פיקסלים וגודל התמונה לא יותר מ %dKB.";
$lang['Upload_Avatar_file'] = 'העלה סמל אישי מהמחשב שלך';
$lang['Upload_Avatar_URL'] = "הצג דמות אישית מהכתובת הבאה";
$lang['Upload_Avatar_URL_explain'] = "הזן את הכתובת של הדמות האישית, היא תוצג כאן.";
$lang['Pick_local_Avatar'] = "בחירת דמות אישית מהגלרייה";
$lang['Link_remote_Avatar'] = "קישור לדמות אישית מחוץ לאתר";
$lang['Link_remote_Avatar_explain'] = "הכנס את הקישור לדמות האישית שאתה רוצה שתופיע.";
$lang['Avatar_URL'] = "כתובת הדמות האישית";
$lang['Select_from_gallery'] = "בחירת דמות אישית מהגלריה";
$lang['View_avatar_gallery'] = "הצג גלריה";

$lang['Select_avatar'] = "בחר דמות אישית";
$lang['Return_profile'] = "בטל בחירת דמות אישית";
$lang['Select_category'] = "בחר קטגוריה";

$lang['Delete_Image'] = "מחק דמות אישית";
$lang['Current_Image'] = "דמות נוכחית";

$lang['Notify_on_privmsg'] = "הודע בעת מסר אישי חדש";
$lang['Popup_on_privmsg'] = "הקפץ חלון כאשר יש מסר אישי חדש"; 
$lang['Popup_on_privmsg_explain'] = "ישנם סגנונות שקיימת בהם האפשרות לפתוח חלון בעת קבלת מסר אישי חדש";
$lang['Hide_user'] = "הסתר את שמך מרשימת הגולשים";

$lang['Profile_updated'] = 'הכרטיס האישי שלך עודכן';
$lang['Profile_updated_inactive'] = "הכרטיס האישי שלך עודכן בהצלחה, שינית פרטים חשובים וחיוניים בחשבון ולכן החשבון שלך איננו פעיל כרגע, ייתכן שנשלח אליך קוד
הפעלה לחשבון שבאמצעותו יהיה באפשרותך להפעיל את החשבון, אם לא נשלח אליך קוד ההפעלה אז כנראה שאתה צריך אישור ממנהל מערכת הפורומים, כאשר הוא יאשר אותו
תקבל הודעה שחשבונך אושר";

$lang['Password_mismatch'] = "הסיסמאות שהזנת אינן תואמות.";
$lang['Current_password_mismatch'] = "הסיסמה שהקשת אינה תואמת לזו שבמסד הנתונים";
$lang['Password_long'] = "הסיסמה חייבת להיות פחות מ- 32 תווים.";
$lang['Username_taken'] = "שם משתמש זה תפוס. אנא בחר אחד אחר.";
$lang['Username_invalid'] = "שם משתמש זה מכיל תווים לא חוקיים. אנא בחר שם אחר.";
$lang['Username_disallowed'] = "שם משתמש זה נאסר לשימוש על ידי המנהל הראשי. אנא בחר שם אחר.";
$lang['Email_taken'] = "כתובת דואר אלקטרוני זאת כבר בשימוש. אנא כתוב אחרת.";
$lang['Email_banned'] = "כתובת דואר אלקטרוני זאת בוטלה לשימוש על ידי המנהל הראשי.";
$lang['Email_invalid'] = "כתובת דואר אלקטרוני זאת בלתי חוקית. אנא כתוב אחרת.";
$lang['Signature_too_long'] = "חתימתך ארוכה מדי. אנא קצר אותה.";
$lang['Fields_empty'] = "אתה חייב למלא את השדות המסומנות ב *";
$lang['Avatar_filetype'] = "הדמות האישית חייבת להיות בתבנית jpg, .gif. או png.";
$lang['Avatar_filesize'] = "הדמות האישית חייבת להיות פחות מ %d kB"; // The avatar image file size must be less than 6 kB
$lang['Avatar_imagesize'] = "הדמות האישית חייבת להיות %d פיקסלים רוחב על %d פיקסלים גובה"; 

$lang['Welcome_subject'] = "ברוך הבא לפורומים של %s"; // Welcome to my.com forums
$lang['New_account_subject'] = "חשבון משתמש חדש";
$lang['Account_activated_subject'] = "חשבון הופעל";

$lang['Account_added'] = "תודה לך על הרישום, חשבונך הופעל. אתה יכול להכנס עכשיו עם שמך וסיסמתך";
$lang['Account_inactive'] = "חשבונך נוצר. אנא בדוק את חשבון הדואר האלקטרוני שהקשת, לשם נשלח המידע על ההפעלה של הפורומים. לפני שתכנס תצטרך לאשר על ידי
כניסה לקישור שבהודעת שתקבל";
$lang['Account_inactive_admin'] = "חשבונך נוצר. הבקשה להפעלה נשלחה למנהל. לאחר שמנהל המערכת יאשר את חשבונך, תקבל הודעה בדואר האלקטרוני ותוכל
להכנס למערכת הפורומים";
$lang['Account_active'] = "חשבונך הופעל. תודה שנרשמת";
$lang['Account_active_admin'] = "חשבונך הופעל";
$lang['Reactivate'] = "הפעל מחדש את חשבונך!";
$lang['COPPA'] = "חשבון המשתמש שלך נוצר בהצלחה אבל עליך לאשר אותו, פרטים נוספים נמסרו לתיבת הדואר האלקטרוני שלך.";

$lang['Registration'] = 'הסכמי השימוש במערכת הפורומים';
$lang['Reg_agreement'] = 'בזמן שמנהלי-העל ומנהלי הפורומים ינסו להסיר במהירות כל מיני הערות לא רצויות ודעות פוגעות, עדיין אפשר לראות את ההודעה הפוגעת.
לכן עליך לדעת שכל ההודעות אשר נכתבות בפורום הם באחריות הכותב של ההודעה, לא באחריות המנהל הראשי, מנהלי הפורום ומנהל האתר (חוץ מהודעות שהם בעצמם
כתבו) ולכן הם לא נושאים באחריות.<br /><br />בלחיצה על אישור אתה מסכים לא לשלוח דברים גסים, גזעניים, אלימים, פוגעים, בלתי חוקיים או סוג אחר של הערות שנויות
במחלוקת. אם תעשה כך תוביל את עצמך לנידוי מהפורום (ותקבל על זה הודעה). כתובת ה IP של כל ההודעות נרשמת על מנת לעזור בלכפות את תנאים אלה. אתה מסכים
שהמנהלים הראשיים, מנהל האתר, ומנהלי הפורומים יהיו בעלי זכות למחוק, לערוך, להעביר או לסגור כל נושא בכל זמן שנראה להם מתאים. כמשתמש אתה מסכים לכך שכל
מידע שאתה מזין יאוכסן בבסיס הנתונים. ברור שמידע זה לא יחשף לשום צד שלישי, מבלי הסכמתך. מנהל אתר, המנהלים הראשיים ומנהלי הפורומים לא יכולים להיות אחראיים
לשום נסיון פריצה שעלול להוביל לכך שמידע יחשף.<br /><br />מערכת הפורום משתמשת בעוגיות על מנת לאכסן מידע במחשבך האישי. עוגיות אלו אינן מכילות את המידע
שאתה מקיש כאן, הם משמשות רק כדי לשפר את ההנאה שלך. כתובת הדואר האלקטרוני שלך משומשת רק כדי לאשר את פרטי ההרשמה והסיסמה ( ובשביל לשלוח סיסמאות
חדשות אם תשכח את הנוכחית).<br /><br />על ידי לחיצה על ההרשמה מתחת להסכם זה אתה מסכים לכל התנאים האלה.';

$lang['Agree_under_13'] = 'אני מסכים לתנאים ואני <b>מתחת</b> לגיל 13';
$lang['Agree_over_13'] = 'אני מסכים לתנאים ואני <b>מעל</b> או <b>בדיוק</b> בן 13';
$lang['Agree_not'] = "אני לא מסכים לתנאים של מערכת הפורומים";

$lang['Wrong_activation'] = "מפתח ההפעלה שהזנת אינו תואם לזה שבבסיס נתונים. אנא הזן אותו שוב.";
$lang['Send_password'] = "שלח לי סיסמה חדשה"; 
$lang['Password_updated'] = "סיסמה חדשה נוצרה. אנא בדוק בתיבת הדואר האלקטרוני שלך כדי לקבל הוראות כיצד להשתמש בסיסמה וכיצד לאשר ולהפעיל אותה";
$lang['No_email_match'] = "כתובת הדואר האלקטרוני שסיפקת אינה תואמת לכתובת הדואר האלקטרוני שצריכה להיות תואמת לשם המשתמש שמסרת";
$lang['New_password_activation'] = "סיסמת הפעלה חדשה";
$lang['Password_activated'] = "החשבון משתמש שלך הופעל מחדש, כדי להכנס למערכת הפורומים עליך להשתמש בסיסמה שסופקה לך בתיבת הדואר האלקטרוני שלך";

$lang['Send_email_msg'] = 'שלח הודעה לדואר האלקטרוני';
$lang['No_user_specified'] = 'שם המשתמש לא צויין';
$lang['User_prevent_email'] = 'משתמש זה אינו רוצה לקבל דואל. אנא נסה לשלוח אליו מסר אישי.';
$lang['User_not_exist'] = 'המשתמש אינו קיים';
$lang['CC_email'] = 'שלח עותק של הודעה זו אל עצמך';
$lang['Email_message_desc'] = 'ההודעה נשלחה כתמליל פשוט, אל תכלול תגי HTML או קוד BBCode בהודעה זו. הכתובת שתוצג שממנה נשלח הדואר האלקטרוני מופיעה
כפי שהגדרת אותה.';
$lang['Flood_email_limit'] = 'אינך יכול לשלוח דואל בזמן זה, אנא נסה מאוחר יותר.';

$lang['Recipient'] = 'נמען';
$lang['Email_sent'] = 'ההודעה נשלחה בהצלחה';
$lang['Send_email'] = 'שלח דואל';
$lang['Empty_subject_email'] = 'אתה חייב לציין נושא עבור הודעה זו';
$lang['Empty_message_email'] = 'אתה חייב להקיש את ההודעה שברצונך לשלוח';


//
// Visual confirmation system strings
//
$lang['Confirm_code_wrong'] = 'קוד האישור שהכנסת אינו תקין';
$lang['Too_many_registers'] = 'עברת את מספר הניסיות המותר, אנא נסה שוב מאוחר יותר';
$lang['Confirm_code_impaired'] = 'אם אתה לא יכול לראות את הקוד המוצג אנא צור קשר עם %sהמנהל הראשי%s לעזרה.';
$lang['Confirm_code'] = 'קוד אישור';
$lang['Confirm_code_explain'] = 'אנא הכנס את הקוד בדיוק כפי שאתה רואה אותו. הקוד דורש אותיות גדולות וקטנות, והאפס מכיל קו חוצה.';



//
// Memberslist
//
$lang['Select_sort_method'] = 'בחר סוג מיון';
$lang['Sort'] = 'סדר';
$lang['Sort_Top_Ten'] = 'עשרת השולחים הגדולים';
$lang['Sort_Joined'] = 'תאריך הצטרפות';
$lang['Sort_Username'] = 'שם משתמש';
$lang['Sort_Location'] = 'מיקום';
$lang['Sort_Posts'] = 'סכום הודעות כולל';
$lang['Sort_Email'] = 'כתובת דואר אלקטרוני';
$lang['Sort_Website'] = 'אתר אישי';
$lang['Sort_Ascending'] = 'סדר עולה';
$lang['Sort_Descending'] = 'סדר יורד';
$lang['Order'] = 'סדר';


//
// Group control panel
//
$lang['Group_Control_Panel'] = 'לוח בקרה לקבוצות';
$lang['Group_member_details'] = 'פרטי חברות בקבוצה';
$lang['Group_member_join'] = 'הצטרף לקבוצה';

$lang['Group_Information'] = 'מידע קבוצה';
$lang['Group_name'] = 'שם קבוצה';
$lang['Group_description'] = 'תיאור קבוצה';
$lang['Group_membership'] = 'חברות בקבוצה';
$lang['Group_Members'] = 'חברי קבוצה';
$lang['Group_Moderator'] = 'מנהל קבוצה';
$lang['Pending_members'] = 'חברים נסיוניים';

$lang['Group_type'] = 'סוג קבוצה';
$lang['Group_open'] = 'קבוצה פתוחה';
$lang['Group_closed'] = 'קבוצה סגורה';
$lang['Group_hidden'] = 'קבוצה מוסתרת';

$lang['Current_memberships'] = 'חברויות נוכחיות';
$lang['Non_member_groups'] = 'קבוצות ללא חברים';
$lang['Memberships_pending'] = 'חברויות נסיוניות';

$lang['No_groups_exist'] = 'אין קבוצות קיימות';
$lang['Group_not_exist'] = 'קבוצת משתמשים זו אינה קיימת';

$lang['Join_group'] = 'הצטרף לקבוצה';
$lang['No_group_members'] = 'בקבוצה זו אין חברים';
$lang['Group_hidden_members'] = 'קבוצה זו מוסתרת, אינך יכול לראות את הפרטים שלה';
$lang['No_pending_group_members'] = 'בקבוצה זו אין חברים נסיוניים';
$lang['Group_joined'] = 'נרשמת בהצלחה לקבוצה זו.<br />אתה תקבל הודעה כאשר רישומך יאושר על ידי מנהל הקבוצה.';
$lang['Group_request'] = 'בקשתך להצטרף לקבוצה זו נשלחה';
$lang['Group_approved'] = 'בקשתך אושרה';
$lang['Group_added'] = 'נוספת בהצלחה לקבוצת משתמשים זו'; 
$lang['Already_member_group'] = 'אתה כבר חבר בקבוצה זו';
$lang['User_is_member_group'] = 'משתמש זה כבר חבר בקבוצה זו';
$lang['Group_type_updated'] = 'סוג הקבוצה שונה בהצלחה';

$lang['Could_not_add_user'] = 'אי אפשר לצרף משתמש שאינו קיים';
$lang['Could_not_anon_user'] = 'אינך יכול לצרף משתמש אלמוני לקבוצה';

$lang['Confirm_unsub'] = 'האם אתה בטוח שברצונך לבטל את הרשמתך לקבוצה זו?';
$lang['Confirm_unsub_pending'] = 'הרשמתך לקבוצה זו אינה אושרה עדיין. האם אתה בטוח כי ברצונך לבטל את בקשתך להתקבל לקבוצה זו?';

$lang['Unsub_success'] = 'ביטלת את הרשמתך לקבוצה זו בהצלחה.';

$lang['Approve_selected'] = 'אשר נבחרים';
$lang['Deny_selected'] = 'דחה נבחרים';
$lang['Not_logged_in'] = 'אתה חייב להכנס לקבוצה על מנת להרשם אליה.';
$lang['Remove_selected'] = 'מחק נבחרים';
$lang['Add_member'] = 'הוסף חבר';
$lang['Not_group_moderator'] = 'אינך יכול לנהל קבוצה זו ולכן אינך יכול לבצע פעולה זו.';

$lang['Login_to_join'] = 'כניסה או הצטרפות או ניהול חברי קבוצה';
$lang['This_open_group'] = 'זוהי קבוצה פתוחה, לחץ כדי לבקש להצטרף';
$lang['This_closed_group'] = 'זוהי קבוצה סגורה, צירוף של משתמשים נוספים אינו מורשה';
$lang['This_hidden_group'] = 'זוהי קבוצה מוסתרת, צירוף אוטומטי של משתמש אינו מורשה';
$lang['Member_this_group'] = 'הינך חבר בקבוצה';
$lang['Pending_this_group'] = 'הינך בעל חברות נסיונית בקבוצה';
$lang['Are_group_moderator'] = 'הינך מנהל הקבוצה';
$lang['None'] = 'אין';

$lang['Subscribe'] = 'הירשם';
$lang['Unsubscribe'] = 'בטל את הרשמתך';
$lang['View_Information'] = 'ראה מידע';

//
// Search
//
$lang['Search_query'] = "חיפוש לפי מילת מפתח";
$lang['Search_options'] = "אפשרויות חיפוש";

$lang['Search_keywords'] = "חיפוש מילות מפתח";
$lang['Search_keywords_explain'] = 'אתה יכול להשתמש ב- <u>AND</u> בין שתי מילות מפתח, על-מנת שהתוצאה תכלול את שתי מילות המפתח בתוצאות החיפוש.<br
/>אתה יכול להשתמש ב- <u>Or</u> בין שתי מילות מפתח, כדי שהתוצאה תכלול אחת ממילות המפתח, או את כולן.<br />אתה יכול להשתמש ב- <u>Not</u> בין שתי מילות
מפתח, ע"מ  לציין איזה מילה כן תהיה בתוצאות החיפוש ואיזו לא.<br />אתה יכול להשתמש ב- * בתור תו משלים.';
$lang['Search_author'] = "חיפוש לפי שם מחבר ההודעה";
$lang['Search_author_explain'] = "השתמש ב * בתור תו משלים";

$lang['Search_for_any'] = "חפש כל אחד מהתנאים או השתמש כפי שרשמת";
$lang['Search_for_all'] = "חפש את כל התנאים";
$lang['Search_title_msg'] = "חפש בכותרת הודעה ותוכן הודעה";
$lang['Search_msg_only'] = "חפש בתוכן הודעה בלבד";

$lang['Return_first'] = "חזור לראשון"; // followed by xxx characters in a select box
$lang['characters_posts'] = "תווים של הודעה";

$lang['Search_previous'] = "חפש קודם"; // followed by days, weeks, months, year, all in a select box

$lang['Sort_by'] = "סדר לפי";
$lang['Sort_Time'] = "זמן הודעה";
$lang['Sort_Post_Subject'] = "נושא הודעה";
$lang['Sort_Topic_Title'] = "כותרת נושא";
$lang['Sort_Author'] = "כותב";
$lang['Sort_Forum'] = "פורום";

$lang['Display_results'] = "הצג תוצאה כ";
$lang['All_available'] = "הכל אפשרי";
$lang['No_searchable_forums'] = "אין באפשרותך לחפש באף אחד מהפורומים באתר זה";

$lang['No_search_match'] = "לא נמצאו תוצאות לחיפוש שביצעת";
$lang['Found_search_match'] = "נמצאה הודעה אחת תואמת לחיפוש שלך"; // eg. Search found 1 match
$lang['Found_search_matches'] = "נמצאו %d תוצאות תואמות לחיפוש שלך"; // eg. Search found 24 matches

$lang['Search_Flood_Error'] = 'אינך יכול לבצע חיפוש נוסף בזמן קצר כל-כך; אנא נסה שנית בעוד זמן קצר.';

$lang['Close_window'] = "סגור חלון";


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = "סליחה אבל רק %s יכול לשלוח הכרזות בפורום זה";
$lang['Sorry_auth_sticky'] = "סליחה אבל רק %s יכול לשלוח הודעות דביקות בפורום זה"; 
$lang['Sorry_auth_read'] = "סליחה אבל רק %s יכול לקרוא הודעות בפורום זה"; 
$lang['Sorry_auth_post'] = "סליחה אבל רק %s יכול לשלוח הודעות בפורום זה";
$lang['Sorry_auth_reply'] = "סליחה אבל רק %s יכול להגיב להודעות בפורום זה";
$lang['Sorry_auth_edit'] = "סליחה אבל רק %s יכול לערוך הודעות בפורום זה";
$lang['Sorry_auth_delete'] = "סליחה אבל רק %s יכול למחוק הודעות בפורום זה";
$lang['Sorry_auth_vote'] = "סליחה אבל רק %s יכול להצביע במשאלים בפורום זה";

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = "<b>משתמשים אלמוניים</b>";
$lang['Auth_Registered_Users'] = "<b>משתמשים רשומים</b>";
$lang['Auth_Users_granted_access'] = "<b>משתמשים בעלי גישה מסויימת</b>";
$lang['Auth_Moderators'] = "<b>מנהלים</b>";
$lang['Auth_Administrators'] = "<b>מנהלים ראשיים</b>";

$lang['Not_Moderator'] = 'אינך המנהל של פורום זה';
$lang['Not_Authorised'] = 'הגישה אסורה';

$lang['You_been_banned'] = 'הושעית מפורום זה.<br />אנא פנה למנהל הראשי או למנהל הפורום כדי לקבל מידע נוסף.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'אין אף חבר רשום ו'; // There are 5 Registered and
$lang['Reg_users_online'] = 'יש %d חברים רשומים ו-'; // There ae 5 Registered and
$lang['Reg_user_online'] = 'יש חבר רשום אחד ו-'; // There ae 5 Registered and
$lang['Hidden_users_zero_online'] = 'אין חברים בלתי נראים'; // Zero Hidden users online
$lang['Hidden_users_online'] = '%d חברים בלתי נראים'; // six Hidden users online
$lang['Hidden_user_online'] = 'חבר אחד בלתי נראה'; // six Hidden users online
$lang['Guest_users_online'] = 'יש %d אורחים בפורום שמחוברים כרגע'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'אין אורחים בפורום שמחוברים כרגע'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'יש אורח אחד בפורום שמחובר כרגע'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'אין משתמשים שגולשים כרגע בפורום';

$lang['Online_explain'] = 'המידע מבוסס על פעילות המשתמשים במערכת בחמשת הדקות האחרונות';

$lang['Forum_Location'] = 'מיקום פורום';
$lang['Last_updated'] = 'עודכן לאחרונה';

$lang['Forum_index'] = 'בעמוד הראשי';
$lang['Logging_on'] = 'מתחבר';
$lang['Posting_message'] = 'שולח הודעה';
$lang['Searching_forums'] = 'מחפש בפורומים';
$lang['Viewing_profile'] = 'צופה בכרטיס האישי';
$lang['Viewing_online'] = 'רואה מי מחובר';
$lang['Viewing_member_list'] = 'רואה רשימת חברים';
$lang['Viewing_priv_msgs'] = 'רואה מסרים אישיים';
$lang['Viewing_FAQ'] = 'רואה עמוד שאלות נפוצות';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'לוח בקרה למנהלים';
$lang['Mod_CP_explain'] = 'בעזרת טופס זה תוכל לבצע פעולות שונות כגון מחיקה, העברה, נעילה, שחרור נעילה ופיצול הודעות בפורום זה.';

$lang['Select'] = 'בחר';
$lang['Delete'] = 'מחק';
$lang['Move'] = 'העבר';
$lang['Lock'] = 'נעל';
$lang['Unlock'] = 'שחרר נעילה';

$lang['Topics_Removed'] = 'ההודעות שבחרת הוסרו בהצלחה ממסד הנתונים.';
$lang['Topics_Locked'] = 'ההודעות שנבחרו ננעלו';
$lang['Topics_Moved'] = 'ההודעות שנבחרו הועברו לפורום שבחרת';
$lang['Topics_Unlocked'] = 'ההודעות שנבחרו שוחררו מהנעילה';
$lang['No_Topics_Moved'] = 'אף הודעה לא הועברה';

$lang['Confirm_delete_topic'] = 'האם אתה בטוח שברצונך להסיר את ההודעה שנבחרה?';
$lang['Confirm_lock_topic'] = 'האם אתה בטוח שברצונך לנעול את ההודעה שנבחרה?';
$lang['Confirm_unlock_topic'] = 'האם אתה בטוח שברצונך לשחרר את הנעילה של ההודעה שנבחרה?';
$lang['Confirm_move_topic'] = 'האם אתה בטוח שברצונך להעביר את ההודעה שנבחרה?';

$lang['Move_to_forum'] = 'העבר לפורום';
$lang['Leave_shadow_topic'] = 'השאר העתק של ההודעה בפורום המקורי.';

$lang['Split_Topic'] = 'לוח הבקרה לפיצול הודעות';
$lang['Split_Topic_explain'] = 'בעזרת טופס זה תוכל לחלק הודעה לשתי הודעות נפרדות. ואף ניתן להפריד בין הנושא לתגובות.';
$lang['Split_title'] = 'נושא ההודעה החדשה';
$lang['Split_forum'] = 'הפורום שאליו תועבר ההודעה החדשה';
$lang['Split_posts'] = 'חלק רק את ההודעות שנבחרו';
$lang['Split_after'] = 'חלק מההודעה שנבחרה ומטה';
$lang['Topic_split'] = 'ההודעה שנבחרה פוצלה בהצלחה';

$lang['Too_many_error'] = 'בחרת יותר מדי הודעות. אתה יכול לבחור רק הודעה אחת לפיצול.';

$lang['None_selected'] = 'לא בחרת הודעה כלשהי לביצוע פעולה זו. בבקשה חזור אחורה ובחר לפחות הודעה אחת.';
$lang['New_forum'] = 'פורום חדש';

$lang['This_posts_IP'] = 'IP עבור הודעה זו';
$lang['Other_IP_this_user'] = 'כתובות IP אחרות שדרכם משתמש זה שלח הודעות';
$lang['Users_this_IP'] = 'משתמשים ששלחו הודעות דרך ה IP';
$lang['IP_info'] = 'מידע IP';
$lang['Lookup_IP'] = 'מצא כתובת IP';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'כל הזמנים הם %s'; // eg. All times are GMT - 12 Hours (times from next block)

$lang['-12'] = 'GMT - 12 שעות';
$lang['-11'] = 'GMT - 11 שעות';
$lang['-10'] = 'GMT - 10 שעות';
$lang['-9'] = 'GMT - 9 שעות';
$lang['-8'] = 'GMT - 8 שעות';
$lang['-7'] = 'GMT - 7 שעות';
$lang['-6'] = 'GMT - 6 שעות';
$lang['-5'] = 'GMT - 5 שעות';
$lang['-4'] = 'GMT - 4 שעות';
$lang['-3.5'] = 'GMT - 3.5 שעות';
$lang['-3'] = 'GMT - 3 שעות';
$lang['-2'] = 'GMT - שעתיים';
$lang['-1'] = 'GMT - שעה';
$lang['0'] = 'שעון בריטניה (GMT)';
$lang['1'] = 'שעון אירופה (GMT + שעה)';
$lang['2'] = 'שעון ישראל (GMT + שעתיים)';
$lang['3'] = 'GMT + 3 שעות';
$lang['3.5'] = 'GMT + 3.5 שעות';
$lang['4'] = 'GMT + 4 שעות';
$lang['4.5'] = 'GMT + 4.5 שעות';
$lang['5'] = 'GMT + 5 שעות';
$lang['5.5'] = 'GMT + 5.5 שעות';
$lang['6'] = 'GMT + 6 שעות';
$lang['6.5'] = 'GMT + 6.5 שעות';
$lang['7'] = 'GMT + 7 שעות';
$lang['8'] = 'GMT + 8 שעות';
$lang['9'] = 'GMT + 9 שעות';
$lang['9.5'] = 'GMT + 9.5 שעות';
$lang['10'] = 'GMT + 10 שעות';
$lang['11'] = 'GMT + 11 שעות';
$lang['12'] = 'GMT + 12 שעות';
$lang['13'] = 'GMT + 13 שעות';

// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 שעות';
$lang['tz']['-11'] = 'GMT - 11 שעות';
$lang['tz']['-10'] = 'GMT - 10 שעות';
$lang['tz']['-9'] = 'GMT - 9 שעות';
$lang['tz']['-8'] = 'GMT - 8 שעות';
$lang['tz']['-7'] = 'GMT - 7 שעות';
$lang['tz']['-6'] = 'GMT - 6 שעות';
$lang['tz']['-5'] = 'GMT - 5 שעות';
$lang['tz']['-4'] = 'GMT - 4 שעות';
$lang['tz']['-3.5'] = 'GMT - 3.5 שעות';
$lang['tz']['-3'] = 'GMT - 3 שעות';
$lang['tz']['-2'] = 'GMT - שעתיים';
$lang['tz']['-1'] = 'GMT - שעה';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + שעה';
$lang['tz']['2'] = 'שעון ישראל';
$lang['tz']['3'] = 'GMT + 3 שעות';
$lang['tz']['3.5'] = 'GMT + 3.5 שעות';
$lang['tz']['4'] = 'GMT + 4 שעות';
$lang['tz']['4.5'] = 'GMT + 4.5 שעות';
$lang['tz']['5'] = 'GMT + 5 שעות';
$lang['tz']['5.5'] = 'GMT + 5.5 שעות';
$lang['tz']['6'] = 'GMT + 6 שעות';
$lang['tz']['6.5'] = 'GMT + 6.5 שעות';
$lang['tz']['7'] = 'GMT + 7 שעות';
$lang['tz']['8'] = 'GMT + 8 שעות';
$lang['tz']['9'] = 'GMT + 9 שעות';
$lang['tz']['9.5'] = 'GMT + 9.5 שעות';
$lang['tz']['10'] = 'GMT + 10 שעות';
$lang['tz']['11'] = 'GMT + 11 שעות';
$lang['tz']['12'] = 'GMT + 12 שעות';
$lang['tz']['13'] = 'GMT + 13 שעות';

$lang['datetime']['Sunday'] = 'ראשון';
$lang['datetime']['Monday'] = 'שני';
$lang['datetime']['Tuesday'] = 'שלישי';
$lang['datetime']['Wednesday'] = 'רביעי';
$lang['datetime']['Thursday'] = 'חמישי';
$lang['datetime']['Friday'] = 'שישי';
$lang['datetime']['Saturday'] = 'שבת';
$lang['datetime']['Sun'] = "א'";
$lang['datetime']['Mon'] = "ב'";
$lang['datetime']['Tue'] = "ג'";
$lang['datetime']['Wed'] = "ד'";
$lang['datetime']['Thu'] = "ה'";
$lang['datetime']['Fri'] = "ו'";
$lang['datetime']['Sat'] = 'שבת';
$lang['datetime']['January'] = 'ינואר';
$lang['datetime']['February'] = 'פברואר';
$lang['datetime']['March'] = 'מרץ';
$lang['datetime']['April'] = 'אפריל';
$lang['datetime']['May'] = 'מאי';
$lang['datetime']['June'] = 'יוני';
$lang['datetime']['July'] = 'יולי';
$lang['datetime']['August'] = 'אוגוסט';
$lang['datetime']['September'] = 'ספטמבר';
$lang['datetime']['October'] = 'אוקטובר';
$lang['datetime']['November'] = 'נובמבר';
$lang['datetime']['December'] = 'דצמבר';
$lang['datetime']['Jan'] = '01';
$lang['datetime']['Feb'] = '02';
$lang['datetime']['Mar'] = '03';
$lang['datetime']['Apr'] = '04';
$lang['datetime']['May'] = '05';
$lang['datetime']['Jun'] = '06';
$lang['datetime']['Jul'] = '07';
$lang['datetime']['Aug'] = '08';
$lang['datetime']['Sep'] = '09';
$lang['datetime']['Oct'] = '10';
$lang['datetime']['Nov'] = '11';
$lang['datetime']['Dec'] = '12';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'מידע';
$lang['Critical_Information'] = 'מידע גורלי';

$lang['General_Error'] = 'שגיאה כללית';
$lang['Critical_Error'] = 'שגיאה חמורה';
$lang['An_error_occured'] = 'התרחשה שגיאה';
$lang['A_critical_error'] = 'התרחשה שגיאה חמורה';

$lang['Admin_reauthenticate'] = 'כדי לנהל את הפורום אתה צריך לאמת את זהותך שנית.';

$lang['Login_attempts_exceeded'] = 'עברת את המספר המירבי של נסיונות ההתחברות, העומד על %s. אינך רשאי להתחבר במשך %s הדקות הבאות.';
$lang['Please_remove_install_contrib'] = 'אנא וודא שמחקת את התקיות /install ו- contrib/ ';

$lang['Session_invalid'] = 'שגיאה בזיהוי. אנא נסה לשלוח שוב.';


//
// That's all Folks!
// -------------------------------------------------

?>