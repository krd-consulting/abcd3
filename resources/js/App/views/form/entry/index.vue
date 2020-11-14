<template>
    <div>
      <grid
        :title="form.name"
        :items="teams"
        :fields="fields"
        :page.sync="params.page"
        :sortBy.sync="params.sortBy"
        :ascending.sync="params.ascending"
        :per-page="params.perPage"
        :search-terms.sync="params.search"
        @params-change="retrieveTeams();"
        :has-collapsible-rows="true"
        @open-collapsible-row="retrieveEntries"
        :total="total"
      >
        <template v-slot:extra-columns-header>
          <th>Required</th>
        </template>

        <template v-slot:extra-columns-data>
          <td>&nbsp;</td>
        </template>

        <template v-slot:collapsible-row>
          <td colspan="3" v-for="entry in entries" :key="entry.id">
            {{ entry }}
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
                targetType: '',
                request: new Request({}),
                entriesRequest: new EntryRequest({}),
                fieldRequest: new FieldRequest({}),
                params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 5,
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
                });
            },

            retrieveFields() {
                this.fieldRequest.retrieve(this.$route.params.form).then(response => {
                    // this.fields = response.data;
                    // this.total = response.total;
                });
            },
        },

        created() {
            this.retrieve();
            this.retrieveTeams();
            this.retrieveEntries();
            this.retrieveFields();
        }
    }
</script>
