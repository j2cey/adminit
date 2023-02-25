<template>

    <div id="rulelist">

        <AnalysisRule v-for="(analysisrule, index) in analysisrules" :key="analysisrule.id" :analysisrule_prop="analysisrule" :index_prop="index"></AnalysisRule>

    </div>

</template>

<script>
    import RuleBus from "./analysisruleBus";
    export default {
        name: "rules-list",
        props: {
            attributeid_prop: 0,
            analysisrules_prop: {}
        },
        components: {
            AnalysisRule: () => import('../analysisrules/item'),
        },
        mounted() {
            RuleBus.$on('analysisrule_created', (analysisrule) => {
                console.log('analysisrule_created received from rulelist', analysisrule)
                if (this.attributeId === analysisrule.dynamic_attribute_id) {
                    this.addRuleToList(analysisrule)
                }
            })

            this.$on('analysisrule_deleted', ({ analysisrule, index }) => {
                if (this.attributeId === analysisrule.dynamic_attribute_id) {
                    this.analysisrules.splice(index, 1)
                }
            })
        },
        data() {
            return {
                attributeId: this.attributeid_prop,
                analysisrules: this.analysisrules_prop,
            };
        },
        methods: {
            addRuleToList(analysisrule) {
                let analysisruleIndex = this.analysisrules.findIndex(c => {
                    return analysisrule.id === c.id
                })
                // si cette rule n'existe pas déjà, on l'insère dans la liste
                if (analysisruleIndex === -1) {
                    this.analysisrules.push(analysisrule)
                }
            }
        }
    }
</script>

<style scoped>
</style>
