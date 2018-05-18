/*************************************************************************
 chm2web Navigation Script 1.0 
 Copyright (c) 2002-2003 A!K Research Labs (http://www.aklabs.com)
 http://chm2web.aklabs.com - HTML Help Conversion Utility
**************************************************************************/

var NV = ["helpimages/contents.htm","introduction/contents.htm","introduction/overview.htm","introduction/why_mxbb.htm","introduction/why_not_mxbb.htm","installing/contents.htm","installing/requirements.htm","installing/download_packages.htm","installing/uploading.htm","installing/the_installation_wizard.htm","installing/confirmation.htm","upgrading/contents.htm","upgrading/introduction.htm","upgrading/full.htm","upgrading/changed_files.htm","upgrading/code_changes.htm","uninstalling/contents.htm","uninstalling/backup_data.htm","uninstalling/uninstalling.htm","upgrading/confirmation.htm","administration/introduction.htm"];
var s = "chapters/";
function getNav(op) { var p=chmtop.c2wtopf.pageid;var n=s+p; var m=NV.length-1;for(i=0;i<=m;i++){if(NV[i]==p){if(op=="next"){if (i<m) {curpage=i+1;return s+NV[i+1];} else return n;}else{if(i>0) {curpage=i-1;return s+NV[i-1];} else return n;}}} return n;}
function syncTopic(){open('helpheaderc.html', 'header');open('helpcontents.html','toc');}
