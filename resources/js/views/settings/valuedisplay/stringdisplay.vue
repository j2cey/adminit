<template>
    <b-field custom-class="is-small">
        <template #label>
            <span class="has-text-primary is-italic">{{setting.value}}</span>
        </template>
    </b-field>
</template>

<script>
export default {
    name: "stringdisplay",
    props: {
        setting_prop: {},
    },
    data() {
        return {
            setting: this.setting_prop,
        }
    },
}
</script>

<style scoped>

</style>
