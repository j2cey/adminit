"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reportfiletypes_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _reportfiletypeBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./reportfiletypeBus */ "./resources/js/views/reportfiletypes/reportfiletypeBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var ReportFileType = /*#__PURE__*/_createClass(function ReportFileType(reportfiletype) {
  _classCallCheck(this, ReportFileType);
  this.name = reportfiletype.name || '';
  this.extension = reportfiletype.extension || '';
  this.filemimetype = reportfiletype.filemimetype || {};
  this.description = reportfiletype.description || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "reportfiletype-addupdate",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    // Se déclenche à la réception de l'évènement 'reportfiletype_create'
    _reportfiletypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('report_file_type_create', function () {
      _this.editing = false;
      _this.reportfiletypeUuid = null;
      _this.reportfiletypeId = null;
      _this.reportfiletype = new ReportFileType({});
      _this.reportFileTypeForm = new Form(_this.reportfiletype);
      $('#addUpdatereportfiletype').modal(); // rend visible le formulaire.
    });

    // Se déclenche à la réception de l'évènement 'reportfiletype_edit'
    _reportfiletypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('report_file_type_edit', function (reportfiletype) {
      console.log('report_file_type_edit received on ADDUPDATE: ', reportfiletype);
      _this.editing = true;
      _this.reportfiletype = new ReportFileType(reportfiletype);
      //this.reportfiletypetype_selected = this.getreportfiletypeType(reportfiletype.type)
      _this.reportFileTypeForm = new Form(_this.reportfiletype);
      _this.reportfiletypeUuid = reportfiletype.uuid;
      _this.reportfiletypeId = reportfiletype.id;
      _this.formTitle = 'Modification Type de Fichier';
      $('#addUpdatereportfiletype').modal();
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/filemimetypes.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.mimetypes = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Création Type de Fichier',
      reportfiletype: {},
      reportFileTypeForm: new Form(new ReportFileType({})),
      reportfiletypeId: null,
      reportfiletypeUuid: null,
      editing: false,
      loading: false,
      mimetypes: []
    };
  },
  methods: {
    getreportfiletypeType: function getreportfiletypeType($type) {
      var typeIndex = this.reportfiletype.findIndex(function (s) {
        return $type === s.value;
      });
      if (typeIndex !== -1) {
        return this.reportfiletype[typeIndex];
      } else {
        return null;
      }
    },
    createReportFileType: function createReportFileType() {
      var _this3 = this;
      this.loading = true;
      this.reportFileTypeForm.post('/reportfiletypes').then(function (reportfiletype) {
        _this3.loading = false;
        _this3.closeModal();
        _this3.$swal({
          html: '<small>Type de fichier créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reportfiletypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('report_file_type_created', reportfiletype);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateReportFileType: function updateReportFileType() {
      var _this4 = this;
      this.loading = true;
      this.reportFileTypeForm.put("/reportfiletypes/".concat(this.reportfiletypeUuid)).then(function (reportfiletype) {
        _this4.loading = false;
        _this4.resetForm();
        $('#addUpdatereportfiletype').modal('hide');
        _this4.$swal({
          html: '<small>Type de fichier mis à jour avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reportfiletypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('report_file_type_updated', reportfiletype);
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdatereportfiletype').modal('hide');
    },
    resetForm: function resetForm() {
      this.reportFileTypeForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading && !this.reportFileTypeForm.name !== "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true& ***!
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
  return _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "addUpdatereportfiletype",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "reportfiletypeModalLabel",
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
      id: "reportfiletypeModalLabel"
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
        return _vm.reportFileTypeForm.errors.clear();
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
      value: _vm.reportfiletypeId,
      expression: "reportfiletypeId"
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
      value: _vm.reportfiletypeId
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.reportfiletypeId = $event.target.value;
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
      value: _vm.reportFileTypeForm.name,
      expression: "reportFileTypeForm.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "name",
      name: "name",
      placeholder: "Name"
    },
    domProps: {
      value: _vm.reportFileTypeForm.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.reportFileTypeForm, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.reportFileTypeForm.errors.has("name") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileTypeForm.errors.get("name"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "extension"
    }
  }, [_vm._v("Extension")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reportFileTypeForm.extension,
      expression: "reportFileTypeForm.extension"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "extension",
      name: "extension",
      placeholder: "extension"
    },
    domProps: {
      value: _vm.reportFileTypeForm.extension
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.reportFileTypeForm, "extension", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.reportFileTypeForm.errors.has("extension") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileTypeForm.errors.get("extension"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_group"
    }
  }, [_vm._v("Mime Type")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_group",
      "selected.sync": "subjectForm.filemimetype",
      value: "",
      options: _vm.mimetypes,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Mime Type"
    },
    model: {
      value: _vm.reportFileTypeForm.filemimetype,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileTypeForm, "filemimetype", $$v);
      },
      expression: "reportFileTypeForm.filemimetype"
    }
  }), _vm._v(" "), _vm.reportFileTypeForm.errors.has("filemimetype") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileTypeForm.errors.get("filemimetype"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "description"
    }
  }, [_vm._v("Description")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reportFileTypeForm.description,
      expression: "reportFileTypeForm.description"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "description",
      name: "description",
      placeholder: "Description"
    },
    domProps: {
      value: _vm.reportFileTypeForm.description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.reportFileTypeForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.reportFileTypeForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileTypeForm.errors.get("description"))
    }
  }) : _vm._e()])])])])]), _vm._v(" "), _c("div", {
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
        return _vm.updateReportFileType();
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
        return _vm.createReportFileType();
      }
    }
  }, [_vm._v("Créer Nouveau")])], 1)])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reportfiletypes/addupdate.vue":
/*!**********************************************************!*\
  !*** ./resources/js/views/reportfiletypes/addupdate.vue ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=814b7416&scoped=true& */ "./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "814b7416",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reportfiletypes/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true& ***!
  \*****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_814b7416_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=814b7416&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfiletypes/addupdate.vue?vue&type=template&id=814b7416&scoped=true&");


/***/ })

}]);