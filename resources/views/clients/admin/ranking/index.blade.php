@extends('layouts.admin.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .col-3_5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 30% !important;
            flex: 0 0 30%;
            max-width: 30%;
        }

        .select2-selection__choice {
            background-color: #0dcaf0 !important;

            padding-right: 10px !important;
            padding-left: 30px !important;
            padding-top: 5px !important;
            padding-bottom: 4px !important;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .select2-selection {
            min-height: 38px;
        }

        .select2-selection__rendered {
            line-height: 37px !important;
        }

        .select2-selection__arrow {
            top: 6px !important;
            right: 5px !important;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px !important;
        }

        .select2-selection__choice__remove {
            color: #fff !important;
            font-size: 1.4rem !important;
        }

        .select2-selection__choice__remove:hover {
            background-color: #0dcaf0 !important;
            color: black !important;
        }

        .badge {
            padding: .6em .9em !important;
            font-size: .9rem !important;
        }

        table.dataTable.nowrap th,
        table.dataTable.nowrap td {
            white-space: normal;
        }

        .table>:not(caption)>*>* {
            padding: 0;
        }

        .table th {
            padding: .95rem .5rem;
        }

        .table td p {
            height: max-content;
            max-height: max-content;
        }
    </style>
@endpush
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@section('content-wrapper')
    <div class="content-wrapper m-4" style="margin-top: 1rem !important;">
        <div class="col-12 d-flex align-items-center justify-content-between">
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-1">Comics</h4>
                        <div class="table-responsive">
                            <div id="products-datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    {{-- <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="products-datatable_length"><label>Display
                                                <select class="custom-select custom-select-sm ml-1 mr-1">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="-1">All</option>
                                                </select> products</label></div>
                                    </div> --}}
                                    <div class="col-sm-12 col-md-6">
                                        <div id="products-datatable_filter" class="dataTables_filter">
                                            <label>Search:<input type="search" class="form-control form-control-sm"
                                                    placeholder="" aria-controls="products-datatable"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="col-sm-12">
                                            <table
                                                class="table table-centered w-100 dt-responsive nowrap dataTable no-footer dtr-inline"
                                                id="table-comics">
                                                <thead class="thead-light">
                                                    <tr role="row">
                                                        <th class="all sorting" tabindex="0"
                                                            aria-controls="products-datatable" rowspan="1" colspan="1"
                                                            style="width: 270.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">Comic
                                                        </th>
                                                        <th class="all sorting" tabindex="0"
                                                            aria-controls="products-datatable" rowspan="1" colspan="1"
                                                            style="width: 110.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">Total
                                                            View
                                                        </th>
                                                        <th class="all sorting_desc" tabindex="0"
                                                            aria-controls="products-datatable" rowspan="1" colspan="1"
                                                            style="width: 75.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">Rating
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="products-datatable_info" role="status"
                                            aria-live="polite">Showing products 1 to 5 of 12</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="comics-datatable_paginate">
                                            <ul class="pagination pagination-rounded">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-1">Translators</h4>
                        <div class="table-responsive">
                            <div id="products-datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    {{-- <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="products-datatable_length"><label>Display
                                                <select class="custom-select custom-select-sm ml-1 mr-1">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="-1">All</option>
                                                </select> products</label></div>
                                    </div> --}}
                                    <div class="col-sm-12 col-md-6">
                                        <div id="products-datatable_filter" class="dataTables_filter">
                                            <label>Search:<input type="search" class="form-control form-control-sm"
                                                    placeholder="" aria-controls="products-datatable"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="col-sm-12">
                                            <table
                                                class="table table-centered w-100 dt-responsive nowrap dataTable no-footer dtr-inline"
                                                id="table-translators">
                                                <thead class="thead-light">
                                                    <tr role="row">
                                                        <th class="all sorting" tabindex="0"
                                                            aria-controls="translators-datatable" rowspan="1"
                                                            colspan="1" style="width: 270.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">
                                                            Translator
                                                        </th>
                                                        <th class="all sorting" tabindex="0"
                                                            aria-controls="translators-datatable" rowspan="1"
                                                            colspan="1" style="width: 180.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">Monthly
                                                            Chapter
                                                        </th>
                                                        <th class="all sorting_desc" tabindex="0"
                                                            aria-controls="translators-datatable" rowspan="1"
                                                            colspan="1" style="width: 75.8px;" aria-sort="ascending"
                                                            aria-label="Comic: activate to sort column descending">Total
                                                            View
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="products-datatable_info" role="status"
                                            aria-live="polite">Showing products 1 to 5 of 12</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="comics-datatable_paginate">
                                            <ul class="pagination pagination-rounded">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script>
        var getCellValue = function(tr, idx) {
            return tr.children[idx].innerText || tr.children[idx].textContent;
        }

        var comparer = function(idx, asc) {
            return function(a, b) {
                return function(v1, v2) {
                    return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString()
                        .localeCompare(v2);
                }(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));
            }
        };

        // do the work...
        Array.prototype.slice.call(document.querySelectorAll('th')).forEach(function(th) {
            th.addEventListener('click', function(e, a) {
                var table = th.parentNode
                console.log($(this).hasClass('sorting'));
                if ($(this).hasClass('sorting')) {
                    $(this).removeClass('sorting')
                        .addClass('sorting_asc')
                } else if ($(this).hasClass('sorting_asc')) {
                    $(this).removeClass('sorting_asc')
                        .addClass('sorting_desc')
                } else if ($(this).hasClass('sorting_desc')) {
                    $(this).removeClass('sorting_desc')
                        .addClass('sorting_asc')
                }
                while (table.tagName.toUpperCase() != 'TABLE') table = table.parentNode;
                Array.prototype.slice.call(table.querySelectorAll('tr:nth-child(n+2)'))
                    .sort(comparer(Array.prototype.slice.call(th.parentNode.children).indexOf(th), this
                        .asc = !this.asc))
                    .forEach(function(tr) {
                        table.appendChild(tr)
                    });
            })
        })
    </script>
    <script>
        const showDataComics = () => {
            $.ajax({
                url: "{{ route('api.comics.ranking_comic') }}",
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        response.data.forEach(each => {
                            const comic =
                                `<img src="{{ asset('${each.avatar}') }}" alt="contact-img" title="contact-img" class="rounded mr-3" height="70">
                                <div>
                                    <p class = "m-0 align-middle font-16 text-ellipsis" style="-webkit-line-clamp: 2;">
                                    <a href = "apps-ecommerce-products-details.html"
                                    class = "text-body" >${each.name}</a></p>
                                    <small>${each.user_name} - ${each.user_nickname}</small>
                                </div>`

                            const view =
                                `<span class="text-success mr-2"><i class="fa-solid fa-up"></i></span> ${each.view}</span>`

                            $('#table-comics').append($('<tr>')
                                .append($('<td class="d-flex">')
                                    .append(
                                        comic))
                                .append($('<td>').append(view))
                                .append(
                                    $('<td>').append((each.rate || "0.00") +
                                        ` (${each.count_rate})`))
                            )
                        })

                        // $('#comics-datatable_paginate > ul').append(`<li class="paginate_button page-item "><a href="#"
                    //     aria-controls="products-datatable" data-dt-idx="3" tabindex="0"
                    //     class="page-link">3</a></li>`);
                    }
                },
                error: function(response) {

                }
            })
        }

        const showDataTranslators = () => {
            $.ajax({
                url: "{{ route('api.users.ranking_translators') }}",
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#tbody-data-comics').empty();
                        response.data.forEach(each => {
                            let curRate = '';
                            for (let index = 1; index <= 5; index++) {
                                if (index <= parseFloat(each.cur_rate)) {
                                    curRate += '<i class="fas fa-star fs12 _on"></i>'
                                } else {
                                    curRate += '<i class="fas fa-star fs12"></i>'
                                }
                            }

                            const translator =
                                `<img src="{{ asset('${each.avatar}') }}" alt="contact-img" title="contact-img" class="rounded-circle mr-3 fit_cover" height="50" width="50">
                                <div>
                                    <p class = "m-0 align-middle font-16 text-ellipsis" style="-webkit-line-clamp: 2;">
                                    <a href = "apps-ecommerce-products-details.html"
                                    class = "text-body" >${each.name}</a></p>
                                    <small>${each.nickname}</small>
                                    <br>
                                    ${curRate}
                                </div>`

                            const view =
                                `<span class="text-success mr-2"><i class="fa-solid fa-up"></i></span> ${each.view}</span>`
                            const curChapter =
                                `<span class="text-success mr-2"><i class="fa-solid fa-up"></i></span> ${each.cur_chapter || 0}</span>`
                            const increaseChapter = each.cur_chapter - each.pre_chapter;
                            let increaseChapterText = '';
                            if (increaseChapter > 0)
                                increaseChapterText =
                                `<iconify-icon icon="mdi:arrow-up-bold" style="font-size: 18px; height: 14px"></iconify-icon> ${increaseChapter}`
                            else if (increaseChapter < 0)
                                increaseChapterText =
                                `<iconify-icon icon="mdi:arrow-down-bold" style="font-size: 18px; height: 14px"></iconify-icon> ${increaseChapter}`


                            $('#table-translators').append($('<tr>')
                                .append($('<td class="d-flex">')
                                    .append(translator))
                                .append($('<td>')
                                    .append(curChapter)
                                    .append($(
                                            `<span style="margin-left: 15px; color: ${increaseChapter > 0 ? '#42d29d' : '#fa6767'}">`
                                        )
                                        .append(increaseChapterText)))
                                .append($('<td>').append(view))
                            )
                        })
                    }
                },
                error: function(response) {

                }
            })
        }

        $(document).ready(function() {
            showDataComics();
            showDataTranslators();
        })
    </script>
@endpush
