"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_formatrules_innerformatrules_formattextsize_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../formatrules/formatruleBus */ "./resources/js/views/formatrules/formatruleBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "formattextsize",
  props: {
    formatrule_prop: {},
    innerformatrule_prop: {},
    model_type_prop: null
  },
  mounted: function mounted() {
    var _this = this;
    _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_edit', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.editing = true;
      }
    });
    _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_edit_cancel', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.editing = false;
        _this.loading = false;
      }
    });
    _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_updating', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.loading = true;
      }
    });
  },
  data: function data() {
    return {
      formatrule: this.formatrule_prop,
      formattextsize: this.innerformatrule_prop,
      model_type: this.model_type_prop,
      editing: false,
      loading: false
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("b-field", [_c("b-input", {
    attrs: {
      size: "is-small",
      type: "number",
      min: _vm.formattextsize.min_value,
      max: _vm.formattextsize.max_value,
      placeholder: "size",
      loading: _vm.loading,
      readonly: !_vm.editing
    },
    model: {
      value: _vm.formattextsize.format_value,
      callback: function callback($$v) {
        _vm.$set(_vm.formattextsize, "format_value", $$v);
      },
      expression: "formattextsize.format_value"
    }
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextsize.vue ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formattextsize.vue?vue&type=template&id=618974ac&scoped=true& */ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true&");
/* harmony import */ var _formattextsize_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./formattextsize.vue?vue&type=script&lang=js& */ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _formattextsize_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "618974ac",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/formatrules/innerformatrules/formattextsize.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextsize_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formattextsize.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextsize_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true& ***!
  \***********************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextsize_vue_vue_type_template_id_618974ac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formattextsize.vue?vue&type=template&id=618974ac&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextsize.vue?vue&type=template&id=618974ac&scoped=true&");


/***/ })

}]);