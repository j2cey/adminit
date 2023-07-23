<template>
    <div class="card collapsed-card">
        <div class="card-header">

            <h5 type="button" class="btn btn-tool" data-card-widget="collapse">
                {{ list_title }}
            </h5>

            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <settingsgroup v-for="settinggroup in settings_grouped" :ref="settinggroup.id" :key="settinggroup.id" :settinggroup_prop="settinggroup" :list_title_prop="settinggroup.name" v-on:setting_edit="editSeting"></settingsgroup>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <SettingAddUpdate></SettingAddUpdate>
    </div>
</template>

<script>
import SettingBus from "./settingBus";

export default {
    name: "setting-item-list",
    props: {
        list_title_prop: {default: "Settings", type: String},
        settings_grouped_prop: {}
    },
    components: {
        settingsgroup: () => import('./group'),
        SettingAddUpdate: () => import('./addupdate'),
    },
    data() {
        return {
            list_title: this.list_title_prop,
            settings_grouped: this.settings_grouped_prop,
            searchSettings: "",

            isOpen: 0,
            collapses: [
                {
                    title: 'Title 1',
                    text: 'Text 1'
                },
                {
                    title: 'Title 2',
                    text: 'Text 2'
                },
                {
                    title: 'Title 3',
                    text: 'Text 3'
                }
            ]
        };
    },
    methods: {
        editSeting($setting) {
            SettingBus.$emit('setting_edit',$setting);
        }
    },
    computed: {
    }
}
</script>

<style scoped>

</style>
