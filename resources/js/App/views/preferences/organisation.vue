<template>
  <div class="organisation tw-w-1/3">
    <label>Organisation name</label>
    <base-input v-model="name" @input="handleInputChange"></base-input>
    <div v-if="getError('org_name')" v-text="getError('org_name')" class="field-error"></div>
    <img :src="image" class="tw-w-64 tw-h-32 tw-mt-8" v-if="image" />
    <div v-if="getError('org_logo')" v-text="getError('org_logo')" class="field-error"></div>
    <input type="file" ref="fileInput" @change="handleChange" class="tw-hidden" />
    <el-link class="tw-no-underline" @click="$refs.fileInput.click()">
      Upload a new logo
      <i class="fas fa-upload"></i>
    </el-link>
    <div class="tw-mt-16">
      <base-button @click="handleSave" :disabled="submitting">Save changes</base-button>
      <base-button @click="handleDiscard" :disabled="submitting" gray class="tw-ml-4">Discard</base-button>
    </div>
  </div>
</template>

<script>
import fp from 'lodash/fp';

export default {
  data() {
    return {
      name: "",
      image: "",
      originalData: null,
      file: null,
      submitting: false,
      errors: null
    };
  },
  async created() {
    const { data } = await axios.get("/api/organisation-setting");
    this.name = data.org_name;
    this.image = data.org_logo;
    this.originalData = data;
  },
  methods: {
    getError(field) {
      return this.errors?.[field]?.[0];
    },
    handleInputChange() {
      this.errors = fp.set('org_name', null)(this.errors);
    },
    handleChange(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;

      const image = new Image();
      const reader = new FileReader();
      const vm = this;

      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(files[0]);
      this.file = files[0];

      this.errors = fp.set('org_logo', null)(this.errors);
    },
    async handleSave() {
      const formData = new FormData();
      formData.append("org_name", this.name);
      if (this.file) {
        formData.append("org_logo", this.file);
      }

      this.submitting = true;
      try {
        await axios.post("/api/organisation-setting", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        });
        this.$message({
          type: "success",
          message: "Organisation information is successfully updated"
        });
      } catch (e) {
        this.errors = e.response.data.errors;
      }
      this.submitting = false;
    },
    handleDiscard() {
      this.name = this.originalData.org_name;
      this.image = this.originalData.org_logo;
      this.errors = null;
    }
  }
};
</script>

<style>
.organisation .el-link--inner {
  @apply tw-no-underline !important;
}
</style>
