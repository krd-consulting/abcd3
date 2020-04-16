<template>
     <div>
        <el-card>
            <el-header class="tw-text-center tw-mb-12">
                <h1 class="tw-text-4xl">{{ form.name }}</h1>
                <p>{{ form.description }}</p>
                <el-divider></el-divider>
            </el-header>
            
            <el-main>
                <el-row class="tw-mb-4">
                    <el-col :span="6">
                        <label v-if="form.target != null" for="name" class="tw-block tw-text-right tw-mr-1"> {{ form.target.name }} Name</label>
                        <label v-else for="name" class="tw-block tw-text-right tw-mr-1"> {{ targetName }} Name</label>
                    </el-col>
                    <el-col :span="8">
                        <base-select
                            v-if="targetName != 'Record'"
                            v-model="entryData.target_id"
                            @click.native="retrieveFormTargetItems"
                            filterable
                            remote
                            :remote-method="retrieveFormTargetItems"
                            name="type"
                            placeholder=" "
                            @change="request.errors.clear('team_id')">
                            <el-option
                                v-for="(item, index) in targetItems"
                                :key="index"
                                :label="item.name"
                                :value="item.id">
                                {{ item.name }}
                            </el-option>
                        </base-select>

                        <base-select
                            v-else
                            v-model="entryData.target_id"
                            filterable
                            remote
                            :remote-method="retrieveFormTargetItems"
                            name="type"
                            placeholder=" "
                            @change="request.errors.clear('team_id')">
                            <el-option
                                v-for="(item, index) in targetItems"
                                :key="index"
                                :label="getPrimaryData(item, item.fields)"
                                :value="item.id">
                                <record-primary-data :record="item" :fields="item.fields" />
                            </el-option>
                        </base-select>
                        
                    </el-col>
                </el-row>
                    
                <el-row class="tw-mb-4">
                    <el-col :span="6">
                        <label for="teamSelect" class="tw-block tw-text-right tw-mr-1">Team</label>
                    </el-col>
                    <el-col :span="8">
                        <base-select
                            v-model="teams.team_id"
                            filterable
                            remote
                            :remote-method="retrieveTeams"
                            name="type"
                            placeholder=" "
                            @change="request.errors.clear('team_id')">
                            <el-option
                                v-for="(team, index) in teams"
                                :key="index"
                                :label="team.name"
                                :value="team.id">
                                {{ team.name }}
                            </el-option>
                        </base-select>
                    </el-col>
                </el-row>

                <el-row v-if="form.type === 'pre-post'" class="tw-mb-4">
                    <el-col :span="6">
                        <label for="pre-post" class="tw-block tw-text-right tw-mr-1">Completed for</label>
                    </el-col>
                    <el-col :span="6">
                        <el-select id="pre-post" v-model="value" placeholder=" ">
                            <el-option v-for="select in prePost" 
                                :key="select.value"
                                :label="select.value" 
                                :value="select.value">
                            </el-option>
                        </el-select>
                    </el-col>
                </el-row>

                <el-row class="tw-mb-4">
                    <el-col :span="6">
                        <label for="formDate" class="tw-block tw-text-right tw-mr-1">Date Completed</label>
                    </el-col>
                    <el-col :span="6">
                        <el-date-picker 
                            id="formDate" 
                            v-model="entryData.completed_at" 
                            type="date" 
                            placeholder=" " 
                            :picker-options="pickerOptions">
                        </el-date-picker>
                    </el-col>
                    
                </el-row>
                
                <div class="tw-block tw-mr-1" v-for="field in form.field_layout" :key="field.id">
                    <component
                        class="tw-my-8"
                        v-model="entryData[field.column_name]"
                        :field="field"
                        :is="field.type"
                        :key="field.id">
                    </component>
                    
                </div>

                <br>
                <br>

                    <div class="tw-relative tw-text-center tw-mt-12">
                        <el-button type="primary" class="tw-w-48" @click="submit">Submit</el-button>
                    </div>
            </el-main>
        </el-card> 
    </div>
</template>
<script>
    import MatrixField from '@/components/formFields/matrix.vue'
    import RadioField from '@/components/formFields/radio.vue'
    import TextField from '@/components/formFields/textField.vue'
    import TextBox from '@/components/formFields/textBox.vue'
    import NumberField from '@/components/formFields/numeric.vue'
    import DropdownField from '@/components/formFields/dropdown.vue'
    import CheckBoxField from '@/components/formFields/checkbox.vue'
    import DateField from '@/components/formFields/datePicker.vue'
    import TimeField from '@/components/formFields/timePicker.vue'
    import FileField from '@/components/formFields/upload.vue'
    import SectionDivider from '@/components/formFields/sectionDivider.vue'

    import Request from '@/api/FormRequest';
    import EntryRequest from '@/api/FormEntryRequest';
    import TeamRequest from '@/api/TeamRequest';

    import RecordPrimaryData from '@/App/components/record/primaryData';

    export default {
        data() {
            return {
                request: new Request({}),
                entryRequest: new EntryRequest({}),
                teamRequest: new TeamRequest(),
                form: {
                    target_type: {
                        name: null
                    },
                    target: {
                        name: null
                    }
                },
                teamRequestParams: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                teams: [],
                targetRequest: {},
                targetParams: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                recordParams: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                targetItems: [],
                entryData: {},
                value: '',
                inputName: '',
                dateCompleted: '',
                prePost: [
                    {id: 0, value: 'Pre-test'},
                    {id: 1, value: 'Intermittent'},
                    {id: 2, value: 'Post-test'},
                ],
                pickerOptions: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    }
                }

            }
        },

        computed: {
            targetName() {
                const targetTypes = {
                    Programs: 'Program',
                    Groups: 'Group',
                    Records: 'Record',
                };

                return targetTypes[this.form.target_type.name];
            }
        },

        components: {
            MatrixField,
            RadioField,
            TextField,
            TextBox,
            NumberField,
            DropdownField,
            CheckBoxField,
            DateField,
            TimeField,
            FileField,
            SectionDivider,
            RecordPrimaryData
        },

        methods: {
            getPrimaryData(record, fields) {
                let remainingFields = [];

                if('first_name' in fields)
                    remainingFields.push('first_name');

                if('last_name' in fields)
                    remainingFields.push('last_name');

                if('business_name' in fields)
                    remainingFields.push('business_name');

                let data = '';

                remainingFields.forEach(field => {
                    data += record[field] + ' ';
                });

                return data.trim();
            },

            retrieveTeams(keywords) {
                this.teamRequestParams.search = keywords;

                this.teamRequest.setFields({
                    params: {...this.teamRequestParams }
                });

                let getTeams = this.teamRequest.retrieve();

                getTeams.then(response => {
                    this.teams = response.data;
                });

                return getTeams;
            },

            retrieve(form = this.$route.params.form) {
                return this.request.show(form).then((response) => {
                    this.form = response.data;
                });
            },

            // initializeEntryData(fields) {
            //     fields.foreach((field) => {
            //         if(field.type == 'Check')
            //     })
            // },

            retrieveFormTargetItems(keywords, callback) {
                import(`@/api/${this.targetName}Request`)
                    .then((foo) => {
                        this.targetRequest = new foo.default({});

                        this.targetParams.search = keywords;
                        let params = this.targetParams;

                        if(this.targetName == 'Record') {
                            this.recordParams.search = keywords;
                            params = this.recordParams;
                        }

                        this.targetRequest.setFields({
                            params
                        });

                        const args = this.form.target != null 
                        ? this.form.target.name 
                        : null;

                        this.targetRequest.retrieve(args).then((response) => {
                            this.targetItems = response.data;
                        });
    
                    }
                );
            },
            
            submit() {
                this.entryRequest = new EntryRequest(this.entryData);

                this.entryRequest.store(this.$route.params.form)
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: 'Form Entry Submitted!'
                        });

                        window.location.reload();
                    })
                    .catch((error) => {
                        this.$message({
                            type: 'error',
                            message: 'You may have entered incorrect data.'
                        });
                    });
            }
        },

        created() {
            this.retrieve();
            this.retrieveTeams();
        }
    }
</script>
