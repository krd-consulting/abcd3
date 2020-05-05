<template>
    <div>
        <create-record
            :active.sync="create.active"
            :fields="fields"
            :record-type="type"
            @save="retrieve()"/>

        <edit-record
            :active.sync="edit.active"
            :record-id="edit.record"
            @update="retrieve()"/>


        <list
            :items="records"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :loading="loading"
            has-add
            has-delete
            has-disable
            :has-list-columns="false"
            @add="createRecord"
            @edit="editRecord"
            @delete="confirmDelete(type.slug, $event)"
            @disable="confirmDisable(type.slug, $event)"
            @enable="confirmEnable(type.slug, $event)"
            @page-change="retrieve();"
            @show-inactive="toggleInactive"
            :total="total">
            <template slot="header-text">{{ type.name }}</template>
            <template slot="options-add-text">Add {{ type.name }}</template>

            <template v-slot:list-item-image="{ item:record }">
                <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="record" :fields="fields"/>
            </template>

            <template v-slot:list-item-primary-data="{ item:record }">
                <primary-data class="tw-font-semibold" :record="record" :fields="fields"/>
            </template>

             <template v-slot:list-item-secondary-data="{ item:record }">
                <secondary-data class="tw-text-xs tw-text-gray-600" :record="record" :fields="fields"/>
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '@/api/RecordRequest';

    import methods from './methods';

    import List from '@/App/components/resourceList';

    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import CreateRecord from './create';
    import EditRecord from './edit';

    export default {

        components: {
            List,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            CreateRecord,
            EditRecord
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    record: ''
                },
                fields: [],
                records: [],
                request: new Request({}),
                loading: false,
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: '',
                    active: true
                },
                inactivePage: 0,
                total: 0,
                type: {
                    name: ''
                }
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
        },

        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.recordType);
            next();
        }

    }
</script>
