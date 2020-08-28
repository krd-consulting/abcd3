<template>
  <div>
    <div class="tw-flex tw-items-center">
      <div
        class="tw-w-6 tw-h-6 tw-bg-orange-base tw-rounded-full tw-flex tw-justify-center tw-items-center"
      >
        <base-icon class="tw-text-white tw-text-sm">bookmark</base-icon>
      </div>
      <h1 class="tw-text-3xl tw-text-black tw-font-bold tw-ml-3">
        <slot name="header-text"></slot>
      </h1>
    </div>
    <div class="tw-flex tw-justify-between tw-items-end tw-mb-5">
      <div class="tw-text-gray-darkest">
        Showing
        <span class="tw-font-bold">{{ total }}</span>
        <span class="tw-lowercase">
          <slot name="header-text"></slot>
        </span>
      </div>
      <base-button @click="$emit('add')">
        <i class="el-icon-plus tw-ml-3 tw-mr-2"></i>
        Add new
        <span class="tw-lowercase tw-mr-3 tw-ml-0">
          <slot name="header-text"></slot>
        </span>
      </base-button>
    </div>
    <div class="tw-shadow tw-rounded tw-bg-white">
      <!-- <div v-if="hasHeader" class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b">
        <slot name="header">
          <h2 class="tw-font-bold tw-text-xl tw-w-1/4">
            <slot name="header-text"></slot>
          </h2>
          <slot name="options"></slot>
        </slot>
      </div>-->
      <div v-if="total == 0">
        <slot name="empty-placeholder"></slot>
      </div>
      <slot v-else name="list">
        <div>
          <slot></slot>
        </div>
      </slot>
      <div class="tw-flex tw-justify-between tw-items-center tw-py-2">
        <slot v-if="total > 0" name="pagination">
          <base-pagination
            v-show="showPagination"
            :current-page="page"
            @current-change="handlePageChange"
            layout="prev, slot, next"
            :page-size="perPage"
            :total="total"
          >
            <template v-slot:pagination-info="slotProps">
              <span class="tw-text-gray-600">{{ slotProps.paginationInfo }}</span>
            </template>
          </base-pagination>
        </slot>
        <slot name="footer-options"></slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    //items: Array,
    page: Number,
    perPage: Number,
    total: Number,
    hasHeader: {
      type: Boolean,
      default: false
    },
    showPagination: {
      type: Boolean,
      default: true
    }
  },

  methods: {
    handlePageChange(page) {
      this.$emit("update:page", page);
      this.$emit("page-change", page);
    }
  }
};
</script>
