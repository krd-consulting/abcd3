<template>
    <div id="datepciker">
        <el-collapse>
            <span class="inputLabel">{{ options.title }}</span><br>
            <el-collapse-item name="1">
                <template slot="title">
                    <div v-if="options.dateType === 'day'">
                        <el-date-picker 
                            v-model="dateSelection" 
                            :type="dateType" 
                            :picker-options="dateOptions" 
                            :placeholder="datePlaceHolder"
                            :format="dateFormat">
                        </el-date-picker>
                    </div>

                    <div v-if="options.dateType === 'extended'">
                        <div>
                            <!-- week -->
                        </div>
                        <div>
                            <!-- month -->
                        </div>
                        <div>
                            <!-- year -->
                        </div>
                    </div>
                    <div v-if="options.dateType === 'range'"></div>
                </template>
                <div>
                    <el-form label-position="top" ref="options" :model="options" @submit.native.prevent>
                        <el-form-item label="Field Label">
                            <el-col :span="6">
                                <el-input v-model="options.title"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item>
                            <el-switch v-model="options.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-form-item>
                        <el-form-item label="Select By">
                            <el-radio-group v-model="options.dateType" size="medium">
                                <el-radio-button label="day" ></el-radio-button>
                                <el-radio-button label="extended"></el-radio-button>
                                <el-radio-button label="range"></el-radio-button>
                            </el-radio-group>
                            <div v-if="options.dateType === 'day'">
                                <span>Calendar Preferences</span><br>
                                <el-row>
                                    <el-switch @change="togglePastOnly" v-model="myOptions.daySelect1" inactive-text="No restriction" active-text="Only past dates"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleQuickMenu" v-model="myOptions.daySelect2" inactive-text="No Quick menu" active-text="Quick menu"></el-switch>
                                </el-row>
                                <el-row>
                                    <el-switch @change="toggleTime" v-model="myOptions.daySelect3" inactive-text="No time" active-text="Include time"></el-switch>
                                </el-row>
                            </div>
                            <div v-if="options.dateType === 'extended'">
                                <p>week</p>
                                <p>month</p>
                                <p>year</p>
                            </div>
                            <div v-if="options.dateType === 'range'">
                                <p>from this day to that day</p>
                                <p>from this day/time to that day/time</p>
                                <p>from this week to that week</p>
                                <p>from this month to that month</p>
                                <p>quick menu</p>
                            </div>
                        </el-form-item>
                    </el-form>
                </div>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>

export default {
    data: () => {
        return {
            dateSelection: '',
            dateType: 'date',
            dateOptions: {},
            datePlaceHolder: 'Pick a day',
            dateFormat: 'yyyy/MM/dd',
            myOptions: []
        }
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    mounted() {
        this.togglePastOnly(),
        this.toggleQuickMenu(),
        this.toggleTime()
    },
    created() {
        this.myOptions = _.clone(this.options)
    },
    methods: {
        togglePastOnly() {
            if(this.myOptions.daySelect1 === true) {
                this.dateOptions.disabledDate = function(time) { 
                    return time.getTime() > Date.now() 
                }
                console.log(this.dateOptions)
            } else if(this.myOptions.daySelect1 === false) {
                delete this.dateOptions.disabledDate;
                console.log(this.dateOptions)
            }
        },
        toggleQuickMenu() {
            console.log(this.options.daySelect2)
        },
        toggleTime() {
            console.log(this.options.daySelect3)
        }
    }
}
</script>

<style>

</style>
