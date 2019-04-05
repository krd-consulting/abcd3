<template>
    <div>
        <edit-group
            :active.sync="edit.active"
            :group="edit.group"
            @update="retrieve"/>

        <div class="tw-shadow tw-rounded tw-bg-white">
            <div class="tw-flex tw-items-start tw-justify-between tw-p-4 tw-border-b-2">
                <div>
                    <h1 class="tw-font-semibold tw-text-xl">{{ group.name }}</h1>
                    <p class="tw-text-grey">{{ group.description }}</p>
                </div>
                <div class="tw-text-right">
                    <div>
                        <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">people</base-icon>
                        <span class="tw-uppercase tw-text-grey tw-text-xs tw-font-semibold">{{ group.program.name }}</span>
                    </div>
                    <div>
                        <base-button @click="editGroup(group)" class="tw-py-2 tw-px-0 tw-mr-4 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none">
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
                    <el-tab-pane name="group_profile_summary" label="Summary">
                    </el-tab-pane>
                    <el-tab-pane v-for="(type, key) in recordTypes" :name="`group_profile_records_${type.slug}`" :key="key" label="Summary">
                        <template slot="label">
                            <base-icon class="tw-align-middle tw-text-sm">insert_drive_file</base-icon>
                            {{ type.name }}
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
    import GroupRequest from '../api/GroupRequest';
    import RecordTypeRequest from '../api/RecordTypeRequest';

    import EditGroup from './AppGroupEdit';

    export default {
        components: {
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
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        computed: {
            firstItemNo() {
                return (this.params.perPage*(this.params.page-1)) + 1 ;
            },

            lastItemNo() {
                const itemNo = this.params.page*this.params.perPage;

                if(itemNo > this.total)
                    return this.total;

                return itemNo;
            },

            paginationInfo() {
                return `Showing ${ this.firstItemNo }-${ this.lastItemNo } of ${ this.total }`;
            }
        },

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 5;
                this.retrieve();
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
                    this.group = response;
                });
            },

            retrieveRecordTypes() {
                const request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response;
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
