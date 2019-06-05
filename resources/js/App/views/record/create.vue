<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Add {{ recordType.name }}
        </div>
        <form>
            <div v-for="(field, fieldName) in fields" class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        {{ fieldName.replace('_', ' ') }}
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-if="fieldName == 'birth_date'"
                            v-model="recordData[field]"
                            :name="fieldName"
                            type="date"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                        <base-input
                            v-else
                            v-model="recordData[field]"
                            :name="fieldName"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has(field)" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get(field)[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Team
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="recordData.team_id"
                            name="team"
                            placeholder="Select Team"
                            @change="request.errors.clear('team')">
                            <el-option
                                v-for="team in teams"
                                :key="team.id"
                                :label="team.name"
                                :value="team.id">
                                {{ team.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('team_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('team_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none" @click="store">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/RecordRequest';

    export default {
        props: {
            active: Boolean,
            recordType: String|Object,
            fields: Array|Object
        },

        data() {
            return {
                request: new Request(),
                recordData: {
                    field_1_value: '',
                    field_2_value: '',
                    field_3_value: '',
                    record_type_id: '',
                    team_id: ''
                },
                teams: []
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.programData = {
                    field_1_value: '',
                    field_2_value: '',
                    field_3_value: '',
                    record_type_id: '',
                    team_id: ''
                };
            },

            open() {
                this.load();
            },

            load() {
                let request = new Request({});

                request.create(this.recordType.slug).then((response) => {
                    this.teams = response;
                });
            },

            store() {
                this.recordData.record_type_id = this.recordType.id;

                this.request = new Request(this.recordData);

                this.request.store(this.recordType.slug)
                    .then((response) => {
                        this.$emit('save');
                        this.$message({
                            type: 'success',
                            message: 'Record created successfully!'
                        });
                        this.close()
                    })
                    .catch((error) => {
                        //
                    });
            }
        },

        created() {

        }
    }
</script>
