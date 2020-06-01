<template>
    <div>
        <edit-record
            :active.sync="edit.active"
            :record-id="edit.record"
            @update="retrieve"/>

        <resource-profile
            :resource="record"
            :fields="fields"
            @edit="editRecord(record.id)"
            @disable="confirmDisable(record.type.slug, record.id)"
            @delete="confirmDelete(record.id)"
            @enable="confirmEnable(record.type.slug, record.id)">
            <template v-slot:main-information-container>
                <div>
                    <div class="tw-inline-block tw-align-middle">
                        <h2>
                            <primary-data class="tw-block tw-font-semibold tw-text-xl" :record="record" />
                        </h2>
                        <p>
                            <secondary-data class="tw-text-sm" :record="record" :fields="fields"></secondary-data>
                        </p>
                    </div>
                </div>
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ record.type.name }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import RecordRequest from '@/api/RecordRequest';

    import methods from '../methods';

    import ResourceProfile from '@/App/components/resourceProfile';
    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import EditRecord from '../edit';

    export default {

        components: {
            ResourceProfile,
            EditRecord,
            ProfilePicture,
            PrimaryData,
            SecondaryData
        },

        data() {
            return {
                edit: {
                    active: false,
                    record: ''
                },
                fields: [],
                record: {
                    type: {
                        name: '',
                        identity: {
                            name: ''
                        },
                        slug: ''
                    }
                },
                request: new RecordRequest({}),
            }
        },

        methods: {
            ...methods,

            retrieve: methods.profile
        },

        created() {
            this.retrieve();
        }

    }
</script>
