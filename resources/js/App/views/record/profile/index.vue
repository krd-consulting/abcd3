<template>
  <div v-if="!loading">
    <page-title :title="title" class="tw-px-8"></page-title>
    <div class="tw-px-8 tw-pt-5 tw-flex tw-items-center">
      <el-input suffix-icon="fas fa-search" placeholder="Route name 1" class="tw-w-56"></el-input>
      <div class="tw-ml-8">
        <div v-if="this.fields[1]">
          <span class="tw-text-sm tw-text-gray-dark">{{ this.fields[1].name }}:</span>
          <span class="tw-text-sm tw-font-bold tw-text-gray-darker tw-ml-2">{{ this.fields[1].value }}</span>
        </div>
        <div class="tw-mt-2">
          <span class="tw-text-sm tw-text-gray-dark">Dynamicdata_label:</span>
          <span class="tw-text-sm tw-font-bold tw-text-gray-darker tw-ml-2">Dynamicdata</span>
        </div>
      </div>
      <base-button outline class="tw-ml-8 tw-h-8 tw-flex tw-items-center">
        <i class="fas fa-pen tw-mr-2 tw-text-xs"></i> Edit
      </base-button>
      <base-button class="tw-ml-auto">
        <i class="fas fa-envelope tw-mr-2 tw-text-xs"></i> Email client
      </base-button>
    </div>
    <profile-tabs>
      <el-tab-pane label="Summary" name="record_profile_summary"></el-tab-pane>
      <el-tab-pane label="Orders" name="record_profile_orders"></el-tab-pane>
      <el-tab-pane label="Forms" name="record_profile_forms"></el-tab-pane>
      <el-tab-pane label="Diets & Special requests" name="record_profile_diets"></el-tab-pane>
      <el-tab-pane label="Finance" name="record_profile_finance"></el-tab-pane>
      <el-tab-pane label="Links" name="record_profile_links"></el-tab-pane>
    </profile-tabs>
    <div class="tw-p-4">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import methods from "../methods";
import RecordRequest from "@/api/RecordRequest";
import ProfileTabs from "@/App/components/profileTabs";

export default {
  components: {
    ProfileTabs
  },
  data() {
    return {
      edit: {
        active: false,
        record: ""
      },
      loading: true,
      fields: [],
      record: {
        type: {
          name: "",
          identity: {
            name: ""
          },
          slug: ""
        }
      },
      request: new RecordRequest({}),
      activeTab: "links"
    };
  },
  computed: {
    title() {
      return this.fields[0].value;
    },


  },
  methods: {
    ...methods,
    retrieve: methods.profile
  },
  created() {
    this.retrieve();
  }
};
</script>

<style>
.profile-tabs .el-tabs__nav-scroll {
  @apply tw-px-8;
}

.profile-tabs .el-tabs__content {
  @apply tw-pt-5 tw-pb-0;
}
</style>
