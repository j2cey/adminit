<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left" style="max-width: 100%;">{{ setting.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs">
                <component v-if="setting.type" :key="fieldvalue_key" id="value" :ref="setting.full_path" :is="setting.type + 'display'" :setting_prop="setting"></component>
            </span>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 col-6 border-right">
            <b-field>
                <b-input type="textarea" group-multiline custom-class="text text-xs border-0" readonly :value="setting.description" style="min-height: 2px"></b-input>
            </b-field>
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
        stringdisplay: () => import('./valuedisplay/stringdisplay'),
        integerdisplay: () => import('./valuedisplay/integerdisplay'),
        booldisplay: () => import('./valuedisplay/booldisplay'),
        floatdisplay: () => import('./valuedisplay/floatdisplay'),
        arraydisplay: () => import('./valuedisplay/arraydisplay'),
    },
    mounted() {
        SettingBus.$on('setting_updated', (setting) => {
            console.log("setting_updated received")
            if (this.setting.id === setting.id) {
                this.setting = setting
                this.forceRerenderValueDisplay()
                console.log("setting_updated updated: ", this.setting, "fieldvalue_key: ", this.fieldvalue_key)
            }
        })
    },
    data() {
        return {
            setting: this.setting_prop,
            commom_key: 0,
            fieldvalue_key: this.generateRandomInteger(10000),
        };
    },
    methods: {
        generateRandomInteger(max) {
            return Math.floor(Math.random() * max) + 1;
        },
        forceRerenderValueDisplay() {
            this.commom_key = this.generateRandomInteger(10000);
            this.fieldvalue_key = this.setting.id + this.commom_key;
        },
        editSetting(setting) {
            this.$emit('setting_edit',setting);
        }
    },
    computed: {}
}
</script>

<style scoped>

</style>
