<template>
    <div>
        <edit-program
            :active.sync="edit.active"
            :program-id="program.id"
            @update="retrieve"/>

        <page-title :title="title" class="tw-px-8"></page-title>
        <div class="tw-flex">
          <info-card
            icon="fas fa-calendar-plus"
            title="3 orders"
            description="Lorem ipsum dolor sit amet"
            text-class="tw-text-orange-base"
            bg-class="tw-bg-orange-lightest"
          ></info-card>
          <info-card
            icon="fas fa-copy"
            title="2 forms"
            description="Lorem ipsum dolor sit amet"
            text-class="tw-text-indigo-base"
            bg-class="tw-bg-indigo-lightest"
            class="tw-ml-5"
          ></info-card>
          <info-card
            icon="fas fa-link"
            title="15 links"
            description="Lorem ipsum dolor sit amet"
            text-class="tw-text-red-base"
            bg-class="tw-bg-red-lightest"
            class="tw-ml-5"
          ></info-card>
        </div>
        <profile-tabs>
          <el-tab-pane label="Records" name="program_profile_records"></el-tab-pane>
          <el-tab-pane label="Forms" name="program_profile_forms"></el-tab-pane>
          <el-tab-pane label="Jobs" name="program_profile_jobs"></el-tab-pane>
        </profile-tabs>
        <div class="tw-p-4">
          <router-view></router-view>
        </div>

        <!--<resource-profile
            :extra-information-path="`/teams/${program.team.id}`"
            :record-types="recordTypes"
            :resource="program"
            @edit="editProgram(program)"
            @delete="confirmDelete(program.id)"
            @disable="confirmDisable(program.id)"
            @enable="confirmEnable(program.id)">
            <template v-slot:header>
                {{ program.name }}
            </template>
            <template v-slot:subheader>
                {{ program.description }}
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ program.team.name }}
            </template>
        </resource-profile>-->
    </div>
</template>
<script>
    import methods from '../methods';
    import ProgramRequest from '@/api/ProgramRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    import ProfileTabs from "@/App/components/profileTabs";

    import ResourceProfile from '@/App/components/resourceProfile';
    import EditProgram from '../edit';

    export default {
        components: {
            ProfileTabs,
            ResourceProfile,
            EditProgram
        },

        data() {
            return {
                program: {
                    name: '',
                    team: {
                        name: ''
                    }
                },
                edit: {
                    active: false,
                },
                recordTypes: [],
                request: new ProgramRequest({}),
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

        computed: {
          title() {
            return this.program.name;
          }
        },

        methods: {
            retrieveRecordTypes() {
                const request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response.data;
                });
            },

            ...methods,

            retrieve: methods.profile
        },

        created() {
            this.retrieve(this.$route.params.program);
            this.retrieveRecordTypes();
        },


        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.program);
            this.retrieveRecordTypes();
            next();
        }

    }
</script>
