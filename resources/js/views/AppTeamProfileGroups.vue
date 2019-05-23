<template>
    <div>
        <create-group
            :active.sync="create.active"
            :team-id="$route.params.team"
            disable-team
            @save="retrieve()">
        </create-group>

        <list
            :items="groups"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-delete
            :has-list-columns="false"
            :has-edit="false"
            @add="createGroup"
            @delete="confirmDelete"
            @page-change="retrieve()"
            @search="retrieve()">
            <template slot="header-text">Groups</template>
            <template slot="options-add-text">Create Group</template>

            <template slot="list-column-primary-data">Group</template>

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
    import List from '../components/AppResourceList';

    import GroupsRequest from '../api/TeamGroupsRequest';

    import CreateGroup from './AppGroupCreate';

    export default {
        components: {
            List,
            CreateGroup,
        },

        props: {
            record: Object,
            fields: Array|Object
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    group: {
                        id: ''
                    }
                },
                request: new GroupsRequest({}),
                groups: [],
                params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
            }
        },

        methods: {
            delete(id) {
                return this.request.destroy(
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(id) {
                this.$confirm('Are you sure you want to delete this group?', 'Delete Group', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.delete(id)
                        .then(() => {
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

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(this.$route.params.team).then((response) => {
                    this.groups = response.data;
                    this.total = response.meta.total;
                });
            },

            createGroup() {
                this.create.active = true;
            },

        },

        created() {
            this.retrieve();
        }
    }
</script>
