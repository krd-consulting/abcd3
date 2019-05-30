<template>
	<div>
		<create-status 
            :active.sync="create.active"
            @save="retrieve()"/>

        <edit-status 
            :active.sync="create.active"
            @update="retrieve()"/>

		<list
            :items="statuses"
            :page.sync="params.page"
            :per-page="params.perPage"
            has-add
            has-delete
            :has-list-columns="false"
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
        </list>
	</div>
</template>
<script>
	import Request from '../api/ClientStatusRequest';

	import List from '../components/AppResourceList';

	import CreateStatus from '../views/PreferencesProgramClientStatusCreate';
    import EditStatus from '../views/PreferencesProgramClientStatusEdit';

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
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0,
			}
		},

		methods: {
			retrieve() {
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

            confirmDelete(status) {
                this.$confirm('Are you sure you want to delete this program?', 'Delete Program', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteStatus(status)
                        .then(() => {
                            this.retrieve();

                            this.$message({
                                type: 'success',
                                message: 'Program was deleted.'
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
                let request = new Request();

                return request.destroy(status);
            },
		},

		created() {
			this.retrieve();
		}
	}
</script>