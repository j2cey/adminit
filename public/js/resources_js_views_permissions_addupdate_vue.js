"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_permissions_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _permissionBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./permissionBus */ "./resources/js/views/permissions/permissionBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Permission = /*#__PURE__*/_createClass(function Permission(permission) {
  _classCallCheck(this, Permission);
  this.name = permission.name || '';
  this.level = permission.level || '';
  this.guard_name = permission.guard_name || '';
  this.description = permission.description || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "permission-addupdate",
  props: {},
  components: {},
  mounted: function mounted() {
    var _this = this;
    _permissionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('permission_create', function () {
      _this.editing = false;
      _this.permission = new Permission({});
      _this.permissionForm = new Form(_this.permission);
      $('#addUpdatePermission').modal();
    });
    _permissionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('permission_edit', function (permission) {
      _this.editing = true;
      _this.permission = new Permission(permission);
      _this.permissionForm = new Form(_this.permission);
      _this.permissionId = permission.id;
      _this.formTitle = 'Edit Permission';
      $('#addUpdatePermission').modal();
    });
  },
  created: function created() {},
  data: function data() {
    return {
      formTitle: 'Create New Permission',
      permission: {},
      permissionForm: new Form(new Permission({})),
      permissionId: null,
      editing: false,
      loading: false
    };
  },
  methods: {
    createPermission: function createPermission() {
      var _this2 = this;
      this.loading = true;
      this.permissionForm.post('/permissions').then(function (newpermission) {
        _this2.loading = false;
        _this2.closeModal();
        _this2.$swal({
          html: '<small>Permission créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _permissionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('permission_created', newpermission);
        });
      })["catch"](function (error) {
        _this2.loading = false;
      });
    },
    updatePermission: function updatePermission() {
      var _this3 = this;
      this.loading = true;
      this.permissionForm.put("/permissions/".concat(this.permissionId)).then(function (updpermission) {
        _this3.loading = false;
        _this3.closeModal();
        _this3.$swal({
          html: '<small>Permission modifié avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _permissionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('permission_updated', updpermission);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdatePermission').modal('hide');
    },
    resetForm: function resetForm() {
      this.permissionForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return this.permissionForm.name && !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true& ***!
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
  return _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "addUpdatePermission",
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
  }, [_vm._v(_vm._s(_vm.formTitle))]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "aria-label": "Close"
    },
    on: {
      click: _vm.closeModal
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", {
    staticClass: "form-horizontal",
    on: {
      submit: function submit($event) {
        $event.preventDefault();
      },
      keydown: function keydown($event) {
        return _vm.permissionForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.permissionForm.name,
      expression: "permissionForm.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "name",
      name: "name",
      autocomplete: "name",
      autofocus: "",
      placeholder: "Titre"
    },
    domProps: {
      value: _vm.permissionForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.permissionForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.permissionForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.permissionForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "level"
    }
  }, [_vm._v("Level")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.permissionForm.level,
      expression: "permissionForm.level"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "level",
      name: "level",
      autocomplete: "level",
      autofocus: "",
      placeholder: "Level"
    },
    domProps: {
      value: _vm.permissionForm.level
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.permissionForm, "level", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.permissionForm.errors.has("level") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.permissionForm.errors.get("level"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "guard_name"
    }
  }, [_vm._v("Guard Name")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.permissionForm.guard_name,
      expression: "permissionForm.guard_name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "guard_name",
      name: "guard_name",
      required: "",
      autocomplete: "guard_name",
      autofocus: "",
      placeholder: "Guard Name"
    },
    domProps: {
      value: _vm.permissionForm.guard_name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.permissionForm, "guard_name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.permissionForm.errors.has("guard_name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.permissionForm.errors.get("guard_name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "description"
    }
  }, [_vm._v("Description")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.permissionForm.description,
      expression: "permissionForm.description"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "description",
      name: "description",
      required: "",
      autocomplete: "description",
      autofocus: "",
      placeholder: "Description"
    },
    domProps: {
      value: _vm.permissionForm.description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.permissionForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.permissionForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.permissionForm.errors.get("description"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer justify-content-between"
  }, [_c("b-button", {
    attrs: {
      type: "is-dark",
      size: "is-small",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _vm.editing ? _c("b-button", {
    attrs: {
      type: "is-primary",
      size: "is-small",
      loading: _vm.loading,
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.updatePermission();
      }
    }
  }, [_vm._v("Save")]) : _c("b-button", {
    attrs: {
      type: "is-primary",
      size: "is-small",
      loading: _vm.loading,
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.createPermission();
      }
    }
  }, [_vm._v("Create New Permission")])], 1)])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/permissions/addupdate.vue":
/*!******************************************************!*\
  !*** ./resources/js/views/permissions/addupdate.vue ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=9dc17420&scoped=true& */ "./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "9dc17420",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/permissions/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true& ***!
  \*************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_9dc17420_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=9dc17420&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/permissions/addupdate.vue?vue&type=template&id=9dc17420&scoped=true&");


/***/ })

}]);