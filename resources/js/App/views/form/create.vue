<template>
  <base-dialog :visible="active" @close="close" @open="open" class="record-create-dialog">
    <div slot="title">Create a new form</div>
    <form>
      <div>
        <label for="name">Form name</label>
        <base-input
          id="name"
          v-model="formData['name']"
          background
          @keydown.native="request.errors.clear('name')"
        ></base-input>
        <div
          v-if="request.errors.has('name')"
          v-text="request.errors.get('name')[0]"
          class="field-error"
        ></div>
      </div>

      <div class="tw-mt-4">
        <label>Collecting data about</label>
        <div class="tw-flex tw-items-center tw-mt-3">
          <el-switch id="type" v-model="isCollectionType" active-text="Collection" inactive-text="Record" inactive-color="#001489"></el-switch>
        </div>
        <el-select
          id="target"
          v-model="formData['target']"
          @change="request.errors.clear('target')"
          class="tw-mt-3"
        >
          <el-option
            v-for="targetType in isCollectionType ? collectionTypes : recordTypes"
            :key="targetType.target"
            :value="targetType.target"
            :label="targetType.name"
          ></el-option>
        </el-select>
        <div
          v-if="request.errors.has('target.type')"
          v-text="request.errors.get('target.type')[0]"
          class="field-error"
        ></div>
      </div>

      <div class="tw-mt-4">
        <label for="type">Type</label>
        <div class="tw-flex tw-items-center tw-mt-3" v-if="types.length">
          <el-switch
            v-model="formData['type']"
            :inactive-value="types[0]"
            :inactive-text="types[0]"
            :active-value="types[1]"
            :active-text="types[1]"
            inactive-color="#001489"
          ></el-switch>
        </div>
        <div
          v-if="request.errors.has('type')"
          v-text="request.errors.get('type')[0]"
          class="field-error"
        ></div>
      </div>

      <div class="tw-mt-4">
        <label for="description">Description</label>
        <base-input type="textarea" :rows="3" v-model="formData['description']"></base-input>
        <div
          v-if="request.errors.has('description')"
          v-text="request.errors.get('description')[0]"
          class="field-error"
        ></div>
      </div>

      <div class="tw-mt-4">
        <label>Limit form access to</label>
        <el-select
          id="target"
          v-model="formData['scope_id']"
          @change="request.errors.clear('scope_id')"
          class="tw-mt-2"
        >
          <el-option
            v-for="(scope, index) in scopes"
            :key="index"
            :label="scope.label"
            :value="scope.id"
          >{{ scope.label }}</el-option>
        </el-select>
        <div
          v-if="request.errors.has('scope_id')"
          v-text="request.errors.get('scope_id')[0]"
          class="field-error"
        ></div>
      </div>

      <div class="tw-mt-4" v-if="scopeName && ![1, 6].includes(this.formData['scope_id'])">
        <label>{{ scopeName }}</label>
        <el-select
          id="target"
          v-model="formData['owner_id']"
          @change="request.errors.clear('owner_id')"
          class="tw-mt-2"
        >
          <el-option
            v-for="(owner, index) in owners"
            :key="index"
            :label="owner.name"
            :value="owner.id"
          >{{ owner.name }}</el-option>
        </el-select>
        <div
          v-if="request.errors.has('owner_id')"
          v-text="request.errors.get('owner_id')[0]"
          class="field-error"
        ></div>
      </div>
    </form>
    <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
      <base-button gray @click="close(false)">
        <span class="tw-text-xs tw-align-middle">Cancel</span>
      </base-button>
      <base-button @click="store">
        <span class="tw-text-xs tw-align-middle">Start</span>
      </base-button>
    </div>
  </base-dialog>
</template>

<script>
import Request from "@/api/FormRequest";
import TeamRequest from "@/api/TeamRequest";
import ProgramRequest from "@/api/ProgramRequest";
import GroupRequest from "@/api/GroupRequest";
import _ from "lodash";

const intialData = {
  name: "",
  target: null,
  type: "Static",
  description: "",
  scope_id: "",
  owner_id: ""
};

export default {
  name: "FormCreate",
  props: {
    active: Boolean,
    recordType: String | Object,
    fields: Array | Object
  },
  data() {
    return {
      request: new Request(),
      formData: _.cloneDeep(intialData),
      collectionTypes: [],
      recordTypes: [],
      types: [],
      scopes: [],
      owners: [],
      isCollectionType: false,
      ownerRequestParams: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 10,
        search: ""
      }
    };
  },
  computed: {
    scopeName() {
      return _.find(this.scopes, { id: this.formData["scope_id"] })?.name;
    }
  },
  watch: {
    scopeName(scopeName) {
      if (!scopeName) return;
      this.retrieveOwners();
    }
  },
  methods: {
    ownerClass(scope) {
      const classes = {
        team: TeamRequest,
        program: ProgramRequest,
        group: GroupRequest
      };

      return classes[scope];
    },

    retrieveOwners(keywords) {
      this.ownerRequestParams.search = keywords;
      const ownerClass = this.ownerClass(this.scopeName);
      if (!ownerClass) return;
      let ownerRequest = new ownerClass({});

      ownerRequest.setFields({
        params: { ...this.ownerRequestParams }
      });
      let getOwners = ownerRequest.retrieve();
      getOwners.then(response => {
        this.owners = response.data;
      });

      return getOwners;
    },
    close() {
      this.$emit("update:active", false);
      this.request.errors.clear();
      this.formData = _.cloneDeep(intialData);
    },
    async open() {
      const {
        data: { target_types, types, scopes }
      } = await this.request.create();

      this.types = Object.values(types);
      this.type = this.types[0];

      this.recordTypes = target_types.filter(
        ({ target }) => typeof target === "string" && target.includes("_")
      );
      this.collectionTypes = _.differenceBy(
        target_types,
        this.recordTypes,
        "target"
      );

      const nameToLabel = {
        universal: "Everyone",
        team: "Users in this form's teams",
        program: "Users in this form's programs",
        group: "Users in this form's groups",
        self: "Just me"
      };
      this.scopes = _.reverse(scopes).map(({ id, name }) => ({
        id,
        name,
        label: nameToLabel[name]
      }));
    },
    async store() {
      this.request = new Request(this.formData);
      const { data } = await this.request.validate();
      this.$store.commit("SET_TITLE", data.name);
      this.$store.commit("SET_DESCRIPTION", data.description);
      this.$store.commit("SET_OWNER_ID", data.owner_id);
      this.$store.commit("SET_SCOPE_ID", data.scope_id);
      this.$store.commit("SET_TYPE", data.type);
      this.$store.commit("SET_TARGET", data.target);
      this.close();
      this.$router.push("/forms/create");
    }
  }
};
</script>
