"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_collectedreportfiles_importedlines_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "collectedreportfile-importedlines",
  props: {
    importedlines_prop: {},
    columns_prop: {}
  },
  components: {},
  mounted: function mounted() {},
  data: function data() {
    return {
      importedlines: JSON.parse(this.importedlines_prop),
      isPaginated: true,
      isPaginationSimple: false,
      isPaginationRounded: true,
      paginationPosition: 'bottom',
      defaultSortDirection: 'asc',
      sortIcon: 'arrow-up',
      sortIconSize: 'is-small',
      currentPage: 1,
      perPage: 5,
      defaultOpenedDetails: [-1],
      showDetailIcon: true,
      useTransition: false,
      stickyHeaders: false,
      columns: JSON.parse(this.columns_prop)
    };
  },
  methods: {},
  computed: {
    transitionName: function transitionName() {
      if (this.useTransition) {
        return 'fade';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("section", [_c("b-field", {
    attrs: {
      grouped: "",
      "group-multiline": ""
    }
  }, [_c("b-select", {
    attrs: {
      disabled: !_vm.isPaginated
    },
    model: {
      value: _vm.perPage,
      callback: function callback($$v) {
        _vm.perPage = $$v;
      },
      expression: "perPage"
    }
  }, [_c("option", {
    attrs: {
      value: "5"
    }
  }, [_vm._v("5 per page")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "10"
    }
  }, [_vm._v("10 per page")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "15"
    }
  }, [_vm._v("15 per page")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "20"
    }
  }, [_vm._v("20 per page")])])], 1), _vm._v(" "), _c("b-table", {
    ref: "table",
    attrs: {
      data: _vm.importedlines,
      "debounce-search": 1000,
      paginated: _vm.isPaginated,
      "per-page": _vm.perPage,
      "opened-detailed": _vm.defaultOpenedDetails,
      detailed: "",
      "detail-key": "id",
      "detail-transition": _vm.transitionName,
      "show-detail-icon": _vm.showDetailIcon,
      "current-page": _vm.currentPage,
      "pagination-simple": _vm.isPaginationSimple,
      "pagination-position": _vm.paginationPosition,
      "default-sort-direction": _vm.defaultSortDirection,
      "pagination-rounded": _vm.isPaginationRounded,
      "sort-icon": _vm.sortIcon,
      "sort-icon-size": _vm.sortIconSize,
      "sticky-header": _vm.stickyHeaders,
      "default-sort": "row.name",
      "aria-next-label": "Next",
      "aria-previous-label": "Previous",
      "aria-page-label": "Page",
      "aria-current-label": "Current page",
      "before-destroy": false
    },
    on: {
      "update:currentPage": function updateCurrentPage($event) {
        _vm.currentPage = $event;
      },
      "update:current-page": function updateCurrentPage($event) {
        _vm.currentPage = $event;
      }
    },
    scopedSlots: _vm._u([{
      key: "detail",
      fn: function fn(props) {
        return undefined;
      }
    }, {
      key: "empty",
      fn: function fn() {
        return [_c("div", {
          staticClass: "has-text-centered"
        }, [_vm._v("No Data Available")])];
      },
      proxy: true
    }])
  }, [_vm._l(_vm.columns, function (column) {
    return [_c("b-table-column", _vm._b({
      key: column.id,
      attrs: {
        sortable: column.sortable
      },
      scopedSlots: _vm._u([column.searchable && !column.numeric ? {
        key: "searchable",
        fn: function fn(props) {
          return [_c("b-input", {
            attrs: {
              placeholder: "Search...",
              icon: "magnify",
              size: "is-small",
              "icon-right": "close-circle",
              "icon-right-clickable": ""
            },
            on: {
              "icon-right-click": function iconRightClick($event) {
                props.filters[props.column.field] = "";
              }
            },
            model: {
              value: props.filters[props.column.field],
              callback: function callback($$v) {
                _vm.$set(props.filters, props.column.field, $$v);
              },
              expression: "props.filters[props.column.field]"
            }
          })];
        }
      } : null, {
        key: "default",
        fn: function fn(props) {
          return [column.field === "id" ? _c("span", {
            staticClass: "text-xs"
          }, [_vm._v("\n                        " + _vm._s(props.row[column.field]) + "\n                    ")]) : column.date ? _c("span", {
            staticClass: "tag is-success"
          }, [_vm._v("\n                        " + _vm._s(new Date(props.row[column.field]).toLocaleDateString()) + "\n                    ")]) : column.field === "actions" ? _c("span", {
            staticClass: "text-xs"
          }, [_c("div", {
            staticClass: "block"
          }, [_c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-warning"
          }, [_c("b-icon", {
            attrs: {
              pack: "fas",
              icon: "pencil-square-o",
              size: "is-small"
            }
          })], 1), _vm._v(" "), _c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-danger"
          }, [_c("b-icon", {
            attrs: {
              pack: "fas",
              icon: "trash",
              size: "is-small"
            }
          })], 1)])]) : _c("span", {
            staticClass: "text-xs"
          }, [_vm._v("\n                        " + _vm._s(props.row[column.field]) + "\n                    ")])];
        }
      }], null, true)
    }, "b-table-column", column, false))];
  })], 2)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/collectedreportfiles/importedlines.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/importedlines.vue ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true& */ "./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true&");
/* harmony import */ var _importedlines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./importedlines.vue?vue&type=script&lang=js& */ "./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _importedlines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "1dc1bb76",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/collectedreportfiles/importedlines.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_importedlines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./importedlines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_importedlines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true& ***!
  \**************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_importedlines_vue_vue_type_template_id_1dc1bb76_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/importedlines.vue?vue&type=template&id=1dc1bb76&scoped=true&");


/***/ })

}]);