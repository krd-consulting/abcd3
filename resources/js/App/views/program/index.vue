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
            has-disable
            :has-list-columns="false"
            :hasSearch="false"
            @add="createProgram"
            @edit="editProgram"
            @delete="confirmDelete"
            @disable="confirmDisable"
            @enable="confirmEnable"
            @page-change="retrieve()"
            @show-inactive="toggleInactive"
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

    import methods from './methods';

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
            ...methods,

            retrieve: methods.index,

            toggleInactive(showInactive) {
                this.params.active = !showInactive;
                this.params.page = 1;
                this.retrieve();
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
