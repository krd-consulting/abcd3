<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>

            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>

            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" 
                    active-text="Required" 
                    inactive-text="Optional">
                </el-switch>
            </el-form-item>

            <el-form-item label="Set Character Limit">
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

            <el-form-item label="Field Refers To:">
                <!-- <el-select v-model="fieldData.reference">
                    <el-option label="No Reference" value="noRef"></el-option>
                    <el-option label="Another Form" value="form"></el-option>
                    <el-option 
                        v-for="type in recordTypes" 
                        :label="type.name" 
                        :value="type.slug"
                        :key="type.slug"></el-option>
                </el-select> -->

                <base-select
                    v-model="target"
                    name="target"
                    placeholder="Select Resource">
                    <el-option
                        v-for="(type, index) in targetTypes"
                        :key="index"
                        :label="type.name"
                        :value="type.target">
                        {{ type.name }}
                    </el-option>
                </base-select>

                <div v-if="fieldData.reference === 'form'">
                    <p>New Select Menu with list of available <b>forms</b> from back end</p>
                    <p>From there, available fields within that form</p>
                </div>
                <div v-if="fieldData.reference === 'volunteer'">
                    <p>Link to available <b>volunteers</b> from back end</p>
                </div>
                <div v-if="fieldData.reference === 'client'">
                    <p>Link to available <b>Clients</b> from back end</p>
                </div>
                <div v-if="fieldData.reference === 'staff'">
                    <p>Link to available <b>Staff Members</b> from back end</p>
                </div>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Set</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
import Request from '@/api/FormFieldTargetTypeRequest';

export default {
    name: 'textField',
    data: () => {
        return {
            targetTypes: [],

            target: '',

            fieldData: {
                type: 'TextField',
                name: 'text_field',
                label: '',
                settings: {
                    required: false,
                    isLimited: false,
                    max: 50,
                },
                rules: {
                    label: [
                        { required: true, message: 'Please input Question or title', trigger: 'blur' }
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
                return this.target;
            }

            const target = this.target.toString().split('_');

            return target[0];
        },

        target_id() {
            if(this.target.toString().includes('_')) {
                const target = this.target.toString().split('_')
                return target[1];
            }

            return null;
        }
    },
    methods: {
        
        save() {
            this.fieldData['target_type_id'] = this.target_type_id;
            this.fieldData['target_id'] = this.target_id;
            this.$emit('save', this.fieldData);
        },

        retrieve() {
            const request = new Request({});

            request.retrieve().then((response) => {
                this.targetTypes = response.data;
            });
        },
    },

    created() {
        this.retrieve();
    }
}
</script>

<style>

</style>
