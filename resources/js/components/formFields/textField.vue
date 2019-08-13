<template>
    <div id="textField" class="tw-my-8">
        <el-row>
            <el-col :span="6">
                <label for="text" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>
            <el-col v-if="field.reference_target_type_id == null" :span="10">
                <el-input id="text"
                    v-if="limit"
                    show-word-limit  
                    v-model="value" 
                    :required="isRequired"
                    :maxlength="max">
                </el-input>
                <el-input id="text"
                    v-else 
                    v-model="value" 
                    :required="isRequired">
                </el-input>
            </el-col>
            <el-col v-else :span="10">
                <base-select
                    v-if="targetName == 'Record'"
                    v-model="value"
                    filterable
                    remote
                    :remote-method="retrieveTargetItems"
                    name="type"
                    :placeholder="`Input ${targetName}`"
                    @change="targetRequest.errors.clear('team_id')">
                    <el-option
                        v-for="(item, index) in targetItems"
                        :key="index"
                        :label="getPrimaryData(item, item.fields)"
                        :value="item.id">
                        {{ getPrimaryData(item, item.fields) }}
                    </el-option>
                </base-select>

                <base-select
                    v-else-if="targetName == 'Form Field'"
                    v-model="value"
                    @click.native="retrieveTargetItems"
                    filterable
                    remote
                    :remote-method="retrieveTargetItems"
                    name="type"
                    :placeholder="`Input ${targetName}`"
                    @change="targetRequest.errors.clear('team_id')">
                    <el-option
                        v-for="(item, index) in targetItems"
                        :key="index"
                        :label="item.value"
                        :value="item.value">
                        {{ item.value }}
                    </el-option>
                </base-select>

                <base-select
                    v-else
                    v-model="value"
                    @click.native="retrieveTargetItems"
                    filterable
                    remote
                    :remote-method="retrieveTargetItems"
                    name="type"
                    :placeholder="`Input ${targetName}`"
                    @change="targetRequest.errors.clear('team_id')">
                    <el-option
                        v-for="(item, index) in targetItems"
                        :key="index"
                        :label="item.name"
                        :value="item.id">
                        {{ item.name }}
                    </el-option>
                </base-select>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import TargetTypeRequest from '@/api/FormFieldTargetTypeRequest';

    import ProgramRequest from '@/api/ProgramRequest';
    import GroupRequest from '@/api/GroupRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';
    import RecordRequest from '@/api/RecordRequest';
    import FormFieldEntryRequest from '@/api/FormFieldEntryRequest';

    export default {

        data() {
            return {
                value: '',
                targetTypeRequest: new TargetTypeRequest({}),
                targetType: {
                    name: ''
                },
                targetRequest: {},
                requests: {
                    Program: ProgramRequest,
                    Group: GroupRequest,
                    Record: RecordRequest,
                    'Form Field': FormFieldEntryRequest
                },
                targetParams: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                recordParams: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                fieldParams: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                targetItems: [],
            }
        },
        props: { 
            field: {
                type: Array | Object,
                default: {}
            }
        },
        computed: {
            max: {
                get() { return this.field.settings.max }
            },
            isRequired: {
                get() { return this.field.settings.required }
            },
            limit: {
                get() { return this.field.settings.isLimited }
            },
            targetName() {
                return this.targetType.name;
            }
        },
        methods: {
            getTargetType() {
                if(this.field.reference_target_type_id == null)
                    return;

                this.targetTypeRequest.show(this.field.reference_target_type_id).then((response) => {
                    this.targetType = response.data;
                });
            },

            retrieveTargetItems(keywords) {
                this.targetRequest = new this.requests[this.targetName]({});

                this.targetParams.search = keywords;
                let params = this.targetParams;

                if(this.targetName == 'Record') {
                    this.recordParams.search = keywords;
                    params = this.recordParams;

                    const request = new RecordTypeRequest({});
                    request.show(this.field.reference_target_id).then((response) => {
                        this.targetRequest.setFields({
                            params
                        });

                        this.targetRequest.retrieve(response.data.slug).then((response) => {
                            this.targetItems = response.data;
                        });
                    });

                    return;
                } else if(this.targetName == 'Form Field') {
                    this.fieldParams.search = keywords;
                    params = this.fieldParams;

                    this.targetRequest.setFields({
                        params
                    });

                    this.targetRequest.retrieve(this.field.reference_target_id).then((response) => {
                        this.targetItems = response.data;

                        console.log(response.data);
                    });

                    return;
                }

                this.targetRequest.setFields({
                    params
                });

                this.targetRequest.retrieve().then((response) => {
                    this.targetItems = response.data;
                });
            },

            getPrimaryData(record, fields) {
                let remainingFields = [];

                if('first_name' in fields)
                    remainingFields.push('first_name');

                if('last_name' in fields)
                    remainingFields.push('last_name');

                if('business_name' in fields)
                    remainingFields.push('business_name');

                let data = '';

                remainingFields.forEach(field => {
                    data += record[field] + ' ';
                });

                return data.trim();
            },
        },

        created() {
            this.getTargetType();
        }
    }
</script>
