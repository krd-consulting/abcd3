<template>
    <div>
        <create-group
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-group
            :active.sync="edit.active"
            :group-id="edit.group"
            @update="retrieve()"/>

        <list
            :items="groups"
            :page.sync="params.page"
            :per-page="params.perPage"
            has-add
            has-delete
            :has-list-columns="false"
            :hasSearch="false"
            @add="createGroup"
            @edit="editGroup"
            @delete="confirmDelete"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">Groups</template>
            <template slot="options-add-text">Create Group</template>

            <template v-slot:list-item-primary-data="{ item:group }">
                {{ group.name }}
            </template>

             <template v-slot:list-item-secondary-data="{ item:group }">
                <base-icon class="tw-text-xs align-middle">assignment</base-icon>{{ group.program.name }}
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '../api/GroupRequest';

    import List from '../components/AppResourceList';
    import CreateGroup from './AppGroupCreate';
    import EditGroup from './AppGroupEdit';

    export default {
        components: {
            List,
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
                    perPage: 5,
                    search: ''
                },
                total: 0,
            }
        },

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve().then(response => {
                    this.groups = response.data;
                    this.total = response.total;

                    console.log(this.total);
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

                return request.destroy(group);
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
