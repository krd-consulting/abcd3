<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Update <primary-data :record="record" :fields="fields"/>'s program status
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Status
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="requestData.status"
                            name="status"
                            placeholder="Select Program Status"
                            @change="request.errors.clear('status');requestData.notes = ''">
                            <el-option
                                v-for="status in statuses"
                                :key="status.id"
                                :label="status.name"
                                :value="status">
                                {{ status.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('status')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('status')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Enrollment Date
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="requestData.enrolled_at"
                            name="enrolled_at"
                            type="date"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('enrolled_at')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('enrolled_at')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Notes
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="requestData.notes"
                            name="notes"
                            type="textarea"
                            @keydown="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('status')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('status')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-grey-lightest tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-grey-darker tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close()">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue tw-text-white tw-font-bold tw-border-none" @click="update">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '../api/ProgramRecordsRequest';

    import PrimaryData from '../components/RecordPrimaryData';

    export default {
        props: {
            active: Boolean,
            enrolledAt: String,
            record: Object,
            programId: String|Number,
            programStatus: Array|Object,
            recordType: String|Object,
            fields: Array|Object
        },

        components: {
            PrimaryData
        },

        data() {
            return {
                request: new Request(),
                recordId: '',
                requestData: {
                    status: {
                        id: '',
                        name: ''
                    },
                    notes: '',
                    enrolled_at: ''
                },
                statuses: []
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.requestData = {
                    status: {
                        name: '',
                    },
                    notes: '',
                    enrolled_at: ''
                };
            },

            open() {
                this.recordId = this.record.id;
                this.requestData.status = this.programStatus.status;
                this.requestData.notes = this.programStatus.notes;
                this.requestData.enrolled_at = this.enrolledAt;

                this.load();
            },

            load() {
                let request = new Request({});

                request.edit(this.programId, this.recordType.slug, this.recordId).then((response) => {
                    this.statuses = response;
                });
            },

            update() {
                this.request = new Request(this.requestData);

                this.request.update(this.programId, this.recordType.slug, this.recordId)
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
                    });
            }
        },

        created() {

        }
    }
</script>
