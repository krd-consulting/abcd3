<template>
    <list>
        <template slot="header-text">Programs</template>
        <list-item
            v-for="(program, index) in programs"
            :key="index"
            :to="`/programs/${program.id}`">
            {{ program.name }}
        </list-item>
        <template slot="pagination" slot-scope="pagination">
            <span class="tw-pl-4 tw-py-4 tw-text-sm tw-font-semibold tw-text-grey-dark">Showing all {{ total }} programs</span>
        </template>
    </list>
</template>
<script>
    import Request from '../api/ProgramRequest';

    import List from '../components/AppList';
    import ListItem from '../components/AppListItem';

    export default {
        components: {
            List,
            ListItem
        },

        data() {
            return {
                programs: [],
                request: new Request({}),
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
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
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve().then(response => {
                    this.programs = response;
                    this.total = response.length;
                });
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
