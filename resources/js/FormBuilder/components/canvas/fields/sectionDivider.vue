<template>
     <el-collapse>
        <el-collapse-item name="1">
            <template slot="title">
                <el-divider><span>{{ options.sectionHeader }}</span></el-divider>
            </template>
            <div>
                <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                    <el-form-item label="Section Title">
                        <el-input v-model="options.sectionHeader"></el-input>
                    </el-form-item>
                </el-form>
            </div>
            <slot></slot>
        </el-collapse-item>
     </el-collapse>
</template>

<script>
export default {
    data() {
        return {
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

