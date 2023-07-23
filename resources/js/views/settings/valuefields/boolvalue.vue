<template>
    <b-field>
        <b-radio-button size="is-small" v-model="setting.value"
                        native-value="1"
                        type="is-success"
                        :loading="loading">
            <b-icon icon="check"></b-icon>
            <span>true</span>
        </b-radio-button>
        <b-radio-button size="is-small" v-model="setting.value"
                        native-value="0"
                        type="is-danger"
                        :loading="loading">
            <b-icon icon="close"></b-icon>
            <span>false</span>
        </b-radio-button>
    </b-field>
</template>

<script>
import SettingBus from "../settingBus";

export default {
    name: "boolvalue",
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
