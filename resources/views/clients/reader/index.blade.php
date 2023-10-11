@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
@endpush
@section('content')
    <div class="weekly_book px-0 w_layout wide">
        <div class="row">
            <div class="left col l-6 m-6 c-6">
                <h3 class="fs24 fw700">{{ __('frontpage.weekly_comic') }}</h3>
                <div class="slider">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <div class="slides">
                        @foreach ($weeklyComics as $each)
                            <a class="slide @if ($loop->first) first @endif"
                                href="{{ route('reader.comics.index', $each->link) }}">
                                <img class="bg_slide" src="{{ asset($each->file) }}" alt="">
                            </a>
                        @endforeach
                    </div>
                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        {{-- <div class="auto-btn3"></div> --}}
                    </div>
                    <div class="navigation-manual">
                        <label for="radio1" class="manual-btn"></label>
                        <label for="radio2" class="manual-btn"></label>
                        {{-- <label for="radio3" class="manual-btn"></label> --}}
                    </div>
                </div>
            </div>
            <div class="right col l-6 m-6 c-6">
                <h3 class="fw700">{{ __('frontpage.recent_activities') }}</h3>
                <div class="list">
                    <div class="activity">
                        <a href="" title="{{ __('frontpage.let_read_together') }}">
                            <div class="ac-left">
                                <h4>{{ __('frontpage.let_read_together') }}</h4>
                                <p class=" fs14">{{ __('frontpage.read_and_chat_here') }}</p>
                            </div>
                            <div class="ac-right">
                                <img src="" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="activity">
                        <a href="" title="{{ __('frontpage.wsa_2021_winners') }}">
                            <div class="ac-left">
                                <h4>{{ __('frontpage.wsa_2021_winners') }}</h4>
                                <p class=" fs14">{{ __('frontpage.see_the_winners_of_dirtylesc_spirity_awards_2022') }}
                                </p>
                            </div>
                            <div class="ac-right">
                                <img src="" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="activity">
                        <a href="" title="Writing Prompts Contest #271 #272">
                            <div class="ac-left">
                                <h4></h4>
                                <p class=" fs14"></p>
                            </div>
                            <div class="ac-right">
                                <img src="" alt="">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="weekly_featured w_layout">
        <div class="text">
            <h3 class="fs24 fw700">{{ __('frontpage.weekly_featured') }}</h3>
        </div>
        <div class="featured">
            <div class="left g_col _3">
                <div class="change_img">
                    @for ($i = 0; $i < 3; $i++)
                        <p data-index="{{ $i }}"><img src="{{ asset($featuredComics[$i]->avatar) }}"
                                alt=""></p>
                    @endfor
                </div>
                <div class="review_img">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="review @if ($i === 0) _on @endif">
                            <div class="title flex-column">
                                <a href="{{ route('reader.comics.index', $featuredComics[$i]->slug) }}">
                                    <h4 class="fs20 mb-0">{{ $featuredComics[$i]->name }}</h4>
                                </a>
                                <div class="abc">
                                    <p class="fs14 mb-0">
                                        {{ __('categories.' . optional(optional($featuredComics[$i]->categories)[0])->slug) }}
                                    </p>
                                    ·<h6 class="mb-0 ms-1"> {{ $featuredComics[$i]->alias }}</h6>
                                </div>
                            </div>
                            <p class="fs14 x fs14 text-ellipsis" style="-webkit-line-clamp: 6;">
                                {{ $featuredComics[$i]->description }}
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="right">
                <div class="list_featured">
                    @for ($i = 3; $i < count($featuredComics); $i++)
                        <div class="item">
                            <a href="{{ route('reader.comics.index', $featuredComics[$i]->slug) }}" class="picture">
                                <img src="{{ asset($featuredComics[$i]->avatar) }}" alt="">
                            </a>
                            <h4 class="fs14">
                                <a href="{{ route('reader.comics.index', $featuredComics[$i]->slug) }}"
                                    title="{{ $each->name }}">
                                    {{ $featuredComics[$i]->name }}
                                </a>
                            </h4>
                            <p class="fs14 text-ellipsis" style="">
                                <a href="###" title="{{ $each->name }}">
                                    {{ __('categories.' . optional(optional($featuredComics[$i]->categories)[0])->slug) }}
                                </a>
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="weekly_special w_layout">
        <div class="special">
            <div class="left">
                <a href=""><img src="{{ asset($banner->file) }}" alt=""></a>
            </div>
            <div class="right">
                <h3 class="fs24 fw700">{{ __('frontpage.special_for_you') }}</h3>
                <div class="bottom">
                    <div class="special_img">
                        <a href="{{ route('reader.comics.index', $specialComic->slug) }}">
                            <img src="{{ asset($specialComic->avatar) }}" alt="">
                        </a>
                    </div>
                    <div class="title">
                        <a href="{{ route('reader.comics.index', $specialComic->slug) }}">
                            <h4 class="fs20 fw600">{{ $specialComic->name }}</h4>
                        </a>
                        <h5 class="fs12 mb-0">
                            @for ($i = 0; $i < 3; $i++)
                                {{ !empty($specialComic->categories[$i])
                                    ? __('categories.' . optional(optional($specialComic->categories)[$i])->slug)
                                    : '' }}
                            @endfor
                        </h5>
                        <i class="fas fa-star fs12 lc1_5"> {{ $specialComic->rate }}</i>
                        <p class="fs12 mb-2">{{ $specialComic->description }}
                        </p>
                        <div class="read_now d-flex">
                            <a
                                href="{{ route('reader.comics.show_chapter', [$specialComic->slug, $specialComic->chapter_slug]) }}">
                                <b class="fs14 text_uppercase">{{ __('frontpage.read_now') }}</b>
                            </a>
                            <i class="fas fa-plus ms-2" onclick="addToLibrary(this, {{ $specialComic->id }})"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="checkbox" style="display: none;" id="ex_more">
    <div class="weekly_ranking w_layout">
        <div class="text">
            <h3 class="fs24 fw700">{{ __('frontpage.ranking') }}</h3>
            <a href="">
                <p class="fs14 fw600 text_uppercase">{{ __('frontpage.more') }}</p>
            </a>
        </div>
        <div class="list_ranking_ col-md-12">
            <div class="power_ranking col-md-4">
                <div class="title">
                    <h4 class="fs20 fw700 text-white">{{ __('frontpage.power_ranking') }}</h4>
                </div>
                <div class="list_ranking _1">
                    @foreach ($powerRankingComics as $key => $each)
                        <div class="ranking">
                            <a class="ranking_img" href="{{ route('reader.comics.index', $each->slug) }}">
                                <img src="{{ asset($each->avatar) }}" alt=""></a>
                            <h3
                                class="fs16 ff_number lc1_5
                                        @if ($key == 0) c_secondary 
                                        @elseif ($key == 1) c_tertiary 
                                        @elseif ($key == 2) c_quaternary
                                        @else c_m @endif">
                                {{ $key + 1 < 10 ? '0' . ($key + 1) : $key + 1 }}
                            </h3>
                            <div class="review_">
                                <h4 class="fs16 fw700">
                                    <a href="{{ route('reader.comics.index', $each->slug) }}"
                                        title="{{ $each->name }}">{{ $each->name }}</a>
                                </h4>
                                <p class="fs12 fw400">
                                    <a href=""
                                        title="{{ __('categories.' . optional(optional($each->categories)[0])->slug) }}">
                                        {{ __('categories.' . optional(optional($each->categories)[0])->slug) }}
                                    </a>
                                </p>
                                <i class="fas fa-star fs12 lc1_5"> {{ $each->rate ?? 0 }}</i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="new_ranking col-md-4 ms-3">
                <div class="title">
                    <h4 class="fs20 fw700 text-white">{{ __('frontpage.new') }}</h4>
                </div>
                <div class="list_ranking _2">
                    @foreach ($newComics as $key => $each)
                        <div class="ranking">
                            <a class="ranking_img" href="{{ route('reader.comics.index', $each->slug) }}">
                                <img src="{{ asset($each->avatar) }}" alt=""></a>
                            <h3
                                class="fs16 ff_number lc1_5 
                                    @if ($key == 0) c_secondary 
                                    @elseif ($key == 1) c_tertiary 
                                    @elseif ($key == 2) c_quaternary
                                    @else c_m @endif">
                                {{ $key + 1 < 10 ? '0' . ($key + 1) : $key + 1 }}
                            </h3>
                            <div class="review_">
                                <h4 class="fs16 fw700">
                                    <a href="{{ route('reader.comics.index', $each->slug) }}"
                                        title="{{ $each->name }}">{{ $each->name }}</a>
                                </h4>
                                <p class="fs12 fw400">
                                    <a href=""
                                        title="{{ __('categories.' . optional(optional($each->categories)[0])->slug) }}">
                                        {{ __('categories.' . optional(optional($each->categories)[0])->slug) }}
                                    </a>
                                </p>
                                <i class="fas fa-star fs12 lc1_5"> {{ $each->rate ?? 0 }}</i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="collection_ranking col-md-4 ms-3">
                <div class="title">
                    <h4 class="fs20 fw700 text-white">{{ __('frontpage.collection_ranking') }}</h4>
                </div>
                <div class="list_ranking _3">
                    @foreach ($collectionRankingComics as $key => $each)
                        <div class="ranking">
                            <a class="ranking_img" href="{{ route('reader.comics.index', $each->slug) }}">
                                <img src="{{ asset($each->avatar) }}" alt=""></a>
                            <h3
                                class="fs16 ff_number lc1_5 
                                    @if ($key == 0) c_secondary 
                                    @elseif ($key == 1) c_tertiary 
                                    @elseif ($key == 2) c_quaternary
                                    @else c_m @endif">
                                {{ $key + 1 < 10 ? '0' . ($key + 1) : $key + 1 }}
                            </h3>
                            <div class="review_">
                                <h4 class="fs16 fw700">
                                    <a href="{{ route('reader.comics.index', $each->slug) }}"
                                        title="{{ $each->name }}">{{ $each->name }}</a>
                                </h4>
                                <p class="fs12 fw400">
                                    <a href=""
                                        title="{{ __('categories.' . optional(optional($each->categories)[0])->slug) }}">
                                        {{ __('categories.' . optional(optional($each->categories)[0])->slug) }}
                                    </a>
                                </p>
                                <i class="fas fa-star fs12 lc1_5"> {{ $each->rate ?? 0 }}</i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="extends_more">
        <label for="ex_more">
            <h3 class="fs14 fw600">{{ __('frontpage.extend_more') }}</h3>
        </label>
    </div>
    <div class="potential_starlet">
        <div class="starlets">
            <h3 class="fs24 fw700" style="border-bottom: 1px solid #d7d8e0; padding: 50px 0 20px 0;">
                {{ __('frontpage.compeleted_comic') }}
            </h3>
            <div class="list_starlet">
                @foreach ($compeletedComics as $each)
                    <div class="starlet">
                        <a href="{{ route('reader.comics.index', $each->slug) }}">
                            <img src="{{ $each->avatar }}" alt="{{ $each->avatar }}">
                        </a>
                        <h4 class="fs16 text-ellipsis mt-2 fw600">
                            <a href="{{ route('reader.comics.index', $each->slug) }}" title="{{ $each->name }}">
                                {{ $each->name }} </a>
                        </h4>
                        <p class="fs14 fw400">
                            <a href=""
                                title="{{ __('categories.' . optional(optional($each->categories)[0])->slug) }}">
                                {{ __('categories.' . optional(optional($each->categories)[0])->slug) }}
                            </a>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="under pe-0">
        <div class="rising_fictions w_layout">
            <div class="left">
                <h3 class="fs24 fw700">{{ __('frontpage.rising_fictions') }}</h3>
                <div class="lists">
                    <div class="list_fictions">
                        @foreach ($risingFictions as $each)
                            <div class="fiction @if ($loop->first) active @endif">
                                <p class="position-relative"><img src="{{ $each->avatar }}" alt=""></p>
                            </div>
                        @endforeach
                    </div>
                    <div class="fictions_reviews pt-4">
                        @foreach ($risingFictions as $each)
                            <div class="fictions_review">
                                <div class="fictions_img">
                                    <a href="{{ route('reader.comics.index', $each->slug) }}">
                                        <img src="{{ asset($each->avatar) }}" alt="">
                                    </a>
                                </div>
                                <div class="title">
                                    <h4 class="fs20 mb-0 text-ellipsis">{{ $each->name }}</h4>
                                    <h5 class="fs12 mb-0">
                                        {{ !empty($each->categories[0]) ? __('categories.' . optional(optional($each->categories)[0])->slug) : '' }}
                                    </h5>
                                    <i class="fas fa-star fs12 lc1_5"> {{ $each->rate ?? 0 }}</i>
                                    <p class="fs12 mb-0 text-ellipsis">{{ $each->description }}</p>
                                    <div class="read_now d-flex mt-2">
                                        <a
                                            href="{{ route('reader.comics.show_chapter', [$each->slug, $each->chapter_slug]) }}">
                                            <b class="fs14 text_uppercase">{{ __('frontpage.read_now') }}</b>
                                        </a>
                                        <i class="fas fa-plus ms-2"
                                            onclick="addToLibrary(this, {{ $each->id }})"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="right">
                <h3 class="fs24 fw700">{{ __('frontpage.cheering_reads') }}</h3>
                <div class="cheering_reads">
                    @foreach ($cherringReads as $each)
                        <div class="cheering">
                            <a href="{{ route('reader.comics.index', $each->slug) }}">
                                <img src="{{ asset($each->avatar) }}" alt="">
                            </a>
                            <div class="text">
                                <a href="">
                                    <h4 class="fs14 fs700 text-ellipsis mb-0">{{ $each->name }}</h4>
                                </a>
                                <a href="{{ route('reader.comics.index', $each->slug) }}">
                                    <p class="fs12 fs400">
                                        {{ !empty($each->categories[0]) ? __('categories.' . optional(optional($each->categories)[0])->slug) : '' }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="O_B_B w_layout">
            <div class="o_b_b">
                <div class="text">
                    <h3 class="fs20 fw700">Original Stories</h3>
                    <p class="fs16 fw400">A Webnovel site for everyone.</p>
                </div>
                <a href="">
                    <img src="{{ asset('storage/images/OriginalStories.jpg') }}" alt=""
                        title="Original Stories">
                </a>
            </div>
            <div class="o_b_b">
                <div class="text">
                    <h3 class="fs20 fw700">Becoming an Author</h3>
                    <p class="fs16 fw400">Write novels. Get paid.</p>
                </div>
                <a href="">
                    <img src="{{ asset('storage/images/BecomingAnAuthor.jpg') }}" alt=""
                        title="Becoming an Author">
                </a>
            </div>
            <div class="o_b_b">
                <div class="text">
                    <h3 class="fs20 fw700">Book of Authors</h3>
                    <p class="fs16 fw400">A guide on how to become a popular author.</p>
                </div>
                <a href="">
                    <img src="{{ asset('storage/images/BookOfAuthors.jpg') }}" alt="" title="Book of Authors">
                </a>
            </div>
        </div>
        <div class="popular_tags w_layout">
            <div class="title">
                <h3 class="fs24 fw700">{{ __('frontpage.popular_tags') }}</h3>
                <h4 class="fs16 fw600 text_uppercase">{{ __('frontpage.more') }}</h4>
            </div>
            <div class="list_tags">
                @foreach ($popularTags as $item)
                    <div class="tag">
                        <a href="{{ route('reader.tags.index', $item->slug) }}" title="{{ $item->name }}">
                            <h3 class="fs14 fw600">{{ $item->name }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @if (!user())
            <div class="signup_email">
                <div class="w_layout_email position-relative d-flex justify-content-center align-items-center">
                    <div class="naruto_img"><img src="{{ asset('storage/images/naruto.png') }}" alt=""></div>
                    <div class="text">
                        <h3 class="fw700 cl9">{{ __('frontpage.send_email_title') }}</h3>
                        <p class="fs18 fw500 cl6">{{ __('frontpage.send_email_text') }}</p>
                    </div>
                    <div class="email">
                        <form action="{{ route('api.users.sign_up_notification') }}" method="POST" class="d-flex"
                            id="myForm">
                            <input type="email" name="email"
                                placeholder="{{ __('frontpage.send_email_placeholder') }}" class="cl6">
                            <a class="cursor_pointer" onclick="document.getElementById('myForm').submit()">
                                <h4 class="fs18 fw600 mb-0 mt-1">{{ __('frontpage.sign_up') }}</h4>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('js')
    <script>
        const addToLibrary = (e, comicId) => {
            $.ajax({
                url: "{{ route('api.users.add_library') }}",
                type: "POST",
                data: {
                    comicId: comicId,
                },
                beforeSend: function() {
                    $(e).removeClass('fa-plus')
                        .removeAttr('onclick')
                        .addClass('fa-solid fa-spinner')
                        .css('animation', 'spinner-border 1s infinite linear');
                },
                success: function(response) {
                    if (response.success) {
                        $(e).removeClass('fa-plus')
                            .addClass('fa-check disabled')
                            .css('animation', 'none');
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).removeClass('fa-plus')
                            .addClass('fa-check disabled')
                            .css('animation', 'none');
                    }
                }
            })
        }
    </script>

    <script>
        // --------------------Weekly Featured Slider-------------------
        var change_img = document.querySelector(".change_img");
        var change_imgs = document.querySelectorAll(".change_img p");
        var change_reviews = document.querySelectorAll(".review_img .review");

        change_img.style.backgroundImage = "url(" + change_imgs[0].children[0].src + ")";
        let d = 3;
        change_imgs.forEach((item, n) => {
            item.addEventListener("click", function() {
                if (item.dataset.index != 0) {
                    change_slide(item, n);
                }
            });
        });

        setInterval(function() {
            change_slide(change_imgs[d - 1], d - 1);
        }, 4000);

        function change_slide(item, n) {
            for (let ing = 0; ing < change_imgs.length; ing++) {
                if (ing != n) {
                    if (change_imgs[n].dataset.index == 1) {
                        if (change_imgs[ing].dataset.index == 0)
                            change_imgs[ing].dataset.index = 2;
                        else if (change_imgs[ing].dataset.index == 2)
                            change_imgs[ing].dataset.index = 1;
                    } else {
                        if (change_imgs[ing].dataset.index == 0)
                            change_imgs[ing].dataset.index = 1;
                        else if (change_imgs[ing].dataset.index == 1)
                            change_imgs[ing].dataset.index = 2;
                    }
                    // 
                    change_reviews[ing].classList.remove("_on");
                }
            }
            change_img.style.backgroundImage = "url(" + change_imgs[n].children[0].src + ")";
            change_reviews[n].classList.add("_on");
            item.dataset.index = 0;
            if (n == 0) d = 3;
            else d = n;
        }

        // -------------------------Weekly Book Slider------------------------
        var input_slider = document.querySelectorAll(".slider input");
        var slides = document.querySelectorAll(".slider .slides .slide");

        input_slider.forEach((item, n) => {
            item.addEventListener("click", function() {
                a(n);
            });
        });

        function a(n) {
            slides[n].classList.add("first");
            nCount = n + 1;
            for (let index = 0; index < slides.length; index++) {
                if (index != n) {
                    slides[index].classList.remove("first");
                }
            }
        }

        // SLIDER _ RADIO
        var listBtn = document.querySelectorAll(".manual-btn");
        let nCount = 1;
        document.getElementById("radio" + nCount).checked = true;
        setInterval(function() {
            nCount++;
            document.getElementById("radio" + nCount).checked = true;
            a(nCount - 1);
            if (nCount > listBtn.length - 1) nCount = 0;
        }, 5000);

        var fictions_reviews = document.querySelector(".fictions_reviews");
        fictions_reviews.firstElementChild.classList.add("show");

        function fictions() {
            var f_reviews = document.querySelectorAll(".fictions_review");
            var f_list = document.querySelectorAll(".list_fictions .fiction");
            let ing = 0;

            f_list.forEach((item, n) => {
                item.addEventListener("click", function() {
                    if (n != ing) {
                        f_list[n].classList.add('active');
                        f_reviews[n].classList.add("show");
                        f_reviews[ing].classList.remove("show");
                        f_list[ing].classList.remove('active');
                        ing = n;
                    }
                });
            });
        }

        fictions();
    </script>
@endpush
