<template>
    <div id="numeric">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                        <el-input-number v-if="options.isLimited" v-model="options.defaultNum"></el-input-number>
                        <el-input-number v-else v-model="num"></el-input-number>
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-col :span="6">
                                <el-input v-model="options.title"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Set Default Value">
                            <el-switch v-model="options.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch><br>
                            <el-input-number :disabled="!options.isLimited" v-model="options.defaultNum"></el-input-number>
                        </el-form-item>
                    </el-form>
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    data() {
        return {
            num: 0
        }
    },

    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },

}
</script>

<style>

</style>
