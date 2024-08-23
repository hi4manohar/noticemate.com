/*
* in this file common namespace is defined
* common name will be accessed by all the js files
*/

var is = {
  isJson: function(e) {
    if (/^[\],:{}\s]*$/.test(e.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
      return true;
    } else{
      return false;
    }
  },
  isNumeric: function(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  },
  isString: function(s) {
    return s.length == 0 ? false : true;
  },
  isPopupBlocked: function(windowStatus) {
    return !windowStatus || windowStatus.closed || typeof windowStatus.closed=='undefined';
  },
  is_tag: function(elem, t) {
    return $(elem).is(t) ? true : false;
  },
  is_visible: function(e) {
    /* return true if element is not visible */
    return $(e).is(':not(:visible)') ? true : false;
  },
  is_exists: function(e) {
    /* check element exist */
    return $(e).length > 0 ? "exists" : "notExist!";
  },
  type_of: function(v) {
    /* check type */
    return typeof v;
  },
  is_str_length: function(str, strln) {
    return str.length > strln ? true : false;
  },
  is_board : function(bid) {
    return bid.length == 10 ? true : false;
  },
  is_user : function(uid) {
    return uid.length == 10 ? true : false;
  },
  is_attr : function(attr) {
    return typeof attr !== typeof undefined && attr !== false ? true : false;
  }
}

var cm = {
  parseJSON: function(n) {
    return is.isJson(n) ? JSON.parse(n) : "Invalid JSON";
  },
  urlText: function(s) {
    return is.isString(s) ? s.replace(" ", "+").toLowerCase() : "Invalid String";
  },
  getLocation: function(href) {
    var l = document.createElement("a");
    l.href = href;
    return l;
  },
  tagsToReplace: {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
  },
  replaceTag: function(tag) {
    return this.tagsToReplace[tag] || tag;
  },
  escapeHTML: function(str) {
    return str.replace(/[&<>]/g, this.replaceTag);
  },
  removeArrayElement: function(arr) {

    if( Array.isArray(arr) ) {
      var what, a = arguments, L = a.length, ax;
      while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
          arr.splice(ax, 1);
        }
      }
      return arr;
    } else return false;
  }
}