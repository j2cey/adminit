<template>
    <b-taglist>
        <b-tag rounded v-if="setting.value === '1'" type="is-success">true</b-tag>
        <b-tag rounded v-else type="is-danger">false</b-tag>
    </b-taglist>
</template>

<script>
export default {
    name: "booldisplay",
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
