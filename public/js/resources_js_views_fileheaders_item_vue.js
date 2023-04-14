"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_fileheaders_item_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
var FileHeader = /*#__PURE__*/_createClass(function FileHeader(fileheader) {
  _classCallCheck(this, FileHeader);
  this.title = fileheader.title || '';
  this.description = fileheader.description || '';
  this.model_type = fileheader.model_type || '';
  this.model_id = fileheader.model_id || '';
});
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "fileheader-item",
  props: {
    fileheader_prop: {}
  },
  components: {
    FormatRuleList: function FormatRuleList() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_formatrules_list_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../formatrules/list */ "./resources/js/views/formatrules/list.vue"));
    }
  },
  data: function data() {
    return {
      fileheader: this.fileheader_prop,
      fileHeaderForm: new Form(new FileHeader(this.fileheader_prop)),
      editing: false,
      loading: false
    };
  },
  methods: {
    editFileHeader: function editFileHeader() {
      this.editing = true;
    },
    cancelEditFileHeader: function cancelEditFileHeader() {
      this.editing = false;
      this.loading = false;
    },
    setFileHeaderUpdated: function setFileHeaderUpdated(fileheader) {
      this.fileHeaderForm = new Form(new FileHeader(fileheader));
      this.cancelEditFileHeader(fileheader);
    },
    updateFileHeader: function updateFileHeader(fileheader) {
      var _this = this;
      this.loading = true;
      this.fileHeaderForm.put("/fileheaders/".concat(this.fileheader.uuid), undefined).then(function (fileheader) {
        _this.loading = false;
        _this.$swal({
          html: '<small>En-tête modifiée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _this.loading = false;
          _this.setFileHeaderUpdated(fileheader);
        });
      })["catch"](function (error) {
        _this.loading = false;
        _this.cancelEditFileHeader(fileheader);
      });
    },
    deleteFileHeader: function deleteFileHeader(fileheader) {
      var _this2 = this;
      this.$swal({
        title: "Suppresion de l'En-tête",
        text: "Validez la Suppression!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui'
      }).then(function (result) {
        if (result.value) {
          _this2.loading = true;
          axios["delete"]("/fileheaders/".concat(fileheader.uuid)).then(function (resp) {
            _this2.loading = false;
          })["catch"](function (error) {
            _this2.loading = false;
            window.handleErrors(error);
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true& ***!
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
  return _c("section", [_c("div", {
    staticClass: "box"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col"
  }, [_c("b-field", {
    attrs: {
      size: "is-small",
      horizontal: ""
    },
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-primary text-xs"
        }, [_vm._v("Titre")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("b-field", {
    attrs: {
      type: _vm.fileHeaderForm.errors.has("title") ? "is-danger" : "is-default"
    }
  }, [_c("b-tooltip", {
    attrs: {
      active: _vm.fileHeaderForm.errors.has("title"),
      label: _vm.fileHeaderForm.errors.get("title"),
      position: "is-bottom",
      type: "is-danger",
      animated: false
    }
  }, [_c("b-input", {
    attrs: {
      "custom-class": "transinput",
      size: "is-small",
      name: "title",
      placeholder: "Titre",
      readonly: !_vm.editing
    },
    model: {
      value: _vm.fileHeaderForm.title,
      callback: function callback($$v) {
        _vm.$set(_vm.fileHeaderForm, "title", $$v);
      },
      expression: "fileHeaderForm.title"
    }
  })], 1)], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      size: "is-small",
      horizontal: ""
    },
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-primary text-xs"
        }, [_vm._v("Description")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("b-field", [_c("b-input", {
    staticStyle: {
      "border-style": "none"
    },
    attrs: {
      size: "is-small",
      name: "description",
      placeholder: "Description",
      readonly: !_vm.editing
    },
    model: {
      value: _vm.fileHeaderForm.description,
      callback: function callback($$v) {
        _vm.$set(_vm.fileHeaderForm, "description", $$v);
      },
      expression: "fileHeaderForm.description"
    }
  })], 1)], 1), _vm._v(" "), _c("b-field", {
    attrs: {
      size: "is-small",
      horizontal: ""
    },
    scopedSlots: _vm._u([{
      key: "label",
      fn: function fn() {
        return [_c("span", {
          staticClass: "has-text-primary text-xs"
        }, [_vm._v("Création")])];
      },
      proxy: true
    }])
  }, [_vm._v(" "), _c("b-field", [_c("b-input", {
    attrs: {
      size: "is-small",
      value: _vm._f("formatDate")(_vm.fileheader.created_at),
      name: "created_at",
      placeholder: "Created at",
      readonly: ""
    }
  })], 1)], 1), _vm._v(" "), _c("b-field", {
    staticClass: "text-xs",
    attrs: {
      position: "is-right"
    }
  }, [!_vm.editing ? _c("a", {
    staticClass: "tw-inline-block tw-mr-3 text-warning",
    on: {
      click: function click($event) {
        return _vm.editFileHeader(_vm.fileheader);
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
        return _vm.updateFileHeader(_vm.fileheader);
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
        return _vm.cancelEditFileHeader(_vm.fileheader);
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
        return _vm.deleteFileHeader(_vm.fileheader);
      }
    }
  }, [_c("b-icon", {
    attrs: {
      pack: "fas",
      icon: "trash",
      size: "is-small"
    }
  })], 1)])], 1), _vm._v(" "), _c("div", {
    staticClass: "col"
  }, [_c("FormatRuleList", {
    attrs: {
      model_prop: _vm.fileheader
    }
  })], 1)])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/fileheaders/item.vue":
/*!*************************************************!*\
  !*** ./resources/js/views/fileheaders/item.vue ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=a5a6cf12&scoped=true& */ "./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "a5a6cf12",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/fileheaders/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true& ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_a5a6cf12_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item.vue?vue&type=template&id=a5a6cf12&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/fileheaders/item.vue?vue&type=template&id=a5a6cf12&scoped=true&");


/***/ })

}]);