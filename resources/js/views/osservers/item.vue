<template>
    <div class="row">
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left">{{ osserver.id }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left" style="max-width: 100%;">{{ osserver.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs">{{ osserver.osfamily ? osserver.osfamily.name : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ osserver.osarchitecture ? osserver.osarchitecture.name : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editOsServer(osserver)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a type="button"  @click="deleteOsServer(osserver)" class="btn btn-tool text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import OsServerBus from "./osserverBus";

export default {
    name: "osserver-item",

    props: {
        osserver_prop: {}
    },

    components: {
    },
    mounted() {
        OsServerBus.$on('os_server_updated', (osserver) => {
            if (this.osserver.id === osserver.id) {
                this.osserver = osserver
            }
        })
    },
    data() {
        return {
            osserver: this.osserver_prop,
        };
    },
    methods: {
        editOsServer(osserver) {
            console.log('os_server_edit on ITEM: ', osserver)
            OsServerBus.$emit('os_server_edit', osserver);
        },

        deleteOsServer(osserver) {

            this.$swal({
                title: '<small>Êtes vous sûr de vouloir supprimer ce serveur?</small>',
                text: "Cette procédure est irrévocable!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.value) {

                    // eslint-disable-next-line no-undef
                    axios.delete(`/osservers/${osserver.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.$swal({
                                html: '<small>Serveur supprimé avec succès</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('osserver_deleted', osserver)
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },

    },
    computed: {
    }
}
</script>

<style scoped>

</style>
