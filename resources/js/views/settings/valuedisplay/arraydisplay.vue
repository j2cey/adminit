<template>
    <b-taglist>
        <b-tag :key="setting.id + '_' + item_value" size="is-small" type="is-info" v-for="item_value in array_value">{{ item_value }}</b-tag>
    </b-taglist>
</template>

<script>
export default {
    name: "arraydisplay",
    props: {
        setting_prop: {},
    },
    data() {
        return {
            setting: this.setting_prop,
            array_value: this.setting_prop.value.split(this.setting_prop.array_sep),
        }
    },
}
</script>

<style scoped>

</style>
