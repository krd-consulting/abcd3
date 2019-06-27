<template>
    <div id="Textbox">
        <el-row>
            <el-col :span="10">
                <label for="textBox" class="inputLabel">{{ field.label }}</label>
                <sup>{{ field.description }}</sup>
                <el-input id="textBox" 
                    v-if="field.settings.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="field.settings.max" 
                    show-word-limit 
                    placeholder="Your text here" 
                    v-model="value">
                </el-input>
                <el-input id="textBox" 
                    v-else type="textarea" 
                    :rows="2" 
                    placeholder="Your text here" 
                    v-model="value">
                </el-input>
            </el-col>
        </el-row>
        <el-collapse>
            <el-collapse-item name="1">
                <template slot="title">
                    <el-button icon="el-icon-edit">Field field</el-button>
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
                                <el-input id="description" v-model="field.description"></el-input>
                            </el-col>
                        </el-row>

                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" 
                                v-model="field.required" 
                                active-text="Required" 
                                inactive-text="Optional">
                            </el-switch>
                        </el-row>
                    </div>

                    <div class="tw-float-right tw-mx-20 tw-my-6">
                        <label for="charLimit">Set Character Limit</label><br>
                        <el-switch id="charLimit" 
                            v-model="field.settings.isLimited" 
                            inactive-text="No Limit"
                            active-text="Set Character Limit">
                        </el-switch><br>
                        <el-input-number class="tw-my-6" 
                            :disabled="!field.settings.isLimited" 
                            v-model="field.settings.max" 
                            :step="5" :min="0" 
                            step-strictly>
                        </el-input-number>

                    </div>
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    name: 'Textbox',
    data() {
        return {
            value: '',
            field: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Text Area',
            }
        }
    },
    created() {
        this.field = _.clone(this.fieldData)
    },
}
</script>

<style>

</style>
