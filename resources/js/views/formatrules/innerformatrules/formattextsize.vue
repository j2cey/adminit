<template>
    <b-field>
        <b-input size="is-small" type="number"
                 :min="formattextsize.min_value"
                 :max="formattextsize.max_value"
                 placeholder="size"
                 v-model="formattextsize.format_value"

                 :loading="loading"
                 :readonly="!editing"
        ></b-input>
    </b-field>
</template>

<script>
    import FormatRuleBus from "../../formatrules/formatruleBus";

    export default {
        name: "formattextsize",
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
                formattextsize: this.innerformatrule_prop,
                model_type: this.model_type_prop,

                editing: false,
                loading: false,
            }
        },
    }
</script>

<style scoped>

</style>
