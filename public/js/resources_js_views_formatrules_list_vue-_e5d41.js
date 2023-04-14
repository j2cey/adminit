"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_formatrules_list_vue-_e5d41"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=script&lang=js& ***!
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
  this.model_type = formatrule.model_type || '';
  this.model_id = formatrule.model_id || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "formatrule-list",
  props: {
    model_prop: {}
  },
  components: {
    FormatRuleItem: function FormatRuleItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_formatrules_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./item */ "./resources/js/views/formatrules/item.vue"));
    }
  },
  created: function created() {
    var _this = this;
    axios.get('/formatruletypes.fetchall').then(function (_ref) {
      var data = _ref.data;
      return _this.formatruletypes = data;
    });
  },
  data: function data() {
    return {
      model: this.model_prop,
      formatruletypes: [],
      filteredFormatRuleTypes: [],
      formatRuleForm: this.getNewformatRuleForm(),
      formatrules: this.model_prop.formatrules,
      creating: false,
      loading: false,
      allowNew: false,
      openOnFocus: true
    };
  },
  methods: {
    getNewformatRuleForm: function getNewformatRuleForm() {
      return new Form(new FormatRule({
        'model_type': this.model_prop.model_type,
        'model_id': this.model_prop.id
      }));
    },
    addFormatRuleToList: function addFormatRuleToList(formatrule) {
      var formatruleIndex = this.formatrules.findIndex(function (c) {
        return formatrule.id === c.id;
      });

      // if this format rule doesn't exists in the list
      if (formatruleIndex === -1) {
        this.formatrules.push(formatrule);
      }
    },
    removeFormatRuleToList: function removeFormatRuleToList($event) {
      var formatruleIndex = this.formatrules.findIndex(function (c) {
        return $event.id === c.id;
      });
      if (formatruleIndex > -1) {
        this.formatrules.splice(formatruleIndex, 1);
        this.$swal({
          html: '<small>Règle supprimée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {});
      }
    },
    resetFom: function resetFom() {
      this.formatRuleForm = this.getNewformatRuleForm();
    },
    toggleCreating: function toggleCreating(creating) {
      this.creating = !creating;
    },
    createFormatRule: function createFormatRule() {
      var _this2 = this;
      this.loading = true;
      this.formatRuleForm.post('/formatrules').then(function (newformatrule) {
        _this2.loading = false;
        _this2.$swal({
          html: '<small>Règle créée avec succès! <br> Prière de compléter les valeurs.</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _formatrules_formatruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('formatrule_created', newformatrule);
          _this2.addFormatRuleToList(newformatrule);
          _this2.resetFom();
        });
      })["catch"](function (error) {
        _this2.loading = false;
      });
    },
    getFilteredFormatRuleTypes: function getFilteredFormatRuleTypes(text) {
      this.filteredFormatRuleTypes = this.formatruletypes.filter(function (option) {
        return option.name.toString().toLowerCase().indexOf(text.toLowerCase()) >= 0;
      });
    }
  },
  computed: {
    formatruletype_has_error: function formatruletype_has_error() {
      return this.formatRuleForm.errors.has('formatruletype') || this.formatRuleForm.errors.has('formatruletype_key');
    },
    formatruletype_error_msg: function formatruletype_error_msg() {
      return this.formatRuleForm.errors.get('formatruletype') || this.formatRuleForm.errors.get('formatruletype_key');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true& ***!
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
  return _c("section", [_c("b-field", {
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-black text-xs"
        }, [_vm._v("Règles de Formattage\n                "), _c("b-button", {
          attrs: {
            type: "is-info is-light",
            size: "is-small"
          },
          on: {
            click: function click($event) {
              return _vm.toggleCreating(_vm.creating);
            }
          }
        }, [_c("b-icon", {
          attrs: {
            pack: "fa",
            icon: "plus",
            size: "is-small"
          }
        })], 1)], 1)];
      },
      proxy: true
    }])
  }), _vm._v(" "), _vm.creating ? _c("b-field", [_c("b-field", {
    attrs: {
      type: _vm.formatruletype_has_error ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.formatruletype_has_error,
      label: _vm.formatruletype_error_msg,
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-select", {
    attrs: {
      size: "is-small",
      placeholder: "Type de Règle",
      name: "formatruletype"
    },
    model: {
      value: _vm.formatRuleForm.formatruletype,
      callback: function callback($$v) {
        _vm.$set(_vm.formatRuleForm, "formatruletype", $$v);
      },
      expression: "formatRuleForm.formatruletype"
    }
  }, _vm._l(_vm.formatruletypes, function (option) {
    return _c("option", {
      key: option.id,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                        " + _vm._s(option.name) + "\n                    ")]);
  }), 0)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.formatRuleForm.errors.has("title") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.formatRuleForm.errors.has("title"),
      label: _vm.formatRuleForm.errors.get("title"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      placeholder: "Titre",
      name: "title"
    },
    model: {
      value: _vm.formatRuleForm.title,
      callback: function callback($$v) {
        _vm.$set(_vm.formatRuleForm, "title", $$v);
      },
      expression: "formatRuleForm.title"
    }
  })], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.formatRuleForm.errors.has("description") ? "is-danger" : "is-default",
      expanded: ""
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.formatRuleForm.errors.has("description"),
      label: _vm.formatRuleForm.errors.get("description"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      placeholder: "Description",
      name: "description",
      expanded: ""
    },
    model: {
      value: _vm.formatRuleForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.formatRuleForm, "description", $$v);
      },
      expression: "formatRuleForm.description"
    }
  })], 1)], 1), _vm._v(" "), _c("p", {
    staticClass: "control"
  }, [_c("b-button", {
    attrs: {
      size: "is-small",
      type: "is-success",
      loading: _vm.loading,
      label: "Valider"
    },
    on: {
      click: function click($event) {
        return _vm.createFormatRule();
      }
    }
  })], 1)], 1) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "box"
  }, _vm._l(_vm.formatrules, function (formatrule) {
    return _c("FormatRuleItem", {
      key: formatrule.uuid,
      attrs: {
        formatrule_prop: formatrule
      },
      on: {
        formatrule_deleted: _vm.removeFormatRuleToList
      }
    });
  }), 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/formatrules/list.vue":
/*!*************************************************!*\
  !*** ./resources/js/views/formatrules/list.vue ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=3f75046c&scoped=true& */ "./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/formatrules/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3f75046c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/formatrules/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/formatrules/list.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/views/formatrules/list.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true& ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3f75046c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=3f75046c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/formatrules/list.vue?vue&type=template&id=3f75046c&scoped=true&");


/***/ })

}]);