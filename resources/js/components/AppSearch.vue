<template>
	<base-input
        :value="value"
        @input="handleInput($event)"
        class="tw-no-shrink tw-mr-2"
        :placeholder="`Search for something`">
        <i slot="prefix" class="el-input__icon el-icon-search"></i>
    </base-input>
</template>
<script>
	export default {
		props: {
			value: String
		},

		methods: {
			handleInput: _.debounce(function(event) {
                this.$emit('input', event);
            }, 300),
		}
	}
</script>