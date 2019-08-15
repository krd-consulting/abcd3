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
                    v-model="target"
                    name="target"
                    placeholder="Stands alone">
                    <el-option
                        v-for="(type, index) in targetTypes"
                        :key="index"
                        :label="type.name"
                        :value="type.target">
                        Refers to {{ type.name }}
                    </el-option>
                </base-select>

                <base-select
                    v-if="targetName == 'Form Fields'"
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
        target_type_id() {
            if(!this.target.toString().includes('_')) {
                this.fieldData.reference_target_type_id = this.target;
                return this.target;
            }

            const target = this.target.toString().split('_');

            this.fieldData.reference_target_type_id = target[0];
            this.fieldData.reference_target_id = target[1];

            return target[0];
        },

        target_id() {
            if(this.target.toString().includes('_')) {
                const target = this.target.toString().split('_')
                return target[1];
            }else if(this.targetName == 'Form Fields') {
                return this.fieldData.reference_target_id;
            }

            return null;
        },

        targetName() {
            let targetType = null;

            targetType = _.find(this.targetTypes, _.matchesProperty('target', this.target));

            if(targetType == null)
                return null;

            if(targetType.name == 'Form Fields')
                this.retrieveForms();

            return targetType.name;
        }
    },
    methods: {
        save(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.fieldData.reference_target_type_id = this.target_type_id;
                    this.fieldData.reference_target_id = this.target_id;
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
