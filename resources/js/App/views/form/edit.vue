<template>
  <base-dialog :visible="active" @close="close" @open="open" class="record-create-dialog">
    <div slot="title">Edit form</div>
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
          <el-switch
            id="type"
            v-model="isCollectionType"
            active-text="Collection"
            inactive-text="Record"
            inactive-color="#001489"
          ></el-switch>
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

      <!-- <div class="tw-mt-4">
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
      </div> -->
    </form>
    <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
      <base-button gray @click="close(false)">
        <span class="tw-text-xs tw-align-middle">Cancel</span>
      </base-button>
      <base-button @click="submit">
        <span class="tw-text-xs tw-align-middle">Save</span>
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

export default {
  props: {
    active: Boolean,
    formId: Number | String
  },
  data() {
    return {
      request: new Request(),
      teamRequest: new TeamRequest(),
      teamRequestParams: {
        ascending: true,
        sortBy: "name",
        page: 1,
        perPage: 10,
        search: ""
      },
      formData: {
        name: "",
        description: "",
        target: "",
        type: "",
        scope_id: "",
        owner_id: ""
      },
      targetTypes: [],
      types: [],
      scopes: [],
      teams: [],
      isCollectionType: false,
      collectionTypes: [],
      recordTypes: [],
      owners: [],
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
    formattedScopes() {
      const labels = {
        universal: "Everyone",
        team: "Users in this form's teams",
        program: "Users in this form's programs",
        group: "Users in this form's groups",
        self: "Just me"
      };

      const scopes = _.clone(this.scopes);

      return scopes.map(scope => {
        scope.label = labels[scope.name];

        return scope;
      });
    },
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

    retrieveTeams(keywords) {
      this.teamRequestParams.search = keywords;

      this.teamRequest.setFields({
        params: { ...this.teamRequestParams }
      });

      this.teamRequest.retrieve().then(response => {
        this.teams = response.data;
      });
    },

    close() {
      this.$emit("update:active", false);

      this.request.errors.clear();

      this.formData = {
        name: "",
        description: "",
        target: "",
        type: "",
        scope_id: "",
        owner_id: ""
      };
    },

    async open() {
      this.retrieve();
      this.retrieveTeams();
    },

    initializeWithData(data) {
      const nameToLabel = {
        universal: "Everyone",
        team: "Users in this form's teams",
        program: "Users in this form's programs",
        group: "Users in this form's groups",
        self: "Just me"
      };

      this.formData.id = data.form.id;
      this.formData.name = data.form.name;
      this.formData.description = data.form.description;
      this.formData.type = data.form.type;

      if (data.form.target == null) {
        this.formData.target = data.form.target_type_id;
      } else {
        this.formData.target = `${data.form.target_type_id}_${data.form.target_id}`;
      }

      console.log(data.form);

      this.formData.team_id = data.form.team_id;
      this.formData.scope_id = data.form.scope_id;
      this.formData.owner_id = data.form.owner_id;

      this.targetTypes = data.target_types;
      this.types = Object.values(data.types);
      this.scopes = _.reverse(data.scopes).map(({ id, name }) => ({
        id,
        name,
        label: nameToLabel[name]
      }));

      console.log(data.types);
      console.log(this.formData);

      this.recordTypes = data.target_types.filter(
        ({ target }) => typeof target === "string" && target.includes("_")
      );
      this.collectionTypes = _.differenceBy(
        data.target_types,
        this.recordTypes,
        "target"
      );

      if (_.map(this.collectionTypes, 'target').includes(this.formData.target)) {
        this.isCollectionType = true;
      } else {
        this.isCollectionType = false;
      }
    },

    retrieve() {
      let request = new Request({});

      request.edit(this.formId).then(response => {
        this.initializeWithData(response.data);
      });
    },

    submit() {
      if (typeof this.formData.target === "string" && this.formData.target.includes("_")) {
        this.formData.target_id = parseInt(this.formData.target.split("_")[0])
        this.formData.target_type_id = parseInt(this.formData.target.split("_")[1])
      } else {
        this.formData.target_type_id = this.formData.target
      }
      this.request = new Request(this.formData);

      this.request
        .update(this.formData.id)
        .then(response => {
          this.$emit("update", response.data);
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
