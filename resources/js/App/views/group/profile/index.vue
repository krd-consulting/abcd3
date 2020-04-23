<template>
    <div>

        <edit-group
            :active.sync="edit.active"
            :group="edit.group"
            @update="retrieve"/>

        <resource-profile
            :extra-information-path="`/programs/${group.program.id}`"
            :record-types="recordTypes"
            @edit="editGroup(group)"
            @delete="confirmDelete(group)">
            <template v-slot:header>
                {{ group.name }}
            </template>
            <template v-slot:subheader>
                {{ group.description }}
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ group.program.name }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import GroupRequest from '@/api/GroupRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    import ResourceProfile from '@/App/components/resourceProfile';
    import EditGroup from '../edit';

    export default {
        components: {
            ResourceProfile,
            EditGroup
        },

        data() {
            return {
                group: {
                    name: '',
                    program: {
                        name: ''
                    }
                },
                edit: {
                    active: false,
                    group: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                        team_id: ''
                    }
                },
                recordTypes: [],
                request: new GroupRequest({}),
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        methods: {
            handleClick(tab, event) {
                if(tab.name.includes('group_profile_records_'))
                    return this.handleRecordTabClick(tab.name.replace('group_profile_records_', ''));

                this.$router.push({ name: `${tab.name}`});
            },

            handleRecordTabClick(recordType) {
                this.$router.push({ name: 'group_profile_records', params:  {recordType}});
            },

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(this.$route.params.group).then((response) => {
                    this.group = response.data;
                });
            },

            retrieveRecordTypes() {
                const request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response.data;
                });
            },

            confirmDelete(group) {
                this.$confirm('Are you sure you want to delete this group?', 'Delete Group', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteGroup(group)
                        .then(() => {
                            this.$router.push('/groups');

                            this.$message({
                                type: 'success',
                                message: 'Group was deleted.'
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

            editGroup(group) {
                this.edit.group = group;

                this.edit.active = true;
            },

            deleteGroup(group) {
                let request = new GroupRequest({});

                return request.destroy(group.id);
            },
        },

        created() {
            this.retrieve();
            this.retrieveRecordTypes();
        }

    }
</script>
