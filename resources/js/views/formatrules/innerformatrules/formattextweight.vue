<template>
    <b-field size="is-small">
        <b-checkbox-button size="is-small" type="is-dark is-light" v-model="checkboxGroup" native-value="bold"
                           :loading="loading"
                           :readonly="!editing"
                           :disabled="!editing"
                           @input="setElemToCheckboxGroup('bold')"
        >
            <b-icon icon="format-bold"></b-icon>
        </b-checkbox-button>
        <b-checkbox-button size="is-small" type="is-info is-light" v-model="checkboxGroup" native-value="italic"
                           :loading="loading"
                           :readonly="!editing"
                           :disabled="!editing"
                           @input="setElemToCheckboxGroup('italic')"
        >
            <b-icon icon="format-italic"></b-icon>
        </b-checkbox-button>
        <b-checkbox-button size="is-small" type="is-primary is-light" v-model="checkboxGroup" native-value="underline"
                           :loading="loading"
                           :readonly="!editing"
                           :disabled="!editing"
                           @input="setElemToCheckboxGroup('underline')"
        >
            <b-icon icon="format-underline"></b-icon>
        </b-checkbox-button>
    </b-field>
</template>

<script>
import FormatRuleBus from "../formatruleBus";

export default {
    name: "formattextweight",
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
    created() {

    },
    data() {
        return {
            formatrule: this.formatrule_prop,
            formattextweight: this.innerformatrule_prop,
            model_type: this.model_type_prop,

            checkboxGroup: JSON.parse(this.innerformatrule_prop.format_value),

            editing: false,
            loading: false,
        }
    },
    methods: {
        setElemToCheckboxGroup(elem) {
            if (elem === 'bold') {
                this.formattextweight.format_bold = ! this.formattextweight.format_bold
            }
            if (elem === 'italic') {
                this.formattextweight.format_italic = ! this.formattextweight.format_italic
            }
            if (elem === 'underline') {
                this.formattextweight.underline = ! this.formattextweight.underline
            }

            this.formattextweight.format_value = JSON.stringify(this.checkboxGroup)
        }
    },
}
</script>

<style scoped>

</style>
