<template>
    <b-field size="is-small">
        <b-field size="is-small">
            <b-select size="is-small" placeholder="Comparison Type" name="comparisontype" v-model="analysisrulecomparison.comparisontype" :disabled="!editing">
                <option
                    v-for="option in comparisontypes"
                    :value="option"
                    :key="option.id">
                    {{ option.label }}
                </option>
            </b-select>
        </b-field>
        <b-field size="is-small">
            <b-input size="is-small" type="number"
                     placeholder="Valeur"
                     v-model="analysisrulecomparison.inner_operand"

                     :loading="loading"
                     :readonly="!editing"
            ></b-input>
        </b-field>
        <b-field size="is-small">
            <b-field size="is-small" horizontal>
                <b-checkbox size="is-small" v-model="analysisrulecomparison.use_strict_comparison" type="is-warning" :disabled="!editing">
                    Strict
                </b-checkbox>
            </b-field>
            <b-field size="is-small" horizontal>
                <b-checkbox size="is-small" v-model="analysisrulecomparison.use_type_comparison" type="is-warning" :disabled="!editing">
                    Type
                </b-checkbox>
            </b-field>
        </b-field>

    </b-field>
</template>

<script>
import AnalysisRuleBus from "../analysisruleBus";

export default {
    name: "analysisrulecomparison",
    props: {
        analysisrule_prop: {},
        inneranalysisrule_prop: {},
        model_type_prop: null,
    },
    mounted() {
        AnalysisRuleBus.$on('analysisrule_edit', (analysisrule) => {
            if (this.analysisrule.id === analysisrule.id) {
                this.editing = true
            }
        })

        AnalysisRuleBus.$on('analysisrule_edit_cancel', (analysisrule) => {
            if (this.analysisrule.id === analysisrule.id) {
                this.editing = false
                this.loading = false
            }
        })

        AnalysisRuleBus.$on('analysisrule_updating', (analysisrule) => {
            if (this.analysisrule.id === analysisrule.id) {
                this.loading = true
            }
        })
    },
    created() {
        // eslint-disable-next-line no-undef
        axios.get('/comparisontypes.fetchall')
            .then(({data}) => this.comparisontypes = data);
    },
    data() {
        return {
            analysisrule: this.analysisrule_prop,
            analysisrulecomparison: this.inneranalysisrule_prop,
            model_type: this.model_type_prop,

            comparisontypes: [],

            editing: false,
            loading: false,
        }
    },
}
</script>

<style scoped>

</style>
