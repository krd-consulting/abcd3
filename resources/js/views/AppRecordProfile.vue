<template>
    <div>
        <edit-record
            :active.sync="edit.active"
            :record="edit.record"
            :fields="fields"
            :record-type="record.type"
            @update="retrieve"/>

        <div class="tw-shadow tw-rounded tw-bg-white">
            <div class="tw-flex tw-items-top tw-justify-between tw-p-4">
                <div>
                    <div class="tw-inline-block tw-align-middle">
                        <profile-picture class="tw-mr-2 tw-w-16 tw-h-16 tw-text-2xl" :record="record" :fields="fields" />
                    </div>
                    <div class="tw-inline-block tw-align-middle">
                        <h1>
                            <primary-data class="tw-mb-2 tw-block tw-font-semibold tw-text-xl" :record="record" :fields="fields"/>
                        </h1>
                        <p>
                            <secondary-data class="tw-text-sm" :record="record" :fields="fields"></secondary-data>
                        </p>
                    </div>
                </div>
                <div class="tw-text-right">
                    <div>
                        <span class="tw-uppercase tw-text-grey tw-text-xs tw-font-semibold">{{ record.type.name }}</span>
                    </div>
                    <div>
                        <base-button @click="editRecord(record)" class="tw-py-2 tw-px-0 tw-mr-4 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                            <span class="tw-text-xs tw-align-middle">Edit</span>
                        </base-button>
                        <base-button @click="confirmDelete(record)" class="tw-py-2 tw-px-0 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
                            <span class="tw-text-xs tw-align-middle">Delete</span>
                        </base-button>
                    </div>
                </div>
            </div>
            <div class="tw-bg-grey-lightest">
                <el-tabs  @tab-click="handleClick">
                    <el-tab-pane name="record_profile_summary" label="Summary">
                    </el-tab-pane>
                    <el-tab-pane name="record_profile_programs">
                        <template slot="label">
                            <base-icon class="tw-align-middle tw-text-sm">assignment</base-icon>
                            Programs
                        </template>
                    </el-tab-pane>
                </el-tabs>
            </div>
            <div>
                <router-view/>
            </div>
        </div>
    </div>
</template>
<script>
    import RecordRequest from '../api/RecordRequest';

    import EditRecord from './AppRecordEdit';
    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {

        components: {
            EditRecord,
            ProfilePicture,
            PrimaryData,
            SecondaryData
        },

        data() {
            return {
                edit: {
                    active: false,
                    record: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                    }
                },
                fields: [],
                record: {
                    type: {
                        name: ''
                    }
                },
                request: new RecordRequest({}),
            }
        },

        methods: {
            handleClick(tab, event) {
                this.$router.push({ name: `${tab.name}`});
            },

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(this.$route.params.recordType, this.$route.params.record).then((response) => {


                    this.record = response.data;
                    this.fields = response.data.fields;
                });
            },

            confirmDelete(record) {
                this.$confirm('Are you sure you want to delete this record?', 'Delete Record', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteRecord(record)
                        .then(() => {
                            this.$emit('delete', record);

                            this.$router.push(`/records/${this.record.type_slug}`);

                            this.$message({
                                type: 'success',
                                message: 'Record was deleted.'
                            });
                        })
                        .catch((error) => {
                            this.$message({
                                type: 'error',
                                message: error.message
                            });
                        });
                })
            },

            editRecord(record) {
                this.edit.record = record;

                this.edit.active = true;
            },

            deleteRecord(record) {
                let request = new RecordRequest(record);

                return request.destroy(record.id);
            }
        },

        created() {
            this.retrieve();
        }

    }
</script>
