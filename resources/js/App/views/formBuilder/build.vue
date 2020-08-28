<template>
  <div class="form-build">
    <panel>
      <static-fields></static-fields>
    </panel>
    <draggable class="dropArea" v-model="fields" handle=".drag-handler">
      <panel class="tw-mt-4 tw-relative" v-for="(field, index) in fields" :key="index">
        <div class="drag-handler">
          <i class="fas fa-ellipsis-v"></i>
        </div>
        <div class="action-container">
          <div @click="cloneField(index)">
            <i class="far fa-clone"></i>
          </div>
          <div @click="removeField(index)" class="tw-mt-4">
            <i class="fas fa-trash"></i>
          </div>
        </div>

        <div v-if="field.type === 'section_divider'">
          <base-input v-model="field.title" placeholder="Section title goes here"></base-input>
        </div>

        <template v-else>
          <div class="tw-flex tw-items-center">
            <div class="input-wrapper">
              <base-input v-model="field.title" placeholder="Question"></base-input>
            </div>

            <div class="tw-ml-4">
              <el-select
                v-model="field.type"
                @input="field.value = ['DropdownField', 'MatrixField'].includes($event) ? [] : ''"
                placeholder="Select"
              >
                <el-option
                  v-for="({value, label}) in fieldTypes"
                  :key="value"
                  :value="value"
                  :label="label"
                ></el-option>
              </el-select>
            </div>

            <div class="tw-ml-4">
              <base-switch
                v-model="field.settings.required"
                active-text="Required"
                inactive-text="Required"
              ></base-switch>
            </div>
          </div>

          <div
            class="tw-border-t tw-border-gray-dark tw-my-4"
            v-if="!['TimeField', 'FileField'].includes(field.type)"
          ></div>

          <div
            class="tw-flex tw--ml-4 tw-items-center"
            v-if="['TextField', 'DateTimeField', 'TextBox', 'NumberField'].includes(field.type)"
          >
            <div class="input-wrapper tw-ml-4" v-if="['TextField', 'DateTimeField'].includes(field.type)">
              <base-select
                v-model="field.reference_target_type_id"
                @change="field.reference_target_id = null"
                name="target_type"
              >
                <el-option label="Stands alone" :value="null" v-if="field.type === 'TextField'">Stands alone</el-option>
                <el-option
                  v-for="(type, index) in targetTypes"
                  :key="index"
                  :label="`Refers to ${type.name}`"
                  :value="type.id"
                  :disabled="type.name === 'Form Fields' && formOptions.length === 0"
                >Refers to {{ type.name }}</el-option>
              </base-select>
            </div>

            <div
              class="tw-inline-flex tw-items-center tw-ml-4"
              v-if="['TextField', 'TextBox'].includes(field.type)"
            >
              <base-switch
                v-model="field.settings.isLimited"
                active-text="Character limit"
                inactive-text="Character limit"
              ></base-switch>
              <base-input
                :disabled="!field.settings.isLimited"
                v-model="field.settings.max"
                class="tw-w-16 tw-border-none tw-ml-4"
              ></base-input>
            </div>

            <div
              class="tw-inline-flex tw-items-center tw-ml-4"
              v-if="field.type === 'NumberField'"
            >
              <base-switch
                v-model="field.settings.isLimited"
                active-text="Default value"
                inactive-text="Default value"
              ></base-switch>
              <base-input
                :disabled="!field.settings.isLimited"
                v-model="field.settings.max"
                class="tw-w-16 tw-border-none tw-ml-4"
              ></base-input>
            </div>

            <el-radio-group
              class="tw-ml-4 tw-flex tw-flex-1"
              :value="getDateMode(field.settings)"
              @input="$event => setDateSettings($event, field.settings)"
              v-if="field.type === 'DateTimeField'"
            >
              <el-radio-button label="Any date"></el-radio-button>
              <el-radio-button label="Past only"></el-radio-button>
              <el-radio-button label="Future only"></el-radio-button>
            </el-radio-group>

            <div class="input-wrapper tw-ml-4" v-if="field.type === 'MatrixField'">
              <base-input v-model="field.description" placeholder="Additional information"></base-input>
            </div>
          </div>

          <div class="tw-flex tw-mt-4">
            <div class="tw-flex" v-if="getTargetName(field) === 'Records'">
              <base-select v-model="field.reference_target_id">
                <el-option
                  v-for="(type, index) in recordTypes"
                  :key="index"
                  :label="type.name"
                  :value="type.id"
                >{{ type.name }}</el-option>
              </base-select>
            </div>
            <div class="tw-flex" v-if="getTargetName(field) === 'Form Fields'">
              <base-select
                v-model="field.form_id"
                @change="retrieveFields($event); field.reference_target_id = null"
              >
                <el-option
                  v-for="(type, index) in formOptions"
                  :key="index"
                  :label="type.name"
                  :value="type.id"
                >{{ type.name }}</el-option>
              </base-select>

              <base-select
                v-model="field.reference_target_id"
                v-if="field.form_id != null"
                class="tw-ml-4"
              >
                <el-option
                  v-for="(type, index) in fieldOptions"
                  :key="index"
                  :label="type.title"
                  :value="type.id"
                >{{ type.title }}</el-option>
              </base-select>
            </div>
          </div>

          <div class="tw-flex tw--ml-4 tw-mt-4" v-if="field.type === 'DropdownField'">
            <div class="input-wrapper tw-ml-4">
              <label>List the options</label>
              <base-input
                v-model="field.settings.options"
                type="textarea"
                rows="3"
                placeholder="One option per line"
              ></base-input>
            </div>

            <div class="tw-ml-4">
              <label>Allow for</label>
              <el-switch
                class="tw-mt-2 tw-w-full"
                v-model="field.settings.single"
                active-text="One answer"
                inactive-text="Multiple answers"
                inactive-color="#001489"
              ></el-switch>
            </div>
          </div>

          <div class="tw-flex tw-mt-4" v-if="field.type === 'MatrixField'">
            <div class="input-wrapper">
              <label>List the questions</label>
              <base-input
                v-model="field.settings.matrix_questions"
                type="textarea"
                rows="3"
                placeholder="One option per line"
              ></base-input>
            </div>
            <div class="tw-ml-4 input-wrapper">
              <label>List the possible answers</label>
              <base-input
                v-model="field.settings.matrix_choices"
                type="textarea"
                rows="3"
                placeholder="One option per line"
              ></base-input>
            </div>
          </div>

          <div class="tw-flex tw-mt-4 tw-justify-between" v-if="field.type === 'DateTimeField'">
            <base-switch
              v-model="field.settings.includeTime"
              active-text="Include time"
              inactive-text="Include time"
            ></base-switch>
            <base-switch
              v-model="field.settings.quickMenu"
              active-text="Include shortcuts"
              inactive-text="Include shortcuts"
            ></base-switch>
            <base-switch
              v-model="field.settings.dateRange"
              active-text="Include date range"
              inactive-text="Include date range"
            ></base-switch>
          </div>
        </template>
      </panel>
    </draggable>

    <div class="tw-mt-4 tw-flex tw-justify-center">
      <base-button @click="addSection" outline>
        <i class="fas fa-plus tw-mr-2"></i> Add section
      </base-button>
      <base-button @click="addField" class="tw-ml-4">
        <i class="fas fa-plus tw-mr-2"></i> Add question
      </base-button>
    </div>
  </div>
</template>

<script>
import { mapFields } from "vuex-map-fields";
import draggable from "vuedraggable";
import _ from "lodash";
import fp from "lodash/fp";
import FormFieldTargetTypesRequest from "@/api/FormFieldTargetTypeRequest";
import mockData from "./mockData";
import otherMock from "./otherMock";
import GroupRequest from "@/api/GroupRequest";
import ProgramRequest from "@/api/ProgramRequest";
import RecordTypeRequest from "@/api/RecordTypeRequest";
import FormRequest from "@/api/FormRequest";
import FieldRequest from "@/api/FormFieldRequest";
import staticFields from './staticFields';

export default {
  name: "build",
  components: {
    draggable,
    staticFields
  },
  data() {
    return {
      formData: {
        name: "",
        description: "",
        participantName: "",
        team: "",
        dateCompleted: ""
      },
      targetTypes: [],
      fieldTypes: [
        { value: "TextField", label: "Text field" },
        { value: "NumberField", label: "Numeric field" },
        { value: "TextBox", label: "Paragraph field" },
        { value: "DateTimeField", label: "Date field" },
        { value: "TimeField", label: "Time field" },
        { value: "FileField", label: "Upload field" },
        { value: "DropdownField", label: "Multiple choice field" },
        { value: "MatrixField", label: "Matrix" }
      ],
      recordTypes: [],
      formOptions: [],
      fieldOptions: [],
      groupOptions: [],
      programOptions: []
    };
  },
  computed: {
    ...mapFields(["title", "description", "fields"])
  },
  created() {
    this.retrieveTargetTypes();
    this.retrieveRecordTypes();
    this.retrieveGroupOptions();
    this.retrieveProgramOptions();
    this.retrieveForms();
    // this.retrieveFields();

    // setTimeout(() => {
    //   console.log(this.getTargetOptions(this.fields[0]));
    // }, 5000);
  },
  methods: {
    getTargetName(field) {
      const targetType = fp.find(
        { id: field.reference_target_type_id },
        this.targetTypes
      );
      return targetType?.name;
    },
    getDateMode(settings) {
      return settings.pastOnly
        ? "Past only"
        : settings.futureOnly
        ? "Future only"
        : "Any date";
    },
    setDateSettings(mode, settings) {
      settings.pastOnly = mode === "Past only" ? true : false;
      settings.futureOnly = mode === "Future only" ? true : false;
    },
    retrieveTargetTypes() {
      const request = new FormFieldTargetTypesRequest({});

      request.retrieve().then(response => {
        this.targetTypes = response.data;
      });
    },
    retrieveRecordTypes() {
      const request = new RecordTypeRequest({});

      request.retrieve().then(response => {
        this.recordTypes = response.data;
      });
    },
    retrieveGroupOptions() {
      const request = new GroupRequest({});

      request.retrieve().then(response => {
        this.groupOptions = response.data;
      });
    },
    retrieveProgramOptions() {
      const request = new ProgramRequest({});

      request.retrieve().then(response => {
        this.programOptions = response.data;
      });
    },
    retrieveForms() {
      const request = new FormRequest({});

      request.retrieve().then(response => {
        this.formOptions = response.data;
      });
    },
    retrieveFields(form_id) {
      const request = new FieldRequest({});

      request.retrieve(form_id).then(response => {
        this.fieldOptions = response.data;
      });
    },
    addField() {
      const field = {
        type: "TextField",
        title: "",
        description: "",
        value: "",
        reference_target_type_id: null,
        reference_target_id: null,
        settings: {
          required: false,

          isLimited: false,
          max: 50,
          defaultNum: 5,

          pastOnly: false,
          futureOnly: false,
          quickMenu: false,
          includeTime: false,
          dateRange: false,
          dateType: "date",
          datePlaceHolder: "Pick a day",
          dateFormat: "yyyy/MM/dd",

          single: true,

          matrix_questions: "",
          matrix_choices: "",
          options: ""
        }
      };
      if (this.fields) {
        this.fields.push(field);
      } else {
        this.fields = [field];
      }
    },
    addSection() {
      const field = {
        type: "section_divider",
        titie: ""
      };
      if (this.fields) {
        this.fields.push(field);
      } else {
        this.fields = [field];
      }
    },
    removeField(index) {
      this.fields.splice(index, 1);
    },
    cloneField(index) {
      this.fields.push(_.cloneDeep(this.fields[index]));
    }
  }
};
</script>

<style>
.drag-handler {
  position: absolute;
  left: -24px;
  top: 50%;
  transform: translateY(-50%);
  @apply tw-cursor-pointer tw-text-indigo-base tw-text-lg;
}

.action-container {
  position: absolute;
  right: -36px;
  top: 50%;
  transform: translateY(-50%);
}

.action-container i {
  @apply tw-cursor-pointer tw-text-indigo-base tw-text-lg;
}

.input-wrapper {
  width: 250px;
}

.form-build .dropArea {
  min-width: 720px;
}
</style>
