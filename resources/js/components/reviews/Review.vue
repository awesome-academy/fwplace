<template>
    <div class="position-relative">
        <select name="batch" class="form-select mb-3" v-model="batch_selected">
            <template v-for="batch in batches">
                <option :value="batch.id">{{ batch.name }}</option>
            </template>
        </select>
        <select name="trainees" class="form-select mb-3" v-model="trainee_selected">
            <option v-for="trainee in trainees" :value="trainee.id">{{ trainee.name }}</option>
        </select>
        <div class="report-section">
            <table class="table table-editable table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>{{ $t('Subject') }}</th>
                        <th class="th-report-content">{{ $t('Content') }}</th>
                        <th class="th-report-item">{{ $t('Lesson') }}</th>
                        <th class="th-report-item">{{ $t('Status') }}</th>
                        <th class="th-report-item">{{ $t('Review') }}</th>
                    </tr>
                </thead>
                <tbody v-for="(subject, x) in subjects" :key="x">
                    <tr v-for="(n,index) in subject.day" :key="n">
                        <template v-if="subjects[x].reports[n - 1].day == n">
                            <td>
                                <h3>{{ subject.name }}</h3> ({{ subject.day }} {{ $t('day') }})
                                <hr>
                                <div>Day: {{ n }}</div>
                                <div class="form-group">
                                    <span>{{ frontEndDateFormat(subjects[x].reports[n - 1].updated_at) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label>{{ $t('Content') }}</label>
                                    <div>
                                        <span class="ml-2" v-html="subjects[x].reports[n - 1].content"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Link') }}</label>
                                    <a target="_blank" v-if="subjects[x].reports[n - 1].day == n" v-bind:href="subjects[x].reports[n - 1].link">{{ subjects[x].reports[n - 1].link }}</a>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Test') }}</label>
                                    <a target="_blank" v-if="subjects[x].reports[n - 1].day == n" v-bind:href="subjects[x].reports[n - 1].test_link">{{ subjects[x].reports[n - 1].test_link }}</a>
                                </div>
                            </td>
                            <td>
                                <span v-html="subjects[x].reports[n - 1].lesson"></span>
                            </td>
                            <td>
                                <span v-html="subjects[x].reports[n - 1].status"></span>
                            </td>
                            <td>
                                <ckeditor class="edittor" type="balloon" @blur="submitReview(x, n)" @focus="focus(x, n)" v-model="subjects[x].reports[n - 1].review"></ckeditor>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="loading" v-show="loading === true">
            <br>
            <span>{{ $t('Loading') }}...</span>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            user: {
                role: ''
            },
            trainees: [''],
            batches: [''],
            batch_selected: '',
            trainee_selected: '',
            subjects: [''],
            reports: [''],
            review: {
                id: '',
                report_id: '',
                content: ''
            },
            reviewLength: 0,
            editting: false,
            loading: true
        };
    },
    created() {
        this.getBatches();
    },
    watch: {
        batch_selected: function() {
            this.getTrainees(this.batch_selected);
        },
        trainee_selected: function() {
            this.loading = true;
            this.getTraineesReport();
        }
    },
    methods: {
        submitReview(x, n) {
            if (
                this.review.content === this.subjects[x].reports[n - 1].review
            ) {
                return;
            }
            this.review.content = this.subjects[x].reports[n - 1].review;
            axios.put('/reviews', this.review);
        },
        focus(x, n) {
            let report = this.subjects[x].reports[n - 1];
            this.review.content = report.review;
            this.review.id = report.review_id;
            this.review.report_id = report.id;
        },
        getTrainees(id) {
            axios(`/trainees/batch/${id}`).then(res => {
                this.trainees = res.data.data;
                if (this.trainees[0])
                    this.trainee_selected = this.trainees[0].id;
                else this.loading = false;
            });
        },
        getTraineesReport() {
            axios(`/reports/trainee/${this.trainee_selected}`).then(res => {
                this.subjects = res.data;
                this.loading = false;
            });
        },
        getBatches() {
            axios('/batches').then(res => {
                this.batches = res.data.data;
                this.batch_selected = this.batches[0].id;
            });
        },
        frontEndDateFormat: function(date) {
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },

        backEndDateFormat: function(date) {
            return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    }
};
</script>
