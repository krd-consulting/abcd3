<template>
    <div id="timePicker">
        <label for="time-picker" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
        <el-time-picker
            arrow-control
            v-model="timeSelection"
            :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
            placeholder="Pick a time">
        </el-time-picker>

        <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="inputFieldData.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Description</label>
                                <el-input id="description" v-model="inputFieldData.description"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-row>
                    </div>

                </div>

                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            timeSelection: '',
            inputFieldData: [],
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
    },
}
</script>

<style>

</style>
