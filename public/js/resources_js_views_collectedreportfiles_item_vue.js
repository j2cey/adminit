"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_collectedreportfiles_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    collectedreportfile_prop: {}
  },
  name: "item",
  components: {},
  data: function data() {
    return {
      collectedreportfile: this.collectedreportfile_prop
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
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
  }, [_vm._v("Nom Initiale")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.initial_file_name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nom Local")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.local_file_name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Fichier de Rapport")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.reportfile.name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Taille")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.file_size))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nombre de Lignes")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.nb_rows))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nombre de Lignes importées")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_c("span", {
    staticClass: "badge badge-pill badge-success"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.nb_rows_import_success))])]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Nombre de Lignes échèc importation")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_c("span", {
    staticClass: "badge badge-pill badge-danger"
  }, [_vm._v(_vm._s(_vm.collectedreportfile.nb_rows_import_failed))])]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Created at")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm._f("formatDate")(_vm.collectedreportfile.created_at)))])])])])]), _vm._v(" "), _c("b-tab-item", {
    scopedSlots: _vm._u([{
      key: "header",
      fn: function fn() {
        return [_c("b-icon", {
          attrs: {
            size: "small",
            icon: "database"
          }
        }), _vm._v(" "), _c("span", {
          staticClass: "help-inline pr-1 text-sm"
        }, [_vm._v(" Résultat Importation ")]), _vm._v(" "), _c("b-tag", {
          attrs: {
            rounded: "",
            type: "is-info is-light"
          }
        }, [_vm._v(_vm._s(_vm.collectedreportfile.nb_rows_import_success))])];
      },
      proxy: true
    }])
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/collectedreportfiles/item.vue":
/*!**********************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/item.vue ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=5395fd39&scoped=true& */ "./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "5395fd39",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/collectedreportfiles/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true& ***!
  \*****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_5395fd39_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=5395fd39&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/item.vue?vue&type=template&id=5395fd39&scoped=true&");


/***/ })

}]);