(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _App_views_record_profile_addGroup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/App/views/record/profile/addGroup */ "./resources/js/App/views/record/profile/addGroup.vue");
/* harmony import */ var _App_views_record_profile_addCase__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/App/views/record/profile/addCase */ "./resources/js/App/views/record/profile/addCase.vue");
/* harmony import */ var _App_components_record_primaryData__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/App/components/record/primaryData */ "./resources/js/App/components/record/primaryData.vue");
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
  components: {
    AddGroup: _App_views_record_profile_addGroup__WEBPACK_IMPORTED_MODULE_0__["default"],
    AddCase: _App_views_record_profile_addCase__WEBPACK_IMPORTED_MODULE_1__["default"],
    PrimaryData: _App_components_record_primaryData__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  props: {
    record: Array | Object,
    program: Array | Object
  },
  computed: {
    casesCount: function casesCount() {
      var noun = 'case';
      if (this.record.cases_count != 1) noun = 'cases';
      return "".concat(this.record.cases_count, " ").concat(noun);
    },
    groupsCount: function groupsCount() {
      var noun = 'group';
      if (this.record.groups_count != 1) noun = 'groups';
      return "".concat(this.record.groups_count, " ").concat(noun);
    }
  },
  data: function data() {
    return {
      addGroupModal: {
        active: false
      },
      addCaseModal: {
        active: false
      }
    };
  },
  methods: {
    addGroup: function addGroup() {
      this.addGroupModal.active = true;
    },
    addCase: function addCase() {
      this.addCaseModal.active = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _api_RecordsAvailableForCaseloadRequest__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/api/RecordsAvailableForCaseloadRequest */ "./resources/js/api/RecordsAvailableForCaseloadRequest.js");
/* harmony import */ var _api_CasesRequest__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/api/CasesRequest */ "./resources/js/api/CasesRequest.js");
/* harmony import */ var _App_components_transfer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/App/components/transfer */ "./resources/js/App/components/transfer.vue");
/* harmony import */ var _App_components_record_primaryData__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/App/components/record/primaryData */ "./resources/js/App/components/record/primaryData.vue");
/* harmony import */ var _App_components_record_secondaryData__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/App/components/record/secondaryData */ "./resources/js/App/components/record/secondaryData.vue");
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
  components: {
    Transfer: _App_components_transfer__WEBPACK_IMPORTED_MODULE_2__["default"],
    PrimaryData: _App_components_record_primaryData__WEBPACK_IMPORTED_MODULE_3__["default"],
    SecondaryData: _App_components_record_secondaryData__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: {
    active: Boolean,
    recordId: {
      type: Number | String,
      "default": ''
    },
    recordType: {
      type: String,
      "default": ''
    },
    programId: {
      type: Number | String,
      "default": ''
    }
  },
  computed: {
    record: function record() {
      if (this.recordId === '') return this.$route.params.record;
      return this.recordId;
    },
    type: function type() {
      if (this.recordType === '') return this.$route.params.recordType;
      return this.recordType;
    },
    program: function program() {
      if (this.programId === '') return this.$route.params.program;
      return this.programId;
    }
  },
  data: function data() {
    return {
      casesRequest: new _api_CasesRequest__WEBPACK_IMPORTED_MODULE_1__["default"]({}),
      availableCasesRequest: new _api_RecordsAvailableForCaseloadRequest__WEBPACK_IMPORTED_MODULE_0__["default"]({}),
      selected: [],
      notSelected: [],
      selectedParams: {
        ascending: true,
        sortBy: 'id',
        page: 1,
        perPage: 10,
        total: 0
      },
      notSelectedParams: {
        ascending: true,
        sortBy: 'id',
        page: 1,
        perPage: 10,
        total: 0
      }
    };
  },
  methods: {
    close: function close() {
      this.$emit('update:active', false);
      this.$emit('close');
    },
    loadSelected: function loadSelected() {
      var _this = this;

      this.casesRequest.setFields({
        params: this.selectedParams
      });
      this.casesRequest.retrieve(this.program, this.type, this.record).then(function (response) {
        _this.selected = response.data;
        _this.selectedParams.total = response.meta.total;
      });
    },
    loadNotSelected: function loadNotSelected() {
      var _this2 = this;

      this.availableCasesRequest.setFields({
        params: this.notSelectedParams
      });
      this.availableCasesRequest.retrieve(this.program, this.type, this.record).then(function (response) {
        _this2.notSelected = response.data;
        _this2.notSelectedParams.total = response.meta.total;
      });
    },
    open: function open() {
      this.loadSelected();
      this.loadNotSelected();
    },
    handleSelectedPageChange: function handleSelectedPageChange(page) {
      this.selectedParams.page = page;
      this.loadSelected();
    },
    handleNotSelectedPageChange: function handleNotSelectedPageChange(page) {
      this.notSelectedParams.page = page;
      this.loadNotSelected();
    },
    searchSelected: function searchSelected(search) {
      this.selectedParams.search = search;
      this.loadSelected();
    },
    searchNotSelected: function searchNotSelected(search) {
      this.notSelectedParams.search = search;
      this.loadNotSelected();
    },
    add: function add(id) {
      var _this3 = this;

      this.casesRequest.store(this.program, this.type, this.record, id).then(function (response) {
        _this3.open();
      })["catch"](function (error) {
        _this3.$message({
          type: 'error',
          message: error.message
        });
      });
    },
    remove: function remove(id) {
      var _this4 = this;

      this.casesRequest.destroy(this.program, this.type, this.record, id).then(function (response) {
        _this4.open();
      })["catch"](function (error) {
        _this4.$message({
          type: 'error',
          message: error.message
        });
      });
    }
  },
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
        [_c("span", [_vm._v(_vm._s(_vm.casesCount))])]
      ),
      _vm._v(" "),
      _c(
        "div",
        [
          _c(
            "add-case",
            {
              attrs: {
                "record-id": _vm.record.id,
                active: _vm.addCaseModal.active
              },
              on: {
                "update:active": function($event) {
                  return _vm.$set(_vm.addCaseModal, "active", $event)
                },
                close: function($event) {
                  return _vm.retrieve()
                }
              }
            },
            [
              _c(
                "template",
                { slot: "title" },
                [
                  _vm._v("\n            \t\t\t\tCaseload of "),
                  _c("primary-data", {
                    attrs: { record: _vm.record, fields: _vm.record.fields }
                  })
                ],
                1
              )
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "base-button",
            {
              staticClass:
                "tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none",
              on: { click: _vm.addCase }
            },
            [
              _c(
                "base-icon",
                { staticClass: "tw-text-sm tw-align-middle tw-mr-1" },
                [_vm._v("add")]
              ),
              _vm._v(" "),
              _c("span", { staticClass: "tw-text-xs tw-align-middle" }, [
                _vm._v("Manage Cases")
              ])
            ],
            1
          )
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "tw-flex-1" }, [
      _c(
        "div",
        {
          staticClass:
            "tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500"
        },
        [_c("span", [_vm._v(_vm._s(_vm.groupsCount))])]
      ),
      _vm._v(" "),
      _c(
        "div",
        [
          _c("add-group", {
            attrs: {
              "record-id": _vm.record.id,
              active: _vm.addGroupModal.active
            },
            on: {
              "update:active": function($event) {
                return _vm.$set(_vm.addGroupModal, "active", $event)
              },
              close: function($event) {
                return _vm.retrieve()
              }
            }
          }),
          _vm._v(" "),
          _c(
            "base-button",
            {
              staticClass:
                "tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none",
              on: { click: _vm.addGroup }
            },
            [
              _c(
                "base-icon",
                { staticClass: "tw-text-sm tw-align-middle tw-mr-1" },
                [_vm._v("add")]
              ),
              _vm._v(" "),
              _c("span", { staticClass: "tw-text-xs tw-align-middle" }, [
                _vm._v("Manage Groups")
              ])
            ],
            1
          )
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "tw-flex-1" }, [
      _c("span", [_vm._v(_vm._s(_vm.record.enrolled_at))])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c& ***!
  \************************************************************************************************************************************************************************************************************************/
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
  return _c("transfer", {
    attrs: {
      active: _vm.active,
      notSelected: _vm.notSelected,
      selected: _vm.selected,
      selectedParams: _vm.selectedParams,
      notSelectedParams: _vm.notSelectedParams
    },
    on: {
      "selected-page-change": _vm.handleSelectedPageChange,
      "not-selected-page-change": _vm.handleNotSelectedPageChange,
      "search-selected": _vm.searchSelected,
      "search-not-selected": _vm.searchNotSelected,
      add: _vm.add,
      remove: _vm.remove,
      open: _vm.open,
      close: _vm.close
    },
    scopedSlots: _vm._u(
      [
        {
          key: "title",
          fn: function() {
            return [_vm._t("title", [_vm._v("Manage Cases")])]
          },
          proxy: true
        },
        {
          key: "caption",
          fn: function() {
            return [
              _c("p", [
                _vm._v(
                  "Check available records to add them to the caseload or uncheck current records to remove them from the caseload."
                )
              ])
            ]
          },
          proxy: true
        },
        {
          key: "current-items-title",
          fn: function() {
            return [_vm._v("\n            Current Caseload\n        ")]
          },
          proxy: true
        },
        {
          key: "available-items-title",
          fn: function() {
            return [_vm._v("\n            Available Records\n        ")]
          },
          proxy: true
        },
        {
          key: "current-item-title",
          fn: function(ref) {
            var item = ref.item
            return [
              _c("primary-data", {
                attrs: { record: item, fields: item.fields }
              })
            ]
          }
        },
        {
          key: "current-item-subtitle",
          fn: function(ref) {
            var item = ref.item
            return [
              _c("secondary-data", {
                staticClass: "tw-text-xs",
                attrs: { record: item, fields: item.fields }
              })
            ]
          }
        },
        {
          key: "available-item-title",
          fn: function(ref) {
            var item = ref.item
            return [
              _c("primary-data", {
                attrs: { record: item, fields: item.fields }
              })
            ]
          }
        },
        {
          key: "available-item-subtitle",
          fn: function(ref) {
            var item = ref.item
            return [
              _c("secondary-data", {
                staticClass: "tw-text-xs",
                attrs: { record: item, fields: item.fields }
              })
            ]
          }
        },
        {
          key: "empty-available-items",
          fn: function() {
            return [
              _vm._v("\n            No more available records.\n        ")
            ]
          },
          proxy: true
        }
      ],
      null,
      true
    )
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataStaff.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataStaff.vue ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pivotDataStaff.vue?vue&type=template&id=4c44634b& */ "./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b&");
/* harmony import */ var _pivotDataStaff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pivotDataStaff.vue?vue&type=script&lang=js& */ "./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _pivotDataStaff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/App/components/programRecord/pivotDataStaff.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataStaff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pivotDataStaff.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataStaff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./pivotDataStaff.vue?vue&type=template&id=4c44634b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/components/programRecord/pivotDataStaff.vue?vue&type=template&id=4c44634b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pivotDataStaff_vue_vue_type_template_id_4c44634b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/App/views/record/profile/addCase.vue":
/*!***********************************************************!*\
  !*** ./resources/js/App/views/record/profile/addCase.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addCase.vue?vue&type=template&id=3b3af04c& */ "./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c&");
/* harmony import */ var _addCase_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addCase.vue?vue&type=script&lang=js& */ "./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addCase_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/App/views/record/profile/addCase.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addCase_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./addCase.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/views/record/profile/addCase.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addCase_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c&":
/*!******************************************************************************************!*\
  !*** ./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./addCase.vue?vue&type=template&id=3b3af04c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/App/views/record/profile/addCase.vue?vue&type=template&id=3b3af04c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addCase_vue_vue_type_template_id_3b3af04c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/api/CasesRequest.js":
/*!******************************************!*\
  !*** ./resources/js/api/CasesRequest.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _core_Request__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../core/Request */ "./resources/js/core/Request.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { return function () { var Super = _getPrototypeOf(Derived), result; if (_isNativeReflectConstruct()) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }



var CasesRequest = /*#__PURE__*/function (_Request) {
  _inherits(CasesRequest, _Request);

  var _super = _createSuper(CasesRequest);

  function CasesRequest() {
    _classCallCheck(this, CasesRequest);

    return _super.apply(this, arguments);
  }

  _createClass(CasesRequest, [{
    key: "retrieve",
    value: function retrieve(program, recordType, record) {
      return this.get("/api/programs/".concat(program, "/records/").concat(recordType, "/").concat(record, "/cases"));
    }
  }, {
    key: "store",
    value: function store(program, recordType, record, recordCase) {
      return this.post("/api/programs/".concat(program, "/records/").concat(recordType, "/").concat(record, "/cases/").concat(recordCase));
    }
  }, {
    key: "destroy",
    value: function destroy(program, recordType, record, recordCase) {
      return this["delete"]("/api/programs/".concat(program, "/records/").concat(recordType, "/").concat(record, "/cases/").concat(recordCase));
    }
  }]);

  return CasesRequest;
}(_core_Request__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (CasesRequest);

/***/ }),

/***/ "./resources/js/api/RecordsAvailableForCaseloadRequest.js":
/*!****************************************************************!*\
  !*** ./resources/js/api/RecordsAvailableForCaseloadRequest.js ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _core_Request__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../core/Request */ "./resources/js/core/Request.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { return function () { var Super = _getPrototypeOf(Derived), result; if (_isNativeReflectConstruct()) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }



var RecordsAvailableForCaseloadRequest = /*#__PURE__*/function (_Request) {
  _inherits(RecordsAvailableForCaseloadRequest, _Request);

  var _super = _createSuper(RecordsAvailableForCaseloadRequest);

  function RecordsAvailableForCaseloadRequest() {
    _classCallCheck(this, RecordsAvailableForCaseloadRequest);

    return _super.apply(this, arguments);
  }

  _createClass(RecordsAvailableForCaseloadRequest, [{
    key: "retrieve",
    value: function retrieve(program, recordType, record) {
      return this.get("/api/programs/".concat(program, "/records/").concat(recordType, "/").concat(record, "/available-cases"));
    } // store() {
    // 	return this.post(`/api/programs/client-statuses`);
    // }
    // edit(status) {
    // 	return this.get(`/api/programs/client-statuses/${status}/edit`);
    // }
    // update(status) {
    // 	return this.patch(`/api/programs/client-statuses/${status}`);
    // }
    // destroy(status) {
    // 	return this.delete(`/api/programs/client-statuses/${status}`);
    // }

  }]);

  return RecordsAvailableForCaseloadRequest;
}(_core_Request__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (RecordsAvailableForCaseloadRequest);

/***/ })

}]);