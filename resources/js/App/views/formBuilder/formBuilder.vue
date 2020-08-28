<template>
  <div class="form-builder tw-flex tw-flex-col tw-h-full">
    <page-title :title="title" has-bookmark class="tw-px-8"></page-title>
    <div class="tw-my-4 tw-px-8 tw-text-sm">{{ description }}</div>
    <div class="tw-relative tw-flex-1 tw-overflow-hidden">
      <el-tabs v-model="activeTab" class="tw-h-full tw-flex tw-flex-col">
        <el-tab-pane label="Build" name="build">
          <div class="tw-p-4 tw-flex tw-justify-center">
            <div class="tab-content">
              <build></build>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Preview" name="preview">
          <div class="tw-p-4 tw-flex tw-justify-center">
            <div class="tab-content">
              <preview></preview>
            </div>
          </div>
        </el-tab-pane>
      </el-tabs>
      <div class="tw-absolute tw-right-0 tw-top-0 tw-mr-4 tw-mt-2">
        <base-button :disabled="submitting" gray @click="goBack">Discard</base-button>
        <base-button :disabled="submitting" @click="saveForm">Save form</base-button>
      </div>
    </div>
  </div>
</template>

<script>
import build from "./build";
import preview from "./preview";
import Request from "@/api/FormRequest.js";
import { mapFields } from "vuex-map-fields";
import _ from "lodash";

export default {
  name: "formBuilder",
  components: {
    build,
    preview
  },
  data() {
    return {
      activeTab: "build",
      submitting: false
    };
  },
  computed: {
    ...mapFields([
      "title",
      "description",
      "owner_id",
      "scope_id",
      "type",
      "target",
      "fields"
    ])
  },
  watch: {
    activeTab(value) {
      if (value === "preview" && _(this.fields).some(field => !field.title)) {
        this.$message({
          type: "warning",
          message: "Fields with empty question will be ignored"
        });
      }
    }
  },
  beforeMount() {
    // console.log('target', JSON.stringify(this.target));
    // this.target = {
    //   id: 1,
    //   name: "Participants",
    //   description: null,
    //   slug: "participants",
    //   userable: 0,
    //   identity_id: 1,
    //   active: true,
    //   created_at: "2020-05-29T08:39:29.000000Z",
    //   updated_at: "2020-05-29T08:39:29.000000Z",
    //   deleted_at: null,
    //   type: {
    //     id: 1,
    //     name: "Records",
    //     model: "App\\RecordType",
    //     created_at: null,
    //     updated_at: null
    //   }
    // };
    // this.target = {
    //   type: {
    //     id: 2,
    //     name: "Programs",
    //     model: "App\\Program",
    //     created_at: null,
    //     updated_at: null
    //   }
    // };
    if (!this.target) {
      this.$router.replace("/forms");
    }
  },
  methods: {
    goBack() {
      this.$router.replace("/forms");
    },
    async saveForm() {
      const formData = {
        name: this.title,
        description: this.description,
        owner_id: this.owner_id,
        scope_id: this.scope_id,
        type: this.type,
        target_type_id: this.target.type.id,
        target_id: this.target.id,
        fields: this.fields
          .filter(field => field.title)
          .map(field =>
            Object.assign(
              field,
              field.settings?.matrix_choices
                ? {
                    choices: _(field.settings.matrix_choices)
                      .split("\n")
                      .compact()
                      .value()
                  }
                : {},

              field.settings?.matrix_questions
                ? {
                    questions: _(field.settings.matrix_questions)
                      .split("\n")
                      .compact()
                      .value()
                  }
                : {},

              field.settings?.options
                ? {
                    choices: _(field.settings.options)
                      .split("\n")
                      .compact()
                      .value()
                  }
                : {}
            )
          )
      };

      this.submitting = true;
      const request = new Request(formData);
      await request.store();
      this.submitting = false;

      this.goBack();
    }
  }
};
</script>

<style>
.form-builder .el-tabs__content {
  @apply tw-flex-1 tw-overflow-y-auto;
}
</style>
