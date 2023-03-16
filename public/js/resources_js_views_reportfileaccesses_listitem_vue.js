"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reportfileaccesses_listitem_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../reportfileaccesses/reportfileaccessBus */ "./resources/js/views/reportfileaccesses/reportfileaccessBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "reportfileaccess-listitem",
  props: {
    reportfileaccess_prop: {}
  },
  components: {},
  mounted: function mounted() {
    var _this = this;
    _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('report_file_access_updated', function (reportfileaccess) {
      if (_this.reportfileaccess.id === reportfileaccess.id) {
        _this.reportfileaccess = reportfileaccess;
      }
    });
  },
  data: function data() {
    return {
      reportfileaccess: this.reportfileaccess_prop
    };
  },
  methods: {
    editReportFileAccess: function editReportFileAccess(reportfileaccess) {
      console.log('report_file_access_edit launched ITEM: ', reportfileaccess);
      _reportfileaccesses_reportfileaccessBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('report_file_access_edit', reportfileaccess);
    },
    deleteReportFileAccess: function deleteReportFileAccess(reportfileaccess) {
      var _this2 = this;
      this.$swal({
        title: '<small>Êtes vous sûr de vouloir supprimer cet Accès ?</small>',
        text: "Vous ne pourrez plus le récupérer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez le!',
        cancelButtonText: 'Annuler'
      }).then(function (result) {
        if (result.value) {
          // eslint-disable-next-line no-undef
          axios["delete"]("/reportfileaccesses/".concat(reportfileaccess.uuid))
          // eslint-disable-next-line no-unused-vars
          .then(function (resp) {
            _this2.$swal({
              html: '<small>Accès supprimé avec succès</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _this2.$emit('report_file_access_deleted', reportfileaccess);
            });
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        }
      });
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "text text-xs d-inline-block text-truncate text-xs-left"
  }, [_vm._v(_vm._s(_vm.reportfileaccess.accessaccount ? _vm.reportfileaccess.accessaccount.login : ""))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs d-inline-block text-truncate text-xs-left",
    staticStyle: {
      "max-width": "100%"
    }
  }, [_vm._v(_vm._s(_vm.reportfileaccess.reportserver ? _vm.reportfileaccess.reportserver.ip_address : ""))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.reportfileaccess.accessprotocole ? _vm.reportfileaccess.accessprotocole.name : ""))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs"
  }, [_vm.reportfileaccess.status && _vm.reportfileaccess.status.code === "active" ? _c("b-tag", {
    attrs: {
      type: "is-success is-light"
    }
  }, [_vm._v(_vm._s(_vm.reportfileaccess.status.name))]) : _vm.reportfileaccess.status && _vm.reportfileaccess.status.code === "inactive" ? _c("b-tag", {
    attrs: {
      type: "is-success is-light"
    }
  }, [_vm._v(_vm._s(_vm.reportfileaccess.status.name))]) : _c("b-tag", {
    attrs: {
      icon: "account-check-outline"
    }
  }, [_vm._v("PB status")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-xs text-center"
  }, [_c("div", {
    staticClass: "block"
  }, [_c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-warning",
    on: {
      click: function click($event) {
        return _vm.editReportFileAccess(_vm.reportfileaccess);
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
        return _vm.deleteReportFileAccess(_vm.reportfileaccess);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "trash",
      size: "is-small"
    }
  })], 1)])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reportfileaccesses/listitem.vue":
/*!************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/listitem.vue ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./listitem.vue?vue&type=template&id=2ff0852f&scoped=true& */ "./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true&");
/* harmony import */ var _listitem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./listitem.vue?vue&type=script&lang=js& */ "./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _listitem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "2ff0852f",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reportfileaccesses/listitem.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_listitem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./listitem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_listitem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true& ***!
  \*******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_listitem_vue_vue_type_template_id_2ff0852f_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./listitem.vue?vue&type=template&id=2ff0852f&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/listitem.vue?vue&type=template&id=2ff0852f&scoped=true&");


/***/ })

}]);