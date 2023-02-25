<template>
    <div class="card">
        <ul class="todo-list" data-widget="todo-list">

            <li class="list-group-item"
                v-for="(subject, idx) in subjects"
                :key="subject.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <subjectitem :subject_prop="subject" :subsubjects_prop="subject.subsubjects" :is-subsubject_prop="isSubList" :is-upper-list-colored_prop="isUpperListColored"></subjectitem>

            </li>

        </ul>
    </div>
</template>

<script>
    import SubjectBus from './subjectBus'
    import subjectitem from "./subject-item";

    export default {
        name: "subject-list",
        props: {
            subjects_prop: {},
            parentId_prop: '',
            isSubList_prop: false,
            isUpperListColored_prop: false
        },
        components: { subjectitem },
        mounted() {
            SubjectBus.$on('subject_created', (add_data) => {
                if (this.parentId === add_data.categoryId) {
                    this.addSubject(add_data.subject)
                }
            })
            SubjectBus.$on('subsubject_created', (add_data) => {
                if (this.parentId === add_data.subjectParentId) {
                    this.addSubject(add_data.subject)
                }
            })
            this.$on('subject_deleted', (subject) => {
                this.deleteSubject(subject);
            })
            this.$on('subsubject_deleted', (subject) => {
                this.deleteSubject(subject);
            })
        },
        data() {
            return {
                subjects: this.subjects_prop,
                parentId: this.parentId_prop,
                isSubList: this.isSubList_prop,
                isUpperListColored: this.isUpperListColored_prop
            }
        },
        methods: {
            updateSubject(subject) {
                // we get the index of the modified subject
                let subjectIndex = this.subjects.findIndex(s => {
                    return subject.id === s.id
                })
                this.subjects.splice(subjectIndex, 1, subject)
                window.noty({
                    message: 'SubjectResource successfully modified',
                    type: 'success'
                })
            },
            addSubject(subject) {
                let subjectIndex = this.subjects.findIndex(c => {
                    return subject.id === c.id
                })
                // if this subject does not already exists, it is inserted in the list
                if (subjectIndex === -1) {
                    window.noty({
                        message: 'SubjectResource successfully created',
                        type: 'success'
                    })
                    this.subjects.push(subject)
                }
            },
            deleteSubject(subject) {
                let subjectIndex = this.subjects.findIndex(c => {
                    return subject.id === c.id
                })
                // if this subject exists, it is removed from list
                if (subjectIndex !== -1) {
                    window.noty({
                        message: 'SubjectResource successfully deleted',
                        type: 'success'
                    })
                    this.subjects.splice(subjectIndex, 1)
                }
            }
        }
    }
</script>

<style scoped>

</style>
