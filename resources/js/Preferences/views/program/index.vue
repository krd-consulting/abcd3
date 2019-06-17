<template>
	<div>
		<create-status 
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-status 
            :active.sync="edit.active"
            @update="retrieve()"/>

		<list
            :items="statuses"
            :page.sync="params.page"
            :per-page="params.perPage"
            :has-list-columns="false"
            has-add
            has-delete
            :hasSearch="false"
            @add="createStatus"
            @delete="confirmDelete"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">Client Statuses</template>
            <template slot="options-add-text">Create Client Status</template>

            <template v-slot:list-item-primary-data="{ item:status }">
                {{ status.name }}
            </template>

            <template v-slot:option-remove-button="{ item:status }">
                <base-button
                    class="tw-py-2 tw-px-2 tw-text-gray-500 hover:tw-text-red-500 hover:tw-bg-transparent tw-border-none"
                    @click="toggleDisable(status)">
                    <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">{{ disableIcon(status.disabled_at) }}</base-icon>
                    <span class="tw-text-xs tw-align-middle">{{ disableText(status.disabled_at) }}</span>
                </base-button>
            </template>

            <template slot="footer-options">
                <div class="tw-py-2 tw-px-4">
                    <base-switch v-model="params.disabled" @change="retrieve()"/> Only Show Disabled Statuses
                </div>
            </template>
        </list>
	</div>
</template>
<script>
	import Request from '@/api/ClientStatusRequest';

	import List from '@/App/components/resourceList';

	import CreateStatus from './clientStatus/create';
    import EditStatus from './clientStatus/edit';

	export default {
		components: {
			List,
			CreateStatus,
            EditStatus
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
				request: new Request({}),
				statuses: [],
				params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 5,
                    disabled: false
                },
                total: 0,
			}
		},

		methods: {
			retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

				this.request.retrieve().then(response => {
					this.statuses = response.data;
					this.total = response.data.length;
				})
			},

			createStatus() {
                this.create.active = true;
            },

            editStatus(status) {
                this.edit.status = status;

                this.edit.active = true;
            },

            confirmDisable(status) {
                this.$confirm('Are you sure you want to disable this status?', 'Disable Status', {
                    confirmButtonText: 'Disable',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.disableStatus(status)
                        .then(() => {
                            this.retrieve();

                            this.$message({
                                type: 'success',
                                message: 'Status was disabled.'
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

            disableStatus(status) {
                const request = new Request({
                    id: status,
                    enabled: false
                });

                return request.update(status);
            },

            confirmEnable(status) {
                this.enableStatus(status)
                    .then(() => {
                        this.retrieve();

                        this.$message({
                            type: 'success',
                            message: 'Status was enabled.'
                        });
                    })
                    .catch((error) => {
                        this.$message({
                            type: 'error',
                            message: error.message
                        });
                    });
            },

            enableStatus(status) {
                const request = new Request({
                    id: status,
                    enabled: true
                });

                return request.update(status);
            },

            confirmDelete(status) {
                this.$confirm('Are you sure you want to delete this status?', 'Delete Status', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteStatus(status)
                        .then(() => {
                            this.retrieve();

                            this.$message({
                                type: 'success',
                                message: 'Status was deleted.'
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

            deleteStatus(status) {
                const request = new Request();

                return request.destroy(status);
            },

            toggleDisable(status) {
                status.disabled_at == null ?  this.confirmDisable(status.id) : this.confirmEnable(status.id);
            },

            disableIcon(disabled) {
                return disabled == null ?  'close' : 'check';
            },

            disableText(disabled) {
                return disabled == null ?  'Disable' : 'Enable';
            }
		},

		created() {
			this.retrieve();
		}
	}
</script>