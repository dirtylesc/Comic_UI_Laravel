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

        .select2-selection__choice__remove {
            color: #fff !important;
            font-size: 1.4rem !important;
        }

        .select2-selection__choice__remove:hover {
            background-color: #0dcaf0 !important;
            color: black !important;
        }

        .select2-selection {
            min-height: 38px !important;
        }

        .select2-selection__arrow,
        .select2-selection__rendered {
            margin-top: 5px;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8) none 50% / contain no-repeat;
            cursor: pointer;
            transition: 0.3s;

            visibility: hidden;
            opacity: 0;
        }

        #overlay.open {
            visibility: visible;
            opacity: 1;
        }

        #overlay:after {
            /* X button icon */
            content: "\2715";
            position: absolute;
            color: #fff;
            top: 10px;
            right: 20px;
            font-size: 2em;
        }
    </style>
@endpush
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@section('content-wrapper')
    <div class="content-wrapper m-4">
        <div class="modal" id="modal-category" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="close-modal-category-1">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0" id="errors-category"></div>
                    <div class="modal-body">
                        <form action="{{ route('api.categories.store') }}" id="form-create-category" method="POST">
                            <div class="col-12">
                                <label for="name">Category Name <span class="c_red">(*)</span>:</label>
                                <input type="text" name="name" id="category_name" class="form-control">
                            </div>
                            <div class="col-12 mt-1">
                                <label for="description">Description:</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit-modal-category"
                            onclick="submitForm('category')">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="close-modal-category-2">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('api.comics.store') }}" method="POST" id="form-create-comic" enctype="multipart/form-data">
            @csrf
            <table class="table">
                <tbody>
                    <tr class="form-group">
                        <div class="d-flex">
                            <div class="col-4">
                                <label for="name">Comic Name <span class="c_red">(*)</span>:</label>
                                <input type="text" placeholder="Enter comic name.." name="name" id="name"
                                    value="{{ old('name') }}" class="form-control mt-1">
                            </div>
                            <div class="col-4">
                                <label for="alias">Alias:</label>
                                <input type="text" placeholder="Enter comic's alias.." name="alias" id="alias"
                                    value="{{ old('alias') }}" class="form-control mt-1">
                            </div>
                            <div class="col-4">
                                <label for="author">Author:</label>
                                <input type="text" placeholder="Enter comic's author.." name="author" id="author"
                                    value="{{ old('author') }}" class="form-control mt-1">
                            </div>
                        </div>
                    </tr>
                    <tr class="form-group">
                        <div class="d-flex mt-2">
                            <div class="col-4">
                                <label for="language">Language:</label>
                                <select name="language" id="language" class="form-control mt-1">
                                    @foreach ($languages as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="avatar">Avatar:</label>
                                <input type="file" name="avatar" id="avatar" value="{{ old('avatar') }}"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])" class="form-control mt-1">
                            </div>
                            <div class="col-4">
                                <img src="" alt="" id="pic" height="100" class=""
                                    style="cursor: pointer">
                                <div id="overlay" class="custom-file-input"></div>
                            </div>
                        </div>
                    </tr>
                    <tr class="form-group">
                        <div class="d-flex mt-2">
                            <div class="col-4">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" rows="5" class="form-control mt-1">{{ old('description') }}</textarea>
                            </div>
                            <div class="col-8">
                                <label for="categories" class="mt-1 ps-0 position-relative col-12">
                                    Categories:
                                    <span class="btn btn-secondary position-absolute" style="top: -15px; right: 0px"
                                        onclick="$('#modal-category').modal('show')">
                                        New
                                    </span>
                                </label>
                                <select name="categories[]" id="select-category" multiple
                                    class="form-control mt-1"></select>
                                <div class="d-flex mt-2">
                                    <div class="form-group col-4 p-0">
                                        <label for="select-translator">
                                            Translator <span class="c_red">(*)</span>:
                                        </label>
                                        <select name="user_id" id="select-translator-create" class="form-control">
                                        </select>
                                    </div>
                                    <div class="form-group col-4 pr-0">
                                        <label for="status">Status:</label>
                                        <select name="status" class="form-control">
                                            @foreach ($arrStatus as $status => $key)
                                                @if (!$loop->last)
                                                    <option value="{{ $key }}">{{ $status }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4 pr-0">
                                        <label for="slug">Slug:</label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                </tbody>
            </table>
        </form>
        <button class="btn btn-primary ms-3" id="btn_submit">Submit</button>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="module" src="{{ asset('js/admin/comic/create.js') }}"></script>
@endpush
