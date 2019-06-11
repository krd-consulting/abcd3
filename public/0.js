(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    record: Array | Object
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570& ***!
  \************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "tw-flex tw-flex-grow" }, [
    _c("div", { staticClass: "tw-flex-1" }, [
      _c(
        "div",
        {
          staticClass:
            "tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500"
        },
        [_c("span", [_vm._v(_vm._s(_vm.record.program_status.status.name))])]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "tw-text-sm tw-text-gray-500" }, [
        _c("span", [
          _vm._v("Since " + _vm._s(_vm.record.program_status.created_at))
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "tw-flex-1" }, [
      _c("span", [_vm._v(_vm._s(_vm.record.enrolled_at))])
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "tw-flex-1" },
      [
        _vm.record.program_status.notes == "" ||
        _vm.record.program_status.notes == null
          ? _c(
              "base-button",
              {
                staticClass:
                  "tw-py-2 tw-px-0 tw-text-gray-500 tw-font-semibold tw-border-none hover:tw-bg-transparent hover:tw-text-blue"
              },
              [
                _c(
                  "base-icon",
                  { staticClass: "tw-text-sm tw-align-middle tw-mr-1" },
                  [_vm._v("add")]
                ),
                _vm._v(" "),
                _c("span", { staticClass: "tw-text-xs tw-align-middle" }, [
                  _vm._v("Add Note")
                ])
              ],
              1
            )
          : _c("p", [_vm._v(_vm._s(_vm.record.program_status.notes))])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataClient.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataClient.vue ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pivotDataClient.vue?vue&type=template&id=71112570& */ "./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570&");
/* harmony import */ var _pivotDataClient_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pivotDataClient.vue?vue&type=script&lang=js& */ "./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _pivotDataClient_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__["render"],
  _pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/App/components/programRecord/pivotDataClient.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataClient_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pivotDataClient.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataClient_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570& ***!
  \******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pivotDataClient.vue?vue&type=template&id=71112570& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataClient.vue?vue&type=template&id=71112570&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataClient_vue_vue_type_template_id_71112570___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);