<template>
    <b-field size="is-small">
        <b-colorpicker
            size="is-small"
            position="is-top-right"
            :value="selected_color"
            v-model="selected_color"

            :loading="loading"
            :readonly="!editing"
            :disabled="!editing"

            @input="colorChanged"
        />
    </b-field>
</template>

<script>
    import FormatRuleBus from "../../formatrules/formatruleBus";

    export default {
        name: "formattextcolor",
        props: {
            formatrule_prop: {},
            innerformatrule_prop: {},
            model_type_prop: null,
        },
        mounted() {
            FormatRuleBus.$on('formatrule_edit', (formatrule) => {
                if (this.formatrule.id === formatrule.id) {
                    this.editing = true
                }
            })

            FormatRuleBus.$on('formatrule_edit_cancel', (formatrule) => {
                if (this.formatrule.id === formatrule.id) {
                    this.editing = false
                    this.loading = false
                }
            })

            FormatRuleBus.$on('formatrule_updating', (formatrule) => {
                if (this.formatrule.id === formatrule.id) {
                    this.loading = true
                }
            })
        },
        data() {
            return {
                formatrule: this.formatrule_prop,
                formattextcolor: this.innerformatrule_prop,
                selected_color: this.innerformatrule_prop.format_value,
                model_type: this.model_type_prop,

                editing: false,
                loading: false,
            }
        },
        methods: {
            colorChanged($event) {
                this.formattextcolor.red = $event.red
                this.formattextcolor.alpha = $event.alpha
                this.formattextcolor.blue = $event.blue
                this.formattextcolor.green = $event.green
                this.formattextcolor.hue = $event.hue
                this.formattextcolor.lightness = $event.lightness
                this.formattextcolor.saturation = $event.saturation

                this.formattextcolor.format_value = $event.toString("hex")
            }
        }
    }
</script>

<style scoped>

</style>
