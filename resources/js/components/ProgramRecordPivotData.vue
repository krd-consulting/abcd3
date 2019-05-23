<template>
	<component :is="appropriateComponent" :record="record"/>
</template>
<script>
	export default {
		props: {
			recordType: Array | Object,
			record: Array | Object
		},

		components: {
			clientData: () => import('./ProgramRecordPivotDataClient'),
			staffData: () => import('./ProgramRecordPivotDataStaff'),
			volunteerData: () => import('./ProgramRecordPivotDataVolunteer'),
			externalData: () => import('./ProgramRecordPivotDataExternal'),
		},

		computed: {
			appropriateComponent() {
				return this.recordType.identity.toLowerCase() + '-data';
			}
		}
	}
</script>