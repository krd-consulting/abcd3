<template>
    <div id="radio" class="tw-my-8">
        <el-row>
            <el-col :span="5">
                <label for="radioGroup" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>

            <el-col :span="10">
                <div class="zone">
                    <el-radio-group id="radioGroup" 
                        class="tw-my-2 tw-mx-8" 
                        v-model="select" 
                        v-for="choice in field.choices" 
                        :key="choice">
                            <el-radio :label="choice"></el-radio>
                    </el-radio-group>
                </div>
            </el-col>
        </el-row>

        <br>
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: ''
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>
.zone {
    overflow: none;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    max-height: 200px;
    max-width: 300px;
}
</style>
