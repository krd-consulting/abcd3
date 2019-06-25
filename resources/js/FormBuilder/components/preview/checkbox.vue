<template>
    <div id="radio">
        <label for="check" class="inputLabel">{{ field.label }}</label><br>
        <sup>{{ field.description }}</sup>
        <el-checkbox-group id="check" 
            class="tw-h-8"
            v-for="item in field.options.responses" 
            :key="item.id"
            v-model="select">
            <el-checkbox :label="item.text" class="tw-my-2 tw-ml-8 tw-text-lg"></el-checkbox>
        </el-checkbox-group>
    </div>
</template>

<script>
export default {
    data() {
        return {
            select: []
        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>

</style>
