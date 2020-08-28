<template>
    <div>
        <edit-group
            :active.sync="edit.active"
            :group-id="edit.group.id"
            @update="retrieve"/>

        <resource-profile
            :extra-information-path="`/programs/${group.program.id}`"
            :record-types="recordTypes"
            :resource="group"
            @edit="editGroup(group)"
            @delete="confirmDelete(group.id)"
            @disable="confirmDisable(group.id)"
            @enable="confirmEnable(group.id)">
            <template v-slot:header>
                {{ group.name }}
            </template>
            <template v-slot:subheader>
                {{ group.description }}
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ group.program.name }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import GroupRequest from '@/api/GroupRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    import methods from '../methods';

    import ResourceProfile from '@/App/components/resourceProfile';
    import EditGroup from '../edit';

    export default {
        components: {
            ResourceProfile,
            EditGroup
        },

        data() {
            return {
                group: {
                    name: '',
                    program: {
                        name: ''
                    }
                },
                edit: {
                    active: false,
                    group: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                        team_id: ''
                    }
                },
                recordTypes: [],
                request: new GroupRequest({}),
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        methods: {
            handleClick(tab, event) {
                if(tab.name.includes('group_profile_records_'))
                    return this.handleRecordTabClick(tab.name.replace('group_profile_records_', ''));

                this.$router.push({ name: `${tab.name}`});
            },

            handleRecordTabClick(recordType) {
                this.$router.push({ name: 'group_profile_records', params:  {recordType}});
            },

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
            this.retrieve();
            this.retrieveRecordTypes();
        }

    }
</script>
