<template>
  <div>
    <page-title title="General Settings" has-bookmark class="tw-px-8"></page-title>
    <el-tabs v-model="activeTab" class="tw-mt-6 profile-tabs">
      <el-tab-pane label="Organisation" name="organisation">
        <organisation></organisation>
      </el-tab-pane>
      <el-tab-pane label="Email server" name="emailServer">Email server</el-tab-pane>
      <el-tab-pane label="API screens" name="apiScreens">API screens</el-tab-pane>
      <el-tab-pane label="Modules" name="modules">Modules</el-tab-pane>
      <el-tab-pane label="Statuses" name="statuses">Statuses</el-tab-pane>
      <el-tab-pane label="Menu types" name="menuTypes">Menu types</el-tab-pane>
      <el-tab-pane label="Role" name="role">Role</el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import organisation from './organisation'

export default {
  components: {
    organisation
  },
  data() {
    return {
      activeTab: "organisation"
    };
  }
};
</script>
