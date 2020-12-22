EUCookieCheck = function(cookieName){

  var _this = this;

  _this.cookieName = cookieName;
  _this.cookiesEnabled = false;

  _this.init = function(){
    this.cookiesEnabled = cookiesEnabled();
    if(this.cookiesEnabled){
      this.hasAccepted = getCookie(_this.cookieName) === 'ok';      
    }
  };

  _this.acceptCookie = function(){
    var years = 10;
    document.cookie = _this.cookieName+'=ok; max-age=' + (60*60*24*356*years) +';';
  };

  // getCookie by name
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
} 

  // check in cookie enabled
  function cookiesEnabled () {
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;
    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled) { 
        document.cookie="testcookie";
        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
    }
    return (cookieEnabled);
  }

  _this.init();
  
  return _this;
};

jQuery(function(){
  // eu cookie hint
  var ln = (lang == undefined) ? '' : ('_' + lang);
  var euCookie = new EUCookieCheck("SpringWORK-EUCookie" + ln);
  if(euCookie.cookiesEnabled === true && euCookie.hasAccepted !== true){
    var cookieHint = $('#cookie-hint');
    
    cookieHint.addClass("active");
    cookieHint.css({opacity:0, bottom:'-200px'});
    cookieHint.animate( {opacity:1, bottom:'0px'}, 500, function() {});

    var closeButton = cookieHint.find('a.cookie-accept-close');
    closeButton.click(function(event) {
      event.preventDefault();
      euCookie.acceptCookie();
      cookieHint.animate( {opacity:0, bottom:'-200px'}, 500, function() {
      	cookieHint.remove();
      });
    });
  }
});