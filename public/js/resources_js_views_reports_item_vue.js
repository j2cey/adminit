"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reports_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate */ "./resources/js/views/reports/addupdate.vue");
/* harmony import */ var _reportfiles_list__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../reportfiles/list */ "./resources/js/views/reportfiles/list.vue");
/* harmony import */ var _reportBus__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./reportBus */ "./resources/js/views/reports/reportBus.js");



/* harmony default export */ __webpack_exports__["default"] = ({
  name: "report-item",
  props: {
    report_prop: {},
    index_prop: {}
  },
  components: {
    AddUpdateReport: _addupdate__WEBPACK_IMPORTED_MODULE_0__["default"],
    ReportFiles: _reportfiles_list__WEBPACK_IMPORTED_MODULE_1__["default"],
    FileHeader: function FileHeader() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_fileheaders_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../fileheaders/item */ "./resources/js/views/fileheaders/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _reportBus__WEBPACK_IMPORTED_MODULE_2__["default"].$on('report_updated', function (updreport) {
      if (_this.report.id === updreport.id) {
        _this.report = updreport;
        window.noty({
          message: 'Report successfully updated',
          type: 'success'
        });
      }
    });
  },
  created: function created() {},
  data: function data() {
    return {
      report: this.report_prop,
      index: this.index_prop,
      collapse_icon: 'fas fa-chevron-down',
      collapse_reportaccess_icon: 'fas fa-chevron-down'
    };
  },
  methods: {
    editReport: function editReport(report) {
      _reportBus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('edit_report', {
        report: report
      });
    },
    showFlowchart: function showFlowchart(report) {
      /*ReportBus.$emit('show_flowchart', report)*/
      window.location = '/reports.flowchart/' + report.uuid;
    },
    deleteReport: function deleteReport(id, key) {
      var _this2 = this;
      this.$swal({
        html: '<small>Do you really want to delete this Report ?</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("/reports/".concat(id)).then(function (resp) {
            console.log('report delete resp: ', resp);
            _this2.$swal({
              html: '<small>Report successfully deleted !</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _reportBus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('reportaction_deleted', {
                key: key,
                resp: resp
              });
            });
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        } else {
          // stay here
        }
      });
    },
    collapseClicked: function collapseClicked(collapsevar, collapseicon) {
      console.log("collapseClicked: ", collapsevar, collapseicon);
      if (collapseicon === 'fas fa-chevron-down') {
        this[collapsevar] = 'fas fa-chevron-up';
      } else {
        this[collapsevar] = 'fas fa-chevron-down';
      }
    }
  },
  computed: {
    currentCollapseIcon: function currentCollapseIcon() {
      return this.collapse_icon;
    },
    currentReportAccessCollapseIcon: function currentReportAccessCollapseIcon() {
      return this.collapse_reportaccess_icon;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
    staticClass: "card"
  }, [_c("header", [_c("div", {
    staticClass: "card-header-title row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-8 col-12"
  }, [_c("span", {
    staticClass: "text-olive text-sm"
  }, [_vm._v("\n                            " + _vm._s(_vm.report.title) + "\n                        ")])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-4 col-12 text-right"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_c("a", {
    staticClass: "btn btn-tool text-success",
    attrs: {
      type: "button",
      "data-toggle": "tooltip"
    },
    on: {
      click: function click($event) {
        return _vm.showFlowchart(_vm.report);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-eye"
  })]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-tool text-warning",
    attrs: {
      type: "button",
      "data-toggle": "tooltip"
    },
    on: {
      click: function click($event) {
        return _vm.editReport(_vm.report);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-pencil-square-o"
  })]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-tool text-danger",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.deleteReport(_vm.report.uuid, _vm.index);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-trash"
  })])])])])]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("b-tabs", {
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
            icon: "info-circle",
            pack: "fa"
          }
        }), _vm._v(" "), _c("span", [_vm._v(" Infos ")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("dl", [_c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Type")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.report.reporttype.name))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Description")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.report.description))]), _vm._v(" "), _c("dt", {
    staticClass: "text text-xs"
  }, [_vm._v("Création")]), _vm._v(" "), _c("dd", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm._f("formatDate")(_vm.report.created_at)))]), _vm._v(" "), _c("dd", {
    staticClass: "col-sm-8 offset-sm-4 text-xs"
  })])]), _vm._v(" "), _c("b-tab-item", {
    scopedSlots: _vm._u([{
      key: "header",
      fn: function fn() {
        return [_c("b-icon", {
          attrs: {
            icon: "list-ol",
            pack: "fa"
          }
        }), _vm._v(" "), _c("span", {
          staticClass: "help-inline pr-1 text-sm"
        }, [_vm._v(" Header ")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("FileHeader", {
    attrs: {
      fileheader_prop: _vm.report.fileheader
    }
  })], 1)], 1)], 1)]), _vm._v(" "), _c("div", {
    attrs: {
      id: "reportfile_" + _vm.report.uuid
    }
  }, [_c("div", {
    staticClass: "card"
  }, [_c("header", [_c("div", {
    staticClass: "card-header-title row"
  }, [_c("div", {
    staticClass: "col-md-6 col-sm-8 col-12"
  }, [_c("span", {
    staticClass: "text-purple text-xs",
    attrs: {
      "data-toggle": "collapse",
      "data-parent": "#reportfile_" + _vm.report.uuid,
      href: "#collapse-reports-access-" + _vm.index
    },
    on: {
      click: function click($event) {
        return _vm.collapseClicked("collapse_reportaccess_icon", _vm.collapse_reportaccess_icon);
      }
    }
  }, [_vm._v("\n                            Fichier(s) du Rapport\n                        ")])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-sm-4 col-12 text-right"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm.report.reportfiles.length > 0 ? _c("span", {
    staticClass: "badge badge-success"
  }, [_vm._v("\n                                " + _vm._s(_vm.report.reportfiles.length) + "\n                            ")]) : _c("span", {
    staticClass: "badge badge-danger"
  }, [_vm._v("\n                                " + _vm._s(_vm.report.reportfiles.length) + "\n                            ")]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-tool",
    attrs: {
      type: "button",
      "data-toggle": "collapse",
      "data-parent": "#reportfile_" + _vm.report.uuid,
      href: "#collapse-reports-access-" + _vm.index
    },
    on: {
      click: function click($event) {
        return _vm.collapseClicked("collapse_reportaccess_icon", _vm.collapse_reportaccess_icon);
      }
    }
  }, [_c("i", {
    "class": _vm.currentReportAccessCollapseIcon
  })])])])])]), _vm._v(" "), _c("div", {
    staticClass: "card-content panel-collapse collapse in",
    attrs: {
      id: "collapse-reports-access-" + _vm.index
    }
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-12 col-sm-6 col-12"
  }, [_c("ReportFiles", {
    attrs: {
      report_prop: _vm.report,
      reportfiles_prop: _vm.report.reportfiles
    }
  })], 1)])])])]), _vm._v(" "), _c("AddUpdateReport")], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reports/item.vue":
/*!*********************************************!*\
  !*** ./resources/js/views/reports/item.vue ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=feec173c&scoped=true& */ "./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/reports/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "feec173c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reports/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reports/item.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/views/reports/item.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true&":
/*!****************************************************************************************!*\
  !*** ./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true& ***!
  \****************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_feec173c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=feec173c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reports/item.vue?vue&type=template&id=feec173c&scoped=true&");


/***/ })

}]);