"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_reportfileaccesses_addupdate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _reportfileaccessBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./reportfileaccessBus */ "./resources/js/views/reportfileaccesses/reportfileaccessBus.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }


var ReportFileAccess = /*#__PURE__*/_createClass(function ReportFileAccess(reportfileaccess) {
  _classCallCheck(this, ReportFileAccess);
  this.reportfile = reportfileaccess.reportfile || {};
  this.accessaccount = reportfileaccess.accessaccount || {};
  this.reportserver = reportfileaccess.reportserver || {};
  this.accessprotocole = reportfileaccess.accessprotocole || {};
  this.description = reportfileaccess.description || '';
  this.retrieve_by_name = reportfileaccess.retrieve_by_name || '';
  this.retrieve_by_wildcard = reportfileaccess.retrieve_by_wildcard || '';
  this.retrieval_type = reportfileaccess.retrieve_by_name ? 'retrieve_by_name' : reportfileaccess.retrieve_by_wildcard ? 'retrieve_by_wildcard' : 'retrieve_by_name';
  this.status = reportfileaccess.status ? reportfileaccess.status.code : 'active';
  this.name = reportfileaccess.name ? reportfileaccess.name : null;
  this.code = reportfileaccess.code ? reportfileaccess.code : null;
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "reportfileaccess-addupdate",
  components: {
    Multiselect: (vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default())
  },
  mounted: function mounted() {
    var _this = this;
    // Se déclenche à la réception de l'évènement 'reportfileaccess_create'
    _reportfileaccessBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('report_file_type_create', function (reportfile) {
      _this.editing = false;
      _this.reportfileaccessUuid = null;
      _this.reportfileaccessId = null;
      _this.reportfileaccess = new ReportFileAccess({
        'reportfile': reportfile
      });
      _this.reportFileAccessForm = new Form(_this.reportfileaccess);
      $('#addUpdatereportfileaccess').modal(); // rend visible le formulaire.
    });

    // Se déclenche à la réception de l'évènement 'reportfileaccess_edit'
    _reportfileaccessBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('report_file_access_edit', function (reportfileaccess) {
      console.log('report_file_type_edit received on ADDUPDATE: ', reportfileaccess);
      _this.editing = true;
      _this.reportfileaccess = new ReportFileAccess(reportfileaccess);
      //this.reportfileaccesstype_selected = this.getreportfileaccessType(reportfileaccess.type)
      _this.reportFileAccessForm = new Form(_this.reportfileaccess);
      _this.reportfileaccessUuid = reportfileaccess.uuid;
      _this.reportfileaccessId = reportfileaccess.id;
      _this.formTitle = 'Modification Accès';
      $('#addUpdatereportfileaccess').modal();
    });
  },
  created: function created() {
    var _this2 = this;
    axios.get('/accessaccounts.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.accessaccounts = data;
    });
    axios.get('/reportservers.fetch').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.reportservers = data;
    });
    axios.get('/accessprotocoles.fetch').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.accessprotocoles = data;
    });
  },
  data: function data() {
    return {
      formTitle: 'Création Accès',
      reportfileaccess: {},
      reportFileAccessForm: new Form(new ReportFileAccess({})),
      reportfileaccessId: null,
      reportfileaccessUuid: null,
      editing: false,
      loading: false,
      accessaccounts: [],
      reportservers: [],
      accessprotocoles: []
    };
  },
  methods: {
    getreportfileaccessType: function getreportfileaccessType($type) {
      var typeIndex = this.reportfileaccess.findIndex(function (s) {
        return $type === s.value;
      });
      if (typeIndex !== -1) {
        return this.reportfileaccess[typeIndex];
      } else {
        return null;
      }
    },
    createReportFileAccess: function createReportFileAccess() {
      var _this3 = this;
      this.loading = true;
      this.revertStatusObject();
      this.reportFileAccessForm.post('/reportfileaccesses').then(function (reportfileaccess) {
        _this3.loading = false;
        _this3.closeModal();
        _this3.$swal({
          html: '<small>Accès créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reportfileaccessBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('report_file_type_created', reportfileaccess);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateReportFileAccess: function updateReportFileAccess() {
      var _this4 = this;
      this.loading = true;
      this.revertStatusObject();
      this.reportFileAccessForm.put("/reportfileaccesses/".concat(this.reportfileaccessUuid), undefined).then(function (reportfileaccess) {
        _this4.loading = false;
        _this4.resetForm();
        $('#addUpdatereportfileaccess').modal('hide');
        _this4.$swal({
          html: '<small>Accès mis à jour avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reportfileaccessBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('report_file_type_updated', reportfileaccess);
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdatereportfileaccess').modal('hide');
    },
    resetForm: function resetForm() {
      this.reportFileAccessForm.reset();
    },
    revertStatusObject: function revertStatusObject() {
      this.reportFileAccessForm.status = {
        'code': this.reportFileAccessForm.status
      };
    },
    retrievalTypeChange: function retrievalTypeChange(event) {
      this.reportFileAccessForm.retrieval_type = event;
      this.updateRetrievalType();
    },
    updateRetrievalType: function updateRetrievalType() {
      if (this.reportFileAccessForm.retrieval_type === 'retrieve_by_name') {
        this.reportFileAccessForm.retrieve_by_name = 1;
        this.reportFileAccessForm.retrieve_by_wildcard = 0;
      } else if (this.reportFileAccessForm.retrieval_type === 'retrieve_by_wildcard') {
        this.reportFileAccessForm.retrieve_by_name = 0;
        this.reportFileAccessForm.retrieve_by_wildcard = 1;
      } else {
        this.reportFileAccessForm.retrieve_by_name = 0;
        this.reportFileAccessForm.retrieve_by_wildcard = 0;
      }
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading && !this.reportFileAccessForm.name !== "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true& ***!
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
  return _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "addUpdatereportfileaccess",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "reportfileaccessModalLabel",
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
      id: "reportfileaccessModalLabel"
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
        return _vm.reportFileAccessForm.errors.clear();
      }
    }
  }, [_c("div", {
    staticClass: "card-body"
  }, [_vm.editing ? _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "id"
    }
  }, [_vm._v("ID")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reportfileaccessId,
      expression: "reportfileaccessId"
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
      value: _vm.reportfileaccessId
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.reportfileaccessId = $event.target.value;
      }
    }
  })])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "reportfile"
    }
  }, [_vm._v("Fichier")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reportFileAccessForm.reportfile.name,
      expression: "reportFileAccessForm.reportfile.name"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "reportfile",
      name: "reportfile",
      placeholder: "Fichier",
      readonly: ""
    },
    domProps: {
      value: _vm.reportFileAccessForm.reportfile.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.reportFileAccessForm.reportfile, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.reportFileAccessForm.errors.has("reportfile") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileAccessForm.errors.get("reportfile"))
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_accessaccount"
    }
  }, [_vm._v("Compte")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_accessaccount",
      "selected.sync": "reportFileAccessForm.accessaccount",
      value: "",
      options: _vm.accessaccounts,
      searchable: true,
      multiple: false,
      label: "login",
      "track-by": "id",
      placeholder: "Compte"
    },
    model: {
      value: _vm.reportFileAccessForm.accessaccount,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "accessaccount", $$v);
      },
      expression: "reportFileAccessForm.accessaccount"
    }
  }), _vm._v(" "), _vm.reportFileAccessForm.errors.has("accessaccount") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileAccessForm.errors.get("accessaccount"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_reportserver"
    }
  }, [_vm._v("Serveur")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_reportserver",
      "selected.sync": "reportFileAccessForm.reportserver",
      value: "",
      options: _vm.reportservers,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Serveur"
    },
    model: {
      value: _vm.reportFileAccessForm.reportserver,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "reportserver", $$v);
      },
      expression: "reportFileAccessForm.reportserver"
    }
  }), _vm._v(" "), _vm.reportFileAccessForm.errors.has("reportserver") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileAccessForm.errors.get("reportserver"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs text-xs",
    attrs: {
      "for": "select_accessprotocole"
    }
  }, [_vm._v("Protocole")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-8"
  }, [_c("multiselect", {
    key: "id",
    attrs: {
      id: "select_accessprotocole",
      "selected.sync": "reportFileAccessForm.accessprotocole",
      value: "",
      options: _vm.accessprotocoles,
      searchable: true,
      multiple: false,
      label: "name",
      "track-by": "id",
      placeholder: "Protocole"
    },
    model: {
      value: _vm.reportFileAccessForm.accessprotocole,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "accessprotocole", $$v);
      },
      expression: "reportFileAccessForm.accessprotocole"
    }
  }), _vm._v(" "), _vm.reportFileAccessForm.errors.has("accessprotocole") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileAccessForm.errors.get("accessprotocole"))
    }
  }) : _vm._e()], 1)]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "reportfile_retrieval_type"
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("b-field", {
    attrs: {
      id: "reportfile_retrieval_type",
      label: "",
      "label-position": "on-border",
      "custom-class": "is-small"
    }
  }, [_c("b-radio-button", {
    attrs: {
      size: "is-small",
      "native-value": "retrieve_by_name",
      type: "is-success is-light is-outlined"
    },
    on: {
      input: function input($event) {
        return _vm.retrievalTypeChange($event);
      }
    },
    model: {
      value: _vm.reportFileAccessForm.retrieval_type,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "retrieval_type", $$v);
      },
      expression: "reportFileAccessForm.retrieval_type"
    }
  }, [_c("span", [_vm._v("Par Nom")])]), _vm._v(" "), _c("b-radio-button", {
    attrs: {
      size: "is-small",
      "native-value": "retrieve_by_wildcard",
      type: "is-warning is-light is-outlined"
    },
    on: {
      input: function input($event) {
        return _vm.retrievalTypeChange($event);
      }
    },
    model: {
      value: _vm.reportFileAccessForm.retrieval_type,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "retrieval_type", $$v);
      },
      expression: "reportFileAccessForm.retrieval_type"
    }
  }, [_c("span", [_vm._v("Par Wildcard")])])], 1)], 1)]), _vm._v(" "), _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-2 col-form-label text-xs",
    attrs: {
      "for": "status"
    }
  }, [_vm._v("Statut")]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-10"
  }, [_c("b-field", {
    attrs: {
      id: "status",
      label: "Statut",
      "label-position": "on-border",
      "custom-class": "is-small"
    }
  }, [_c("b-radio-button", {
    attrs: {
      size: "is-small",
      "native-value": "active",
      type: "is-success is-light is-outlined"
    },
    model: {
      value: _vm.reportFileAccessForm.status,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "status", $$v);
      },
      expression: "reportFileAccessForm.status"
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "check"
    }
  }), _vm._v(" "), _c("span", [_vm._v("Actif")])], 1), _vm._v(" "), _c("b-radio-button", {
    attrs: {
      size: "is-small",
      "native-value": "inactive",
      type: "is-danger is-light is-outlined"
    },
    model: {
      value: _vm.reportFileAccessForm.status,
      callback: function callback($$v) {
        _vm.$set(_vm.reportFileAccessForm, "status", $$v);
      },
      expression: "reportFileAccessForm.status"
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "close"
    }
  }), _vm._v(" "), _c("span", [_vm._v("Inactif")])], 1)], 1)], 1)]), _vm._v(" "), _c("div", {
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
      value: _vm.reportFileAccessForm.description,
      expression: "reportFileAccessForm.description"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      id: "description",
      name: "description",
      placeholder: "Description"
    },
    domProps: {
      value: _vm.reportFileAccessForm.description
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.reportFileAccessForm, "description", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.reportFileAccessForm.errors.has("description") ? _c("span", {
    staticClass: "invalid-feedback d-block text-xs",
    attrs: {
      role: "alert"
    },
    domProps: {
      textContent: _vm._s(_vm.reportFileAccessForm.errors.get("description"))
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
        return _vm.updateReportFileAccess();
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
        return _vm.createReportFileAccess();
      }
    }
  }, [_vm._v("Créer Nouveau")])], 1)])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group row"
  }, [_c("label", {
    staticClass: "col-sm-4 col-form-label text-xs",
    attrs: {
      "for": "reportfile_retrieval_type"
    }
  }, [_vm._v("Récupération du Fichier:")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/reportfileaccesses/addupdate.vue":
/*!*************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/addupdate.vue ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=6df5289c&scoped=true& */ "./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6df5289c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reportfileaccesses/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true& ***!
  \********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_6df5289c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./addupdate.vue?vue&type=template&id=6df5289c&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/reportfileaccesses/addupdate.vue?vue&type=template&id=6df5289c&scoped=true&");


/***/ })

}]);