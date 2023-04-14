<template>
    <section>
        <b-tabs size="is-small" type="is-boxed">
            <b-tab-item>
                <template #header>
                    <b-icon icon="information-outline"></b-icon>
                    <span> Infos </span>
                </template>

                <section>
                    <div class="box">

                        <div class="row">
                            <div class="col">
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Name</span></template>
                                    <b-field>
                                        <b-input custom-class="transinput" size="is-small" :value="dynamicattribute.name" name="name" placeholder="Name" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Title</span></template>
                                    <b-field>
                                        <b-input style="border-style:none;" size="is-small" :value="dynamicattribute.title" name="title" placeholder="Title" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Type</span></template>
                                    <b-field>
                                        <b-input size="is-small" :value="dynamicattribute.dynamicattributetype.name" name="dynamicattributetype" placeholder="Type" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Num. Order</span></template>
                                    <b-field>
                                        <b-input size="is-small" :value="dynamicattribute.num_ord" name="num_ord" placeholder="Num. Order" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Offset</span></template>
                                    <b-field>
                                        <b-input size="is-small" :value="dynamicattribute.offset || 0" name="num_ord" placeholder="Offset" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Max Length</span></template>
                                    <b-field>
                                        <b-input size="is-small" :value="dynamicattribute.max_length || 0" name="max_length" placeholder="Max Length" readonly></b-input>
                                    </b-field>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <template #label><span class="has-text-primary text-xs">Created at</span></template>
                                    <b-field>
                                        <b-input size="is-small" :value="dynamicattribute.created_at | formatDate" name="created_at" placeholder="Created at" readonly></b-input>
                                    </b-field>
                                </b-field>
                            </div>

                            <div class="col">
                                <b-field size="is-small" horizontal>
                                    <b-checkbox size="is-small" :value="dynamicattribute.searchable" type="is-info" disabled>
                                        Searchable
                                    </b-checkbox>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <b-checkbox size="is-small" :value="dynamicattribute.sortable" type="is-info" disabled>
                                        Sortable
                                    </b-checkbox>
                                </b-field>
                                <b-field size="is-small" horizontal>
                                    <b-checkbox size="is-small" :value="dynamicattribute.can_be_notified" type="is-info" disabled>
                                        Can be notified
                                    </b-checkbox>
                                </b-field>
                            </div>
                        </div>

                    </div>
                </section>
            </b-tab-item>
            <b-tab-item>
                <template #header>
                    <b-icon icon="source-pull"></b-icon>
                    <span class="help-inline pr-1 text-sm"> Règles d'Analyse </span>
                    <b-tag rounded type="is-info is-light">{{ dynamicattribute.analysisrules.length }}</b-tag>
                </template>

                <AnalysisRuleList :model_prop="dynamicattribute"></AnalysisRuleList>

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

<style lang="scss" scoped>
    .transinput {
        border: none;
        background-color: none;
        outline: 0;
    }
</style>
