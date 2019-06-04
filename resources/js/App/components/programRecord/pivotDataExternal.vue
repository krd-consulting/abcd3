<template>
	<div class="tw-flex tw-flex-grow">
        <div class="tw-flex-1">
            <span>{{ record.enrolled_at }}</span>
        </div>
    </div>
</template>
<script>
	export default {
		props: {
			record: Array | Object
		}
	}
</script>