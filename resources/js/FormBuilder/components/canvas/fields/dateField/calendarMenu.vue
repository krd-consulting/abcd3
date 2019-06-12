<template>
    <el-date-picker 
        v-model="dateSelection" 
        type="date" 
        placeholder="Pick a day" 
        :picker-options="shortcutOnly">
    </el-date-picker>
</template>

<script>
export default {
    data: () => {
        return {
            dateSelection: '',
            shortcutOnly: {
                shortcuts: [
                    { text: 'Today', onClick(picker) 
                        { picker.$emit('pick', new Date()); }
                    }, 
                    { text: 'Yesterday', onClick(picker) 
                        { const date = new Date(); 
                          date.setTime(date.getTime() - 3600 * 1000 * 24); 
                          picker.$emit('pick', date);
                        }
                    },
                    { text: 'A week ago', onClick(picker) 
                        { const date = new Date();
                          date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                          picker.$emit('pick', date);}
                    }
                ],
            },
        }
    }
}
</script>

<style>

</style>
