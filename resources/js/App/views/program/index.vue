<template>
    <div>
        <create-program
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-program
            :active.sync="edit.active"
            :program-id="edit.program"
            @update="retrieve()"/>

        <list
            :items="programs"
            :page.sync="params.page"
            :per-page="params.perPage"
            has-add
            has-delete
            :has-list-columns="false"
            :hasSearch="false"
            @add="createProgram"
            @edit="editProgram"
            @delete="confirmDelete"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">Programs</template>
            <template slot="options-add-text">Create Program</template>

            <template v-slot:list-item-primary-data="{ item:program }">
                {{ program.name }}
            </template>

             <template v-slot:list-item-secondary-data="{ item:program }">
                <base-icon class="tw-text-xs align-middle">people</base-icon>{{ program.team.name }}
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '@/api/ProgramRequest';

    import List from '@/App/components/resourceList';
    import CreateProgram from './create';
    import EditProgram from './edit';

    export default {
        components: {
            List,
            CreateProgram,
            EditProgram
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    program: ''
                },
                programs: [],
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
                    this.programs = response.data;
                    this.total = response.meta.total;
                });
            },

            createProgram() {
                this.create.active = true;
            },

            editProgram(program) {
                this.edit.program = program;

                this.edit.active = true;
            },

            confirmDelete(program) {
                this.$confirm('Are you sure you want to delete this program?', 'Delete Program', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteProgram(program)
                        .then(() => {
                            this.retrieve();

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

            deleteProgram(program) {
                let request = new Request();

                return request.destroy(program);
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
