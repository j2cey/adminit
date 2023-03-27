"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_collectedreportfiles_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _collectedreportfiles_collectedreportfileBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../collectedreportfiles/collectedreportfileBus */ "./resources/js/views/collectedreportfiles/collectedreportfileBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    collectedreportfiles_prop: {}
  },
  name: "collectedreportfiles-index",
  components: {
    AddUpdateCollectedReportFile: function AddUpdateCollectedReportFile() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_collectedreportfiles_addupdate_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../collectedreportfiles/addupdate */ "./resources/js/views/collectedreportfiles/addupdate.vue"));
    },
    CollectedReportFileItem: function CollectedReportFileItem() {
      return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ../collectedreportfiles/item */ "./resources/js/views/collectedreportfiles/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _collectedreportfiles_collectedreportfileBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('collectedreportfile_created', function (collectedreportfile) {
      if (_this.report.id === collectedreportfile.report.id) {
        _this.addReportFileToList(collectedreportfile);
      }
    });
    _collectedreportfiles_collectedreportfileBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('collectedreportfile_updated', function (collectedreportfile) {
      if (_this.report.id === collectedreportfile.report.id) {
        _this.updateCollectedReportFileFromList(collectedreportfile);
      }
    });
  },
  data: function data() {
    return {
      report: this.report_prop,
      collectedreportfiles: this.collectedreportfiles_prop,
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
      columns: [{
        field: 'id',
        key: 'id',
        label: 'ID',
        numeric: true,
        searchable: false,
        sortable: true
      }, {
        field: 'local_file_name',
        key: 'local_file_name',
        label: 'Local File Name',
        searchable: true,
        sortable: true
      }, {
        field: 'reportfile',
        key: 'reportfile',
        label: 'Fichier Rapport',
        searchable: false,
        sortable: true
      }, {
        field: 'file_size',
        key: 'file_size',
        label: 'Taille',
        numeric: true,
        searchable: false,
        sortable: true
      }, {
        field: 'nb_rows',
        key: 'nb_rows',
        label: 'Lignes',
        numeric: true,
        searchable: false,
        sortable: true
      }, {
        field: 'description',
        key: 'description',
        label: 'Description',
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
    showCollectedReportFile: function showCollectedReportFile(collectedreportfile) {
      console.log("showCollectedReportFile: ", collectedreportfile.show_url);
      window.location = collectedreportfile.show_url;
    },
    createCollectedReportFile: function createCollectedReportFile() {
      var report = this.report;
      _collectedreportfiles_collectedreportfileBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('create_new_collectedreportfile', {
        report: report
      });
    },
    editCollectedReportFile: function editCollectedReportFile(collectedreportfile) {
      _collectedreportfiles_collectedreportfileBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('edit_collectedreportfile', {
        collectedreportfile: collectedreportfile
      });
    },
    deleteCollectedReportFile: function deleteCollectedReportFile(collectedreportfile) {
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
          axios["delete"]("/collectedreportfiles/".concat(collectedreportfile.uuid)).then(function (resp) {
            _this2.removeCollectedReportFileFromList(collectedreportfile);
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        }
      });
    },
    removeAt: function removeAt(idx) {
      this.list.splice(idx, 1);
    },
    add: function add() {
      id++;
      this.list.push({
        name: "Juan " + id,
        id: id,
        text: ""
      });
    },
    addCollectedReportFileToList: function addCollectedReportFileToList(collectedreportfile) {
      var collectedreportfileIndex = this.collectedreportfiles.findIndex(function (c) {
        return collectedreportfile.id === c.id;
      });

      // if this attribute doesn't exists in the list
      if (collectedreportfileIndex === -1) {
        //J'ajoute dans la liste
        this.collectedreportfiles.push(collectedreportfile);
        this.$emit('report_file_created', collectedreportfile);
      }
    },
    updateCollectedReportFileFromList: function updateCollectedReportFileFromList(collectedreportfile) {
      var stepIndex = this.collectedreportfiles.findIndex(function (s) {
        return collectedreportfile.id === s.id;
      });

      // if this attribute belongs to the list
      if (stepIndex > -1) {
        this.collectedreportfiles.splice(stepIndex, 1, collectedreportfile);
      }
    },
    removeCollectedReportFileFromList: function removeCollectedReportFileFromList(collectedreportfile) {
      var collectedreportfileIndex = this.collectedreportfiles.findIndex(function (s) {
        return collectedreportfile.id === s.id;
      });

      // if this attribute belongs to the list
      if (collectedreportfileIndex > -1) {
        this.collectedreportfiles.splice(collectedreportfileIndex, 1);
        this.$swal({
          html: '<small>Fichier de rapport supprimé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {});
      }
    }
  },
  computed: {
    transitionName: function transitionName() {
      if (this.useTransition) {
        return 'fade';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; },
/* harmony export */   "staticRenderFns": function() { return /* binding */ staticRenderFns; }
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("section", [_c("p", [_c("b-button", {
    attrs: {
      size: "is-small",
      type: "is-info is-light"
    },
    on: {
      click: function click($event) {
        return _vm.createCollectedReportFile();
      }
    }
  }, [_vm._v("Ajouter")])], 1), _vm._v(" "), _c("b-field", {
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
      data: _vm.collectedreportfiles,
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
        return [_c("CollectedReportFileItem", {
          attrs: {
            collectedreportfile_prop: props.row
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
          }, [_vm._v("\n                        " + _vm._s(props.row[column.field]) + "\n                    ")]) : column.field === "local_file_name" ? _c("span", {
            staticClass: "has-text-primary is-italic text-xs"
          }, [_c("a", {
            on: {
              click: function click($event) {
                return _vm.showCollectedReportFile(props.row);
              }
            }
          }, [_vm._v("\n                            " + _vm._s(props.row[column.field]) + "\n                        ")])]) : column.field === "reportfile" ? _c("span", {
            staticClass: "has-text-info is-italic text-xs"
          }, [props.row[column.field] ? _c("span", [_vm._v("\n                            " + _vm._s(props.row[column.field].name) + "\n                        ")]) : _c("span")]) : column.date ? _c("span", {
            staticClass: "tag is-success"
          }, [_vm._v("\n                        " + _vm._s(new Date(props.row[column.field]).toLocaleDateString()) + "\n                    ")]) : column.field === "actions" ? _c("span", {
            staticClass: "text-xs"
          }, [_c("div", {
            staticClass: "block"
          }, [_c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-warning",
            on: {
              click: function click($event) {
                return _vm.editCollectedReportFile(props.row);
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
                return _vm.deleteCollectedReportFile(props.row);
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
  })], 2), _vm._v(" "), _c("AddUpdateCollectedReportFile")], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/collectedreportfiles/collectedreportfileBus.js":
/*!***************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/collectedreportfileBus.js ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/index.vue":
/*!***********************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/index.vue ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=7147b31c&scoped=true& */ "./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "7147b31c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/collectedreportfiles/index.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true& ***!
  \******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_7147b31c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=7147b31c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/collectedreportfiles/index.vue?vue&type=template&id=7147b31c&scoped=true&");


/***/ })

}]);