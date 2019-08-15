<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>

            <el-form-item prop="title">
                <label>
                    Question/Title
                </label>
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>

            <el-form-item>
                <label>
                    This field is
                </label>
                <el-switch v-model="fieldData.settings.required" 
                    active-text="Required" 
                    inactive-text="Optional">
                </el-switch>
            </el-form-item>

            <el-form-item>
                <label>
                    Set character limit
                </label>
                <el-switch v-model="fieldData.settings.isLimited" 
                    inactive-text="No Limit" 
                    active-text="Limit">
                </el-switch>
                <el-input-number v-model="fieldData.settings.max" 
                    :disabled="!fieldData.settings.isLimited"
                    :step="5"
                    step-strictly>
                </el-input-number>
            </el-form-item>

            <el-form-item>
                <label>
                    This field
                </label>
                <base-select
                    v-model="fieldData.reference_target_type_id"
                    @change="fieldData.reference_target_id = null"
                    name="target"
                    placeholder="Stands alone">
                    <el-option
                        :key="-1"
                        label="Stands alone"
                        value="">
                        Stands alone
                    </el-option>
                    <el-option
                        v-for="(type, index) in targetTypes"
                        :key="index"
                        :label="type.name"
                        :value="type.id">
                        Refers to {{ type.name }}
                    </el-option>
                </base-select>

                <base-select
                    v-if="targetName == 'Records'"
                    v-model="fieldData.reference_target_id"
                    name="record_type"
                    filterable
                    remote
                    :remote-method="retrieveRecordTypes"
                    placeholder="Select record type">
                    <el-option
                        v-for="(type, index) in recordTypes"
                        :key="index"
                        :label="type.name"
                        :value="type.id">
                        {{ type.name }}
                    </el-option>
                </base-select>

                <base-select
                    v-else-if="targetName == 'Form Fields'"
                    v-model="form_id"
                    @change="retrieveFields(''); fieldData.reference_target_id = null"
                    name="form"
                    filterable
                    remote
                    :remote-method="retrieveForms"
                    placeholder="Select form">
                    <el-option
                        v-for="(form, index) in forms"
                        :key="index"
                        :label="form.name"
                        :value="form.id">
                        {{ form.name }}
                    </el-option>
                </base-select>

                <base-select
                    v-if="targetName == 'Form Fields' && form_id != null"
                    v-model="fieldData.reference_target_id"
                    name="field"
                    filterable
                    remote
                    :remote-method="retrieveFields"
                    placeholder="Select form field">
                    <el-option
                        v-for="(field, index) in fields"
                        :key="index"
                        :label="field.title"
                        :value="field.id">
                        {{ field.title }}
                    </el-option>
                </base-select>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save('fieldData')" class="tw-w-48">Add it!</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
import FormFieldTargetTypesRequest from '@/api/FormFieldTargetTypeRequest';
import RecordTypeRequest from '@/api/RecordTypeRequest';
import FormRequest from '@/api/FormRequest';
import FieldRequest from '@/api/FormFieldRequest';

export default {
    name: 'textField',
    data: () => {
        return {
            targetTypes: [],
            target: '',
            formRequest: new FormRequest({}),
            formParams: {
                ascending: true,
                sortBy: 'name',
                page: 1,
                perPage: 10,
                search: ''
            },
            forms: [],
            form_id: null,
            record_type: null,
            recordTypes: [],
            fieldRequest: new FieldRequest({}),
            fieldParams: {
                ascending: true,
                sortBy: 'title',
                page: 1,
                perPage: 10,
                search: '',
                field_type: 'text'
            },
            fields: [],
            field_id: null,

            fieldData: {
                type: 'TextField',
                name: 'text_field',
                title: '',
                reference_target_type_id: '',
                reference_target_id: '',
                settings: {
                    required: false,
                    isLimited: false,
                    max: 50,
                },
                rules: {
                    title: [
                        { required: true, message: 'Please input question title', trigger: 'blur' }
                    ]
                }
            },
        }
    },

    props: {
        inputData: Object,
    },
    
    computed: {
        targetName() {
            let targetType = null;

            targetType = _.find(
                this.targetTypes, 
                _.matchesProperty('id', this.fieldData.reference_target_type_id)
            );

            if(targetType == null)
                return null;

            if(targetType.name == 'Records') {
                this.retrieveRecordTypes();
            }else if(targetType.name == 'Form Fields') {
                this.retrieveForms();
            }

            return targetType.name;
        }
    },
    methods: {
        save(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$emit('save', this.fieldData);
                } else {
                    this.$message.error('Oops, You forgot to enter a Question/Title for this field.');
                    return false;
                }
            })
        },       

        retrieveTargetTypes() {
            const request = new FormFieldTargetTypesRequest({});

            request.retrieve().then((response) => {
                this.targetTypes = response.data;
            });
        },

        retrieveRecordTypes() {
            const request = new RecordTypeRequest({});

            request.retrieve().then((response) => {
                this.recordTypes = response.data;
            });
        },

        retrieveForms(keywords){
            this.formParams.search = keywords;

            this.formRequest.setFields({
                params: {...this.formParams}
            });

            this.formRequest.retrieve().then((response) => {
                this.forms = response.data;
            });
        },

        retrieveFields(keywords){
            this.fieldParams.search = keywords;

            this.fieldRequest.setFields({
                params: {...this.fieldParams}
            });

            this.fieldRequest.retrieve(this.form_id).then((response) => {
                this.fields = response.data;
            });;
        }
    },

    created() {
        this.retrieveTargetTypes();
    }
}
</script>

<style>

</style>
