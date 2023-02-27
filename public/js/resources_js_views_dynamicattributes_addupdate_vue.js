"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_dynamicattributes_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _attributeBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./attributeBus */ "./resources/js/views/dynamicattributes/attributeBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var Dynamicattribute = /*#__PURE__*/_createClass(function Dynamicattribute(dynamicattribute) {
  _classCallCheck(this, Dynamicattribute);
  this.name = dynamicattribute.name || '';
  this.attributetype = dynamicattribute.attributetype || '';
  this.description = dynamicattribute.description || '';
  this.model_type = dynamicattribute.model_type || '';
  this.model_id = dynamicattribute.model_id || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "dynamicattribute-addupdate",
  props: {},
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    _attributeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('create_new_dynamicattribute', function (_ref) {
      var model_type = _ref.model_type,
        model_id = _ref.model_id;
      _this.editing = false;
      _this.dynamicattribute = new Dynamicattribute({});
      _this.dynamicattributeForm = new Form(_this.dynamicattribute);
      _this.dynamicattributeForm.model_type = model_type;
      _this.dynamicattributeForm.model_id = model_id;
      _this.formTitle = 'Create New Attribute';
      $('#addUpdateDynamicattribute').modal();
    });
    _attributeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('edit_dynamicattribute', function (_ref2) {
      var attribute = _ref2.attribute;
      _this.editing = true;
      _this.dynamicattribute = new Dynamicattribute(attribute);
      _this.dynamicattributeForm = new Form(_this.dynamicattribute);
      _this.dynamicattributeId = attribute.uuid;
      _this.formTitle = 'Edit Attribute';
      $('#addUpdateDynamicattribute').modal();
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/dynamicattributetypes.fetchall').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.attributetypes = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Create Attribute',
      dynamicattribute: {},
      dynamicattributeForm: new Form(new Dynamicattribute({})),
      dynamicattributeId: null,
      editing: false,
      loading: false,
      attributetypes: []
    };
  },
  methods: {
    formKeyEnter: function formKeyEnter() {
      if (this.editing) {
        this.updateDynamicattribute();
      } else {
        this.createDynamicattribute();
      }
    },
    createDynamicattribute: function createDynamicattribute() {
      var _this3 = this;
      this.loading = true;
      this.dynamicattributeForm.post('/dynamicattributes').then(function (newdynamicattribute) {
        _this3.loading = false;
        _this3.$swal({
          html: '<small>Attribute successfully created !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _attributeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('dynamicattribute_created', newdynamicattribute);
          $('#addUpdateDynamicattribute').modal('hide');
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateDynamicattribute: function updateDynamicattribute() {
      var _this4 = this;
      this.loading = true;
      this.dynamicattributeForm.put("/dynamicattributes/".concat(this.dynamicattributeId), undefined).then(function (upddynamicattribute) {
        _this4.loading = false;
        _this4.$swal({
          html: '<small>Attribute successfully updated !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _attributeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('dynamicattribute_updated', upddynamicattribute);
          $('#addUpdateDynamicattribute').modal('hide');
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    }
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc& ***!
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
      id: "addUpdateDynamicattribute",
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
      id: "dynamicattributeModalLabel"
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
        return _vm.dynamicattributeForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "dynamicattribute_name"
    }
  }, [_vm._v("Name")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.dynamicattributeForm.name,
      expression: "dynamicattributeForm.name"
    }],
    staticClass: "form-control text-xs",
    attrs: {
      type: "text",
      id: "dynamicattribute_name",
      name: "name",
      autocomplete: "name",
      autofocus: "",
      placeholder: "Name"
    },
    domProps: {
      value: _vm.dynamicattributeForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.dynamicattributeForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.dynamicattributeForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.dynamicattributeForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "m_select_dynamicattributetype"
    }
  }, [_vm._v("Attribute Type")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10 text-xs"
  }, [_c("multiselect", {
    key: "id",
    staticClass: "text text-xs",
    attrs: {
      id: "m_select_dynamicattributetype",
      "selected.sync": "dynamicattributeForm.attributetype",
      value: "",
      options: _vm.attributetypes,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Attribute Type"
    },
    model: {
      value: _vm.dynamicattributeForm.attributetype,
      callback: function callback($$v) {
        _vm.$set(_vm.dynamicattributeForm, "attributetype", $$v);
      },
      expression: "dynamicattributeForm.attributetype"
    }
  }), _vm._v(" "), _vm.dynamicattributeForm.errors.has("dynamicattributetype") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.dynamicattributeForm.errors.get("dynamicattributetype"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
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
      value: _vm.dynamicattributeForm.description,
      expression: "dynamicattributeForm.description"
    }],
    staticClass: "form-control text-xs",
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
      value: _vm.dynamicattributeForm.description
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.formKeyEnter();
      },
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.dynamicattributeForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.dynamicattributeForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.dynamicattributeForm.errors.get("description"))
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
      disabled: !_vm.isValidCreateForm
    },
    on: {
      click: function click($event) {
        return _vm.updateDynamicattribute();
      }
    }
  }, [_vm._v("Save")]) : _c("b-button", {
    attrs: {
      type: "is-primary",
      size: "is-small",
      loading: _vm.loading,
      disabled: !_vm.isValidCreateForm
    },
    on: {
      click: function click($event) {
        return _vm.createDynamicattribute();
      }
    }
  }, [_vm._v("Create Attribute")])], 1)])])]);
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

/***/ "./resources/js/views/dynamicattributes/addupdate.vue":
/*!************************************************************!*\
  !*** ./resources/js/views/dynamicattributes/addupdate.vue ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=012a7bfc& */ "./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/dynamicattributes/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc& ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_012a7bfc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=012a7bfc& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/dynamicattributes/addupdate.vue?vue&type=template&id=012a7bfc&");


/***/ })

}]);