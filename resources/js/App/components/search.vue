<template>
	<base-input
        :value="value"
        @input="handleInput($event)"
        class="tw-no-shrink tw-mr-2"
        :placeholder="`Search`">
        <i slot="prefix" class="el-input__icon el-icon-search"></i>
    </base-input>
</template>
<script>
	export default {
		props: {
			value: String
		},

		methods: {
			handleInput(event) {
				this.$emit('input', event);
			},
		}
	}
</script>