<template>
    <div class="modal fade" id="addUpdateSetting" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="settingModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="settingForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-xs">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" v-model="settingForm.name" readonly>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('name')" v-text="settingForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label text-xs text-xs">Type</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="type" name="type" placeholder="Type" v-model="settingForm.type">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('type')" v-text="settingForm.errors.get('type')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="value" class="col-sm-4 col-form-label text-xs text-xs">Value</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="value" name="value" placeholder="Value" v-model="settingForm.value">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('value')" v-text="settingForm.errors.get('value')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="array_sep" class="col-sm-4 col-form-label text-xs text-xs">Array Separator</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="array_sep" name="array_sep" placeholder="Array Separator" v-model="settingForm.array_sep">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('array_sep')" v-text="settingForm.errors.get('array_sep')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select_group" class="col-sm-4 col-form-label text-xs text-xs">Group</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_group"
                                        v-model="settingForm.group"
                                        selected.sync="subjectForm.group"
                                        value=""
                                        :options="groups"
                                        :searchable="true"
                                        :multiple="false"
                                        label="full_path"
                                        track-by="id"
                                        key="id"
                                        placeholder="Group"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-xs text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description" v-model="settingForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('description')" v-text="settingForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="value" class="col-sm-4 col-form-label text-xs text-xs">Full Path</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="full_path" name="full_path" placeholder="Full Path" v-model="settingForm.full_path" readonly>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="settingForm.errors.has('full_path')" v-text="settingForm.errors.get('full_path')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateSetting()" :disabled="!isValidForm" v-if="editing">Save</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createSetting()" :disabled="!isValidForm" v-else>Create New Setting</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import SettingBus from "./settingBus";

    class Setting {
        constructor(setting) {
            this.name = setting.name || ''
            this.type = setting.type || ''
            this.value = setting.value || ''
            this.array_sep = setting.array_sep || ''
            this.group = setting.group || ''
            this.full_path = setting.full_path || ''
            this.description = setting.description || ''
        }
    }

    export default {
        name: "setting-addupdate",
        components: { Multiselect },
        mounted() {
            SettingBus.$on('setting_edit', (setting) => {
                this.editing = true
                this.setting = new Setting(setting)
                this.settingForm = new Form(this.setting)
                this.settingId = setting.id

                this.formTitle = 'Edit Setting'

                $('#addUpdateSetting').modal()
            })
        },
        created() {
            axios.get('/settings.fetch')
                .then(({data}) => this.groups = data);
        },
        data() {
            return {
                formTitle: 'Create New Setting',
                setting: {},
                settingForm: new Form(new Setting({})),
                settingId: null,
                editing: false,
                loading: false,
                groups: [],
            }
        },
        methods: {
            updateSetting() {
                this.loading = true

                this.settingForm
                    .put(`/settings/${this.settingId}`)
                    .then(setting => {
                        this.loading = false
                        this.resetForm();

                        $('#addUpdateSetting').modal('hide')

                        this.$swal({
                            html: '<small>Setting successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            SettingBus.$emit('setting_updated', setting)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateSetting').modal('hide')
            },
            resetForm() {
                this.settingForm.reset();
            }
        },
        computed: {
            isValidForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
