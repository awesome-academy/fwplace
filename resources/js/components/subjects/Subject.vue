<template>
    <div>
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $t('Subjects') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end mr-5">
                <a class="m-menu__link btn btn-success" data-toggle="modal" data-target="#m_modal_subject">
                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">{{ $t('Add Subject') }}</span>
                </a>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                    <thead>
                        <tr>
                            <th>{{ $t('ID') }}</th>
                            <th>{{ $t('Name') }}</th>
                            <th>{{ $t('Day') }}</th>
                            <th>{{ $t('Delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subject in subjects" :key="subject.id">
                            <td>{{ subject.id }}</td>
                            <td>
                                <ItemSubject :content="subject.name" :id="subject.id" :column="'name'" @finishedEdit="finishedEdit"></ItemSubject>
                            </td>

                            <td>
                                <ItemSubject :content="subject.day" :id="subject.id" :column="'day'" @finishedEdit="finishedEdit"></ItemSubject>
                            </td>

                            <td>
                                <a href="javascript:void(0)" @click="deleteSubject(subject.id)">{{ $t('Delete') }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="m_modal_subject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form @submit.prevent="addSubject">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $t('Create Subject') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">{{ $t('Name') }}</label>
                                <input type="text" class="form-control" v-model="name">
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">{{ $t('Day') }}</label>
                                <input type="text" class="form-control" v-model="day">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('Close') }}</button>
                            <button type="submit" class="btn btn-primary" @click="addSubject" data-dismiss="modal">{{ $t('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ItemSubject from './ItemSubject.vue';

export default {
    components: {
        ItemSubject
    },

    data() {
        return {
            name: '',
            day: 0,
            edit: false,
            subjects: []
        };
    },

    mounted() {
        this.getSubject();
    },

    methods: {
        addSubject() {
            this.$store
                .dispatch('subject/addSubject', {
                    name: this.name,
                    day: this.day
                })
                .then(res => {
                    this.getSubject();
                    (this.name = ''), (this.day = 0);
                });
        },

        editing() {
            this.edit = true;
        },

        doneEdit($event) {
            this.name = $event;
        },

        getSubject() {
            this.$store.dispatch('subject/getSubject').then(res => {
                this.subjects = res.data;
            });
        },

        finishedEdit(data) {
            this.$store.dispatch('subject/editSubject', data);
        },

        deleteSubject(id) {
            if (!confirm(this.$t('Are you sure?'))) {
                return;
            }
            this.$store
                .dispatch('subject/deleteSubject', {
                    id: id
                })
                .then(res => {
                    this.getSubject();
                });
        }
    }
};
</script>
