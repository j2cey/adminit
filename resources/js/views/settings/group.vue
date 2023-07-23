<template>
    <div class="card collapsed-card">
        <div class="card-header">

            <h6 class="text text-xs" data-card-widget="collapse">
                {{ list_title }}
                <small class="text text-xs">
                    {{ searchSettings === "" ? "" : " (" + filteredSettings.length + ")" }}
                </small>
            </h6>

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
                                <span class="text text-xs font-weight-light font-italic">{{ settinggroup.description }}</span>
                            </div>
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
                                <span class="text text-sm">Name</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-6">
                                <span class="text text-sm">Value</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Description</span>
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
                        <SettingItem v-if="setting" :setting_prop="setting" v-on:setting_edit="editSeting"></SettingItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
</template>

<script>
import SettingBus from "./settingBus";

export default {
    name: "group",
    props: {
        settinggroup_prop: {},
        list_title_prop: {type: String, default: ""},
        list_color_prop: {type: String, default: "blue"},
    },
    watch: {
        groups_prop: function (newValue, oldValue) {
            this.groups = newValue
        },
    },
    components: {
        SettingItem: () => import('./item')
    },
    data() {
        return {
            settinggroup: this.settinggroup_prop,
            settings: this.settinggroup_prop.mainsubsettings,

            list_title: this.list_title_prop,
            list_color: this.list_color_prop,

            searchSettings: "",

            editing: false,
            loading: false,
        }
    },
    methods: {
        editSeting($setting) {
            this.$emit('setting_edit',$setting);
        }
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
