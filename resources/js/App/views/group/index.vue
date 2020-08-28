<template>
  <div>
    <create-group :active.sync="create.active" @save="retrieve()" />

    <edit-group :active.sync="edit.active" :group-id="edit.group" @update="retrieve()" />

    <grid
      title="Groups"
      :items="groups"
      :fields="fields"
      :page.sync="params.page"
      :sortBy.sync="params.sortBy"
      :ascending.sync="params.ascending"
      :per-page="params.perPage"
      :search-terms.sync="params.search"
      has-add
      has-delete
      @add="createGroup"
      @edit="editGroup"
      @delete="confirmDelete"
      @disable="confirmDisable"
      @params-change="retrieve()"
      @show-inactive="toggleInactive"
      :total="total"
    >
      <template v-slot:name="{ value }">
        <b>{{value}}</b>
      </template>
    </grid>
  </div>
</template>
<script>
import Request from "@/api/GroupRequest";

import methods from "./methods";

import grid from "@/components/extendable/grid";
import CreateGroup from "./create";
import EditGroup from "./edit";

export default {
  components: {
    grid,
    CreateGroup,
    EditGroup
  },
  data() {
    return {
      create: {
        active: false
      },
      edit: {
        active: false,
        group: {
          name: "",
          description: "",
          program_id: ""
        }
      },
      groups: [],
      fields: [],
      request: new Request({}),
      params: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 5,
        search: "",
        active: true
      },
      showInactive: false,
      total: 0
    };
  },
  methods: {
    ...methods,
    retrieve: methods.index,
    toggleInactive(showInactive) {
      this.params.active = !showInactive;
      this.params.page = 1;
      this.retrieve();
    }
  },
  created() {
    this.retrieve();
  }
};
</script>
