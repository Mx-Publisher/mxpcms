<?php 
/***************************************************************************
 *							 last10_eg.php
 *							-------------------
 *	begin				:	September 2006
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



include_once('config.php');              

$bgcolor = '#ffffff'; // Page background color 
$tablew = '100%'; // Table width 
$toprow = '#c0c0c0'; // Top background color 
$bottom = '#ffffff'; // Bottom background color 
$border = '#000000'; // Border color 
$thickness = '2'; // Border thickness 
$padding = '4'; // Cell padding 
$font = 'Verdana'; // Font 
$fontsize = '2'; // Font size 
$refresh = '30'; // How often should it refresh? (seconds) 

// Return JavaScript or HTML 
$jsOutput=FALSE; // TRUE=js | FALSE=HTML 



// $host = $scip;		// IP adress or domain 
// $port = $scport;	// Port 

$lf = chr(10); // 0x0A [\n] 

// The lastN is configurable at the DNAS with, ShowLastSongs= it defaults to 10 and has a maximum of 20 
$t_max = $_REQUEST[n]; 
if (!t_max || $t_max<1 || $t_max>19) $t_max=10; 
//19 is the max here because 20=current_track+19 

// Let's get /index.html first... to keep this short, there is no code to handle the dnas being down 
// or not running, so the script will display nothing in those cases. 

$connect_timeout=5; 
$success=0; 


$open = fsockopen($scip,$scport); 
if ($open) { 
fputs($open,"GET /7.html HTTP/1.1\nUser-Agent:Mozilla\n\n"); 
$read = fread($open,1000); 
$text = explode("content-type:text/html",$read); 
$text = explode(",",$text[1]); 
} else { $er="Connection Refused!"; }


if ($text[1]==1) { $state = "Up"; } else { $state = "Down"; }

$fp1 = fsockopen($scip, $scport, &$errno, &$errstr, $connect_timeout); //open connection 
if(!$fp1) { //if this fails, I'm done.... 
fclose($fp1); 
$success++; 
} else { 
$request="GET /index.html HTTP/1.1\r\nHost:" . $host . ":" . $port . "\r\nUser-Agent: SHOUTcast DNAS Status [index] * (Mozilla/PHP)\r\nConnection: close\r\n\r\n"; //get index.html 
fputs($fp1,$request,strlen($request)); 
$page=''; 
while(!feof($fp1)) { 
$page .= fread($fp1, 16384); 
} 
fclose($fp1); 

// now I have the entire /index.html in $page -- all I want from here is the current track... 
// (hint-hint) 

$song00 = ereg_replace("</b></td>.*", "", ereg_replace(".*Current Song: </font></td><td><font class=default><b>", "", $page)); // easy, right <img src="images/smilies/smile.gif" border="0" alt=""> 

// now let's get /played.html... (this is kinda long) 
$fp = fsockopen($scip, $scport, &$errno, &$errstr, $connect_timeout); 
if(!$fp) { //if connection could not be made 
fclose($fp); 
$success++; 

} else { 
$request="GET /played.html HTTP/1.1\r\nHost: " . $host . ":" . $port . "\r\nUser-Agent: SHOUTcast DNAS Status [played] * (Mozilla/PHP)\r\n"."Connection: close\r\n\r\n"; 
fputs($fp,$request,strlen($request)); 
$page=''; 
while (!feof($fp)) { 
$page .= fread($fp, 16384); 
} 
fclose($fp); //close connection 
$played_html=$page; 

if ($played_html) { 
$played_html= ereg_replace('<x>','|-|',ereg_replace('</tr>','',ereg_replace('</td><td>','<x>',ereg_replace('<tr><td>','',ereg_replace('</tr>','</tr>' . $lf,ereg_replace('-->','--]',ereg_replace('<!--','[!--',ereg_replace('</table><br><br>.*','',ereg_replace('.*<b>Current Song</b></td></tr>','',$played_html))))))))); 
$xxn=strlen($played_html); 
$r=2; 
$t_count=0; 
$reading=0; 
$track[0]=$song00; 
while ($r<$xxn & $t_count<=$t_max){ 
$cur=substr($played_html,$r,1); 
if ($cur==$lf) $reading=0; 
if ($reading==1) $track[$t_count] .= $cur; 
if ($cur=="|" & substr($played_html,$r-1,1)=="-" & substr($played_html,$r-2,1)=="|") { 
$reading=1; 
$t_count++; 
} 
$r++; 
} 
} 
} 
} 

// I now have $track[0-N] containg the current plus last N tracks... 
// Output time... 

if ($success==0 && $state=="Up") { 
 
echo " <table width=\" . $block_size . \" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"forumline\">\n";

$r=0; 
$output_string=''; 

//tweak the output string (the table init) here.... 
$output_string .= '<table width="' . $tablew . '" class="forumline" border="' . $thickness . '" bordercolor="' . $border . '"><tr bgcolor="' . $toprow . '"><td> 
<table width="100%" border="0" cellpadding="' . $padding . '"><tr><td> 
<font face=' . $font . ' size=' . $fontsize . '>'; //Now playing... 

while ($r<=$t_max){ 
if ($r==0) $output_string .= 'Acum la radio:<b>'.str_replace("'", "'",str_replace('"', '"',$track[$r])).'</b></td></tr></table></td></tr><tr><td><table bgcolor=' . $bottom . ' width="100%" border="0" cellpadding="' . $padding . '"><tr><td><br><font face=' . $font . ' size=' . $fontsize . '><i>Înainte de aceasta ai putut asculta:</i><br><br>'; 
else $output_string .= str_replace("'", "'",str_replace('"', '"',$track[$r])) . '<br>'; 

$r++; 
} 

// I also want to close the table code now.... 
$output_string .= '</font></td></tr></table></td></tr></table>'; 
 
echo $output_string . '';  

} else { // I couldn't connect to the DNAS  
$r=0; 
$output_string='';
$output_string .= '<table width="' . $tablew . '" class="forumline" border="' . $thickness . '" bordercolor="' . $border . '"><tr bgcolor="' . $toprow . '"><td> 
<table width="100%" border="0" cellpadding="' . $padding . '"><tr><td> 
<font face=' . $font . ' size=' . $fontsize . '>Serverul este <b>Off-Air</b>, incearcã mai târziu.'; //Now playing... 
if ($success!=0) {
$output_string .= '<td><tr>'; 
}
if ($success==0) {
while ($r<=$t_max){ 
if ($r==0) $output_string .= '<tr><td>Înainte de aceasta ai putut asculta:</i><br><br>'; 
else $output_string .= str_replace("'", "'",str_replace('"', '"',$track[$r])) . '<br>'; 

$r++; 
}
}
// I also want to close the table code now.... 
$output_string .= '</td></tr></font></td></tr></table></td></tr></table>'; 
 
echo $output_string . '';  

} 
?> 
