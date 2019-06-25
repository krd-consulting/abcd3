<template>
    <div>
        <add-group 
            :active.sync="add.active" @close="retrieve()"/>

        <list
            :items="groups"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-remove
            has-list-columns
            :has-search="false"
            :has-edit="false"
            @add="addGroup"
            @remove="confirmDelete($event)"
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
    import GroupsRequest from '@/api/RecordGroupsRequest';

    import List from '@/App/components/resourceList';
    import AddGroup from './addGroup';

    export default {
        components: {
            List,
            AddGroup,
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
                return this.request.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirm(id) {
                this.$confirm('Are you sure you want to remove this group?', 'Remove Group', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Group was removed.'
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

            confirmDelete(id) {
                this.$confirm('Are you sure you want to remove this group?', 'Remove Group', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Group was removed.'
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
                this.request.retrieve(this.$route.params.recordType, this.$route.params.record).then((response) => {
                    this.groups = response.data;
                    this.total = response.meta.total;
                });
            },

            addGroup() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
