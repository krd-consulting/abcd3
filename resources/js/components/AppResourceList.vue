<template>
    <div>
        <list
            :has-header="true"
            :page.sync="params.page"
            @page-change="retrieve"
            :per-page="params.perPage"
            :total="total">
            <template slot="header-text">{{ type.name }}</template>
            <template slot="options">
                <div class="tw-flex">
                    <search v-model="params.search" @input="search"/>
                    <base-button class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" @click="createRecord">
                        <base-icon class="tw-text-base tw-font-bold tw-align-middle">add</base-icon>
                        <span class="tw-align-middle">Add {{type.name}}</span>
                    </base-button>
                </div>
            </template>
        </list>
    </div>
</template>
<script>
    import lodash from 'lodash';

    import List from '../components/AppList';
    import Search from '../components/AppSearch';

    export default {

        components: {
            List,
            Search
        },

        data() {
            return {
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
            }
        },

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 10;
                this.retrieve();
            }
        },

        methods: {
            retrieve() {

            },
        },

        created() {
            this.retrieve();
        },

    }
</script>
