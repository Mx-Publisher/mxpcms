<?php
/***************************************************************************
 *                         lang_bbcode.php [marathi]
 *                            -------------------
 *   begin                : Wednesday Oct 3, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: lang_bbcode.php,v 1.3.2.2 2002/12/18 15:40:20 psotfx Exp $
 *
 *
 ***************************************************************************/

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
		Fixed many minor grammatical problems.
*/
/*TRANSLATOR:   24-08-2006  Subodh D Gaikwad (subodh.dg@gmail.com)*/
//  http://subodh.info/
// To add an entry to your BBCode guide simply add a line to this file in this format:
//$faq[] = array("प्रश्न", "उत्तर");
// If you want to separate a section enter$faq[] = array("--","येथे मथळा तुम्हाला हवा असल्यास");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your BBCode guide entries, if you absolutely must then escape them ie. \"something\";
//
// The BBCode guide items will appear on the BBCode guide page in the same order they are listed in this file
//
// If just translating this file please do not alter the actual HTML unless absolutely necessary, thanks :)
//
// In addition please do not translate the colours referenced in relation to BBCode any section, if you do
// users browsing in your language may be confused to find they're BBCode doesn't work :D You can change
// references which are 'in-line' within the text though.
//

$faq[] = array("--","माहीती");
$faq[] = array("BBCode काय आहे?", "BBCode हा HTMLचा विशेष उपयोग आहे. तुम्ही सार्वत्रिकेच्या लिखाणात BBCode वापरू शकता की नाही हे व्यवस्थापकावर ठरविल्या जाते. लिखाण फ़ार्मद्वारा तुम्ही प्रत्येक लिखाणानुसार BBCODE रद्द ठरवू शकता. BBCode हा स्वतःच HTML प्रमाणे आहे: tags येथे चौकोनी कंसात [ ] असतात ;&lt आणि &gt; हे काय आणइ कसे दिसेल यावर जास्त निंयत्रण देते.तुम्ही वापरत असलेल्या template नुसार तुम्हाला असे दिसून येईल की लिखाण फ़ार्मच्या वरच्या संदेश जागेत फ़क्त टिक-टिक करून हे BBcode तुम्हाला वापरता येतात. यासोबतदेखिल खालिल मार्गदर्शिका तुम्हाला फ़ायद्याची ठरेल.");

$faq[] = array("--","शब्द पद्धत");
$faq[] = array("जाडे, वाकडे किंवा रेघोषित शब्द असे तयार करावे", "BBCode मधिल tag तुम्हाला तुमच्या शब्दाची पद्धत बदलवु देतील. हे खालिलप्रमाणे करता येईल : <ul><li>शब्द जाडे करण्यासाठी त्यंना <b>[b][/b]</b> मध्ये बंधिस्त करा, उदा. <br /><br /><b>[b]</b>नमस्कार<b>[/b]</b><br /><br />हे <b>नमस्कार</b>असे बनेल.</li><li>रेघोषित करण्यासाठी <b>[u][/u]</b>, उदा:<br /><br /><b>[u]</b>शुभ प्रभात<b>[/u]</b><br /><br />हे <u>शुभ प्रभात</u>असे बनेल</li><li>वाकडे करण्यासाठी <b>[i][/i]</b>, उदा.<br /><br />हा आहे<b>[i]</b>चमत्कार!<b>[/i]</b><br/><br />हे हा आहे<i>चमत्कार!</i>असे बनेल</li></ul>");
$faq[] = array("शब्दांचा रंग किंवा आकार कसा बदलावा", "शब्दांचा रंग किंवा आकार बदलविण्यासाठी खालिल tags वापरता येईल. कृपया लक्षात घ्या की हे दिसणे बघणाय्राच्या ब्राउजरवर व यंत्रणेवर अवलंबून आहे: <ul><li>शब्दांचा रंग बदलविण्याकरिता त्यांना <b>[color=][/color]</b> मध्ये बंधिस्त करा. तुम्ही एक तर रंगाचे नाव (उदा. red, blue, yellow, इत्यादी.) किंवा hexadecimal उदा. #FFFFFF, #000000 चा वापर करू शकता. उदाहरण, लाल अक्षर तयार करण्यासाठी :<br /><br /><b>[color=red]</b>नमस्कार!<b>[/color]</b><br /><br /> किंवा <br /><br /><b>[color=#FF0000]</b>नमस्कार!<b>[/color]</b><br /><br />हे <span style=\"color:red\">नमस्कार!</span> असे दिसेल</li><li>त्याचप्रमाणे शब्दांचा आकार बदलवु शकता <b>[size=][/size]</b>.हा tag तुम्ही वापरत असलेल्या template वर अवलंबून आहे. शब्द आकाराची पिक्सेलची सांख्यिकी किंमत देणे अधिक चांगले,सुरुवात 1 ने(खुपच लहान त्यामूळे दिसणार नाही) 29 (फ़ार मोठे) पर्यंत. उदा:<br /><br /><b>[size=9]</b>लहान<b>[/size]</b><br /><br /> हे <span style=\"font-size:9px\">लहान</span> असे दिसेल<br /><br />तसेच:<br/><br /><b>[size=24]</b>मोठे!<b>[/size]</b><br /><br /> हे <span style=\"font-size:24px\">मोठे!</span> असे दिसेल</li></ul>");
$faq[] = array("मी ह्या tags एकत्र वापरू शकति का?", "हो, नक्कीच; उदा.:<br /><br /><b>[size=18][color=red][b]</b>माझ्याकडे बघा!<b>[/b][/color][/size]</b><br /><br /> हे <span style=\"color:red;font-size:18px\"><b>माझ्याकडे बघा!</b></span> असे दिसेल<br/><br /> आम्ही तुम्हाला फ़ारच जास्त शब्द वापरायला सुचवत नाही. हे लक्षात घ्या की हे तुमच्यावर अवलंबून आहे की tags बरोबर निवडले पाहिजे. उदा. खालिल चुकिचे आहे:<br /><br /><b>[b][u]</b>हे चूक आहे<b>[/b][/u]</b>");

$faq[] = array("--","बोललेले शब्द आणि सारख्या रुंदिचे शब्द");
$faq[] = array("प्रतिक्रियेत बोललेले शब्द", "येथे हे तुम्ही दोन प्रकारे वापरू शकता बोलणारा नमुद करून व नमुद न करून.<ul><li>जेव्हा तुम्ही बोललेले फ़ंक्शन चा वापर प्रतिक्रिया देण्यासाठी करता तेव्हा तुम्हाला असे लक्षात येईल की लिखाणाचे शब्द <b>[quote=\"\"][/quote]</b> यामध्ये बंधिस्त झाले आहेत.या प्रकारे तुम्ही बोलणारा नमुद करू शकता.उदा. श्री. अबक नमुद करायचे असल्यास तुम्ही:<br /><br /><b>[quote=\"श्री.अबक\"]</b>श्री. अबकनी बोललेले येथे<b>[/quote] असे वापरु शकता</b><br /><br />तेव्हा ते असे दिसेल: श्री. अबकनी लिहिले: शब्दापुर्वी. लक्षात ठेवा हे <b>नक्की</b> \"\" मध्ये हवे. -- हे वैकल्पिक नाही.</li><li>दुसय्रा पद्धतीद्वारा तुम्ही आंधळेपणाने बोललेले नमुद करु शकता. हे वापरण्यासाठी शब्द <b>[quote][/quote]</b> tags मध्ये लिहा. जेव्हा तुम्ही हा संदेश बघाल तेव्हा असे दिसेल: बोललेले: शब्दापुर्वी.</li></ul>");
$faq[] = array("कोड दर्शविणे", "जर तुम्हाला कोड (ज्याला नियमित लांबी आणि रंदीची गरज आहे) दाखवायचा असल्यास तुम्ही तॊ  <b>[code][/code]</b> tags मध्ये बंधिस्त करायला हवा, उदा.<br /><br /><b>[code]</b>echo \"हा काही कोड आहे\";<b>[/code]</b><br /><br /><b>[code][/code]</b> tags मधिल सर्व शब्द जसेच्या तसेच राहतील.");

$faq[] = array("--","सुची बनविणे");
$faq[] = array("अक्रमित सुची बनवा", "BBCode दोन प्रकारच्या सुचीला सहाय्यता देतो, क्रमित आणि अक्रमित. ते HTML प्रमाणे आहे.अक्रमित सुचीतील वस्तू एकमेकामागे bullet अक्षराद्वारे असेल. अक्रमित सुची तयार करण्यासाठी तुम्ही  <b>[list][/list]</b> याचा वापर करू शकता आणि त्यामध्ये वस्तु  <b>[*]</b> द्वारा भरू शकता. उदा.आवडता रंग भरण्यासाठी तुम्ही:<br /><br /><b>[list]</b><br /><b>[*]</b>Red<br /><b>[*]</b>Blue<br /><b>[*]</b>Yellow<br /><b>[/list]</b> याचा वापर करू शकता<br /><br />हे खालिलप्रमाणे सुची बनवेल :<ul><li>Red</li><li>Blue</li><li>Yellow</li></ul>");
$faq[] = array("क्रमित सुची बनविणे", "या दुसय्रा प्रकारच्या सुचीत प्रत्ये वस्तूसमोर दिसणारा नियंत्रित करू शकता. क्रमित सुची तयार करण्यासाठी तुम्ही <b>[list=1][/list]</b> याचा उपयोग संख्याप्रमाणे क्रमित सुची किंवा <b>[list=a][/list]</b> याचा उपयोग तुम्ही अबकड या प्रमाणे क्रमित करू शकता.अक्रमित सुचीप्रमाणे वस्तू <b>[*]</b> चा उपयोग करून भरू शकता. उदा:<br /><br /><b>[list=1]</b><br /><b>[*]</b>Go to the shops<br /><b>[*]</b>Buy a new computer<br /><b>[*]</b>Swear at computer when it crashes<br /><b>[/list]</b><br /><br />हे खालिलप्रमाणॆ दिसेल:<ol type=\"1\"><li>Go to the shops</li><li>Buy a new computer</li><li>Swear at computer when it crashes</li></ol>तसेच alphabetical सुचीसाठी :<br /><br /><b>[list=a]</b><br /><b>[*]</b>The first possible answer<br /><b>[*]</b>The second possible answer<br /><b>[*]</b>The third possible answer<br /><b>[/list]</b> याचा वापर करु शकता<br /><br />हे असे दिसेल:<ol type=\"a\"><li>The first possible answer</li><li>The second possible answer</li><li>The third possible answer</li></ol>");

$faq[] = array("--", "संकेत बनविणे");
$faq[] = array("दुसय्रा संकेतस्थळासाठी संकेत बनविणे", "phpBB BBCode संकेत बनविण्यासाठी अनेक प्रकारे सहाय्यता देतो.<ul><li>यासाठी <b>[url=][/url]</b> tag वापरल्या जाते; = यानंतर तुम्ही जे लिहाल ते त्या tag साठी संकेताचे काम करेल. उदा.phpBB.com साठी संकेत बनवायचे असल्यास तुम्ही :<br/><br/><b>[url=http://www.phpbb.com/]</b>phpBB भेट द्या!<b>[/url]</b> असे लिहावे लागेल<br /><br />हे संकेत याप्रमाणे बनवेल <a href=\"http://www.phpbb.com/\" target=\"_blank\">phpBB भेट द्या!</a> तुम्हाला लक्षात आले असेल की संकेत नविन पृष्ठावर उघडल्या जातो जेणेकरून सदस्य सार्वत्रिका वापरत राहू शकतो.</li><li>जर तुम्हाला संकेत जसेच्या तएच दिसायला हवे असे पाहिजे असल्यास याप्रमाणे करा:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br/> हे असे दिसेल: <a href=\"http://www.phpbb.com/\"target=\"_blank\">http://www.phpbb.com/</a></li><li>अजुन phpBB मध्ये एक सुविधा आहे ज्याला  <i>जादू संकेत </i> म्हणतात. जे योग्य संकेत रचनेला (http://xyz.com) आपोआप संकेतात बदलवते ज्यामुळे तुम्हाला काही करण्याची आवश्यकता नाही. उदा. www.phpbb.com तुमच्या संदेशत लिहल्याबरोबर ते आपोआप  <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> संकेत बनवेल.</li><li> हेच इमेल करितादेखील लागू होईल.; तुम्ही लिहिलेला इमेल, उदा:<br /><br /><b>[email]</b>no.one@domain.adr<b>[/email]</b><br /><br />असा दिसेल : <a href=\"emailto:no.one@domain.adr\">no.one@domain.adr</a> किंवा तुम्ही फ़क्त  no.one@domain.adr असे तुमच्या संदेशात लिहल्यास ते आपोआप बदलेल.</li></ul>सर्व BBCode tags द्वारे तुम्ही संकेत इतर tags मध्ये गुंडाळू शकता.जसे की <b>[img][/img]</b> (पुढील भाग बघा), <b>[b][/b]</b>, इत्यादी.tags तुमच्यावर अवलंबून असल्यामूळे तुम्ही त्यांना योग्य प्रकारे उघडणे व बंद करणे आवश्यक आहे. उदा.:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br />जे <u>योग्य नाही</u> त्यामूळे तुमचे लिखाण वगळल्या जाऊ शकते.");

$faq[] = array("--", "लिखाणात चित्र दाखविणे");
$faq[] = array("लिखाणात चित्र टाकणे", "phpBB BBCode लिखाणात चित्र टाकण्यासाठी मदत करतो. महत्वाच्या लक्षात ठेवण्याची बाब ही आहे की: बहुतेक सदस्यांना लिखाणात खुप सारे चित्र आवडत नाही आणि दुसरी ते चित्र  Internet वर असायला हवे(फ़क्त तुमच्या संगणकावर नाही, उदा. जर तुम्ही webserver चालवत नसाल तर!). सध्या phpBB मध्ये स्थानिक चित्रे ठेवण्याची सुविधा नाही.(ह्या सर्व बाबी phpBB नंतरच्या वर्जनमध्ये विचारात घेतल्या जातील). चित्र दाखविण्यासाठी तुम्ही चित्राला जोडणारा संकेत <b>[img][/img]</b> tags मध्ये ठेवायला हवा. उदा:<br/><br/><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br/>संकेत विभागात दाखविल्याप्रमाणे तुम्ही चित्र <b>[url][/url]</b> tag मध्ये ठेवू शकता, उदा.<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />would generate:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "बाकिची माहीती");
$faq[] = array("मी स्वतःच्या tags टाकू शकतो का?", "माफ़ करा, ते phpBB 2.0 मध्ये शक्य नाही. आम्ही पुढच्या मोठ्या वर्जनमध्ये याबाबत प्रयत्न करीत आहोत.");

//
// This ends the BBCode guide entries
//

?>