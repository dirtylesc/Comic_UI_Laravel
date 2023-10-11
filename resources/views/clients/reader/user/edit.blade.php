@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/style_user.css') }}">
    <style>
        .ck-editor__editable {
            height: 130px;
            width: 500px;
            padding-left: 16px !important;
            overflow-y: scroll !important;
        }

        .ck-editor__editable p:not(.ck-placeholder) {
            height: fit-content !important;
        }

        .ck.ck-content.ck-focused:not(.ck-editor__nested-editable),
        .ck.ck-editor__editable_inline {
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .ck.ck-editor__main {
            border: 1px solid #e0e0e0;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #fff !important;
        }
    </style>
@endpush
@section('content')
    <div class="header">
        <div class="wrapper w_layout position-relative">
            <img src="{{ asset('images/reader-default-banner.svg') }}" alt="">
            <i class="wrapper_mask w_100 h_100 top_0 left_0 position-absolute "></i>
        </div>
        <div class="info w_layout position-relative mb-5">
            <div class="position-absolute d-flex px-4 w_100">
                <form>
                    <input type="file" id="avatarUpdated" style="display: none"
                        oninput="avatar.src=window.URL.createObjectURL(this.files[0])">
                </form>
                <label>
                    <a onclick="openInputFile()" class="cursor_pointer" id="a_scale">
                        <img class="img_scale" id="currentAvatar" src="{{ asset($user->avatar) }}" alt="">
                        <i class="fa-solid fa-camera"></i>
                    </a>
                </label>
                <ul class="d-flex flex-grow-1">
                    <li class="d-flex flex-column align-items-center col-6 stat">
                        <strong class="fw600 fs32 c_fff"> - h </strong>
                        <small class="fs12">of Reading</small>
                    </li>
                    <li class="d-flex flex-column align-items-center col-6 stat">
                        <strong class="fw600 fs32 c_fff"> {{ $user->comicCount ?? 0 }} </strong>
                        <small class="fs12">Read comics</small>
                    </li>
                </ul>
            </div>
        </div>
        @include('clients.reader.user.modal_edit_avatar')
        <div class="form-edit row w_layout">
            <form action="{{ route('api.profiles.update', user()->id) }}" id="form-edit">
                <div class="form-group d-flex align-items-center">
                    <strong>Nickname</strong>
                    <input name="nickname" id="nickname" type="text" value="{{ $user->nickname }}">
                </div>
                <div class="form-group d-flex align-items-center">
                    <strong>Full Name</strong>
                    <input name="name" id="name" type="text" value="{{ $user->name }}">
                </div>
                <div class="form-group d-flex align-items-center">
                    <strong>Email Address</strong>
                    <input name="email" id="email" type="text" placeholder="Add email to receive notification">
                </div>
                <div class="gender form-group d-flex align-items-center">
                    <strong>Gender</strong>
                    <div class="d-flex align-items-center">
                        @foreach ($arrGender as $gender => $val)
                            <label class="mb-0 me-5" id="gender">
                                <i class="position-relative">
                                    <input type="radio" name="gender" value="{{ $val }}"
                                        @if ((int) $user->gender === $val) checked @endif>
                                    <b class="position-absolute"></b>
                                </i>
                                <strong class="fw400 ms-2">{{ $gender }}</strong>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="location form-group d-flex align-items-center">
                    <strong>Location</strong>
                    <label class="position-relative">
                        <select name="location" id="select-country" class="pe-2" id="location">
                            <option value="Global">Global</option>
                        </select>
                    </label>
                </div>
                <div class="form-group d-flex">
                    <strong>About</strong>
                    <textarea name="description" id="editor" cols="50" rows="4" placeholder="Decribe yourself">
                        {{ $user->description }}
                    </textarea>
                </div>
            </form>
            <div class="form-group text_center me-5">
                <button class="btn bg-primary c_fff disabled" id="btn-update" onclick="submitForm(edit)">Save
                    Changes</button>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
    <script>
        const showModal = (name) => {
            $(`#modal-${name}`).modal('show')
        }

        const closeModal = (name) => {
            $(`#modal-${name}`).modal('hide')
        }

        const openInputFile = () => {
            $('#avatarUpdated').click();
        }

        const submitForm = (name) => {
            const form = $(`#form-${name}`);
            const formData = new FormData(form[0]);

            if (name === "edit") {
                formData.set('description', $(`#form-edit .ck.ck-content`).html());
            } else if (name === "edit-avatar") {
                formData.set('avatar', $('#avatarUpdated')[0].files[0]);
            }

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        if (name === "edit") {
                            $('#btn-update').addClass('disabled');
                        } else if (name === "edit-avatar") {
                            $('#currentAvatar').attr('src', window.location.origin + '/' + response.data);
                            $('#h_avatar').attr('src', window.location.origin + '/' + response.data);
                            $('#hc_avatar').attr('src', window.location.origin + '/' + response.data);
                            closeModal(name);
                        }
                    }
                },
                error: function(response) {}
            });
        }

        $(document).ready(async function() {
            $("#city").select2({
                tags: true
            });
            const response = await fetch('{{ asset('locations/index.json') }}');
            const countries = await response.json();
            $.each(countries, function(index, each) {
                let location = "{{ $user->location }}";

                $("#select-country").append(`
                <option value='${index}' data-path='${each.code}' ${location === index ? "selected" : ''}>
                    ${index}
                </option>`)
            })

            $('#nickname , #name , #email, .ck.ck-content').on('keyup', function() {
                console.log($('#nickname').val(), $('#name').text().trim());
                if ($('#nickname').val() != '' && $('#name').text().trim() != '') {
                    $('#btn-update').removeClass('disabled');
                } else {
                    $('#btn-update').addClass('disabled');
                }
            })

            $('#select-country, #gender').on('change', function() {
                $('#btn-update').removeClass('disabled');
            })

            $('#avatarUpdated').change(function() {
                showModal('edit-avatar');
            })
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [],
                autosave: {
                    save(editor) {
                        return saveData(editor.getData());
                    }
                }
            })
            .then(editor => {
                window.editor = editor;
                $('.ck-reset_all').remove();

                displayStatus(editor);
            })
            .catch(err => {
                console.error(err.stack);
            });

        // Save the data to a fake HTTP server (emulated here with a setTimeout()).
        function saveData(data) {
            return new Promise(resolve => {
                setTimeout(() => {
                    console.log('Saved', data);

                    resolve();
                }, HTTP_SERVER_LAG);
            });
        }

        // Update the "Status: Saving..." info.
        function displayStatus(editor) {
            const pendingActions = editor.plugins.get('PendingActions');
            const statusIndicator = document.querySelector('#editor-status');

            pendingActions.on('change:hasAny', (evt, propertyName, newValue) => {
                if (newValue) {
                    statusIndicator.classList.add('busy');
                } else {
                    statusIndicator.classList.remove('busy');
                }
            });
        }
    </script>
@endpush
