"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_osservers_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _osserverBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./osserverBus */ "./resources/js/views/osservers/osserverBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var OsServer = /*#__PURE__*/_createClass(function OsServer(osserver) {
  _classCallCheck(this, OsServer);
  this.name = osserver.name || '';
  this.osfamily = osserver.osfamily || '';
  this.osarchitecture = osserver.osarchitecture || '';
  this.description = osserver.description || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "osserver-addupdate",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    // Se déclenche à la réception de l'évènement 'osserver_create'
    _osserverBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('os_server_create', function () {
      _this.editing = false;
      _this.osserverUuid = null;
      _this.osserverId = null;
      _this.osserver = new OsServer({});
      _this.osServerForm = new Form(_this.osserver);
      $('#addUpdateosserver').modal(); // rend visible le formulaire.
    });

    // Se déclenche à la réception de l'évènement 'osserver_edit'
    _osserverBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('os_server_edit', function (osserver) {
      console.log('os_server_edit received on ADDUPDATE: ', osserver);
      _this.editing = true;
      _this.osserver = new OsServer(osserver);
      //this.osservert_selected = this.getosserver(osserver)
      _this.osServerForm = new Form(_this.osserver);
      _this.osserverUuid = osserver.uuid;
      _this.osserverId = osserver.id;
      _this.formTitle = 'Modification du server';
      $('#addUpdateosserver').modal();
    });
  },
  created: function created() {},
  data: function data() {
    return {
      formTitle: 'Création du server ',
      osserver: {},
      osServerForm: new Form(new OsServer({})),
      osserverId: null,
      osserverUuid: null,
      editing: false,
      loading: false,
      osfamilies: []
    };
  },
  methods: {
    getosserverType: function getosserverType($type) {
      var typeIndex = this.osserver.findIndex(function (s) {
        return $type === s.value;
      });
      if (typeIndex !== -1) {
        return this.osserver[typeIndex];
      } else {
        return null;
      }
    },
    createOsServer: function createOsServer() {
      var _this2 = this;
      this.loading = true;
      this.osServerForm.post('/osservers').then(function (osserver) {
        _this2.loading = false;
        _this2.closeModal();
        _this2.$swal({
          html: '<small>Serveur créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _osserverBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('os_server_created', osserver);
        });
      })["catch"](function (error) {
        _this2.loading = false;
      });
    },
    updateOsServer: function updateOsServer() {
      var _this3 = this;
      this.loading = true;
      this.osServerForm.put("/osservers/".concat(this.osserverUuid)).then(function (osserver) {
        _this3.loading = false;
        _this3.resetForm();
        $('#addUpdateosserver').modal('hide');
        _this3.$swal({
          html: '<small>Serveur mis à jour avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _osserverBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('os_server_updated', osserver);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateosserver').modal('hide');
    },
    resetForm: function resetForm() {
      this.osServerForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading && !this.osServerForm.name !== "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
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
      id: "addUpdateosserver",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "osserverModalLabel",
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
      id: "osserverModalLabel"
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
        return _vm.osServerForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_vm.editing ? _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("ID")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.osserverId,
      expression: "osserverId"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "id",
      name: "id",
      placeholder: "id",
      readonly: ""
    },
    domProps: {
      value: _vm.osserverId
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.osserverId = $event.target.value;
      }
    }
  })])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Nom")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.osServerForm.name,
      expression: "osServerForm.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "name",
      name: "name",
      placeholder: "Name"
    },
    domProps: {
      value: _vm.osServerForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.osServerForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.osServerForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.osServerForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_osfamily"
    }
  }, [_vm._v("Famille")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_osfamily",
      "selected.sync": "subjectForm.osfamily",
      value: "",
      options: _vm.osfamilies,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Famille"
    },
    model: {
      value: _vm.osServerForm.osfamily,
      callback: function callback($$v) {
        _vm.$set(_vm.osServerForm, "osfamily", $$v);
      },
      expression: "osServerForm.osfamily"
    }
  }), _vm._v(" "), _vm.osServerForm.errors.has("osfamily") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.osServerForm.errors.get("osfamily"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_osarchitecture"
    }
  }, [_vm._v("Architecture")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_osarchitecture",
      "selected.sync": "subjectForm.osarchitecture",
      value: "",
      options: _vm.osarchitecture,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Architecture"
    },
    model: {
      value: _vm.osServerForm.osarchitecture,
      callback: function callback($$v) {
        _vm.$set(_vm.osServerForm, "osarchitecture", $$v);
      },
      expression: "osServerForm.osarchitecture"
    }
  }), _vm._v(" "), _vm.osServerForm.errors.has("osarchitecture") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.osServerForm.errors.get("osarchitecture"))
    }
  }) : _vm._e()], 1)])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer justify-content-between"
  }, [_c("b-button", {
    attrs: {
      type: "is-dark",
      size: "is-small",
      "data-dismiss": "modal"
    },
    on: {
      click: _vm.closeModal
    }
  }, [_vm._v("Fermer")]), _vm._v(" "), _vm.editing ? _c("b-button", {
    attrs: {
      type: "is-primary",
      size: "is-small",
      loading: _vm.loading,
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.updateOsServer();
      }
    }
  }, [_vm._v("Enregistrer")]) : _c("b-button", {
    attrs: {
      type: "is-primary",
      size: "is-small",
      loading: _vm.loading,
      disabled: !_vm.isValidForm
    },
    on: {
      click: function click($event) {
        return _vm.createOsServer();
      }
    }
  }, [_vm._v("Créer Nouveau")])], 1)])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/osservers/addupdate.vue":
/*!****************************************************!*\
  !*** ./resources/js/views/osservers/addupdate.vue ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=459ab8d8&scoped=true& */ "./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "459ab8d8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/osservers/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true& ***!
  \***********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_459ab8d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=459ab8d8&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/addupdate.vue?vue&type=template&id=459ab8d8&scoped=true&");


/***/ })

}]);