<template>
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Mime types</span>
                        <span class="info-box-number">{{ filemimetypes.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Types de Fichier</span>
                        <span class="info-box-number">{{ reportfiletypes.length }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Systèmes d'Exploitation</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-address-card"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Protocoles d'Accès</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <ReportFileTypes list_title_prop="Types de Fichier" :reportfiletypes_list_prop="reportfiletypes" v-on:report_file_type_created="addReportFileType" v-on:reportfiletype_removed_from_list="removeReportFileType"></ReportFileTypes>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </div><!--/. container-fluid -->
</template>

<script>

export default {
    name: "reportsetting-index",
    props: {
        filemimetypes_prop: {},
        reportfiletypes_prop: {},
    },
    components: {
        ReportFileTypes: () => import('../reportfiletypes/item-list'),
    },
    data() {
        return {
            filemimetypes: this.filemimetypes_prop,
            reportfiletypes: this.reportfiletypes_prop,
        };
    },
    methods: {
        addReportFileType($event) {
            //console.log("ReportFileType created received in system index", $event)
            let reportFileTypeIndex = this.reportfiletypes.findIndex(s => {
                return $event.id === s.id
            })
            if (reportFileTypeIndex === -1) {
                this.reportfiletypes.push($event)
            }
        },
        removeReportFileType($event){
            //console.log("reportfiletype_removed_from_list received at reportsetting-index", $event)
            let reportFileTypeIndex = this.reportfiletypes.findIndex(s => {
                return $event.id === s.id
            })
            if (reportFileTypeIndex === -1) {
                this.reportfiletypes.splice($event, 1)
            }
        }

    },
    computed: {
    }
}
</script>

<style scoped>
</style>
