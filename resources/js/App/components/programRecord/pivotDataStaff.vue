<template>
	<div class="tw-flex tw-flex-grow">
	    <div class="tw-flex-1">
	        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500">
	            <span>{{ casesCount }}</span>
	        </div>
	        <div>
	        	<add-case
	        		:record-id="record.id"
            		:active.sync="addCaseModal.active"
            		@close="retrieve()">
            			<template slot="title">
            				Caseload of <primary-data :record="record" :fields="record.fields"/>
            			</template>
            	</add-case>
	            <base-button
	                class="tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none"
	                @click="addCase">
	                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
	                <span class="tw-text-xs tw-align-middle">Manage Cases</span>
	            </base-button>
	        </div>
	    </div>
	    <div class="tw-flex-1">
	        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500">
	            <span>{{ groupsCount }}</span>
	        </div>
	        <div>
	        	<add-group
	        		:record-id="record.id"
            		:active.sync="addGroupModal.active" @close="retrieve()"/>
	            <base-button
	                class="tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none"
	                @click="addGroup">
	                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
	                <span class="tw-text-xs tw-align-middle">Manage Groups</span>
	            </base-button>
	        </div>
	    </div>
	    <div class="tw-flex-1">
	        <span>{{ record.enrolled_at }}</span>
	    </div>
	</div>
</template>
<script>
	import AddGroup from '@/App/views/record/profile/addGroup';
	import AddCase from '@/App/views/record/profile/addCase';
	import PrimaryData from '@/App/components/record/primaryData';

	export default {
		components: {
			AddGroup,
			AddCase,
			PrimaryData
		},

		props: {
			record: Array | Object,
            program: Array | Object
		},

		computed: {
			casesCount() {
				let noun = 'case';

				if(this.record.cases_count != 1)
					noun = 'cases';

				return `${this.record.cases_count} ${noun}`;
			},

			groupsCount() {
				let noun = 'group';

				if(this.record.groups_count != 1)
					noun = 'groups';

				return `${this.record.groups_count} ${noun}`;
			}
		},

		data() {
			return {
				addGroupModal: {
	                active: false
	            },

	            addCaseModal: {
	            	active: false
	            }
			}
		},

		methods: {
			addGroup() {
                this.addGroupModal.active = true;
            },

            addCase() {
                this.addCaseModal.active = true;
            }
		}
	}
</script>
