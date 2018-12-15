<template>
    <div>
        <div class="tw-flex tw-items-center tw-justify-between">
            <h2 class="tw-mb-4">
                <base-icon class="tw-text-xl tw-px-2">people</base-icon> Roles
            </h2>
            <base-button>Create Role</base-button>
        </div>
        <table class="tw-w-full tw-mt-4">
            <thead>
                <tr class="tw-border-b-2">
                    <td colspan="2" class="tw-py-2">
                        <span class="tw-inline-block tw-font-semibold">Administrator</span>
                        <span class="tw-align-middle tw-px-2 tw-py-1 tw-rounded tw-bg-blue-lightest tw-font-semibold tw-text-xs tw-text-blue">
                            <base-icon class="tw-text-xs tw-align-middle">star</base-icon> Universal
                        </span>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="90%" class="tw-py-4 tw-border-b">Write files</td>
                    <td class="tw-py-4 tw-border-b">
                        <el-switch/>
                    </td>
                </tr>
                <tr>
                    <td width="90%" class="tw-py-4 tw-border-b">Write programs</td>
                    <td class="tw-py-4 tw-border-b">
                        <el-switch/>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="tw-w-full tw-mt-8">
            <thead>
                <tr class="tw-border-b-2">
                    <td colspan="2" class="tw-py-2">
                        <span class="tw-inline-block tw-font-semibold">Program Manager</span>
                        <span class="tw-align-middle tw-px-2 tw-py-1 tw-rounded tw-bg-orange-lightest tw-font-semibold tw-text-xs tw-text-orange">
                            <base-icon class="tw-text-xs tw-align-middle">assignment</base-icon> Program
                        </span>
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="90%" class="tw-py-4 tw-border-b">Write files</td>
                    <td class="tw-py-4 tw-border-b">
                        <el-switch/>
                    </td>
                </tr>
                <tr>
                    <td width="90%" class="tw-py-4 tw-border-b">Write programs</td>
                    <td class="tw-py-4 tw-border-b">
                        <el-switch/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {

    }
</script>
