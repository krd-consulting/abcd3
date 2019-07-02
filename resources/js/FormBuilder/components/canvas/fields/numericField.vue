<template>
    <div id="numeric">
        <label for="numfield" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.fieldDescription }}</sup>
        <el-input-number id="numfield" v-if="field.settings.isLimited" 
            v-model="field.settings.defaultNum">
        </el-input-number>
        <el-input-number id="numfield" 
            v-else 
            v-model="num">
        </el-input-number>

        <el-collapse>
            <el-collapse-item name="1">
                <template slot="title">
                      <el-button icon="el-icon-edit">Field Options</el-button>  
                </template>
                    <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="field.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Description</label>
                                <el-input id="description" v-model="field.fieldDescription"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" v-model="field.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-row>
                    </div>

                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <label for="numLimit"></label>
                        <el-switch id="numLimit" v-model="field.settings.isLimited" 
                            inactive-text="No Default" 
                            active-text="Set Default">
                        </el-switch><br>
                        <el-input-number class="tw-my-6" :disabled="!field.settings.isLimited" 
                            v-model="field.settings.defaultNum">
                        </el-input-number>
                    </div>

                <!-- <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-col :span="6">
                                <el-input v-model="settings.title"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="settings.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Set Default Value">
                            <el-switch v-model="settings.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch><br>
                            <el-input-number :disabled="!settings.isLimited" v-model="settings.defaultNum"></el-input-number>
                        </el-form-item>
                    </el-form>
                </div> -->
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    name: 'numeric',
    data() {
        return {
            num: 0,
            field: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
    },
}
</script>

<style>

</style>
