<template>
  <div>
    <div class="tw-flex">
      <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">{{ collectingLabel }}</label>
      <el-autocomplete v-model="collectingValue" :fetch-suggestions="querySearch"></el-autocomplete>
      <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
    </div>
    <div class="tw-flex tw-mt-4">
      <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">Team</label>
      <el-select v-model="team" placeholder="Select">
        <el-option v-for="team in teams" :key="team.id" :label="team.name" :value="team.id"></el-option>
      </el-select>
      <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
    </div>
    <div class="tw-flex tw-mt-4">
      <label class="tw-mr-4 tw-w-1/4 tw-text-right tw-mt-3">Date Completed</label>
      <el-date-picker v-model="dateCompleted" format="yyyy-MM-DD" class="tw-w-full"></el-date-picker>
      <div class="tw-text-gray-light tw-text-xs tw-font-bold tw-ml-4 tw-mt-3">Required</div>
    </div>
    <div class="tw-flex tw-mt-4" v-if="type === 'Pre-post'">
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
  </div>
</template>

<script>
import { mapFields } from "vuex-map-fields";
import GroupRequest from "@/api/GroupRequest";
import ProgramRequest from "@/api/ProgramRequest";
import RecordRequest from "@/api/RecordRequest";
import TeamRequest from "@/api/TeamRequest";
import fp from "lodash/fp";
import pluralize from 'pluralize';

export default {
  data() {
    return {
      collectingValue: "",
      dateCompleted: "",
      formCompletedFor: "",
      team: "",
      teams: []
    };
  },
  computed: {
    ...mapFields(["title", "type", "description", "fields", "target"]),
    collectingLabel() {
      return pluralize.singular(this.target.name || this.target.type.name) + ' Name';
    }
  },
  async created() {
    const teamRequest = new TeamRequest({});
    const { data } = await teamRequest.retrieve();
    this.teams = data;
  },
  methods: {
    async querySearch(query, cb) {
      let searchRequest, result;

      if (this.target.type.name === "Programs") {
        searchRequest = new ProgramRequest({});
      } else if (this.target.type.name === "Groups") {
        searchRequest = new GroupRequest({});
      } else {
        searchRequest = new RecordRequest({});
      }
      searchRequest.setFields({ params: { search: query } });

      const { data } =
        this.target.type.name === "Records"
          ? await searchRequest.retrieve(this.target.slug)
          : await searchRequest.retrieve();

      if (this.target.type.name === "Records") {
        result = data.map(item => ({
          value: fp.get("fields.full_name.value", item)
        }));
      } else {
        result = data.map(item => ({ value: item.name }));
      }

      cb(result);
    },
  }
}
</script>
