<template>
    <div id="matrix">
        <!-- <div v-for="data in formData" :key="data.title"> -->
            <!-- <div v-for="field in formData" :key="field.label"> -->
                <label for="matrix-table" class="inputLabel">{{ field.label }}</label><br>
                <sup>{{ field.fieldDescription }}</sup>
                    <table id="matrix-table">
                    <thead>
                        <tr class="tw-max-w-sm">
                            <th></th>
                            <th v-for="(item, index) in field.options.responses" :key="index" >
                                <el-col>
                                    {{ item.text }}
                                </el-col>  
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(question, questionIndex) in field.options.questions" :key="questionIndex">
                            <td>
                                {{ question.text }}
                            </td>
                            <td v-for="(response, index) in field.options.responses" 
                                :key="response.id" 
                                class="tw-text-center">
                                <el-radio :value="index" 
                                    :key="response.id"
                                    :label="response.value"
                                    v-model="select[questionIndex]" 
                                    class="tw-ml-2">
                                        &nbsp;
                                </el-radio>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>
        <!-- </div> -->
    <!-- </div> -->
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

<style scoped>
    #matrix-table {
        width: 100%; 
        /* margin-top: 20px;  */
        z-index: 0;
        
    }
    #matrix-table table, td {
        border: 1px solid #dedfe0;
    }
    #matrix-table tbody tr:hover {
        background: #9ebdef;
    }
</style>
