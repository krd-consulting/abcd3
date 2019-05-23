<template>
    <div>
        <list
            :has-header="hasListHeader"
            :page="page"
            @page-change="handlePageChange"
            :per-page="perPage"
            :total="total">

            <template slot="empty-placeholder">
                <slot name="empty-placeholder">
                    <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4">
                        <div v-if="total == 0 && searchTerms !== ''" class="tw-my-2 tw-text-grey-dark">
                            <slot name="empty-placeholder-text">
                                No items matched your query.
                            </slot>
                        </div>
                        <div>
                            <slot name="empty-placeholder-add-button">
                                <base-button
                                    class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                                    @click="$emit('add')">
                                    <base-icon class="tw-text-sm tw-align-middle tw-mr-1">
                                        <slot name="empty-placeholder-add-button-icon">add</slot>
                                    </base-icon>
                                    <span class="tw-text-xs tw-align-middle">
                                        <slot name="empty-placeholder-add-button-text">Add</slot>
                                    </span>
                                </base-button>
                            </slot>
                        </div>
                    </div>
                </slot>
            </template>

            <template slot="header-text">
                <slot name="header-text">Title</slot>
            </template>

            <template slot="options" v-if="hasOptions">
                <div class="tw-flex tw-justify-end" v-show="showListHeaderOptions">
                    <slot v-if="hasSearch" name="options-search">
                        <search v-model="search" @input="handleSearch(search)"/>
                    </slot>
                    <slot v-if="hasAdd" name="options-add">
                            <base-button 
                                class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" 
                                @click="$emit('add')">
                            <base-icon class="tw-text-base tw-font-bold tw-align-middle">
                                <slot name="options-add-icon">
                                    add
                                </slot>
                            </base-icon>
                            <span class="tw-align-middle">
                                <slot name="options-add-text">Add Resource</slot>
                            </span>
                        </base-button>
                    </slot>
                </div>
            </template>

            <slot v-if="hasListColumns" name="list-columns">
                <div class="tw-flex tw-pt-6 tw-pb-2 tw-px-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
                    <div class="tw-w-1/6" :column="primaryDataColumn">
                        <slot name="list-column-primary-data">{{ primaryDataColumn }}</slot>   
                    </div>
                    <div class="tw-flex tw-w-5/6">
                        <div class="tw-flex tw-flex-grow">
                            <span 
                                v-for="column in tertiaryColumns" 
                                :column="column"
                                class="tw-flex-1">
                                {{ column }}
                            </span>
                        </div>
                        <div class="tw-w-1/6">
                        </div>
                    </div>
                </div>
            </slot>

            <slot name="list" :items="items">
                <list-item 
                    v-for="(item, index) in items" 
                    :key="index" class="tw-py-4 tw-px-4"
                    :to="item.path">

                    <template slot="image">
                        <slot name="list-item-image" :item="item"></slot>
                    </template>

                    <slot name="list-item-primary-data" :item="item">
                        {{ item }}
                    </slot>

                    <template slot="secondary-data">
                        <span class="tw-text-sm tw-text-grey">
                            <slot name="list-item-secondary-data" :item="item"></slot>
                        </span>
                    </template>

                    <template slot="tertiary-data">
                        <slot name="list-item-tertiary-data-container" :item="item">
                            <div class="tw-flex tw-flex-grow">
                                <slot name="list-item-tertiary-data" :item="item"></slot>          
                            </div>      
                        </slot>      
                    </template>

                    <template slot="options">
                        <base-button v-if="hasEdit" 
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none" 
                            @click="$emit('edit', item[resourceIdentifier])">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">edit</base-icon>
                            <span class="tw-text-xs tw-align-middle">Edit</span>
                        </base-button>
                        <base-button
                            v-if="hasRemove"
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none"
                            @click="$emit('remove', item[resourceIdentifier])">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                            <span class="tw-text-xs tw-align-middle">Remove</span>
                        </base-button>
                        <base-button
                            v-if="hasDelete"
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none"
                            @click="$emit('delete', item[resourceIdentifier])">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">delete</base-icon>
                            <span class="tw-text-xs tw-align-middle">Delete</span>
                        </base-button>
                    </template>
                </list-item>
            </slot>

            <template slot="footer-options">
                <base-button
                    v-if="hasManage && total > 0"
                    class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                    @click="$emit('manage')">
                    <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                    <span class="tw-text-xs tw-align-middle">
                        <slot name="footer-options-manage-text">Manage Resources</slot>
                    </span>
                </base-button>
            </template>

        </list>
    </div>
</template>
<script>
    import lodash from 'lodash';

    import List from '../components/AppList';
    import ListItem from '../components/AppListItem';
    import Search from '../components/AppSearch';

    export default {

        components: {
            List,
            ListItem,
            Search
        },

        props: {
            resourceIdentifier: {
                type: String,
                default: 'id'
            },

            searchTerms: {
                type: String,
                default: ''
            },

            page: {
                type: Number | String,
                default: 1
            },

            perPage: {
                type: Number | String,
                default: 10
            },

            total: {
                type: Number | String,
                default: 0
            },

            items: Array | Object,

            hasAdd: {
                type: Boolean,
                default: false
            },

            hasEdit: {
                type: Boolean,
                default: true
            },

            hasDelete: {
                type: Boolean,
                default: false
            },

            hasListHeader: {
                type: Boolean,
                default: true
            },

            hasListColumns: {
                type: Boolean,
                default: true
            },

            hasRemove: {
                type: Boolean,
                default: false
            },

            hasManage: {
                type: Boolean,
                default: false
            },

            hasOptions: {
                type: Boolean,
                default: true
            },

            hasSearch: {
                type: Boolean,
                default: true
            },

            primaryDataColumn: {
                type: String | Object,
                default: ''
            },

            tertiaryColumns: {
                type: Array | Object,
                default: () => { return [] }
            }

        },

        computed: {
            showListHeaderOptions() {
                if(!this.hasListHeader)
                    return false;

                if(this.searchTerms.length == 0 && this.total == 0) 
                    return false;

                return true;
            }
        },

        data() {
            return {
                search: '',
                optionsWidth: ''
            }
        },

        methods: {
            handlePageChange(page) {
                this.$emit('update:page', page);
                this.$emit('page-change', page);
            },

            handleSearch(search) {
                this.$emit('update:search-terms', search);
                this.$emit('search', search);
            }
        },

    }
</script>
