<template>
    <div>
        <create-group
            :active.sync="create.active"
            @save="retrieve"/>

        <edit-group
            :active.sync="edit.active"
            :group="edit.group"
            @update="retrieve"/>

        <list :hasHeader="true">
            <template slot="header-text">Groups</template>
            <template slot="options">
                <div class="tw-flex tw-flex-row-reverse">
                    <base-button class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" @click="createGroup">
                        <base-icon class="tw-text-base tw-font-bold tw-align-middle">add</base-icon>
                        <span class="tw-align-middle">Create Group</span>
                    </base-button>
                </div>
            </template>
            <list-item
                v-for="(group, index) in groups"
                :key="index"
                :to="`/groups/${group.id}`"
                class="tw-py-4 tw-px-4">
                {{ group.name }}

                <template v-if="group.program" slot="secondary-data-text">{{ group.program.name }}</template>
                <template slot="options">
                    <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none" @click="editGroup(group)">
                        <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                        <span class="tw-text-xs tw-align-middle">Edit</span>
                    </base-button>
                    <base-button
                        class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none"
                        @click="confirmDelete(group)">
                        <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
                        <span class="tw-text-xs tw-align-middle">Delete</span>
                    </base-button>
                </template>
            </list-item>
            <template slot="pagination" slot-scope="pagination">
                <span class="tw-pl-4 tw-py-4 tw-text-sm tw-font-semibold tw-text-grey-dark">Showing all {{ total }} groups</span>
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '../api/GroupRequest';

    import List from '../components/AppList';
    import ListItem from '../components/AppListItem';
    import CreateGroup from './AppGroupCreate';
    import EditGroup from './AppGroupEdit';

    export default {
        components: {
            List,
            ListItem,
            CreateGroup,
            EditGroup
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    group: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                    }
                },
                groups: [],
                request: new Request({}),
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

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve().then(response => {
                    this.groups = response;
                    this.total = response.length;
                });
            },

            createGroup() {
                this.create.active = true;
            },

            editGroup(group) {
                this.edit.group = group;

                this.edit.active = true;
            },

            confirmDelete(group) {
                this.$confirm('Are you sure you want to delete this group?', 'Delete Group', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteGroup(group)
                        .then(() => {
                            this.retrieve();

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

            deleteGroup(group) {
                let request = new Request();

                return request.destroy(group.id);
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
