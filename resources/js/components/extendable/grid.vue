<template>
  <div>
    <page-title :title="title" :has-bookmark="hasBookmark" v-if="showTitle"></page-title>
    <div class="tw-flex tw-items-end tw-mb-5">
      <div class="tw-text-gray-darkest">
        Showing
        <b>{{ total }}</b>
        {{ title }}
      </div>
      <base-input
        placeholder="Search..."
        :value="searchTerms"
        @input="handleSearchChange"
        class="tw-ml-auto tw-w-56"
        suffix-icon="fas fa-search"
      ></base-input>
      <base-button @click="$emit('add')" v-if="hasAdd" class="tw-ml-8">
        <i class="el-icon-plus tw-mr-2"></i>
        Add new {{ title.toLowerCase() }}
      </base-button>
    </div>
    <table class="tw-w-full">
      <thead>
        <tr class="tw-bg-indigo-darker">
          <th
            v-for="(field, index) in fields"
            :key="field.slug"
            :class="{'tw-rounded-tl-lg': index === 0, 'tw-rounded-tr-lg': index === fields.length - 1 && !hasAction}"
            @click="field.key === sortBy ? changeAscending(!ascending) : changeSortBy(field.key)"
          >
            {{ field.name }}
            <span class="tw-ml-3">
              <i class="fas fa-sort" v-if="sortBy !== field.key"></i>
              <i class="fas fa-sort-down" v-else-if="ascending"></i>
              <i class="fas fa-sort-up" v-else></i>
            </span>
          </th>
          <slot name="extra-columns-header"></slot>
          <th class="tw-rounded-tr-lg" v-if="hasAction"></th>
        </tr>
      </thead>
      <tbody>
        <template v-for="item in items">
          <tr :key="item.id" class="tw-border-b tw-border-gray-lighter">
            <td v-for="field in fields" :key="field.key">
              <slot
                :name="field.slug"
                :value="item.fields[field.slug] && item.fields[field.slug].value"
                :data="item"
              >{{ item.fields[field.slug] && item.fields[field.slug].value }}</slot>
            </td>
            <slot name="extra-columns-data" :data="item"></slot>
            <td class="tw-w-1/12 tw-whitespace-no-wrap" v-if="hasAction">
              <grid-action
                v-if="hasCollapsibleRows"
                icon="fas fa-eye"
                :label="openedCollapsibleRow == item.id ? `Hide ${rowTitle}` : `Show ${rowTitle}`"
                @click="toggleCollapsibleRow(item.id); $emit('open-collapsible-row', item.id)"
              ></grid-action>
              <grid-action
                v-if="hasEdit"
                icon="fas fa-pen"
                label="Edit"
                @click="$emit('edit', item.id)"
              ></grid-action>
              <grid-action
                v-if="hasDisable && item.active"
                icon="fas fa-eye-slash"
                label="Disable"
                @click="$emit('disable', item.id)"
              ></grid-action>
              <grid-action
                v-if="hasDisable && !item.active"
                icon="fas fa-eye"
                label="Enable"
                @click="$emit('enable', item.id)"
              ></grid-action>
              <grid-action
                v-if="hasRemove"
                icon="fas fa-trash"
                label="Remove"
                @click="$emit('remove', item.id)"
              ></grid-action>
              <grid-action
                v-if="hasDelete"
                icon="fas fa-archive"
                label="Archive"
                @click="$emit('delete', item.id)"
              ></grid-action>
              <grid-action
                v-for="(action, index) in extraActions"
                :key="action.label"
                :icon="action.icon"
                :label="action.label"
                @click="$emit('extra-action', {itemId: item.id, actionIndex: index})"
              ></grid-action>
            </td>
          </tr>
          <tr v-if="openedCollapsibleRow == item.id">
            <slot name="collapsible-row" :item="item"></slot>
          </tr>
        </template>
      </tbody>
    </table>
    <div v-if="total > 0 && perPage" class="tw-flex tw-justify-center tw-m-5">
      <slot name="pagination">
        <base-pagination
          v-show="showPagination"
          :current-page="page"
          @current-change="handlePageChange"
          :page-size="perPage"
          :total="total"
        >
          <template v-slot:pagination-info="slotProps">
            <span class="tw-text-gray-600">{{ slotProps.paginationInfo }}</span>
          </template>
        </base-pagination>
      </slot>
    </div>
  </div>
</template>

<script>
import GridAction from "./GridAction";
import _ from "lodash";

export default {
  components: {
    GridAction
  },
  props: {
    title: String,
    rowTitle: {
      type: String,
      default: 'Row'
    },
    fields: {
      type: Array | Object,
      default: () => []
    },
    items: {
      type: Array,
      default: () => []
    },
    searchTerms: String,
    page: Number,
    perPage: Number,
    total: Number,
    hasAdd: {
      type: Boolean,
      default: false
    },
    hasCollapsibleRows: {
      type: Boolean,
      default: false
    },
    hasEdit: {
      type: Boolean,
      default: true
    },
    hasDelete: {
      type: Boolean,
      default: false
    },
    hasDisable: {
      type: Boolean,
      default: false
    },
    hasRemove: {
      type: Boolean,
      default: false
    },
    hasBookmark: {
      type: Boolean,
      default: true
    },
    extraActions: {
      type: Array,
      default: () => []
    },
    showPagination: {
      type: Boolean,
      default: true
    },
    showTitle: {
      type: Boolean,
      default: true
    },
    sortBy: String,
    ascending: Boolean,
  },
  data() {
    return {
      openedCollapsibleRow: null,
    }
  },
  computed: {
    hasAction() {
      return (
        this.hasEdit ||
        this.hasCollapsibleRows ||
        this.hasDisable ||
        this.hasRemove ||
        this.hasDelete ||
        this.extraActions.length
      );
    }
  },
  methods: {
    toggleCollapsibleRow(key) {
      if(this.openedCollapsibleRow != key || this.openedCollapsibleRow == null) {
        this.openedCollapsibleRow = key;
      } else {
        this.openedCollapsibleRow = null;
      }
    },

    handlePageChange(page) {
      this.$emit("update:page", page);
      this.$emit("params-change");
    },
    changeSortBy(sortBy) {
      this.$emit("update:sortBy", sortBy);
      this.$emit("params-change");
    },
    changeAscending(ascending) {
      this.$emit("update:ascending", ascending);
      this.$emit("params-change");
    },
    handleSearchChange(search) {
      this.$emit("update:search-terms", search);
      // this.$emit("params-change");
      this.debounceParamsChange();
    },
    debounceParamsChange: _.debounce(function() {
      this.$emit("params-change");
    }, 500)
  }
};
</script>
<style>
  table thead tr th {
    @apply tw-p-4 tw-text-left tw-text-white tw-font-normal tw-text-sm tw-uppercase tw-cursor-pointer;
  }

  table tbody tr td {
    @apply tw-p-4 tw-text-base;
  }
</style>
