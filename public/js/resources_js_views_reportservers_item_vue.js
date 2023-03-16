"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reportservers_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    reportserver_prop: {}
  },
  name: "report-server-item",
  components: {
    ReportFileAccessList: function ReportFileAccessList() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_reportfileaccesses_list_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../reportfileaccesses/list */ "./resources/js/views/reportfileaccesses/list.vue"));
    }
  },
  data: function data() {
    return {
      reportserver: this.reportserver_prop
    };
  },
  methods: {
    createReportFileAccess: function createReportFileAccess(val) {
      console.log("TODO: createReportFileAccess", val);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("b-tabs", {
    attrs: {
      size: "is-small",
      type: "is-boxed"
    }
  }, [_c("b-tab-item", {
    scopedSlots: _vm._u([{
      key: "header",
      fn: function fn() {
        return [_c("b-icon", {
          attrs: {
            icon: "information-outline"
          }
        }), _vm._v(" "), _c("span", [_vm._v(" Infos ")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("div", {
    staticClass: "card card-default"
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("dl", [_c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nom")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportserver.name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Adresse IP")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportserver.ip_address))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nom du domaine")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportserver.domain_name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Statut")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportserver.status.name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Système d'exploitation")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportserver.osserver ? _vm.reportserver.osserver.name : ""))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Created at")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm._f("formatDate")(_vm.reportserver.created_at)))])])])])]), _vm._v(" "), _c("b-tab-item", {
    scopedSlots: _vm._u([{
      key: "header",
      fn: function fn() {
        return [_c("b-icon", {
          attrs: {
            icon: "source-pull"
          }
        }), _vm._v(" "), _c("span", {
          staticClass: "help-inline pr-1 text-sm"
        }, [_vm._v("Server")]), _vm._v(" "), _c("b-button", {
          attrs: {
            size: "is-small",
            type: "is-ghost"
          },
          on: {
            click: function click($event) {
              return _vm.createReportFileAccess(_vm.reportserver);
            }
          }
        }, [_c("i", {
          staticClass: "fas fa-plus"
        })])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("ReportFileAccessList")], 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reportservers/item.vue":
/*!***************************************************!*\
  !*** ./resources/js/views/reportservers/item.vue ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=3727eba5&scoped=true& */ "./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/reportservers/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3727eba5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reportservers/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reportservers/item.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/reportservers/item.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true& ***!
  \**********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3727eba5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=3727eba5&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportservers/item.vue?vue&type=template&id=3727eba5&scoped=true&");


/***/ })

}]);