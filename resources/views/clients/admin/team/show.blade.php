@extends('layouts.admin.master')
@section('content-header')
    @include('layouts.admin.content_header')
@endsection
@push('css')
    <style>
        .badge {
            padding: .4em .7em !important;
            font-size: .8rem;
            letter-spacing: 1px;
        }
    </style>
@endpush
@section('content-wrapper')
    <div class="content-wrapper m-4">
        <div class="d-flex mb-2">
            <div class="col-md-2">
                <img style="width: 200px" src="{{ asset($data->avatar) }}" class="card-img" alt="...">
            </div>
            <div class="d-flex col-md-8">
                <div class="row no-gutters col-6">
                    <div class="card-body pt-1">
                        <h4 class="card-title mb-0">{{ $data->name }}</h4>
                        <p class="card-text"><small class="text-muted"
                                style="font-size: .9rem">{{ $data->description }}</small>
                        </p>
                        <br>
                        <p class="card-text" style="font-size: 1rem; font-weight: 500">
                            <strong>Leader: </strong><a
                                href="{{ route('admin.users.show', $data->user_id) }}">{{ $data->user_name }}</a> -
                            {{ $data->user_nickname }}
                            <br>
                            <strong>Number of members: </strong>{{ $data->count_member }}
                            <br>
                        </p>
                    </div>
                </div>
                <div class="row no-gutters col-6">
                    <div class="card-body pt-1">
                        <h4 class="card-title mb-0">Comics</h4>
                        <br>
                        <p class="card-text">
                            <strong>Number of comics: </strong>{{ $data->count_comic }}
                            <br>
                            <strong>Reaction: </strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Info</th>
                    <th scope="col">Language</th>
                    <th scope="col">Achievement</th>
                    <th scope="col">Join At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody-data">
            </tbody>
        </table>
    </div>
@endsection
@push('js')
    <script>
        const showDataTable = () => {
            $.ajax({
                url: "{{ route('api.teams.show', $data->id) }}",
                dataType: 'json',
                data: {
                    page: {{ request()->get('page') ?? 1 }},
                    q: $('#search').val() || '',
                },
                success: function(response) {
                    $('#tbody-data').empty();
                    response.data.data.forEach(each => {
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
                            .append($('<td class="col-2">').append(each.join_at))
                            .append($('<td class="col-1">').append(action))
                        )
                    });
                    renderPagination(response.data.pagination);
                },
                error: function(response) {
                    notifyError(response.responseJSON.message);
                }
            });
        }

        $(document).ready(function() {
            showDataTable();
        });
    </script>
@endpush
