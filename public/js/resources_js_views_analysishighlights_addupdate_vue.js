"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_analysishighlights_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _analysishighlightBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./analysishighlightBus */ "./resources/js/views/analysishighlights/analysishighlightBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var Highlight = /*#__PURE__*/_createClass(function Highlight(highlight) {
  _classCallCheck(this, Highlight);
  this.title = highlight.title || '';
  this.highlighttype = highlight.highlighttype || '';
  this.description = highlight.description || '';
  this.analysis_rule_id = highlight.analysis_rule_id || '';
  this.rule_result = highlight.rule_result || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "highlight-addupdate",
  props: {},
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    this.$parent.$on('create_new_highlight', function (_ref) {
      var analysisrule = _ref.analysisrule;
      console.log('create_new_highlight received: ', analysisrule);
      _this.editing = false;
      _this.highlight = new Highlight({});
      _this.highlight.analysis_rule_id = analysisrule.id;
      _this.highlightForm = new Form(_this.highlight);
      console.log('form ready: ', _this.highlightForm);
      _this.formTitle = 'Create New Highlight';
      $('#addUpdateHighlight').modal();
    });
    this.$parent.$on('edit_highlight', function (_ref2) {
      var highlight = _ref2.highlight;
      _this.editing = true;
      _this.highlight = new Highlight(highlight);
      _this.highlightForm = new Form(_this.highlight);
      _this.highlightId = highlight.uuid;
      _this.formTitle = 'Edit Highlight';
      $('#addUpdateHighlight').modal();
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/analysishighlighttypes.fetchall').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.highlighttypes = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Create Highlight',
      analysisrule: {},
      rule_result: "",
      highlight: {},
      highlightForm: new Form(new Highlight({})),
      highlightId: null,
      editing: false,
      loading: false,
      highlighttypes: []
    };
  },
  methods: {
    formKeyEnterDown: function formKeyEnterDown() {
      if (this.editing) {
        this.updateHighlight();
      } else {
        this.createHighlight();
      }
    },
    createHighlight: function createHighlight() {
      var _this3 = this;
      this.loading = true;

      //this.highlightForm.analysis_rule_id = this.highlight.analysis_rule_id
      //this.highlightForm.when_rule_result_is = this.when_rule_result_is

      console.log('form to post: ', this.highlightForm);
      this.highlightForm.post('/analysishighlights').then(function (highlight) {
        _this3.loading = false;
        _this3.$swal({
          html: '<small>Highlight successfully created !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _this3.$parent.$emit('highlight_created', highlight);
          $('#addUpdateHighlight').modal('hide');
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateHighlight: function updateHighlight() {
      var _this4 = this;
      this.loading = true;
      this.highlightForm.put("/analysishighlights/".concat(this.highlightId), undefined).then(function (highlight) {
        _this4.loading = false;
        console.log('analysishighlights updated result', highlight);
        _this4.$swal({
          html: '<small>Highlight successfully updated !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _this4.$parent.$emit('highlight_updated', highlight);
          $('#addUpdateHighlight').modal('hide');
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************/
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
      id: "addUpdateHighlight",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "highlightModalLabel",
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
      id: "highlightModalLabel"
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
        return _vm.highlightForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "highlight_title"
    }
  }, [_vm._v("Title")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.highlightForm.title,
      expression: "highlightForm.title"
    }],
    staticClass: "form-control text-xs",
    attrs: {
      type: "text",
      id: "highlight_title",
      name: "title",
      autocomplete: "title",
      autofocus: "",
      placeholder: "Titre"
    },
    domProps: {
      value: _vm.highlightForm.title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.highlightForm, "title", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.highlightForm.errors.has("title") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.highlightForm.errors.get("title"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "when_rule_result_is"
    }
  }, [_vm._v("When Rule result is")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("b-field", {
    attrs: {
      id: "when_rule_result_is"
    }
  }, [_c("b-select", {
    attrs: {
      name: "when_rule_result_is",
      placeholder: "Small",
      size: "is-small"
    },
    model: {
      value: _vm.highlightForm.when_rule_result_is,
      callback: function callback($$v) {
        _vm.$set(_vm.highlightForm, "when_rule_result_is", $$v);
      },
      expression: "highlightForm.when_rule_result_is"
    }
  }, [_c("option", {
    attrs: {
      value: "allowed"
    }
  }, [_vm._v("Allowed")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "broken"
    }
  }, [_vm._v("Broken")])])], 1)], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "m_select_highlighttype"
    }
  }, [_vm._v("Highlight Type")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8 text-xs"
  }, [_c("multiselect", {
    key: "id",
    staticClass: "text text-xs",
    attrs: {
      id: "m_select_highlighttype",
      "selected.sync": "highlightForm.highlighttype",
      value: "",
      options: _vm.highlighttypes,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Highlight Type"
    },
    model: {
      value: _vm.highlightForm.highlighttype,
      callback: function callback($$v) {
        _vm.$set(_vm.highlightForm, "highlighttype", $$v);
      },
      expression: "highlightForm.highlighttype"
    }
  }), _vm._v(" "), _vm.highlightForm.errors.has("highlighttype") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.highlightForm.errors.get("highlighttype"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "highlight_description"
    }
  }, [_vm._v("Description")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.highlightForm.description,
      expression: "highlightForm.description"
    }],
    staticClass: "form-control text-xs",
    attrs: {
      type: "text",
      id: "highlight_description",
      name: "description",
      required: "",
      autocomplete: "description",
      autofocus: "",
      placeholder: "Description"
    },
    domProps: {
      value: _vm.highlightForm.description
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.formKeyEnterDown();
      },
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.highlightForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.highlightForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.highlightForm.errors.get("description"))
    }
  }) : _vm._e()])])])]), _vm._v(" "), _c("div", {
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
        return _vm.updateHighlight();
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
        return _vm.createHighlight();
      }
    }
  }, [_vm._v("Create Highlight")])], 1)])])]);
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

/***/ "./resources/js/views/analysishighlights/addupdate.vue":
/*!*************************************************************!*\
  !*** ./resources/js/views/analysishighlights/addupdate.vue ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=af4ccd96& */ "./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null

)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/analysishighlights/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

/***/ }),

/***/ "./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96& ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_af4ccd96___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=af4ccd96& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysishighlights/addupdate.vue?vue&type=template&id=af4ccd96&");


/***/ })

}]);
