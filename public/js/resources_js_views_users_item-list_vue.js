"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_users_item-list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _users_userBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../users/userBus */ "./resources/js/views/users/userBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "user-item-list",
  props: {
    list_title_prop: {
      "default": "Users",
      type: String
    },
    users_prop: {}
  },
  components: {
    UserAddUpdate: function UserAddUpdate() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_users_addupdate_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./addupdate */ "./resources/js/views/users/addupdate.vue"));
    },
    UserItem: function UserItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_users_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./item */ "./resources/js/views/users/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _users_userBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('user_created', function (newuser) {
      _this.users.push(newuser);
      _this.$emit('user_created', newuser);
    });
  },
  data: function data() {
    return {
      list_title: this.list_title_prop,
      users: this.users_prop,
      searchUsers: ""
    };
  },
  methods: {
    createUser: function createUser() {
      _users_userBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('user_create');
    },
    deleteUser: function deleteUser($event) {
      console.log("user_deleted received at list: ", $event);
      var userIndex = this.users.findIndex(function (c) {
        return $event.id === c.id;
      });
      if (userIndex !== -1) {
        this.users.splice(userIndex, 1);
      }
    }
  },
  computed: {
    filteredUsers: function filteredUsers() {
      var _this2 = this;
      var tempUsers = this.users;
      if (this.searchUsers !== '' && this.searchUsers) {
        tempUsers = tempUsers.filter(function (item) {
          return item.name.toUpperCase().includes(_this2.searchUsers.toUpperCase());
        });
      }

      // Sorting
      tempUsers = tempUsers.sort(function (a, b) {
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
        tempUsers.reverse();
      }
      // end Sorting

      return tempUsers;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true& ***!
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
    staticClass: "btn btn-tool",
    attrs: {
      type: "button",
      "data-card-widget": "collapse"
    }
  }, [_vm._v("\n            " + _vm._s(_vm.list_title) + "\n            "), _c("small", {
    staticClass: "text text-xs"
  }, [_vm._v("\n                " + _vm._s(_vm.searchUsers === "" ? "" : " (" + _vm.filteredUsers.length + ")") + "\n            ")])]), _vm._v(" "), _c("div", {
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
      click: _vm.createUser
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
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.searchUsers,
      expression: "searchUsers"
    }],
    staticClass: "form-control form-control-navbar",
    attrs: {
      type: "search",
      placeholder: "Search",
      "aria-label": "Search"
    },
    domProps: {
      value: _vm.searchUsers
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.searchUsers = $event.target.value;
      }
    }
  }), _vm._v(" "), _vm._m(0)])])])]), _vm._v(" "), _vm._m(1)])])]), _vm._v(" "), _c("tbody", _vm._l(_vm.filteredUsers, function (user, index) {
    return _vm.filteredUsers ? _c("tr", {
      key: user.id,
      staticClass: "text text-xs"
    }, [index < 10 ? _c("td", [user.name ? _c("UserItem", {
      attrs: {
        user_prop: user
      },
      on: {
        user_deleted: _vm.deleteUser
      }
    }) : _vm._e()], 1) : _vm._e()]) : _vm._e();
  }), 0)])]), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }), _vm._v(" "), _c("UserAddUpdate")], 1);
};
var staticRenderFns = [function () {
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
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("E-mail")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Role(s)")])]), _vm._v(" "), _c("div", {
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

/***/ "./resources/js/views/users/userBus.js":
/*!*********************************************!*\
  !*** ./resources/js/views/users/userBus.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/users/item-list.vue":
/*!************************************************!*\
  !*** ./resources/js/views/users/item-list.vue ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item-list.vue?vue&type=template&id=1a8586a2&scoped=true& */ "./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&");
/* harmony import */ var _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item-list.vue?vue&type=script&lang=js& */ "./resources/js/views/users/item-list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "1a8586a2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/users/item-list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/users/item-list.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/users/item-list.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true& ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=template&id=1a8586a2&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&");


/***/ })

}]);