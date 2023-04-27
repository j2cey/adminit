"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_selectedretrieveactions_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _selectedretrieveactionBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectedretrieveactionBus */ "./resources/js/views/selectedretrieveactions/selectedretrieveactionBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


// eslint-disable-next-line no-unused-vars
var SelectedRetrieveAction = /*#__PURE__*/_createClass(function SelectedRetrieveAction(selectedretrieveaction) {
  _classCallCheck(this, SelectedRetrieveAction);
  this.actionvalue_valuetype = selectedretrieveaction.actionvalue_valuetype || '';
  this.actionvalue_label = selectedretrieveaction.actionvalue_label || '';
  this.description = selectedretrieveaction.description || '';
  this.retrieveaction = selectedretrieveaction.retrieveaction || '';
  this.selectedretrieveaction = selectedretrieveaction.selectedretrieveaction || '';
  this.model_id = selectedretrieveaction.model_id || '';
  this.model_type = selectedretrieveaction.model_type || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "list",
  props: {
    model_prop: {}
  },
  components: {
    SelectedRetrieveActionItem: function SelectedRetrieveActionItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_selectedretrieveactions_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../selectedretrieveactions/item */ "./resources/js/views/selectedretrieveactions/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _selectedretrieveactionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('selectedretrieveaction_created', function (selectedretrieveaction) {
      console.log('selectedretrieveaction_created received from actionlist', selectedretrieveaction);
      if (_this.attributeId === selectedretrieveaction.dynamic_attribute_id) {
        _this.addRuleToList(selectedretrieveaction);
      }
    });
    this.$on('selectedretrieveaction_deleted', function (_ref) {
      var selectedretrieveaction = _ref.selectedretrieveaction,
        index = _ref.index;
      if (_this.attributeId === selectedretrieveaction.dynamic_attribute_id) {
        _this.selectedretrieveactions.splice(index, 1);
      }
    });
  },
  created: function created() {
    var _this2 = this;
    // eslint-disable-next-line no-undef
    axios.get('/retrieveactions.fetch').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.retrieveactions = data;
    });
    // eslint-disable-next-line no-undef
    axios.get('/valuetypeenums.fetch').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.valuetypeenums = data;
    });
  },
  data: function data() {
    return {
      attributeId: this.attributeid_prop,
      selectedretrieveactions: this.model_prop.selectedretrieveactions,
      selectedRetrieveActionForm: this.getNewselectedRetrieveActionForm(),
      retrieveactions: [],
      valuetypeenums: [],
      creating: false,
      editing: false,
      loading: false
    };
  },
  methods: {
    getNewselectedRetrieveActionForm: function getNewselectedRetrieveActionForm() {
      // eslint-disable-next-line no-undef
      return new Form(new SelectedRetrieveAction({
        'model_type': this.model_prop.model_type,
        'model_id': this.model_prop.id
      }));
    },
    resetFom: function resetFom() {
      this.selectedRetrieveActionForm = this.getNewselectedRetrieveActionForm();
    },
    toggleCreating: function toggleCreating(creating) {
      this.creating = !creating;
    },
    createSelectedRetrieveAction: function createSelectedRetrieveAction() {
      var _this3 = this;
      this.loading = true;
      this.selectedRetrieveActionForm.post('/selectedretrieveactions').then(function (newselectedretrieveaction) {
        _this3.loading = false;
        _this3.$swal({
          html: '<small>Action créée avec succès! <br> Prière de compléter les valeurs.</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _selectedretrieveactionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('selectedretrieveaction_created', newselectedretrieveaction);
          _this3.addSelectedRetrieveActionToList(newselectedretrieveaction);
          _this3.resetFom();
        });

        // eslint-disable-next-line no-unused-vars
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    addSelectedRetrieveActionToList: function addSelectedRetrieveActionToList(selectedretrieveaction) {
      var selectedretrieveactionIndex = this.selectedretrieveactions.findIndex(function (c) {
        return selectedretrieveaction.id === c.id;
      });
      // si cette action n'existe pas déjà, on l'insère dans la liste
      if (selectedretrieveactionIndex === -1) {
        this.selectedretrieveactions.push(selectedretrieveaction);
      }
    },
    removeSelectedRetrieveActionToList: function removeSelectedRetrieveActionToList($event) {
      var selectedretrieveactionIndex = this.selectedretrieveactions.findIndex(function (c) {
        return $event.id === c.id;
      });
      if (selectedretrieveactionIndex > -1) {
        this.selectedretrieveactions.splice(selectedretrieveactionIndex, 1);
        this.$swal({
          html: '<small>Action supprimée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {});
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
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
        }, [_vm._v("Ajouter\n                "), _c("b-button", {
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
      type: _vm.selectedRetrieveActionForm.errors.has("retrieveaction") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.selectedRetrieveActionForm.errors.has("retrieveaction"),
      label: _vm.selectedRetrieveActionForm.errors.get("retrieveaction"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-select", {
    attrs: {
      size: "is-small",
      placeholder: "actions",
      name: "retrieveaction",
      expanded: ""
    },
    model: {
      value: _vm.selectedRetrieveActionForm.retrieveaction,
      callback: function callback($$v) {
        _vm.$set(_vm.selectedRetrieveActionForm, "retrieveaction", $$v);
      },
      expression: "selectedRetrieveActionForm.retrieveaction"
    }
  }, _vm._l(_vm.retrieveactions, function (option) {
    return _c("option", {
      key: option.id,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                        " + _vm._s(option.name) + "\n                    ")]);
  }), 0)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.selectedRetrieveActionForm.errors.has("actionvalue_valuetype") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.selectedRetrieveActionForm.errors.has("actionvalue_valuetype"),
      label: _vm.selectedRetrieveActionForm.errors.get("actionvalue_valuetype"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-select", {
    attrs: {
      size: "is-small",
      placeholder: "Type de valeur",
      name: "actionvalue_valuetype"
    },
    model: {
      value: _vm.selectedRetrieveActionForm.actionvalue_valuetype,
      callback: function callback($$v) {
        _vm.$set(_vm.selectedRetrieveActionForm, "actionvalue_valuetype", $$v);
      },
      expression: "selectedRetrieveActionForm.actionvalue_valuetype"
    }
  }, _vm._l(_vm.valuetypeenums, function (option) {
    return _c("option", {
      key: option.value,
      domProps: {
        value: option
      }
    }, [_vm._v("\n                        " + _vm._s(option.name) + "\n                    ")]);
  }), 0)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.selectedRetrieveActionForm.errors.has("actionvalue_label") ? "is-danger" : "is-default",
      expanded: ""
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.selectedRetrieveActionForm.errors.has("actionvalue_label"),
      label: _vm.selectedRetrieveActionForm.errors.get("actionvalue_label"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-input", {
    attrs: {
      size: "is-small",
      placeholder: "Libellé",
      name: "actionvalue_label",
      expanded: ""
    },
    model: {
      value: _vm.selectedRetrieveActionForm.actionvalue_label,
      callback: function callback($$v) {
        _vm.$set(_vm.selectedRetrieveActionForm, "actionvalue_label", $$v);
      },
      expression: "selectedRetrieveActionForm.actionvalue_label"
    }
  })], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.selectedRetrieveActionForm.errors.has("description") ? "is-danger" : "is-default",
      expanded: ""
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.selectedRetrieveActionForm.errors.has("description"),
      label: _vm.selectedRetrieveActionForm.errors.get("description"),
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
      value: _vm.selectedRetrieveActionForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.selectedRetrieveActionForm, "description", $$v);
      },
      expression: "selectedRetrieveActionForm.description"
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
        return _vm.createSelectedRetrieveAction();
      }
    }
  })], 1)], 1) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "box"
  }, _vm._l(_vm.selectedretrieveactions, function (selectedretrieveaction) {
    return _c("SelectedRetrieveActionItem", {
      key: selectedretrieveaction.uuid,
      attrs: {
        model_prop: selectedretrieveaction
      },
      on: {
        selectedretrieveaction_deleted: _vm.removeSelectedRetrieveActionToList
      }
    });
  }), 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/selectedretrieveactions/selectedretrieveactionBus.js":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/selectedretrieveactions/selectedretrieveactionBus.js ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());
/// Permet de faciliter la communication entre composants enfants.

/***/ }),

/***/ "./resources/js/views/selectedretrieveactions/list.vue":
/*!*************************************************************!*\
  !*** ./resources/js/views/selectedretrieveactions/list.vue ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=4445e6c6&scoped=true& */ "./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "4445e6c6",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/selectedretrieveactions/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true& ***!
  \********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_4445e6c6_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=4445e6c6&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/selectedretrieveactions/list.vue?vue&type=template&id=4445e6c6&scoped=true&");


/***/ })

}]);