@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/library.css') }}">
    @if (session('locale') == 'vi')
        <style>
            ._line {
                width: 50%;
            }

            ._line.right {
                left: 60%;
                width: 42%;
            }
        </style>
    @endif
@endpush()
@section('content')
    <div class="content mt-5">
        <div class="d-flex w_layout d-flex flex-column">
            <h1 class="fw700">{{ __('frontpage.library') }}</h1>
            <div class="_tab _slide mt-4 min_content position-relative">
                <a href="" class="fs22 me-3" id="library">{{ __('frontpage.library') }}</a>
                <a href="{{ route('reader.history') }}" class="fs22" id="history">{{ __('frontpage.history') }}</a>
                <i class="_line"></i>
            </div>
        </div>
    </div>
    <div class="d-flex w_layout mt-5 flex-wrap">
        @foreach ($data as $each)
            <div id="comic" class="col-2 mb-5 position-relative">
                @if ($each->chapterNumber == null)
                    <i class="_dot"></i>
                @endif
                <a href="{{ $each->chapterSlug ? route('reader.comics.show_chapter', [$each->comicSlug, $each->chapterSlug]) : '' }}"
                    class="a_scale">
                    <img class="w_100 img_scale" src="{{ asset($each->avatar) }}" alt="">
                </a>
                <a
                    href="{{ $each->chapterSlug ? route('reader.comics.show_chapter', [$each->comicSlug, $each->chapterSlug]) : '' }}">
                    <h4 class="fw700 fs16 text-ellipsis mt-1 mb-0" id="name" style="-webkit-line-clamp: 2">
                        {{ $each->name }}
                    </h4>
                </a>
                <span class="fw400 fs15" style="color: var(--c_s)">
                    {{ __('frontpage.progress') }} <span class="number">{{ $each->chapterNumber ?? 0 }}</span>
                    /
                    <span class="chapter_total">{{ $each->chapterTotal ?? 0 }}</span>
                </span>
            </div>
        @endforeach
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            currentUrl = window.location.href;
            currentUrl.includes('library') ? $('#library').addClass('active') : $('#history').addClass('active');
            if ($('#library').hasClass('active')) {
                $('#library').addClass('fw700');
            } else if ($('#history').hasClass('active')) {
                $('#history').addClass('fw700');
            }

            $('#history').mouseenter(function() {
                $('._line').addClass('right');
            });
            $('#history').mouseout(function() {
                $('._line').removeClass('right');
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
