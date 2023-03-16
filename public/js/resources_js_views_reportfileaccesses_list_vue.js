"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reportfileaccesses_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../reportfileaccesses/reportfileaccessBus */ "./resources/js/views/reportfileaccesses/reportfileaccessBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "reportfileaccess-list",
  props: {
    list_title_prop: {
      "default": "Accès",
      type: String
    },
    reportfile_prop: {},
    reportfileaccesses_list_prop: {}
  },
  components: {
    ReportFileAccessAddUpdate: function ReportFileAccessAddUpdate() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_reportfileaccesses_addupdate_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./addupdate */ "./resources/js/views/reportfileaccesses/addupdate.vue"));
    },
    ReportFileAccessListdetail: function ReportFileAccessListdetail() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_reportfileaccesses_listitem_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./listitem */ "./resources/js/views/reportfileaccesses/listitem.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('report_file_type_created', function (reportfileaccess) {
      if (_this.reportfile.id === reportfileaccess.reportfile.id) {
        _this.addReportfileaccessToList(reportfileaccess);
      }
    });
  },
  data: function data() {
    return {
      list_title: this.list_title_prop,
      reportfile: this.reportfile_prop,
      reportfileaccesses_list: this.reportfileaccesses_list_prop,
      searchReportfileaccesses: "",
      searchtypes: ['compte', 'serveur', 'protocole'],
      searchtype_selected: null,
      searching: false
    };
  },
  methods: {
    createReportFileAccess: function createReportFileAccess() {
      var reportfile = this.reportfile;
      _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('report_file_type_create', reportfile);
    },
    deleteReportFileAccess: function deleteReportFileAccess($event) {
      //console.log("report_file_access_deleted received at list: ", $event)
      var itemIndex = this.reportfileaccesses_list.findIndex(function (c) {
        return $event.id === c.id;
      });
      console.log("itemIndex : ", itemIndex);
      if (itemIndex !== -1) {
        this.reportfileaccesses_list.splice(itemIndex, 1);
        // emission vers le parent
        //this.$emit('reportfileaccess_removed_from_list', $event)
      }
    },
    searchtypeSelected: function searchtypeSelected($event) {
      console.log("searchtypeSelected: ", $event);
      console.log("searchtype_selected: ", this.searchtype_selected);
    },
    clearSearchtype: function clearSearchtype() {
      this.searchReportfileaccesses = "";
      this.searchtype_selected = null;
    },
    addReportfileaccessToList: function addReportfileaccessToList(reportfileaccess) {
      var itemIndex = this.reportfileaccesses_list.findIndex(function (c) {
        return reportfileaccess.id === c.id;
      });
      if (itemIndex === -1) {
        this.reportfileaccesses_list.push(reportfileaccess);
        this.$emit('report_file_type_added', reportfileaccess);
      }
    }
  },
  computed: {
    filteredReportfileaccesses: function filteredReportfileaccesses() {
      var _this2 = this;
      var tempReportfileaccesses = this.reportfileaccesses_list;
      if (this.searchReportfileaccesses !== '' && this.searchReportfileaccesses) {
        if (this.searchtype_selected === "compte") {
          // search by compte
          tempReportfileaccesses = tempReportfileaccesses.filter(function (item) {
            return item.accessaccount.login.toUpperCase().includes(_this2.searchReportfileaccesses.toUpperCase());
          });
        } else if (this.searchtype_selected === "serveur") {
          // search by serveur
          tempReportfileaccesses = tempReportfileaccesses.filter(function (item) {
            return item.reportserver.name.toUpperCase().includes(_this2.searchReportfileaccesses.toUpperCase());
          });
        } else {
          // search by protocole
          tempReportfileaccesses = tempReportfileaccesses.filter(function (item) {
            return item.accessprotocole.name.toUpperCase().includes(_this2.searchReportfileaccesses.toUpperCase());
          });
        }
      }
      // Sorting
      tempReportfileaccesses = tempReportfileaccesses.sort(function (a, b) {
        var fa = a.name.toLowerCase(),
          fb = b.name.toLowerCase();
        if (fa > fb) {
          return -1;
        }
        if (fa < fb) {
          return 1;
        }
        return 0;
      });
      if (!this.ascending) {
        tempReportfileaccesses.reverse();
      }
      // end Sorting
      return tempReportfileaccesses;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_c("h5", [_vm._v("\n            " + _vm._s(_vm.list_title) + "\n            "), _c("small", {
    staticClass: "text text-xs"
  }, [_vm._v("\n                " + _vm._s(_vm.searchReportfileaccesses === "" ? "" : " (" + _vm.filteredReportfileaccesses.length + ")") + "\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "card-tools"
  })]), _vm._v(" "), _c("div", {
    staticClass: "card-body table-responsive p-0"
  }, [_c("table", {
    staticClass: "table table-head-fixed text-nowrap"
  }, [_c("thead", [_c("tr", [_c("th", [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("div", {
    staticClass: "btn-group"
  }, [_c("b-button", {
    attrs: {
      size: "is-small",
      type: "is-info is-light"
    },
    on: {
      click: _vm.createReportFileAccess
    }
  }, [_vm._v("Ajouter")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("div", {
    staticClass: "btn-group"
  }, [_c("div", {
    staticClass: "input-group input-group-sm"
  }, [_c("div", {
    staticClass: "input-group-prepend"
  }, [_c("b-select", {
    attrs: {
      placeholder: "Select Rechercher",
      size: "is-small",
      loading: _vm.searching
    },
    on: {
      input: function input($event) {
        return _vm.searchtypeSelected($event);
      }
    },
    model: {
      value: _vm.searchtype_selected,
      callback: function callback($$v) {
        _vm.searchtype_selected = $$v;
      },
      expression: "searchtype_selected"
    }
  }, _vm._l(_vm.searchtypes, function (option) {
    return _c("option", {
      key: option,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                                                " + _vm._s(option) + "\n                                            ")]);
  }), 0)], 1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.searchReportfileaccesses,
      expression: "searchReportfileaccesses"
    }],
    staticClass: "form-control form-control-navbar",
    attrs: {
      type: "search",
      placeholder: "Rechercher ...",
      "aria-label": "Search",
      disabled: !_vm.searchtype_selected
    },
    domProps: {
      value: _vm.searchReportfileaccesses
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.searchReportfileaccesses = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-navbar",
    attrs: {
      type: "button",
      disabled: !_vm.searchtype_selected
    },
    on: {
      click: _vm.clearSearchtype
    }
  }, [_c("i", {
    staticClass: "fa fa-times"
  })])])])])])]), _vm._v(" "), _vm._m(0)])])]), _vm._v(" "), _c("tbody", _vm._l(_vm.filteredReportfileaccesses, function (reportfileaccess, index) {
    return _vm.filteredReportfileaccesses ? _c("tr", {
      key: reportfileaccess.id,
      staticClass: "text text-xs"
    }, [index < 10 ? _c("td", [_c("ReportFileAccessListdetail", {
      attrs: {
        reportfileaccess_prop: reportfileaccess
      },
      on: {
        report_file_access_deleted: _vm.deleteReportFileAccess
      }
    })], 1) : _vm._e()]) : _vm._e();
  }), 0)])]), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }), _vm._v(" "), _c("ReportFileAccessAddUpdate")], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Compte")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Serveur")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Protocole")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Statut")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  })])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reportfileaccesses/reportfileaccessBus.js":
/*!**********************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/reportfileaccessBus.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/list.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/list.vue ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=19c5ed9c&scoped=true& */ "./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "19c5ed9c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reportfileaccesses/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true& ***!
  \***************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_19c5ed9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=19c5ed9c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/list.vue?vue&type=template&id=19c5ed9c&scoped=true&");


/***/ })

}]);