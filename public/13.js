(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _analysishighlights_analysishighlightBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../analysishighlights/analysishighlightBus */ "./resources/js/views/analysishighlights/analysishighlightBus.js");
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
  name: "highlights-list",
  props: {
    analysisrule_prop: {},
    highlights_prop: [],
    list_title_prop: "",
    list_color_prop: "",
    when_rule_result_is_prop: ""
  },
  watch: {
    highlights_prop: function highlights_prop(newValue, oldValue) {
      this.highlights = newValue;
    }
  },
  components: {
    StatusShow: function StatusShow() {
      return __webpack_require__.e(/*! import() */ 1).then(__webpack_require__.bind(null, /*! ../statuses/show */ "./resources/js/views/statuses/show.vue"));
    },
    StatusInlineDisplay: function StatusInlineDisplay() {
      return __webpack_require__.e(/*! import() */ 3).then(__webpack_require__.bind(null, /*! ../statuses/inline-display */ "./resources/js/views/statuses/inline-display.vue"));
    },
    highlighttextcolor: function highlighttextcolor() {
      return __webpack_require__.e(/*! import() */ 10).then(__webpack_require__.bind(null, /*! ./innerhighlights/highlighttextcolor */ "./resources/js/views/analysishighlights/innerhighlights/highlighttextcolor.vue"));
    },
    highlighttextsize: function highlighttextsize() {
      return __webpack_require__.e(/*! import() */ 11).then(__webpack_require__.bind(null, /*! ./innerhighlights/highlighttextsize */ "./resources/js/views/analysishighlights/innerhighlights/highlighttextsize.vue"));
    },
    highlighttextweight: function highlighttextweight() {
      return __webpack_require__.e(/*! import() */ 12).then(__webpack_require__.bind(null, /*! ./innerhighlights/highlighttextweight */ "./resources/js/views/analysishighlights/innerhighlights/highlighttextweight.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;

    _analysishighlights_analysishighlightBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('highlight_created', function (highlight) {
      if (_this.analysisrule.id === highlight.analysis_rule_id && _this.when_rule_result_is === highlight.when_rule_result_is) {
        _this.addHighlightToList(highlight);
      }
    });
    _analysishighlights_analysishighlightBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('highlight_updated', function (highlight) {
      if (_this.analysisrule.id === highlight.analysis_rule_id && _this.when_rule_result_is === highlight.when_rule_result_is) {
        _this.updateHighlightFromList(highlight);
      }
    });
    this.$parent.$on('analysisrule_reloaded', function (_ref) {
      var when_rule_result_is = _ref.when_rule_result_is,
          highlights = _ref.highlights,
          analysisrule = _ref.analysisrule;
      console.log('analysisrule_reloaded receive on list ' + _this.when_rule_result_is + ': ', when_rule_result_is, highlights, analysisrule);

      if (_this.analysisrule.id === analysisrule.id && _this.when_rule_result_is === when_rule_result_is) {
        _this.highlights = highlights;
      }
    });
  },
  created: function created() {//axios.get('/highlighttypes.fetchall').then(({data}) => this.highlighttypes = data);
  },
  data: function data() {
    return {
      analysisrule: this.analysisrule_prop,
      highlights: this.highlights_prop,
      list_title: this.list_title_prop,
      list_color: this.list_color_prop,
      when_rule_result_is: this.when_rule_result_is_prop,
      editing: false,
      loading: false,
      highlighttypes: [],
      highlight_collapse_icon: 'fas fa-chevron-down'
    };
  },
  methods: {
    editHighlit: function editHighlit(highlight) {
      _analysishighlights_analysishighlightBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('edit_highlight', highlight);
    },
    collapseHighlightClicked: function collapseHighlightClicked() {
      if (this.highlight_collapse_icon === 'fas fa-chevron-down') {
        this.highlight_collapse_icon = 'fas fa-chevron-up';
      } else {
        this.highlight_collapse_icon = 'fas fa-chevron-down';
      }
    },
    addHighlightToList: function addHighlightToList(highlight) {
      var highlightIndex = this.highlights.findIndex(function (c) {
        return highlight.id === c.id;
      }); // if this highlight doesn't exists in the list

      if (highlightIndex === -1) {
        this.highlights.push(highlight);
      }
    },
    updateHighlightFromList: function updateHighlightFromList(highlight) {
      var highlightIndex = this.reportattributes.findIndex(function (s) {
        return highlight.id === s.id;
      }); // if this highlight belongs to the list

      if (highlightIndex > -1) {
        this.highlights.splice(highlightIndex, 1, highlight);
      }
    },
    deleteHighlit: function deleteHighlit(highlight) {
      var _this2 = this;

      this.$swal({
        title: '<small>Are you sure ?</small>',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("/analysishighlights/".concat(highlight.uuid)).then(function (resp) {
            _this2.$swal({
              html: '<small>Highlight successfully deleted !</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _this2.$parent.$emit('highlight_deleted', highlight);
            });
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        }
      });
    }
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    },
    currentHighlightCollapseIcon: function currentHighlightCollapseIcon() {
      return this.highlight_collapse_icon;
    },
    highlights_list: function highlights_list() {
      return this.highlights;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "card collapsed-card border-0" }, [
    _c("header", [
      _c("div", { staticClass: "card-header-title row" }, [
        _c("div", { staticClass: "col-md-6 col-sm-8 col-12" }, [
          _c(
            "span",
            {
              class: "text-" + _vm.list_color + " text-xs",
              attrs: { "data-card-widget": "collapse" },
              on: {
                click: function ($event) {
                  return _vm.collapseHighlightClicked()
                },
              },
            },
            [
              _vm._v(
                "\n                    " +
                  _vm._s(_vm.list_title) +
                  "\n                "
              ),
            ]
          ),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-6 col-sm-4 col-12 text-right" }, [
          _vm.highlights
            ? _c(
                "span",
                { staticClass: "text text-xs" },
                [
                  _vm.highlights.length < 1
                    ? _c(
                        "b-tag",
                        {
                          attrs: {
                            type: "is-danger is-light",
                            size: "is-small",
                          },
                        },
                        [_vm._v(_vm._s(_vm.highlights.length))]
                      )
                    : _vm.highlights.length === 1
                    ? _c(
                        "b-tag",
                        {
                          attrs: {
                            type: "is-success is-light",
                            size: "is-small",
                          },
                        },
                        [_vm._v(_vm._s(_vm.highlights.length))]
                      )
                    : _c(
                        "b-tag",
                        {
                          attrs: {
                            type: "is-danger is-light",
                            size: "is-small",
                          },
                        },
                        [_vm._v(_vm._s(_vm.highlights.length))]
                      ),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: "btn btn-tool",
                      attrs: { type: "button", "data-card-widget": "collapse" },
                      on: {
                        click: function ($event) {
                          return _vm.collapseHighlightClicked()
                        },
                      },
                    },
                    [_c("i", { class: _vm.currentHighlightCollapseIcon })]
                  ),
                  _vm._v(" "),
                  _vm._m(0),
                ],
                1
              )
            : _vm._e(),
        ]),
      ]),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card-body p-0" }, [
      _c(
        "div",
        {
          staticClass: "card-body table-responsive p-0",
          staticStyle: { "min-height": "200px" },
        },
        [
          _c("table", { staticClass: "table m-0" }, [
            _vm.highlights ? _c("thead", [_vm._m(1)]) : _vm._e(),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.highlights_list, function (highlight, index) {
                return _vm.highlights_list.length
                  ? _c("tr", { staticClass: "text text-xs" }, [
                      _c("td", [
                        _c("span", { staticClass: "badge badge-default" }, [
                          _vm._v(_vm._s(highlight.highlighttype.name)),
                        ]),
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("status-inline-display", {
                            attrs: {
                              model_type_prop: highlight.model_type,
                              model_id_prop: highlight.id,
                              status_prop: highlight.status,
                            },
                          }),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c(highlight.highlighttype.view_name, {
                            ref: highlight.innerhighlight.id,
                            refInFor: true,
                            tag: "component",
                            attrs: {
                              model_type_prop: highlight.innerhighlight_type,
                              innerhighlight_prop: highlight.innerhighlight,
                            },
                          }),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", [
                        _c("div", { staticClass: "block" }, [
                          _c("span", {
                            staticClass: "fa fa-pencil-square-o text-warning",
                            on: {
                              click: function ($event) {
                                return _vm.editHighlit(highlight)
                              },
                            },
                          }),
                          _vm._v(" "),
                          _c("span", {
                            staticClass: "fa fa-trash text-danger",
                            on: {
                              click: function ($event) {
                                return _vm.deleteHighlit(highlight)
                              },
                            },
                          }),
                        ]),
                      ]),
                    ])
                  : _vm._e()
              }),
              0
            ),
          ]),
        ]
      ),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card-footer" }),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass: "btn btn-tool",
        attrs: { type: "button", "data-card-widget": "maximize" },
      },
      [_c("i", { staticClass: "fas fa-expand" })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", { staticClass: "text text-sm" }, [
      _c("th", [_vm._v("Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Status")]),
      _vm._v(" "),
      _c("th", [_vm._v("Details")]),
      _vm._v(" "),
      _c("th"),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/analysishighlights/list.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/analysishighlights/list.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=6a61c163&scoped=true& */ "./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "6a61c163",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/analysishighlights/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/analysishighlights/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=template&id=6a61c163&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/analysishighlights/list.vue?vue&type=template&id=6a61c163&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_6a61c163_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);