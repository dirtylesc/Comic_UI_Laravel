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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.8/handlebars.min.js"
        integrity="sha512-E1dSFxg+wsfJ4HKjutk/WaCzK7S2wv1POn1RRPGh8ZK+ag9l244Vqxji3r6wgz9YBf6+vhQEYJZpSjqWFPg9gg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script id="my-template" type="text/x-handlebars-template">
        
    </script>
    <script src="{{ asset('js/admin/comic/index.js') }}" type="module"></script>
    @if (isSuperAdmin())
        <script type="module">
            showDataTable(1);
        </script>
    @else
        <script type="module">
            import {
                showDataTable
            } from '{{ asset('js/admin/comic/index.js') }}'
            showDataTable(0);
        </script>
    @endif
@endpush
