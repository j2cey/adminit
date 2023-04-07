"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_formatrules_innerformatrules_formattextweight_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formatruleBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../formatruleBus */ "./resources/js/views/formatrules/formatruleBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "formattextweight",
  props: {
    formatrule_prop: {},
    innerformatrule_prop: {},
    model_type_prop: null
  },
  mounted: function mounted() {
    var _this = this;
    _formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_edit', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.editing = true;
      }
    });
    _formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_edit_cancel', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.editing = false;
        _this.loading = false;
      }
    });
    _formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('formatrule_updating', function (formatrule) {
      if (_this.formatrule.id === formatrule.id) {
        _this.loading = true;
      }
    });
  },
  created: function created() {},
  data: function data() {
    return {
      formatrule: this.formatrule_prop,
      formattextweight: this.innerformatrule_prop,
      model_type: this.model_type_prop,
      checkboxGroup: JSON.parse(this.innerformatrule_prop.format_value),
      editing: false,
      loading: false
    };
  },
  methods: {
    setElemToCheckboxGroup: function setElemToCheckboxGroup(elem) {
      if (elem === 'bold') {
        this.formattextweight.format_bold = !this.formattextweight.format_bold;
      }
      if (elem === 'italic') {
        this.formattextweight.format_italic = !this.formattextweight.format_italic;
      }
      if (elem === 'underline') {
        this.formattextweight.underline = !this.formattextweight.underline;
      }
      this.formattextweight.format_value = JSON.stringify(this.checkboxGroup);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
  }, [_c("b-checkbox-button", {
    attrs: {
      size: "is-small",
      type: "is-dark is-light",
      "native-value": "bold",
      loading: _vm.loading,
      readonly: !_vm.editing,
      disabled: !_vm.editing
    },
    on: {
      input: function input($event) {
        return _vm.setElemToCheckboxGroup("bold");
      }
    },
    model: {
      value: _vm.checkboxGroup,
      callback: function callback($$v) {
        _vm.checkboxGroup = $$v;
      },
      expression: "checkboxGroup"
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "format-bold"
    }
  })], 1), _vm._v(" "), _c("b-checkbox-button", {
    attrs: {
      size: "is-small",
      type: "is-info is-light",
      "native-value": "italic",
      loading: _vm.loading,
      readonly: !_vm.editing,
      disabled: !_vm.editing
    },
    on: {
      input: function input($event) {
        return _vm.setElemToCheckboxGroup("italic");
      }
    },
    model: {
      value: _vm.checkboxGroup,
      callback: function callback($$v) {
        _vm.checkboxGroup = $$v;
      },
      expression: "checkboxGroup"
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "format-italic"
    }
  })], 1), _vm._v(" "), _c("b-checkbox-button", {
    attrs: {
      size: "is-small",
      type: "is-primary is-light",
      "native-value": "underline",
      loading: _vm.loading,
      readonly: !_vm.editing,
      disabled: !_vm.editing
    },
    on: {
      input: function input($event) {
        return _vm.setElemToCheckboxGroup("underline");
      }
    },
    model: {
      value: _vm.checkboxGroup,
      callback: function callback($$v) {
        _vm.checkboxGroup = $$v;
      },
      expression: "checkboxGroup"
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "format-underline"
    }
  })], 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextweight.vue ***!
  \******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true& */ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true&");
/* harmony import */ var _formattextweight_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./formattextweight.vue?vue&type=script&lang=js& */ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _formattextweight_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "e8af2a3a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/formatrules/innerformatrules/formattextweight.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextweight_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formattextweight.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextweight_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true& ***!
  \*************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formattextweight_vue_vue_type_template_id_e8af2a3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/innerformatrules/formattextweight.vue?vue&type=template&id=e8af2a3a&scoped=true&");


/***/ })

}]);