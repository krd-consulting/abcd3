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
    :placeholder="`Select ${getTargetType(fieldData.reference_target_type_id).singular_name}`"
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
        targetTypes: [],
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

        request.retrieve(this.fieldData.reference_target_id).then(response => {
          this.fieldTargetItems = response.data;
        });
      },

      getTargetType(id) {
        console.log(`target types:`);
        console.log(this.targetTypes);

        return this.targetTypes.filter(targetType => {
          return targetType.id == id;
        })[0];
      },

      retrieveTargetTypes() {
        const request = new FormFieldTargetTypesRequest({});

        request.retrieve().then(response => {
          this.targetTypes =  response.data;
        });
      },

    },

    created() {
      this.retrieveTargetTypes();
    }
  }
</script>
