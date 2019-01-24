<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-top tw-justify-between tw-p-4">
            <div>
                <div class="tw-inline-block tw-align-middle">
                    <profile-picture class="tw-mr-2 tw-w-16 tw-h-16 tw-text-xl" :record="record" :fields="fields" />
                </div>
                <div class="tw-inline-block tw-align-middle">
                    <primary-data class="tw-mb-2 tw-block tw-font-bold tw-text-xl" :record="record" :fields="fields"/>
                    <secondary-data class="tw-text-sm" :record="record" :fields="fields"></secondary-data>
                </div>
            </div>
            <div class="tw-text-right">
                <div>
                    <base-button class="tw-py-2 tw-px-2 tw-bg-green-lightest tw-text-green-dark tw-border-none">
                        <base-icon class="tw-text-xs tw-align-top">edit</base-icon>

                    </base-button>
                    <base-button class="tw-py-2 tw-px-2 tw-bg-red-lightest tw-text-red-dark tw-border-none">
                        <base-icon class="tw-text-xs tw-align-top">delete</base-icon>

                    </base-button>
                </div>
            </div>
        </div>
        <div class="tw-pb-4 tw-px-4">
            <el-tabs :value="$route.name" @tab-click="handleClick">
                <el-tab-pane name="record_profile_summary" label="Summary">
                </el-tab-pane>
                <el-tab-pane name="record_profile_programs">
                    <template slot="label">
                        <base-icon class="tw-align-middle tw-text-sm">assignment</base-icon>
                        Programs
                    </template>
                </el-tab-pane>
            </el-tabs>
            <router-view/>
        </div>
    </div>
</template>
<script>
    import RecordRequest from '../api/RecordRequest';

    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {

        components: {
            ProfilePicture,
            PrimaryData,
            SecondaryData
        },

        data() {
            return {
                fields: [],
                record: {},
                request: new RecordRequest({}),
            }
        },

        methods: {
            handleClick(tab, event) {
                this.$router.push({ name: `${tab.name}`});
            },

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(this.$route.params.recordType, this.$route.params.record).then((response) => {


                    this.record = response.data;
                    this.fields = response.data.fields;
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
