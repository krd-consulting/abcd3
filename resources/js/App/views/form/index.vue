<template>
    <div>
        <list
            :items="forms"
            :page.sync="params.page"
            :per-page="params.perPage"
            :has-add="total > 0"
            has-delete
            :has-list-columns="false"
            :hasSearch="false"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">Forms</template>
            <template slot="options-add-text">Create Form</template>

            <template slot="empty-placeholder-add-button">
                <a href="/forms/create">
                    <base-button
                        class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue-500 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-white tw-border-none">
                        <base-icon class="tw-text-sm tw-align-middle tw-mr-1">
                            <slot name="empty-placeholder-add-button-icon">add</slot>
                        </base-icon>
                        <span class="tw-text-xs tw-align-middle">
                            <slot name="empty-placeholder-add-button-text">Create Form</slot>
                        </span>
                    </base-button>
                </a>
            </template>

            <template v-slot:list-item-primary-data="{ item:form }">
                    {{ form.name }}
            </template>

            <template v-slot:list-item-secondary-data="{ item:form }">
                    <base-icon class="tw-text-xs align-middle">people</base-icon>{{ form.team.name }}
            </template>
        </list>
    </div>
</template>
<script>
        //import Request from '@/api/FormRequest';

        import List from '@/App/components/resourceList';

        export default {
                components: {
                    List,
                },

                data() {
                    return {
                        forms: [],
                        //request: new Request({}),
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

                },

                created() {
                }
        }
</script>
