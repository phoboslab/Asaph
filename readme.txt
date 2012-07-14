Asaph version 1.0 

Author: Dominic Szablewski
Web: http://www.phoboslab.org/projects/asaph


Requirements & Installation
-------------------------------------------------------------------------

Asaph needs PHP 5.0 or higher with the GD-lib installed and cURL or
allow_url_fopen enabled. Also MySQL 4.0 or higher and an already created
database is needed. To post entries to your blog, you'll need a good
browser (read: anything not Internet Explorer).

To install, enter your database and server settings in the
lib/asaph_config.class.php file. The settings you absolutely need to 
change are $domain, $absolutePath and $db. You also have the option to 
switch from the minimalist whiteout templates to the stickney templates 
by just replacing both occurrences of "whiteout" with "stickney" in the 
$templates setting.

When done, upload all files to your server and make sure the data/
directory is writable - this is where Asaph stores all images and 
thumbnails. After that, point your browser to admin/install.php and 
follow the instructions.



Usage / Posting
-------------------------------------------------------------------------

The only way to post new entries to your Asaph blog, is through a 
bookmarklet. After logging in to your admin menu, you will see the ASAPH
bookmarklet on the left. Just drag this link to your bookmarks bar and
you're set. 

Now, navigate your browser to any page you want and click your newly 
created bookmark. A small box should pop up and all images on the page
should now have a dashed blue border (if not, see the FAQ). You can now 
either click on any of these images or on "Post this Site" to post the
image or link.



FAQ
-------------------------------------------------------------------------

Q: My bookmarklet is not working
A: This can have several reasons. The most common one is, that your
   $domain and/or $absolutePath setting is not correctly set in the 
   asaph_config.class.php. Refer to the installer (admin/install.php) it 
   should tell you the correct settings for these values in the 
   "Asaph Config" section.
   Another reason for the bookmarklet not working could be, that you
   disabled iframes in your browser. Some ad-block plugins do this.

Q: When posting images I repeatedly get the message "Couldn't create a 
   thumbnail of the image!"
A: Most of the time this happens because Asaph wrongly detects the image 
   URL. Maybe because the thumbnail is linked to an interstitial instead of 
   the image itself. You can enter the image URL manually into the "Image" 
   field if Asaph fails to detect it.
   
Q: I'm getting the error message "parse error, unexpected ',', expecting 
   '(' in /admin/install.php on line 46" when I try to install Asaph.
A: Your server is not running PHP5 (see requirements). Ask Your hoster to
   update.



Thanks
-------------------------------------------------------------------------

Thanks to Nicolas Magnier (www.gamovr.com), Nate Cook (natecook.com) for
some code contributions and countless others for all the helpful comments,
bug reports and suggestions.



Changelog
-------------------------------------------------------------------------

Version 1.0
  - Added more comments to source files, to allow easier modification
  - New $title config variable used in templates
  - Various bugfixes in the RSS template
  - Fixed bug, where changing the post date would not create a new 
    directory in data/
  - Fixed bug, where deleting a post would not delete the image from disk
  - Fixed bug, where the user was being redirected to a malformed URL on
    success (xhrLocation in remote-success.html.php)
  - New template theme "stickney"
  
Beta 2
  - Usage of cURL or url fopen wrappers, based on what's available
  - magic_quotes are now reverted automatically
  - The RSS Feed should now display images properly
  - Fixed bug, where post titles were filtered through htmlspecialchars 
    twice when editing post in the admin menu



License
-------------------------------------------------------------------------

Copyright (C) 2008  Dominic Szablewski

License: http://www.gnu.org/copyleft/gpl.html

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

