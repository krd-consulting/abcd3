<template>
    <div>
      <grid
        :title="`${form.name} Entries`"
        rowTitle="Entries"
        :items="entries"
        :fields="fields"
        :page.sync="params.page"
        :sortBy.sync="params.sortBy"
        :ascending.sync="params.ascending"
        :per-page="params.perPage"
        :search-terms.sync="params.search"
        @params-change="retrieveEntries"
        :has-pagination="true"
        :has-edit="false"
        :total="total"
      >
      
      </grid>
    </div>
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
    import Grid from "@/components/extendable/grid";

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
            FileField,
            Grid
        },

        data() {
            return {
                create: {
                    active: false
                },
                form: [],
                entries: [],
                teams: [],
                fields: [],
                teamFields: [],
                targetType: '',
                request: new Request({}),
                entriesRequest: new EntryRequest({}),
                fieldRequest: new FieldRequest({}),
                params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    search: '',
                },
                total: 0,
                totalTeams: 0
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

            retrieveTeams() {
              this.entriesRequest.teams(this.$route.params.form).then(response => {
                    this.teams = response.data;
                    this.fields = response.fields;
                    this.totalTeams = this.teams.length;
                });
            },

            retrieveEntries(team) {
                this.entriesRequest.setFields({
                    params: {
                      ...this.params,
                      team: team
                    }
                });

                this.entriesRequest.retrieve(this.$route.params.form).then(response => {
                    this.entries = response.data;
                    this.total = response.meta.total;
                    this.targetType = response.target_type;
                    this.fields = response.fields;
                });
            },

            handlePageChange(page) {
              this.params.page = page;
            },
        },

        created() {
            this.retrieve();
            this.retrieveEntries();
        }
    }
</script>
<style scoped>
  td >>> .el-pagination .btn-next,
  td >>> .el-pagination .btn-prev {
    @apply tw-bg-indigo-darker tw-text-white;
  }
  td >>> .el-pagination button:disabled  {
    @apply tw-bg-indigo-darker tw-text-white;
  }
  td >>> .el-pagination .el-pager .number{
    @apply tw-text-gray-400;
  }
  td >>> .el-pagination .el-pager .number.active {
    @apply tw-text-white;
  }
  td >>> .el-pagination .el-icon-arrow-right,
  td >>> .el-pagination .el-icon-arrow-left {
    @apply tw-text-white tw-text-3xl tw-font-light;
  }
  td >>> .el-pagination button:disabled .el-icon-arrow-right,
  td >>> .el-pagination button:disabled .el-icon-arrow-left {
    @apply tw-text-gray-400;
  }
</style>
