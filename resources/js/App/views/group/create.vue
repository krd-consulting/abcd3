<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Create Group
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Group Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="groupData['name']"
                            name="name"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('name')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('name')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Description
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="groupData['description']"
                            name="description"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('description')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('description')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Program
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="groupData.program_id"
                            :value="groupData.program_id"
                            name="program"
                            placeholder="Select Program"
                            @change="request.errors.clear('program')"
                            :disabled="isProgramGiven">
                            <el-option
                                v-for="program in programs"
                                :key="program.id"
                                :label="program.name"
                                :value="`${program.id}`">
                                {{ program.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('program_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('program_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none" @click="store">
                <span class="tw-text-xs tw-align-middle">OK</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/GroupRequest';

    export default {
        props: {
            active: Boolean,
            programId: Number|String,
            teamId: {
                type: Number | String,
                default: null
            }
        },

        data() {
            return {
                request: new Request(),
                groupData: {
                    name: '',
                    description: '',
                    program: ''
                },
                programs: []
            }
        },

        computed: {
            isProgramGiven() {
                return typeof this.programId !== 'undefined';
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.groupData = {
                    name: '',
                    description: '',
                    program_id: ''
                };
            },

            open() {
                if(this.isProgramGiven) {
                    this.groupData.program_id = this.programId;
                }

                this.load();
            },

            load() {
                let request = new Request({});

                request.create(this.teamId).then((response) => {
                    this.programs = response;
                });
            },

            store() {
                this.request = new Request(this.groupData);

                this.request.store()
                    .then((response) => {
                        this.$emit('save');
                        this.$message({
                            type: 'success',
                            message: 'Group created successfully!'
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
