"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_settings_valuefields_arrayvalue_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _settingBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../settingBus */ "./resources/js/views/settings/settingBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "arrayvalue",
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
      array_value: this.setting_prop.value.split(this.setting_prop.array_sep),
      editing: false,
      loading: false
    };
  },
  methods: {
    // eslint-disable-next-line no-unused-vars
    addElem: function addElem($event) {
      this.updateValueFromArray();
      console.log("addElem: ", this.setting.value);
    },
    // eslint-disable-next-line no-unused-vars
    removeElem: function removeElem($event) {
      this.updateValueFromArray();
      console.log("removeElem: ", this.setting.value);
    },
    updateValueFromArray: function updateValueFromArray() {
      this.setting.value = this.array_value.join(this.setting.array_sep);
    }
  },
  computed: {
    arrayValue: function arrayValue() {
      return this.setting.value.split(this.setting.array_sep);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true& ***!
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
  return _c("b-field", [_c("b-taginput", {
    attrs: {
      size: "is-small",
      attached: "",
      placeholder: "Add a value",
      loading: _vm.loading
    },
    on: {
      add: _vm.addElem,
      remove: _vm.removeElem
    },
    model: {
      value: _vm.array_value,
      callback: function callback($$v) {
        _vm.array_value = $$v;
      },
      expression: "array_value"
    }
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/settings/valuefields/arrayvalue.vue":
/*!****************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/arrayvalue.vue ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true& */ "./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true&");
/* harmony import */ var _arrayvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./arrayvalue.vue?vue&type=script&lang=js& */ "./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _arrayvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "48eb06ba",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/settings/valuefields/arrayvalue.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_arrayvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./arrayvalue.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_arrayvalue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true& ***!
  \***********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_arrayvalue_vue_vue_type_template_id_48eb06ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/valuefields/arrayvalue.vue?vue&type=template&id=48eb06ba&scoped=true&");


/***/ })

}]);