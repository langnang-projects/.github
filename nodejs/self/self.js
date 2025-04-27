
class App {
  static $() { }
  static loadStyle(href, success, error) {
    var style = document.createElement("link");
    style.rel = "stylesheet";
    style.type = "text/css";
    style.href = href;
    style.onload = function () {
      // console.log(`onload loadStyle ${href}`, this);
      if (success) success();
    }
    style.onerror = function () {
      // console.log(`onerror loadStyle ${href}`, this);
      if (error) error();
    }
    document.head.appendChild(style);
  } static loadStylePrepend(href, success, error) {
    var style = document.createElement("link");
    style.rel = "stylesheet";
    style.type = "text/css";
    style.href = href;
    style.onload = function () {
      // console.log(`onload loadStyle ${href}`, this);
      if (success) success();
    }
    style.onerror = function () {
      // console.log(`onerror loadStyle ${href}`, this);
      if (error) error();
    }
    document.head.prepend(style);
  }
  static loadStyleError() { }
  static loadStyleSuccess() { }
  static loadScript(src, success, error) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = src;
    script.onload = function () {
      // console.log(`onload loadScript ${src}`, this);
      if (success) success();
    }
    script.onerror = function () {
      // console.log(`onerror loadScript ${src}`, this);
      if (error) error();
    }
    document.head.appendChild(script);
  }
  static loadScriptPrepend(src, success, error) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = src;
    script.onload = function () {
      // console.log(`onload loadScript ${src}`, this);
      if (success) success();
    }
    script.onerror = function () {
      // console.log(`onerror loadScript ${src}`, this);
      if (error) error();
    }
    document.head.prepend(script);
  }
  static loadScriptError() { }
  static loadScriptSuccess() { }

}
// load style
// App.loadStyle("");
App.loadStyle("https://unpkg.com/normalize.css@8.0.1/normalize.css");
App.loadStyle("https://unpkg.com/animate.css@4.1.1/animate.min.css");
App.loadStyle("https://unpkg.com/perfect-scrollbar@1.5.5/css/perfect-scrollbar.css");
// load script
// App.loadScript("");
App.loadScript("https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js");
App.loadScript("https://unpkg.com/axios@1.7.4/dist/axios.min.js");
App.loadScript("https://unpkg.com/holderjs@2.9.9/holder.min.js");
App.loadScript("https://unpkg.com/moment@2.30.1/min/moment.min.js");
App.loadScript("https://unpkg.com/lodash@4.17.21/lodash.min.js");
App.loadScript("https://unpkg.com/mockjs@1.1.0/dist/mock-min.js");
App.loadScript("https://unpkg.com/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js");
