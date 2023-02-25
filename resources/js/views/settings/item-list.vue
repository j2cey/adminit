<template>
    <div class="card collapsed-card">
        <div class="card-header">
            <h5 class="card-title">{{ list_title }}
                <small class="text text-xs">
                    {{ searchSettings === "" ? "" : " (" + filteredSettings.length + ")" }}
                </small>
            </h5>

            <div class="card-tools">

                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                        <a class="dropdown-divider"></a>
                        <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchSettings">
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
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Full Path</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-6">
                                <span class="text text-sm">Value</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Type</span>
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
                <tr v-for="(setting, index) in filteredSettings" v-if="filteredSettings" :key="setting.id" class="text text-xs">
                    <td v-if="index < 10">
                        <SettingItem v-if="setting.value" :setting_prop="setting"></SettingItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <SettingAddUpdate></SettingAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>

    export default {
        name: "setting-item-list",
        props: {
            list_title_prop: {default: "Settings", type: String},
            settings_prop: {},
            settings_grouped_prop: {}
        },
        components: {
            SettingAddUpdate: () => import('./addupdate'),
            SettingItem: () => import('./item')
        },
        data() {
            return {
                list_title: this.list_title_prop,
                settings: this.settings_prop,
                settings_grouped: this.settings_grouped_prop,
                searchSettings: "",
            };
        },
        methods: {
        },
        computed: {
            filteredSettings() {

                let tempSettings = this.settings

                if (this.searchSettings !== '' && this.searchSettings) {
                    tempSettings = tempSettings.filter((item) => {
                        return item.full_path
                            .toUpperCase()
                            .includes(this.searchSettings.toUpperCase())
                    })
                }

                // Sorting
                tempSettings = tempSettings.sort((a, b) => {
                    let fa = a.full_path.toLowerCase(), fb = b.full_path.toLowerCase()

                    if (fa > fb) {
                        return -1
                    }
                    if (fa < fb) {
                        return 1
                    }
                    return 0
                })

                if (!this.ascending) {
                    tempSettings.reverse()
                }
                // end Sorting

                return tempSettings
            }
        }
    }
</script>

<style scoped>

</style>
