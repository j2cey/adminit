"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_retrieveactionvalues_list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _retrieveactionvalueBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./retrieveactionvalueBus */ "./resources/js/views/retrieveactionvalues/retrieveactionvalueBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


// eslint-disable-next-line no-unused-vars
var RetrieveActionValue = /*#__PURE__*/_createClass(function RetrieveActionValue(retrieveactionvalue) {
  _classCallCheck(this, RetrieveActionValue);
  this.description = retrieveactionvalue.description || '';
  this.retrieveactionvalue = retrieveactionvalue.retrieveactionvalue || '';
  this.retrieveaction = retrieveactionvalue.retrieveaction || '';
  this.model_type = retrieveactionvalue.model_type || '';
  this.model_id = retrieveactionvalue.model_id || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "list",
  props: {
    model_prop: {}
  },
  components: {
    RetrieveActionValueItem: function RetrieveActionValueItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_retrieveactionvalues_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../retrieveactionvalues/item */ "./resources/js/views/retrieveactionvalues/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _retrieveactionvalueBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('retrieveactionvalue_created', function (retrieveactionvalue) {
      console.log('retrieveactionvalue_created received from actionlist', retrieveactionvalue);
      if (_this.attributeId === retrieveactionvalue.dynamic_attribute_id) {
        _this.addRuleToList(retrieveactionvalue);
      }
    });
    this.$on('retrieveactionvalue_deleted', function (_ref) {
      var retrieveactionvalue = _ref.retrieveactionvalue,
        index = _ref.index;
      if (_this.attributeId === retrieveactionvalue.dynamic_attribute_id) {
        _this.retrieveactionvalues.splice(index, 1);
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
  },
  data: function data() {
    return {
      attributeId: this.attributeid_prop,
      retrieveactionvalues: this.model_prop.retrieveactionvalues,
      retrieveActionValueForm: this.getNewretrieveActionValueForm(),
      retrieveactions: [],
      creating: false,
      editing: false,
      loading: false
    };
  },
  methods: {
    getNewretrieveActionValueForm: function getNewretrieveActionValueForm() {
      // eslint-disable-next-line no-undef
      return new Form(new RetrieveActionValue({
        'model_type': this.model_prop.model_type,
        'model_id': this.model_prop.id
      }));
    },
    resetFom: function resetFom() {
      this.retrieveActionValueForm = this.getNewretrieveActionValueForm();
    },
    toggleCreating: function toggleCreating(creating) {
      this.creating = !creating;
      if (!this.creating) {
        this.resetFormValues();
      }
    },
    createRetrieveActionValue: function createRetrieveActionValue() {
      var _this3 = this;
      this.loading = true;
      this.retrieveActionValueForm.post('/retrieveactionvalues').then(function (newretrieveactionvalue) {
        _this3.loading = false;
        _this3.$swal({
          html: '<small>Action créée avec succès! <br> Prière de compléter les valeurs.</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _retrieveactionvalueBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('retrieveactionvalue_created', newretrieveactionvalue);
          _this3.addRetrieveActionValueToList(newretrieveactionvalue);
          _this3.resetFom();
        });

        // eslint-disable-next-line no-unused-vars
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    addRetrieveActionValueToList: function addRetrieveActionValueToList(retrieveactionvalue) {
      var retrieveactionvalueIndex = this.retrieveactionvalues.findIndex(function (c) {
        return retrieveactionvalue.id === c.id;
      });
      // si cette action n'existe pas déjà, on l'insère dans la liste
      if (retrieveactionvalueIndex === -1) {
        this.retrieveactionvalues.push(retrieveactionvalue);
      }
    },
    removeRetrieveActionValueToList: function removeRetrieveActionValueToList($event) {
      var retrieveactionvalueIndex = this.retrieveactionvalues.findIndex(function (c) {
        return $event.id === c.id;
      });
      if (retrieveactionvalueIndex > -1) {
        this.retrieveactionvalues.splice(retrieveactionvalueIndex, 1);
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
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
      type: _vm.retrieveActionValueForm.errors.has("retrieveaction") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.retrieveActionValueForm.errors.has("retrieveaction"),
      label: _vm.retrieveActionValueForm.errors.get("retrieveaction"),
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
      value: _vm.retrieveActionValueForm.retrieveaction,
      callback: function callback($$v) {
        _vm.$set(_vm.retrieveActionValueForm, "retrieveaction", $$v);
      },
      expression: "retrieveActionValueForm.retrieveaction"
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
      type: _vm.retrieveActionValueForm.errors.has("description") ? "is-danger" : "is-default",
      expanded: ""
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.retrieveActionValueForm.errors.has("description"),
      label: _vm.retrieveActionValueForm.errors.get("description"),
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
      value: _vm.retrieveActionValueForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.retrieveActionValueForm, "description", $$v);
      },
      expression: "retrieveActionValueForm.description"
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
        return _vm.createRetrieveActionValue();
      }
    }
  })], 1)], 1) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "box"
  }, _vm._l(_vm.retrieveactionvalues, function (retrieveactionvalue) {
    return _c("RetrieveActionValueItem", {
      key: retrieveactionvalue.uuid,
      attrs: {
        model_prop: retrieveactionvalue
      },
      on: {
        retrieveactionvalue_deleted: _vm.removeRetrieveActionValueToList
      }
    });
  }), 1)], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/retrieveactionvalues/retrieveactionvalueBus.js":
/*!***************************************************************************!*\
  !*** ./resources/js/views/retrieveactionvalues/retrieveactionvalueBus.js ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());
/// Permet de faciliter la communication entre composants enfants.

/***/ }),

/***/ "./resources/js/views/retrieveactionvalues/list.vue":
/*!**********************************************************!*\
  !*** ./resources/js/views/retrieveactionvalues/list.vue ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=c4fc0f6c&scoped=true& */ "./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "c4fc0f6c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/retrieveactionvalues/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true& ***!
  \*****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_c4fc0f6c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./list.vue?vue&type=template&id=c4fc0f6c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/retrieveactionvalues/list.vue?vue&type=template&id=c4fc0f6c&scoped=true&");


/***/ })

}]);