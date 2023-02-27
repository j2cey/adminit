"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_settings_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _settingBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./settingBus */ "./resources/js/views/settings/settingBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var Setting = /*#__PURE__*/_createClass(function Setting(setting) {
  _classCallCheck(this, Setting);
  this.name = setting.name || '';
  this.type = setting.type || '';
  this.value = setting.value || '';
  this.array_sep = setting.array_sep || '';
  this.group = setting.group || '';
  this.full_path = setting.full_path || '';
  this.description = setting.description || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "setting-addupdate",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    _settingBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('setting_edit', function (setting) {
      _this.editing = true;
      _this.setting = new Setting(setting);
      _this.settingForm = new Form(_this.setting);
      _this.settingId = setting.id;
      _this.formTitle = 'Edit Setting';
      $('#addUpdateSetting').modal();
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/settings.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.groups = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Create New Setting',
      setting: {},
      settingForm: new Form(new Setting({})),
      settingId: null,
      editing: false,
      loading: false,
      groups: []
    };
  },
  methods: {
    updateSetting: function updateSetting() {
      var _this3 = this;
      this.loading = true;
      this.settingForm.put("/settings/".concat(this.settingId)).then(function (setting) {
        _this3.loading = false;
        _this3.resetForm();
        $('#addUpdateSetting').modal('hide');
        _this3.$swal({
          html: '<small>Setting successfully updated !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _settingBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('setting_updated', setting);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateSetting').modal('hide');
    },
    resetForm: function resetForm() {
      this.settingForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
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
      id: "addUpdateSetting",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "settingModalLabel",
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
      id: "settingModalLabel"
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
        return _vm.settingForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.name,
      expression: "settingForm.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "name",
      name: "name",
      placeholder: "Name",
      readonly: ""
    },
    domProps: {
      value: _vm.settingForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "type"
    }
  }, [_vm._v("Type")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.type,
      expression: "settingForm.type"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "type",
      name: "type",
      placeholder: "Type"
    },
    domProps: {
      value: _vm.settingForm.type
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "type", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("type") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("type"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "value"
    }
  }, [_vm._v("Value")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.value,
      expression: "settingForm.value"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "value",
      name: "value",
      placeholder: "Value"
    },
    domProps: {
      value: _vm.settingForm.value
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "value", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("value") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("value"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "array_sep"
    }
  }, [_vm._v("Array Separator")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.array_sep,
      expression: "settingForm.array_sep"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "array_sep",
      name: "array_sep",
      placeholder: "Array Separator"
    },
    domProps: {
      value: _vm.settingForm.array_sep
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "array_sep", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("array_sep") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("array_sep"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_group"
    }
  }, [_vm._v("Group")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_group",
      "selected.sync": "subjectForm.group",
      value: "",
      options: _vm.groups,
      searchable: true,
      multiple: false,
      label: "full_path",
      "track-by": "id",
      placeholder: "Group"
    },
    model: {
      value: _vm.settingForm.group,
      callback: function callback($$v) {
        _vm.$set(_vm.settingForm, "group", $$v);
      },
      expression: "settingForm.group"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "description"
    }
  }, [_vm._v("Description")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.description,
      expression: "settingForm.description"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "description",
      name: "description",
      placeholder: "Description"
    },
    domProps: {
      value: _vm.settingForm.description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("description"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs text-xs",
    attrs: {
      "for": "value"
    }
  }, [_vm._v("Full Path")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.settingForm.full_path,
      expression: "settingForm.full_path"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "full_path",
      name: "full_path",
      placeholder: "Full Path",
      readonly: ""
    },
    domProps: {
      value: _vm.settingForm.full_path
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.settingForm, "full_path", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.settingForm.errors.has("full_path") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.settingForm.errors.get("full_path"))
    }
  }) : _vm._e()])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer justify-content-between"
  }, [_c("button", {
    staticClass: "btn btn-secondary btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.closeModal
    }
  }, [_vm._v("Close")]), _vm._v(" "), _vm.editing ? _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      type: "button",
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.updateSetting();
      }
    }
  }, [_vm._v("Save")]) : _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      type: "button",
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.createSetting();
      }
    }
  }, [_vm._v("Create New Setting")])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/settings/settingBus.js":
/*!***************************************************!*\
  !*** ./resources/js/views/settings/settingBus.js ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/settings/addupdate.vue":
/*!***************************************************!*\
  !*** ./resources/js/views/settings/addupdate.vue ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=79939c06&scoped=true& */ "./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "79939c06",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/settings/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true& ***!
  \**********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_79939c06_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=79939c06&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/settings/addupdate.vue?vue&type=template&id=79939c06&scoped=true&");


/***/ })

}]);