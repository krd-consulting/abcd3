<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit Client Status
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Status Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="newClientStatusData['name']"
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
                            v-model="newClientStatusData['description']"
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
    import Request from '@/api/ClientStatusRequest';

    export default {
        props: {
            active: Boolean,
            clientStatusId: Number | String
        },

        data() {
            return {
                request: new Request(),
                newClientStatusData: {
                    name: '',
                    description: '',
                },
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.newClientStatusData = {
                    name: '',
                    description: '',
                };
            },

            open() {
                this.retrieve();
            },
            initializeWithData(data) {
                this.newClientStatusData.id = data.id;
                this.newClientStatusData.name = data.name;
                this.newClientStatusData.description = data.description;
            },
            retrieve() {
                let request = new Request({});
                request.edit(this.clientStatusId).then((response) => {
                    this.initializeWithData(response.data);
                });
            },

            store(status) {
                this.request = new Request(this.newClientStatusData);

                this.request.update(this.newClientStatusData.id)
                    .then((response) => {
                        this.$emit('update');
                        this.$message({
                            type: 'success',
                            message: 'Client Status updated successfully!'
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
