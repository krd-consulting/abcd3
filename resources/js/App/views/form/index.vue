<template>
  <div>
    <create :active.sync="create.active" @save="retrieve()" />
    <edit :active.sync="edit.active" :formId="edit.form" @update="retrieve()" />
    <raw-grid
      title="Forms"
      :items="forms"
      :fields="headers"
      :page.sync="params.page"
      :sortBy.sync="params.sortBy"
      :ascending.sync="params.ascending"
      :per-page="params.perPage"
      :search-terms.sync="params.search"
      :loading="loading"
      has-add
      addLabel="Create new form"
      has-delete
      :extra-actions="[{icon: 'fas fa-plus', label: 'Add Entry'}]"
      @extra-action="handleExtraAction"
      @add="createForm"
      @edit="editForm"
      @delete="confirmDelete($event)"
      @params-change="retrieve();"
      @show-inactive="toggleInactive"
      :total="total"
      v-if="!loading || items.length"
    >
      <template v-slot:name="{ value, data }">
        <router-link
          :to="`${$route.path}${data.id}`"
          class="tw-font-bold tw-text-black hover:tw-text-black"
        >{{ value }}</router-link>
      </template>
      <template v-slot:active="{ value, data }">
        <el-switch
          :value="value"
          :active-value="1"
          :inactive-value="0"
          @input="$event ? confirmEnable(data.id) : confirmDisable(data.id)"
          active-text="Enabled"
          inactive-text="Disabled"
        ></el-switch>
      </template>
    </raw-grid>
  </div>
</template>
<script>
import Request from "@/api/FormRequest";
import methods from "./methods";
import rawGrid from "@/components/extendable/rawGrid";
import create from "./create";
import edit from "./edit";
import { mapFields } from 'vuex-map-fields';

export default {
  components: {
    rawGrid,
    create,
    edit
  },
  computed: {
    ...mapFields(["fields"])
  },
  data() {
    return {
      create: {
        active: false
      },
      edit: {
        active: false,
        form: ""
      },
      headers: [
        { key: "name", label: "Form name" },
        { key: "target_name", label: "About" },
        { key: "type", label: "Type" },
        { key: "active", label: "Status" }
      ],
      forms: [],
      loading: false,
      request: new Request({}),
      params: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 5,
        active: true
      },
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
    },

    handleExtraAction({itemId, actionIndex}) {
      if (actionIndex === 0) {
        this.$router.push(`/forms/${itemId}/new`);
      }
    }
  },

  created() {
    this.retrieve();
  }
};
</script>
