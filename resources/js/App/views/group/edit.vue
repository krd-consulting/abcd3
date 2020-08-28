<template>
  <base-dialog :visible="active" @close="close" @open="retrieve">
    <div slot="title">
      <div slot="title">Add new groups</div>
    </div>
    <form>
      <div>
        <label>Name</label>
        <base-input
          v-model="newGroupData.name"
          name="name"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <div
          v-if="request.errors.has('name')"
          v-text="request.errors.get('name')[0]"
          class="field-error"
        ></div>
      </div>
      <div class="tw-mt-4">
        <label>Description</label>
        <base-input
          v-model="newGroupData.description"
          name="description"
          background
          @keydown.native="request.errors.clear($event.target.name)"
        />
        <div
          v-if="request.errors.has('description')"
          v-text="request.errors.get('description')"
          class="field-error"
        ></div>
      </div>
      <div class="tw-mt-4">
        <label>Program</label>
        <base-select
          v-model="newGroupData.program_id"
          :value="newGroupData.program_id"
          name="program"
          placehoder="Select a program"
          @change="request.errors.clear('team')"
          disabled
        >
          <el-option
            :label="newGroupData.program.name"
            :value="newGroupData.program.id"
          >{{ newGroupData.program.name }}</el-option>
        </base-select>
        <div
          v-if="request.errors.has('program_id')"
          v-text="request.errors.get('program_id')[0]"
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
import Request from "@/api/GroupRequest";

export default {
  props: {
    active: Boolean,
    groupId: Number | String
  },

  data() {
    return {
      request: new Request(),
      newGroupData: {
        id: "",
        name: "",
        description: "",
        program: {},
        program_id: ""
      }
    };
  },

  methods: {
    close() {
      this.$emit("update:active", false);

      this.request.errors.clear();

      this.newGroupData = {
        id: "",
        name: "",
        description: "",
        program: {},
        program_id: ""
      };
    },

    initializeWithData(data) {
      this.newGroupData.id = data.id;
      this.newGroupData.name = data.name;
      this.newGroupData.description = data.description;
      this.newGroupData.program_id = data.program_id;
      this.newGroupData.program = data.program;
    },

    retrieve() {
      let request = new Request({});

      request.edit(this.groupId).then(response => {
        this.initializeWithData(response.data);
      });
    },

    store() {
      this.request = new Request(this.newGroupData);

      this.request
        .update(this.newGroupData.id)
        .then(response => {
          this.$emit("update");
          this.$message({
            type: "success",
            message: "Group updated successfully!"
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
