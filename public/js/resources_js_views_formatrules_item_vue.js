"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_formatrules_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../formatrules/formatruleBus */ "./resources/js/views/formatrules/formatruleBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var FormatRule = /*#__PURE__*/_createClass(function FormatRule(formatrule) {
  _classCallCheck(this, FormatRule);
  this.title = formatrule.title || '';
  this.description = formatrule.description || '';
  this.formatruletype = formatrule.formatruletype || '';
  this.innerformatrule = formatrule.innerformatrule || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "formatrule-item",
  props: {
    formatrule_prop: {}
  },
  components: {
    formattextcolor: function formattextcolor() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_formatrules_innerformatrules_formattextcolor_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./innerformatrules/formattextcolor */ "./resources/js/views/formatrules/innerformatrules/formattextcolor.vue"));
    },
    formattextsize: function formattextsize() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_formatrules_innerformatrules_formattextsize_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./innerformatrules/formattextsize */ "./resources/js/views/formatrules/innerformatrules/formattextsize.vue"));
    },
    formattextweight: function formattextweight() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_formatrules_innerformatrules_formattextweight_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./innerformatrules/formattextweight */ "./resources/js/views/formatrules/innerformatrules/formattextweight.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    this.$watch("$refs.formatrule.innerformatrule",
    // eslint-disable-next-line no-unused-vars
    function (new_value, old_value) {
      _this.innerformatrule = new_value;
    });
  },
  data: function data() {
    return {
      formatrule: this.formatrule_prop,
      innerformatrule: this.formatrule_prop.innerformatrule,
      formatRuleForm: new Form(new FormatRule(this.formatrule_prop)),
      editing: false,
      loading: false
    };
  },
  methods: {
    editFormatRule: function editFormatRule(formatrule) {
      this.editing = true;
      _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('formatrule_edit', formatrule);
    },
    cancelEditFormatRule: function cancelEditFormatRule(formatrule) {
      this.editing = false;
      this.loading = false;
      _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('formatrule_edit_cancel', formatrule);
    },
    setFormatRuleUpdated: function setFormatRuleUpdated(formatrule) {
      this.formatRuleForm = new Form(new FormatRule(formatrule));
      this.cancelEditFormatRule(formatrule);
    },
    updateFormatRule: function updateFormatRule(formatrule) {
      var _this2 = this;
      this.loading = true;
      _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('formatrule_updating', formatrule);
      this.formatRuleForm.innerformatrule = this.innerformatrule;
      this.formatRuleForm.put("/formatrules/".concat(this.formatrule.uuid), undefined).then(function (formatrule) {
        _this2.loading = false;
        _this2.$swal({
          html: '<small>Règle modifiée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _this2.loading = false;
          _this2.setFormatRuleUpdated(formatrule);
          _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('formatrule_updated', formatrule);
        });
      })["catch"](function (error) {
        _this2.loading = false;
        _this2.cancelEditFormatRule(formatrule);
      });
    },
    deleteFormatRule: function deleteFormatRule(formatrule) {
      var _this3 = this;
      this.$swal({
        title: 'Suppresion de la Règle',
        text: "Validez la Suppression!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui'
      }).then(function (result) {
        if (result.value) {
          _this3.loading = true;
          axios["delete"]("/formatrules/".concat(formatrule.uuid)).then(function (resp) {
            _this3.loading = false;
            _this3.$emit('formatrule_deleted', formatrule);
          })["catch"](function (error) {
            _this3.loading = false;
            window.handleErrors(error);
          });
        }
      });
    }
  },
  computed: {
    cantBeEdited: function cantBeEdited() {
      return !this.editing;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true& ***!
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
  return _c("b-field", {
    attrs: {
      size: "is-small",
      horizontal: ""
    },
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-primary text-xs"
        }, [_vm._v(_vm._s(_vm.formatrule.formatruletype.name))])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.formatRuleForm.errors.has("title") ? "is-danger" : "is-default"
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      name: "name",
      placeholder: "Titre",
      loading: _vm.loading,
      readonly: _vm.cantBeEdited
    },
    model: {
      value: _vm.formatRuleForm.title,
      callback: function callback($$v) {
        _vm.$set(_vm.formatRuleForm, "title", $$v);
      },
      expression: "formatRuleForm.title"
    }
  })], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.formatRuleForm.errors.has("description") ? "is-danger" : "is-default"
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      name: "description",
      loading: _vm.loading,
      readonly: _vm.cantBeEdited
    },
    model: {
      value: _vm.formatRuleForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.formatRuleForm, "description", $$v);
      },
      expression: "formatRuleForm.description"
    }
  })], 1), _vm._v(" "), _c(_vm.formatrule.formatruletype.view_name, {
    ref: _vm.formatrule.innerformatrule.id,
    tag: "component",
    attrs: {
      formatrule_prop: _vm.formatrule,
      model_type_prop: _vm.formatrule.innerformatrule_type,
      innerformatrule_prop: _vm.formatrule.innerformatrule
    }
  }), _vm._v(" "), _c("b-field", {
    staticClass: "text-xs"
  }, [!_vm.editing ? _c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-warning",
    on: {
      click: function click($event) {
        return _vm.editFormatRule(_vm.formatrule);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "pencil-square-o",
      size: "is-small"
    }
  })], 1) : _vm._e(), _vm._v(" "), _vm.editing ? _c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-success",
    on: {
      click: function click($event) {
        return _vm.updateFormatRule(_vm.formatrule);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "check",
      size: "is-small"
    }
  })], 1) : _vm._e(), _vm._v(" "), _vm.editing ? _c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-info",
    on: {
      click: function click($event) {
        return _vm.cancelEditFormatRule(_vm.formatrule);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "ban",
      size: "is-small"
    }
  })], 1) : _vm._e(), _vm._v(" "), _c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-danger",
    on: {
      click: function click($event) {
        return _vm.deleteFormatRule(_vm.formatrule);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "trash",
      size: "is-small"
    }
  })], 1)])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/formatrules/item.vue":
/*!*************************************************!*\
  !*** ./resources/js/views/formatrules/item.vue ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=356f8c61&scoped=true& */ "./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/formatrules/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "356f8c61",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/formatrules/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/formatrules/item.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/views/formatrules/item.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true& ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_356f8c61_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=356f8c61&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/item.vue?vue&type=template&id=356f8c61&scoped=true&");


/***/ })

}]);