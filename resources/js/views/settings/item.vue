<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left" style="max-width: 100%;">{{ setting.full_path }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 col-6 border-right">
            <span class="text text-xs">{{ setting.value }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span v-if="setting.type === 'string'" class="badge badge-primary text-xs">{{ setting.type }}</span>
            <span v-else-if="setting.type === 'integer'" class="badge badge-success text-xs">{{ setting.type }}</span>
            <span v-else-if="setting.type === 'array'" class="badge badge-warning text-xs">{{ setting.type }}</span>
            <span v-else class="badge badge-secondary text-xs">{{ setting.type }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editSetting(setting)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
    import SettingBus from "./settingBus";

    export default {
        name: "setting-item",
        props: {
            setting_prop: {}
        },
        components: {
        },
        mounted() {
            SettingBus.$on('setting_updated', (setting) => {
                if (this.setting.id === setting.id) {
                    this.setting = setting
                }
            })
        },
        data() {
            return {
                setting: this.setting_prop,
            };
        },
        methods: {
            editSetting(setting) {
                SettingBus.$emit('setting_edit',setting);
            }
        },
        computed: {}
    }
</script>

<style scoped>

</style>
