<template>
    <div id="matrix" class="tw-my-8">
        <br>
        <el-row>
           <el-col :span="24">
                <label for="matrix-table" class="">{{ field.title }}</label><br>
                <sup>{{ field.description }}</sup>
                    <table id="matrix-table" class="tw-w-full">
                    <thead>
                        <tr class="tw-max-w-sm">
                            <th></th>
                            <th class="tw-whitespace-no-wrap tw-mx-2" v-for="(choice, index) in field.choices" :key="index" >
                                <el-col>
                                    {{ choice }}
                                </el-col>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(question, questionIndex) in field.questions" :key="questionIndex">
                            <td>
                                {{ question.title }}
                                <div v-if="errors.has(question.column_name)">
                                    <span class="tw-text-red-500 tw-text-sm">{{ errors.get(question.column_name)[0] }}</span>
                                </div>
                            </td>
                            <td v-for="(response, index) in field.choices"
                                :key="index"
                                class="tw-text-center">
                                <el-radio
                                    @input="$emit('input', {'column_name': question.column_name, 'value': select[questionIndex]})"
                                    :key="response"
                                    :label="response"
                                    v-model="select[questionIndex]"
                                    class="tw-ml-2">
                                        &nbsp;
                                </el-radio>
                            </td>
                        </tr>
                    </tbody>
                </table>
           </el-col>
        </el-row>
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
        field: Object,
        errors: Array | Object
    },
}
</script>

<style scoped>
    #matrix-table {
        /* width: 100%;  */
        /* margin-top: 20px;  */
        z-index: 0;

    }
    #matrix-table td {
        border: 1px solid #dedfe0;
        max-width: 30%;
    }
    #matrix-table tbody tr:hover {
        background: #9ebdef;
    }
</style>
