<template>
    <base-dialog :visible="active" @close="close" @open="retrieve">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit {{ recordType.name }}
        </div>
        <form>
            <div v-for="(field, fieldName) in fields" class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        {{ fieldName.replace('_', ' ') }}
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-if="fieldName == 'birth_date'"
                            v-model="newRecordData[field]"
                            :name="fieldName"
                            type="date"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                        <base-input
                            v-else
                            v-model="newRecordData[field]"
                            :name="fieldName"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has(field)" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get(field)[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none" @click="update">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import RecordRequest from '@/api/RecordRequest';
    import TeamRequest from '@/api/TeamRequest';

    export default {
        props: {
            active: Boolean,
            recordId: Number | String 
        },

        data() {
            return {
                newRecordData: {
                    id: '',
                    field_1_value: '',
                    field_2_value: '',
                    field_3_value: '',
                },
                request: new RecordRequest(),
                fields: [],
                recordType: this.$route.params.recordType,
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();
            },

            retrieve() {
                let request = new RecordRequest({});

                request.edit(this.recordType, this.recordId).then((response) => {
                    this.initializeWithData(response.data);
                });
            },

            initializeWithData(data) {
                this.fields = data.fields;
                const invertedFields = _.invert(data.fields);
                this.newRecordData.field_1_value = data[invertedFields['field_1_value']];
                this.newRecordData.field_2_value = data[invertedFields['field_2_value']];
                this.newRecordData.field_3_value = data[invertedFields['field_3_value']];
            },

            update() {
                this.request = new RecordRequest(this.newRecordData);

                this.request.update(this.recordType, this.recordId)
                    .then((response) => {
                        this.$emit('update');
                        this.$message({
                            type: 'success',
                            message: 'Record updated successfully!'
                        });
                        this.close()
                    })
                    .catch((error) => {
                        this.$message({
                            type: 'error',
                            message: error.message
                        });
                        this.close()
                    });
            }
        },

        created() {

        }
    }
</script>
