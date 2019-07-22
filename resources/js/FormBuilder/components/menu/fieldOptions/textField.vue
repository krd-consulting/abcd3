<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>

            <el-form-item label="Question/Title" prop="title">
                <el-input v-model="fieldData.title"></el-input>
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
                <el-select v-model="fieldData.reference">
                    <el-option label="No Reference" value="noRef"></el-option>
                    <el-option label="Another Form" value="form"></el-option>
                    <el-option 
                        v-for="type in recordTypes" 
                        :label="type.name" 
                        :value="type.slug"
                        :key="type.slug"></el-option>
                </el-select>

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
import RecordTypeRequest from '@/api/RecordTypeRequest';

export default {
    name: 'textField',
    data: () => {
        return {
            recordTypes: [],

            fieldData: {
                type: 'TextField',
                name: 'text_field',
                title: '',
                reference: '',
                settings: {
                    required: false,
                    isLimited: false,
                    max: 50,
                },
                rules: {
                    title: [
                        { required: true, message: 'Please input Question or title', trigger: 'blur' }
                    ]
                }
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {
        
        save() {
            this.$emit('save', this.fieldData);
        },

        retrieveRecordTypes() {
            const request = new RecordTypeRequest({});

            request.retrieve().then((response) => {
                this.recordTypes = response;
            });
        },
    },

    created() {
        this.retrieveRecordTypes();
    }
}
</script>

<style>

</style>
