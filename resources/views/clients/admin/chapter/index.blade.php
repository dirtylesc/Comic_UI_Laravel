@extends('layouts.admin.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        @media (min-width: 576px) {
            .model-dialog-preview {
                max-width: 1000px !important;
            }
        }
    </style>
@endpush
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@section('content-wrapper')
    <div class="content-wrapper m-4" style="margin-top: 1rem !important;">
        @include('clients.admin.chapter.modal_create')
        @include('clients.admin.chapter.modal_edit')
        @include('clients.admin.chapter.modal_preview_chapter')
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="form-group mb-3 position-relative col-6 px-0 d-flex">
                <div class="form-group mb-3 position-relative col-3 px-0">
                    <label for="" class="fs16">Status:</label>
                    <select type="text" name="status" id="select-status" class="col-12 form-control">
                        <option value="-1">All</option>
                        @foreach ($arrStatus as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (isAdmin())
                <div class="form-group">
                    <button class="btn btn-primary" onclick="showModal('create')">New Chapter</button>
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
                    <th scope="col">Info</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody-data">
            </tbody>
        </table>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const submitDelete = (id) => {
            if (confirm('You want to delete this chapter, right?')) {
                var url = "{{ route('api.chapters.destroy', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        comic_slug: "{{ $comic->slug }}",
                    },
                    success: (response) => {
                        if (response.success) {
                            notifySuccess(response.message);
                            showDataTable();
                        }
                    },
                    error: (response) => {
                        notifyError(response.responseJSON.message);
                    },
                });
            }
        }

        const submitApproved = (chapter_id) => {
            if (confirm('You want to approved this chapter, right?')) {
                var apiUrl = '{{ route('api.chapters.approve_status', ':id') }}';
                apiUrl = apiUrl.replace(':id', chapter_id);

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    success: function(response) {
                        if (response.success) {
                            $('.status[data-id="' + chapter_id + '"]')
                                .text(`Approved`)
                                .removeClass('badge-danger')
                                .addClass('badge-info');

                            notifySuccess(response.message);
                        }
                    },
                    error: function(data) {}
                });
            };
        }

        const showModal = (name) => {
            $(`#modal-${name}-chapter`).modal('show')
        }

        const showDataTable = (isSuperAdmin) => {
            $.ajax({
                url: `{{ route('api.comics.chapters.index', $comic->id) }}`,
                dataType: 'json',
                data: {
                    page: {{ request()->get('page') ?? 1 }},
                    q: $('#search').val() || '',
                    status: $('#select-status').val() || -1,
                },
                success: function(response) {
                    $('#tbody-data').empty();
                    response.data.data.forEach(each => {
                        let info =
                            `
                            <strong>Chapter</strong>: <span class="number">${each.number}</span>
                            <input type="hidden" value=${each.slug} class="slug">
                            <br>
                            <strong>Title</strong>: <span class="title">${each.title || 'No title'}</span>
                            <br>
                            <strong>View</strong>: ${each.view || 0}
                            <br>
                            <strong>Images</strong>: <span class="btn-link cursor_pointer" onclick=previewImages(${each.id})>View images</span>
                            `;

                        let description = !!each.description ?
                            `<span class='text-ellipsis' style="-webkit-line-clamp: 3;">${each.description}</span>` :
                            '';

                        let status =
                            `
                            ${
                                each.status === 'Approved' 
                                ?  '<span class="badge badge-info">Approved</span>'
                                : `<span class="badge badge-danger status cursor_pointer" ${isSuperAdmin ? `onclick=submitApproved(${each.id})` : ''} data-id=${each.id}>Pending</span>`
                                }
                                `;

                        let action = `
                                <button class="btn btn-primary col-12" onclick="fillFormEditChapter(this)">Update</button>
                                <button class="btn btn-secondary col-12 mt-2" onclick="submitDelete(${each.id})">Delete</button>
                                `;
                        const date = new Date(each.created_at);
                        const created_at = convertDateToDateTime(date);

                        $('#tbody-data').append($('<tr>')
                            .append($('<td>')
                                .append($('<span class="id">')
                                    .append(each.id)))
                            .append($('<td class="col-3">').append(info))
                            .append($('<td>').append(status))
                            .append($('<td>').append(created_at))
                            .append($('<td class="col-1" id="action">').append(action))
                        )
                    });
                    renderPagination(response.data.pagination);
                },
                error: function(response) {
                    notifyError(response.responseJSON.message);
                }
            });
        }

        const checkSlug = (name, that = 'non-onject') => {
            var url = `{{ route('api.chapters.check_slug', ':id') }}`;

            if (that !== 'non-onject') {
                const lastestParent = $(that.parentElement.parentElement);
                url = url.replace(':id', lastestParent.find('form').find('#id').val());
            } else {
                url = url.replace(':id', -1);
            }

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    'slug': $(`#slug-${name}`).val(),
                    'comic_id': "{{ $comic->id }}",
                },
                success: function(response) {
                    if (response.success)
                        submitFormChapter(name);
                },
                error: function(response) {
                    const erorrs = Object.values(response.responseJSON.errors.slug);
                    notifyError(erorrs);
                }
            });
        }

        const submitFormChapter = (name) => {
            const form = $(`#form-${name}-chapter`);
            const formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        notifySuccess(response.message);
                        $(`#modal-${name}-chapter`).modal('hide');
                        showDataTable();

                        form.trigger('reset');
                    }
                },
                error: function(data) {
                    const erorrs = Object.values(data.responseJSON.errors);
                    notifyError(erorrs);
                }
            });
        }

        const fillFormEditChapter = (that) => {
            const lastestParent = $(that.parentElement.parentElement);

            const form_edit = $('#form-edit-chapter');
            form_edit.find('#title').val(lastestParent.find('.title').text());
            form_edit.find('#number-edit').val(lastestParent.find('.number').text());
            form_edit.find('#slug-edit').val(lastestParent.find('.slug').val());
            form_edit.find('#id').val(lastestParent.find('.id').text());

            var url = "{{ route('api.chapters.update', ':id') }}";
            url = url.replace(':id', lastestParent.find('.id').text());
            form_edit.attr('action', url);

            showModal('edit');
        }

        const previewChapter = (input, placeToInsertImagePreview) => {
            if (input.files.length > 0) {
                $(placeToInsertImagePreview).empty();
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img width="100%">')).attr('src', event.target.result).appendTo(
                            placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
                $('#modal-preview-chapter').modal('show');
            }
        }

        const previewImages = ($id) => {
            var url = '{{ route('api.chapters.get_images', ':id') }}';
            url = url.replace(':id', $id);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('div.gallery').empty();
                        response.data.forEach(element => {
                            $($.parseHTML('<img width="100%">')).attr('src',
                                    window.location.origin + '/storage/' + element.link)
                                .appendTo(
                                    'div.gallery');
                        });
                        $('#modal-preview-chapter').modal('show');
                    }
                },
                error: function(response) {
                    const erorrs = Object.values(response.responseJSON.errors);
                    notifyError(erorrs);
                }
            });
        }

        $(document).ready(function() {
            //Generate Slug Example
            $('#number-create').change(function() {
                $('#slug-create').val('chapter-' + $(this).val());
            });
            $('#number-edit').change(function() {
                $('#slug-edit').val('chapter-' + $(this).val());
            });

            //Re-render Data Table
            $('#select-translator, #search, #select-status').change(function() {
                showDataTable();
            });

            //Close Modal Create / Edit
            $('#close-modal-1, #close-modal-2').click(() => {
                $('#modal-create-chapter').modal('hide')
            })

            $('#close-modal-3, #close-modal-4').click(() => {
                $('#modal-edit-chapter').modal('hide')
            })
        });
    </script>
    @if (isSuperAdmin())
        <script>
            showDataTable(1);
        </script>
    @else
        <script>
            showDataTable(0);

            //ADD PREPEND EDIT BUTTON
            $("#action").prepend(
                `<button class="btn btn-primary col-12 mb-1" onclick="fillFormEditChapter(this)">Edit</button>`)
        </script>
    @endif
@endpush
