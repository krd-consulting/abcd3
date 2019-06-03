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
			clientData: () => import('./pivotDataClient'),
			staffData: () => import('./pivotDataStaff'),
			volunteerData: () => import('./pivotDataVolunteer'),
			externalData: () => import('./pivotDataExternal'),
		},

		computed: {
			appropriateComponent() {
				return this.recordType.identity.toLowerCase() + '-data';
			}
		}
	}
</script>