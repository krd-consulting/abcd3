<template>
  <grid
    title="Subscriptions"
    :items="items"
    :fields="fieldArr"
    :search-terms.sync="params.search"
    has-edit
    :has-bookmark="false"
    :total="2"
  >
    <template v-slot:subscription_id="{ value }">
      <base-link class="tw-font-semibold">Sub_{{ value }}</base-link>
    </template>
    <template v-slot:schedule="{ value }">
      <span
        v-for="day in value"
        :key="day"
        class="tw-text-xs tw-rounded-lg tw-bg-indigo-lightest tw-text-indigo-base tw-w-10 tw-h-6 tw-mr-1 tw-inline-flex tw-justify-center tw-items-center"
      >{{ day }}</span>
    </template>
    <template v-slot:status="{ value }">
      <span v-if="value" class="tw-text-sm tw-text-indigo-base tw-mr-2">Enabled</span>
      <span v-else class="tw-text-sm tw-text-gray-dark tw-mr-2">Disabled</span>
      <el-switch :value="value"></el-switch>
    </template>
  </grid>
</template>

<script>
import fp from "lodash/fp";
import grid from "@/components/extendable/grid";

export default {
  name: "ProfileOrders",
  components: {
    grid
  },
  data() {
    return {
      items: [
        {
          id: 1,
          fields: {
            subscription_id: {
              value: 12345
            },
            status: {
              value: true
            },
            diets: {
              value: "Diet type"
            },
            schedule: {
              value: ["Mon", "Tue", "Wed", "Thu", "Fri"]
            }
          }
        },
        {
          id: 2,
          fields: {
            subscription_id: {
              value: 12345
            },
            status: {
              value: false
            },
            diets: {
              value: "Diet type"
            },
            schedule: {
              value: ["Mon", "Tue", "Wed"]
            }
          }
        }
      ],
      fieldArr: [
        {
          key: "subscription_id",
          slug: "subscription_id",
          name: "Subscription ID"
        },
        {
          key: "status",
          slug: "status",
          name: "Status"
        },
        {
          key: "diets",
          slug: "diets",
          name: "Diets"
        },
        {
          key: "schedule",
          slug: "schedule",
          name: "Schedule"
        }
      ],
      params: {
        ascending: true,
        sortBy: "subscription_id",
        page: 1,
        perPage: 10,
        search: "",
        active: true
      }
    };
  }
};
</script>
