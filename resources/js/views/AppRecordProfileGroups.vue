<template>
    <div>
        <add-group 
            :active.sync="add.active" @close="retrieve"/>
        <div class="tw-mb-2">
            <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4" v-if="groups.length == 0">
                <div>
                    <base-button
                        class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                        @click="addGroup">
                        <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                        <span class="tw-text-xs tw-align-middle">Add to a Group</span>
                    </base-button>
                </div>
            </div>
            <div v-if="groups.length > 0"
                class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
                <div class="tw-flex tw-w-4/5">
                    <div class="tw-w-1/4 tw-m-0">
                        <span class="tw-tracking-wide">Group</span>
                    </div>
                </div>
            </div>
            <list-item
                v-if="groups.length > 0"
                :to="`/groups/${group.id}`"
                :key="group.id"
                v-for="group in groups"
                class="group tw-pl-4 tw-py-4">
                <span class="hover:tw-text-blue">{{ group.name }}</span>
                <template v-slot:secondary-data>

                </template>
                <template v-slot:options-container>
                    <div class="tw-w-1/5 tw-text-right">
                        <div class="tw-px-4">
                            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-grey-darkest tw-border-none">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">edit</base-icon>
                                <span class="tw-text-xs tw-align-middle">Edit</span>
                            </base-button>
                            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none" @click="confirm(record.id)">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">delete</base-icon>
                                <span class="tw-text-xs tw-align-middle">Delete</span>
                            </base-button>
                        </div>
                    </div>
                </template>
            </list-item>
        </div>
       <div class="tw-px-4 tw-pb-4">
            <base-button
                v-if="groups.length > 0"
                class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                @click="addGroup">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Add to a Group</span>
            </base-button>
        </div>
    </div>
</template>
<script>
    import GroupsRequest from '../api/RecordGroupsRequest';
    import ListItem from '../components/AppListItem';

    import AddGroup from './AppRecordProfileAddGroup';

    export default {
        components: {
            AddGroup,
            ListItem,
        },

        data() {
            return {
                add: {
                    active: false
                },
                request: new GroupsRequest({}),
                groups: []
            }
        },

        methods: {
            remove(id) {
                return this.request.destroy(
                    this.$route.params.program,
                    this.$route.params.recordType,
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirm(id) {
                this.$confirm('Are you sure you want to remove this record?', 'Remove Record', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Record was removed.'
                            });
                        })
                        .catch((error) => {
                            this.$message({
                                type: 'error',
                                message: error.message
                            });
                        });
                })
            },

            retrieve() {
                this.request.retrieve(this.$route.params.recordType, this.$route.params.record).then((response) => {
                    this.groups = response.data;
                });
            },

            addGroup() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
