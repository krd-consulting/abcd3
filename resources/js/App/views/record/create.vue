<template>
  <base-dialog :visible="active" @close="close" @open="open" class="record-create-dialog">
    <div slot="title">
      Add new
      <span class="tw-lowercase">{{ recordType.name }}</span>
    </div>
    <form>
      <div v-for="(value, key, index) in recordType.fields" :key="key" :class="{'tw-mt-4': index}">
        <label>{{ value.name }}</label>
        <base-input
          v-if="value.slug == 'birth_date'"
          v-model="recordData[key]"
          :name="key"
          type="date"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <base-input
          v-else
          v-model="recordData[key]"
          :name="key"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <div v-if="request.errors.has(key)" v-text="request.errors.get(key)[0]" class="field-error"></div>
      </div>
      <div class="tw-mt-4">
        <label>Team</label>
        <base-select
          v-model="recordData.team_id"
          name="team"
          placehoder="Select a team"
          @change="request.errors.clear('team')"
        >
          <el-option
            v-for="team in teams"
            :key="team.id"
            :label="team.name"
            :value="team.id"
          >{{ team.name }}</el-option>
        </base-select>
        <div
          v-if="request.errors.has('team_id')"
          v-text="request.errors.get(key)[0]"
          class="field-error"
        ></div>
      </div>
    </form>
    <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
      <base-button gray @click="close(false)">
        <span class="tw-text-xs tw-align-middle">Cancel</span>
      </base-button>
      <base-button @click="store">
        <span class="tw-text-xs tw-align-middle">Save</span>
      </base-button>
    </div>
  </base-dialog>
</template>
<script>
import Request from "@/api/RecordRequest";

export default {
  props: {
    active: Boolean,
    recordType: String | Object,
    fields: Array | Object
  },

  data() {
    return {
      request: new Request(),
      recordData: {
        field_1_value: "",
        field_2_value: "",
        field_3_value: "",
        record_type_id: "",
        team_id: ""
      },
      teams: []
    };
  },

  methods: {
    close() {
      this.$emit("update:active", false);

      this.request.errors.clear();

      this.programData = {
        field_1_value: "",
        field_2_value: "",
        field_3_value: "",
        record_type_id: "",
        team_id: ""
      };
    },

    open() {
      this.load();
    },

    load() {
      let request = new Request({});
      request.create(this.recordType.slug).then(({ data }) => {
        this.teams = data;
      });
    },

    store() {
      this.recordData.record_type_id = this.recordType.id;

      this.request = new Request(this.recordData);

      this.request
        .store(this.recordType.slug)
        .then(response => {
          this.$emit("save");
          this.$message({
            type: "success",
            message: "Record created successfully!"
          });
          this.close();
        })
        .catch(error => {
          //
        });
    }
  },

  created() {}
};
</script>

<style lang="css">
.record-create-dialog .el-dialog {
  width: 420px;
}
</style>
