<template>
  <grid
    title="Orders"
    :items="items"
    :fields="fieldArr"
    :page.sync="params.page"
    :sortBy.sync="params.sortBy"
    :ascending.sync="params.ascending"
    :per-page="params.perPage"
    :search-terms.sync="params.search"
    has-add
    :has-edit="false"
    :has-bookmark="false"
    :total="84"
  >
    <template v-slot:delivery_date="{ value }">{{ value | moment('dddd DD MMM YYYY') }}</template>
    <template v-slot:order_id="{ value }">
      <base-link class="tw-font-semibold">Order_{{ value }}</base-link>
    </template>
    <template v-slot:created_on="{ value }">{{ value | moment('DD MMM YYYY') }}</template>
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
      items: fp.range(0, 5).map(id => ({
        id,
        fields: {
          delivery_date: {
            value: "2020-05-18",
          },
          order_id: {
            value: 12345,
          },
          type: {
            value: id % 2 === 0 ? "Manual" : "Subscription",
          },
          created_on: {
            value: "2020-05-05"
          }
        }
      })),
      fieldArr: [
        {
          key: "delivery_date",
          slug: "delivery_date",
          name: "Delivery date"
        },
        {
          key: "order_id",
          slug: "order_id",
          name: "Order ID"
        },
        {
          key: "type",
          slug: "type",
          name: "Type"
        },
        {
          key: "created_on",
          slug: "created_on",
          name: "Created on"
        }
      ],
      params: {
        ascending: true,
        sortBy: "delivery_date",
        page: 1,
        perPage: 10,
        search: "",
        active: true
      }
    };
  }
};
</script>
