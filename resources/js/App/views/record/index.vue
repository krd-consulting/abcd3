<template>
  <div>
    <create-record
      :active.sync="create.active"
      :fields="fields"
      :record-type="type"
      @save="retrieve()"
    />
    <edit-record
      :active.sync="edit.active"
      :record-id="edit.record"
      @update="retrieve()"
      :record-type="type"
    />
    <grid
      :title="type.name"
      :items="records"
      :fields="fields"
      :page.sync="params.page"
      :sortBy.sync="params.sortBy"
      :ascending.sync="params.ascending"
      :per-page="params.perPage"
      :search-terms.sync="params.search"
      :loading="loading"
      has-add
      has-delete
      has-disable
      @add="createRecord"
      @edit="editRecord"
      @delete="confirmDelete(type.slug, $event)"
      @disable="confirmDisable(type.slug, $event)"
      @enable="confirmEnable(type.slug, $event)"
      @params-change="retrieve();"
      @show-inactive="toggleInactive"
      :total="total"
      v-if="!loading || records.length"
    >
      <template v-slot:full_name="{ value, data }">
        <router-link
          :to="`${$route.path}/${data.id}`"
          class="tw-font-bold tw-text-black hover:tw-text-black"
        >{{ value }}</router-link>
      </template>
      <template v-slot:name="{ value, data }">
        <router-link
          :to="`${$route.path}/${data.id}`"
          class="tw-font-bold tw-text-black hover:tw-text-black"
        >{{ value }}</router-link>
      </template>
    </grid>
  </div>
</template>

<script>
import grid from "@/components/extendable/grid";
import Request from "@/api/RecordRequest";
import methods from "./methods";
import fp from "lodash/fp";
import createRecord from "./create";
import editRecord from "./edit";

export default {
  components: {
    grid,
    createRecord,
    editRecord
  },
  data() {
    return {
      create: {
        active: false
      },
      edit: {
        active: false,
        record: ""
      },
      fields: [],
      records: [],
      request: new Request({}),
      loading: false,
      params: {
        ascending: true,
        sortBy: "field_1_value",
        page: 1,
        perPage: 10,
        search: "",
        active: true
      },
      inactivePage: 0,
      total: 0,
      type: {
        name: ""
      }
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
  },
  beforeRouteUpdate(to, from, next) {
    this.retrieve(to.params.recordType);
    next();
  }
};
</script>
