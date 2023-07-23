"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_settings_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _settingBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./settingBus */ "./resources/js/views/settings/settingBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "setting-item",
  props: {
    setting_prop: {}
  },
  components: {
    stringdisplay: function stringdisplay() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_settings_valuedisplay_stringdisplay_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./valuedisplay/stringdisplay */ "./resources/js/views/settings/valuedisplay/stringdisplay.vue"));
    },
    integerdisplay: function integerdisplay() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_settings_valuedisplay_integerdisplay_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./valuedisplay/integerdisplay */ "./resources/js/views/settings/valuedisplay/integerdisplay.vue"));
    },
    booldisplay: function booldisplay() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_settings_valuedisplay_booldisplay_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./valuedisplay/booldisplay */ "./resources/js/views/settings/valuedisplay/booldisplay.vue"));
    },
    floatdisplay: function floatdisplay() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_settings_valuedisplay_floatdisplay_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./valuedisplay/floatdisplay */ "./resources/js/views/settings/valuedisplay/floatdisplay.vue"));
    },
    arraydisplay: function arraydisplay() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_settings_valuedisplay_arraydisplay_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./valuedisplay/arraydisplay */ "./resources/js/views/settings/valuedisplay/arraydisplay.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _settingBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('setting_updated', function (setting) {
      console.log("setting_updated received");
      if (_this.setting.id === setting.id) {
        _this.setting = setting;
        _this.forceRerenderValueDisplay();
        console.log("setting_updated updated: ", _this.setting, "fieldvalue_key: ", _this.fieldvalue_key);
      }
    });
  },
  data: function data() {
    return {
      setting: this.setting_prop,
      commom_key: 0,
      fieldvalue_key: this.generateRandomInteger(10000)
    };
  },
  methods: {
    generateRandomInteger: function generateRandomInteger(max) {
      return Math.floor(Math.random() * max) + 1;
    },
    forceRerenderValueDisplay: function forceRerenderValueDisplay() {
      this.commom_key = this.generateRandomInteger(10000);
      this.fieldvalue_key = this.setting.id + this.commom_key;
    },
    editSetting: function editSetting(setting) {
      this.$emit('setting_edit', setting);
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-sm d-inline-block text-truncate text-sm-left",
    staticStyle: {
      "max-width": "100%"
    }
  }, [_vm._v(_vm._s(_vm.setting.name))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs"
  }, [_vm.setting.type ? _c(_vm.setting.type + "display", {
    key: _vm.fieldvalue_key,
    ref: _vm.setting.full_path,
    tag: "component",
    attrs: {
      id: "value",
      setting_prop: _vm.setting
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-4 col-6 border-right"
  }, [_c("b-field", [_c("b-input", {
    staticStyle: {
      "min-height": "2px"
    },
    attrs: {
      type: "textarea",
      "group-multiline": "",
      "custom-class": "text text-xs border-0",
      readonly: "",
      value: _vm.setting.description
    }
  })], 1)], 1), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-xs text-center"
  }, [_c("a", {
    staticClass: "text text-success",
    on: {
      click: function click($event) {
        return _vm.editSetting(_vm.setting);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-pencil-square-o",
    attrs: {
      "aria-hidden": "true"
    }
  })])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/settings/item.vue":
/*!**********************************************!*\
  !*** ./resources/js/views/settings/item.vue ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=0b255390&scoped=true& */ "./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/settings/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0b255390",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/settings/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/settings/item.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/views/settings/item.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true& ***!
  \*****************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_0b255390_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=0b255390&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/item.vue?vue&type=template&id=0b255390&scoped=true&");


/***/ })

}]);