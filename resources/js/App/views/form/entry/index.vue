<template>
    <div>
      <grid
        :title="`${form.name} Entries`"
        rowTitle="Entries"
        :items="entries"
        :fields="fields"
        :sortBy.sync="params.sortBy"
        :ascending.sync="params.ascending"
        :search-terms.sync="params.search"
        @params-change="retrieveEntries();"
        :has-pagination="true"
        :has-edit="false"
        :has-add="true"
        :total="total"
      >
      <template v-slot:entries-th="{ field }">
        <th
            :key="field.slug"
            class="tw-rounded-tr-lg"
            :colspan="entries.length"
          >
            <div class="tw-flex tw-justify-between tw-items-center">
              <span>
                {{ field.name }}
              </span>
              <base-pagination
                  class="pagination-white"
                  :current-page="params.page"
                  @current-change="handlePageChange($event); retrieveEntries();"
                  :page-size="params.perPage"
                  :total="total"
                ></base-pagination>
            </div>
        </th>
      </template>
      <template v-slot:table-body="{ items }">
      <tbody>
        <tr>
            <td class="tw-bg-indigo-lightest">&nbsp;</td>
            <td class="tw-text-lg tw-text-black tw-text-semibold tw-normal-case tw-border-r" v-for="entry in entries" :key="entry.id">
              <div>
                {{ entry.fields.target.value }}
              </div>
              <div class="tw-text-sm tw-text-gray-dark">
                <span>Entered by {{ entry.creator.name }}</span>
                <br>
                <span>On {{ entry.created_at }}</span>
              </div>
            </td>
          </tr>
          <tr v-for="field in formFields" :key="field.key">
            <td class="tw-bg-indigo-lightest tw-font-semibold">{{ field.name }}</td>
            <td class="tw-border-r" v-for="entry in entries" :key="entry.id">
              <!-- TODO: morph form entry fields -->
              <!-- case for file field -->
              <div v-if="field.type === 'file'">
                <a v-for="attachment in (entry.form_fields[field.key].value)" :href="`/${attachment}`" target="_blank">
                  {{ attachment.split('/')[1] }}
                </a>
              </div>
              <div v-else-if="!!entry.form_fields[field.key].path">
                <a :href="entry.form_fields[field.key].path" target="_blank">{{ entry.form_fields[field.key].value }}</a>
              </div>
              <div v-else>
                {{ entry.form_fields[field.key].value }}
              </div>
            </td>
          </tr>
        </tbody>
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
                fields: [
                  {
                    slug: 'form_fields',
                    key: 'form_fields',
                    name: 'Form Fields'
                  },
                  {
                    slug: 'entries',
                    key: 'entries',
                    name: 'Entries'
                  }
                ],
                formFields: [],
                teamFields: [],
                targetType: '',
                request: new Request({}),
                entriesRequest: new EntryRequest({}),
                fieldRequest: new FieldRequest({}),
                params: {
                    ascending: false,
                    sortBy: 'id',
                    page: 1,
                    perPage: 3,
                    search: '',
                },
                total: 0
            }
        },

        computed: {
            listComponent() {
                return this.targetName.toLowerCase() + '-list';
            },

            targetName() {
                return targetTypes[this.targetType];
            },

            title() {
              return `${this.form.name} Entries`;
            }
        },

        methods: {
            retrieve() {
                this.request.show(this.$route.params.form).then(response => {
                    this.form = response.data;
                });
            },

            retrieveEntries() {
                this.entriesRequest.setFields({
                    params: {
                      ...this.params
                    }
                });

                this.entriesRequest.retrieve(this.$route.params.form).then(response => {
                    this.entries = response.data;
                    this.total = response.meta.total;
                    this.targetType = response.target_type;
                    this.formFields = response.form_fields;
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
