<?php
/***************************************************************************
 *                       lang_bbcode.php [Simplified Chinese]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_bbcode.php,v 1.85.2.15 2003/06/10 00:31:19 psotfx Exp $
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
		Fixed many minor grammatical problems.
*/

//
// Translation by:
//      inker    :: http://www.byink.com
//
//      For questions and comments use: support@byink.com
//      last modify   : 2002/3/1
//

//
// Update by:
//	iCy-fLaME
//      For questions and comments use: icy_flame_hm@hotmail.com
//      last modify   : 05 Apr 2004
//

//
// To add an entry to your BBCode guide simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
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

$faq[] = array("--","����");
$faq[] = array("ʲô�� BBCode ����?", "BBCode ������һ�� HTML ���ر��﷨, ���Ƿ�ʹ�� BBCode ����ȡ���ڹ���Ա�Ŀ������, ������Ҳ������ÿ�����µķ��������ȡ���������. BBCode�������ʽ����HTML�﷨, ����ʹ�� [ and ] ��������ʹ�� &lt; and &gt;��ǩ, ���ṩ�˸��õĲ��������ԺͿ������ı���. �����������·���ı���Ϸ����� BBCode ����ı�ݰ�ť (�÷�λ�û�����ͬ�Ĳ�����ʽ��������ͬ). ���»��и���ϸ�Ľ���.");

$faq[] = array("--","���ָ�ʽ");
$faq[] = array("��δ�������, б�弰�ӵ��ߵ�����?", "BBCode �����ṩһЩ���ֱ�ǩ���������ٵĸ������ֵĻ�����ʽ. ����: <ul><li>���� <b>[b][/b]</b>, ��: <br /><br /><b>[b]</b>���<b>[/b]</b><br /><br />����<b>���</b><br /><br /></li><li>Ҫʹ�õ���ʱ, ����<b>[u][/u]</b>, ��:<br /><br /><b>[u]</b>���<b>[/u]</b><br /><br />���<u>���</u><br /><br /></li><li>Ҫб����ʾʱ, ���� <b>[i][/i]</b>, ��:<br /><br />����<b>[i]</b>̫����<b>[/i]</b><br /><br />������ �������<i>̫����</i></li></ul>");
$faq[] = array("����޸����ֵ���ɫ�Լ���С?", "�������������޸�������ɫ����С������ʹ�����µı�ǩ. ��ע��, ��ʾ��Ч���������������ϵͳ����: <ul><li>��������ɫ��ʱ, ��ʹ�� <b>[color=][/color]</b>. ������ָ��һ���ɱ���ʶ����ɫ����(����. red, blue, yellow, �ȵ�.) ����ʹ����ɫ����, ����: #FFFFFF, #000000. ������˵, Ҫ����һ�ݺ�ɫ����������ʹ��:<br /><br /><b>[color=red]</b>���<b>[/color]</b><br /><br />����<br /><br /><b>[color=#FF0000]</b>���!<b>[/color]</b><br /><br />������ʾ:<span style=\"color:red\">���!</span><br /><br /></li><li>�ı����ֵĴ�СҲ��ʹ�����Ƶ��趨, ���Ϊ <b>[size=][/size]</b>. ������Ĺ��ܳ���ʹ����ֵ��ʽ����������ʾ�������ִ�����, �����ĸ�����ʹ�õ���ʽ����, ��ʼֵΪ 1 (���ǿ��ܻ�С�����޷�����) �� 29 Ϊֹ (����). ����˵��:<br /><br /><b>[size=9]</b>С<b>[/size]</b><br /><br />������� <span style=\"font-size:9px\">С</span><br /><br />������:<br /><br /><b>[size=24]</b><b>[/size]</b><br /><br />������ʾ <span style=\"font-size:24px\">��</span></li></ul>");
$faq[] = array("�ҿ��Խ��ʹ�ò�ͬ�ı�ǩ������?", "��Ȼ����, ����Ҫ������ҵ�ע��ʱ, ������ʹ��:<br /><br /><b>[size=18][color=red][b]</b>�������!<b>[/b][/color][/size]</b><br /><br /> ������ʾ�� <span style=\"color:red;font-size:18px\"><b>�������!</b></span><br /><br />���ǲ�����������ʾ̫�����������! ������Щ�����������о���. ��ʹ�� BBCode ����ʱ, �뾡��ʹ����ȷ�ı�ǩ, ���¾��Ǵ����ʹ�÷�ʽ:<br /><br /><b>[b][u]</b>����ʾ��<b>[/b][/u]</b>");

$faq[] = array("--","��ӵ, ��ʾ�����̶���ȵ�����");
$faq[] = array("�ظ�ʱ��������", "�����ַ�ʽ������������������, ��ʾ������Դ��ֱ������.<ul><li>���������۰���ʹ�����Իظ�ʱ, ����ע�⵽���������ѱ�����ظ��������Ӵ���  <b>[quote=\"\"][/quote]</b> ������. ��������ĳλ�����ߵ��������ݲ���ʾ��Դ! ����Ҫ����123����������ʱ, ����������:<br /><br /><b>[quote=\"123\"]</b>123���������ݽ���������<b>[/quote]</b><br /><br />�⽫������ʾʱ�Զ�����: <b>ĳĳд��:(����)</b>��ǵ���<b>����</b>��\"\"����ָ�������ߵ�����ǰ�����\"��\"<br /><br /></li><li>�ڶ��ַ���������ֱ������. Ҫʹ�������ǩʱ, ������ʹ�� <b>[quote][/quote]</b> ��ǩ. ������ʹ�÷�ʽ����ֻ����ʾ�򵥵����ù���, ����: <b>���ûظ�: </b>����ָ������������.</li></ul>");
$faq[] = array("��ʾ��ʽ�����̶���ȵ�����", "�������Ҫ��ʾһ�γ�ʽ��������κ�Ҫ�̶���ȵ�����, ������ʹ�� <b>[code][/code]</b> ��ǩ��������Щ����, ����:<br /><br /><b>[code]</b>echo \"��������\";<b>[/code]</b><br /><br />�������ʱ, ���б� <b>[code][/code]</b> ��ǩ���������ָ�ʽ�������ֲ���.");

$faq[] = array("--","�����б�");
$faq[] = array("����û��������б�", "BBCode ����֧�������б�ģʽ, ������ĺ��������. ��������б��Է����������е���ʾÿ����Ŀ, ����ʹ�� <b>[list][/list]</b> ����ʹ�� <b>[*]</b> ������ÿһ����Ŀ. ����Ҫ���г�����ϲ������ɫʱ, ������ʹ��:<br /><br /><b>[list]</b><br /><b>[*]</b>��ɫ<br /><b>[*]</b>��ɫ<br /><b>[*]</b>��ɫ<br /><b>[/list]</b><br /><br />�⽫���������б�:<ul><li>��ɫ</li><li>��ɫ</li><li>��ɫ</li></ul>");
$faq[] = array("�����������е��б�", "�ڶ����б�ģʽ, ��������б���������ÿ����Ŀ��ʾ��˳��, ����ʹ�� <b>[list=1][/list]</b> ������������������б�, ������ <b>[list=a][/list]</b> ����������ĸ������б�. ��ͬ�������б��ʹ�÷�ʽһ��, ������ <b>[*]</b>��ָ�����������. ����:<br /><br /><b>[list=1]</b><br /><b>[*]</b>���̵�ȥ<br /><b>[*]</b>��һ̨�µĵ���<br /><b>[*]</b>�����Թҵ�ʱ����һ��<br /><b>[/list]</b><br /><br />������������б�:<ol type=\"1\"><li>���̵�ȥ</li><li>��һ̨�µĵ���</li><li>�����Թҵ�ʱ����һ��</li></ol>���Ҫʹ����ĸ���еĻ�, ������ʹ��:<br /><br /><b>[list=a]</b><br /><b>[*]</b>��һ�����ܵĴ�<br /><b>[*]</b>�ڶ������ܵĴ�<br /><b>[*]</b>���������ܵĴ�<br /><b>[/list]</b><br /><br />�������<ol type=\"a\"><li>��һ�����ܵĴ�</li><li>�ڶ������ܵĴ�</li><li>���������ܵĴ�</li></ol>");

$faq[] = array("--", "��������");
$faq[] = array("���ӵ�������վ", "phpBB BBCode ����֧������ʽ����ַ, һ����˵��õľ��� URLs ����.<ul><li>ʹ���������������ʹ�� <b>[url=][/url]</b> ��ǩ, �ڵȺ� ( = ) ֮��, �����������κ�����, �Ի�ʹ�ô�һ��ǩ���ӵ���ָ���� URL. ����˵��, Ҫ���� phpBB.com ʱ, ������ʹ��:<br /><br /><b>[url=http://www.phpbb.com/]</b>���phpBB!<b>[/url]</b><br /><br />��������������, <a href=\"http://www.phpbb.com/\" target=\"_blank\">���phpBB!</a> ������ע�����, ��ѡ���ӽ�����һ���µ��Ӵ�, ����Ϊ�˷���������ܼ�������������ݶ����.<br /><br /></li><li>�������Ҫ URL ������ʾ������, ������ʹ�ü򵥵��趨:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br />�⽫�������������, <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a><br /><br /></li><li>�ڸ��ӵ� phpBB ������, ��һ��<b>ħ������</b>�Ĺ���, ������ܽ�ת��������ȷ�� URL ���ͳ�Ϊ����, ������ָ���κα�ǩҲ�����ھ��׼��� http://. ������������������ www.phpbb.com, �������ʱ, ���Զ�ת���� <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> ��ʾ.<br /><br /></li><li>�������ͬ��֧�ֵ����ʼ�λַ, ������ָ��һ���ض�λַ, ����:<br /><br /><b>[email]</b>no.one@domain.adr<b>[/email]</b><br /><br />������ʾΪ <a href=\"emailto:no.one@domain.adr\">no.one@domain.adr</a> ������ֻҪ���� no.one@domain.adr ϵͳ���Զ�ת��ΪԤ��ĵ����ʼ�λַ.<br /><br /></li></ul>����ʹ�� BBCode URLs �ı�ǩʱҲ���Լ���������ǩ����, �� <b>[img][/img]</b> (�ɲο���һ��˵��), <b>[b][/b]</b>...�ȵ�, �����Դ���ʹ���κεı�ǩ, ����ȷ���Ƿ���ȷʹ���˱�ǩ, ����:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br />����ȷ���﷨, ������ʹ�ý������������±�ɾ��, �����ʹ��.");

$faq[] = array("--", "�������в���ͼƬ");
$faq[] = array("�������в���ͼƬ", "phpBB BBCode �����ṩ��ǩ��������������ʾͼ��. ʹ��ǰ, ���ס������Ҫ����;  ��һ, ���ʹ���߲���ϲ��������������̫���ͼƬ, �ڶ�, ����ͼƬ������������·����ʾ�� (����: �������������ϵ��ļ� (�������ĵ�����̨������). phpBB Ŀǰû���ṩ����ͼƬ�Ĺ���  (����һ��� phpBB ������������). Ŀǰ, ��Ҫ��ʾͼ��, ������ʹ�� <b>[img][/img]</b> ��ǩ��ָ��ͼ��������ַ,  ����:<br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />��ͬ����ǰ��ַ���ӵ�˵��һ��, ��Ҳ����ʹ��ͼƬ��ַ������ <b>[url][/url]</b> �ı�ǩ, ����:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />������:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "��������");
$faq[] = array("�ҿ��Լ������ж���ı�ǩ��?", "Ŀǰ phpBB 2.0 �в�û�������,  ��������ϣ����������һ���ٷ��汾�м��������.");

//
// This ends the BBCode guide entries
//

?>