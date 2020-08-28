<template>
    <div>
        <create-program
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-program
            :active.sync="edit.active"
            :program-id="edit.program"
            @update="retrieve()"/>

        <grid
            :title="'Programs'"
            :items="programs"
            :fields="fields"
            :page.sync="params.page"
            :sortBy.sync="params.sortBy"
            :ascending.sync="params.ascending"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            has-add
            has-delete
            @add="createProgram"
            @edit="editProgram"
            @delete="confirmDelete($event)"
            @enable="confirmEnable($event)"
            @params-change="retrieve();"
            @show-inactive="toggleInactive"
            :total="total">
            <template v-slot:name="{ value, data }">
              <router-link
                :to="`${$route.path}/${data.id}`"
                class="tw-font-bold tw-text-black hover:tw-text-black"
              >{{ value }}</router-link>
            </template>
        </grid>
    </div>
</template>
<script>
    import Request from '@/api/ProgramRequest';

    import methods from './methods';

    import Grid from '@/components/extendable/grid';
    import CreateProgram from './create';
    import EditProgram from './edit';

    export default {
        components: {
            Grid,
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
                fields: [],
                request: new Request({}),
                params: {
                    ascending: true,
                    sortBy: 'name',
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
