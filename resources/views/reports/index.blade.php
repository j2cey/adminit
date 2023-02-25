@extends('app', ['page_title' => "Reports"])

@section('app_content')

    <section class="section">

        <div class="container">

            <div class="tw-bg-white tw-shadow-md tw-rounded tw-px-3 md:tw-px-8 tw-pt-3 md:tw-pt-6 tw-pb-3 md:tw-pb-8 tw-mb-4">

                <div class="tw-mb-4">

                    <h2 class="tw-text-blue-600 tw-text-sm tw-font-bold tw-mb-3 tw-border-b tw-border-gray-400 tw-pb-2">
                        <span class="text text-align-left">List Of Reports</span>
                        <span class="text text-align-right">
                            <b-button size="is-small" type="is-info is-light" @click="$emit('create_new_report')"><i class="fas fa-plus"></i></b-button>
                        </span>
                    </h2>

                    <!-- SEARCH FORM -->

                    <search-form
                        group="report-search"
                        url="{{ route('reports.fetch') }}"
                        :params="{
                            search: '',
                            per_page: {{ $defaultPerPage }},
                            page: 1,
                            order_by: 'title:asc',
                            createdat_from: '',
                            createdat_to: '',
                            type: '',
                            status: '',
                            reporttype: '',
                            }"
                        v-slot="{ params, update, change, clear, processing }"
                    >

                        <form class="tw-grid tw-grid-cols-10 tw-col-gap-4 tw-pb-3 tw-border-b tw-border-gray-400">
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="createdat_from"
                                    class="tw-block tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    From
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="createdat_from" lang="fr" style="width: 90%; height: 90%;" v-model="params.createdat_from" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="createdat_to"
                                    class="tw-block tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    To
                                </label>
                                <div class="relative">
                                    <vue2-datepicker id="createdat_to" lang="fr" style="width: 90%; height: 90%;" v-model="params.createdat_to" format="YYYY-MM-DD" @change="change"></vue2-datepicker>
                                </div>
                            </div>

                            {{--                            TODO: PB de rafraichissement des parametres de filtre--}}

                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="reporttype"
                                    class="tw-block tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Report Type
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.reporttype"
                                            @change="change"
                                            id="reporttype"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-text-xs tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                        >
                                            <option
                                                v-for="reporttype in {{ $reporttypes }}"
                                                :value="reporttype.id"
                                            >@{{ reporttype.name }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="reporttype_clear" name="reporttype_clear" class="btn btn-default btn-sm" @click="[params.reporttype= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="tw-col-span-4 md:tw-col-span-2">
                                <label
                                    for="status"
                                    class="tw-block tw-tracking-wide tw-text-gray-700 tw-text-xs tw-font-bold tw-mb-2"
                                >
                                    Status
                                </label>
                                <div class="tw-inline-flex">
                                    <div class="tw-relative">
                                        <select
                                            v-model="params.status"
                                            @change="change"
                                            id="status"
                                            class="tw-appearance-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-text-xs tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-rounded-sm tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                                        >
                                            <option
                                                v-for="status in {{ $statuses }}"
                                                :value="status.id"
                                            >@{{ status.name }}</option>
                                        </select>
                                        <select-angle></select-angle>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" id="status_clear" name="status_clear" class="btn btn-default btn-sm" @click="[params.status= '', change()]"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </search-form>

                    <!--/ SEARCH FORM -->


                    <!-- RESULTS -->

                    <search-results group="report-search" v-slot="{ total, records }">

                        <div class="tw-text-sm">

                            <div class="tw-flex tw-flex-wrap tw-p-4 tw-bg-gray-700 tw-text-white tw-rounded-sm">
                                <div class="tw-flex-auto tw-pr-3">Total : @{{ total }}</div>
                            </div>

                            <template v-if="records.length">

                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th class="tw-px-4 tw-py-2">#</th>
                                        <th class="tw-px-4 tw-py-2">Title</th>
                                        <th class="tw-px-4 tw-py-2">Description</th>
                                        <th class="tw-px-4 tw-py-2">Report Type</th>
                                        <th class="tw-px-4 tw-py-2">Status</th>
                                        <th class="tw-px-4 tw-py-2">Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="record in records"
                                        :key="record.id"
                                        class="tw-px-4 tw-border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700 hover:tw-bg-gray-100"
                                    >
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.id }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.title }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm">@{{ record.description }}</span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <span class="tw-text-sm" v-if="record.reporttype">
                                                @{{ record.reporttype.name }}
                                            </span>
                                        </td>
                                        <td class="tw-px-6 tw-py-2">
                                            <span class="tw-text-sm" v-if="record.status">
                                                <span v-if="record.status.code === 'active'" class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-green-600 tw-bg-green-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.status.name }}</span>
                                                <span v-else class="tw-text-xs tw-font-semibold tw-inline-block tw-py-1 tw-px-2 tw-rounded tw-text-teal-600 tw-bg-red-200 tw-w-32 last:tw-mr-0 tw-mr-1">@{{ record.status.name }}</span>
                                            </span>
                                        </td>
                                        <td class="tw-px-4 tw-py-2">
                                            <a :href="record.show_url" class="tw-inline-block tw-mr-3 tw-text-green-500">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </template>

                            <div
                                v-else
                                class="tw-flex tw-flex-wrap tw-p-4 border-b tw-border-dashed tw-border-gray-400 tw-text-gray-700"
                            >
                                No Data Available
                            </div>

                        </div>

                    </search-results>

                    <!--/ RESULTS -->


                    <!-- PAGINATION -->

                    <search-pagination group="report-search" :always-show="true"></search-pagination>

                    <!--/ PAGINATION -->

                </div>

                <report-addupdate></report-addupdate>
            </div>
        </div>

    </section>

@endsection
