<template>
  <base-dialog :visible="active" @close="close" @open="retrieve" class="record-create-dialog">
    <div slot="title">
      Edit
      <span class="tw-lowercase">{{ recordType.name }}</span>
    </div>
    <form>
      <div v-for="(value, key, index) in recordType.fields" :key="key" :class="{'tw-mt-4': index}">
        <label>{{ value.name }}</label>
        <base-input
          v-if="value.slug == 'birth_date'"
          v-model="newRecordData[key]"
          :name="key"
          type="date"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <base-input
          v-else
          v-model="newRecordData[key]"
          :name="key"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <div v-if="request.errors.has(key)" v-text="request.errors.get(key)[0]" class="field-error"></div>
      </div>
    </form>
    <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
      <base-button gray @click="close(false)">
        <span class="tw-text-xs tw-align-middle">Cancel</span>
      </base-button>
      <base-button @click="update">
        <span class="tw-text-xs tw-align-middle">Save</span>
      </base-button>
    </div>
  </base-dialog>
</template>
<script>
import RecordRequest from "@/api/RecordRequest";
import TeamRequest from "@/api/TeamRequest";

export default {
  props: {
    active: Boolean,
    recordId: Number | String,
    recordType: String | Object,
  },

  data() {
    return {
      newRecordData: {
        id: "",
        field_1_value: "",
        field_2_value: "",
        field_3_value: ""
      },
      request: new RecordRequest(),
      fields: [],
    };
  },

  methods: {
    close() {
      this.$emit("update:active", false);

      this.request.errors.clear();
    },

    retrieve() {
      let request = new RecordRequest({});

      request.edit(this.recordType.slug, this.recordId).then(response => {
        this.initializeWithData(response.data);
      });
    },

    initializeWithData(data) {
      this.fields = data.fields;
      for (const fieldKey of ['field_1_value', 'field_2_value', 'field_3_value']) {
          this.newRecordData[fieldKey] = data.field_values[data.type.fields[fieldKey].slug];
      }
    },

    update() {
      this.request = new RecordRequest(this.newRecordData);

      this.request
        .update(this.recordType.slug, this.recordId)
        .then(response => {
          this.$emit("update");
          this.$message({
            type: "success",
            message: "Record updated successfully!"
          });
          this.close();
        })
        .catch(error => {
          this.$message({
            type: "error",
            message: error.message
          });
          this.close();
        });
    }
  },

  created() {}
};
</script>
