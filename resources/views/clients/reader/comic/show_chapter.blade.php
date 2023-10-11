<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reader/read_comic.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reader/style.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&family=Roboto:wght@300&display=swap"
        rel="stylesheet" />
    @include('libraries')
    <title>Đồ Án Cơ Sở 1</title>
</head>

<body>
    @include('layouts.reader.login_form')
    <div class="top">
        <div class="left align-items-center">
            <div class="logo d-flex align-items-center">
                <a href="{{ route('reader.index') }}">
                    <h2 class="mb-0 fs20 text_decoration_none c_black lh_0">DIRTYLESC</h2>
                </a>
            </div>
            <div class="title">
                <h4 class="fw700 fs17 mb-0">
                    <a href="{{ route('reader.comics.index', $data->slug) }}">
                        @if ($data->alias)
                            {{ $data->name }} - ( {{ $data->alias }} )
                        @else
                            {{ $data->name }}
                    </a>
                    @endif / Chapter
                    <span id="chapter_number">{{ $data->chapter->number }}</span>
                    : {{ $data->chapter->title }}
                </h4>
            </div>
        </div>
        <div class="right">
            <div class="library_forum">
                <a href="{{ route('reader.library') }}">
                    <p>Library</p>
                </a>
                <a href="">
                    <p>Forum</p>
                </a>
                <i class="fas fa-browser fs14"></i>
            </div>
            <div class="user-function g_hd_link ms-3">
                @if (!auth()->check())
                    <div class="log_in d-flex align-items-center justify-content-center" style="cursor: pointer;">
                        <a href="###">Sign In</a>
                    </div>
                @else
                    <div class="user_login">
                        <input type="checkbox" id="user_up">
                        <label for="user_up">
                            <img src="{{ asset(user()->avatar) }}" alt="">
                        </label>
                        <div class="function">
                            <div class="d-flex py-3" style="padding: 5px 15px;">
                                <a href="{{ route('reader.profiles.show', user()->id) }}">
                                    <img src="{{ asset(user()->avatar) }}" alt="">
                                </a>
                                <div class="ms-3">
                                    <a id="name" href="{{ route('reader.profiles.show', user()->id) }}">
                                        <p class="c_fff fw700">{{ user()->name }}</p>
                                    </a>
                                </div>
                            </div>
                            <ul id="user_down" class="mt-3 mb-0 ps-0">
                                <li>
                                    <strong class="lh_22">Earn Rewards</strong>
                                    <small class="fs12 c_xs lh_18">by check-in and more</small>
                                </li>
                                <li>
                                    <a href="{{ route('reader.profiles.show', user()->id) }}" class="ms-0">My
                                        Profile</a>
                                </li>
                                <li><a href="" class="ms-0">Credit Card</a></li>
                                <li><a href="" class="ms-0">Help</a></li>
                                <li id="log_out_btn">
                                    <a href="{{ route('logout') }}" class="ms-0">Sign Out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="middle">
        <div class="reading_detail">
        </div>
        <div class="mid_function">
            <div class="function">
                <i class="fas fa-bars"></i>
                <i class="fas fa-cog"></i>
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="bg_function">
                <div class="title">
                    <h1>Display Options</h1>
                    <p>Background</p>
                    <div class="bg_color">
                        <span id="s1"></span>
                        <span id="s2"></span>
                        <span id="s3"></span>
                    </div>
                </div>
            </div>
            <div class="chapter_function">
                <div class="title">
                    <h1>Table of Contents</h1>
                    <p>Comic Chapters</p>
                    <div class="chapters">
                        @foreach ($chapters as $chapter)
                            <a href="{{ route('reader.comics.show_chapter', [$data->slug, $chapter->slug]) }}"
                                @if ($chapter->id == $data->chapter->id) class="now_ch" @endif>
                                <span>{{ floatToInt($chapter->number) }}</span>
                                <strong>{{ $chapter->title }}</strong>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/helper.js') }}"></script>
<script src="{{ asset('js/reader/login_register.js') }}"></script>
<script type="module" src="{{ asset('js/reader/app_comic.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('api.chapters.get_images', ['id' => $data->chapter->id]) }}",
            type: "GET",
            success: function(data) {
                let html = '';
                data.data.forEach((element, n) => {
                    html += `
                        <div id="page" class="page-chapter">
                            <img alt="{{ $data->name }} Chap {{ $data->chapter->number }} - Trang ${n + 1}" data-index="${n + 1}"
                                width="55%"
                                src="{{ asset('storage') }}/${element.link}"
                                data-cdn="//cdn.ntcdntempv26.com/data/images/27946/547315/001" />
                        </div>
                    `
                });
                $('.reading_detail').html(html);
            },
            error: function() {}
        })

        if ($('#chapter_number').text()[$('#chapter_number').text().length - 1] == 0) {
            $('#chapter_number').text(parseInt($('#chapter_number').text()));
        }
    })
</script>
@if (auth()->check())
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('api.users.history') }}",
                data: {
                    chapterId: {{ $data->chapter->id }},
                    comicId: {{ $data->id }}
                },
                type: "POST",
            })
        })
    </script>
@endif

</html>
