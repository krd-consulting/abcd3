<template>
    <div>
        <create-group
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-group
            :active.sync="edit.active"
            :group-id="edit.group"
            @update="retrieve()"/>

        <list
            :items="groups"
            :page.sync="params.page"
            :per-page="params.perPage"
            has-add
            has-delete
            has-disable
            :has-list-columns="false"
            :hasSearch="false"
            @add="createGroup"
            @edit="editGroup"
            @delete="confirmDelete"
            @disable="confirmDisable"
            @enable="confirmEnable"
            @page-change="retrieve()"
            @show-inactive="toggleInactive"
            :total="total">
            <template slot="header-text">Groups</template>
            <template slot="options-add-text">Create Group</template>

            <template v-slot:list-item-primary-data="{ item:group }">
                {{ group.name }}
            </template>

             <template v-slot:list-item-secondary-data="{ item:group }">
                <base-icon class="tw-text-xs align-middle">assignment</base-icon>{{ group.program.name }}
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '@/api/GroupRequest';

    import methods from './methods';

    import List from '@/App/components/resourceList';
    import CreateGroup from './create';
    import EditGroup from './edit';

    export default {
        components: {
            List,
            CreateGroup,
            EditGroup
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
                groups: [],
                request: new Request({}),
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
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
