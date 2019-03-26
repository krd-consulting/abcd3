<template>
    <transfer
        :active="active"
        :items="programs"
        :selected="selected"
        @add="add"
        @remove="remove"
        @open="open"
        @close="close">
            <template v-slot:title>
                <slot name="title">Manage Programs</slot>
            </template>
            <template v-slot:current-items-title>
                Current Programs
            </template>
            <template v-slot:available-items-title>
                Available Programs
            </template>
            <template v-slot:current-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:current-item-subtitle="{ item }">
                {{ item.team.name }}
            </template>
            <template v-slot:available-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:available-item-subtitle="{ item }">
                {{ item.team.name }}
            </template>
            <template v-slot:empty-available-items>
                No more available programs.
            </template>
    </transfer>
</template>
<script>
    import ProgramRequest from '../api/ProgramRequest';
    import RecordProgramsRequest from '../api/RecordProgramsRequest';

    import Transfer from '../components/AppTransfer';

    export default {
        components: {
            Transfer
        },

        props: {
            active: Boolean,
            assignedPrograms: Array
        },

        data() {
            return {
                programs: [],
                programsRequest: new ProgramRequest({}),
                recordProgramsRequest: new RecordProgramsRequest({}),
                selected: [],
            }
        },

        computed: {
            notSelected() {
                return _.differenceBy(this.programs, this.selected, 'id');
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            open() {
                this.selected = _.cloneDeep(this.assignedPrograms);

                this.programsRequest.retrieve().then(response => {
                    this.programs = response;
                });
            },

            add(id) {
                this.recordProgramsRequest.store(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected.push(_.find(this.programs, {id}));
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });
            },

            remove(id) {
                this.recordProgramsRequest.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected = _.reject(this.selected, { id });
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });;
            }
        },

        created() {

        }
    }
</script>
