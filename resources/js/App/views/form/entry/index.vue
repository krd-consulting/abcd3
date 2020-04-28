<template>
    <list
        :items="entries"
        :page.sync="params.page"
        :per-page="params.perPage"
        :search-terms.sync="params.search"
        :loading="false"
        :has-list-columns="false"
        @page-change="retrieveEntries()"
        :total="total">
        <template slot="header-text">{{ form.name }}</template>

        <template slot="list">
            <list-item
                v-for="(entry, index) in entries"
                :key="index"
                :to="entry.target.path"
                class="tw-cursor-pointer">
                <template v-if="targetName == 'Record'">
                    <template slot="image">
                        <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="entry.target" :fields="entry.target.fields"/>
                    </template>

                    <slot name="list-item-primary-data" :item="entry">
                        <primary-data class="tw-font-semibold" :record="entry.target" :fields="entry.target.fields"/>
                    </slot>

                    <template slot="secondary-data">
                        <secondary-data class="tw-text-xs tw-text-gray-600" :record="entry.target" :fields="entry.target.fields"/>
                    </template>
                </template>

                <template v-if="targetName != 'Record'">
                    <slot name="list-item-primary-data" :item="entry">
                        {{ entry.target.name }}
                    </slot>

                    <template slot="secondary-data">
                        {{ entry.target.secondary_data }}
                    </template>
                </template>

                <template slot="bellows">
                    <dl>
                        <div v-for="(field, index) in fields" :key="index">
                            <text-field
                                v-if="field.type == 'text'"
                                v-model="entry[field.column_name]"
                                :field="field"
                                class="tw-grid tw-grid-cols-3 tw-p-4 even:tw-bg-gray-100">
                            </text-field>

                            <file-field
                                v-else-if="field.type == 'file'"
                                v-model="entry[field.column_name]"
                                :field="field"
                                class="tw-grid tw-grid-cols-3 tw-p-4 even:tw-bg-gray-100">
                            </file-field>

                            <div v-else class="tw-grid tw-grid-cols-3 tw-p-4 even:tw-bg-gray-100">
                                <dd class="tw-text-gray-600">{{ field.title }}</dd>
                                <dt>{{ entry[field.column_name] }}</dt>
                            </div>
                        </div>
                    </dl>
                </template>
            </list-item>
        </template>
    </list>
</template>
<script>
    import Request from '@/api/FormRequest';
    import EntryRequest from '@/api/FormEntryRequest';
    import FieldRequest from '@/api/FormFieldRequest';

    import List from '@/App/components/resourceList';
    import ListItem from '@/components/listItemAccordion';
    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import TextField from '@/components/formEntryDataFields/text';
    import FileField from '@/components/formEntryDataFields/file';

    import { targetTypes } from '@/helpers';

    export default {
        components: {
            List,
            ListItem,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            TextField,
            FileField
        },

        data() {
            return {
                create: {
                    active: false
                },
                form: [],
                entries: [],
                fields: [],
                targetType: '',
                request: new Request({}),
                entriesRequest: new EntryRequest({}),
                fieldRequest: new FieldRequest({}),
                params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 5,
                    search: ''
                },
                total: 0,
            }
        },

        computed: {
            listComponent() {
                return this.targetName.toLowerCase() + '-list';
            },

            targetName() {
                return targetTypes[this.targetType];
            }
        },

        methods: {
            retrieve() {
                this.request.show(this.$route.params.form).then(response => {
                    this.form = response.data;
                });
            },

            retrieveEntries() {
                this.entriesRequest.setFields({
                    params: {...this.params}
                });

                this.entriesRequest.retrieve(this.$route.params.form).then(response => {
                    this.entries = response.data;
                    this.total = response.meta.total;
                    this.targetType = response.target_type;
                });
            },

            retrieveFields() {
                this.fieldRequest.retrieve(this.$route.params.form).then(response => {
                    this.fields = response.data;
                    this.total = response.total;
                });
            },
        },

        created() {
            this.retrieve();
            this.retrieveEntries();
            this.retrieveFields();
        }
    }
</script>
