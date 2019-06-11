<template>
    <el-date-picker 
        v-model="dateSelection" 
        type="datetime"
        placeholder="Select date and time"
        format="yyyy/MM/dd h:mm:ss a"
        :picker-options="dayOptions">
    </el-date-picker>
</template>

<script>
export default {
    data: () => {
        return {
            dateSelection: '',
            dayOptions: {
                disabledDate(time) {
                    return time.getTime() > Date.now();
                },
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
            }
        }
    }
}
</script>

<style>

</style>
