<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm">{{ status.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ status.code }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ status.description }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input disabled readonly type="checkbox" class="custom-control-input" :id="status.code" :name="status.code" autocomplete="is_default" autofocus placeholder="Is default ?" v-model="status.is_default">
                <label class="custom-control-label" :for="status.code"><span class="text text-xs"></span></label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editStatus(status)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
    import StatusBus from "./statusBus";

    export default {
        name: "status-item",
        props: {
            status_prop: {}
        },
        components: {
        },
        mounted() {
            StatusBus.$on('status_updated', (status) => {
                if (this.status.id === status.id) {
                    this.status = status
                } else {
                    this.refrechStatus()
                }
            })
        },
        data() {
            return {
                status: this.status_prop,
            };
        },
        methods: {
            editStatus(status) {
                StatusBus.$emit('status_edit',status);
            },
            refrechStatus() {
                axios.get(`/statuses.fetchone/${this.status.id}`)
                    .then(({data}) => this.status = data);
            }
        }
    }
</script>

<style scoped>

</style>
