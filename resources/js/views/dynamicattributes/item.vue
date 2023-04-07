<template>
    <section>
        <b-tabs size="is-small" type="is-boxed">
            <b-tab-item>
                <template #header>
                    <b-icon icon="information-outline"></b-icon>
                    <span> Infos </span>
                </template>

                <div class="card card-default">
                    <div class="card-body">
                        <dl>
                            <dt class="text text-xs">Name</dt>
                            <dd class="text text-xs">{{ dynamicattribute.name }}</dd>
                            <dt class="text text-xs">Type</dt>
                            <dd class="text text-xs">{{ dynamicattribute.dynamicattributetype.name }}</dd>
                            <dt class="text text-xs">Num. Order</dt>
                            <dd class="text text-xs">{{ dynamicattribute.num_ord }}</dd>
                            <dt class="text text-xs">Offset</dt>
                            <dd class="text text-xs">{{ dynamicattribute.offset || 0}}</dd>
                            <dt class="text text-xs">Max Length</dt>
                            <dd class="text text-xs">{{ dynamicattribute.max_length || 0}}</dd>
                            <dt class="text text-xs">Creaed at</dt>
                            <dd class="text text-xs">{{ dynamicattribute.created_at | formatDate}}</dd>
                        </dl>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item>
                <template #header>
                    <b-icon icon="source-pull"></b-icon>
                    <span class="help-inline pr-1 text-sm"> Analysis </span>
                    <b-button size="is-small" type="is-ghost" @click="createAnalysisRule(dynamicattribute)"><i class="fas fa-plus"></i></b-button>
                </template>

                <AnalysisRuleList :attributeid_prop="dynamicattribute.id" :analysisrules_prop="dynamicattribute.analysisrules"></AnalysisRuleList>

            </b-tab-item>

            <b-tab-item>
                <template #header>
                    <b-icon icon="bars" pack="fa"></b-icon>
                    <span class="help-inline pr-1 text-sm"> Règles Formattage </span>
                    <b-tag rounded type="is-info is-light">{{ dynamicattribute.formatrules.length }}</b-tag>
                </template>

                <FormatRuleList :model_prop="dynamicattribute"></FormatRuleList>

            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
export default {
    name: "dynamicattribute-item",
    props: {
        model_type_prop: String,
        dynamicattribute_prop: {}
    },
    components: {
        AnalysisRuleList: () => import('../analysisrules/list'),
        FormatRuleList: () => import('../formatrules/list'),
    },
    data() {
        return {
            model: this.model_prop,
            dynamicattribute: this.dynamicattribute_prop,
        }
    }
}
</script>

<style scoped>

</style>
