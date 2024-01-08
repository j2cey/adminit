"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_treatments_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _treatmentBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./treatmentBus */ "./resources/js/views/treatments/treatmentBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "treatment-list",
  props: {
    treatments_prop: {}
  },
  components: {
    TreatmentItem: function TreatmentItem() {
      return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ./item */ "./resources/js/views/treatments/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _treatmentBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('treatment_created', function (treatment) {
      _this.addTreatmentToList(treatment);
    });
    _treatmentBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('treatment_updated', function (treatment) {
      _this.updateTreatmentFromList(treatment);
    });
  },
  data: function data() {
    return {
      treatments: this.treatments_prop,
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
        field: 'reportfile',
        key: 'reportfile',
        label: 'Report / File',
        numeric: false,
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
        label: 'Start/End',
        searchable: false,
        sortable: true,
        date: false
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
    showTreatment: function showTreatment(treatment) {
      window.location = treatment.show_url;
    },
    createTreatment: function createTreatment() {
      _treatmentBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('create_new_treatment');
    },
    editTreatment: function editTreatment(treatment) {
      _treatmentBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('edit_treatment', {
        treatment: treatment
      });
    },
    deleteTreatment: function deleteTreatment(treatment) {
      var _this2 = this;
      this.$swal({
        title: 'Supprimer ce Traitement ?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez le!'
      }).then(function (result) {
        if (result.value) {
          // eslint-disable-next-line no-undef
          axios["delete"]("/treatments/".concat(treatment.uuid))
          // eslint-disable-next-line no-unused-vars
          .then(function (resp) {
            _this2.removeTreatmentFromList(treatment);
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        }
      });
    },
    addTreatmentToList: function addTreatmentToList(treatment) {
      var treatmentIndex = this.treatments.findIndex(function (c) {
        return treatment.id === c.id;
      });
      console.log("addTreatmentToList: ", treatment, treatmentIndex);

      // if this Account doesn't belong to the list
      if (treatmentIndex === -1) {
        //J'ajoute dans la liste
        this.treatments.push(treatment);
        this.$emit('treatment_added', treatment);
        console.log("treatment_added");
      }
    },
    updateTreatmentFromList: function updateTreatmentFromList(treatment) {
      var stepIndex = this.treatments.findIndex(function (s) {
        return treatment.id === s.id;
      });

      // if this Account belongs to the list
      if (stepIndex > -1) {
        this.treatments.splice(stepIndex, 1, treatment);
      }
    },
    removeTreatmentFromList: function removeTreatmentFromList(treatment) {
      var treatmentIndex = this.treatments.findIndex(function (s) {
        return treatment.id === s.id;
      });

      // if this attribute belongs to the list
      if (treatmentIndex > -1) {
        this.treatments.splice(treatmentIndex, 1);
        this.$swal({
          html: '<small>Traitement supprimé avec succès !</small>',
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
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
      data: _vm.treatments,
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
        return [_c("TreatmentItem", {
          attrs: {
            treatment_prop: props.row
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
                return _vm.showTreatment(props.row);
              }
            }
          }, [_vm._v("\n                            " + _vm._s(props.row[column.field]) + "\n                        ")])]) : column.field === "reportfile" ? _c("span", {
            staticClass: "has-text-info is-italic text-xs"
          }, [props.row[column.field] ? _c("span", [_c("b-tag", {
            attrs: {
              type: "is-default is-light"
            }
          }, [_vm._v(_vm._s(props.row[column.field].report.title) + " / " + _vm._s(props.row[column.field].name))])], 1) : _c("span")]) : column.field === "result" ? _c("span", {
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
          }, [_vm._v(_vm._s(props.row[column.field]))])], 1) : _c("span")]) : column.field === "start_at" ? _c("span", {
            staticClass: "tag is-info is-light"
          }, [_vm._v("\n                        " + _vm._s(_vm._f("formatDate")(props.row["start_at"])) + " / " + _vm._s(_vm._f("formatDate")(props.row["end_at"])) + "\n                    ")]) : column.date ? _c("span", {
            staticClass: "tag is-info is-light"
          }, [_vm._v("\n                        " + _vm._s(_vm._f("formatDate")(props.row[column.field])) + "\n                    ")]) : column.field === "actions" ? _c("span", {
            staticClass: "text-xs"
          }, [_c("div", {
            staticClass: "block"
          }, [_c("a", {
            staticClass: "tw-inline-block tw-mr-3 text-warning",
            on: {
              click: function click($event) {
                return _vm.editTreatment(props.row);
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
                return _vm.deleteTreatment(props.row);
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

/***/ "./resources/js/views/treatments/list.vue":
/*!************************************************!*\
  !*** ./resources/js/views/treatments/list.vue ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=4e9dc983&scoped=true& */ "./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/treatments/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "4e9dc983",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/treatments/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/treatments/list.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/treatments/list.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true& ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4e9dc983_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=4e9dc983&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/treatments/list.vue?vue&type=template&id=4e9dc983&scoped=true&");


/***/ })

}]);