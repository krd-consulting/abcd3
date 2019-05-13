<template>
    <div>
        <create-program
            :active.sync="create.active"
            @save="retrieve"/>

        <edit-program
            :active.sync="edit.active"
            :program-id="edit.program"
            @update="retrieve"/>

        <list :hasHeader="true">
            <template slot="header-text">Programs</template>
            <template slot="options">
                <div class="tw-flex tw-flex-row-reverse">
                    <base-button class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" @click="createProgram">
                        <base-icon class="tw-text-base tw-font-bold tw-align-middle">add</base-icon>
                        <span class="tw-align-middle">Create Program</span>
                    </base-button>
                </div>
            </template>
            <list-item
                v-for="(program, index) in programs"
                :key="index"
                :to="`/programs/${program.id}`"
                class="tw-py-4 tw-px-4">
                {{ program.name }}
                <template v-if="program.team" slot="secondary-data-text">{{ program.team.name }}</template>
                <template slot="options">
                    <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none" @click="editProgram(program.id)">
                        <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                        <span class="tw-text-xs tw-align-middle">Edit</span>
                    </base-button>
                    <base-button
                        class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none"
                        @click="confirmDelete(program.id)">
                        <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
                        <span class="tw-text-xs tw-align-middle">Delete</span>
                    </base-button>
                </template>
            </list-item>
            <template slot="pagination" slot-scope="pagination">
                <span class="tw-pl-4 tw-py-4 tw-text-sm tw-font-semibold tw-text-grey-dark">Showing all {{ total }} programs</span>
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '../api/ProgramRequest';

    import List from '../components/AppList';
    import ListItem from '../components/AppListItem';
    import CreateProgram from './AppProgramCreate';
    import EditProgram from './AppProgramEdit';

    export default {
        components: {
            List,
            ListItem,
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
                    this.total = response.data.length;
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
