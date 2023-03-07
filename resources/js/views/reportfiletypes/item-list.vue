<template>
    <div class="card collapsed-card">
        <div class="card-header">

            <h5 type="button" class="btn btn-tool" data-card-widget="collapse">
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchReportfiletypes === "" ? "" : " (" + filteredReportfiletypes.length + ")" }}
                </small>
            </h5>

            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div class="btn-group">
                                        <b-button size="is-small" type="is-info is-light" @click="createReportFileType">Ajouter</b-button>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6"></div>
                                <div class="col-sm-3 col-6"></div>
                                <div class="col-sm-3 col-6">
                                    <div class="btn-group">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-navbar" type="search" placeholder="Rechercher" aria-label="Search" v-model="searchReportfiletypes">
                                            <div class="input-group-append">
                                                <button class="btn btn-navbar" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 col-6">
                                    <span class="text text-sm">ID</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <span class="text text-sm">Nom</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-sm">Extension</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <span class="text text-sm">Mime Type</span>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-6">
                                    <span class="text text-sm"></span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(reportfiletype, index) in filteredReportfiletypes" v-if="filteredReportfiletypes" :key="reportfiletype.id" class="text text-xs">
                        <td v-if="index < 10">
                            <ReportFileTypeItem :reportfiletype_prop="reportfiletype" v-on:reportfiletype_deleted="deleteReportFileType"></ReportFileTypeItem>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <ReportFileTypeAddUpdate></ReportFileTypeAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>
import ReportFileTypeBus from "../reportfiletypes/reportfiletypeBus";

export default {
    name: "reportfiletype-list",
    props: {
        list_title_prop: {default: "Reportfiletypes", type: String},
        reportfiletypes_list_prop: {},
    },
    components: {
        ReportFileTypeAddUpdate: () => import('./addupdate'),
        ReportFileTypeItem: () => import('./item')
    },
    mounted() {
        ReportFileTypeBus.$on('report_file_type_created', (reportfiletype) => {
            this.reportfiletypes_list.push(reportfiletype)
            // émet l'événement au pararent pour envoyer le nouvel objet créé
            this.$emit('report_file_type_created', reportfiletype)
        })
    },
    data() {
        return {
            list_title: this.list_title_prop,
            reportfiletypes_list: this.reportfiletypes_list_prop,
            searchReportfiletypes: "",
        };
    },
    methods: {
        createReportFileType() {
            ReportFileTypeBus.$emit('report_file_type_create');
        },
        deleteReportFileType($event) {
            //console.log("reportfiletype_deleted received at list: ", $event)
            let itemIndex = this.reportfiletypes_list.findIndex(c => {
                return $event.id === c.id
            })
            console.log("itemIndex : ", itemIndex)
            if (itemIndex !== -1) {
                this.reportfiletypes_list.splice(itemIndex, 1)
                // emission vers le parent
                //this.$emit('reportfiletype_removed_from_list', $event)
            }
        }
    },
    computed: {
        filteredReportfiletypes() {
            let tempReportfiletypes = this.reportfiletypes_list
            if (this.searchReportfiletypes !== '' && this.searchReportfiletypes) {
                tempReportfiletypes = tempReportfiletypes.filter((item) => {
                    return item.name
                        .toUpperCase()
                        .includes(this.searchReportfiletypes.toUpperCase())
                })
            }
            // Sorting
            tempReportfiletypes = tempReportfiletypes.sort((a, b) => {
                let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()
                if (fa > fb) {
                    return -1
                }
                if (fa < fb) {
                    return 1
                }
                return 0
            })
            if (!this.ascending) {
                tempReportfiletypes.reverse()
            }
            // end Sorting
            return tempReportfiletypes
        }
    }
}
</script>

<style scoped>

</style>
