<?php

/***************************************************************************
 *                            lang_admin.php [Marathi]
 *                              -------------------
 *     begin                : Thu Aug 17 2006
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin.php,v 1.35.2.17 2006/02/05 15:59:48 grahamje Exp $
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

/* CONTRIBUTORS
	2002-12-15	Philip M. White (pwhite@mailhaven.com)
		Fixed many minor grammatical mistakes
*/
/*TRANSLATOR:   24-08-2006  Subodh D Gaikwad (subodh.dg@gmail.com)*/
//  http://subodh.info/
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'मुख्य नियंत्रण';
$lang['Users'] = 'सदस्य नियंत्रण';
$lang['Groups'] = 'गट नियंत्रण';
$lang['Forums'] = 'सार्वत्रिका नियंत्रण';
$lang['Styles'] = 'स्टॉईल नियंत्रण';

$lang['Configuration'] = 'रचना';
$lang['Permissions'] = 'परवानगी';
$lang['Manage'] = 'व्यवस्थापण';
$lang['Disallow'] = 'नाव प्रतिबंधित करा';
$lang['Prune'] = 'मिटवा';
$lang['Mass_Email'] = 'सार्वजनिक इमेल';
$lang['Ranks'] = 'हुद्दा';
$lang['Smilies'] = 'हसरे तारे';
$lang['Ban_Management'] = 'कंट्रोल प्रतिबंधित करा';
$lang['Word_Censor'] = 'शब्द सेंसर';
$lang['Export'] = 'निर्यात';
$lang['Create_new'] = 'तयार करा';
$lang['Add_new'] = 'टाका';
$lang['Backup_DB'] = 'डेटाबेस संचित';
$lang['Restore_DB'] = 'डेटाबेस पुर्ववत करा';


//
// Index
//
$lang['Admin'] = 'व्यवस्थापण';
$lang['Not_admin'] = 'तुम्हाला या सार्वत्रिकेचे व्यवस्थापण करण्याचा अधिकार नाही';
$lang['Welcome_phpBB'] = 'phpBB स्वागत आहे';
$lang['Admin_intro'] ='सार्वत्रिकेसाठी phpBB ची निवड केल्याबद्दल धन्यवाद. हे पृष्ठ तुम्हाला तुमच्या सार्वत्रिकेची सरासरी देईल. तुम्ही या पृष्ठावर डाव्या फ़लकातील <u>व्यवस्थापण</u> लिंकवर टिकटिक करून वापस जाऊ शकता. तुमच्या सार्वत्रिकेच्या मुखपृष्ठावर जाण्यासाठी डाव्या फ़लकातील phpbb लोगोवर टिकटिक करा.डाव्या बाजूतील बाकीच्या लिंक तुम्हाला सार्वत्रिकेच्या सर्व गोष्टी कंट्रोल करु देतील. प्रत्येक पृष्ठावर कसा वापर करावा याची माहिती आहे.';
$lang['Main_index'] = 'सार्वत्रिका मुखपृष्ठ';
$lang['Forum_stats'] = 'सार्वत्रिका सरासरी';
$lang['Admin_Index'] = 'व्यवस्थापण मुखपृष्ठ';
$lang['Preview_forum'] = 'सार्वत्रिका पुर्वदृश्य';

$lang['Click_return_admin_index'] = 'व्यवस्थापण मुखपृष्ठावर जाण्यासाठी %sHere%s येथे टिकटिक करा';

$lang['Statistic'] = 'सरासरी';
$lang['Value'] = 'किंमत';
$lang['Number_posts'] = 'लिखाणांची संख्या';
$lang['Posts_per_day'] = 'प्रतिदिन लिखाण';
$lang['Number_topics'] = 'विषयांची संख्या';
$lang['Topics_per_day'] = 'प्रतिदिन विषय';
$lang['Number_users'] = 'सदस्यांची संख्या';
$lang['Users_per_day'] = 'प्रतिदिन सदस्य';
$lang['Board_started'] = 'सार्वत्रिकेची सुरुवात';
$lang['Avatar_dir_size'] = 'अवतार डायरेक्टरीचा आकार';
$lang['Database_size'] = 'डेटाबेसचा आकार';
$lang['Gzip_compression'] ='Gzip आकुंचन';
$lang['Not_available'] = 'उपस्थित नाही';

$lang['ON'] = 'सुरु'; // This is for GZip compression
$lang['OFF'] = 'बंद'; 


//
// DB Utils
//
$lang['Database_Utilities'] = 'डेटाबेस Utilities';

$lang['Restore'] = 'पुर्ववत';
$lang['Backup'] = 'संचित';
$lang['Restore_explain'] = 'याद्वारे phpBB सारण्या सुरक्षित फ़ाईल मधुन पुर्व-वत करेल. जर तुमचा सर्वर सहायता देत असेल gzip-आकुंचित शब्द फ़ाईल अपलोड करू शकता आणि ती आपोआप प्रसरण पावेल. <b>सुचना</b>: यामूळे तुमची अगोदरच्या माहितीवर पून्हा लिहल्या जाईल.पुर्व-वत क्रियेला वेळ लागु शकतो, म्हनूण कृपया पुर्ण होईपर्यंत या पृष्ठापासून हटू नका.';
$lang['Backup_explain'] = 'येथे तुम्ही phpBB विषयीची माहिती संचित करु शकता. जर याच डेटाबेसमध्ये तुमच्या phpBB विषयी आणखी काही सारण्या असतील आणि तुम्हाला त्या पण संचित करायच्या असल्यास त्यांची नावे "," नी वेगळी करून खालील शब्दकप्प्यात लिहा. जर तुमचा सर्वर सहायता देत असेल gzip-आकुंचित शब्द फ़ाईल डाउनलोड करू शकता .';

$lang['Backup_options'] = 'संचित पर्याय';
$lang['Start_backup'] = 'संचित सुरु करा';
$lang['Full_backup'] = 'पुर्ण संचित';
$lang['Structure_backup'] = 'फ़क्त Structure संचित';
$lang['Data_backup'] = 'फ़क्त माहिती संचित';
$lang['Additional_tables'] = 'आणखी सारण्या';
$lang['Gzip_compress'] = 'Gzip compress फ़ाईल';
$lang['Select_file'] = 'फ़ाईल निवडा';
$lang['Start_Restore'] = 'पुर्व-वत सुरु करा';

$lang['Restore_success'] = 'डेटाबेस पुर्व-वत करण्यात आला आहे.<br /><br />तुमची सार्वत्रिका जेव्हा डेटाबेस संचित करण्यात आला त्याच स्थितीत आली आहे.';
$lang['Backup_download'] = 'तुमचे डाउनलोड थोड्या वेळात सुरु होईल. कृपया प्रतिक्षा करा.';
$lang['Backups_not_supported'] = 'माफ़ करा, परंतु तुमच्या डेटाबेस यंत्रणा करिता डेटाबेस संचित वापरता येणार नाही.';

$lang['Restore_Error_uploading'] = 'संचित फ़ाईल अप-लोड करतांना चूक होतेय';
$lang['Restore_Error_filename'] = 'फ़ाईल नाव चूक; कृपया दुसरी एखादी फ़ाईल वापरा';
$lang['Restore_Error_decompress'] = 'gzip फ़ाईल प्रसरण हॊत नाही आहे; कृपया साधी शब्द फ़ाईल अपलोड करा';
$lang['Restore_Error_no_file'] = 'कोणतीही फ़ाईल अपलोड झाली नाही';


//
// Auth pages
//
$lang['Select_a_User'] = 'सदस्य निवडा';
$lang['Select_a_Group'] = 'गट  निवडा';
$lang['Select_a_Forum'] = 'सार्वत्रिका  निवडा';
$lang['Auth_Control_User'] = 'सदस्य परवानगी कंट्रोल'; 
$lang['Auth_Control_Group'] = 'गट परवानगी कंट्रोल'; 
$lang['Auth_Control_Forum'] = 'सार्वत्रिका परवानगी कंट्रोल'; 
$lang['Look_up_User'] = 'सदस्य बघा'; 
$lang['Look_up_Group'] = 'गट बघा'; 
$lang['Look_up_Forum'] = 'सार्वत्रिका बघा'; 

$lang['Group_auth_explain'] = 'येथे प्रत्येक सदस्य गटाची परवानगी आणि असलेली निरिक्षक स्थिती बदलवू शकता. हे विसरु नका की गटाची परवानगी बदलवी तरी एक-एक सदस्याची परवानगी त्याला सार्वत्रिकेत प्रवेश करण्याची अनुमती देईल. असे असल्यास तुम्हाला सुचना येईल.';
$lang['User_auth_explain'] = 'येथे प्रत्येक सदस्याची परवानगी आणि असलेली निरिक्षक स्तर बदलवू शकता. हे विसरु नका की गटाची परवानगी बदलवी तरी एक-एक सदस्याची परवानगी त्याला सार्वत्रिकेत प्रवेश करण्याची अनुमती देईल. असे असल्यास तुम्हाला सुचना येईल.';
$lang['Forum_auth_explain'] = 'येथे प्रत्येक सार्वत्रिकेचा परवानगी स्तर बदलवू शकता. त्याकरिता तुमच्याजवळ साधी रित व विशेष रित आहे, विशेष रित प्रत्येक सार्वत्रिकेसाठी जास्त कंट्रोल देईल. हे लक्षात असु द्या की असे केल्यास जे सदस्य सार्वत्रिका वापरत आहे त्यांच्यावर फ़रक पडेल.';

$lang['Simple_mode'] = 'साधी रित';
$lang['Advanced_mode'] = 'विशेष रित';
$lang['Moderator_status'] = 'निरिक्षक स्तर';

$lang['Allowed_Access'] = 'अनुमती';
$lang['Disallowed_Access'] = 'अनुमती नकार';
$lang['Is_Moderator'] = 'निरिक्षक आहे';
$lang['Not_Moderator'] = 'निरिक्षक नाही';

$lang['Conflict_warning'] = 'अनुमती स्तर चुक सुचना';
$lang['Conflict_access_userauth'] = 'या सदस्याला गट सदस्यत्वाद्वारे या सार्वत्रिकेला प्रवेश आहे. प्रवेश नाकारण्यासाठी तुम्ही गटाची परवानगी किंवा या सदस्याचे त्या गटाचे सदस्यत्व बदलवू शकता. गटाचे अधिकार (आणि संबधित सार्वत्रिका) खाली दिलेले आहे';
$lang['Conflict_mod_userauth'] = 'या सदस्याला गट सदस्यत्वाद्वारे निरिक्षकाचे अधिकार आहेत. निरिक्षक अधिकार नाकारण्यासाठी तुम्ही गटाची परवानगी किंवा या सदस्याचे त्या गटाचे सदस्यत्व बदलवू शकता. गटाचे अधिकार (आणि संबधित सार्वत्रिका) खाली दिलेले आहे.';

$lang['Conflict_access_groupauth'] = 'या सदस्याला सदस्य परवानगीद्वाए या सार्वत्रिकेला प्रवेश आहे. प्रवेश नाकारण्यासाठी तुम्ही सदस्य परवानगी बदलवू शकता. सदस्य परवानगी अधिकार (आणि संबधित सार्वत्रिका) खाली दिलेले आहे.';
$lang['Conflict_mod_groupauth'] = 'या सदस्याला सदस्य परवानगीद्वारे निरिक्षक अधिकार आहेत. ते नाकारण्यासाठी तुम्ही  या सदस्याचे सदस्य परवानगी बदलवू शकता.  सदस्य परवानगी अधिकार (आणि संबधित सार्वत्रिका) खाली दिलेले आहे.';

$lang['Public'] = 'सार्वजनिक';
$lang['Private'] = 'खाजगी';
$lang['Registered'] = 'नॊंदित';
$lang['Administrators'] = 'व्यवस्थापकं';
$lang['Hidden'] = 'लपलेला';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'सर्व';
$lang['Forum_REG'] = 'नॊंदित';
$lang['Forum_PRIVATE'] = 'खाजगी';
$lang['Forum_MOD'] = 'निरिक्षक';
$lang['Forum_ADMIN'] = 'व्यवस्थापक';

$lang['View'] = 'बघा';
$lang['Read'] = 'वाचण';
$lang['Post'] = 'लिखाण';
$lang['Reply'] = 'प्रतिक्रिया';
$lang['Edit'] = 'संपादन';
$lang['Delete'] = 'मिटवा';
$lang['Sticky'] = 'स्टिकी';
$lang['Announce'] = 'घोषणा'; 
$lang['Vote'] = 'मत';
$lang['Pollcreate'] = 'कौल तैयार';

$lang['Permissions'] = 'परवानगी';
$lang['Simple_Permission'] = 'साधी परवानगी';

$lang['User_Level'] = 'सदस्य स्तर'; 
$lang['Auth_User'] = 'सदस्य';
$lang['Auth_Admin'] = 'व्यवस्थापक';
$lang['Group_memberships'] = 'गट सदस्यता';
$lang['Usergroup_members'] = 'या गटात खालिल सदस्य आहेत';

$lang['Forum_auth_updated'] = 'सार्वत्रिका परवानगी नुतनीकरण';
$lang['User_auth_updated'] = 'सदस्य परवानगी नुतनीकरण';
$lang['Group_auth_updated']= 'गट परवानगी नुतनीकरण';

$lang['Auth_updated'] = 'परवानगी नुतनीकरण';
$lang['Click_return_userauth'] = 'सदस्य परवानगी कडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';
$lang['Click_return_groupauth'] = 'गट परवानगी कडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';
$lang['Click_return_forumauth'] = 'सार्वत्रिका परवानगी कडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';


//
// Banning
//
$lang['Ban_control'] = 'प्रतिबंध कंट्रोल ';
$lang['Ban_explain'] = 'येथे तुम्ही सदस्याला प्रतिबंधित करू शक्ता. तुम्ही हे त्याला एकट्याला प्रतिबंध करुन किंवा एखाद्या IP ला प्रतिबंध करुन किंवा IP ची मर्यादा प्रतिबंधित करुन किंवा hostname ला प्रतिबंध करुन करु शकता. या द्वारे सदस्याला सार्वत्रिकेच्या मुखपृष्ठावर जाण्यापासुन देखिल प्रतिबंध करेल. त्या सदस्याला दुसय्रा एखाद्या सदस्य नावाखाली नॊंद करु न देण्यासाठी त्याचा इमेलदेखील प्रतिबंधित करू शकता. हे लक्षात घ्या की फ़क्त इमेल प्रतिबंधित करुन त्या सदस्याला प्रवेश करण्यास किंवा लिखाण करण्यास प्रतिबंध करता येणार नाही. हे करण्यासाठी तुम्ही सुरवातीच्या पहिल्या दोन पध्दती वापराव्या लागतील.';
$lang['Ban_explain_warn'] = 'कृपया लक्षात घ्या की IP ची मर्यादा दिल्यामूळे सुरवातीपासून शेवटपर्यंत सगळे IP प्रतिबंध यादित जाईल.योग्य तेथे wildcards चा उपयोग करून हे कमी करू शकता. जर तुम्हाला मर्यादा द्यायचीच असेल तर ती लहान ठेवा किंवा तो विशिष्ट IP नमुद करा.';

$lang['Select_username'] = 'सदस्य नाव निवडा';
$lang['Select_ip'] = 'IP निवडा';
$lang['Select_email'] = 'इमेल निवडा';

$lang['Ban_username'] = 'एक किंवा एकापेक्षा अधिक सदस्य प्रतिबंधित करा';
$lang['Ban_username_explain'] = 'mouse आणि keyboard चा तुमच्या संगणकासाठी व ब्राउझरसाठी योग्य वापर करून अनेक सदस्य एकाचवेळी प्रतिबंधित करू शकता.';

$lang['Ban_IP'] = 'एक किंवा अनेक IP किंवा hostnames प्रतिबंधित करा';
$lang['IP_hostname'] = 'IP किंवा hostnames';
$lang['Ban_IP_explain'] = 'अनेक IP किंवा hostname नमुद करण्यासाठी त्यांना "," नी वेगळे करा. IP ची मर्यादा देण्यासाठी सुरवात आणि शेवट '-' नी वेगळे करा;  wildcard देण्यासाठी, '*' चा उपयोग करा.';

$lang['Ban_email'] = 'एक किंवा एकापेक्षा जास्त इमेल प्रतिबंधित करा';
$lang['Ban_email_explain'] = 'अनेक इमेल नमुद करण्यासाठी त्यांना "," नी वेगळे करा.सदस्य नावाला wildcard देण्यासाठी, '*' चा उपयोग करा जसे की *@xyz.com';

$lang['Unban_username'] = 'एक किंवा एकापेक्षा अधिक सदस्य प्रतिबंधित हटवा';
$lang['Unban_username_explain'] = 'mouse आणि keyboard चा तुमच्या संगणकासाठी व ब्राउझरसाठी योग्य वापर करून अनेक सदस्य एकाचवेळी प्रतिबंधित हटवू शकता';

$lang['Unban_IP'] = 'एक किंवा अनेक IP किंवा hostnames प्रतिबंधित हटवा';
$lang['Unban_IP_explain'] = 'mouse आणि keyboard चा तुमच्या संगणकासाठी व ब्राउझरसाठी योग्य वापर करून अनेक IP चा एकाचवेळी प्रतिबंधित करू शकता';

$lang['Unban_email'] = 'एक किंवा अनेक इमेलंचा प्रतिबंधित हटवा';
$lang['Unban_email_explain'] = 'mouse आणि keyboard चा तुमच्या संगणकासाठी व ब्राउझरसाठी योग्य वापर करून अनेक इमेलं चा एकाचवेळी प्रतिबंधित हटवू शकता';

$lang['No_banned_users'] = 'प्रतिबंधित सदस्य नाव नाही';
$lang['No_banned_ip'] = 'प्रतिबंधित IP नाहीत';
$lang['No_banned_email'] = 'प्रतिबंधित इमेल नाहीत';

$lang['Ban_update_sucessful'] = 'प्रतिबंधित यादीचे यशस्वी नुतनीकरण';
$lang['Click_return_banadmin'] = 'प्रतिबंधित कंट्रोलवर वापस जाण्यासाठी  %sयेथे%s टिक-टिक करा';


//
// Configuration
//
$lang['General_Config'] = 'साधारण रचना';
$lang['Config_explain'] = 'खालिल फ़ार्मद्वारे तुम्ही सार्वत्रिकेचे साधारण सर्व पर्याय स्वतः ठरवू शकता. सदस्य आणि सार्वत्रिकेच्या रचनेसाठी डाव्या बाजुतील संबंधित संकेतांचा वापर करा.';

$lang['Click_return_config'] = 'साधारण रचनेकडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['General_settings'] = 'साधारण सार्वत्रिका नियंत्रण';
$lang['Server_name'] = 'संकेतस्थळ डोमेन नाव';
$lang['Server_name_explain'] = 'ज्या संकेतस्थळावर ही सार्वत्रिका आहे त्याचे डोमेन नाव';
$lang['Script_path'] = 'स्क्रिप्ट मार्ग';
$lang['Script_path_explain'] = 'संकेतस्थळाशी संबंधित phpBB2 चा मार्ग ';
$lang['Server_port'] = 'सर्वर पोर्ट';
$lang['Server_port_explain'] = 'ज्या पोर्टवर सर्वर चालत आहे,साधारणतः 80 असतो. दुसरा असेल तरच बदलवा';
$lang['Site_name'] = 'संकेतस्थळ नाव';
$lang['Site_desc'] = 'संकेतस्थळ माहिती';
$lang['Board_disable'] = 'सार्वत्रिका बंद';
$lang['Board_disable_explain'] = 'यामूळे सद्स्यांकरिता सार्वत्रिका बंद राहील. सार्वत्रिका बंद असतांना मात्र व्यवस्थापक व्यवस्थापण फ़लकचा वापरू शकेल.';
$lang['Acct_activation'] = 'खाते सुरु ';
$lang['Acc_None'] = 'एकही नाही'; // These three entries are the type of activation
$lang['Acc_User'] = 'सदस्य';
$lang['Acc_Admin'] = 'व्य्वस्थापक';

$lang['Abilities_settings'] = 'सदस्य आणि सार्वत्रिकेची सर्वसाधारण नियंत्रण';
$lang['Max_poll_options'] = 'कौलाचे जास्तीत जास्त पर्याय';
$lang['Flood_Interval'] = 'पुराचे अंतर';
$lang['Flood_Interval_explain'] = 'सदस्याने लिखाणांमध्ये सेकंद वाट बघावी'; 
$lang['Board_email_form'] = 'सार्वत्रिकाद्वारे सदस्याकरिता इमेल';
$lang['Board_email_form_explain'] = 'सार्वत्रिकाद्वारे सदस्य एकमेकांना इमेल पाठवू शकतील.';
$lang['Topics_per_page'] = 'प्रति-पृष्ठ विषय';
$lang['Posts_per_page'] = 'प्रति-पृष्ठ लिखाण';
$lang['Hot_threshold'] = 'रंगलेल्या विषयासाठी लिखाण';
$lang['Default_style'] = 'ठराविक रंगरूप';
$lang['Override_style'] = 'सदस्याने निवडलेले रंगरूप बाद करा';
$lang['Override_style_explain'] = 'सदस्याने निवडलेले रंगरूप ठराविक रंगरुपाने बदलतील';
$lang['Default_language'] = 'ठराविक भाषा';
$lang['Date_format'] = 'दिनांक नमुना';
$lang['System_timezone'] = 'यंत्रणेची वेळ-पद्धत';
$lang['Enable_gzip'] = 'GZip आकुंचन सुरु करा';
$lang['Enable_prune'] = 'सार्वत्रिका स्वच्छ करणे सुरु करा';
$lang['Allow_HTML'] = 'HTML संमती';
$lang['Allow_BBCode'] ='BBCode संमती';
$lang['Allowed_tags'] = 'HTML tags संमती';
$lang['Allowed_tags_explain'] = 'tags सल्पविरामाद्वारे वेगळे करा';
$lang['Allow_smilies'] = 'हसय्रा ताय्रांना संमती';
$lang['Smilies_path'] = 'हसय्रा ताय्रांचा मार्ग';
$lang['Smilies_path_explain'] = 'phpBB मुख्य डायरेक्टरीशी निगडित मार्ग, उदा.images/smiles';
$lang['Allow_sig'] = 'सही संमती';
$lang['Max_sig_length'] = 'सहीची जास्तीत जास्त लांबी';
$lang['Max_sig_length_explain'] = 'सहीत जास्तीत जास्त अक्षरे';
$lang['Allow_name_change'] = 'सदस्य नाव बदलविण्यास संमती';

$lang['Avatar_settings']= 'अवतार नियंत्रण';
$lang['Allow_local'] = 'अवतार संग्रहालय सुरु';
$lang['Allow_remote'] = 'दुरच्या अवतारांना संमती';
$lang['Allow_remote_explain'] = 'दुसय्रा संकेतस्थळावर असलेले अवतार';
$lang['Allow_upload'] = 'अवतार अपलोडींग सुरु';
$lang['Max_filesize'] = 'अवतारचे आकारमान';
$lang['Max_filesize_explain'] = 'अपलोडेड अवतार फ़ाईल करिता';
$lang['Max_avatar_size'] = 'अवतारचा जास्तीत जास्त आकार';
$lang['Max_avatar_size_explain'] = '(लांबी x रंदी पिक्सेलमध्ये)';
$lang['Avatar_storage_path'] = 'अवतार साठणूक मार्ग';
$lang['Avatar_storage_path_explain'] = 'phpBB मुख्य डयरेक्टरीशी संबधित मार्ग, उदा. images/avatars';
$lang['Avatar_gallery_path'] = 'अवतार संग्रहालय मार्ग';
$lang['Avatar_gallery_path_explain'] = 'phpBB मुख्य डयरेक्टरीशी संबधित मार्ग,उदा. images/avatars/gallery';

$lang['COPPA_settings'] = 'COPPA नियंत्रण';
$lang['COPPA_fax'] = 'COPPA फ़ॅक्स क्रमांक';
$lang['COPPA_mail'] = 'COPPA पत्रव्यवहाराचा पत्ता';
$lang['COPPA_mail_explain'] = 'हा पत्रव्यवहाराचा पत्ता आहे जिथे पालकांनी COPPA नोंदणी फ़ार्म पाठवावा';

$lang['Email_settings'] = 'इमेल नियंत्रण';
$lang['Admin_email'] = 'व्यवस्थापक इमेल पत्ता';
$lang['Email_sig'] = 'पत्र सही';
$lang['Email_sig_explain'] = 'ही शब्दावली सार्वत्रिकेद्वारे पाठविल्या जाणाय्रा सर्व इमेलला जोडली जाईल.';
$lang['Use_SMTP'] = 'इमेलकरिता SMTP सर्वर चा वापर करा';
$lang['Use_SMTP_explain'] = 'स्थानिक इमेल फ़ंक्शनच्या ऎवजी नमुद केलेल्या सर्वरद्वारे इमेल पाठवायचा असल्यास हो म्हणा.';
$lang['SMTP_server'] = 'SMTP सर्वर पत्ता';
$lang['SMTP_username'] = 'SMTP सदस्य नाव';
$lang['SMTP_username_explain'] = 'जर तुमच्या SMTP सर्वरला आवश्यक असेल तर सद्स्य नाव नमुद करा';
$lang['SMTP_password'] = 'SMTP परवलिचा शब्द';
$lang['SMTP_password_explain'] = 'जर तुमच्या SMTP सर्वरला आवश्यक असेल तर परवलिचा शब्द नमुद करा';

$lang['Disable_privmsg'] = 'खाजगी संदेश यंत्रणा';
$lang['Inbox_limits'] = 'आंतर-पत्रपेटीसाठी जास्तीत जास्त संदेश';
$lang['Sentbox_limits'] = 'बाह्य-पत्रपेटीसाठी जास्तीत जास्त संदेश';
$lang['Savebox_limits'] = 'सुरक्षित-पत्रपेटीसाठी जास्तीत जास्त संदेश';

$lang['Cookie_settings'] = 'Cookie नियंत्रण'; 
$lang['Cookie_settings_explain'] = 'ही माहीती हे सांगेल की cookies तुमच्या सदस्यांच्या ब्राउझरला कसे पाठवल्या जाईल. बय्राच वेळेस ठरावीक योग्य असते, पण तुम्हाला बदलवायची असल्यास योग्य प्रकारे बदलवा--चुकिमुळे सदस्यांना प्रवेश करता येणार नाही';
$lang['Cookie_domain'] = 'Cookie डोमेन';
$lang['Cookie_name'] = 'Cookie नाव';
$lang['Cookie_path'] = 'Cookie मार्ग';
$lang['Cookie_secure'] = 'Cookie सुरक्षिता';
$lang['Cookie_secure_explain'] = 'जर तुमचा सर्वर SSL द्वारे चालत असेल तर, हे सुरु करा, नाहीतर बंदच असुद्या';
$lang['Session_length'] = 'वापर कालावधी [ सेकंद ]';

// Visual Confirmation
$lang['Visual_confirm'] = 'दृष्टी पक्कीकरण सुरु';
$lang['Visual_confirm_explain'] = 'नॊंद करतांना उपयोगकर्त्याला चित्रावरील कोड टाकावा लागेल.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'आपोआप प्रवेश सुरु';
$lang['Allow_autologin_explain'] = 'सद्स्याचा आपोआप सार्वत्रिकेला भेट दिल्याबरोबर प्रवेश होईल का हे ठरवा';
$lang['Autologin_time'] = 'आपोआप प्रवेश संपूष्टी';
$lang['Autologin_time_explain'] = 'जर सदस्याने भेट दिली नाही तर आपोआप प्रवेश किती दिवसांसाठी सुरु राहील. संपुष्टी रद्द करण्यासाठी 0 लिहा.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'शोध पुर कालावधी';
$lang['Search_Flood_Interval_explain'] = 'सद्स्याने शोधांच्या मध्ये किती सेकंद वात बघावी'; 

//
// Forum Management
//
$lang['Forum_admin'] = 'सार्वत्रिका व्यवस्थापण';
$lang['Forum_admin_explain'] = 'या फ़लकाद्वारे तुम्ही विभाग आणि सार्वत्रिका टाकू, वगळु , संपादित, पुर्न-क्रम आणि व्यवस्थित करु शकता';
$lang['Edit_forum'] = 'सार्वत्रिका संपादन';
$lang['Create_forum'] = 'नविन सार्वत्रिका';
$lang['Create_category'] = 'नविन विभाग';
$lang['Remove'] = 'वगळा';
$lang['Action'] = 'क्रिया';
$lang['Update_order'] = 'क्रम नुतनीकरण';
$lang['Config_updated'] = 'सार्वत्रिकेच्या रचनेचे यशस्वी नुतनीकरण';
$lang['Edit'] = 'संपादन';
$lang['Delete'] = 'वगळा';
$lang['Move_up'] = 'वर करा';
$lang['Move_down'] = 'खाली करा';
$lang['Resync'] = 'व्यवस्थित';
$lang['No_mode'] = 'रित ठरवलेली नाही';
$lang['Forum_edit_delete_explain'] = 'खालिल फ़ार्मद्वारे तुम्ही सार्वत्रिकेचे साधारण पर्याय ठरवू शकता. सदस्याच्या आणि सार्वत्रिकेच्या रचनेसाठी डाव्या बाजुच्या संबंधित संकेतांचा वापर करा';

$lang['Move_contents'] = 'सर्व माहिती हलवा';
$lang['Forum_delete'] = 'सार्वत्रिका वगळा';
$lang['Forum_delete_explain'] = 'खालिल फ़ार्मद्वारे तुम्ही सार्वत्रिका (किंवा विभाग) वगळु शकता आणि त्यात असलेले सर्व विषय (किंवा सार्वत्रिका) कोठे ठेवावेत हे ठरवू शकता.';

$lang['Status_locked'] = 'बंधिस्त';
$lang['Status_unlocked'] = 'बंधिस्त नाही';
$lang['Forum_settings'] = 'साधारण सार्वत्रिका नियंत्रण';
$lang['Forum_name'] = 'सार्वत्रिका नाव';
$lang['Forum_desc'] = 'माहिती';
$lang['Forum_status'] = 'सार्वत्रिका स्थिती';
$lang['Forum_pruning'] = 'आपोआप-स्वच्छता';

$lang['prune_freq'] = 'प्रत्येक वेळेस विषयाची आयु तपासा';
$lang['prune_days'] = 'इतक्या दिवसांत ज्या विषयात लिखाण झाले नाही ते वगळा';
$lang['Set_prune_data'] = 'तुम्ही आपोआप-स्वच्छता या सार्वत्रिकेसाठी सुरु केले आहे पण तुम्ही वारंवारता किंवा दिवसांची संख्या ठरवली नाही. कृपया मागे जाऊन ते ठरवा.';

$lang['Move_and_Delete'] = 'हलवा व वगळा';

$lang['Delete_all_posts'] = 'सर्व विषय वगळा';
$lang['Nowhere_to_move'] = 'येथे हलवा';

$lang['Edit_Category'] = 'विभाग संपादन';
$lang['Edit_Category_explain'] = 'या फ़ार्म द्वारे तुम्ही विभागाचे नाव बदलवू शकता.';

$lang['Forums_updated'] = 'सार्वत्रिका आणि विभाग माहितीचे यशस्वीपणे नुतनीकरण';

$lang['Must_delete_forums'] = 'हा विभाग वगळण्यापुर्वी तुम्ही त्यातील सर्व सार्वत्रिका वगळणे आवश्यक आहे.';

$lang['Click_return_forumadmin'] = 'सार्वत्रिका व्यवस्थापणाकडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';


//
// Smiley Management
//
$lang['smiley_title'] = 'हसरे तारे संपादन';
$lang['smile_desc'] = 'या पृष्ठापासून तुम्ही भावना किंवा हसरे तारे टाकू, वगळू आणि संपादित करू शकता जे तुमचे सदस्य त्यांच्या लिखाणात व खाजगी संदेशात वापरू शकतात.';

$lang['smiley_config'] = 'हसरे ताय्रांची रचना';
$lang['smiley_code'] = 'हसरे तारे कोड';
$lang['smiley_url'] = 'हसरे तारे चित्र फ़ाईल';
$lang['smiley_emot'] = 'हसरे तारे फ़ाईल';
$lang['smile_add'] = 'हसरे तारा टाका';
$lang['Smile'] = 'हसरे';
$lang['Emotion'] = 'भावना';

$lang['Select_pak'] = 'हसरे ताय्रांचा गठ्ठा (.pak) फाईल निवडा';
$lang['replace_existing'] = 'असलेले हसरे तारे बदलवा';
$lang['keep_existing'] = 'असलेले हसरे तारे ठेवा';
$lang['smiley_import_inst'] = 'हसरे ताय्रांच्या गठ्ठ्यातून फ़ाईल काढून त्या फ़ाईल योग्य डायरेक्टरीत installation साठी अप-लोड करा. त्यानंतर या फ़ार्ममधून योग्य माहिती निवडून हसरे तारे आयात करा.';
$lang['smiley_import'] = 'हसरे तारे गठ्ठा आयात करा';
$lang['choose_smile_pak'] = 'हसरे ताय्रांचा गठ्ठा (.pak) फाईल निवडा';
$lang['import'] = 'हसरे तारे आयात करा';
$lang['smile_conflicts'] = 'अडचणीच्या वेळी काय करावे';
$lang['del_existing_smileys'] = 'हसरे तारे आयात करण्यापुर्वी असलेले हसरे तारे वगळा';
$lang['import_smile_pack'] = 'हसरे तारे गठ्ठा आयात करा';
$lang['export_smile_pack'] = 'हसरे तारे गठ्ठा तयार करा';
$lang['export_smiles'] = 'installed हसरे ताय्रांचा गठ्ठा तयार करण्यासाठी, smiles.pak फ़ाईल डाउनलॊड करण्यासाठी %sयेथे%s टिक-टिक करा.या फ़ाईलला .pak शेपुट ठेवून योग्य नाव द्या. त्यानंतर या सर्व हसय्रा ताय्रांची व या .pak फ़ाईल ची.zip फ़ाईल तयार करा.';

$lang['smiley_add_success'] = 'हसरे तारे यशस्वीपणे टाकता आले';
$lang['smiley_edit_success'] = 'हसरे तारे नुतन झाले';
$lang['smiley_import_success'] = 'हसरे तारे गठ्ठा यशस्वीपणे आयात झाला!';
$lang['smiley_del_success'] = 'हसरे तारे यशस्वीपणे वगळले गेले';
$lang['Click_return_smileadmin'] = 'हसरे तारे व्यवस्थापणाकडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['Confirm_delete_smiley'] = 'हा हसरा तारा वगळण्याची तुम्हाला खात्री आहे का?';

//
// User Management
//
$lang['User_admin'] = 'सदस्य व्यवस्थापण';
$lang['User_admin_explain'] = 'येथे तुम्ही सदस्यांची माहिती व काही पर्याय बदलवू शकता. सदस्याची परवानगी बदलवण्यासाठी, कृपया सदस्य आणि गट परवानगी यंत्रणा वापरा.';

$lang['Look_up_user'] ='सदस्य बघा';

$lang['Admin_user_fail'] = 'सदस्याची  सदस्य माहितीचे नुतनीकरण होऊ शकले नाही.';
$lang['Admin_user_updated'] = 'सदस्याची  सदस्य माहितीचे नुतनीकरण झाले आहे.';
$lang['Click_return_useradmin'] = 'सदस्य व्यवस्थापणावर वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['User_delete'] = 'हा सदस्य वगळा';
$lang['User_delete_explain'] = 'हा सदस्य वगळण्यासाठी येथे टिक-टिक करा; हे वापस करता येणार नाही.';
$lang['User_deleted'] = 'हा सदस्य यशस्वीपणे वगळल्या गेला आहे.';

$lang['User_status'] = 'सदस्य सार्वत्रिकेवर आहे';
$lang['User_allowpm'] = 'खाजगी संदेश पाठविता येईल';
$lang['User_allowavatar'] = 'अवतार दाखवा';

$lang['Admin_avatar_explain'] = 'येथे तुम्ही सदस्याचा अवतार पाहू व वगळू शकता.';

$lang['User_special'] = 'खास व्यवस्थापकाच्या जागा';
$lang['User_special_explain'] = 'ह्या जागा सदस्य बदलवू शकत नाही. येथे तुम्ही त्यांचा स्तर आणि इतर पर्याय ठरवु शकता.';


//
// Group Management
//
$lang['Group_administration'] = 'गट व्यवस्थापण';
$lang['Group_admin_explain'] = 'या फ़लकाद्वारे तुम्ही सर्व सद्स्य वर्गाचेव्यवस्थापण करू शकता. तुम्ही असलेला वर्ग वगळू, तयार किंवा संपादन करू शकता. तुम्ही निरिक्षक निवडू शकता, वर्ग स्तर सुरु/बंद करू शकता आणि वर्ग नाव व माहिती देऊ शकता';
$lang['Error_updating_groups'] = 'या गटाचे नुतनीकरण करताना चूक होत आहे';
$lang['Updated_group'] = 'या गटाचे नुतनीकरण यशस्वीपणे झाले आहे.';
$lang['Added_new_group'] = 'नविन गट यशस्वीपणे तयार झाला आहे';
$lang['Deleted_group'] = 'हा गट यशस्वीपणे वगळल्या गेला आहे';
$lang['New_group'] = 'नविन गट तयार करा';
$lang['Edit_group'] = 'गट संपादित करा';
$lang['group_name'] = 'गट नाव';
$lang['group_description'] = 'गत माहिती';
$lang['group_moderator'] = 'गट निरिक्षक';
$lang['group_status'] = 'गट स्तर';
$lang['group_open'] = 'गट उघडा';
$lang['group_closed'] = 'गट बंद करा';
$lang['group_hidden'] = 'गट लपवा';
$lang['group_delete'] = 'गट वगळा';
$lang['group_delete_check'] = 'हा गट वगळा';
$lang['submit_group_changes'] = 'बदल द्या';
$lang['reset_group_changes'] = 'बदल पुर्ववत करा';
$lang['No_group_name'] = 'या गटासाठी तुम्ही नाव दिलेच पाहिजे';
$lang['No_group_moderator'] = 'या गटासाठी तुम्ही निंयत्रक नेमलाच पाहिजे';
$lang['No_group_mode'] = 'या गटासाठी तुम्ही स्थिती निवडली पाहिजे,सुरु बंद';
$lang['No_group_action'] = 'कोणतीही क्रिया झाली नाही';
$lang['delete_group_moderator'] = 'गटाचा जुना निरिक्षक वगळा?';
$lang['delete_moderator_explain'] = 'जर तुम्ही गटाचा निरिक्षक बदलवत असाल, तर जुना निरिक्षक बाहेर काढण्यासाठी हा कप्पा निवडा. नाहीतर कप्पा निवडु नका आणि तो सदस्य या गटाचा नियमित सदस्य बनेल.';
$lang['Click_return_groupsadmin'] = 'गट व्यवस्थापणाकडे वापस जाण्याकरिता %sयेथे%s टिक-टिक करा.';
$lang['Select_group'] = 'गट निवडा';
$lang['Look_up_group'] = 'गट बघा';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'सार्वत्रिका स्वच्छता';
$lang['Forum_Prune_explain'] = 'यामूळे ज्या विषयात तुम्ही निवडलेल्या दिवसांत लिखाण झाले नाही ते विषय वगळले जातील. जर तुम्ही दिवस ठरविले नाहीत तर सर्व विषय वगळल्या जातील. याद्वारे ज्या विषयात कौल सुरु आहे किंवा ज्या घोषणा आहेत ते वगळल्या जाणार नाही, ते तुम्हाला स्वतः वगळावे लागतील.';
$lang['Do_Prune'] = 'स्वच्छता करा';
$lang['All_Forums'] = 'सर्व सार्वत्रिका';
$lang['Prune_topics_not_posted'] = ' ज्या विषयात इतक्या दिवसांत लिखाण झाले नाही ते विषय वगळा';
$lang['Topics_pruned'] = 'विषय वगळले';
$lang['Posts_pruned'] = 'लिखाण वगळले';
$lang['Prune_success'] = 'सार्वत्रिका यशस्वीपणे स्वच्छ झाली';


//
// Word censor
//
$lang['Words_title'] = 'शब्द सेंसर';
$lang['Words_explain'] = 'या कंट्रोल फ़लकाद्वारे तुम्ही शब्द आपोआप सेंसर करण्यासाठी शब्द टाकू, संपादित आणि वगळू शकता. त्याबरोबरच लोक हे शब्द असलेल्या सदस्य नावाने नोंद करू शकणार नाही.शब्दात Wildcards (*) चा उपयोग करू शकता. उदा. *test* हा detestable तसेच testing तसेच detest ला सेंसरींग करेल.';
$lang['Word'] = 'शब्द';
$lang['Edit_word_censor'] = 'शब्द सेंसर संपादन';
$lang['Replacement'] = 'याने बदलवा';
$lang['Add_new_word'] = 'नविन शब्द टाका';
$lang['Update_word'] = 'शब्द सेंसर नुतनीकरण';

$lang['Must_enter_word'] = 'तुम्ही शब्द व त्याऎवजी येणारा शब्द दिलाच पाहिजे';
$lang['No_word_selected'] = 'संपादनासाठी कोणताही शब्द निवडला नाही';

$lang['Word_updated'] = 'निवडलेल्या शब्दाचे सेंसर यशस्वीपणे नुतनीकरण झाले';
$lang['Word_added'] = 'शब्द सेंसर यशस्वीपणे टाकल्या गेले';
$lang['Word_removed'] = 'शब्द सेंसर यशस्वीपणे वगळले';

$lang['Click_return_wordadmin'] = 'शब्द सेंसर व्यवस्थापणाकडे परत जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['Confirm_delete_word'] = 'तुम्हाला हा शब्द सेंसर वगळायचा आहे का?';


//
// Mass Email
//
$lang['Mass_email_explain'] = 'येथे तुम्ही सर्व सदस्यांना किंवा विशिष्ट गटाच्या सर्व सदस्यांना एकसाथ इमेल पाठवू शकता. हे करण्यासाठी एक इमेल दिलेल्या व्यवस्थापक इमेल कडे जाईल, आणि एक रिकामी प्रत सर्व मिळणाय्रांना पाठविल्या जाईल. जर तुम्ही बय्राच सदस्यांना इमेल पाठवित असाल तर कृपया वाट बघा आणि पृष्ठ मधातच थांबवू नका. अशा इमेलला बराच वेळ लागतो. स्क्रिप्ट पूर्ण झाल्यावर तुम्हाला सूचना मिळेल.';
$lang['Compose'] = 'लिहा'; 

$lang['Recipients'] = 'प्रति'; 
$lang['All_users'] = 'सर्व सदस्य';

$lang['Email_successfull'] = 'तुमचा इमेल पाठविल्या गेला';
$lang['Click_return_massemail'] = 'अनेक इमेल फ़ार्मकडे परत जाण्यासाठी %sयेथे%s टिक-टिक करा';


//
// Ranks admin
//
$lang['Ranks_title'] = 'हुद्दा व्यवस्थापण';
$lang['Ranks_explain'] = 'या फ़ार्मचा उपयोग करून तुम्ही हुद्दा टाकू, संपादित,बघू व वगळू शकता. तुम्ही विशिष्ट हुद्दा तयार करू शकता जो सद्स्याला सदस्य व्यवस्थापणाद्वारे देता येईल.';

$lang['Add_new_rank'] = 'नविन हुद्दा टाका';

$lang['Rank_title'] = 'हुद्दा नाव';
$lang['Rank_special'] = 'खास हुद्दा ठेवा';
$lang['Rank_minimum'] = 'कमित-कमी लिखाण';
$lang['Rank_maximum'] = 'जास्तीत-जास्त लिखाण';
$lang['Rank_image'] = 'हुद्द्याचे चित्र (phpBB2 च्या मूख्य मार्गाशी संबंधित)';
$lang['Rank_image_explain'] = 'Use this to define a small image associated with the rank';

$lang['Must_select_rank'] = 'तुम्ही हुद्दा निवडलाच पाहिजे';
$lang['No_assigned_rank'] = 'विशिष्ट हुद्दा ठरविला नाही';

$lang['Rank_updated'] = 'हुद्दा यशस्वीप्रमाणे नुतन झाला';
$lang['Rank_added'] = 'हुद्दा यशस्वीप्रमाणे टाकला गेला';
$lang['Rank_removed'] = 'हुद्दा यशस्वीप्रमाणे वगळल्या गेला';
$lang['No_update_ranks'] = 'हुद्दा यशस्वीप्रमाणे वगळल्या गेला. तरीही जो सदस्य हा हुद्दा वापरत आहे त्याच्या खात्याचे नुतनीकरण झाले नाही. तुम्हाला स्वतः ते बरोबर करावे लागेल.';

$lang['Click_return_rankadmin'] = 'हुद्दा व्यवस्थापणाकडे परत जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['Confirm_delete_rank'] = 'तुम्हाला हा हुद्दा वगळण्याबाबत खात्री आहे का?';

//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'सद्स्य नाव प्रतिबंध कंट्रोल';
$lang['Disallow_explain'] = 'येथे तुम्ही तुम्हाला ज्या सदस्य नावांना प्रतिबंध करायचा आहे ते कंट्रोल करू शकता.प्रतिबंधित नावात wildcard अक्षर * असू शकते. कृपया लक्षात घ्या की अगोदरच त्या नावाने नॊंद झाली असल्यास तुम्ही तो प्रतिबंधित करू शकत नाही. तुम्ही पहिले ते नाव वगळा आणि नंतर प्रतिबंधित करा.';

$lang['Delete_disallow'] = 'वगळा';
$lang['Delete_disallow_title'] = 'प्रतिबंधित सदस्य नाव वगळा';
$lang['Delete_disallow_explain'] = 'तुम्ही प्रतिबंधित सदस्य नाव या सुचीतुन वगळण्यासाठी त्याला निवडून द्या वर टिक-टिक करा';

$lang['Add_disallow'] = 'टाका';
$lang['Add_disallow_title'] = 'प्रतिबंधित नाव टाका';
$lang['Add_disallow_explain'] = 'तुम्ही सद्स्य नाव wildcard * चा उपयोग करुन त्याला जुअळणाय्रा कोणत्याही अक्षरासह प्रतिबंधित करू शकता';

$lang['No_disallowed'] = 'प्रतिबंधित सदस्य नाव नाही';

$lang['Disallowed_deleted'] = 'प्रतिबंधित सदस्य नाव यशस्वीपणे वगळल्या गेले';
$lang['Disallow_successful'] = 'प्रतिबंधित सदस्य नाव यशस्वीपणे टाकल्या गेले';
$lang['Disallowed_already'] = 'तुम्ही दिलेले नाव प्रतिबंधित करू शकत नाही. एकतर ते अगोदरच या सुचीत आहे किंवा शब्द सेंसर सुचित आहे, किंवा जुडणारा सदस्य नाव अस्तित्वात आहे.';

$lang['Click_return_disallowadmin'] = 'प्रतिबंधित सदस्य नाव व्यवस्थापणाकडे जाण्यासाठी %sयेथे%s टिक-टिक करा';


//
// Styles Admin
//
$lang['Styles_admin'] = 'रंगरूप व्यवस्थापण';
$lang['Styles_explain'] = 'या सुविधाचा उपयोग करून तुम्ही रंगरुम टाकू, वगळु आणि सांभाळू शकता';
$lang['Styles_addnew_explain'] = 'खालिल यादित तुमच्याकडे असलेल्या templates साठी उपलब्ध थिम आहेत.या सुचीतिल थिम तुमच्या phpBB च्या डेटाबेसमध्ये installed नाही आहे. थिम install करण्यासाठी, सुचिच्या बाजुला अस्लेल्या install संकेतावर टिक-टिक करा.';

$lang['Select_template'] ='Template निवडा';

$lang['Style'] = 'रंगरूप';
$lang['Template'] = 'Template';
$lang['Install'] = 'Install';
$lang['Download'] = 'डाउनलोड';

$lang['Edit_theme'] = 'थिम संपादन';
$lang['Edit_theme_explain'] = 'खालिल फ़ार्ममध्ये तुम्ही निवडलेल्या थिमची स्थिती संपादित करू शकता';

$lang['Create_theme'] = 'थिम तयार करा';
$lang['Create_theme_explain'] = 'खालिल फ़ार्मचा उपयोग निवडलेल्या template साठी नविन थिम तयार करण्यासाठी करा. रंग देताना(hexadecimal चा वापर करा) तुम्ही सुरवात # यानी करू नका, उदा. CCCCCC बरोबर आहे, #CCCCCC हे नाही';

$lang['Export_themes'] = 'थिम निर्यात करा';
$lang['Export_explain'] = 'या फ़लकाद्वारे तुम्ही थिमची माहीती निवडलेल्या template साठी निर्यात करू शकता.खालिल सुचीतुन template निवडा आणि स्क्रिप्ट थिम रचना फ़ाईल तयार करिल आणि त्याला निवडलेल्या template डायरेक्टरित सुरक्षित ठेवण्याचा प्रयत्न करील. जर तो सुरक्षित ठेवू शकला नाही तर तुम्हाला डाउनलोड करण्याचा पर्याय देईल. सुरक्षित ठेवण्यासाठी तुम्ही सर्वरच्या template डायरेक्तरिला परवानगी दिली पाहिजे. अधिक माहितीसाठी phpBB 2 उपयोगकर्ता मार्गदर्शिका बघा.';

$lang['Theme_installed'] = 'निवडलेली थिम यशस्वीपणे installed झाली';
$lang['Style_removed'] = 'निवडलेले रंगरूप डेटाबेसमधुन वगळल्या गेले आहे.त्याला तुमच्या यंत्रणेतुन पुर्णपणे वगळण्यासाठी तो रंगरूप templates डायरेक्टरीतून वगळा.';
$lang['Theme_info_saved'] = 'निवडलेल्या template साठी थिमची माहिती सुरक्षित झाली आहे.तुम्ही आता theme_info.cfg फ़ाइलची परवानगी वापस फ़क्त वाचु शकू अशी ठेवा';
$lang['Theme_updated'] = 'निवडलेल्या थिमचे नुतनीकरण झाले आहे. तुम्ही नविन थिमची स्थिती निर्यात करू शकता';
$lang['Theme_created'] = 'थिम तयार झाली आहे.तुम्ही आता थिम सुरक्षित किंवा दुसरीकडे ठेवण्यासाठी थिम रचना फ़ाईलमध्ये निर्यात करायली हवी';

$lang['Confirm_delete_style'] = 'तुम्हाला हे रंगरूप वगळायचे आहे का?';

$lang['Download_theme_cfg'] = 'निर्यातक थिम माहिती फ़ाईल लिहू शकला नाही.template फ़ाइल असलेल्या डायरेक्टरीत निर्यात करण्यासाठी येथे टिक-टिक करा.नंतर कोठेही वापरण्यासाठी किंवा वाटण्यासाठी तुम्ही त्यांचा गठ्ठा बनवू शकता';
$lang['No_themes'] = 'निवडलेल्या template शी संबधित एकही थिम जुडलेली नाही. नविन थिम तयार करण्यासाठी डाव्या फ़लकातील नविन तयार करा या संकेतावर टिक-टिक करा';
$lang['No_template_dir'] = 'template डायरेक्टरी उघडू शकत नाही. ती बहुतेक सर्वर द्वारा न वाचता येणारी आहे किंवा अस्तित्वात नाही';
$lang['Cannot_remove_style'] = 'हा रंगरूप ठरविला असल्यामूळे वगळू शकत नाही. कृपया, ठरविला रंगरूप बदलवा आणि पुन्हा प्रयत्न करा.';
$lang['Style_exists'] = 'रंगरूपाचे निवडलेले नाव अगोदरच अस्तित्वात आहे, कृपया मागे जाऊन दुसरे नाव निवडा.';

$lang['Click_return_styleadmin'] = 'रंगरूप व्यवस्थापणाकडे वापस जाण्यासाठी %sयेथे%s टिक-टिक करा';

$lang['Theme_settings'] = 'थिम नियंत्रण';
$lang['Theme_element'] = 'थिम अवयव';
$lang['Simple_name'] = 'साधे नाव';
$lang['Value'] = 'किंमत';
$lang['Save_Settings'] = 'स्थिती सुरक्षित करा';

$lang['Stylesheet'] = 'CSS Stylesheet';
$lang['Stylesheet_explain'] = 'ही थिम वापरण्यासाठी CSS stylesheet चे फ़ाईलनाव .';
$lang['Background_image'] = 'पृष्ठामागचा चित्र';
$lang['Background_color'] ='पृष्ठामागचा रंग';
$lang['Theme_name'] = 'थिम नाव';
$lang['Link_color'] = 'संकेत रंग';
$lang['Text_color'] = 'शब्द रंग';
$lang['VLink_color'] = 'भेट दिलेल्या संकेताचा रंग';
$lang['ALink_color'] = 'सुरु असलेल्या संकेताचा रंग';
$lang['HLink_color'] = 'त्यावर नेल्यावर संकेत रंग';
$lang['Tr_color1'] = 'सारणी रांग रंग १';
$lang['Tr_color2'] = 'सारणी रांग रंग २';
$lang['Tr_color3'] = 'सारणी रांग रंग ३';
$lang['Tr_class1'] = 'सारणी रांग वर्ग १';
$lang['Tr_class2'] = 'सारणी रांग वर्ग २';
$lang['Tr_class3'] = 'सारणी रांग वर्ग ३';
$lang['Th_color1'] = 'सारणी मथळा रंग १';
$lang['Th_color2'] = 'सारणी मथळा रंग २';
$lang['Th_color3'] = 'सारणी मथळा रंग ३';
$lang['Th_class1'] = 'सारणी मथळा वर्ग १';
$lang['Th_class2'] = 'सारणी मथळा वर्ग २';
$lang['Th_class3'] = 'सारणी मथळा वर्ग ३';
$lang['Td_color1'] = 'सारणी जागा रंग १';
$lang['Td_color2'] = 'सारणी जागा रंग २';
$lang['Td_color3'] = 'सारणी जागा रंग ३';
$lang['Td_class1'] = 'सारणी जागा वर्ग १';
$lang['Td_class2'] = 'सारणी जागा वर्ग २';
$lang['Td_class3'] = 'सारणी जागा वर्ग ३';
$lang['fontface1'] = 'फ़ॉण्ट चेहरा १';
$lang['fontface2'] = 'फ़ॉण्ट चेहरा २';
$lang['fontface3'] = 'फ़ॉण्ट चेहरा ३';
$lang['fontsize1'] = 'फ़ॉण्ट आकार १';
$lang['fontsize2'] = 'फ़ॉण्ट आकार २';
$lang['fontsize3'] = 'फ़ॉण्ट आकार ३';
$lang['fontcolor1'] = 'अक्षरांचा रंग १';
$lang['fontcolor2'] = 'अक्षरांचा रंग २';
$lang['fontcolor3'] = 'अक्षरांचा रंग ३';
$lang['span_class1'] = 'Span वर्ग १';
$lang['span_class2'] = 'Span वर्ग २';
$lang['span_class3'] = 'Span वर्ग ३';
$lang['img_poll_size'] = 'कौल चित्र आकार [px]';
$lang['img_pm_size'] = 'खाजगि संदेश स्तर आकार्मान[px]';


//
// Install Process
//
$lang['Welcome_install'] = 'phpBB 2 Installation मध्ये स्वागत आहे';
$lang['Initial_config'] = 'साधारण रचना';
$lang['DB_config'] = 'डेटाबेस रचना';
$lang['Admin_config'] = 'व्यवस्थापण रचना';
$lang['continue_upgrade'] = 'तुम्ही एकदा config फ़ाईल तुमच्या स्थानिक संगणकावर डाउनलोड केल्यानंतर तुम्ही \'नुतनीकरण चालू ठेवा\' बटनावर टिक-टिक करून नुतनीकरण सुरु करू शकता. कृपया config फ़ाईल नुअतनीकरण प्रक्रिया पुर्ण होईपर्यंत अपलोड करा.';
$lang['upgrade_submit'] = 'नुतनीकरण चालू ठेवा';

$lang['Installer_Error'] = 'installation करताना चुक झाली आहे';
$lang['Previous_Install'] = 'मागिल installation शोधल्या गेले आहे';
$lang['Install_db_error'] = 'डेटाबेस नुतन करताना चुक झाली आहे';

$lang['Re_install'] = 'तुमचे installation अजुनही सुरु आहे..<br /><br/>जर तुम्हाला phpBB 2 re-install करायचे असेल तर हो बटनावर टिक-टिक करा. हे लक्षात घ्या की असे केल्यामूळे अगोदरची माहीती नष्ट होईल व संचित तयार होणार नाही!  re-installation नंतर व्यवस्थापक सदस्य नाव आणि परवलिचा शब्द पुन्हा तयार होईल आणि कोणतीच रचना वापस मिळणार नाही.<br /><br />हो! करण्यापुर्वी पुन्हा एकदा विचार करा';

$lang['Inst_Step_0'] = 'phpBB 2 निवडल्याबद्दल धन्यवाद. install पुर्न करण्यासाठी कृपया खालिल माहिती पुर्ण भरा. कृपया हे लक्षात घ्या की ज्या डेटाबेसमध्ये तुम्हाला install करायचा आहे तो अगोदरच अस्तित्वात असला पाहिजे.ज्या डेटाबेसमध्ये तुम्हाला install करायचा आहे तो जर ODBC, उदा. MS Access चा उपयोग करत असेल तर तुम्ही सुरवात करण्यापुर्वी DSN तयार करायला हवा.';

$lang['Start_Install'] = 'Install सुरु करा';
$lang['Finish_Install'] = 'Installation संपले';

$lang['Default_lang'] = 'सार्वत्रिकेची ठराविक भाषा';
$lang['DB_Host'] = 'डेटाबेस सर्वर Hostname / DSN';
$lang['DB_Name'] = 'तुमच्या डेटाबेसचे नाव';
$lang['DB_Username'] = 'डेटाबेस सदस्य नाव';
$lang['DB_Password'] = 'डेटाबेस परवलिचा शब्द';
$lang['Database'] = 'तुमचा डेटाबेस ';
$lang['Install_lang'] = 'Installation करिता भाषा निवडा';
$lang['dbms'] = 'डेटाबेस प्रकार';
$lang['Table_Prefix'] = 'डेटाबेसमध्ये सारणीची सुरवात';
$lang['Admin_Username'] = 'व्यवस्थापकाचा सदस्य नाव';
$lang['Admin_Password'] = 'व्यवस्थापकाचा परवलिचा शब्द';
$lang['Admin_Password_confirm'] = 'व्यवस्थापकाचा परवलिचा शब्द [ पक्का ]';

$lang['Inst_Step_2'] = 'तुमचा व्यावस्थापक सदस्य नाव तयार झाले. आता तुमचे साधारण installation पुर्ण झाले आहे. तुम्हाला तुमच्या नविन installation चे व्यवस्थापन करण्यासाठी नविन पृष्ठावर नेल्या जाईल. कृपया साधारण रचना तपासुन घ्या व योग्य ते बदल करा.phpBB 2 निवडल्याबद्दल धन्यवाद.';

$lang['Unwriteable_config'] = 'तुमची config फाईल सध्या लिहिल्या जाऊ शकत नाही. खालिल बटनावर टिक-टिक केल्यावर config फ़ाईल ची प्रती तुमच्या संगणकामध्ये डाउनलॊड हॊईल. तुम्ही हीच फ़ाईल त्याच phpBB 2 डायरेक्टरित अपलोद करावी लागेल. हे झाल्यावर तुम्ही व्यवस्थापक सद्स्य नाव आणि परवलिच्या शब्दाने प्रवेश करा आणि व्यवस्थापक कंट्रोल मुख्यालय (तुम्ही एकदा प्रवेश केल्यावर संकेत प्रत्येक प्रुष्ठाच्या खाली येईल) मध्ये प्रवेश करुन कृपया साधारण रचना तपासुन घ्या व योग्य ते बदल करा.phpBB 2 निवडल्याबद्दल धन्यवाद.';
$lang['Download_config'] = 'डाउनलोड Config';

$lang['ftp_choose'] = 'डाउनलोद रित निवडा';
$lang['ftp_option'] = '<br />या PHP च्या वर्जनमध्ये FTP extensions सुरु असल्यामुळॆ तुम्हाला आपोआप config फ़ाईल  त्या जागी FTP करता येईल.';
$lang['ftp_instructs'] = 'तुम्ही phpBB 2 असलेल्या खात्यात फ़ाईल आपोआप FTP करणे निवडले आहे.या सुविधाचा वापर करण्यासाठी कृपया खाली माहिती लिहा. कृपया लक्षात घ्या की जर तुम्ही साधारण FTP client वापरत असाल तर FTP चा मार्ग हा बरोबर  phpBB2 installation चाच हवा.';
$lang['ftp_info'] = 'तुमची FTP माहिती लिहा';
$lang['Attempt_ftp'] = 'त्या जागी config फ़ाईल FTP करण्याचा प्रयत्न';
$lang['Send_file'] = 'ती फ़ाईल मला पाठवा आणि मी ती स्वतः FTP करीन';
$lang['ftp_path'] = 'FTP  चा phpbb2 शी संबधीत मार्ग';
$lang['ftp_username'] = 'तुमचा FTP सदस्य नाव';
$lang['ftp_password'] = 'तुमचा FTP परवलिचा शब्द';
$lang['Transfer_config'] = 'पाठविण्यास सुरुवात करा';
$lang['NoFTP_config'] = 'त्या जागी config फ़ाईल FTP करण्यास अयशस्वी ठरले. कृपया config फ़ाईल स्वतः डाउनलोड करुन त्या जागी FTP करा.';

$lang['Install'] = 'Install';
$lang['Upgrade'] = 'नुतनीकरण';


$lang['Install_Method'] = 'तुमची installation रित निवडा';

$lang['Install_No_Ext'] = 'तुमच्या सर्वरवरील PHP configuration तुम्ही निवडलेल्या डेटाबेस प्रकाराला सहाय्यता देत नाही';

$lang['Install_No_PCRE'] = 'phpBB2 ला Perl- Compatible Regular Expressions Module ची आवश्यकता आहे जे तुमचे PHP configuration सहाय्यता देत नाही आहे!';

//
// Version Check
//
$lang['Version_up_to_date'] = 'तुमचे installation नविनतम आहे, phpBB वर्जनकरिता नुतनीकरण उपलब्ध नाही.';
$lang['Version_not_up_to_date'] = 'तुमचे installation <b>नविनतम नाही</b>.तुमच्या phpBB वर्जनकरिता नुतनीकरण उपलब्ध आहे, त्यासाठी कृपया <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> येथे भेट द्या.';
$lang['Latest_version_info'] = 'नविनतन  वर्जन <b>phpBB %s</b> हे आहे.';
$lang['Current_version_info'] = 'तुम्ही <b>phpBB %s</b> चालवित आहात.';
$lang['Connect_socket_error'] = 'phpBB सर्वरशी संपर्क साधण्यास असमर्थता. चुक आहे :<br />%s';
$lang['Socket_functions_disabled'] = 'socket फ़ंक्शन उपयोगात आणण्यास असमर्थता.';
$lang['Mailing_list_subscribe_reminder'] = 'नविनतम माहितीकरिता <a href="http://www.phpbb.com/support/"target="_new">सुचना संदेश यादी</a>त तुमचा इमेल समाविष्ट करा .';
$lang['Version_information'] = 'वर्जन माहिती';

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'स्वीकार्य प्रवेश प्रयत्न';
$lang['Max_login_attempts_explain'] = 'स्वीकार्य प्रवेश प्रयत्नांची संख्या.';
$lang['Login_reset_time'] = 'प्रवेश बंदिकरण वेळ';
$lang['Login_reset_time_explain'] = 'स्वीकार्य प्रवेश प्रयत्नांच्या वर प्रयत्न केल्यावर सदस्याला पुन्हा प्रवेश करण्यासाठी लागणारा वेळ मिनिटांमध्ये.';

//
// लोकांनो हेच सर्व काही!
// -------------------------------------------------

?>