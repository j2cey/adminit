"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_osservers_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _osserverBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./osserverBus */ "./resources/js/views/osservers/osserverBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "osserver-item",
  props: {
    osserver_prop: {}
  },
  components: {},
  mounted: function mounted() {
    var _this = this;
    _osserverBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('os_server_updated', function (osserver) {
      if (_this.osserver.id === osserver.id) {
        _this.osserver = osserver;
      }
    });
  },
  data: function data() {
    return {
      osserver: this.osserver_prop
    };
  },
  methods: {
    editOsServer: function editOsServer(osserver) {
      console.log('os_server_edit on ITEM: ', osserver);
      _osserverBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('os_server_edit', osserver);
    },
    deleteOsServer: function deleteOsServer(osserver) {
      var _this2 = this;
      this.$swal({
        title: '<small>Êtes vous sûr de vouloir supprimer ce serveur?</small>',
        text: "Cette procédure est irrévocable!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez le!',
        cancelButtonText: 'Annuler'
      }).then(function (result) {
        if (result.value) {
          // eslint-disable-next-line no-undef
          axios["delete"]("/osservers/".concat(osserver.uuid))
          // eslint-disable-next-line no-unused-vars
          .then(function (resp) {
            _this2.$swal({
              html: '<small>Serveur supprimé avec succès</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _this2.$emit('osserver_deleted', osserver);
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "col-sm-2 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-sm d-inline-block text-truncate text-sm-left"
  }, [_vm._v(_vm._s(_vm.osserver.id))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-sm d-inline-block text-truncate text-sm-left",
    staticStyle: {
      "max-width": "100%"
    }
  }, [_vm._v(_vm._s(_vm.osserver.name))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.osserver.osfamily ? _vm.osserver.osfamily.name : ""))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6 border-right"
  }, [_c("span", {
    staticClass: "text text-xs"
  }, [_vm._v(_vm._s(_vm.osserver.osarchitecture ? _vm.osserver.osarchitecture.name : ""))])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-xs text-center"
  }, [_c("a", {
    staticClass: "text text-success",
    on: {
      click: function click($event) {
        return _vm.editOsServer(_vm.osserver);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-pencil-square-o",
    attrs: {
      "aria-hidden": "true"
    }
  })]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-tool text-danger",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.deleteOsServer(_vm.osserver);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-trash",
    attrs: {
      "aria-hidden": "true"
    }
  })])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/osservers/item.vue":
/*!***********************************************!*\
  !*** ./resources/js/views/osservers/item.vue ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=3038afd5&scoped=true& */ "./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/osservers/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3038afd5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/osservers/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/osservers/item.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/views/osservers/item.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true& ***!
  \******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_3038afd5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=3038afd5&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item.vue?vue&type=template&id=3038afd5&scoped=true&");


/***/ })

}]);