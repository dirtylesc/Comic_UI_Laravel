@extends('layouts.admin.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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
            padding: .4em .7em !important;
            cursor: default;
        }

        .b_status {
            padding: .6em .9em !important;
            font-size: .9rem !important;
        }
    </style>
@endpush
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@section('content-wrapper')
    <div class="content-wrapper m-4" style="margin-top: 1rem !important;">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="form-group mb-3 position-relative col-6 px-0 d-flex">
                <div class="form-group mb-3 position-relative col-3 px-0">
                    <label for="" class="fs16">Status:</label>
                    <select type="text" name="status" id="select-status" class="col-12 form-control">
                        <option value="-1">All</option>
                        @foreach ($arrStatus as $status => $key)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-9">
                    <label for="" class="fs16">Category:</label>
                    <select type="text" name="categories[]" id="select-category" class="ms-2 col-12" multiple>
                    </select>
                    <button class="btn position-absolute border-left-1" style="height: 38px; right: 10px"
                        onclick="filterCategory()">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>
            @if (isAdmin())
                <div class="form-group">
                    <a href="{{ route('admin.comics.create') }}" class="btn btn-primary">Add Comic</a>
                </div>
            @endif
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Info</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody-data">
                <tr>
                    <td>id</td>
                    <td>
                        <img width='85px' height='85px' class="bg-info rounded-circle" style="object-fit: cover"
                            src="" />
                    </td>
                    <td class="col-3">
                        <i class="fas fa-star fs12 _on"></i>
                        <a href="${url}" class="fw700">
                            each.name
                        </a>
                        each.alias ? ' - ' + each.alias : ''
                        <br>
                        Author: <strong>each.author</strong>
                        <br>
                        <div class="rate">rate (each.count_rate)</div>
                    </td>
                    <td class="col-1">
                        <span class="badge bg-info">each.language</span>
                    </td>
                    <td class="col-2">
                        <span class='text-ellipsis' style="-webkit-line-clamp: 3;">each.description</span>
                    </td>
                    <td>
                        <div class="dropdown notification-list topbar-dropdown ps-0 max_content">
                            <a class="nav-link dropdown-toggle arrow-none p-0 lh_0" data-toggle="dropdown"
                                id="topbar-languagedrop" href="#" role="button" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="badge ${bagde} status b_status cursor_pointer"
                                    data-id=${each.id}>each.status_name</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu"
                                style="right: 22% !important; min-width: 0; max-width: 100px;"
                                aria-labelledby="topbar-languagedrop">
                                <span class="badge ${addClassStatus(element.value)} cursor_pointer col-12"
                                    onclick="changeStatus(${each.id}, ${each.status}, ${element.value}, '${element.text}')">
                                    element.text
                                </span>
                            </div>
                        </div>

                        <span class="badge badge-danger status b_status cursor_pointer" onclick=changeStatus(${each.id})
                            data-id=each.id>Pending</span>
                    </td>
                    <td>
                        created_at
                    </td>
                    <td class="col-1">
                        action
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal" id="modal-privew-chapter" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <iframe src="{{ route('reader.index') }}" frameborder="0" height="1000px" id=""></iframe>
                </div>
            </div>
        </div>
        <nav>
            <ul class="pagination pagination-rounded" style="float: right" id="pagination">
            </ul>
        </nav>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/admin/comic/index.js') }}"></script>
    @if (isSuperAdmin())
        <script>
            showDataTable(1);
        </script>
    @else
        <script>
            showDataTable(0);
        </script>
    @endif
@endpush
