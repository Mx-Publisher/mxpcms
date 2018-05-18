/* 
	Copyright: Robert Nyman, http://www.robertnyman.com
	Free to use for anyone, for studying or commercial purposes. This text has to be included when used:
	Concept and code by Robert Nyman, http://www.robertnyman.com
*/
// ---
var ask = new Ask();
addWindowEvent("load", function(){ask.init();}, false);
addWindowEvent("unload", function(){ask.clearVariables();}, false);
// ---
function Ask(){	
	this.hasXmlHttpSupport = typeof XMLHttpRequest != "undefined" || typeof window.ActiveXObject != "undefined";
	this.xmlHttp = null;
	this.xmlHttpCallComplete = true;	
	this.isIE = document.all && navigator.userAgent.search(/MSIE/i) != -1 && navigator.userAgent.search(/Opera/i) == -1;
	this.isIE50 = this.isIE && navigator.userAgent.search(/MSIE 5.0/i) != -1;
	this.iframe = null;
	this.iframeFakeFile = "blank.htm";
	this.hashLocation = location.hash;
	this.locationInterval = null;
	this.history = [];
	this.useSameTargetForSeveralCalls = false;
	this.linksToGetContentFor = null;
	this.intUniqueCounter = 0;
	this.urlExt = "ajax=true";
	this.links = [];
	this.currentLink = null;
	this.currentLinkIndex = null;
	this.currentLinkURL = null;
	this.elmToPresentIn = null;
	this.responseText = "";
}
Ask.prototype.init = AskInit;
Ask.prototype.clearVariables = AskClearVariables;
Ask.prototype.timerLocationCheck = AskTimerLocationCheck;
Ask.prototype.setState = AskSetState;
Ask.prototype.createXmlHttp = AskCreateXmlHttp;
Ask.prototype.clearXmlHttp = AskClearXmlHttp;
Ask.prototype.createHistory = AskCreateHistory;
Ask.prototype.addEvents = AskAddEvents;
Ask.prototype.getContent = AskGetContent;
Ask.prototype.getMultipleContent = AskGetMultipleContent;
Ask.prototype.presentContent = AskPresentContent;
// ---
function AskInit(){
	if(this.hasXmlHttpSupport){
		this.addEvents(document);
		if(this.isIE && !this.isIE50){
			var oIframe = document.createElement("iframe");
			oIframe.style.position = "absolute";
			oIframe.style.left = "-999px";
			oIframe.setAttribute("id", "fake-history-iframe");
			document.body.appendChild(oIframe);
			this.iframe = window.frames["fake-history-iframe"];
			this.iframe.location.href = this.iframeFakeFile;
		}
		if(!this.isIE50){
			if(this.hashLocation.length > 0){
				this.setState();
			}
			else{
				this.locationInterval = setInterval("ask.timerLocationCheck()", 100);
			}
		}
	}
}
// ---
function AskClearVariables(){
	this.clearXmlHttp();
	this.xmlHttpCallComplete = true;
	this.locationInterval = null;
	this.iframe = null;
	this.hashLocation = location.hash;
	this.history = [];
	this.intUniqueCounter = 0;
	this.links = [];
	clearInterval(this.locationInterva);
}
// ---
function AskTimerLocationCheck(){
	if(location.hash != this.hashLocation){
		this.hashLocation = location.hash;
		this.setState();
	}
}
// ---
function AskSetState(){
	var arrLinkIndexes = (this.hashLocation.length > 1)? this.hashLocation.replace(/#/, "").split(":") : [];
	if(arrLinkIndexes.length > 0 && this.history.length == 0){
		this.linksToGetContentFor = [];
		try{
        	for(var i=0; i<arrLinkIndexes.length; i++){
				intLinkIndex = arrLinkIndexes[i];
				this.linksToGetContentFor.push(this.links[intLinkIndex][0]);
			}
        }
        catch(e){
        	// To avoid history cache errors in IE
        }
		this.getMultipleContent();
	}
	else if(arrLinkIndexes.length > 0 || this.history.length > 0){
		var bNavigateBack = (this.history.length > arrLinkIndexes.length)? true : false;
		var intLinkIndex;
		if(bNavigateBack){
			intLinkIndex = this.history.last();
			var strElmToRemoveContentFromId = this.links[intLinkIndex][1];
			document.getElementById(strElmToRemoveContentFromId).innerHTML = this.links[intLinkIndex][2];
		}
		else{
			intLinkIndex = arrLinkIndexes.last();
			var oRegExp = new RegExp((intLinkIndex));
			var oLinkToGetContentFor = this.links[intLinkIndex][0];
			var strRetrievedContent = this.links[intLinkIndex][3];
			var bHasCachedContent = strRetrievedContent && strRetrievedContent.length > 0;
			if(bHasCachedContent){
				this.responseText = strRetrievedContent;
			}
			ask.getContent(oLinkToGetContentFor, bHasCachedContent);
		}
		this.history = arrLinkIndexes;
	}
}
// ---
function AskCreateXmlHttp(){
	if(typeof XMLHttpRequest != "undefined"){
		this.xmlHttp = new XMLHttpRequest();
	}
	else if(typeof window.ActiveXObject != "undefined"){
		this.xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
}
// ---
function AskClearXmlHttp(){
	this.responseText = "";
	if(this.xmlHttp){
		this.xmlHttp.onreadystatechange = function(){};
		if(typeof this.xmlHttp.abort == "function"){
			this.xmlHttp.abort();
		}
		this.xmlHttp = null;
		this.xmlHttpCallComplete = true;
	}
}
// ---
function AskCreateHistory(oLink){
	this.currentLinkIndex = oLink.getAttribute("rel").replace(/ask-/, "");
	if(this.history.toString().search(this.currentLinkIndex) == -1 || this.useSameTargetForSeveralCalls){
		this.history.push(this.currentLinkIndex);
		var strHistoryJoined = this.history.join(":");
		if(this.isIE && this.iframe){
			this.iframe.location.href = this.iframeFakeFile + "?loadedcontent=" + strHistoryJoined;
		}
		else{
			location.hash = strHistoryJoined;
		}
	}
}
// ---
function AskAddEvents(oContainerElm){
	var arrAllAJAXLinks = getElementsByClassName(oContainerElm, "a", "ask");
	for(var i=0; i<arrAllAJAXLinks.length; i++){
		oLink = arrAllAJAXLinks[i];
		oLink.setAttribute("rel", ("ask-" + this.intUniqueCounter++));
		arrAllAJAXLinks[i].onclick = function (oEvent){
			var oEvent = (typeof oEvent != "undefined")? oEvent : event;
			oEvent.returnValue = false;
			if(oEvent.preventDefault){
				oEvent.preventDefault();
			}
			if(ask.isIE50){
				ask.getContent(this);
			}
			else{
				ask.createHistory(this);
			}
		};
		this.links.push([oLink, oLink.className.replace(/.*target-([\w\d\-]+)(\b.*|$)/i, "$1")]);
	}
}
// ---
function AskGetContent(oLink, bHasCachedContent){
	this.currentLink = oLink;
	var strURL = this.currentLink.getAttribute("href");	
	this.currentLinkURL = strURL + ((strURL.search(/\?/) != -1)? "&" : "?") + this.urlExt + '&ajaxblock=' + this.currentLink.className.replace(/.*target-([\w\d\-]+)(\b.*|$)/i, "$1");
	this.elmToPresentIn = document.getElementById(this.currentLink.className.replace(/.*target-([\w\d\-]+)(\b.*|$)/i, "$1"));
	if(!bHasCachedContent){
		this.createXmlHttp();
		this.xmlHttpCallComplete = false;
		this.xmlHttp.onreadystatechange = function (){
			if(ask.xmlHttp && ask.xmlHttp.readyState == 4){				
				ask.presentContent();
			}
		}
		this.xmlHttp.open("GET", this.currentLinkURL, true);
		this.xmlHttp.send(null);
	}
	else{
		this.presentContent();
	}
}
// ---
function AskGetMultipleContent(){
	if(this.linksToGetContentFor.length > 0){
		if(this.xmlHttpCallComplete){
			var oLink = this.linksToGetContentFor.shift();
			this.createHistory(oLink);
			this.getContent(oLink);
		}
		setTimeout("ask.getMultipleContent()", 100);
	}
	else{
		this.locationInterval = setInterval("ask.timerLocationCheck()", 100);
	}
}
// ---
function AskPresentContent(){
	if(this.xmlHttp){
		this.responseText = this.xmlHttp.responseText;
	}
	if(!this.isIE50){
		this.links[this.currentLinkIndex][2] = this.elmToPresentIn.innerHTML;
		if(typeof this.links[this.currentLinkIndex][3] == "undefined"){
			this.links[this.currentLinkIndex][3] = this.responseText;
		}
	}
	this.elmToPresentIn.innerHTML = this.responseText;
	this.addEvents(this.elmToPresentIn);
	this.clearXmlHttp();
}
// ---
function addWindowEvent(strEvent, oFunction, bCapture){
	if(window.addEventListener){
		window.addEventListener(strEvent, oFunction, bCapture);
	}
	else if(window.attachEvent){
		window.attachEvent(("on" + strEvent), oFunction)
	}
}
// ---
function getElementsByClassName(oElm, strTagName, strClassName){
	var arrElements = (strTagName == "*" && document.all)? document.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
	var oElement;
	for(var i=0; i<arrElements.length; i++){
		oElement = arrElements[i];		
		if(oRegExp.test(oElement.className)){
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}
// ---
if(typeof Array.prototype.push != "function"){
	Array.prototype.push = ArrayPush;
	function ArrayPush(value){
		this[this.length] = value;
	}
}
Array.prototype.last = ArrayLast;
function ArrayLast(value){
	return this[this.length - 1];
}
// ---