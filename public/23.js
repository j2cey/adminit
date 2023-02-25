(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[23],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/users/item-list.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "user-item-list",
  props: {
    list_title_prop: null,
    users_prop: {}
  },
  components: {
    UserAddUpdate: function UserAddUpdate() {
      return __webpack_require__.e(/*! import() */ 7).then(__webpack_require__.bind(null, /*! ./addupdate */ "./resources/js/views/users/addupdate.vue"));
    },
    UserItem: function UserItem() {
      return __webpack_require__.e(/*! import() */ 8).then(__webpack_require__.bind(null, /*! ./item */ "./resources/js/views/users/item.vue"));
    }
  },
  data: function data() {
    return {
      list_title: this.list_title_prop,
      users: this.users_prop,
      searchUsers: null
    };
  },
  methods: {},
  computed: {
    filteredUsers: function filteredUsers() {
      var _this = this;

      var tempUsers = this.users;

      if (this.searchUsers !== '' && this.searchUsers) {
        tempUsers = tempUsers.filter(function (item) {
          return item.name.toUpperCase().includes(_this.searchUsers.toUpperCase());
        });
      } // Sorting


      tempUsers = tempUsers.sort(function (a, b) {
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
        tempUsers.reverse();
      } // end Sorting


      return tempUsers;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "card collapsed-card" },
    [
      _c("div", { staticClass: "card-header" }, [
        _c("h5", { staticClass: "card-title" }, [
          _vm._v(_vm._s(_vm.list_title ? _vm.list_title : "Users")),
        ]),
        _vm._v(" "),
        _vm._m(0),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card-body table-responsive p-0" }, [
        _c("table", { staticClass: "table table-head-fixed text-nowrap" }, [
          _c("thead", [
            _c("tr", [
              _c("th", [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-sm-3 col-6" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-3 col-6" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-3 col-6" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-3 col-6" }, [
                    _c("div", { staticClass: "btn-group" }, [
                      _c("div", { staticClass: "input-group input-group-sm" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.searchUsers,
                              expression: "searchUsers",
                            },
                          ],
                          staticClass: "form-control form-control-navbar",
                          attrs: {
                            type: "search",
                            placeholder: "Search",
                            "aria-label": "Search",
                          },
                          domProps: { value: _vm.searchUsers },
                          on: {
                            input: function ($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.searchUsers = $event.target.value
                            },
                          },
                        }),
                        _vm._v(" "),
                        _vm._m(1),
                      ]),
                    ]),
                  ]),
                ]),
                _vm._v(" "),
                _vm._m(2),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.filteredUsers, function (user, index) {
              return _vm.filteredUsers
                ? _c("tr", { key: user.id, staticClass: "text text-xs" }, [
                    index < 10
                      ? _c(
                          "td",
                          [
                            user.name
                              ? _c("UserItem", { attrs: { user_prop: user } })
                              : _vm._e(),
                          ],
                          1
                        )
                      : _vm._e(),
                  ])
                : _vm._e()
            }),
            0
          ),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card-footer" }),
      _vm._v(" "),
      _c("UserAddUpdate"),
    ],
    1
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-tools" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-tool",
          attrs: { type: "button", "data-card-widget": "collapse" },
        },
        [_c("i", { staticClass: "fas fa-plus" })]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "btn-group" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-tool dropdown-toggle",
            attrs: { type: "button", "data-toggle": "dropdown" },
          },
          [_c("i", { staticClass: "fas fa-wrench" })]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "dropdown-menu dropdown-menu-right",
            attrs: { user: "menu" },
          },
          [
            _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
              _vm._v("Action"),
            ]),
            _vm._v(" "),
            _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
              _vm._v("Another action"),
            ]),
            _vm._v(" "),
            _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
              _vm._v("Something else here"),
            ]),
            _vm._v(" "),
            _c("a", { staticClass: "dropdown-divider" }),
            _vm._v(" "),
            _c("a", { staticClass: "dropdown-item", attrs: { href: "#" } }, [
              _vm._v("Separated link"),
            ]),
          ]
        ),
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "btn btn-tool",
          attrs: { type: "button", "data-card-widget": "remove" },
        },
        [_c("i", { staticClass: "fas fa-times" })]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-append" }, [
      _c(
        "button",
        { staticClass: "btn btn-navbar", attrs: { type: "button" } },
        [_c("i", { staticClass: "fas fa-search" })]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-sm-3 col-6" }, [
        _c("span", { staticClass: "text text-sm" }, [_vm._v("Name")]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-4 col-6" }, [
        _c("span", { staticClass: "text text-sm" }, [_vm._v("E-mail")]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-3 col-6" }, [
        _c("span", { staticClass: "text text-sm" }, [_vm._v("Role(s)")]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-2 col-6" }, [
        _c("span", { staticClass: "text text-sm" }),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/users/item-list.vue":
/*!************************************************!*\
  !*** ./resources/js/views/users/item-list.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item-list.vue?vue&type=template&id=1a8586a2&scoped=true& */ "./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&");
/* harmony import */ var _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item-list.vue?vue&type=script&lang=js& */ "./resources/js/views/users/item-list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "1a8586a2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/users/item-list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/users/item-list.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/users/item-list.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./item-list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/users/item-list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./item-list.vue?vue&type=template&id=1a8586a2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/users/item-list.vue?vue&type=template&id=1a8586a2&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_list_vue_vue_type_template_id_1a8586a2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);