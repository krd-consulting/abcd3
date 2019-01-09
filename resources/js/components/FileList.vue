<template>
    <div>
        <file-list-item
            v-for="(file, index) in files"
            :key="index"
            :index="index"
            :file="file"
            :file-type="fileType"
            :fields="fields"></file-list-item>
    </div>
</template>
<script>
    import FileListItem from './FileListItem';

    export default {
        props: {
            files: Array,
            fileType: String,
            fields: Object|Array
        },

        components: {
            FileListItem
        },
    }
</script>
