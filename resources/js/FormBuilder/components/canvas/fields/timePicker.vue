<template>
    <div id="timePicker">
        <el-collapse>
            <span class="inputLabel">{{ myOptions.title }}</span><br>
            <el-collapse-item>
                <template slot="title">
                    <el-time-picker
                        arrow-control
                        v-model="timeSelection"
                        :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
                        placeholder="Pick a time">
                    </el-time-picker>
                </template>
                <el-form label-position="top" ref="myOptions" :model="myOptions" @submit.native.prevent>
                    <el-form-item label="Field Label">
                        <el-input v-model="myOptions.title"></el-input>
                    </el-form-item>
                    <el-form-item label="This Field is">
                        <el-switch v-model="myOptions.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </el-form-item>
                </el-form>
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
            myOptions: []
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.myOptions = _.clone(this.options)
    },
}
</script>

<style>

</style>
