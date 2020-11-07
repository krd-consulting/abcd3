<template>
  <div>
    <page-title :title="form.name" has-bookmark class="tw-px-8"></page-title>
    <p class="tw-text-sm tw-text-gray-dark tw-px-8">{{ form.description }}</p>
    <div class="tw-items-center tw-flex tw-flex-col">
      <div
        class="tw-w-full tw-flex tw-justify-end tw-py-2 tw-px-4 tw-border-b-2 tw-border-gray-base tw-mb-8"
      >
        <base-button :disabled="disableSubmit" gray @click="$router.replace('/forms')">Discard</base-button>
        <base-button :disabled="disableSubmit" @click="submit(false)">Save form</base-button>
      </div>
      <div class="form-preview">
        <div class="tw-flex">
          <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">{{ collectingLabel }}</label>
          <el-select
            v-if="targetName != 'Record'"
            v-model="entryData.target_id"
            @click.native="retrieveFormTargetItems"
            filterable
            remote
            :remote-method="retrieveFormTargetItems"
            name="type"
            placeholder=" "
            @change="request.errors.clear('team_id')"
          >
            <el-option
              v-for="(item, index) in targetItems"
              :key="index"
              :label="item.name"
              :value="item.id"
            >{{ item.name }}</el-option>
          </el-select>
          <el-select
            v-else
            v-model="entryData.target_id"
            filterable
            remote
            :remote-method="retrieveFormTargetItems"
            name="type"
            placeholder=" "
            @change="entryRequest.errors.clear('target_id')"
          >
            <el-option
              v-for="(item, index) in targetItems"
              :key="index"
              :label="item.fields.full_name.value"
              :value="item.id"
            ></el-option>
          </el-select>
          <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
        </div>
        <div class="tw-flex tw-mt-4">
          <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">Team</label>
          <el-select v-model="entryData.team_id" placeholder=" " remote :remote-method="retrieveTeams">
            <el-option v-for="team in teams" :key="team.id" :label="team.name" :value="team.id"></el-option>
          </el-select>
          <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
        </div>
        <div class="tw-flex tw-mt-4">
          <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">Date Completed</label>
          <el-date-picker v-model="entryData.completed_at" format="yyyy-MM-DD" class="tw-w-full"></el-date-picker>
          <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
        </div>
        <div class="tw-flex tw-mt-4" v-if="form.type === 'Pre-post'">
          <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">Form Completed For</label>
          <el-select v-model="formCompletedFor" placeholder="Select">
            <el-option
              v-for="item in ['Pre', 'Interim', 'Post']"
              :key="item"
              :label="item"
              :value="item"
            ></el-option>
          </el-select>
          <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
        </div>
        <div v-for="(field, index) in form.field_layout" :key="index">
          <div
            class="tw-font-semibold tw-text-lg tw-border-b tw-my-8"
            v-if="field.type === 'section_divider'"
            v-html="field.title"
          ></div>
          <div class="tw-w-full tw-mt-4" v-else-if="field.type === 'MatrixField'">
            <div class="tw-mb-2">
              <label>{{ field.title }}</label>
            </div>
            <div class="tw-flex">
              <div class="tw-w-24"></div>
              <div
                v-for="answer in field.settings.matrix_choices
                  .split('\n')
                  .filter(item => item)"
                :key="answer"
                class="tw-text-sm tw-w-24 tw-text-center"
              >{{ answer }}</div>
            </div>
            <div
              v-for="(question, index) in field.questions"
              :key="index"
              class="tw-flex tw-items-center tw-bg-gray-lightest tw-mt-2 tw-py-2"
            >
              <div class="tw-text-sm tw-w-24 tw-text-center">{{ question.title }}</div>
              <el-radio-group v-model="entryData[question.column_name]" class="without-label">
                <el-radio
                  v-for="answer in field.choices"
                  :key="answer"
                  :label="answer"
                  class="tw-w-24 tw-text-center tw-mr-0 tw-mb-0"
                ></el-radio>
              </el-radio-group>
            </div>
          </div>
          <div v-else class="tw-w-full tw-flex tw-mt-4">
            <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">{{ field.title }}</label>
            <base-input
              type="number"
              v-if="field.type === 'NumberField'"
              v-model="entryData[field.column_name]"
            ></base-input>
            <template v-if="field.type === 'TextField'">
              <textField :field-data="field" v-model="entryData[field.column_name]"></textField>
            </template>
            <base-input
              type="textarea"
              rows="3"
              v-if="field.type === 'TextBox'"
              v-model="entryData[field.column_name]"
            ></base-input>
            <div class="tw-w-full" v-if="field.type === 'DateTimeField'">
              <el-date-picker
                :type="field.settings.includeTime ? 'datetimerange' : 'daterange'"
                v-show="field.settings.dateRange"
                v-model="entryData[field.column_name]"
                format="yyyy-MM-DD HH:mm"
                :picker-options="getOptions(field.settings)"
              ></el-date-picker>
              <el-date-picker
                :type="field.settings.includeTime ? 'datetime' : 'date'"
                v-show="!field.settings.dateRange"
                v-model="entryData[field.column_name]"
                format="yyyy-MM-DD HH:mm"
                :picker-options="getOptions(field.settings)"
              ></el-date-picker>
            </div>
            <div class="tw-w-full" v-if="field.type === 'TimeField'">
              <el-time-picker
                v-model="entryData[field.column_name]"
                format="HH:mm"
                :picker-options="{ format: 'HH:mm' }"
              ></el-time-picker>
            </div>
            <div class="tw-w-full" v-if="field.type === 'DropdownField'">
              <div v-if="!field.settings.single">
                <el-checkbox-group
                  v-model="entryData[field.column_name]"
                  class="tw-grid-cols-3 tw-grid tw-gap-4 tw-mt-2"
                >
                  <el-checkbox
                    v-for="option in field.settings.options
                  .split('\n')
                  .filter(item => item)"
                    :key="option"
                    :label="option"
                  ></el-checkbox>
                </el-checkbox-group>
              </div>
              <div
                v-else-if="
              field.settings.options.split('\n').filter(item => item).length < 5
            "
              >
                <el-radio-group
                  v-model="entryData[field.column_name]"
                  class="tw-grid-cols-3 tw-grid tw-gap-4 tw-mt-2"
                >
                  <el-radio
                    v-for="option in field.settings.options
                  .split('\n')
                  .filter(item => item)"
                    :key="option"
                    :label="option"
                  ></el-radio>
                </el-radio-group>
              </div>
              <div v-else>
                <el-select id="target" v-model="entryData[field.column_name]">
                  <el-option
                    v-for="option in field.settings.options
                  .split('\n')
                  .filter(item => item)"
                    :key="option"
                    :value="option"
                    :label="option"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div
              class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3"
              :class="{ 'tw-opacity-0': !field.settings.required }"
            >Required</div>
          </div>
        </div>
        <div class="tw-flex tw-justify-end tw-mt-8">
          <base-button gray :disabled="disableSubmit" @click="submit()">Submit & Create another</base-button>
          <base-button :disabled="disableSubmit" @click="submit(false)">Submit form</base-button>
          <div
            class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3 tw-opacity-0"
          >Required</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import MatrixField from "@/components/formFields/matrix.vue";
import RadioField from "@/components/formFields/radio.vue";
import TextField from "./fields/textField.vue";
import TextBox from "@/components/formFields/textBox.vue";
import NumberField from "@/components/formFields/numeric.vue";
import DropdownField from "@/components/formFields/dropdown.vue";
import CheckBoxField from "@/components/formFields/checkbox.vue";
import DateField from "@/components/formFields/datePicker.vue";
import TimeField from "@/components/formFields/timePicker.vue";
import FileField from "@/components/formFields/upload.vue";
import SectionDivider from "@/components/formFields/sectionDivider.vue";

import Request from "@/api/FormRequest";
import EntryRequest from "@/api/FormEntryRequest";
import TeamRequest from "@/api/TeamRequest";
import RecordRequest from "@/api/RecordRequest";
import RecordPrimaryData from "@/App/components/record/primaryData";
import FormFieldTargetTypesRequest from "@/api/FormFieldTargetTypeRequest";
import FormFieldRequest from "@/api/FormFieldRequest";
import GroupRequest from "@/api/GroupRequest";
import ProgramRequest from "@/api/ProgramRequest";

import { targetTypes } from "@/helpers";
import pluralize from "pluralize";
import fp from "lodash/fp";
import _ from "lodash";

export default {
  data() {
    return {
      request: new Request({}),
      formCompletedFor: "",
      entryRequest: new EntryRequest({}),
      teamRequest: new TeamRequest(),
      team: "",
      form: {
        target_type: {
          name: null
        },
        target: {
          name: null
        }
      },
      teamRequestParams: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 10,
        search: ""
      },
      teams: [],
      targetRequest: {},
      targetParams: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 10,
        search: ""
      },
      recordParams: {
        ascending: true,
        sortBy: "field_1_value",
        page: 1,
        perPage: 10,
        search: ""
      },
      targetItems: [],
      entryData: {},
      value: "",
      inputName: "",
      dateCompleted: "",
      disableSubmit: false,
      prePost: [
        { id: 0, value: "Pre-test" },
        { id: 1, value: "Intermittent" },
        { id: 2, value: "Post-test" }
      ],
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      },
      targetTypes: null
    };
  },

  computed: {
    targetName() {
      return targetTypes[this.form.target_type.name];
    },
    collectingLabel() {
      return (
        pluralize.singular(
          this.form.target?.name || this.form.target_type.name || ""
        ) + " Name"
      );
    }
  },

  components: {
    MatrixField,
    RadioField,
    TextField,
    TextBox,
    NumberField,
    DropdownField,
    CheckBoxField,
    DateField,
    TimeField,
    FileField,
    SectionDivider,
    RecordPrimaryData
  },

  methods: {
    getOptions(settings) {
      const shortcuts = [];
      if (settings.quickMenu) {
        if (settings.dateRange) {
          if (!settings.futureOnly) {
            shortcuts.push({
              text: "Last week",
              onClick(picker) {
                picker.$emit("pick", [
                  moment()
                    .subtract(7, "day")
                    .toDate(),
                  moment().toDate()
                ]);
              }
            });
            shortcuts.push({
              text: "Last month",
              onClick(picker) {
                picker.$emit("pick", [
                  moment()
                    .subtract(30, "day")
                    .toDate(),
                  moment().toDate()
                ]);
              }
            });
          }
          if (!settings.pastOnly) {
            shortcuts.push({
              text: "Next week",
              onClick(picker) {
                picker.$emit("pick", [
                  moment().toDate(),
                  moment()
                    .add(7, "day")
                    .toDate()
                ]);
              }
            });
            shortcuts.push({
              text: "Next month",
              onClick(picker) {
                picker.$emit("pick", [
                  moment().toDate(),
                  moment()
                    .add(30, "day")
                    .toDate()
                ]);
              }
            });
          }
        } else {
          if (!settings.futureOnly) {
            shortcuts.push({
              text: "Yesterday",
              onClick(picker) {
                picker.$emit(
                  "pick",
                  moment()
                    .subtract(1, "day")
                    .toDate()
                );
              }
            });
          }
          shortcuts.push({
            text: "Today",
            onClick(picker) {
              picker.$emit("pick", moment().toDate());
            }
          });
          if (!settings.pastOnly) {
            shortcuts.push({
              text: "Tomorrow",
              onClick(picker) {
                picker.$emit(
                  "pick",
                  moment()
                    .add(1, "day")
                    .toDate()
                );
              }
            });
          }
        }
      }
      return {
        disabledDate(date) {
          if (settings.pastOnly && !moment(date).isBefore(moment(), "days")) {
            return true;
          }
          if (settings.futureOnly && !moment(date).isAfter(moment(), "days")) {
            return true;
          }
          return false;
        },
        shortcuts: _.isEmpty(shortcuts) ? null : shortcuts,
        format: "yyyy-MM-DD HH:mm"
      };
    },

    addFile(field, fileId) {
      if (this.entryData[field] == null) {
        this.entryData[field] = [fileId];
      } else {
        this.entryData[field].push(fileId);
      }
    },

    retrieveTeams(keywords) {
      this.teamRequestParams.search = keywords;

      this.teamRequest.setFields({
        params: { ...this.teamRequestParams }
      });

      let getTeams = this.teamRequest.retrieve();

      getTeams.then(response => {
        this.teams = response.data;
      });

      return getTeams;
    },

    retrieve(form = this.$route.params.form) {
      return this.request.show(form).then(response => {
        this.form = response.data;
        console.log(this.form);
      });
    },

    retrieveFormTargetItems(keywords, callback) {
      import(`@/api/${this.targetName}Request`).then(foo => {
        this.targetRequest = new foo.default({});

        this.targetParams.search = keywords;
        let params = this.targetParams;

        if (this.targetName == "Record") {
          this.recordParams.search = keywords;
          params = this.recordParams;
        }

        this.targetRequest.setFields({
          params
        });

        const args = this.form.target != null ? this.form.target.name : null;

        this.targetRequest.retrieve(args).then(response => {
          this.targetItems = response.data;
        });
      });
    },

    retrieveTargetTypes() {
      const request = new FormFieldTargetTypesRequest({});

      request.retrieve().then(response => {
        this.targetTypes =  response.data;
      });
    },

    submit(createAnother = true) {
      this.disableSubmit = true;

      this.entryRequest = new EntryRequest(this.entryData);

      this.entryRequest
        .store(this.$route.params.form)
        .then(response => {
          this.$message({
            type: "success",
            message: "Form Entry Submitted!"
          });

          if (createAnother) {
            window.location.reload();
          } else {
            this.$router.replace("/forms");
          }
        })
        .catch(error => {
          this.$message({
            type: "error",
            message: "You may have entered incorrect data."
          });

          this.disableSubmit = false;
        });
    }
  },

  created() {
    this.retrieve();
    this.retrieveTeams();
    this.retrieveTargetTypes();
  }
};
</script>
