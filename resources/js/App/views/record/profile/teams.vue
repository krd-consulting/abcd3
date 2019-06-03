<template>
    <div>
        <add-team 
            :active.sync="add.active" @close="retrieve()"/>

        <list
            :items="teams"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-delete
            has-list-columns
            :has-search="false"
            :has-edit="false"
            :has-delete="false"
            @add="addTeam"
            @page-change="retrieve()"
            @search="retrieve()">
            <template slot="header-text">Teams</template>
            <template slot="options-add-text">Add Team</template>

            <template slot="list-column-primary-data">Team</template>

            <template v-slot:list-item-primary-data="{ item:team }">
                {{ team.name }}
            </template>

            <template v-slot:list-item-secondary-data="{ item:team }">
                
            </template>
        </list>
    </div>
</template>
<script>
    import TeamsRequest from '@/api/RecordTeamsRequest';

    import List from '@/App/components/resourceList';
    import AddTeam from './addTeam';

    export default {
        components: {
            List,
            AddTeam,
        },

        data() {
            return {
                add: {
                    active: false
                },
                request: new TeamsRequest({}),
                teams: [],
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
                this.$confirm('Are you sure you want to remove this team?', 'Remove Team', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Team was removed.'
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
                    this.teams = response.data;
                    this.total = response.meta.total;
                });
            },

            addTeam() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
