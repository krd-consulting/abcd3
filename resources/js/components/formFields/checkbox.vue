<template>
    <div class="tw-my-8">
        <el-row>
            <el-col :span="5">
                <label for="check" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label>
            </el-col>
            <el-col :span="10">
                <div class="zone">
                    <el-checkbox-group id="check" 
                        class="tw-h-8"
                        v-for="choice in field.choices" 
                        :key="choice"
                        v-model="select"
                        :required="isRequired">

                            <el-checkbox :label="choice" class="tw-my-2 tw-ml-8 tw-text-lg"></el-checkbox>

                    </el-checkbox-group>
                </div>
                
            </el-col>
            
        </el-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: [],
        }
    },
    props: { 
        field: Object
    },
    computed: {
        isRequired: {
            get() { return this.field.settings.required }
        }
    }
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
