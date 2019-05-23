<template>
	<el-tabs @tab-click="handleClick">
		<el-tab-pane name="summary" key="summary">
            <template slot="label">
                Summary
            </template>
        </el-tab-pane>
        <el-tab-pane v-if="resourceName != 'program' && resourceName != 'group'" name="programs" key="programs">
            <template slot="label">
                <base-icon class="tw-align-middle tw-text-sm">assignment</base-icon>
                Programs
            </template>
        </el-tab-pane>
        <el-tab-pane v-if="resourceName != 'group'" name="groups" key="groups">
            <template slot="label">
                <base-icon class="tw-align-middle tw-text-sm">people</base-icon>
                Groups
            </template>
        </el-tab-pane>
        <el-tab-pane v-for="tab in recordTypes" :name="`records_${tab.slug}`" :key="`records_${tab.slug}`">
            <template slot="label">
                <base-icon class="tw-align-middle tw-text-sm">assignment</base-icon>
                {{ tab.name }}
            </template>
        </el-tab-pane>
        <el-tab-pane v-if="resourceName != 'team' && resourceName != 'group' && resourceName != 'program'" name="teams" key="teams">
            <template slot="label">
                <base-icon class="tw-align-middle tw-text-sm">people</base-icon>
                Teams
            </template>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
	export default {
		props: {
			recordTypes: Array | Object
		},

		computed: {
			prefix() {
				return this.resourceName + '_profile_';
			},

			resourceName() {
				return _.split(this.$route.name, '_', 1)[0];
			}
		},

		methods: {
			handleClick(tab, event) {
                if(tab.name.includes('records_'))
                    return this.handleRecordTabClick(tab.name.replace('records_', ''));

                this.$router.push({ name: `${this.prefix}${tab.name}`});
            },

            handleRecordTabClick(recordType) {
                this.$router.push({ name: `${this.prefix}records`, params: {recordType}});
            },
		},
	}
</script>