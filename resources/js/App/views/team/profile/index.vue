<template>
  <div>
    <edit-team :active.sync="edit.active" :team-id="team.id" @update="retrieve()" />

    <page-title :title="title" class="tw-px-8"></page-title>
    <div class="tw-flex">
      <info-card
        icon="fas fa-calendar-plus"
        title="3 orders"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-orange-base"
        bg-class="tw-bg-orange-lightest"
      ></info-card>
      <info-card
        icon="fas fa-copy"
        title="2 collections"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-indigo-base"
        bg-class="tw-bg-indigo-lightest"
        class="tw-ml-5"
      ></info-card>
      <info-card
        icon="fas fa-link"
        title="15 links"
        description="Lorem ipsum dolor sit amet"
        text-class="tw-text-red-base"
        bg-class="tw-bg-red-lightest"
        class="tw-ml-5"
      ></info-card>
    </div>
    <profile-tabs>
      <el-tab-pane label="Records" name="team_profile_records"></el-tab-pane>
      <el-tab-pane label="Forms" name="team_profile_forms"></el-tab-pane>
      <el-tab-pane label="Jobs" name="team_profile_jobs"></el-tab-pane>
    </profile-tabs>
    <div class="tw-p-4">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import { profile } from '../methods';
import TeamRequest from "@/api/TeamRequest";
import RecordTypeRequest from "@/api/RecordTypeRequest";

import ProfileTabs from "@/App/components/profileTabs";

import ResourceProfile from "@/App/components/resourceProfile";
import EditTeam from "../edit";

export default {
  components: {
    ResourceProfile,
    EditTeam,
    ProfileTabs
  },

  data() {
    return {
      team: {
          name: '',
      },
      edit: {
          active: false,
      },
      recordTypes: [],
      request: new TeamRequest({}),
      type: {
          name: ''
      },
    }
  },

  computed: {
    title() {
      return this.team.name;
    }
  },

  methods: {
    retrieve: profile
  },

  created() {
    this.retrieve();
  },

  beforeRouteUpdate(to, from, next) {
    this.retrieve(to.params.team);
    next();
  }
};
</script>
