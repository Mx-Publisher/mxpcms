- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 - - - - - - - - - - - - - RADIO PLAYER v 4.9.x - - - - - - - - - - -
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


This is the "Web Based RadioPlayer" *Standalone* version 4.x for 
SHOUTcast and Icecast servers. The embed's are hidden in iframes
with auto starts, so the principal is very simple. 
It also uses an Ajax script to update the song title.

Auto detect the users players and plugins and chooses the most fitting.

It can switch between Real Player, Windows Media Player, QuickTime or
Winamp ActiveX player.

Feel free to use it however you want, all I want is that you keep 
the author meta tag.


---------------------------------------------------------------------

                          Instructions:

All you need is to edit config/config.php to your casters server
address/ip and port, password is not needed.

How to fix your custom title and info?
Open "config/display_config.php" and read the info... =)

How to use this with icecast?
U need to add "short_status.xsl" file to the Icecast web directory.
"short_status.xsl" is located under ice_file in this package. My
icecast web directory is under "/usr/share/icecast/web". Maybe u need
to do a chown and a chmod 644 on the file. And that's all.

How to use multiple config files?
Easy... first make a copy of the original config (config.php) and name
it to whatever u like (e.g. elit_conf.php). Then in your function
radio_player() u change "radioplayer.php?config=config" to 
"radioplayer.php?config=elit_conf" that is all.

How to choose language in the URL?
Just add "?language=swedish" or your language of choice to the url after 
"radioplayer.php" like this "radioplayer.php?language=swedish".

For CVS revisions try:
:sserver:anonymous@mxpcms.cvs.sourceforge.net:/cvsroot/mxpcms radioplayer
---------------------------------------------------------------------

                            History:
							
- Version 4.9.2 
- Added "Color title" support to the skin configuration files.
- Added "Cover Image" size options to the skin conguration files: 
 Valid values are: 
 0 for small (default size for new skins);  
 1 for medium (normal size for old skins, this grabs larger cover from Last.fm,
 cdbaby.com, etc. or small size from amazone cache, stretched then in display); 
 2 for large; 
 and 3 for eXtrem large;
 Added more variables for the display in the config -//- for designers,
 so that you can build your own skin setting all you need only in the 
 skin_config.php file located in your skin folder.
May 24, 2013 OryNider
							
- Version 4.9.1 - Added Album Cover/Link getter check also from Last.FM
May 22, 2013 OryNider
							
- Version 4.9.0 - Some php rewrite based on version 2008-2009 by DrKnas
- Fixed the scrolling bar bug that didn't update.
Added a href/url option so u can use multiple config files for
the same player. 
- Added Icecast support *on-the-fly*, and keept old method by DrKnas. 
- Removed <?php ?> tags for PHP 5.2+ standard.
- Added support for every Style specific CSS.
- Added support for getting cover with 4.9+. 
Tested with PHP 5.3.5, Apache 2.2.21.
- Fixed the scrolling bar bug that didn't update like in pre 3.0.0.
Tested with Internet Explorer 8, Firefox 21, Safari 5.1.7, 
Maxthon 4.0.3, Torch 25 / Chromium.  
May 12, 2013 OryNider

- Version 4.2.1 - Minor fix on Cd cover getter and variabel check.
Juli 4, 2010 DrKnas

- Version 4.2.0 - Fixed Cd cover getter that has been broken since
early 2009. Also removed the option to use Curl. Added an option to 
disable or enable text/character cleaning of title and other info 
that the player displays.
Juni 18, 2010 DrKnas							
							
- Version 4.1.2 - Removed/fixed url calling of the radioplayer, you
can now call it directly with only "radioplayer.php" and not the whole
"radioplayer.php?lang=&z=wmp&config=config". Just like versions before
you can still choose configs in the url. New in this release is that the 
language selection in the URL works. Fixed so when u press the stop
button the whole player stops and not only the music. Meaning that the
title and other info stops update to.
February 27, 2009 DrKnas

- Version 4.1.1 - Misc typos fixed. Added Spanish language. Added more
variables in the display config for ice cast. Added basic php checks
for needed functions. Added "_blank" to the html part of the cd cover
getter.
February 17, 2009 DrKnas

- Version 4.1.0 - Cd cover getter added. If a cd cover is found then
it will be displayed in the player window. Added 4 more basic skins
blue/green/yellow/red. New design for the player. Added a little more 
possibility for making custom skins. Language support is updated and
should now be correct. Minor tweaks and bug fixes done.
November 21, 2008 DrKnas

- Version 4.0.5 - Title bug fix again ;). Added so u can customize 
title and other info. More code cleanup/fixes (lot of crap laying
around in the source.) Moved config.php to a separate folder. Good 
if u got many configs. Repositioned some elements (css). Minor fixes
and improvements. Added French language thanks to Mygale06. Swedish
language added to. 
October 06, 2008 DrKnas

- Version 4.0.4 - Title bug fix. 
October 03, 2008 DrKnas

- Version 4.0.3 - Maxlisteners and Peaklisteners fixed. Radio offline
message for shoutcast fixed. More php/java/html cleanup it got some
structure now. Added some fail safe settings if user don't now what to
type in the config. Various bug fixes. Added a file for icecast users
and a little read me how to use it.
October 02, 2008 DrKnas

- Version 4.0.2 - Added asx playlist for icecast users. Looks like
Its needed to use an asx playlist icecast servers. Other wise only the
radio intro is played. 
September 30, 2008 DrKnas

- Version 4.0.1 - Bug fix. Forgot two php vars... 
September 30, 2008 DrKnas

- Version 4.0.0 - Fixed the scrolling bar bug that didn't update.
Added a href/url option so u can use multiple config files for
the same player. Also i have added Icecast support which was my
main purpose. Some php rewrite.
September 29, 2008 DrKnas

----------------------------------------------------------------

- Version 3.0.2 - Added scolling title to the player display bar
plus more start are displayed on the player. 
April 24, 2008 OryNider	
							
- Version 3.0.1 - Added option to get the player to autostart 
instantly when opened.
April 20, 2008 OryNider							
							
- Version 3.0 - This is compleate rewrite backported from latest 
Mx-Publisher CMS module version.
- Fixed bug with curent song and re-implemented multi skin support.
- Included new aero style (AeroBlue).
April 19, 2008 OryNider < orynider@rdslink.ro > (Florin C Bodin)							


- Version 2.0 - This new Version is almost completly renewed. The 
 player detect the best player for the user or he/she can select 
 which one to use. Added QuickTime and Winamp ActiveX as selectable 
 embed players. Supports AAC streams with a AAC plugin for WMP or 
 usage of AOL's Winamp ActiveX embed player. New design on the skin 
 with easier skinnable interface (Photoshop files included).
February 24, 2008 Niklas Pull aka Little Frog

- Version 1.1 - Mayor update. New more userfriendly version for users 
 and developers. A stand-alone php class for obtaining information 
 from the ShoutCast server without having to use password. Removed 
 some general "dead" code. Added some alternative skins. Also put 
 in a new Ajax script and modified the cache controll so the dynamic 
 song update also works in IE. (NOTE: This version does not work as a 
 module for mx-systems).
February 4, 2008 Niklas Pull aka Little Frog

- Version 1.08 - 1.09 - Backported versions.

- Version 1.07 - Upgrade that allows to play icyx aac 
 plus streams in IE and FF.
January 22, 2008 OryNider

- Version 1.05 - "This is version 1.05 Beta with some changes."
January 21, 2008 OryNider

- Version 1.04 - Fixed some problems With WMP 9 (Windows 98 SE)
October 23, 2006 OryNider

- Version 1.04 beta 1 - In contrib/no_pass/ you have a version
 of getinfo.php that is not using a password to get info from
 the shotcast server. The info is readed from 7.html and the station
 name from config.php. You dont need to upload the contrib folder.
 To use it upload contrib/no_pass/getinfo.php replaceing the
 original file. 
October 23, 2006 OryNider

- Version 1.03 - Forced media player mode for NetScape using
 MIME type="audio/mpeg" in the Mac script.
October 22, 2006 OryNider

- Version 1.02 - Rewriten wmp script by OryNider in JavaScript
 for Firefox. In Firefox and Linux when media mode user normaly
 will be propted to install a plugin, but since this is hidden
 in iframes user will have to install the plugin manualy.
October 21, 2006 OryNider

- Version 1.01 - Fixed real mode by OryNider for Firefox.
October 7, 2006 OryNider

- Verion 1.00 - Original version with all base code created by
 Niklas Pull
May 17, 2006 Niklas Pull aka Little Frog



---------------------------------------------------------------------
