<template>
    <b-field grouped group-multiline>
        <div class="control">
            <b-taglist attached>
                <b-tag rounded :type="'is-'+ status.style + ' is-light'" v-model="statuscode">{{ status.name }}</b-tag>
                <b-tag rounded type="is-ghost btn" @click="switchStatus(status.code)"> <i class="fa fa-refresh"></i> </b-tag>
            </b-taglist>
        </div>
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
        name: "status-inline-display",
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
            switchStatus(code) {
                if (code === 'active') {
                    this.saveStatus('inactive')
                } else {
                    this.saveStatus('active')
                }
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
