<template>
    <div class="card-comment">
        <div class="comment-text">
            <span class="username text-sm">
                {{ comment.user.name }}
                <span class="text-muted float-right">{{ comment.created_at | formatDate }}</span>
            </span><!-- /.username -->
            <small>
                <span class="text-muted float-left">
                    <a class="text-success" @click="editComment(comment,model_type,model_id)">
                        <span class="badge badge-default"><i class="fa fa-pencil-square-o"></i></span>
                    </a>
                    <a class="text-danger" @click="deleteComment(comment)">
                        <span class="badge badge-default"><i class="fa fa-trash-o"></i></span>
                    </a>
                </span>
                <span>{{comment.comment_text}}</span>
            </small>
        </div>
        <!-- /.comment-text -->
    </div>
</template>

<script>
    import CommentBus from "./commentBus";

    class Comment {
        constructor(comment) {
            this.comment_text = comment.comment_text || ''
            this.description = comment.description || ''
            this.model_type = comment.model_type || ''
            this.model_id = comment.model_id || ''
            this.posi = comment.posi || ''
        }
    }
    export default {
        name: "comment-item",
        props: {
            comment_prop: null,
            model_type_prop: '',
            model_id_prop: ''
        },
        data() {
            return {
                comment: this.comment_prop,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                commentForm: new Form(new Comment({})),
            }
        },
        mounted() {
            CommentBus.$on('comment_updated', (upd_data) => {
                if (this.comment.id === upd_data.comment.id) {
                    this.updateComment(upd_data.comment)
                }
            })
        },
        methods: {
            initCommentForm() {
                this.comment.model_type = this.model_type_prop
                this.comment.model_id = this.model_id_prop
                this.commentForm = new Form(this.comment)
            },
            editComment(comment,modelType, modelId) {
                CommentBus.$emit('comment_edit', comment,modelType,modelId)
            },
            updateComment(comment) {
                window.noty({
                    message: 'Comment successfully deleted',
                    type: 'success'
                })
                this.comment = comment
            },
            deleteComment(comment) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.value) {

                        this.initCommentForm();

                        this.commentForm
                            .put(`/comments/remove/${this.comment.uuid}`, undefined)
                            .then(resp => {
                                this.$parent.$emit('comment_deleted', comment)
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
