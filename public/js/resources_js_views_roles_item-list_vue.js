"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_roles_item-list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "role-item-list",
  props: {
    list_title_prop: null,
    roles_prop: {}
  },
  components: {
    RoleAddUpdate: function RoleAddUpdate() {
      return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ./addupdate */ "./resources/js/views/roles/addupdate.vue"));
    },
    RoleItem: function RoleItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_roles_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./item */ "./resources/js/views/roles/item.vue"));
    }
  },
  data: function data() {
    return {
      list_title: this.list_title_prop,
      roles: this.roles_prop,
      searchRoles: null
    };
  },
  methods: {},
  computed: {
    filteredRoles: function filteredRoles() {
      var _this = this;
      var tempRoles = this.roles;
      if (this.searchRoles !== '' && this.searchRoles) {
        tempRoles = tempRoles.filter(function (item) {
          return item.name.toUpperCase().includes(_this.searchRoles.toUpperCase());
        });
      }

      // Sorting
      tempRoles = tempRoles.sort(function (a, b) {
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
        tempRoles.reverse();
      }
      // end Sorting

      return tempRoles;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true& ***!
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
  return _c("div", {
    staticClass: "card collapsed-card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "card-title"
  }, [_vm._v(_vm._s(_vm.list_title ? _vm.list_title : "Roles"))]), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _c("div", {
    staticClass: "card-body table-responsive p-0"
  }, [_c("table", {
    staticClass: "table table-head-fixed text-nowrap"
  }, [_c("thead", [_c("tr", [_c("th", [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("div", {
    staticClass: "btn-group"
  }, [_c("div", {
    staticClass: "input-group input-group-sm"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.searchRoles,
      expression: "searchRoles"
    }],
    staticClass: "form-control form-control-navbar",
    attrs: {
      type: "search",
      placeholder: "Search",
      "aria-label": "Search"
    },
    domProps: {
      value: _vm.searchRoles
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.searchRoles = $event.target.value;
      }
    }
  }), _vm._v(" "), _vm._m(1)])])])]), _vm._v(" "), _vm._m(2)])])]), _vm._v(" "), _c("tbody", _vm._l(_vm.filteredRoles, function (role, index) {
    return _vm.filteredRoles ? _c("tr", {
      key: role.id,
      staticClass: "text text-xs"
    }, [index < 10 ? _c("td", [role.name ? _c("RoleItem", {
      attrs: {
        role_prop: role
      }
    }) : _vm._e()], 1) : _vm._e()]) : _vm._e();
  }), 0)])]), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }), _vm._v(" "), _c("RoleAddUpdate")], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-tools"
  }, [_c("button", {
    staticClass: "btn btn-tool",
    attrs: {
      type: "button",
      "data-card-widget": "collapse"
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  })]), _vm._v(" "), _c("div", {
    staticClass: "btn-group"
  }, [_c("button", {
    staticClass: "btn btn-tool dropdown-toggle",
    attrs: {
      type: "button",
      "data-toggle": "dropdown"
    }
  }, [_c("i", {
    staticClass: "fas fa-wrench"
  })]), _vm._v(" "), _c("div", {
    staticClass: "dropdown-menu dropdown-menu-right",
    attrs: {
      role: "menu"
    }
  }, [_c("a", {
    staticClass: "dropdown-item",
    attrs: {
      href: "#"
    }
  }, [_vm._v("Action")]), _vm._v(" "), _c("a", {
    staticClass: "dropdown-item",
    attrs: {
      href: "#"
    }
  }, [_vm._v("Another action")]), _vm._v(" "), _c("a", {
    staticClass: "dropdown-item",
    attrs: {
      href: "#"
    }
  }, [_vm._v("Something else here")]), _vm._v(" "), _c("a", {
    staticClass: "dropdown-divider"
  }), _vm._v(" "), _c("a", {
    staticClass: "dropdown-item",
    attrs: {
      href: "#"
    }
  }, [_vm._v("Separated link")])])]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-tool",
    attrs: {
      type: "button",
      "data-card-widget": "remove"
    }
  }, [_c("i", {
    staticClass: "fas fa-times"
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-navbar",
    attrs: {
      type: "button"
    }
  }, [_c("i", {
    staticClass: "fas fa-search"
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Name")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-4 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Description")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Permission(s)")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  })])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/roles/item-list.vue":
/*!************************************************!*\
  !*** ./resources/js/views/roles/item-list.vue ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item-list.vue?vue&type=template&id=5f7ba697&scoped=true& */ "./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true&");
/* harmony import */ var _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item-list.vue?vue&type=script&lang=js& */ "./resources/js/views/roles/item-list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "5f7ba697",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/roles/item-list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/roles/item-list.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/roles/item-list.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true& ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_5f7ba697_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=template&id=5f7ba697&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/roles/item-list.vue?vue&type=template&id=5f7ba697&scoped=true&");


/***/ })

}]);