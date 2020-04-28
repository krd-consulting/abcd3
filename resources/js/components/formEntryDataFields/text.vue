<template>
    <div v-if="!loading">
        <dd class="tw-text-gray-600">{{ field.title }}</dd>
        <dt v-if="targetName == 'Records'">
            <list-item class="tw-cursor-pointer tw-border-none" :to="targetItem.path">
                <template slot="image">
                    <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="targetItem" :fields="targetItem.fields"/>
                </template>

                <slot name="list-item-primary-data" :item="targetItem">
                    <primary-data class="tw-font-semibold" :record="targetItem" :fields="targetItem.fields"/>
                </slot>

                <template slot="secondary-data">
                    <secondary-data class="tw-text-xs tw-text-gray-600" :record="targetItem" :fields="targetItem.fields"/>
                </template>
            </list-item>
        </dt>
        <dt v-else-if="targetName == 'Programs'">
            <list-item class="tw-cursor-pointer tw-border-none" :to="targetItem.path">
                <slot name="list-item-primary-data" :item="targetItem">
                    {{ targetItem.name }}
                </slot>

                <template slot="secondary-data-text">
                    {{ targetItem.team.name }}
                </template>
            </list-item>
        </dt>
        <dt v-else-if="targetName == 'Groups'">
            <list-item class="tw-cursor-pointer tw-border-none">
                <slot name="list-item-primary-data" :item="targetItem">
                    {{ targetItem.name }}
                </slot>

                <template slot="secondary-data-text">
                    {{ targetItem.program.name }}
                </template>
            </list-item>
        </dt>
        <dt v-else>{{ value }}</dt>
    </div>
</template>
<script>
    import TargetTypeRequest from '@/api/FormFieldTargetTypeRequest';

    import ProgramRequest from '@/api/ProgramRequest';
    import GroupRequest from '@/api/GroupRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';
    import RecordRequest from '@/api/RecordRequest';

    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import ListItem from '@/components/listItem';

    export default {
        components: {
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            ListItem
        },

        props: {
            field: {
                type: Array | Object,
                default: {}
            },
            value: '',
        },

        data() {
            return {
                targetTypeRequest: new TargetTypeRequest({}),
                targetType: {
                    name: ''
                },
                targetRequest: {},
                requests: {
                    Programs: ProgramRequest,
                    Groups: GroupRequest,
                    Records: RecordRequest,
                },
                targetItem: [],
                loading: true
            }
        },

        computed: {
            targetName() {
                return this.targetType.name;
            }
        },

        methods: {
            getTargetType() {
                if(this.field.reference_target_type_id == null) {
                    this.loading = false;
                    return;
                }

                this.targetTypeRequest.show(this.field.reference_target_type_id).then((response) => {
                    this.targetType = response.data;

                    if(this.targetName == 'Form Fields') {
                        this.loading = false;
                        return;
                    }

                    this.retrieve();
                });
            },

            retrieve() {
                this.targetRequest = new this.requests[this.targetName]({});

                if(this.targetName == 'Records') {

                    const request = new RecordTypeRequest({});
                    request.show(this.field.reference_target_id).then((response) => {
                        this.targetRequest.show(response.data.slug, this.value).then((response) => {
                            this.targetItem = response.data;
                            this.loading = false;
                        });
                    });

                    return;
                }

                this.targetRequest.show(this.value).then((response) => {
                    this.targetItem = response.data;
                    this.loading = false;
                });
            },

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
        },

        created() {
            this.getTargetType();
        }
    }
</script>
