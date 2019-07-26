<template>
    <div>
        <edit-form
            :active.sync="edit.active"
            :form-id="edit.form"
            @update="retrieve()"/>

        <list
            :items="forms"
            :page.sync="params.page"
            :per-page="params.perPage"
            :has-add="total > 0"
            has-delete
            :has-list-columns="false"
            :hasSearch="false"
            @edit="editForm"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">Forms</template>
            <template slot="options-add">
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

            <template v-slot:options-edit-button="{ item:form }">
                <router-link :to="`${form.path}/new`"
                    class="tw-py-2 tw-px-2 tw-text-gray-600 hover:tw-text-gray-800 tw-bg-transparent tw-border-none"
                    @click="$emit('edit', item[resourceIdentifier])">
                    <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">
                        add
                    </base-icon>
                    <span class="tw-text-xs tw-align-middle">
                        Enter Data
                    </span>
                </router-link>
            </template>

            <template v-slot:options-remove-button="{ item:form }">
                <el-dropdown :key="form.id" placement="bottom-end">
                    <span class="tw-text-gray-600 tw-text-xs tw-align-middle">
                        <base-icon class="tw-text-gray-600 tw-text-xs tw-mr-1 tw-align-middle">
                            edit
                        </base-icon>
                        Edit Form
                    </span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item @click.native="editForm(form.id)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">
                                edit
                            </base-icon>
                            <span class="tw-text-xs tw-align-middle">
                                Edit Form Information
                            </span>
                        </el-dropdown-item>
                        <el-dropdown-item>
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">
                                edit
                            </base-icon>
                            <span class="tw-text-xs tw-align-middle">
                                Edit Form Fields
                            </span>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>

                <!-- <base-button
                    class="tw-py-2 tw-px-2 tw-text-gray-600 hover:tw-text-gray-800 tw-bg-transparent tw-border-none"
                    @click="$emit('edit', item[resourceIdentifier])">
                </base-button> -->
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '@/api/FormRequest';

    import List from '@/App/components/resourceList';
    import EditForm from './edit';

    export default {
        components: {
            List,
            EditForm
        },

        data() {
            return {
                edit: {
                    active: false,
                    form: ''
                },
                forms: [],
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
            editForm(form) {
                this.edit.form = form;

                this.edit.active = true;
            },

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve().then(response => {
                    this.forms = response.data;
                    this.total = response.data.length;
                });
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
