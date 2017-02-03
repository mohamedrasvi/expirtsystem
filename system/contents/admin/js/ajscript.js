// JavaScript Document
var xmlHttp;
var elementID;


function show(str, elem) {
	if (elem != null) {
		elementID = elem;	
	}
	
	if (str.length==0) { 
		document.getElementById(elementID).innerHTML="";
		return
	}
	
	xmlHttp=GetXmlHttpObject()
	
	if (xmlHttp==null) {
		alert ("Browser does not support HTTP Request");
		return
	} 
	
	var url=str;
	xmlHttp.onreadystatechange=stateChanged ;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
		document.getElementById(elementID).innerHTML=xmlHttp.responseText; 
	} else {
		document.getElementById(elementID).innerHTML="Loading...";
	}
} 

function GetXmlHttpObject() { 
	var objXMLHttp=null;
	if (window.XMLHttpRequest) {
		objXMLHttp=new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
} 