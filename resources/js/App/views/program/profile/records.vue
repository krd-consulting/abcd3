<template>
    <div>
        <add-record
            :active.sync="add.active"
            :program-id="$route.params.program"
            :record-type="recordType.slug"
            @close="retrieve()">
        </add-record>
        <edit-program-record
            :active.sync="edit.active"
            :record-id="edit.record"
            :program-id="$route.params.program"
            :record-type="recordType.slug"
            @update="retrieve($route.params.program, selectedRecordType.slug)"/>

        <div class="tw-grid tw-grid-cols-4 tw-mb-4">
          <el-radio-group v-model="selectedRecordIdentity" @change="handleRecordIdentityChange">
            <el-radio-button v-for="identity in recordIdentities" :key="identity.name" :value="identity" :label="identity.name"></el-radio-button>
          </el-radio-group>

          <base-select v-model="selectedRecordType" class="tw-col-start-3">
            <el-option
              v-for="recordType in availableRecordTypes"
              :key="recordType.slug"
              :label="recordType.name"
              :value="recordType"
              @change="params.page = 1">
            </el-option>
          </base-select>

          <div class="tw-col-start-4 tw-text-right">
            <base-button @click="addRecord">Link {{ selectedRecordType.name }}</base-button>
          </div>
        </div>

        <grid
          :title="selectedRecordType.name"
          :items="records"
          :fields="gridFields"
          :page.sync="params.page"
          :sortBy.sync="params.sortBy"
          :ascending.sync="params.ascending"
          :per-page="params.perPage"
          :search-terms.sync="params.search"
          :loading="false"
          @edit="editRecord"
          @params-change="retrieve($route.params.program, selectedRecordType.slug);"
          :total="total"
        >
          <template v-slot:full_name="{ value, data }">
            <router-link
              :to="`${data.links.to}`"
              class="tw-font-bold tw-text-black hover:tw-text-black"
            >{{ value }}</router-link>
          </template>
          <template v-slot:name="{ value, data }">
            <router-link
              :to="`${data.links.to}`"
              class="tw-font-bold tw-text-blue hover:tw-text-black"
            >{{ value }}</router-link>
          </template>
          <template v-slot:name="{ value, data }">
            <router-link
              :to="`${data.links.to}`"
              class="tw-font-bold tw-text-black hover:tw-text-black"
            >{{ value }}</router-link>
          </template>
          <!--<template v-slot:status="{ value, data }">
            {{ data.pivot.latest_status.status.name }}
          </template>
          <template v-slot:status_notes="{ value, data }">
            {{ data.pivot.latest_status.notes }}
          </template>-->
        </grid>
    </div>
</template>
<script>
    import List from '@/App/components/resourceList';
    import Grid from "@/components/extendable/grid";

    import RecordsRequest from '@/api/ProgramRecordsRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    import AddRecord from './addRecord';
    import EditProgramRecord from '@/App/views/programRecord/edit';

    export default {
        components: {
            List,
            Grid,
            AddRecord,
            EditProgramRecord
        },

        data() {
            return {
                add: {
                    active: false
                },
                edit: {
                    active: false,
                    record: {

                    }
                },
                request: new RecordsRequest({}),
                records: [],
                recordTypes: [],
                recordIdentities: [],
                selectedRecordType: {
                  name: '',
                  slug: ''
                },
                selectedRecordIdentity: {
                  name: ''
                },
                fields: [],
                recordType: {
                    name: '',
                    identity: {
                        name: ''
                    }
                },
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
            }
        },

        computed: {
            availableRecordTypes() {
              let recordTypes = [];

              recordTypes = this.recordTypes.filter(recordType => {
                return recordType.identity == this.selectedRecordIdentity
              });

              return recordTypes;
            },

            gridFields() {
              const fields = [
                ...Object.values(this.fields),
              ];

              return fields;
            },
        },

        watch: {
          selectedRecordType() {
            this.retrieve(this.$route.params.program, this.selectedRecordType.slug);
          }
        },

        methods: {
            remove(record) {
                return this.request.destroy(
                    this.$route.params.program,
                    this.$route.params.recordType,
                    record
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(recordType, record) {
                this.$confirm('Are you sure you want to remove this record?', 'Remove Record', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(record)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Record was removed.'
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

            retrieve(program = this.$route.params.program, recordType = this.$route.params.recordType) {
                if(recordType == null)
                  return;

                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(program, recordType).then((response) => {
                    this.records = response.data;
                    this.recordType = response.record_type;
                    this.fields = response.fields;
                    this.total = response.meta.total;
                });
            },

            retrieveRecordTypes() {
              const request = new RecordTypeRequest();

              return request.retrieve().then((response) => {
                this.recordTypes = response.data;
              });
            },

            retrieveRecordIdentities() {
              const response = {
                data: [
                  { name: 'Client' },
                  { name: 'Staff' },
                  { name: 'Volunteer' },
                  { name: 'Other' },
                ]
              };

              this.recordIdentities = response.data;

              this.selectedRecordIdentity = response.data[0].name;

              const promise = new Promise( (resolve, reject) => {
                  resolve(response);
              });

              return promise;
            },

            handleRecordIdentityChange() {
              this.retrieveRecordTypes();
              this.selectedRecordType = this.availableRecordTypes[0];
              this.params.page = 1;
            },

            addRecord() {
                this.add.active = true;
            },

            editRecord(record) {
                this.edit.record = record;

                this.edit.active = true;
            },
        },

        created() {
            this.retrieveRecordTypes().then(response => {
              this.retrieveRecordIdentities().then(response => {
                this.selectedRecordType = this.availableRecordTypes[0];
              });
            });
        },
    }
</script>
