<template>
    <div class="tw-my-8">
        <el-row class="tw-my-8">
            <el-divider>
                <span>
                    {{ field.title }}
                </span>
            </el-divider>
        </el-row>
    </div>
</template>

<script>
export default {
    data: () => {
        return {

        }
    },
    props: { 
        field: Object
    },
}
</script>

<style>

</style>
