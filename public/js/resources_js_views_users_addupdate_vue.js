"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_users_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _userBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./userBus */ "./resources/js/views/users/userBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var User = /*#__PURE__*/_createClass(function User(user) {
  _classCallCheck(this, User);
  this.name = user.name || '';
  this.email = user.email || '';
  this.username = user.username || '';
  this.password = user.password || '';
  this.roles = user.roles || [];
  this.status = user.status || {};
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "user-addupdate",
  props: {},
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    _userBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('user_create', function () {
      _this.editing = false;
      _this.user = new User({});
      _this.userForm = new Form(_this.user);
      $('#addUpdateUser').modal();
    });
    _userBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('user_edit', function (user) {
      _this.launchEditUser(user);
    });
    this.$parent.$on('user_edit', function (user) {
      _this.launchEditUser(user);
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/roles.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.roles = data;
    });
    axios.get('/statuses.fetch').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.statuses = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Créer Nouvel Utilisateur',
      user: {},
      userForm: new Form(new User({})),
      userId: null,
      editing: false,
      loading: false,
      roles: [],
      statuses: []
    };
  },
  methods: {
    createUser: function createUser() {
      var _this3 = this;
      this.loading = true;
      this.userForm.post('/users').then(function (user) {
        _this3.loading = false;
        _this3.closeModal();
        _this3.$swal({
          html: '<small>Utilisateur créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _userBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('user_created', user);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    launchEditUser: function launchEditUser(user) {
      this.editing = true;
      this.user = new User(user);
      this.userForm = new Form(this.user);
      this.userId = user.uuid;
      this.formTitle = 'Modifier Utilisateur';
      $('#addUpdateUser').modal();
    },
    updateUser: function updateUser() {
      var _this4 = this;
      this.loading = true;
      this.userForm.put("/users/".concat(this.userId)).then(function (user) {
        _this4.loading = false;
        _this4.closeModal();
        _this4.$swal({
          html: '<small>Utilisateur Modifié avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _userBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('user_updated', user);
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateUser').modal('hide');
    },
    resetForm: function resetForm() {
      this.userForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return this.userForm.name && !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true& ***!
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
    staticClass: "modal fade",
    attrs: {
      id: "addUpdateUser",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "exampleModalLabel",
      "aria-hidden": "true"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-lg"
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title text-sm",
    attrs: {
      id: "exampleModalLabel"
    }
  }, [_vm._v(_vm._s(_vm.formTitle))]), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", {
    staticClass: "form-horizontal",
    on: {
      submit: function submit($event) {
        $event.preventDefault();
      },
      keydown: function keydown($event) {
        return _vm.userForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Nom")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.userForm.name,
      expression: "userForm.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "name",
      name: "name",
      placeholder: "Nom"
    },
    domProps: {
      value: _vm.userForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.userForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.userForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "username"
    }
  }, [_vm._v("Nom utilisateur")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.userForm.username,
      expression: "userForm.username"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "username",
      name: "username",
      placeholder: "Nom Utilisateur"
    },
    domProps: {
      value: _vm.userForm.username
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.userForm, "username", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.userForm.errors.has("username") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("username"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("E-mail")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.userForm.email,
      expression: "userForm.email"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "email",
      name: "email",
      placeholder: "E-mail"
    },
    domProps: {
      value: _vm.userForm.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.userForm, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.userForm.errors.has("email") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("email"))
    }
  }) : _vm._e()])]), _vm._v(" "), !_vm.editing ? _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Mot de Passe")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.userForm.password,
      expression: "userForm.password"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "password",
      name: "password",
      placeholder: "Mot de Passe"
    },
    domProps: {
      value: _vm.userForm.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.userForm, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.userForm.errors.has("password") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("password"))
    }
  }) : _vm._e()])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "m_select_action_type"
    }
  }, [_vm._v("User(s)")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10 text-xs"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "m_select_action_type",
      "selected.sync": "user.roles",
      value: "",
      options: _vm.roles,
      searchable: true,
      multiple: true,
      label: "name",
      "track-by": "id",
      placeholder: "Profile(s)"
    },
    model: {
      value: _vm.userForm.roles,
      callback: function callback($$v) {
        _vm.$set(_vm.userForm, "roles", $$v);
      },
      expression: "userForm.roles"
    }
  }), _vm._v(" "), _vm.userForm.errors.has("roles") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("roles"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "m_select_status"
    }
  }, [_vm._v("Statut")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10 text-xs"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "m_select_status",
      "selected.sync": "user.status",
      value: "",
      options: _vm.statuses,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Statut"
    },
    model: {
      value: _vm.userForm.status,
      callback: function callback($$v) {
        _vm.$set(_vm.userForm, "status", $$v);
      },
      expression: "userForm.status"
    }
  }), _vm._v(" "), _vm.userForm.errors.has("roles") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.userForm.errors.get("roles"))
    }
  }) : _vm._e()], 1)])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer justify-content-between"
  }, [_c("button", {
    staticClass: "btn btn-secondary btn-sm",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Fermer")]), _vm._v(" "), _vm.editing ? _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      type: "button",
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.updateUser();
      }
    }
  }, [_vm._v("Enregistrer")]) : _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      type: "button",
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.createUser();
      }
    }
  }, [_vm._v("Valider")])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])]);
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

/***/ "./resources/js/views/users/addupdate.vue":
/*!************************************************!*\
  !*** ./resources/js/views/users/addupdate.vue ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=21491734&scoped=true& */ "./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/users/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var vue_multiselect_dist_vue_multiselect_min_css_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css& */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "21491734",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/users/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/users/addupdate.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/users/addupdate.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true& ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_21491734_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=21491734&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/users/addupdate.vue?vue&type=template&id=21491734&scoped=true&");


/***/ })

}]);