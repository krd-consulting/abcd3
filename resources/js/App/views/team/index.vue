<template>
    <div>
        <create-team
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-team
            :active.sync="edit.active"
            :team-id="edit.team"
            @update="retrieve()"/>

        <grid
            :title="'Teams'"
            :items="teams"
            :fields="fields"
            :page.sync="params.page"
            :sortBy.sync="params.sortBy"
            :ascending.sync="params.ascending"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :loading="loading"
            has-add
            has-delete
            has-disable
            @add="createTeam"
            @edit="editTeam"
            @delete="confirmDelete($event)"
            @disable="confirmDisable($event)"
            @enable="confirmEnable($event)"
            @params-change="retrieve();"
            @show-inactive="toggleInactive"
            :total="total"
            >
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
    import Request from '@/api/TeamRequest';

    import methods from './methods';

    import grid from '@/components/extendable/grid';
    import createTeam from './create';
    import editTeam from './edit';

    export default {
        components: {
            grid,
            createTeam,
            editTeam
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    group: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                    }
                },
                teams: [],
                fields: [],
                request: new Request({}),
                loading: true,
                params: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 5,
                    search: '',
                    active: true
                },
                showInactive: false,
                total: 0,
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
