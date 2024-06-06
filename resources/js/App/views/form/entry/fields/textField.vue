<template>
  <base-input
    v-if="!fieldData.reference_target_type_id"
    :value="value"
    @input="$emit('input', $event)"></base-input>
  <el-select
    v-else
    :value="value"
    @input="$emit('input', $event)"
    filterable
    remote
    :remote-method="retrieveFieldTargetItems"
    :name="fieldData.column_name"
    :placeholder="`Select from ${targetType.name}`"
  >
    <el-option
      v-for="(item, index) in fieldTargetItems"
      :key="index"
      :label="item.value"
      :value="item.value"
    ></el-option>
  </el-select>
</template>
<script>
  import FormFieldTargetTypesRequest from "@/api/FormFieldTargetTypeRequest";
  import FormFieldEntryRequest from "@/api/FormFieldEntryRequest";

  export default {
    props: {
      fieldData: Object,
      value: ''
    },

    data() {
      return {
        targetType: {
          name: 'database'
        },
        fieldTargetItems: [],
      };
    },

    methods: {

      retrieveFieldTargetItems(keywords, callback) {
        // what if
        // 1. give to endpoint: the field information
        // 2. give back right items
        const request = new FormFieldEntryRequest();

        request.setFields({
          params: {
            search: keywords
          }
        });

        request.retrieve(this.fieldData.reference_target_type_id).then(response => {
          this.fieldTargetItems = response.data;
        });
      },

      retrieveTargetType() {
        const request = new FormFieldTargetTypesRequest({});

        request.show(
          this.fieldData.reference_target_type_id, 
          this.fieldData.reference_target_id
        ).then(response => {
          this.targetType =  response.data;
        });
      },

    },

    created() {
      this.retrieveTargetType();
    }
  }
</script>
