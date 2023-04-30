"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_operationresults_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _operationresults_operationresultBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../operationresults/operationresultBus */ "./resources/js/views/operationresults/operationresultBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "operationresult-list",
  props: {
    operationresults_prop: {}
  },
  components: {
    OperationResultItem: function OperationResultItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_operationresults_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../operationresults/item */ "./resources/js/views/operationresults/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _operationresults_operationresultBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('operationresult_created', function (operationresult) {
      _this.addOperationResultToList(operationresult);
    });
    _operationresults_operationresultBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('operationresult_updated', function (operationresult) {
      _this.updateOperationResultFromList(operationresult);
    });
  },
  data: function data() {
    return {
      operationresults: this.operationresults_prop,
      isPaginated: true,
      isPaginationSimple: false,
      isPaginationRounded: true,
      paginationPosition: 'bottom',
      defaultSortDirection: 'asc',
      sortIcon: 'arrow-up',
      sortIconSize: 'is-small',
      currentPage: 1,
      perPage: 10,
      defaultOpenedDetails: [-1],
      showDetailIcon: true,
      useTransition: false,
      stickyHeaders: false,
      columns: [{
        field: 'id',
        key: 'id',
        label: 'ID',
        numeric: true,
        searchable: false,
        sortable: true
      }, {
        field: 'name',
        key: 'name',
        label: 'Name',
        searchable: true,
        sortable: true
      }, {
        field: 'start_at',
        key: 'start_at',
        label: 'Start at',
        searchable: false,
        sortable: true,
        date: true
      }, {
        field: 'end_at',
        key: 'end_at',
        label: 'End at',
        searchable: false,
        sortable: true,
        date: true
      }, {
        field: 'result',
        key: 'result',
        label: 'Result',
        searchable: true,
        sortable: true
      }, {
        field: 'state',
        key: 'state',
        label: 'State',
        searchable: true,
        sortable: true
      }, {
        field: 'actions',
        key: 'actions',
        label: '',
        width: '100',
        centered: true,
        sortable: false
      }]
    };
  },
  methods: {
    showOperationResult: function showOperationResult(operationresult) {
      window.location = operationresult.show_url;
    },
    createOperationResult: function createOperationResult() {
      _operationresults_operationresultBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('create_new_operationresult');
    },
    editOperationResult: function editOperationResult(operationresult) {
      _operationresults_operationresultBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('edit_operationresult', {
        operationresult: operationresult
      });
    },
    deleteOperationResult: function deleteOperationResult(operationresult) {
      var _this2 = this;
      this.$swal({
        title: 'Êtes vous sûr ?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez le!'
      }).then(function (result) {
        if (result.value) {
          // eslint-disable-next-line no-undef
          axios["delete"]("/operationresults/".concat(operationresult.uuid))
          // eslint-disable-next-line no-unused-vars
          .then(function (resp) {
            _this2.removeOperationResultFromList(operationresult);
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        }
      });
    },
    addOperationResultToList: function addOperationResultToList(operationresult) {
      var operationresultIndex = this.operationresults.findIndex(function (c) {
        return operationresult.id === c.id;
      });
      console.log("addOperationResultToList: ", operationresult, operationresultIndex);

      // if this Account doesn't belong to the list
      if (operationresultIndex === -1) {
        //J'ajoute dans la liste
        this.operationresults.push(operationresult);
        this.$emit('operationresult_added', operationresult);
        console.log("operationresult_added");
      }
    },
    updateOperationResultFromList: function updateOperationResultFromList(operationresult) {
      var stepIndex = this.operationresults.findIndex(function (s) {
        return operationresult.id === s.id;
      });

      // if this Account belongs to the list
      if (stepIndex > -1) {
        this.operationresults.splice(stepIndex, 1, operationresult);
      }
    },
    removeOperationResultFromList: function removeOperationResultFromList(operationresult) {
      var operationresultIndex = this.operationresults.findIndex(function (s) {
        return operationresult.id === s.id;
      });

      // if this attribute belongs to the list
      if (operationresultIndex > -1) {
        this.operationresults.splice(operationresultIndex, 1);
        this.$swal({
          html: '<small>Compte supprimé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {});
      }
    }
  },
  computed: {
    // eslint-disable-next-line vue/return-in-computed-property
    transitionName: function transitionName() {
      if (this.useTransition) {
        return 'fade';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("section", [_c("b-table", {
    ref: "table",
    attrs: {
      data: _vm.operationresults,
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
        return [_c("OperationResultItem", {
          attrs: {
            operationresult_prop: props.row
          }
        })];
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
          }, [_vm._v("\n                        " + _vm._s(props.row[column.field]) + "\n                    ")]) : column.field === "name" ? _c("span", {
            staticClass: "has-text-primary is-italic text-xs"
          }, [_c("a", {
            on: {
              click: function click($event) {
                return _vm.showOperationResult(props.row);
              }
            }
          }, [_vm._v("\n                            " + _vm._s(props.row[column.field]) + "\n                        ")])]) : column.field === "result" ? _c("span", {
            staticClass: "has-text-info is-italic text-xs"
          }, [props.row[column.field] ? _c("span", [props.row[column.field] === "success" ? _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-success"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))]) : props.row[column.field] === "failed" ? _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-danger"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))]) : _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-default"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))])], 1) : _c("span")]) : column.field === "state" ? _c("span", {
            staticClass: "has-text-info is-italic text-xs"
          }, [props.row[column.field] ? _c("span", [props.row[column.field] === "completed" ? _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-success"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))]) : props.row[column.field] === "running" ? _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-danger"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))]) : props.row[column.field] === "queued" ? _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-warning"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))]) : _c("b-tag", {
            attrs: {
              rounded: "",
              type: "is-default"
            }
          }, [_vm._v(_vm._s(props.row[column.field]))])], 1) : _c("span")]) : column.date ? _c("span", {
            staticClass: "tag is-info is-light"
          }, [_vm._v("\n                        " + _vm._s(_vm._f("formatDate")(props.row[column.field])) + "\n                    ")]) : column.field === "actions" ? _c("span", {
            staticClass: "text-xs"
          }, [_c("div", {
            staticClass: "block"
          }, [_c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-warning",
            on: {
              click: function click($event) {
                return _vm.editOperationResult(props.row);
              }
            }
          }, [_c("b-icon", {
            attrs: {
              pack: "fas",
              icon: "pencil-square-o",
              size: "is-small"
            }
          })], 1), _vm._v(" "), _c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-danger",
            on: {
              click: function click($event) {
                return _vm.deleteOperationResult(props.row);
              }
            }
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

/***/ "./resources/js/views/operationresults/operationresultBus.js":
/*!*******************************************************************!*\
  !*** ./resources/js/views/operationresults/operationresultBus.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/operationresults/list.vue":
/*!******************************************************!*\
  !*** ./resources/js/views/operationresults/list.vue ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=7a8ef0e2&scoped=true& */ "./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/operationresults/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "7a8ef0e2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/operationresults/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/operationresults/list.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/operationresults/list.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true& ***!
  \*************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_7a8ef0e2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=7a8ef0e2&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/operationresults/list.vue?vue&type=template&id=7a8ef0e2&scoped=true&");


/***/ })

}]);