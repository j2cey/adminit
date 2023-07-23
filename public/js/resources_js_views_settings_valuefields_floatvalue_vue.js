"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_settings_valuefields_floatvalue_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _settingBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../settingBus */ "./resources/js/views/settings/settingBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "floatvalue",
  props: {
    setting_prop: {}
  },
  mounted: function mounted() {
    var _this = this;
    _settingBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('setting_edit', function (setting) {
      if (_this.setting.id === setting.id) {
        _this.editing = true;
      }
    });
    _settingBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('setting_edit_cancel', function (setting) {
      if (_this.setting.id === setting.id) {
        _this.editing = false;
        _this.loading = false;
      }
    });
    _settingBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('setting_updating', function (setting) {
      if (_this.setting.id === setting.id) {
        _this.loading = true;
      }
    });
  },
  created: function created() {},
  data: function data() {
    return {
      setting: this.setting_prop,
      editing: false,
      loading: false
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("b-field", {
    attrs: {
      size: "is-small"
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      type: "number",
      placeholder: "Float Value",
      loading: _vm.loading
    },
    model: {
      value: _vm.setting.value,
      callback: function callback($$v) {
        _vm.$set(_vm.setting, "value", $$v);
      },
      expression: "setting.value"
    }
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/settings/valuefields/floatvalue.vue":
/*!****************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/floatvalue.vue ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true& */ "./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true&");
/* harmony import */ var _floatvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./floatvalue.vue?vue&type=script&lang=js& */ "./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _floatvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3ea9aa17",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/settings/valuefields/floatvalue.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_floatvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./floatvalue.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_floatvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true& ***!
  \***********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_floatvalue_vue_vue_type_template_id_3ea9aa17_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/floatvalue.vue?vue&type=template&id=3ea9aa17&scoped=true&");


/***/ })

}]);