<template>
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
                        <dd class="text text-xs">{{ reportfile.name }}</dd>
                        <dt class="text text-xs">Type de fichier</dt>
                        <dd class="text text-xs">{{ reportfile.reportfiletype.name }}</dd>
                        <dt class="text text-xs">Date Création</dt>
                        <dd class="text text-xs">{{ reportfile.created_at | formatDate}}</dd>
                    </dl>
                </div>
            </div>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon icon="source-pull"></b-icon>
                <span class="help-inline pr-1 text-sm"> Accès </span>
                <b-tag rounded type="is-info is-light">{{ reportfile.reportfileaccesses.length }}</b-tag>
            </template>

            <ReportFileAccessList list_title_prop="Accès au fichier" :reportfile_prop="reportfile" :reportfileaccesses_list_prop="reportfile.reportfileaccesses" ></ReportFileAccessList>
        </b-tab-item>

        <b-tab-item>
            <template #header>
                <b-icon size="small" icon="file"></b-icon>
                <span class="help-inline pr-1 text-sm"> Fichiers Téléchargés </span>
                <b-tag rounded type="is-info is-light">{{ reportfile.collectedreportfiles.length }}</b-tag>
            </template>

            <CollectedReportFileList :collectedreportfiles_prop="reportfile.collectedreportfiles"></CollectedReportFileList>

        </b-tab-item>

            <b-tab-item>
                <template #header>
                    <b-icon size="small" icon="file"></b-icon>
                    <span class="help-inline pr-1 text-sm"> Actions de récupération </span>
                    <b-tag rounded type="is-info is-light">{{ reportfile.selectedretrieveactions.length }}</b-tag>
                </template>
                <!-- model_prop est appelé depuis la list sur le modèle intefrace reportfile!-->
                <SelectedRetrieveActionList :model_prop="reportfile"></SelectedRetrieveActionList>

            </b-tab-item>



    </b-tabs>



</template>

<script>
export default {
    props: {
        reportfile_prop: {},
    },
    name: "reportfile-item",
    components: {
        ReportFileAccessList: () => import('../reportfileaccesses/list'),
        CollectedReportFileList: () => import('../collectedreportfiles/index'),
        SelectedRetrieveActionList: () => import('../selectedretrieveactions/list'),
    },
    data() {
        return {
            reportfile: this.reportfile_prop,
        };
    },
}
</script>

<style scoped>

</style>
