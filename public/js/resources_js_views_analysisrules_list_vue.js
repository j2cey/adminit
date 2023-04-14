"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_analysisrules_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _analysisruleBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./analysisruleBus */ "./resources/js/views/analysisrules/analysisruleBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var AnalysisRule = /*#__PURE__*/_createClass(function AnalysisRule(analysisrule) {
  _classCallCheck(this, AnalysisRule);
  this.title = analysisrule.title || '';
  this.rule_result_for_notification = analysisrule.rule_result_for_notification || '';
  this.description = analysisrule.description || '';
  this.analysisruletype = analysisrule.analysisruletype || '';
  this.model_type = analysisrule.model_type || '';
  this.model_id = analysisrule.model_id || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "analysisrule-list",
  props: {
    model_prop: {}
  },
  components: {
    AnalysisRuleItem: function AnalysisRuleItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_analysisrules_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../analysisrules/item */ "./resources/js/views/analysisrules/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _analysisruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('analysisrule_created', function (analysisrule) {
      console.log('analysisrule_created received from rulelist', analysisrule);
      if (_this.attributeId === analysisrule.dynamic_attribute_id) {
        _this.addRuleToList(analysisrule);
      }
    });
    this.$on('analysisrule_deleted', function (_ref) {
      var analysisrule = _ref.analysisrule,
        index = _ref.index;
      if (_this.attributeId === analysisrule.dynamic_attribute_id) {
        _this.analysisrules.splice(index, 1);
      }
    });
  },
  created: function created() {
    var _this2 = this;
    // eslint-disable-next-line no-undef
    axios.get('/analysisruletypes.fetchall').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.analysisruletypes = data;
    });
    // eslint-disable-next-line no-undef
    axios.get('/ruleresultenums.fetch').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.ruleresultenums = data;
    });
  },
  data: function data() {
    return {
      attributeId: this.attributeid_prop,
      analysisrules: this.model_prop.analysisrules,
      analysisRuleForm: this.getNewanalysisRuleForm(),
      analysisruletypes: [],
      ruleresultenums: [],
      creating: false,
      editing: false,
      loading: false
    };
  },
  methods: {
    getNewanalysisRuleForm: function getNewanalysisRuleForm() {
      // eslint-disable-next-line no-undef
      return new Form(new AnalysisRule({
        'model_type': this.model_prop.model_type,
        'model_id': this.model_prop.id
      }));
    },
    resetFom: function resetFom() {
      this.analysisRuleForm = this.getNewanalysisRuleForm();
    },
    toggleCreating: function toggleCreating(creating) {
      this.creating = !creating;
    },
    createAnalysisRule: function createAnalysisRule() {
      var _this3 = this;
      this.loading = true;
      this.analysisRuleForm.post('/analysisrules').then(function (newanalysisrule) {
        _this3.loading = false;
        _this3.$swal({
          html: '<small>Règle créée avec succès! <br> Prière de compléter les valeurs.</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _analysisruleBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('analysisrule_created', newanalysisrule);
          _this3.addAnalysisRuleToList(newanalysisrule);
          _this3.resetFom();
        });

        // eslint-disable-next-line no-unused-vars
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    addAnalysisRuleToList: function addAnalysisRuleToList(analysisrule) {
      var analysisruleIndex = this.analysisrules.findIndex(function (c) {
        return analysisrule.id === c.id;
      });
      // si cette rule n'existe pas déjà, on l'insère dans la liste
      if (analysisruleIndex === -1) {
        this.analysisrules.push(analysisrule);
      }
    },
    removeAnalysisRuleToList: function removeAnalysisRuleToList($event) {
      var analysisruleIndex = this.analysisrules.findIndex(function (c) {
        return $event.id === c.id;
      });
      if (analysisruleIndex > -1) {
        this.analysisrules.splice(analysisruleIndex, 1);
        this.$swal({
          html: '<small>Règle supprimée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {});
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true& ***!
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
  return _c("section", [_c("b-field", {
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-black text-xs"
        }, [_vm._v("Règles d'Analyse\n                "), _c("b-button", {
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
      type: _vm.analysisRuleForm.errors.has("analysisruletype") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.analysisRuleForm.errors.has("analysisruletype"),
      label: _vm.analysisRuleForm.errors.get("analysisruletype"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-select", {
    attrs: {
      size: "is-small",
      placeholder: "Type de Règle",
      name: "analysisruletype",
      expanded: ""
    },
    model: {
      value: _vm.analysisRuleForm.analysisruletype,
      callback: function callback($$v) {
        _vm.$set(_vm.analysisRuleForm, "analysisruletype", $$v);
      },
      expression: "analysisRuleForm.analysisruletype"
    }
  }, _vm._l(_vm.analysisruletypes, function (option) {
    return _c("option", {
      key: option.id,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                        " + _vm._s(option.name) + "\n                    ")]);
  }), 0)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.analysisRuleForm.errors.has("title") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.analysisRuleForm.errors.has("title"),
      label: _vm.analysisRuleForm.errors.get("title"),
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
      value: _vm.analysisRuleForm.title,
      callback: function callback($$v) {
        _vm.$set(_vm.analysisRuleForm, "title", $$v);
      },
      expression: "analysisRuleForm.title"
    }
  })], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.analysisRuleForm.errors.has("rule_result_for_notification") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.analysisRuleForm.errors.has("rule_result_for_notification"),
      label: _vm.analysisRuleForm.errors.get("rule_result_for_notification"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-select", {
    attrs: {
      size: "is-small",
      placeholder: "Résultat pour Notification",
      name: "rule_result_for_notification"
    },
    model: {
      value: _vm.analysisRuleForm.rule_result_for_notification,
      callback: function callback($$v) {
        _vm.$set(_vm.analysisRuleForm, "rule_result_for_notification", $$v);
      },
      expression: "analysisRuleForm.rule_result_for_notification"
    }
  }, _vm._l(_vm.ruleresultenums, function (option) {
    return _c("option", {
      key: option.value,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                        " + _vm._s(option.name) + "\n                    ")]);
  }), 0)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.analysisRuleForm.errors.has("description") ? "is-danger" : "is-default",
      expanded: ""
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.analysisRuleForm.errors.has("description"),
      label: _vm.analysisRuleForm.errors.get("description"),
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
      value: _vm.analysisRuleForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.analysisRuleForm, "description", $$v);
      },
      expression: "analysisRuleForm.description"
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
        return _vm.createAnalysisRule();
      }
    }
  })], 1)], 1) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "box"
  }, _vm._l(_vm.analysisrules, function (analysisrule) {
    return _c("AnalysisRuleItem", {
      key: analysisrule.uuid,
      attrs: {
        analysisrule_prop: analysisrule
      },
      on: {
        analysisrule_deleted: _vm.removeAnalysisRuleToList
      }
    });
  }), 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/analysisrules/list.vue":
/*!***************************************************!*\
  !*** ./resources/js/views/analysisrules/list.vue ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=ace4665e&scoped=true& */ "./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "ace4665e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/analysisrules/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true& ***!
  \**********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_ace4665e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=ace4665e&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/analysisrules/list.vue?vue&type=template&id=ace4665e&scoped=true&");


/***/ })

}]);