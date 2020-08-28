<template>
  <div>
    <div class="tw-flex tw-justify-between">
      <base-select v-model="selectedCollectionSlug" @change="newItem = null; searchItems = []; index(recordType, record, selectedCollectionSlug)" class="tw-w-40">
        <el-option
          v-for="collection in collections"
          :key="collection.slug"
          :label="collection.slug"
          :value="collection.slug">
        </el-option>
      </base-select>
      <base-button><i class="fas fa-link tw-mr-2"></i> Link teams</base-button>
    </div>
    <!-- Simple association -->
    <div>
      <!-- List -->
      <div>
        <div class="tw-grid tw-grid-cols-3">
          <div class="tw-bg-white tw-rounded tw-border">
            <h1 class="tw-capitalize tw-font-bold tw-m-4">{{ selectedCollectionSlug }} ({{ items.length }})</h1>
            <ul class="tw-m-4">
              <li v-for="item in items" class="tw-p-2 tw-mb-2 tw-rounded tw-bg-gray-100">
                <ul>
                  <li class="tw-font-bold tw-text-indigo-base">
                    {{ item.profile_fields[0].value }}
                  </li>
                  <li class="tw-text-sm tw-text-gray-500">
                    {{ item.profile_fields[1].value }}
                  </li>
                </ul>
              </li>
            </ul>
            <form class="tw-bg-gray-100 tw-p-4">
              <label class="tw-w-full tw-block" for="input-item">Add {{ selectedCollection.name }}</label>
              <div class="tw-grid tw-grid-cols-5">
                <el-select
                  v-model="newItem"
                  filterable
                  remote
                  :remote-method="search"
                  :placeholder="`Search for a ${selectedCollection.name}`"
                  class="tw-col-span-3"
                >
                  <el-option
                    v-for="(item, index) in searchItems"
                    :key="index"
                    :label="item.display_value"
                    :value="item.id"
                  ></el-option>
                </el-select>
                <base-button class="tw-col-span-2" @click="addNewItem(newItem)">
                  <i class="fas fa-link tw-mr-2"></i>Add {{ selectedCollection.name }}
                </base-button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Search -->
      <div>

      </div>
    </div>
  </div>
</template>

<script>
import grid from "@/components/extendable/grid";
import CollectionRequest from "@/api/CollectionRequest";
import RecordCollectionRequest from "@/api/RecordCollectionRequest";

export default {
  name: "ProfileLinks",
  components: {
    grid
  },
  data() {
    return {
      request: new CollectionRequest({}),
      selectedCollectionSlug: '',
      collections: [],
      newItem: '',
      items: [],
      searchItems: [],
      itemFields: []
    }
  },

  computed: {
    selectedCollection() {
      const collection = this.collections.find(item => item.slug == this.selectedCollectionSlug) ?? {
        name: '',
        slug: ''
      };

      return collection;
    },

    recordType() {
      return this.$route.params.recordType;
    },

    record() {
      return this.$route.params.record;
    }
  },

  methods: {
    retrieveCollections() {
      const request = new CollectionRequest({});

      return request.retrieve().then(response => {
          this.collections = response.data;
      });
    },

    index(recordType, record, collection) {
      const request = new RecordCollectionRequest({});

      return request.retrieve(recordType, record, collection).then(response => {
        this.items = response.data;
        this.itemFields = response.fields;
      });
    },

    search(query) {
      const request = new RecordCollectionRequest({});

      request.setFields({
        params: {
          search: query
        }
      });

      request.available(this.recordType, this.record, this.selectedCollectionSlug).then(response => {
        this.searchItems = response.data;
      });
    },

    addNewItem(item) {
      const request = new RecordCollectionRequest({});

      request.store(this.recordType, this.record, this.selectedCollectionSlug, item).then(response => {
        this.index(this.recordType, this.record, this.selectedCollectionSlug);
        this.newItem = null;
      });
    }
  },

  created() {
    this.retrieveCollections().then(reponse => {
      this.selectedCollectionSlug = this.collections[0].slug;

      this.index(this.recordType, this.record, this.selectedCollectionSlug);
    });
  }
};
</script>
