(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    { attrs: { id: "preview" } },
    [
      _c(
        "el-container",
        [
          _c(
            "el-header",
            [
              _c(
                "el-menu",
                {
                  staticClass: "w-full",
                  attrs: {
                    "default-active": _vm.$route.path,
                    "background-color": "#eef1f6",
                    "active-text-color": "#409EFF",
                    mode: "horizontal",
                    router: ""
                  },
                  on: { select: _vm.handleSelect }
                },
                [
                  _c(
                    "el-menu-item",
                    {
                      staticClass: "font-bold focus:font-extrabold",
                      attrs: { "default-active": "", index: "/NewForm" }
                    },
                    [_vm._v("Form Builder")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-menu-item",
                    {
                      staticClass: "font-bold focus:font-extrabold",
                      attrs: { index: "/Preview" }
                    },
                    [_vm._v("Preview Form")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-menu-item",
                    {
                      staticClass: "dock-right font-bold focus:font-extrabold",
                      attrs: { index: "/" },
                      on: { click: _vm.buildForm }
                    },
                    [_vm._v("Finish and Build!")]
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("el-main", [_c("h1", [_vm._v("This is a completed form!")])])
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/FormBuilder/views/formPreview.vue":
/*!********************************************************!*\
  !*** ./resources/js/FormBuilder/views/formPreview.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formPreview.vue?vue&type=template&id=159bef3d&scoped=true& */ "./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true&");
/* harmony import */ var _formPreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./formPreview.vue?vue&type=script&lang=js& */ "./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _formPreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "159bef3d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/FormBuilder/views/formPreview.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./formPreview.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/FormBuilder/views/formPreview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./formPreview.vue?vue&type=template&id=159bef3d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/FormBuilder/views/formPreview.vue?vue&type=template&id=159bef3d&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPreview_vue_vue_type_template_id_159bef3d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);