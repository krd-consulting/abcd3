<template>
    <div>
      <grid
        :title="`${form.name} Entries`"
        rowTitle="Entries"
        :items="teams"
        :fields="fields"
        :sortBy.sync="params.sortBy"
        :ascending.sync="params.ascending"
        :search-terms.sync="params.search"
        @params-change="retrieveTeams();"
        :has-pagination="false"
        :has-edit="false"
        :has-collapsible-rows="true"
        @open-collapsible-row="retrieveEntries"
        :total="totalTeams"
      >
        <template v-slot:extra-columns-header>
          <th>Required</th>
          <th>Frequency</th>
          <th>History</th>
        </template>

        <template v-slot:extra-columns-data="{ item }">
          <td>
            <base-checkbox :checked="item.required_by_form == 1"></base-checkbox>
          </td>
          <td>
            <base-select></base-select>
          </td>
          <td>
            <span class="tw-font-semibold">{{item.entries_history.count}} entries</span>
            <br>
            <span>Last Entry: {{item.entries_history.last_entry_created_at}}</span>
          </td>
        </template>

        <template v-slot:collapsible-row="{ item }">
          <td class="tw-p-0 tw-border-b" colspan="100%">
            <table class="tw-w-full">
              <thead>
                <tr class="tw-py-4 tw-bg-indigo-darker">
                  <td>&nbsp;</td>
                  <td colspan="2">
                    <base-input
                      placeholder="Search..."
                      class="tw-ml-auto tw-w-56"
                      suffix-icon="fas fa-search"
                    ></base-input>
                  </td>
                  <td class="tw-text-right">
                    <base-pagination
                      class="pagination-white"
                      :current-page="params.page"
                      @current-change="handlePageChange($event); retrieveEntries(item.id)"
                      :page-size="params.perPage"
                      :total="total"
                    >
                    </base-pagination>
                  </td>
                </tr>
                <tr>
                  <td class="tw-bg-indigo-lightest">&nbsp;</td>
                  <th class="tw-text-lg tw-text-black tw-text-semibold tw-normal-case tw-border-r" v-for="entry in entries" :key="entry.id">
                    <div>
                      {{ entry.target.display_value }}
                    </div>
                    <div class="tw-text-sm tw-text-gray-dark">
                      <span>Entered by {{ entry.creator.name }}</span>
                      <br>
                      <span>On {{ entry.created_at }}</span>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="field in teamFields" :key="field.key">
                  <td class="tw-bg-indigo-lightest tw-font-semibold">{{ field.name }}</td>
                  <td class="tw-border-r" v-for="entry in entries" :key="entry.id">
                    <!-- TODO: morph form entry fields -->
                    <!-- case for file field -->
                    <div v-if="field.type === 'file'">
                      <a v-for="attachment in (entry[field.key].raw_value)" :href="`/${attachment}`" target="_blank">
                        {{ attachment.split('/')[1] }}
                      </a>
                    </div>
                    <div v-else>
                      {{ entry[field.key].value }}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </template>
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
                    perPage: 3,
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
                    this.teamFields = response.fields;
                });
            },

            handlePageChange(page) {
              this.params.page = page;
            },
        },

        created() {
            this.retrieve();
            this.retrieveTeams();
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
