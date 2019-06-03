<template>
    <div>
        <create-group
            :active.sync="add.active"
            :program-id="$route.params.program"
            @save="retrieve()"/>

        <list
            :items="groups"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-delete
            has-list-columns
            :has-edit="false"
            @add="createGroup"
            @delete="confirmDelete($event)"
            @page-change="retrieve()"
            @search="retrieve()">
            <template slot="header-text">Groups</template>
            <template slot="options-add-text">Create Group</template>

            <template slot="list-column-primary-data">Group</template>

            <template v-slot:list-item-primary-data="{ item:group }">
                {{ group.name }}
            </template>

            <template v-slot:list-item-secondary-data="{ item:group }">
                
            </template>
        </list>
    </div>
</template>
<script>
    import GroupsRequest from '@/api/ProgramGroupsRequest';

    import List from '@/App/components/resourceList';
    import CreateGroup from '../create';

    export default {
        components: {
            List,
            CreateGroup,
        },

        data() {
            return {
                add: {
                    active: false
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
            remove(id) {
                return this.request.destroy(id).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(id) {
                this.$confirm('Are you sure you want to delete this group?', 'Delete Group', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
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

            retrieve(program = this.$route.params.program) {
                this.request.retrieve(program).then((response) => {
                    this.groups = response.data;
                    this.total = response.meta.total;
                });
            },

            createGroup() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
