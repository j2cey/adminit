(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

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
var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  iconColor: 'white',
  customClass: {
    popup: 'colored-toast'
  },
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: false
});

var Status = /*#__PURE__*/_createClass(function Status(status) {
  _classCallCheck(this, Status);

  this.code = status.code || '';
  this.model_type = status.model_type || '';
  this.model_id = status.model_id || '';
});

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "status-inline-display",
  props: {
    model_type_prop: "",
    model_id_prop: "",
    status_prop: {}
  },
  data: function data() {
    return {
      status: this.status_prop,
      statuscode: this.status_prop.code,
      statusForm: new Form(new Status({
        'code': this.status_prop.code,
        'model_type': this.model_type_prop,
        'model_id': this.model_id_prop
      })),
      editing: false,
      loading: false
    };
  },
  methods: {
    switchStatus: function switchStatus(code) {
      if (code === 'active') {
        this.saveStatus('inactive');
      } else {
        this.saveStatus('active');
      }
    },
    saveStatus: function saveStatus(code) {
      var _this = this;

      this.statusForm.code = code;
      this.loading = true;
      console.log("save status: ", code);
      this.statusForm.post('/statuses.modelupdate').then(function (status) {
        _this.loading = false;
        Toast.fire({
          icon: 'success',
          title: 'Status changed successfully'
        }).then(function () {
          _this.status = status;
        });
      })["catch"](function (error) {
        _this.loading = false;
      })["finally"](this.statusForm = new Form(new Status({
        'code': this.status.code,
        'model_type': this.model_type_prop,
        'model_id': this.model_id_prop
      })));
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".colored-toast.swal2-icon-success[data-v-53a1ef2e] {\n  background-color: #a5dc86 !important;\n}\n.colored-toast.swal2-icon-error[data-v-53a1ef2e] {\n  background-color: #f27474 !important;\n}\n.colored-toast.swal2-icon-warning[data-v-53a1ef2e] {\n  background-color: #f8bb86 !important;\n}\n.colored-toast.swal2-icon-info[data-v-53a1ef2e] {\n  background-color: #3fc3ee !important;\n}\n.colored-toast.swal2-icon-question[data-v-53a1ef2e] {\n  background-color: #87adbd !important;\n}\n.colored-toast .swal2-title[data-v-53a1ef2e] {\n  color: white;\n}\n.colored-toast .swal2-close[data-v-53a1ef2e] {\n  color: white;\n}\n.colored-toast .swal2-html-container[data-v-53a1ef2e] {\n  color: white;\n}\n\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("b-field", { attrs: { grouped: "", "group-multiline": "" } }, [
    _c(
      "div",
      { staticClass: "control" },
      [
        _c(
          "b-taglist",
          { attrs: { attached: "" } },
          [
            _c(
              "b-tag",
              {
                attrs: {
                  rounded: "",
                  type: "is-" + _vm.status.style + " is-light",
                },
                model: {
                  value: _vm.statuscode,
                  callback: function ($$v) {
                    _vm.statuscode = $$v
                  },
                  expression: "statuscode",
                },
              },
              [_vm._v(_vm._s(_vm.status.name))]
            ),
            _vm._v(" "),
            _c(
              "b-tag",
              {
                attrs: { rounded: "", type: "is-ghost btn" },
                on: {
                  click: function ($event) {
                    return _vm.switchStatus(_vm.status.code)
                  },
                },
              },
              [_c("i", { staticClass: "fa fa-refresh" })]
            ),
          ],
          1
        ),
      ],
      1
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/statuses/inline-display.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/statuses/inline-display.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true& */ "./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true&");
/* harmony import */ var _inline_display_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./inline-display.vue?vue&type=script&lang=js& */ "./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& */ "./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _inline_display_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "53a1ef2e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/statuses/inline-display.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./inline-display.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=style&index=0&id=53a1ef2e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_style_index_0_id_53a1ef2e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/inline-display.vue?vue&type=template&id=53a1ef2e&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_inline_display_vue_vue_type_template_id_53a1ef2e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);