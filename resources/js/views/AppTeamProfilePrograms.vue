<template>
    <div>
        <create-program
            :active.sync="create.active"
            :team-id="$route.params.team"
            disable-team
            @save="retrieve()">
        </create-program>

        <list
            :items="programs"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-delete
            :has-list-columns="false"
            :has-edit="false"
            @add="createProgram"
            @delete="confirmDelete"
            @page-change="retrieve()"
            @search="retrieve()">
            <template slot="header-text">Programs</template>
            <template slot="options-add-text">Create Program</template>

            <template slot="list-column-primary-data">Program</template>

            <template v-slot:list-item-primary-data="{ item:program }">
                {{ program.name }}
            </template>

        </list>
    </div>
</template>
<script>
    import List from '../components/AppResourceList';

    import ProgramsRequest from '../api/TeamProgramsRequest';

    import CreateProgram from './AppProgramCreate';

    export default {
        components: {
            List,
            CreateProgram,
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
                    program: {
                        id: ''
                    }
                },
                request: new ProgramsRequest({}),
                programs: [],
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
                this.$confirm('Are you sure you want to delete this program?', 'Delete Program', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.delete(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Program was deleted.'
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
                    this.programs = response.data;
                    this.total = response.meta.total;
                });
            },

            createProgram() {
                this.create.active = true;
            },

        },

        created() {
            this.retrieve();
        }
    }
</script>
