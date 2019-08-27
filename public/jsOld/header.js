/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 110);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(5);
var isBuffer = __webpack_require__(15);

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object' && !isArray(obj)) {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim
};


/***/ }),
/* 1 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "v", function() { return getNotifications; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "s", function() { return getLeadsByAgent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "t", function() { return getMyLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "p", function() { return getIndividualLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "y", function() { return getTeamLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "o", function() { return getHotLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "z", function() { return getTodayLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "x", function() { return getSeen; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "u", function() { return getNotSeen; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "n", function() { return getFavoriteLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return changeLeadFav; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return changeLeadHot; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return deleteLead; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "q", function() { return getLeadData; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return addCall; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return addMeeting; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return addRequest; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return addNote; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "w", function() { return getPublicData; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return getAgents; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "C", function() { return newLeadsFilter; });
/* unused harmony export exportReportLeads */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "F", function() { return switchLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return checkUserGroupAndRoles; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "A", function() { return getUnitTypes; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "D", function() { return searchForLead; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return addToDo; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return getDevProjects; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return addCILRequest; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "E", function() { return storeUnitResale; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return getAllLeads; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "r", function() { return getLeadSources; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "B", function() { return leadShortAdding; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(11);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);
// Import axios


// Get My Leads
var getNotifications = function getNotifications(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/api/agent/notification', data);
};

// Get My Leads
var getLeadsByAgent = function getLeadsByAgent(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/get_leads_by_agent', data);
};

// Get My Leads
var getMyLeads = function getMyLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getMyLeads?page=' + page);
};

// Get Individual Leads
var getIndividualLeads = function getIndividualLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getIndividualLeads?page=' + page);
};

// Get Team Leads
var getTeamLeads = function getTeamLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getTeamLeadsNew?page=' + page);
};

// Get Hot Leads
var getHotLeads = function getHotLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getHotLeads?page=' + page);
};

// Get today leads Leads
var getTodayLeads = function getTodayLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getTodayLeads?page=' + page);
};

// Get Hot Leads
var getSeen = function getSeen(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getSeen?page=' + page);
};

// Get Hot Leads
var getNotSeen = function getNotSeen(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getNotSeen?page=' + page);
};

// Get Favorite Leads
var getFavoriteLeads = function getFavoriteLeads(page) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getFavoriteLeads?page=' + page);
};

// Change Lead Fav Status
var changeLeadFav = function changeLeadFav(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/fav_lead', data);
};

// Change Lead Hot Status
var changeLeadHot = function changeLeadHot(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/hot_lead', data);
};

// Change Lead Hot Status
var deleteLead = function deleteLead(id) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/delete-lead/' + id);
};

// Change Lead Hot Status
var getLeadData = function getLeadData(id) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getLeadData/' + id);
};

// Add Call
var addCall = function addCall(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/add_call', data);
};

// Add Meetings
var addMeeting = function addMeeting(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/add_meetings', data);
};

// Add Request
var addRequest = function addRequest(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/add_Request', data);
};

// Add Note
var addNote = function addNote(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/add_note_ajax', data);
};

// Get Public Data
var getPublicData = function getPublicData() {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getPublicData');
};

// Get Agents
var getAgents = function getAgents() {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getAgents');
};

// Filter Leads
var newLeadsFilter = function newLeadsFilter(page, data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/newLeadsFilter?page=' + page, data);
};

// Filter Report Leads
var exportReportLeads = function exportReportLeads(page, data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/exportReportLeads?page=' + page, data);
};

// Switch Leads
var switchLeads = function switchLeads(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/switch_leads', data);
};

// Switch Leads
var checkUserGroupAndRoles = function checkUserGroupAndRoles() {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/checkUserGroupAndRoles');
};

// Get Unit Types
var getUnitTypes = function getUnitTypes(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/getUnitsTypesnew', data);
};

// Get Unit Types
var searchForLead = function searchForLead(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/searchForLead', data);
};

// Add New ToDo
var addToDo = function addToDo(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/addToDo', data);
};

// Add New ToDo
var getDevProjects = function getDevProjects(id) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getDevProjects/' + id);
};

// Add Cil Request
var addCILRequest = function addCILRequest(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/addCILRequest', data);
};

// Add New Resale
var storeUnitResale = function storeUnitResale(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/storeUnitResale', data);
};
// Get All Leads
var getAllLeads = function getAllLeads() {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getAllLeads');
};

// Get All Leads
var getLeadSources = function getLeadSources() {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get('/admin/getLeadSources');
};

// Add Short Lead
var leadShortAdding = function leadShortAdding(data) {
    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post('/admin/leadShortAdding', data);
};

/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(0);
var normalizeHeaderName = __webpack_require__(17);

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(6);
  } else if (typeof process !== 'undefined') {
    // For node use HTTP adapter
    adapter = __webpack_require__(6);
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(10)))

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var settle = __webpack_require__(18);
var buildURL = __webpack_require__(20);
var parseHeaders = __webpack_require__(21);
var isURLSameOrigin = __webpack_require__(22);
var createError = __webpack_require__(7);
var btoa = (typeof window !== 'undefined' && window.btoa && window.btoa.bind(window)) || __webpack_require__(23);

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();
    var loadEvent = 'onreadystatechange';
    var xDomain = false;

    // For IE 8/9 CORS support
    // Only supports POST and GET calls and doesn't returns the response headers.
    // DON'T do this for testing b/c XMLHttpRequest is mocked, not XDomainRequest.
    if ("development" !== 'test' &&
        typeof window !== 'undefined' &&
        window.XDomainRequest && !('withCredentials' in request) &&
        !isURLSameOrigin(config.url)) {
      request = new window.XDomainRequest();
      loadEvent = 'onload';
      xDomain = true;
      request.onprogress = function handleProgress() {};
      request.ontimeout = function handleTimeout() {};
    }

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    request.open(config.method.toUpperCase(), buildURL(config.url, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request[loadEvent] = function handleLoad() {
      if (!request || (request.readyState !== 4 && !xDomain)) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        // IE sends 1223 instead of 204 (https://github.com/mzabriskie/axios/issues/201)
        status: request.status === 1223 ? 204 : request.status,
        statusText: request.status === 1223 ? 'No Content' : request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      reject(createError('timeout of ' + config.timeout + 'ms exceeded', config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(24);

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(config.url)) && config.xsrfCookieName ?
          cookies.read(config.xsrfCookieName) :
          undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (config.withCredentials) {
      request.withCredentials = true;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(19);

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),
/* 10 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(14);

/***/ }),
/* 12 */,
/* 13 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var bind = __webpack_require__(5);
var Axios = __webpack_require__(16);
var defaults = __webpack_require__(4);

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(utils.merge(defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(9);
axios.CancelToken = __webpack_require__(30);
axios.isCancel = __webpack_require__(8);

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(31);

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),
/* 15 */
/***/ (function(module, exports) {

/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */

// The _isBuffer check is for Safari 5-7 support, because it's missing
// Object.prototype.constructor. Remove this eventually
module.exports = function (obj) {
  return obj != null && (isBuffer(obj) || isSlowBuffer(obj) || !!obj._isBuffer)
}

function isBuffer (obj) {
  return !!obj.constructor && typeof obj.constructor.isBuffer === 'function' && obj.constructor.isBuffer(obj)
}

// For Node v0.10 support. Remove this eventually.
function isSlowBuffer (obj) {
  return typeof obj.readFloatLE === 'function' && typeof obj.slice === 'function' && isBuffer(obj.slice(0, 0))
}


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var defaults = __webpack_require__(4);
var utils = __webpack_require__(0);
var InterceptorManager = __webpack_require__(25);
var dispatchRequest = __webpack_require__(26);
var isAbsoluteURL = __webpack_require__(28);
var combineURLs = __webpack_require__(29);

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = utils.merge({
      url: arguments[0]
    }, arguments[1]);
  }

  config = utils.merge(defaults, this.defaults, { method: 'get' }, config);
  config.method = config.method.toLowerCase();

  // Support baseURL config
  if (config.baseURL && !isAbsoluteURL(config.url)) {
    config.url = combineURLs(config.baseURL, config.url);
  }

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(7);

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  // Note: status is not exposed by XDomainRequest
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }
  error.request = request;
  error.response = response;
  return error;
};


/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      }

      if (!utils.isArray(val)) {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
    }
  });

  return parsed;
};


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  (function standardBrowserEnv() {
    var msie = /(msie|trident)/i.test(navigator.userAgent);
    var urlParsingNode = document.createElement('a');
    var originURL;

    /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
    function resolveURL(url) {
      var href = url;

      if (msie) {
        // IE needs attribute set twice to normalize properties
        urlParsingNode.setAttribute('href', href);
        href = urlParsingNode.href;
      }

      urlParsingNode.setAttribute('href', href);

      // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
      return {
        href: urlParsingNode.href,
        protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
        host: urlParsingNode.host,
        search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
        hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
        hostname: urlParsingNode.hostname,
        port: urlParsingNode.port,
        pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                  urlParsingNode.pathname :
                  '/' + urlParsingNode.pathname
      };
    }

    originURL = resolveURL(window.location.href);

    /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
    return function isURLSameOrigin(requestURL) {
      var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
      return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
    };
  })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return function isURLSameOrigin() {
      return true;
    };
  })()
);


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// btoa polyfill for IE<10 courtesy https://github.com/davidchambers/Base64.js

var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

function E() {
  this.message = 'String contains an invalid character';
}
E.prototype = new Error;
E.prototype.code = 5;
E.prototype.name = 'InvalidCharacterError';

function btoa(input) {
  var str = String(input);
  var output = '';
  for (
    // initialize result and counter
    var block, charCode, idx = 0, map = chars;
    // if the next str index does not exist:
    //   change the mapping table to "="
    //   check if d has no fractional digits
    str.charAt(idx | 0) || (map = '=', idx % 1);
    // "8 - idx % 1 * 8" generates the sequence 2, 4, 6, 8
    output += map.charAt(63 & block >> 8 - idx % 1 * 8)
  ) {
    charCode = str.charCodeAt(idx += 3 / 4);
    if (charCode > 0xFF) {
      throw new E();
    }
    block = block << 8 | charCode;
  }
  return output;
}

module.exports = btoa;


/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
  (function standardBrowserEnv() {
    return {
      write: function write(name, value, expires, path, domain, secure) {
        var cookie = [];
        cookie.push(name + '=' + encodeURIComponent(value));

        if (utils.isNumber(expires)) {
          cookie.push('expires=' + new Date(expires).toGMTString());
        }

        if (utils.isString(path)) {
          cookie.push('path=' + path);
        }

        if (utils.isString(domain)) {
          cookie.push('domain=' + domain);
        }

        if (secure === true) {
          cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
      },

      read: function read(name) {
        var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
        return (match ? decodeURIComponent(match[3]) : null);
      },

      remove: function remove(name) {
        this.write(name, '', Date.now() - 86400000);
      }
    };
  })() :

  // Non standard browser env (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return {
      write: function write() {},
      read: function read() { return null; },
      remove: function remove() {}
    };
  })()
);


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var transformData = __webpack_require__(27);
var isCancel = __webpack_require__(8);
var defaults = __webpack_require__(4);

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers || {}
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(9);

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),
/* 32 */,
/* 33 */,
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(41)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(43)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(45)
/* template */
var __vue_template__ = __webpack_require__(46)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6333ff8b"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/Layout/Header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6333ff8b", Component.options)
  } else {
    hotAPI.reload("data-v-6333ff8b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(44);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(34)("4eb23427", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6333ff8b\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Header.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6333ff8b\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Header.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(13)(false);
// imports


// module
exports.push([module.i, "\n#num[data-v-6333ff8b]\n{\n    background-color: red;\n    padding: 4px 7px;\n    color: white;\n    border-radius: 50%;\n    font-size: 12px;\n}\n.fa[data-v-6333ff8b]\n{\n    font-size: 25px;\n}\n.notifications[data-v-6333ff8b]\n{\n    right: 0px;\n    left: auto;\n    width: 426px;\n}\n.notifications a.notification[data-v-6333ff8b] \n{\n    padding-right: 70px;\n    white-space: normal;\n}\n.notifications img[data-v-6333ff8b]\n{\n    width: 40px;\n    margin-right: 10px;\n}\n.notifications span.date[data-v-6333ff8b]\n{\n    font-size: 10px;\n    position: absolute;\n    bottom: 10px;\n    right: 10px;\n}\n/* ------------------- */\n.navbar-end > a.navbar-item[data-v-6333ff8b], .navbar-end .has-dropdown[data-v-6333ff8b]\n{\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n}\n.navbar-end .navbar-dropdown[data-v-6333ff8b]\n{\n    display: none;\n}\n", ""]);

// exports


/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__calls__ = __webpack_require__(2);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            name: window.auth_user.name,
            id: window.auth_user.id,
            numOfCil: window.auth_user.numOfCil,
            agentType: window.auth_user.agentType,
            token: window.auth_user.token,
            locale: window.auth_user.locale,
            numOfNotifications: window.auth_user.numOfNotifications,
            profileUrl: window.auth_user.profileUrl,
            image: window.auth_user.image,
            defaultImage: window.auth_user.defaultImage,
            userType: window.auth_user.type,
            userHr: window.auth_user.userHr,
            permArray: [],
            showNav: false,
            notifications: []
        };
    },
    created: function created() {
        this.getNotificationsFun();
        setInterval(this.getNotificationsFun, 120000);
    },

    // beforeUpdated(){
    //     this.getNotificationsFun()
    // },
    mounted: function mounted() {
        this.checkUserHasGroup();
    },

    methods: {
        getNotificationsFun: function getNotificationsFun() {
            var _this = this;

            Object(__WEBPACK_IMPORTED_MODULE_0__calls__["v" /* getNotifications */])({
                "token": this.token,
                "user_id": this.id,
                "lang": "en"
            }).then(function (response) {
                _this.notifications = response.data;
                console.log("this.notifica");
                console.log(_this.notifications.num);
            }).catch(function (error) {
                console.log("this.notificassssssss");
                console.log(error);
            });
        },
        checkUserHasGroup: function checkUserHasGroup() {
            var _this2 = this;

            Object(__WEBPACK_IMPORTED_MODULE_0__calls__["i" /* checkUserGroupAndRoles */])().then(function (response) {
                _this2.permArray = response.data.permArray;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
});

/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", { staticClass: "navbar is-white is-fixed-top" }, [
    _c("div", { staticClass: "container is-fluid" }, [
      _c("div", { staticClass: "navbar-brand" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "navbar-item" }, [
          _c(
            "a",
            {
              staticClass: "navbar-burger",
              class: { "is-active": _vm.showNav },
              attrs: {
                role: "button",
                "aria-label": "menu",
                "aria-expanded": "false"
              },
              on: {
                click: function($event) {
                  _vm.showNav = !_vm.showNav
                }
              }
            },
            [
              _c("span", { attrs: { "aria-hidden": "true" } }),
              _vm._v(" "),
              _c("span", { attrs: { "aria-hidden": "true" } }),
              _vm._v(" "),
              _c("span", { attrs: { "aria-hidden": "true" } })
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "navbar-menu",
          class: { "is-active": _vm.showNav },
          attrs: { id: "navMenu" }
        },
        [
          _c("div", { staticClass: "navbar-start" }, [
            _vm.permArray.add_leads == 1 ||
            _vm.permArray.switch_leads == 1 ||
            _vm.permArray.edit_leads == 1 ||
            _vm.permArray.show_all_leads == 1 ||
            _vm.permArray.send_cil == 1 ||
            _vm.permArray.calls == 1 ||
            _vm.permArray.meetings == 1 ||
            _vm.permArray.requests == 1 ||
            _vm.userType == "admin"
              ? _c(
                  "div",
                  { staticClass: "navbar-item has-dropdown is-hoverable" },
                  [
                    _c(
                      "a",
                      { staticClass: "navbar-link", attrs: { href: "#" } },
                      [
                        _vm._v(
                          "\n                            Lead\n                        "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "navbar-dropdown is-boxed" }, [
                      _vm.permArray.add_leads == 1 ||
                      _vm.permArray.switch_leads == 1 ||
                      _vm.permArray.edit_leads == 1 ||
                      _vm.permArray.show_all_leads == 1 ||
                      _vm.permArray.send_cil == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "leads" }
                            },
                            [_vm._v("All Leads")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.calls == 1 || _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "calls" }
                            },
                            [_vm._v("Calls")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.meetings == 1 || _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "meetings" }
                            },
                            [_vm._v("Meetings")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.requests == 1 || _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "requests" }
                            },
                            [_vm._v("Requests")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "a",
                        {
                          staticClass: "navbar-item",
                          attrs: { href: "events_request" }
                        },
                        [_vm._v("Events")]
                      ),
                      _vm._v(" "),
                      _c(
                        "a",
                        {
                          staticClass: "navbar-item",
                          attrs: { href: "requests_broadcast" }
                        },
                        [_vm._v("Requests Broadcast")]
                      )
                    ])
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.add_developers == 1 ||
            _vm.permArray.edit_developers == 1 ||
            _vm.permArray.delete_developers == 1 ||
            _vm.permArray.show_developers == 1 ||
            _vm.permArray.add_projects == 1 ||
            _vm.permArray.edit_projects == 1 ||
            _vm.permArray.delete_projects == 1 ||
            _vm.permArray.show_projects == 1 ||
            _vm.permArray.add_phases == 1 ||
            _vm.permArray.edit_phases == 1 ||
            _vm.permArray.delete_phases == 1 ||
            _vm.permArray.show_phases == 1 ||
            _vm.permArray.add_properties == 1 ||
            _vm.permArray.edit_properties == 1 ||
            _vm.permArray.delete_properties == 1 ||
            _vm.permArray.show_properties == 1 ||
            _vm.permArray.add_resale_units == 1 ||
            _vm.permArray.edit_resale_units == 1 ||
            _vm.permArray.delete_resale_units == 1 ||
            _vm.permArray.show_resale_units == 1 ||
            _vm.permArray.add_rental_units == 1 ||
            _vm.permArray.edit_rental_units == 1 ||
            _vm.permArray.delete_rental_units == 1 ||
            _vm.permArray.show_rental_units == 1 ||
            _vm.permArray.add_lands == 1 ||
            _vm.permArray.edit_lands == 1 ||
            _vm.permArray.delete_lands == 1 ||
            _vm.permArray.show_lands == 1 ||
            _vm.userType == "admin"
              ? _c(
                  "div",
                  { staticClass: "navbar-item has-dropdown is-hoverable" },
                  [
                    _c(
                      "a",
                      { staticClass: "navbar-link", attrs: { href: "#" } },
                      [
                        _vm._v(
                          "\n                            Inventory\n                        "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "navbar-dropdown is-boxed" }, [
                      _vm.permArray.add_developers == 1 ||
                      _vm.permArray.edit_developers == 1 ||
                      _vm.permArray.delete_developers == 1 ||
                      _vm.permArray.show_developers == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "developers" }
                            },
                            [_vm._v("Developers")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.add_lands == 1 ||
                      _vm.permArray.edit_lands == 1 ||
                      _vm.permArray.delete_lands == 1 ||
                      _vm.permArray.show_lands == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "lands" }
                            },
                            [_vm._v("Lands")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.add_projects == 1 ||
                      _vm.permArray.edit_projects == 1 ||
                      _vm.permArray.delete_projects == 1 ||
                      _vm.permArray.show_projects == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "projects" }
                            },
                            [_vm._v("Projects")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.add_resale_units == 1 ||
                      _vm.permArray.edit_resale_units == 1 ||
                      _vm.permArray.delete_resale_units == 1 ||
                      _vm.permArray.show_resale_units == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "resale_units" }
                            },
                            [_vm._v("Resale Units")]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.permArray.add_rental_units == 1 ||
                      _vm.permArray.edit_rental_units == 1 ||
                      _vm.permArray.delete_rental_units == 1 ||
                      _vm.permArray.show_rental_units == 1 ||
                      _vm.userType == "admin"
                        ? _c(
                            "a",
                            {
                              staticClass: "navbar-item",
                              attrs: { href: "rental_units" }
                            },
                            [_vm._v("Rental Units")]
                          )
                        : _vm._e()
                    ])
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.marketing == 1 || _vm.userType == "admin"
              ? _c(
                  "div",
                  { staticClass: "navbar-item has-dropdown is-hoverable" },
                  [
                    _c(
                      "a",
                      { staticClass: "navbar-link", attrs: { href: "#" } },
                      [
                        _vm._v(
                          "\n                            Marketing\n                        "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _vm._m(1)
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.marketing == 1 || _vm.userType == "admin"
              ? _c(
                  "a",
                  { staticClass: "navbar-item", attrs: { href: "proposals" } },
                  [_vm._v("Proposals")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.deals == 1 || _vm.userType == "admin"
              ? _c(
                  "a",
                  { staticClass: "navbar-item", attrs: { href: "deals" } },
                  [_vm._v("Closed Deals")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.finance == 1 || _vm.userType == "admin"
              ? _c(
                  "a",
                  { staticClass: "navbar-item", attrs: { href: "finances" } },
                  [_vm._v("Finances")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.userHr == 1 || _vm.userType == "admin"
              ? _c(
                  "div",
                  { staticClass: "navbar-item has-dropdown is-hoverable" },
                  [
                    _c(
                      "a",
                      {
                        staticClass: "navbar-link",
                        attrs: { href: "emp-dashboard" }
                      },
                      [
                        _vm._v(
                          "\n                            HR\n                        "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _vm._m(2)
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.permArray.reports == 1 || _vm.userType == "admin"
              ? _c(
                  "a",
                  { staticClass: "navbar-item", attrs: { href: "reports" } },
                  [_vm._v("Reports")]
                )
              : _vm._e()
          ])
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "navbar-end", attrs: { id: "navMenu" } }, [
        _c(
          "a",
          { staticClass: "navbar-item", attrs: { href: "/admin/cils" } },
          [
            _c("i", { staticClass: "fa fa-envelope" }),
            _vm._v(" "),
            _c(
              "span",
              { staticClass: "label label-danger", attrs: { id: "num" } },
              [
                _vm._v(
                  "\n                        " +
                    _vm._s(_vm.numOfCil) +
                    "\n                    "
                )
              ]
            )
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "navbar-item has-dropdown is-hoverable" }, [
          _c("a", { staticClass: "navbar-link" }, [
            _c("i", { staticClass: "fa fa-bell" }),
            _vm._v(" "),
            _c(
              "span",
              { staticClass: "label label-danger", attrs: { id: "num" } },
              [
                _vm._v(
                  "\n                            " +
                    _vm._s(_vm.numOfNotifications) +
                    "\n                        "
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "navbar-dropdown notifications",
              staticStyle: { height: "347px", overflow: "scroll" }
            },
            _vm._l(_vm.notifications, function(notification) {
              return _c("div", [
                notification.type == "lead"
                  ? _c(
                      "a",
                      {
                        staticClass: "navbar-item notification",
                        attrs: {
                          url: "/admin/leads/" + notification.id,
                          href: "/admin/leads/" + notification.id
                        }
                      },
                      [
                        _c("img", {
                          attrs: { src: "/images/" + notification.icon }
                        }),
                        _vm._v(
                          "\n                                " +
                            _vm._s(notification.title)
                        ),
                        _c("br"),
                        _vm._v(" "),
                        _c("span", { staticClass: "date" }, [
                          _vm._v(_vm._s(notification.diff))
                        ])
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("hr", { staticClass: "navbar-divider" })
              ])
            })
          )
        ]),
        _vm._v(" "),
        _vm.locale == "ar"
          ? _c(
              "a",
              {
                staticClass: "navbar-item",
                attrs: { href: "/admin/language/en" }
              },
              [
                _c("i", { staticClass: "fa fa-globe" }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "label label-danger",
                    staticStyle: { "font-size": "0.5em" },
                    attrs: { id: "num" }
                  },
                  [_vm._v("en")]
                )
              ]
            )
          : _c(
              "a",
              {
                staticClass: "navbar-item",
                attrs: { href: "/admin/language/ar" }
              },
              [
                _c("i", { staticClass: "fa fa-globe" }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "label label-danger",
                    staticStyle: { "font-size": "0.5em" },
                    attrs: { id: "num" }
                  },
                  [_vm._v("ar")]
                )
              ]
            ),
        _vm._v(" "),
        _c("div", { staticClass: "navbar-item has-dropdown is-hoverable" }, [
          _c("a", { staticClass: "navbar-link" }, [
            _c("span", [_vm._v(" " + _vm._s(_vm.name) + " ")])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "navbar-dropdown" }, [
            _c(
              "a",
              { staticClass: "navbar-item", attrs: { href: "/admin/logout" } },
              [
                _vm._v(
                  "\n                        Logout\n                      "
                )
              ]
            ),
            _vm._v(" "),
            _c("hr", { staticClass: "navbar-divider" }),
            _vm._v(" "),
            _c(
              "a",
              { staticClass: "navbar-item", attrs: { href: _vm.profileUrl } },
              [
                _vm._v(
                  "\n                        Profile\n                      "
                )
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _vm._m(3)
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "navbar-item" }, [
      _c("a", { attrs: { href: "/admin" } }, [
        _c("img", {
          attrs: {
            src: "/uploads/logo.png",
            alt: "",
            width: "50",
            height: "50"
          }
        })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "navbar-dropdown is-boxed" }, [
      _c("a", { staticClass: "navbar-item", attrs: { href: "campaigns" } }, [
        _vm._v("Campaigns")
      ]),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "developers_facebook" } },
        [_vm._v("Developers")]
      ),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "projects_facebook" } },
        [_vm._v("Projects")]
      ),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "competitors_facebook" } },
        [_vm._v("Competitors")]
      ),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "forms" } }, [
        _vm._v("Forms")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "navbar-dropdown is-boxed" }, [
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "job_categories" } },
        [_vm._v("Job Categories")]
      ),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "job_titles" } }, [
        _vm._v("Job Titles")
      ]),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "vacancies" } }, [
        _vm._v("Vacancies")
      ]),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "applications" } }, [
        _vm._v("Applications")
      ]),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "employees" } }, [
        _vm._v("Employees")
      ]),
      _vm._v(" "),
      _c("a", { staticClass: "navbar-item", attrs: { href: "salaries" } }, [
        _vm._v("Salaries")
      ]),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "salaries-details" } },
        [_vm._v("Salaries Details")]
      ),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "navbar-item", attrs: { href: "rules-procedure" } },
        [_vm._v("Rules Of Procedure")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      { staticClass: "navbar-item", attrs: { href: "settings_menu" } },
      [_c("i", { staticClass: "fa fa-gears" })]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6333ff8b", module.exports)
  }
}

/***/ }),
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */,
/* 66 */,
/* 67 */,
/* 68 */,
/* 69 */,
/* 70 */,
/* 71 */,
/* 72 */,
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */,
/* 77 */,
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */,
/* 82 */,
/* 83 */,
/* 84 */,
/* 85 */,
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */,
/* 90 */,
/* 91 */,
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */,
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */,
/* 101 */,
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(111);


/***/ }),
/* 111 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_Layout_Header_vue__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_Layout_Header_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_Layout_Header_vue__);


new Vue({
    el: '#app3',
    template: '<Header/>',
    components: { Header: __WEBPACK_IMPORTED_MODULE_0__components_Layout_Header_vue___default.a }
});

/***/ })
/******/ ]);