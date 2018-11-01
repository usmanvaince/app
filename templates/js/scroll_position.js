function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
  		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  		x=x.replace(/^\s+|\s+$/g,"");
  		if (x==c_name) {
    		return unescape(y);
    	}
  	}
}

function loadpos() {
	if (getCookie("doscroll") == 1) {
		window.scrollTo(0,getCookie("poss"));
		setCookie("doscroll",0,365);
	}
}

function savepos() {
	setCookie("poss",window.pageYOffset,365);
}

function scrollit() {
	setCookie("doscroll",1, 365);
}