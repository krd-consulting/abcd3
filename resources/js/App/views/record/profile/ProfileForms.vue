<template>
  <grid
    title="Forms"
    :items="items"
    :fields="fieldArr"
    has-add
    :has-edit="false"
    :has-bookmark="false"
    :total="3"
    :extra-actions="[{icon: 'fas fa-eye', label: 'Show entries'}, {icon: 'fas fa-plus', label: 'Add new entry'}]"
  >
    <template v-slot:form_name="{ value }">
      <div class="tw-text-lg tw-font-semibold tw-underline">{{ value }}</div>
    </template>
    <template v-slot:history="{ data }">
      <div>
        <div class="tw-font-semibold">{{ data.fields.entry_count.value }} entries</div>
        <div
          class="tw-text-sm tw-text-indigo-darker"
        >Last entry: {{ data.fields.last_entry.value | moment('MMM DD, YYYY') }}</div>
      </div>
    </template>
  </grid>
</template>

<script>
import fp from "lodash/fp";
import grid from "@/components/extendable/grid";

export default {
  name: "ProfileForms",
  components: {
    grid
  },
  data() {
    return {
      items: fp.range(0, 3).map(id => ({
        id,
        fields: {
          form_name: {
            value: "Form name"
          },
          type: {
            value: id % 2 === 0 ? "Static" : "Pre-post"
          },
          entry_count: {
            value: 2
          },
          last_entry: {
            value: "2020-01-31"
          }
        }
      })),
      fieldArr: [
        {
          key: "form_name",
          slug: "form_name",
          name: "Form name"
        },
        {
          key: "type",
          slug: "type",
          name: "Type"
        },
        {
          key: "history",
          slug: "history",
          name: "History"
        }
      ]
    };
  }
};
</script>
