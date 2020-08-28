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
      :label="item.display_value"
      :value="item.id"
    ></el-option>
  </el-select>
</template>
<script>
  import TeamRequest from "@/api/TeamRequest";
  import RecordRequest from "@/api/RecordRequest";
  import FormFieldTargetTypesRequest from "@/api/FormFieldTargetTypeRequest";
  import FormFieldRequest from "@/api/FormFieldRequest";
  import GroupRequest from "@/api/GroupRequest";
  import ProgramRequest from "@/api/ProgramRequest";

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
        const entity = this.getTargetType(this.fieldData.reference_target_type_id).singular_name;

        console.log('hello');

        console.log(entity);

        import(`@/api/${entity}Request`).then(Request => {
          const request = new Request.default({});

          request.setFields({
            params: {
              search: keywords
            }
          });

          request.retrieve(this.fieldData.reference_target_id).then(response => {
            this.fieldTargetItems = response.data;
          });
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
