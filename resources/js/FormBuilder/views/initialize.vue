<template>
    <base-dialog 
        v-bind="$attrs" 
        :close-on-click-modal="false"
        :show-close="false"
        :close-on-press-escape="false"
        :visible="active" 
        @close="close" 
        @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Create Form
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Form Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="formData['name']"
                            name="name"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('name')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('name')[0]" class="tw-text-xs tw-text-red-500"></span>
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
                            v-model="formData['description']"
                            name="description"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('description')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('description')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Form Type
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.type"
                            name="type"
                            placeholder="Select Form Type"
                            @change="request.errors.clear('type')">
                            <el-option
                                v-for="(type, index) in types"
                                :key="index"
                                :label="type"
                                :value="type">
                                {{ type }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('type')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('type')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        This form is about
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.target"
                            name="target"
                            placeholder="Select Resource"
                            @change="request.errors.clear('target.type');
                                request.errors.clear('target.type_id')">
                            <el-option
                                v-for="(type, index) in targetTypes"
                                :key="index"
                                :label="type.name"
                                :value="type.target">
                                {{ type.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Who can see this form?
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.target"
                            name="target"
                            placeholder="Select Resource"
                            @change="request.errors.clear('target.type');
                                request.errors.clear('target.type_id')">
                            <el-option
                                v-for="(type, index) in targetTypes"
                                :key="index"
                                :label="type.name"
                                :value="type.target">
                                {{ type.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <a href="javascript:history.back()" class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue tw-text-xs">
                Nevermind
            </a>
            <base-button 
                class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none"
                @click="submit">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/FormRequest';

    export default {
        inheritAttrs: false,

        props: {
            active: Boolean,
        },

        data() {
            return {
                request: new Request(),
                formData: {
                    name: '',
                    description: '',
                    target: '',
                    type: ''
                },
                targetTypes: [],
                types: []
            }
        },

        computed: {
            
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.formData = {
                    name: '',
                    description: '',
                    target: '',
                    type: ''
                };
            },

            open() {
                this.load();
            },

            load() {
                let request = new Request({});

                request.create().then((response) => {
                    this.targetTypes = response.data.target_types;
                    this.types = response.data.types;
                });
            },

            submit() {
                this.request = new Request(this.formData);

                this.request.validate()
                    .then((response) => {
                        this.$emit('save', response.data);
                        this.close();
                    })
                    .catch((error) => {
                        //
                    });
            }
        },

        created() {
            this.load();
        }
    }
</script>
