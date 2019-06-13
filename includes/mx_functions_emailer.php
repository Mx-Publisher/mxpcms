<?php
/**
*
* @package Emailer
* @version $Id: mx_functions_emailer.php,v 1.5 2014/05/09 07:51:42 orynider Exp $
* @copyright (c) 2002-2008 MX-Publisher Project Team & ( C) 2001 The phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v2
* @link http://mxpcms.sourceforge.net/
*
 
/**
 * Modifications:
 * Added $emailer->use_html method by OryNider
 *
 */

/**
* Emailer
* @package MXP3
*/

//
// The emailer class has support for attaching files, that isn't implemented
// in the 2.0 release but we can probable find some way of using it in a future
// release
//
class mx_emailer
{
	var $msg, $subject, $extra_headers;
	var $addresses, $reply_to, $from;
	var $use_smtp;

	var $tpl_msg = array();
	var $use_html = false;

	function emailer($use_smtp)
	{
		$this->reset();
		$this->use_smtp = $use_smtp;
		$this->use_html = false;
		$this->reply_to = $this->from = '';
	}

	// Resets all the data (address, template file, etc etc to default
	function reset()
	{
		$this->addresses = array();
		$this->vars = $this->msg = $this->extra_headers = '';
	}

	// Sets an email address to send to
	function email_address($address)
	{
		$this->addresses['to'] = trim($address);
	}

	function cc($address)
	{
		$this->addresses['cc'][] = trim($address);
	}

	function bcc($address)
	{
		$this->addresses['bcc'][] = trim($address);
	}

	function replyto($address)
	{
		$this->reply_to = trim($address);
	}

	function from($address)
	{
		$this->from = trim($address);
	}

	// set up subject for mail
	function set_subject($subject = '')
	{
		$this->subject = trim(preg_replace('#[\n\r]+#s', '', $subject));
	}
	
	// set up skip mail
	function email_skip($email_skip = false)
	{
		$this->email_skip = $email_skip;
	}	

	// set up extra mail headers
	function extra_headers($headers)
	{
		$this->extra_headers .= trim($headers) . "\n";
	}
	
	function set_mail_priority($priority = MAIL_NORMAL_PRIORITY)
	{
		$this->mail_priority = $priority;
	}

	/**
	* Set the email html
	*/
	function set_mail_html($html = false)
	{
		$this->use_html = $html;
	}	

	function use_template($template_file, $template_lang = '')
	{
		global $board_config, $phpbb_root_path, $module_root_path, $mx_root_path;

		if (trim($template_file) == '')
		{
			mx_message_die(GENERAL_ERROR, 'No template file set', '', __LINE__, __FILE__);
		}

		if (trim($template_lang) == '')
		{
			$template_lang = $board_config['default_lang'];
		}

		if (empty($this->tpl_msg[$template_lang . $template_file]))
		{
			$tpl_file = $mx_root_path . 'language/lang_' . $template_lang . '/email/' . $template_file . '.tpl';

			if (!file_exists(realpath($tpl_file)))
			{
				$tpl_file = $mx_root_path . 'language/lang_' . $board_config['default_lang'] . '/email/' . $template_file . '.tpl';

				if (!file_exists(realpath($tpl_file)))
				{
					mx_message_die(GENERAL_ERROR, 'Could not find email template file :: ' . $template_file . ' @:' . $tpl_file, '', __LINE__, __FILE__);
				}
			}

			if (!($fd = @fopen($tpl_file, 'r')))
			{
				mx_message_die(GENERAL_ERROR, 'Failed opening template file :: ' . $template_file . ' @:' . $tpl_file, '', __LINE__, __FILE__);
			}

			$this->tpl_msg[$template_lang . $template_file] = @fread($fd, filesize($tpl_file));
			fclose($fd);
		}

		$this->msg = $this->tpl_msg[$template_lang . $template_file];
		
		return true;
	}

	// assign variables
	function assign_vars($vars)
	{
		$this->vars = (empty($this->vars)) ? $vars : $this->vars . $vars;
	}

	// Send the mail out to the recipients set previously in var $this->address
	function send()
	{
		global $board_config, $lang, $phpEx, $phpbb_root_path, $db, $mx_root_path;

    	// Escape all quotes, else the eval will fail.
		$this->msg = str_replace ("'", "\'", $this->msg);
		$this->msg = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . $\\1 . '", $this->msg);

		// Set vars
		reset ($this->vars);
		while (list($key, $val) = each($this->vars)) 
		{
			$$key = $val;
		}

		eval("\$this->msg = '$this->msg';");

		// Clear vars
		reset ($this->vars);
		while (list($key, $val) = each($this->vars)) 
		{
			unset($$key);
		}

		// We now try and pull a subject from the email body ... if it exists,
		// do this here because the subject may contain a variable
		$drop_header = '';
		$match = array();
		if (preg_match('#^(Subject:(.*?))$#m', $this->msg, $match))
		{
			$this->subject = (trim($match[2]) != '') ? trim($match[2]) : (($this->subject != '') ? $this->subject : 'No Subject');
			$drop_header .= '[\r\n]*?' . preg_quote($match[1], '#');
		}
		else
		{
			$this->subject = (($this->subject != '') ? $this->subject : 'No Subject');
		}

		if (preg_match('#^(Charset:(.*?))$#m', $this->msg, $match))
		{
			$this->encoding = (trim($match[2]) != '') ? trim($match[2]) : trim($lang['ENCODING']);
			$drop_header .= '[\r\n]*?' . preg_quote($match[1], '#');
		}
		else
		{
			$this->encoding = trim($lang['ENCODING']);
		}

		if ($drop_header != '')
		{
			$this->msg = trim(preg_replace('#' . $drop_header . '#s', '', $this->msg));
		}

		$to = $this->addresses['to'];
		$cc = (count($this->addresses['cc'])) ? implode(', ', $this->addresses['cc']) : '';
		$bcc = (count($this->addresses['bcc'])) ? implode(', ', $this->addresses['bcc']) : '';
		$skip = ($this->email_skip == $this->addresses['to']) ? true : false; 

		// Build header
		if ($this->use_html)
		{
			$this->extra_headers = (($this->reply_to != '') ? "Reply-to: $this->reply_to\n" : '') . (($this->from != '') ? "From: $this->from\n" : "From: " . $board_config['board_email'] . "\n") . "Return-Path: " . $board_config['board_email'] . "\n" . "Message-ID: <" . md5(uniqid(time())) . "@" . $board_config['server_name'] . ">\nMIME-Version: 1.0\nContent-type: text/html; charset=" . $this->encoding . "\n" . "Content-transfer-encoding: 8bit\nDate: " . date('r', time()) . "\n" . "X-Priority: 3\n" . "X-MSMail-Priority: Normal\n" . "X-Mailer: PHP\nX-MimeOLE: Produced By MXP\n" . $this->extra_headers . (($cc != '') ? "Cc: $cc\n" : '')  . (($bcc != '') ? "Bcc: $bcc\n" : '');			
		}
		else
		{
			$this->extra_headers = (($this->reply_to != '') ? "Reply-to: $this->reply_to\n" : '') . (($this->from != '') ? "From: $this->from\n" : "From: " . $board_config['board_email'] . "\n") . "Return-Path: " . $board_config['board_email'] . "\n" ."Message-ID: <" . md5(uniqid(time())) . "@" . $board_config['server_name'] . ">\nMIME-Version: 1.0\nContent-type: text/plain; charset=" . $this->encoding . "\n" . "Content-transfer-encoding: 8bit\nDate: " . date('r', time()) . "\n". "X-Priority: 3\n" . "X-MSMail-Priority: Normal\n" . "X-Mailer: PHP\nX-MimeOLE: Produced By Mx-Publisher\n" . $this->extra_headers . (($cc != '') ? "Cc: $cc\n" : '')  . (($bcc != '') ? "Bcc: $bcc\n" : ''); 
		}
		
		// Send message ... removed $this->encode() from subject for time being
		if ( $this->use_smtp )
		{
			if ( !defined('SMTP_INCLUDED') ) 
			{
				include($mx_root_path . 'includes/contact_smtp.' . $phpEx);
			}

			$result = ($skip) ? false : smtpmail($to, $this->subject, $this->msg, $this->extra_headers);
		}
		else
		{
			$empty_to_header = ($to == '') ? TRUE : FALSE;
			$to = ($to == '') ? (($board_config['sendmail_fix']) ? ' ' : 'Undisclosed-recipients:;') : $to;
	
			$result = ($skip) ? false : mail($to, $this->subject, preg_replace("#(?<!\r)\n#s", "\n", $this->msg), $this->extra_headers);
			
			if (!$result && !$board_config['sendmail_fix'] && $empty_to_header)
			{
				$to = ' ';
				
				switch (PORTAL_BACKEND)
				{
					case 'phpbb2':

						$sql = "UPDATE " . CONFIG_TABLE . " 
							SET config_value = '1'
							WHERE config_name = 'sendmail_fix'";
						if (!$db->sql_query($sql))
						{
							mx_message_die(GENERAL_ERROR, 'Unable to update config table', '', __LINE__, __FILE__, $sql);
						}
					break;
					
					case 'internal':
					case 'smf2':
					case 'mybb':
					case 'phpbb3':
					case 'olympus':
					case 'ascraeus':
					case 'rhea':
						if (!$board_config['board_email'])
						{
							mx_message_die(GENERAL_ERROR, 'The is no default email adress configured were to notify the admin.', '', __LINE__, __FILE__, '');
						}
					break;
				}				

				$board_config['sendmail_fix'] = 1;
				$result = ($skip) ? false : mail($to, $this->subject, preg_replace("#(?<!\r)\n#s", "\n", $this->msg), $this->extra_headers);
			}
		}

		// Did it work?
		if ((!$result) && (!$skip))
		{
			mx_message_die(GENERAL_ERROR, 'Failed sending email :: ' . (($this->use_smtp) ? 'SMTP' : 'PHP') . ' :: ' . $result, '', __LINE__, __FILE__);
		}
		
		if (!$skip)
		{
			//print('Failed sending email :: Use another adress for sender.', __LINE__, __FILE__);
		}

		return true;
	}

	// Encodes the given string for proper display for this encoding ... nabbed 
	// from php.net and modified. There is an alternative encoding method which 
	// may produce lesd output but it's questionable as to its worth in this 
	// scenario IMO
	function encode($str)
	{
		if ($this->encoding == '')
		{
			return $str;
		}

		// define start delimimter, end delimiter and spacer
		$end = "?=";
		$start = "=?$this->encoding?B?";
		$spacer = "$end\r\n $start";

		// determine length of encoded text within chunks and ensure length is even
		$length = 75 - strlen($start) - strlen($end);
		$length = floor($length / 2) * 2;

		// encode the string and split it into chunks with spacers after each chunk
		$str = chunk_split(base64_encode($str), $length, $spacer);

		// remove trailing spacer and add start and end delimiters
		$str = preg_replace('#' . preg_quote($spacer, '#') . '$#', '', $str);

		return $start . $str . $end;
	}

	//
	// Attach files via MIME.
	//
	function attachFile($filename, $mimetype = "application/octet-stream", $szFromAddress, $szFilenameToDisplay)
	{
		global $lang;
		$mime_boundary = "--==================_846811060==_";

		$this->msg = '--' . $mime_boundary . "\nContent-Type: text/plain;\n\tcharset=\"" . $lang['ENCODING'] . "\"\n\n" . $this->msg;

		if ($mime_filename)
		{
			$filename = $mime_filename;
			$encoded = $this->encode_file($filename);
		}

		$fd = fopen($filename, "r");
		$contents = fread($fd, filesize($filename));

		$this->mimeOut = "--" . $mime_boundary . "\n";
		$this->mimeOut .= "Content-Type: " . $mimetype . ";\n\tname=\"$szFilenameToDisplay\"\n";
		$this->mimeOut .= "Content-Transfer-Encoding: quoted-printable\n";
		$this->mimeOut .= "Content-Disposition: attachment;\n\tfilename=\"$szFilenameToDisplay\"\n\n";

		if ( $mimetype == "message/rfc822" )
		{
			$this->mimeOut .= "From: ".$szFromAddress."\n";
			$this->mimeOut .= "To: ".$this->emailAddress."\n";
			$this->mimeOut .= "Date: ".date("D, d M Y H:i:s") . " UT\n";
			$this->mimeOut .= "Reply-To:".$szFromAddress."\n";
			$this->mimeOut .= "Subject: ".$this->mailSubject."\n";
			$this->mimeOut .= "X-Mailer: PHP/".phpversion()."\n";
			$this->mimeOut .= "MIME-Version: 1.0\n";
		}

		$this->mimeOut .= $contents."\n";
		$this->mimeOut .= "--" . $mime_boundary . "--" . "\n";

		return $out;
		// added -- to notify email client attachment is done
	}

	function getMimeHeaders($filename, $mime_filename="")
	{
		$mime_boundary = "--==================_846811060==_";

		if ($mime_filename)
		{
			$filename = $mime_filename;
		}

		$out = "MIME-Version: 1.0\n";
		$out .= "Content-Type: multipart/mixed;\n\tboundary=\"$mime_boundary\"\n\n";
		$out .= "This message is in MIME format. Since your mail reader does not understand\n";
		$out .= "this format, some or all of this message may not be legible.";

		return $out;
	}

	//
   // Split string by RFC 2045 semantics (76 chars per line, end with \r\n).
	//
	function myChunkSplit($str)
	{
		$stmp = $str;
		$len = strlen($stmp);
		$out = "";

		while ($len > 0)
		{
			if ($len >= 76)
			{
				$out .= substr($stmp, 0, 76) . "\r\n";
				$stmp = substr($stmp, 76);
				$len = $len - 76;
			}
			else
			{
				$out .= $stmp . "\r\n";
				$stmp = "";
				$len = 0;
			}
		}
		return $out;
	}

	//
   // Split the specified file up into a string and return it
	//
	function encode_file($sourcefile)
	{
		if (is_readable(realpath($sourcefile)))
		{
			$fd = fopen($sourcefile, "r");
			$contents = fread($fd, filesize($sourcefile));
	      $encoded = $this->myChunkSplit(base64_encode($contents));
	      fclose($fd);
		}

		return $encoded;
	}

} // class emailer

?>