<template>
    <b-field size="is-small">
        <b-field size="is-small">
            <b-select size="is-small" placeholder="Treshold Type" name="thresholdtype" v-model="analysisrulethreshold.thresholdtype" :disabled="!editing">
                <option
                    v-for="option in thresholdtypes"
                    :value="option"
                    :key="option.id">
                    {{ option.label }}
                </option>
            </b-select>
        </b-field>
        <b-field size="is-small">
            <b-input size="is-small" type="number"
                     placeholder="Seuil"
                     v-model="analysisrulethreshold.threshold"

                     :loading="loading"
                     :readonly="!editing"
            ></b-input>
        </b-field>

    </b-field>
</template>

<script>
import AnalysisRuleBus from "../../analysisrules/analysisruleBus";

export default {
    name: "analysisrulethreshold",
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
        axios.get('/thresholdtypes.fetchall')
            .then(({data}) => this.thresholdtypes = data);
    },
    data() {
        return {
            analysisrule: this.analysisrule_prop,
            analysisrulethreshold: this.inneranalysisrule_prop,
            model_type: this.model_type_prop,

            thresholdtypes: [],

            editing: false,
            loading: false,
        }
    },
}
</script>

<style scoped>

</style>
