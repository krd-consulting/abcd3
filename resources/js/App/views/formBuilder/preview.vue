<template>
  <div class="form-preview">
    <static-fields></static-fields>
    <div v-for="(field, index) in validFields" :key="index">
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
          v-for="(question, index) in field.settings.matrix_questions
            .split('\n')
            .filter(item => item)"
          :key="question"
          class="tw-flex tw-items-center tw-bg-gray-lightest tw-mt-2 tw-py-2"
        >
          <div class="tw-text-sm tw-w-24 tw-text-center">{{ question }}</div>
          <el-radio-group v-model="field.value[index]" class="without-label">
            <el-radio
              v-for="answer in field.settings.matrix_choices
                .split('\n')
                .filter(item => item)"
              :key="answer"
              :label="answer"
              class="tw-w-24 tw-text-center tw-mr-0 tw-mb-0"
            ></el-radio>
          </el-radio-group>
        </div>
      </div>
      <div v-else class="tw-w-full tw-flex tw-mt-4">
        <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">{{ field.title }}</label>
        <base-input type="number" v-if="field.type === 'NumberField'" v-model="field.value"></base-input>
        <base-input v-if="field.type === 'TextField'" v-model="field.value"></base-input>
        <base-input type="textarea" rows="3" v-if="field.type === 'TextBox'" v-model="field.value"></base-input>
        <div class="tw-w-full" v-if="field.type === 'DateTimeField'">
          <el-date-picker
            :type="field.settings.includeTime ? 'datetimerange' : 'daterange'"
            v-show="field.settings.dateRange"
            v-model="field.value"
            format="yyyy-MM-DD HH:mm"
            :picker-options="getOptions(field.settings)"
          ></el-date-picker>
          <el-date-picker
            :type="field.settings.includeTime ? 'datetime' : 'date'"
            v-show="!field.settings.dateRange"
            v-model="field.value"
            format="yyyy-MM-DD HH:mm"
            :picker-options="getOptions(field.settings)"
          ></el-date-picker>
        </div>
        <div class="tw-w-full" v-if="field.type === 'TimeField'">
          <el-time-picker
            v-model="field.value"
            format="HH:mm"
            :picker-options="{ format: 'HH:mm' }"
          ></el-time-picker>
        </div>
        <div class="tw-w-full" v-if="field.type === 'DropdownField'">
          <div v-if="!field.settings.single">
            <el-checkbox-group
              v-model="field.value"
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
            <el-radio-group v-model="field.value" class="tw-grid-cols-3 tw-grid tw-gap-4 tw-mt-2">
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
            <el-select id="target" v-model="field.value">
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
  </div>
</template>

<script>
import { mapFields } from "vuex-map-fields";
import moment from "moment";
import _ from "lodash";
import fp from "lodash/fp";
import staticFields from './staticFields'

export default {
  name: "preview",
  components: { staticFields },
  data() {
    return {
      name: "",
    };
  },
  computed: {
    ...mapFields(["title", "type", "description", "fields", "target"]),
    validFields() {
      return _(this.fields)
        .filter("title")
        .value();
    }
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
    }
  }
};
</script>

<style>
.without-label .el-radio__label {
  @apply tw-hidden;
}

.form-preview {
  min-width: 720px;
}
</style>
