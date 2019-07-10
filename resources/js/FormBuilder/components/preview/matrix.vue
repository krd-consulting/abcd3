<template>
    <div id="matrix" class="tw-my-8">
        <br>
        <el-row class="tw-mt-24">
           <el-col :span="24">
                <label for="matrix-table" class="inputLabel">{{ field.label }}</label><br>
                <sup>{{ field.description }}</sup>
                    <table id="matrix-table">
                    <thead>
                        <tr class="tw-max-w-sm">
                            <th></th>
                            <th v-for="(item, index) in field.choices" :key="index" >
                                <el-col>
                                    {{ item.value }}
                                </el-col>  
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(question, questionIndex) in field.questions" :key="questionIndex">
                            <td>
                                {{ question.text }}
                            </td>
                            <td v-for="(response, index) in field.choices" 
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
