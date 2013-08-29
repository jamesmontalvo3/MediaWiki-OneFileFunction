MediaWiki-OneFileFunction
=========================

MediaWiki extension to make a single way of creating links to files,
whether they are located on the wiki ("File:My file.pdf"), somewhere
else accessible via http ("http://example.com/my-file.pdf"), or on 
the local file system ("C:/Users/you/my file.pdf").

Most importantly for simplification of MediaWiki use by new users, 
wiki files are created with a primary link that goes **directly to the
file**, not to the file's wiki page. In superscript after the primary
link is a link that says "file info" which brings you to the wiki page

If the parser function sees that the file starts with "File:" it will
link to a local wiki file. 

If it sees that ":File:" is located within the filename with text 
preceding it (i.e. "w:File:Filename.pdf") then it will create a link
to the appropriate URL from the interwiki table.

If it sees "http://", "https://" or "ftp://" it creates an external 
link to the http-accessible (or ftp-accessible) file.

If it sees a single letter followed by a colon and one or two slashes
(either forward or back slashes) it will create a local file link of
sorts. For example, "C:/Program Files/Git" or "C:\Program Files\Git" 
will both create links to the same location. "C://Program Files/Git"
and "C:\\Program Files\Git" will both be replaced by "C:\..." and 
"C:/...", respectively. This is because Windows 7 Explorer appears to
not like double-slashes.