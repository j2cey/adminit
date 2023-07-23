<template>
    <b-field>
        <b-taginput size="is-small"
                    v-model="array_value" attached
                    placeholder="Add a value" :loading="loading"
                    @add="addElem"
                    @remove="removeElem"
        >
        </b-taginput>
    </b-field>
</template>

<script>
import SettingBus from "../settingBus";

export default {
    name: "arrayvalue",
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
            array_value: this.setting_prop.value.split(this.setting_prop.array_sep),

            editing: false,
            loading: false,
        }
    },
    methods: {
        // eslint-disable-next-line no-unused-vars
        addElem($event) {
            this.updateValueFromArray()
            console.log("addElem: ", this.setting.value)
        },
        // eslint-disable-next-line no-unused-vars
        removeElem($event) {
            this.updateValueFromArray()
            console.log("removeElem: ", this.setting.value)
        },
        updateValueFromArray() {
            this.setting.value = this.array_value.join(this.setting.array_sep)
        }
    },
    computed: {
        arrayValue() {
            return this.setting.value.split(this.setting.array_sep)
        }
    }
}
</script>

<style scoped>

</style>
