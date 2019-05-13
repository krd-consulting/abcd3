<template>
    <div>
        <edit-record
            :active.sync="edit.active"
            :record="edit.record"
            :fields="fields"
            :record-type="record.type"
            @update="retrieve"/>

        <resource-profile 
            :record="record"
            :fields="fields"
            @edit="editRecord(record)" 
            @delete="confirmDelete(record)">
            <template v-slot:main-information-container>
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
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ record.type.name }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import RecordRequest from '../api/RecordRequest';

    import ResourceProfile from '../components/AppResourceProfile';
    import EditRecord from './AppRecordEdit';
    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {

        components: {
            ResourceProfile,
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
                        name: '',
                        identity: {
                            name: ''
                        }
                    }
                },
                request: new RecordRequest({}),
            }
        },

        methods: {
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
