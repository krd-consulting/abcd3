<template>
  <base-dialog :visible="active" @close="close" @open="open">
    <div slot="title">
      <div slot="title">Add new groups</div>
    </div>
    <form>
      <div>
        <label>Name</label>
        <base-input
          v-model="groupData.name"
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
          v-model="groupData.description"
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
          v-model="groupData.program_id"
          :value="groupData.program_id"
          name="program"
          placehoder="Select a program"
          @change="request.errors.clear('team')"
          :disabled="isProgramGiven"
        >
          <el-option
            v-for="program in programs"
            :key="program.id"
            :label="program.name"
            :value="`${program.id}`"
          >{{ program.name }}</el-option>
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
    programId: Number | String,
    teamId: {
      type: Number | String,
      default: null
    }
  },

  data() {
    return {
      request: new Request(),
      groupData: {
        name: "",
        description: "",
        program: ""
      },
      programs: []
    };
  },

  computed: {
    isProgramGiven() {
      return typeof this.programId !== "undefined";
    }
  },

  methods: {
    close() {
      this.$emit("update:active", false);

      this.request.errors.clear();

      this.groupData = {
        name: "",
        description: "",
        program_id: ""
      };
    },

    open() {
      if (this.isProgramGiven) {
        this.groupData.program_id = this.programId;
      }

      this.load();
    },

    load() {
      let request = new Request({});

      request.create(this.teamId).then(response => {
        this.programs = response;
      });
    },

    store() {
      this.request = new Request(this.groupData);

      this.request
        .store()
        .then(response => {
          this.$emit("save");
          this.$message({
            type: "success",
            message: "Group created successfully!"
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
