@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/history.css') }}">
    @if (session('locale') == 'vi')
        <style>
            ._line {
                left: 60%;
                width: 42%;
            }

            ._line.left {
                width: 50%;
            }
        </style>
    @endif
@endpush()
@section('content')
    <div class="content">
        <div class="d-flex w_layout d-flex flex-column">
            <h1 class="fw700">{{ __('frontpage.history') }}</h1>
            <div class="_tab _slide mt-4 min_content position-relative">
                <a href="{{ route('reader.library') }}" class="fs22 me-3" id="library">{{ __('frontpage.library') }}</a>
                <a class="fs22" id="history">{{ __('frontpage.history') }}</a>
                <i class="_line"></i>
            </div>
        </div>
    </div>
    <div class="w_layout mt-4">
        <div class="row">
            @foreach ($data as $each)
                <div class="d-flex justify-content-between mb-4 p-2">
                    <a href="{{ route('reader.comics.index', $each->comicSlug) }}" class="a_scale">
                        <img src="{{ asset($each->avatar) }}" alt="" class="img_scale">
                    </a>
                    <div class="d-flex flex-column info mt-1">
                        <a href="{{ route('reader.comics.index', $each->comicSlug) }}">
                            <h4 class="fs20 fw700">{{ $each->alias ? $each->name . " ($each->alias)" : $each->name }}</h4>
                        </a>
                        <a class="btn min_content p-0">
                            <span
                                class="badge rounded-pill badge_cate">{{ __('categories.' . strtolower($each->category)) }}</span>
                        </a>
                        <div class="rate">
                            @for ($i = 0; $i < 5; $i++)
                                <i
                                    class="fas fa-star fs12
                                    @if ($i + 1 < $each->rate) _on @endif"></i>
                            @endfor
                            <span class="ms-1">{{ $each->rate }}</span>
                        </div>
                        <p class="text-ellipsis" style="-webkit-line-clamp: 2;">{{ $each->description }}</p>
                        <div
                            class="d-flex
                                    align-items-center justify-content-between mt-2">
                            <p>
                                <span class="fs20 number">{{ $each->chapterNumber }}</span>
                                /
                                <span class="chapter_total">{{ $each->chapterTotal }}</span>
                                {{ ucwords(__('frontpage.progress')) }}
                            </p>
                            <div class="d-flex align-items-center justify-content-between" style="min-width: 41%">
                                <a href="{{ route('reader.comics.show_chapter', [$each->comicSlug, $each->chapterSlug]) }}"
                                    class="a_hover fs18 me-4">
                                    {{ __('frontpage.continue_reading') }}
                                    <i class="fa-solid fa-angles-right fs12"></i>
                                </a>
                                @isset($each->addedLibraries)
                                    <a class="read_now cursor_pointer"
                                        onclick="removeFromLibrary(this, {{ $each->comicId }},
                                                '{{ strtoupper(__('frontpage.add_to_library')) }}',
                                                '{{ strtoupper(__('frontpage.in_library')) }}')">
                                        <b>
                                            <span class="fas fa-check me-1" id="icon"></span>
                                            <span id="text" class="text_uppercase">
                                                {{ __('frontpage.in_library') }}
                                            </span>
                                        </b>
                                    </a>
                                @else
                                    <a class="read_now cursor_pointer"
                                        onclick="addToLibrary(this, {{ $each->comicId }}, 
                                                '{{ strtoupper(__('frontpage.in_library')) }}',
                                                '{{ strtoupper(__('frontpage.add_to_library')) }}')">
                                        <b>
                                            <span class="fas fa-plus me-1" id="icon"></span>
                                            <span id="text" class="text_uppercase">
                                                {{ __('frontpage.add_to_library') }}
                                            </span>
                                        </b>
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('js')
    <script>
        const addToLibrary = (e, comicId, text1, text2) => {
            $.ajax({
                url: "{{ route('api.users.add_library') }}",
                type: "POST",
                data: {
                    comicId: comicId,
                },
                beforeSend: function() {
                    $(e).find('#icon')
                        .removeClass('fa-plus')
                        .removeClass('fa-check')
                        .addClass('fa-solid fa-spinner')
                        .css('animation', 'spinner-border 1s infinite linear');
                    $(e).find('#text')
                        .text('LOADING...')
                },
                success: function(response) {
                    if (response.success) {
                        $(e).attr('onclick', `removeFromLibrary(this, ${comicId}, '${text2}', '${text1}')`);
                        $(e).find('#icon')
                            .css('animation', 'none')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-check');
                        $(e).find('#text')
                            .text(text1);
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).find('#icon')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-plus')
                            .css('animation', 'none');
                    }
                }
            })
        }

        const removeFromLibrary = (e, comicId, text1, text2) => {
            $.ajax({
                url: "{{ route('api.users.remove_library') }}",
                type: "POST",
                data: {
                    comicId: comicId,
                },
                beforeSend: function() {
                    $(e).find('#icon')
                        .removeClass('fa-plus')
                        .removeClass('fa-check')
                        .addClass('fa-solid fa-spinner')
                        .css('animation', 'spinner-border 1s infinite linear');
                    $(e).find('#text')
                        .text('LOADING...')
                },
                success: function(response) {
                    if (response.success) {
                        $(e).attr('onclick', `addToLibrary(this, ${comicId}, '${text2}', '${text1}')`);
                        $(e).find('#icon')
                            .css('animation', 'none')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-plus');
                        $(e).find('#text')
                            .text(text1);
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).find('#icon')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-check')
                            .css('animation', 'none');
                    }
                }
            })
        }
    </script>
    <script>
        $(document).ready(function() {
            currentUrl = window.location.href;
            currentUrl.includes('library') ? $('#library').addClass('active') : $('#history').addClass('active');
            if ($('#library').hasClass('active')) {
                $('#library').addClass('fw700');
            } else if ($('#history').hasClass('active')) {
                $('#history').addClass('fw700');
            }

            $('#library').mouseenter(function() {
                $('._line').addClass('left');
            });
            $('#library').mouseout(function() {
                $('._line').removeClass('left');
            });

            $('.number').each(function() {
                if (isInt($(this).text())) {
                    $(this).text(parseInt($(this).text()));
                }
            })
            $('.chapter_total').each(function() {
                if (isInt($(this).text())) {
                    $(this).text(parseInt($(this).text()));
                }
            })
        });
    </script>
@endpush()
