"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_osservers_item-list_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _osservers_osserverBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../osservers/osserverBus */ "./resources/js/views/osservers/osserverBus.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "osserver-list",
  props: {
    list_title_prop: {
      "default": "Osservers",
      type: String
    },
    osservers_list_prop: {}
  },
  components: {
    OsServerAddUpdate: function OsServerAddUpdate() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_osservers_addupdate_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./addupdate */ "./resources/js/views/osservers/addupdate.vue"));
    },
    OsServerItem: function OsServerItem() {
      return __webpack_require__.e(/*! import() */ "resources_js_views_osservers_item_vue").then(__webpack_require__.bind(__webpack_require__, /*! ./item */ "./resources/js/views/osservers/item.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;
    _osservers_osserverBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('os_server_created', function (osserver) {
      _this.osservers_list.push(osserver);
      // émet l'événement au pararent pour envoyer le nouvel objet créé
      _this.$emit('os_server_created', osserver);
    });
  },
  data: function data() {
    return {
      list_title: this.list_title_prop,
      osservers_list: this.osservers_list_prop,
      searchOsservers: ""
    };
  },
  methods: {
    createOsServer: function createOsServer() {
      _osservers_osserverBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('os_server_create');
    },
    deleteOsServer: function deleteOsServer($event) {
      //console.log("osserver_deleted received at list: ", $event)
      var itemIndex = this.osservers_list.findIndex(function (c) {
        return $event.id === c.id;
      });
      console.log("itemIndex : ", itemIndex);
      if (itemIndex !== -1) {
        this.osservers_list.splice(itemIndex, 1);
        // emission vers le parent
        //this.$emit('osserver_removed_from_list', $event)
      }
    }
  },

  computed: {
    filteredOsservers: function filteredOsservers() {
      var _this2 = this;
      var tempOsservers = this.osservers_list;
      if (this.searchOsservers !== '' && this.searchOsservers) {
        tempOsservers = tempOsservers.filter(function (item) {
          return item.name.toUpperCase().includes(_this2.searchOsservers.toUpperCase());
        });
      }
      // Sorting
      tempOsservers = tempOsservers.sort(function (a, b) {
        var fa = a.name.toLowerCase(),
          fb = b.name.toLowerCase();
        if (fa > fb) {
          return -1;
        }
        if (fa < fb) {
          return 1;
        }
        return 0;
      });
      if (!this.ascending) {
        tempOsservers.reverse();
      }
      // end Sorting
      return tempOsservers;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true& ***!
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
    staticClass: "card collapsed-card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_c("h5", {
    staticClass: "btn btn-tool",
    attrs: {
      type: "button",
      "data-card-widget": "collapse"
    }
  }, [_vm._v("\n            " + _vm._s(_vm.list_title) + "\n            "), _c("small", {
    staticClass: "text text-xs"
  }, [_vm._v("\n                " + _vm._s(_vm.searchOsservers === "" ? "" : " (" + _vm.filteredOsservers.length + ")") + "\n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "card-tools"
  })]), _vm._v(" "), _c("div", {
    staticClass: "card-body table-responsive p-0"
  }, [_c("table", {
    staticClass: "table table-head-fixed text-nowrap"
  }, [_c("thead", [_c("tr", [_c("th", [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("div", {
    staticClass: "btn-group"
  }, [_c("b-button", {
    attrs: {
      size: "is-small",
      type: "is-info is-light"
    },
    on: {
      click: _vm.createOsServer
    }
  }, [_vm._v("Ajouter")])], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("div", {
    staticClass: "btn-group"
  }, [_c("div", {
    staticClass: "input-group input-group-sm"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.searchOsservers,
      expression: "searchOsservers"
    }],
    staticClass: "form-control form-control-navbar",
    attrs: {
      type: "search",
      placeholder: "Rechercher",
      "aria-label": "Search"
    },
    domProps: {
      value: _vm.searchOsservers
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.searchOsservers = $event.target.value;
      }
    }
  }), _vm._v(" "), _vm._m(0)])])])]), _vm._v(" "), _vm._m(1)])])]), _vm._v(" "), _c("tbody", _vm._l(_vm.filteredOsservers, function (osserver, index) {
    return _vm.filteredOsservers ? _c("tr", {
      key: osserver.id,
      staticClass: "text text-xs"
    }, [index < 10 ? _c("td", [_c("OsServerItem", {
      attrs: {
        osserver_prop: osserver
      },
      on: {
        osserver_deleted: _vm.deleteOsServer
      }
    })], 1) : _vm._e()]) : _vm._e();
  }), 0)])]), _vm._v(" "), _c("div", {
    staticClass: "card-footer"
  }), _vm._v(" "), _c("OsServerAddUpdate")], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "input-group-append"
  }, [_c("button", {
    staticClass: "btn btn-navbar",
    attrs: {
      type: "button"
    }
  }, [_c("i", {
    staticClass: "fas fa-search"
  })])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("ID")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Nom")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-3 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Famille")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  }, [_c("span", {
    staticClass: "text text-sm"
  }, [_vm._v("Architecture")])]), _vm._v(" "), _c("div", {
    staticClass: "col-sm-2 col-6"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/views/osservers/osserverBus.js":
/*!*****************************************************!*\
  !*** ./resources/js/views/osservers/osserverBus.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0__["default"]());

/***/ }),

/***/ "./resources/js/views/osservers/item-list.vue":
/*!****************************************************!*\
  !*** ./resources/js/views/osservers/item-list.vue ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item-list.vue?vue&type=template&id=3ed72846&scoped=true& */ "./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true&");
/* harmony import */ var _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item-list.vue?vue&type=script&lang=js& */ "./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3ed72846",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/osservers/item-list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=script&lang=js&");
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true& ***!
  \***********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render; },
/* harmony export */   "staticRenderFns": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_3ed72846_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./item-list.vue?vue&type=template&id=3ed72846&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/osservers/item-list.vue?vue&type=template&id=3ed72846&scoped=true&");


/***/ })

}]);