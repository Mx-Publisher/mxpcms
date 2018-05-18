<?php
//require '../../../config.php';
//$CONFIG['encoding'] is replaced by iso-8859-1
?>
// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | management.js                                                      |
// | Some functions, stuff for documents & folders management.          |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

function Fader(id) {
    this.start = function() {
        this.timerId = setInterval(change, 80);
    };
    this.stop = function() {
        clearInterval(this.timerId);
        this.opacity = 80;
        this.direction = 0;
        document.getElementById(this.id).style.opacity = 1;
        document.getElementById(this.id).style.MozOpacity = 1;
        document.getElementById(this.id).style.filter = 80;
    };
    function change() {
        self.opacity += (self.direction ? 10 : -10);
        document.getElementById(self.id).style.opacity = self.opacity/100;
        document.getElementById(self.id).style.MozOpacity = self.opacity/100;
        document.getElementById(self.id).style.filter = "alpha(opacity="+self.opacity+")";
        if (self.opacity == 20) { self.direction = 1; }
        if (self.opacity == 80) { self.direction = 0; }
    }
    var self = this;
    this.id = id;
    this.timerId = null;
    this.opacity = 80;
    this.direction = 0;
}

var tabsLoading = new Fader("tabs-loading");
var tabsSaving = new Fader("tabs-saving");

function tabsLoadingOn() { document.getElementById("tabs-loading").style.display = "block"; tabsLoading.start(); }
function tabsLoadingOff() { document.getElementById("tabs-loading").style.display = "none"; tabsLoading.stop(); }
function tabsSavingOn() { document.getElementById("tabs-saving").style.display = "block"; tabsSaving.start(); }
function tabsSavingOff() { document.getElementById("tabs-saving").style.display = "none"; tabsSaving.stop(); }

function documentInfo() {
	if (!tree.active || !tree.getActiveNode().isDocument()) {
        alert("You have to select a document in the Tree View to perform this action.");
        return;
    }
    checkContentSaved();

    AjaxRequest.get(
	  {
	  	'url':'modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-document-info.php'
	    ,'parameters':{ 'id':escape(treeGetId()), 'block_id':mxBlock.block_id, 'page_id':mxBlock.page_id }
	    ,'onLoading':function() { clearTabs(); tabsLoadingOn(); }
	    ,'onComplete':function() { tabsLoadingOff(); }
	  	,'onSuccess':function(req){ el('tabs-data').innerHTML = req.responseText; updateTabs('tab1'); dhtmlHistory.add( treeGetId(),  el(tree.active+"-text").innerHTML  );}
	  	,'onError':function(req){ el('tabs-data').innerHTML = 'Error!\nStatusText='+req.statusText+'\nContents='+req.responseText;}
	  	,'timeout':5000
    	,'onTimeout':function(){ clearTabs(); tabsLoadingOff(); el('tabs-data').innerHTML = 'Timed out. Try again!'; }
	  }
	);
}

function editContent() {
    if (!tree.active || !tree.getActiveNode().isDocument()) {
        alert("You have to select a document in the Tree View to perform this action.");
        return;
    }

    checkContentSaved();

    AjaxRequest.get(
	  {
	  	'url':'modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-edit-content.php'
	    ,'parameters':{ 'id':escape(treeGetId()), 'block_id':mxBlock.block_id, 'page_id':mxBlock.page_id }
	    ,'onLoading':function() { clearTabs(); tabsLoadingOn(); }
	    ,'onComplete':function() { tabsLoadingOff(); }
	    ,'onSuccess':function(req){ el('tabs-data').innerHTML = req.responseText; initTinyMCEEditor(); updateTabs('tab2'); dhtmlHistory.add( treeGetId(),  el(tree.active+"-text").innerHTML  );}
	    //,'onSuccess':function(req){ el('tabs-data').innerHTML = req.responseText; initTinyMCEEditor(); el('body-tmp').value = el('body').value; updateTabs('tab2'); dhtmlHistory.add( treeGetId(),  el(tree.active+"-text").innerHTML  );}
	  	,'onError':function(req){ el('tabs-data').innerHTML = 'Error!\nStatusText='+req.statusText+'\nContents='+req.responseText;}
	  	,'timeout':5000
    	,'onTimeout':function(){ clearTabs(); tabsLoadingOff(); el('tabs-data').innerHTML = 'Timed out. Try again!'; }
	  }
	);
}

/*
 var ste = null;
 function initSimpleEditor(){
  ste = new SimpleTextEditor("body", "ste");
  ste.path = "modules/mx_simpledoc/simpledoc/shared/SimpleTextEditor/";
  ste.charset = "iso-8859-1";
  ste.init();
  ste.frame.document.onkeydown = keyPress;
  // aaa!! next IE bug, editor images not loading :\
  if (document.all) {
      setTimeout(loadEditorImages, 50);
  }
}
*/

function initTinyMCEEditor(){
	tinyMCE.execCommand('mceAddControl', false, 'body');
	// var inst = tinyMCE.getInstanceById('body');
	// MyEditor = inst.editorId;
}

function documentPreview() {
    if (!tree.active || !tree.getActiveNode().isDocument()) {
        alert("You have to select a document in the Tree View to perform this action.");
        return;
    }

    checkContentSaved();

    AjaxRequest.get(
	  {
	  	'url':'modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-view-content.php'
	    ,'parameters':{ 'id':escape(treeGetId()), 'block_id':mxBlock.block_id, 'page_id':mxBlock.page_id }
	    ,'onLoading':function() { clearTabs(); tabsLoadingOn(); }
	    ,'onComplete':function() { tabsLoadingOff(); }
	  	,'onSuccess':function(req){ el('tabs-data').innerHTML = addTocDiv(stripBodyHtml(req.responseText)); generateTOC('index'); updateTabs('tab3'); }
	  	,'onError':function(req){ el('tabs-data').innerHTML = 'Error!\nStatusText='+req.statusText+'\nContents='+req.responseText;}
	  	,'timeout':5000
    	,'onTimeout':function(){ clearTabs(); tabsLoadingOff(); el('tabs-data').innerHTML = 'Timed out. Try again!'; }
	  }
	);
}

function documentView() {
	if (!tree.active || !tree.getActiveNode().isDocument()) {
       alert("You have to select a document in the Tree View to perform this action.");
       return;
    }

    AjaxRequest.get(
	  {
	  	'url':'modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-view-publish.php'
	    ,'parameters':{ 'id': escape(treeGetId()), 'block_id':mxBlock.block_id, 'page_id':mxBlock.page_id }
	    ,'onLoading':function() { clearTabs(); tabsLoadingOn(); }
	    ,'onComplete':function() { tabsLoadingOff(); }
	  	,'onSuccess':function(req){ el('tabs-data').innerHTML = stripBodyHtml(req.responseText); generateParentTOC('view'); generateTOC('view');}
	  	,'onError':function(req){ el('tabs-data').innerHTML = 'Error!\nStatusText='+req.statusText+'\nContents='+req.responseText; }
	  	,'timeout':5000
    	,'onTimeout':function(){ clearTabs(); tabsLoadingOff(); el('tabs-data').innerHTML = 'Timed out. Try again!'; }
	  }
	);
}

function saveContent() {

    AjaxRequest.post(
	  {
	  	'url':'modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-save-content.php'
	    ,'parameters':{ 'id':escape(treeGetId()), 'block_id':mxBlock.block_id, 'page_id':mxBlock.page_id, 'body':tinyMCE.getContent() }
	    ,'onLoading':function() { tabsSavingOn(); el('save-document').disabled = true;}
	    ,'onComplete':function() { tabsSavingOff(); }
	  	,'onSuccess':function(req){ el('save-document').disabled = false; }
	  	,'onError':function(req){ el('tabs-data').innerHTML = 'Error!\nStatusText='+req.statusText+'\nContents='+req.responseText;}
	  	,'timeout':5000
    	,'onTimeout':function(){ clearTabs(); tabsLoadingOff(); el('tabs-data').innerHTML = 'Timed out. Try again!'; }
	  }
	);

    el("saved").innerHTML = "Saved successfuly on "+(new Date()+"<br>(this message will disappear in 2 seconds)");
    if (savedTimerID) clearTimeout(savedTimerID);
    savedTimerID = setTimeout(function(){ el("saved").innerHTML = "";}, 1000);

    tinyMCE.selectedInstance.undoRedo.undoLevels = [];
}

/*
function saveContent(theform) {

	tabsSavingOn();
	el('save-document').disabled = true;
	//el('tabs-data').style.visibility = "hidden";

  	var status = AjaxRequest.submit(
    	theform
    	,{
      		'onSuccess':function(req){  }
    	}
  	);

    el('save-document').disabled = false;
    el('body-tmp').value = el('body').value;
  	tabsSavingOff();

  	//var data = {"body": el('body').value}
    //var save = httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__tab-save-content.php?id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id, data);

    if ((typeof status == "boolean" && !status) || typeof status == "string") {
        alert("Unknown error, cannot save document.");
    } else {
        el("saved").innerHTML = "Saved successfuly on "+(new Date()+"<br>(this message will disappear in 3 seconds)");
        if (savedTimerID) clearTimeout(savedTimerID);
        savedTimerID = setTimeout(function(){ el("saved").innerHTML = ""; }, 3000);
    }

   	return status;
}
*/

// this snippet doesn't work if there is a folder named "html"
// Only used when the doc is generated as part of the app - inline (scripts are stripped in plain code)
function generateTOC(mode) {
    var contents = "";
    //var link = escape(treeGetId());
    var link = treeGetId();

    contents = '<div><a target="_blank" href="index.php?page='+mxBlock.page_id+'&mode='+mode+'#'+link+'">Permanent Link to this page</a></div>';

    var all = document.getElementById("tabs-data").getElementsByTagName('*');
    var contents2 = "";
    var text = "";
    var found = false;
    var h2 = false;
    var h3 = false;

    contents2 += '<b>Contents</b><ul>';
    for (var i = 0; i < all.length; ++i) {

    	if (all[i].nodeName == "H1" || all[i].nodeName == "H2" || all[i].nodeName == "H3") {

            if (all[i].nodeName == "H1") {
                if (h3 || h2) contents2 += '</ul>';
                h2 = false;
                h3 = false;
            }

            if (all[i].nodeName == "H2") {
            	if (h3) contents2 += '</ul>';
                if (!h2) contents2 += '<ul>';
                h2 = true;
            }

            if (all[i].nodeName == "H3") {
                if (!h3) contents2 += '<ul>';
                h3 = true;
            }

            found = true;
            text = all[i].innerHTML.replace(/<[^>]+>/g,"");
            all[i].innerHTML = '<a name="'+text+'">'+text+'</a>';
            var str_temp = document.URL.split("#", 1);
           	contents2 += '<li><a href="'+str_temp+'#'+text+'">'+text+'</a></li>';
        }

    }
    contents2 += '</ul>';

    if (found) {
        if (contents) contents += '<br>';
        contents += contents2;
    }
    if (contents) {
        document.getElementById("contents").className = "contents";
        document.getElementById("contents").innerHTML = contents;
    }

    //alert(document.getElementById("tabs-data").innerHTML);
}

// this snippet doesn't work if there is a folder named "html"
// Only used when the doc is generated as part of the app - inline (scripts are stripped in plain code)
function generateParentTOC(mode) {
    var contents = "";
    var loc = "";
    var contents2 = "";
    var title = "<h1>Section Contents</h1>";
    var s = '';

    if(!document.getElementById("sectioncontents")) {
    	document.getElementById("tabs-data").innerHTML = addTocDiv('');
    }

	var node = tree.getActiveNode();
	while (node && node.parentNode) {
	    loc = (!node.isDocument() ? ' &raquo; ' + '<a href="javascript:void(0)"><span '+(node.childNodes.length ? 'ondblclick="tree.nodeClick(\''+node.id+'\'); node.blur();"' : "")+' onclick="tree.textClick(\''+node.id+'\')">'+node.text+'</span></a>' : '') + loc;
	    node = node.parentNode;
	}
	loc = '<a href="index.php?page='+mxBlock.page_id+'&mode='+mode+'">Table of Contents</a> ' + loc;

	node = tree.getActiveNode();
	if (node.childNodes) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	    	contents2 += node.childNodes[i].toToc();
	    }
	}
	contents2 = contents2 != '' ? title + contents2 : '';
    contents = loc + ' <hr align="left"> ' + contents2;

    if (contents) {
    	document.getElementById("sectioncontents").className = "sectioncontents";
        document.getElementById("sectioncontents").innerHTML = contents;
    }
}

function stripBodyHtml(html) {

	// Remove HTML comments
	//html = html.replace(/<!--[\w\s\d@{}:.;,'"%!#_=&|?~()[*+\/\-\]]*-->/gi, "" );
    // Remove all HTML tags
	//html = html.replace(/<\/?\s*HTML[^>]*>/gi, "" );
    // Remove all BODY tags
    //html = html.replace(/<\/?\s*BODY[^>]*>/gi, "" );
    // Remove all META tags
	//html = html.replace(/<\/?\s*META[^>]*>/gi, "" );
    // Remove all TITLE tags & content
	//html = html.replace(/<\s*TITLE[^>]*>([^<]*)<\/\s*TITLE\s*>/i, "" );
    // Remove all HEAD tags & content
	//html = html.replace(/<\s*HEAD[^>]*>([^<]*)<\/\s*HEAD\s*>/i, "" );
    // Remove all SCRIPT tags
	//html = html.replace(/<\s*SCRIPT[^>]*>([^<]*)<\/\s*SCRIPT\s*>/i, "" );

    // Remove all SPAN tags
	//html = html.replace(/<\/?\s*SPAN[^>]*>/gi, "" );
    // Remove all STYLE tags
	//html = html.replace(/<\s*STYLE[^>]*>([^<]*)<\/\s*STYLE\s*>/i, "" );
	// Remove Class attributes
	//html = html.replace(/<\s*(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "") ;
	// Remove Style attributes
	//html = html.replace(/<\s*(\w[^>]*) style="([^"]*)"([^>]*)/gi, "") ;

	//html = html.replace(/<\s*br[^>]*>/gi,"");

	html = html.trim();

	return html;
}

function addTocDiv(html) {
	html = '<div id="contents"></div>' + '<div id="sectioncontents"></div>' + html;
	return html;
}

function loadEditorImages() {
    var a = el('tabs-data').getElementsByTagName("img");
    for (var i = 0; i < a.length; ++i) {
        if (!a[i].complete && a[i].outerHTML) {
            a[i].outerHTML = a[i].outerHTML;
        }
    }
}

var savedTimerID = null;

/*
function isContentSaved() {
    if (ste && el("body") && el("save-document")) {
        ste.submit();
        if (el("body").value != el("body-tmp").value) {
            return false;
        }
    }
    return true;
}
*/

function isContentSaved() {
    if (el("save-document")) {
        if (tinyMCE.selectedInstance.undoRedo.undoLevels.length > 1) {
            return false;
        }
    }
    return true;
}

function checkContentSaved() {
    if (!isContentSaved()) {
        if (confirm("Content has not been saved since last change.\nSave it ?")) {
            saveContent();
        }
    }
}

function clearTabs() {
    if(el('tab1')) {el('tab1').className = "tab";}
    if(el('tab2')) {el('tab2').className = "tab right";}
    if(el('tabs-data')) {el('tabs-data').innerHTML = "";}
}

function updateTabs(active){
	el('tab1').className = "tab"+((active=='tab1')?"-active":"");
    el('tab2').className = "tab"+((active=='tab2')?"-active":"")+" right";
    el('tab3').className = "tab"+((active=='tab3')?"-active":"")+" view";
}

function keyPress(e) {
    if (!e) {
        if (!this.parentWindow) return;
        e = this.parentWindow.event;
    }
    if (e.ctrlKey && e.keyCode == 83) {
        if (el("body") && el("save-document")) {
            el("save-document").click();
        }
    }
    if (e.altKey && e.keyCode == 49) documentInfo();
    if (e.altKey && e.keyCode == 50) editContent();
}
document.onkeydown = keyPress;