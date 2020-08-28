<template>
  <div>
    <div class="tw-flex tw-justify-between tw-items-end">
      <div>
        <div class="tw-text-xs">Subsidy</div>
        <base-input class="tw-mt-2" value="10%"></base-input>
      </div>
      <base-button>
        <i class="fas fa-plus tw-mr-2"></i>
        Create invoice
      </base-button>
    </div>
    <div class="tw-mt-5 tw-border tw-border-gray-lighter tw-p-5 tw-inline-flex tw-items-center">
      <div class="tw-rounded-lg tw-p-5 tw-font-bold tw-text-4xl tw-bg-gray-lighter">$300</div>
      <div class="tw-ml-5">
        <div class="tw-text-sm">Outstanding balance</div>
        <base-button class="tw-mt-5">
          <i class="fas fa-plus tw-mr-2"></i>
          Record payment
        </base-button>
      </div>
    </div>
    <grid
      title="Payment history"
      :items="items"
      :fields="fieldArr"
      :has-edit="false"
      :has-bookmark="false"
      :total="3"
      class="tw-mt-10"
    >
      <template v-slot:date="{ value }">
        <div>{{ value | moment('dddd DD MM YYYY') }}</div>
      </template>
      <template v-slot:operation="{ value }">
        <base-link class="tw-font-semibold">{{ value }}</base-link>
      </template>
      <template v-slot:balance="{ value }">
        <div class="tw-font-semibold">{{ value }}</div>
      </template>
    </grid>
  </div>
</template>

<script>
import fp from "lodash/fp";
import grid from "@/components/extendable/grid";

export default {
  name: "ProfileFinance",
  components: {
    grid
  },
  data() {
    return {
      items: fp.range(0, 3).map(id => ({
        id,
        fields: {
          date: {
            value: "2020-05-12",
          },
          operation: {
            value: id % 2 ? "Order_12345" : "Credit Card payment",
          },
          amount: {
            value: "-$1000",
          },
          balance: {
            value: "$300",
          },
          processed_by: {
            value: "John Doe"
          }
        }
      })),
      fieldArr: [
        {
          key: "date",
          slug: "date",
          name: "Date"
        },
        {
          key: "operation",
          slug: "operation",
          name: "Operation"
        },
        {
          key: "amount",
          slug: "amount",
          name: "Amount"
        },
        {
          key: "balance",
          slug: "balance",
          name: "Balance"
        },
        {
          key: "processed_by",
          slug: "processed_by",
          name: "Processed by"
        }
      ]
    };
  }
};
</script>
