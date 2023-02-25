<template>
    <b-field label="Status" label-position="on-border" custom-class="is-small">
        <b-radio-button size="is-small" v-model="statuscode"
                        native-value="active"
                        type="is-success is-light is-outlined" @input="saveStatus('active')">
            <b-icon icon="check"></b-icon>
            <span>Active</span>
        </b-radio-button>
        <b-radio-button size="is-small" v-model="statuscode"
                        native-value="inactive"
                        type="is-danger is-light is-outlined" @input="saveStatus('inactive')">
            <b-icon icon="close"></b-icon>
            <span>Inactive</span>
        </b-radio-button>
    </b-field>
</template>

<script>

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false
    })

    class Status {
        constructor(status) {
            this.code = status.code || ''
            this.model_type = status.model_type || ''
            this.model_id = status.model_id || ''
        }
    }

    export default {
        name: "status-show",
        props: {
            model_type_prop: "",
            model_id_prop: "",
            status_prop: {}
        },
        data() {
            return {
                status: this.status_prop,
                statuscode: this.status_prop.code,
                statusForm: new Form( new Status( {
                    'code': this.status_prop.code,
                    'model_type': this.model_type_prop,
                    'model_id': this.model_id_prop,
                } ) ),
                editing: false,
                loading: false,
            }
        },
        methods: {
            testChecked(code) {
                console.log("status checked: ", code)
            },
            saveStatus(code) {
                this.statusForm.code = code

                this.loading = true

                console.log("save status: ", code)

                this.statusForm
                    .post('/statuses.modelupdate')
                    .then(status => {
                        this.loading = false

                        Toast.fire({
                            icon: 'success',
                            title: 'Status changed successfully'
                        }).then(() => {
                            this.status = status
                        })
                    }).catch(error => {
                    this.loading = false
                }).finally(
                    this.statusForm = new Form( new Status( {
                        'code': this.status.code,
                        'model_type': this.model_type_prop,
                        'model_id': this.model_id_prop,
                    } ) ),
                );

            },
        },
        computed: {
            isValidForm() {
                return !this.loading
            },
        }
    }
</script>

<style scoped>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }

</style>
