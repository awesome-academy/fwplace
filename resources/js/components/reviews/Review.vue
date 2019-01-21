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
            <table
                class="table table-editable table-striped- table-bordered table-hover table-checkable"
                id="m_table_1"
            >
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
                                <h3>{{ subject.name }}</h3>
                                ({{ subject.day }} {{ $t('day') }})
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
                                        <span
                                            class="ml-2"
                                            v-html="subjects[x].reports[n - 1].content"
                                        ></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Link') }}</label>
                                    <a
                                        target="_blank"
                                        v-if="subjects[x].reports[n - 1].day == n"
                                        v-bind:href="subjects[x].reports[n - 1].link"
                                    >{{ subjects[x].reports[n - 1].link }}</a>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Test') }}</label>
                                    <a
                                        target="_blank"
                                        v-if="subjects[x].reports[n - 1].day == n"
                                        v-bind:href="subjects[x].reports[n - 1].test_link"
                                    >{{ subjects[x].reports[n - 1].test_link }}</a>
                                </div>
                            </td>
                            <td>
                                <span v-html="subjects[x].reports[n - 1].lesson"></span>
                            </td>
                            <td>
                                <span v-html="subjects[x].reports[n - 1].status"></span>
                            </td>
                            <td class="p-0">
                                <div
                                    v-for="(review, k) in subjects[x].reports[n - 1].reviews"
                                    :key="k"
                                >
                                    <template
                                        v-if="subjects[x].reports[n - 1].reviews[k].user_id == user.id"
                                    >
                                        <div class="border border-warning mb-5">
                                            <ckeditor
                                                class="edittor"
                                                type="balloon"
                                                @blur="submitReview(x, n, k)"
                                                @focus="focus(x, n, k)"
                                                v-model="subjects[x].reports[n - 1].reviews[k].content"
                                            ></ckeditor>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="position-relative">
                                            <div
                                                v-html="subjects[x].reports[n - 1].reviews[k].content"
                                                class="border border-primary"
                                            ></div>
                                            <label
                                                class="position-absolute r-0 bg-primary text-light"
                                            >{{ subjects[x].reports[n - 1].reviews[k].name }}</label>
                                        </div>
                                        <div
                                            class="border border-warning mb-5"
                                            v-if="k == lastIndex(subjects[x].reports[n - 1].reviews)"
                                        >
                                            <ckeditor
                                                class="edittor"
                                                type="balloon"
                                                @blur="submitReview(x, n, $event)"
                                                @focus="focus(x, n)"
                                            ></ckeditor>
                                        </div>
                                    </template>
                                </div>
                                <template v-if="subjects[x].reports[n - 1].reviews.length === 0">
                                    <div class="border border-warning">
                                        <ckeditor
                                            class="edittor"
                                            type="balloon"
                                            @blur="submitReview(x, n, $event)"
                                            @focus="focus(x, n)"
                                        ></ckeditor>
                                    </div>
                                </template>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
            <div class="position-fixed overflow-x-scroll" id="scroll">
                <div class="scroll"></div>
            </div>
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
                report_id: '',
                content: ''
            },
            editting: false,
            loading: true
        };
    },
    created() {
        this.getUser();
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
        lastIndex(object) {
            return Object.keys(object).length - 1;
        },
        getUser() {
            axios.get('/current-user').then(res => {
                this.user = res.data.data;
            });
        },
        submitReview(x, n, k) {
            if (!isNaN(k)) {
                if (
                    this.review.content ===
                    this.subjects[x].reports[n - 1].reviews[k].content
                ) {
                    return;
                }
                this.review.content = this.subjects[x].reports[n - 1].reviews[
                    k
                ].content;
            } else {
                this.review.content = k.sourceElement.innerText;
            }

            axios.patch('/reviews', this.review);
        },
        focus(x, n, k) {
            let report = this.subjects[x].reports[n - 1];
            if (k !== undefined) {
                this.review.content = report.reviews[k].content;
                this.review.id = report.reviews[k].id;
            } else {
                this.review.content = '';
                this.review.id = null;
            }
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
                this.resizeScroll();
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
        },
        resizeScroll() {
            $(document).ready(function() {
                function isElementScrollingOut(element) {
                    var pageTop = $(window).scrollTop();
                    var pageBottom = pageTop + $(window).height();
                    var elementTop = $(element).offset().top;
                    var elementBottom = elementTop + $(element).height();

                    if (elementBottom <= pageBottom) {
                        return pageBottom - elementBottom;
                    } else {
                        return false;
                    }
                }

                function scrolling() {
                    var diff = isElementScrollingOut($('.report-section')[0]);
                    if (diff) {
                        $('#scroll').css('bottom', diff);
                    } else {
                        $('#scroll').css('bottom', 0);
                    }
                }

                function resize() {
                    let element = $('#scroll');
                    scrolling();
                    $(element).css('width', $('.report-section').innerWidth());
                    $(element)
                        .children('div')
                        .css('width', $('.report-section')[0].scrollWidth);
                }

                resize();
            });
        }
    }
};
</script>
