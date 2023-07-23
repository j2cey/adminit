<template>
    <b-field size="is-small">
        <b-input size="is-small" type="number"
                 placeholder="Integer Value"
                 v-model="setting.value"

                 :loading="loading"
        ></b-input>
    </b-field>
</template>

<script>
import SettingBus from "../settingBus";

export default {
    name: "integervalue",
    props: {
        setting_prop: {},
    },
    mounted() {
        SettingBus.$on('setting_edit', (setting) => {
            if (this.setting.id === setting.id) {
                this.editing = true
            }
        })

        SettingBus.$on('setting_edit_cancel', (setting) => {
            if (this.setting.id === setting.id) {
                this.editing = false
                this.loading = false
            }
        })

        SettingBus.$on('setting_updating', (setting) => {
            if (this.setting.id === setting.id) {
                this.loading = true
            }
        })
    },
    created() {
    },
    data() {
        return {
            setting: this.setting_prop,

            editing: false,
            loading: false,
        }
    },
}
</script>

<style scoped>

</style>
