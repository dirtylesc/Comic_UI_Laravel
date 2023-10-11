@extends('layouts.admin.master')
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@push('css')
    <style>
        .badge {
            padding: .6em .9em !important;
            font-size: .9rem !important;
            letter-spacing: 1px;
        }

        .btn-primary {
            color: var(--white) !important;
        }
    </style>
@endpush
@section('content-wrapper')
    <div class="content-wrapper m-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="form-group mb-3 position-relative col-6 px-0 d-flex">
                <div class="form-group mb-3 position-relative col-3 px-0">
                    <label for="" class="fs16">Status:</label>
                    <select class="form-control" name="status" id="select-status">
                        @foreach ($arrStatus as $status => $val)
                            <option value="{{ $val }}">{{ ucwords(strtolower($status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-9">
                    <label for="" class="fs16">Language:</label>
                    <select type="text" name="language[]" id="select-language" class="ms-2 col-12" multiple>
                    </select>
                    <button class="btn position-absolute border-left-1" style="height: 38px; right: 10px"
                        onclick="filterLanguage()">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>
            @if (isAdmin())
                <div class="form-group">
                    <a class="btn btn-primary" onclick="showModal('create-translator')">Add Translator</a>
                </div>
                @include('clients.admin.team.modal_create_translator')
            @endif
        </div>
        <table class="table">
            <thead>
                @if (isSuperAdmin())
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Info</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                @else
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Info</th>
                        <th scope="col">Language</th>
                        <th scope="col">Achievement</th>
                        <th scope="col">Status</th>
                        <th scope="col">Join At</th>
                        <th scope="col">Action</th>
                    </tr>
                @endif
            </thead>
            <tbody id="tbody-data" class="position-relative">
                @if (isSuperAdmin())
                    @foreach ($data as $each)
                        <tr>
                            <td scope="row">
                                {{ $each->id }}
                            </td>
                            <td scope="row" class="col-1">
                                <img class="bg-info" style="object-fit: cover; border-radius: 10px" height="90px"
                                    width="70px" src="{{ asset("$each->avatar") }}" alt="">
                            </td>
                            <td scope="row" class="col-2">
                                <strong>{{ $each->name }}</strong>
                                <br>
                                Leader: {{ $each->user_name }} - {{ $each->user_nickname }}
                                <br>
                                Members: {{ $each->count_member }}
                                <br>
                                Comics: {{ $each->count_comic }}
                            </td>
                            <td scope="row">
                                {{ $each->description }}
                            </td>
                            <td scope="row" class="col-2">
                                @if ($each->status === 0)
                                    <span class="badge bg-info">{{ $each->status_name }}</span>
                                @elseif ($each->status === 1)
                                    <span class="badge bg-danger">{{ $each->status_name }}</span>
                                @elseif ($each->status === 2)
                                    <span class="badge bg-warning">{{ $each->status_name }}</span>
                                @endif
                            </td>
                            <td scope="row" class="col-2">
                                {{ $each->created_at }}
                            </td>
                            <td scope="row">
                                <a class="btn btn-primary col-10 mb-2"
                                    href="{{ route('admin.teams.show', $each->id) }}">View</a>
                                <form action="{{ route("$table.destroy", $each->id) }}" method="POST" id="form-delete">
                                    @csrf
                                    <button class="btn btn-secondary col-10" onclick="submitDeleted()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if (isAdmin())
        <script>
            const createUser = (each) => {
                let avatar = `<img class="bg-info rounded-circle" style="object-fit: cover" height="85px" width="85px"
                                src="${window.location.origin + each.avatar}" alt="">`
                let gender = ''
                if (each.gender !== null) {
                    gender = each.gender === "Male" ?
                        '<i class="fa-solid fa-mars" style="color: #3688fc"></i>' :
                        '<i class="fa-solid fa-venus" style="color: #fa6767"></i>'
                }

                let info =
                    `
                            <strong>${each.name} ${gender}</strong> - ${each.nickname}
                            <br>
                            Email: ${each.email ? '<a class="link-primary" href="mailto:' + each.email + '">' + each.email + '</a>' : ''}
                            <br>
                            Phone: ${each.phone ? '<a class="link-primary" href="tel:' + each.phone + '">' + each.phone + '</a>' : ''}
                            <br>
                            <strong>Comics</strong>: ${each.sum_comic || 0} - <strong>View</strong>: ${each.sum_view || 0}
                            `;

                let languages = '';
                each.languages.forEach(language => {
                    languages +=
                        `<span class="badge bg-info mb-1">${language.name}</span>`
                })

                let status = '';
                if (each.status === 0) {
                    status +=
                        `<span class="badge bg-primary mb-1">${each.status_name}</span>`
                } else if (each.status === 1) {
                    status +=
                        `<span class="badge bg-danger mb-1">${each.status_name}</span>`
                }

                let action = `
                            <button class="btn btn-primary col-12 mb-1" 
                                onclick="fillFormEditChapter(this)"
                            >
                                Edit
                            </button>
                            <button class="btn btn-secondary col-12" onclick="submitDelete(${each.id})">Delete</button>
                            `;
                const date = new Date(each.created_at);
                const created_at = convertDateToDateTime(date);

                $('#tbody-data').append($('<tr>')
                    .append($('<td>')
                        .append($('<span class="id">')
                            .append(each.id)))
                    .append($('<td>').append(avatar))
                    .append($('<td class="col-3">').append(info))
                    .append($('<td class="col-1">').append(languages))
                    .append($('<td>').append(''))
                    .append($('<td class="col-1">').append(status))
                    .append($('<td class="col-2">').append(each.join_at))
                    .append($('<td class="col-1">').append(action))
                )
            }

            const showDataTable = () => {
                $.ajax({
                    url: "{{ route('api.teams.show', $data->id) }}",
                    dataType: 'json',
                    data: {
                        page: {{ request()->get('page') ?? 1 }},
                        q: $('#search').val() || '',
                        languages: $('#select-language').val() || [],
                        status: $('#select-status').val() || -1,
                    },
                    beforeSend: function() {
                        let loadding = `<div class="d-flex justify-content-center align-items-center position-absolute mt-4 w_100">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>`

                        $('#tbody-data').html(loadding);
                    },
                    success: function(response) {
                        $('#tbody-data').empty();
                        response.data.data.forEach(each => {
                            createUser(each);
                        });
                        renderPagination(response.data.pagination);
                    },
                    error: function(response) {
                        notifyError(response.responseJSON.message);
                    }
                });
            }

            ///Show Data Table First Time
            showDataTable();
        </script>
    @endif
    <script>
        const showModal = (name) => {
            $(`#modal-${name}`).show();
        }

        const closeModal = (name) => {
            $(`#modal-${name}`).hide();
        }

        function submitDeleted() {
            if (confirm('You want to delete this user, right?')) {
                $('#form-delete').submit();
            }
        }

        const filterLanguage = () => {
            showDataTable();
        }

        const submitForm = (name) => {
            const form = $(`#form-${name}`);
            const formData = new FormData(form[0]);
            console.log(formData);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        createUser(response.data);
                    }
                },
                error: function(response) {
                    const erorrs = Object.values(response.responseJSON.errors);
                    showError($('#errors-category'), [erorrs]);
                }
            })
        }

        $(document).ready(function() {
            $("#select-language").select2({
                ajax: {
                    delay: 250,
                    url: `{{ route('api.languages.index') }}`,
                    data: function(params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },

                }
            });

            $("#select-translator-language").select2({
                ajax: {
                    delay: 250,
                    url: `{{ route('api.languages.index') }}`,
                    data: function(params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },

                }
            });

            $('#select-translator').select2({
                ajax: {
                    delay: 250,
                    url: `{{ route('api.users.index') }}`,
                    data: function(params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function(res) {
                        return {
                            results: $.map(res.data.data, function(item) {
                                return {
                                    text: item.name + (item.nickname ?
                                        ' - ' + item.nickname : ''),
                                    id: item.id
                                }
                            })
                        };
                    },

                }
            })

            $('#select-status').change(function() {
                showDataTable();
            })

            $('#close-modal-1, #close-modal-2').click(function() {
                closeModal('create-translator');
            })

            $('#search').keyup(function(e) {
                if (e.keyCode == 13) {
                    $(this).trigger("enterKey");
                }
            });
        });
    </script>
    @if (isAdmin())
        <script>
            $('#search').change(function() {
                showDataTable();
            });
        </script>
    @else
        <script>
            $('#search').bind("enterKey", function(e) {
                let q = $(this).val();
                window.location.href = `{{ route('admin.teams.index') }}?q=${q}`;
            });
        </script>
    @endif
@endpush
