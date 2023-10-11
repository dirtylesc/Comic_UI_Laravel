@if (session()->get('locale') === 'vi')
    <style>
        .top .list-hover-1 .right {
            left: 160px;
        }
    </style>
@else
    <style>
        .top .list-hover-1 .left .drop-item {
            width: 132px;
        }
    </style>
@endif
<section id="side-top">
    <div class="top">
        <div class="container align-items-center justify-content-center py-2 px-0 fixed-top">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="logo_top d-flex align-items-center justify-content-center">
                    <a href="{{ route('reader.index') }}">
                        <h4 style="margin-bottom: 0;">DIRTYLESC</h4>
                    </a>
                </div>
                <div class="function_top">
                    <ol>
                        <li>
                            <div class="browse">
                                <a href="{{ route('reader.stories') }}" class="g_hd_link">
                                    <svg viewBox="0 0 1024 1024" width="24" height="24">
                                        <path
                                            d="M512 85.333333c235.52 0 426.666667 191.146667 426.666667 426.666667s-191.146667 426.666667-426.666667 426.666667S85.333333 747.52 85.333333 512 276.48 85.333333 512 85.333333z m234.666667 192L426.24 426.24 277.333333 746.666667l320.426667-148.906667L746.666667 277.333333zM512 465.066667c26.026667 0 46.933333 20.906667 46.933333 46.933333 0 26.026667-20.906667 46.933333-46.933333 46.933333-26.026667 0-46.933333-20.906667-46.933333-46.933333 0-26.026667 20.906667-46.933333 46.933333-46.933333z">
                                        </path>
                                    </svg>
                                    <p class="mb-0 cl6 max_content">{{ __('frontpage.browse') }}</p>
                                </a>
                            </div>
                            <div class="list-hover-1">
                                <div class="left">
                                    <a class="drop-item hover" href="{{ route('reader.stories') }}"
                                        title="{{ __('frontpage.comic') }}"
                                        data-report-dt="comics">{{ __('frontpage.comic') }}</a>
                                    {{-- <a class="drop-item" href="" title="{{ __('frontpage.novel') }}"
                                        data-report-dt="novels">{{ __('frontpage.novel') }}</a> --}}
                                </div>
                                <div class="right">
                                    <ul class="list ps-0">
                                        <li class="pr block">
                                            <div class="items" data-report-dt="novels">
                                                <p> <strong
                                                        class="g_browse_title">{{ __('frontpage.male_lead') }}</strong>
                                                    @for ($i = 0; $i < 8; $i++)
                                                        <a data-report-did="{{ $arrGenre[$i]->name }}"
                                                            href="{{ route('reader.stories') }}?category={{ $arrGenre[$i]->slug }}"
                                                            title="{{ __('categories.' . $arrGenre[$i]->slug) }}}">
                                                            {{ __('categories.' . $arrGenre[$i]->slug) }}
                                                        </a>
                                                    @endfor
                                                </p>
                                                <p class="mr20"> <span class="g_browse_title">&nbsp;</span>
                                                    @for ($i = 8; $i < count($arrGenre) && $i < 17; $i++)
                                                        <a data-report-did="{{ __('categories.' . $arrGenre[$i]->slug) }}"
                                                            href="{{ route('reader.stories') }}?category={{ $arrGenre[$i]->slug }}"
                                                            title="{{ __('categories.' . $arrGenre[$i]->slug) }}">
                                                            {{ __('categories.' . $arrGenre[$i]->slug) }}
                                                        </a>
                                                    @endfor
                                                </p>
                                                <p> <strong
                                                        class="g_browse_title">{{ __('frontpage.female_lead') }}</strong>
                                                    <a data-report-did="Urban" href="" title="Urban">Urban</a>
                                                    <a data-report-did="Fantasy" href=""
                                                        title="Fantasy">Fantasy</a>
                                                    <a data-report-did="History" href=""
                                                        title="History">{{ __('categories.history') }}</a>
                                                    <a data-report-did="Teen" href=""
                                                        title="Teen">{{ __('categories.teen') }}</a>
                                                    <a data-report-did="LGBT+" href="" title="LGBT+">LGBT+</a>
                                                    <a data-report-did="Sci-fi" href="" title="Sci-fi">Sci-fi</a>
                                                    <a data-report-did="General" href=""
                                                        title="General">General</a>
                                                </p>
                                            </div>
                                        </li>
                                        <li class="pr">
                                            <div class="items" data-report-dt="comics">
                                                <p> <a data-report-did="Romance" href=""
                                                        title="Romance">Romance</a>
                                                    <a data-report-did="Action" href="" title="Action">Action</a>
                                                    <a data-report-did="Urban" href="" title="Urban">Urban</a>
                                                    <a data-report-did="Eastern" href=""
                                                        title="Eastern">Eastern</a>
                                                    <a data-report-did="Fantasy" href=""
                                                        title="Fantasy">Fantasy</a>
                                                    <a data-report-did="School" href="" title="School">School</a>
                                                    <a data-report-did="LGBT+" href="" title="LGBT+">LGBT+</a>
                                                    <a data-report-did="Sci-Fi" href="" title="Sci-Fi">Sci-Fi</a>
                                                    <a data-report-did="Comedy" href="" title="Comedy">Comedy</a>
                                                </p>
                                                <p> <a data-report-did="Magic" href="" title="Magic">Magic</a>
                                                    <a data-report-did="Wuxia" href="" title="Wuxia">Wuxia</a>
                                                    <a data-report-did="Horror" href="" title="Horror">Horror</a>
                                                    <a data-report-did="History" href=""
                                                        title="History">History</a>
                                                    <a data-report-did="Transmigration" href=""
                                                        title="Transmigration">Transmigration</a>
                                                    <a data-report-did="Harem" href=""
                                                        title="Harem">Harem</a>
                                                    <a data-report-did="Adventure" href=""
                                                        title="Adventure">Adventure</a>
                                                    <a data-report-did="Drama" href=""
                                                        title="Drama">Drama</a>
                                                    <a data-report-did="Mystery" href=""
                                                        title="Mystery">Mystery</a>
                                                </p>
                                                <p>
                                                    <a data-report-did="Inspiring" href=""
                                                        title="Inspiring">Inspiring</a>
                                                    <a data-report-did="Cooking" href=""
                                                        title="Cooking">Cooking</a>
                                                    <a data-report-did="Slice-of-Life" href=""
                                                        title="Slice-of-Life">Slice-of-Life</a>
                                                    <a data-report-did="Sports" href=""
                                                        title="Sports">Sports</a>
                                                    <a data-report-did="Diabolical" href=""
                                                        title="Diabolical">Diabolical</a>
                                                </p>
                                            </div>
                                        </li>
                                        <li class="pr">
                                            <div class="items" data-report-dt="fanfic">
                                                <p> <a data-report-did="Anime &amp; Comics" href=""
                                                        title="Anime &amp; Comics">Anime &amp; Comics</a>
                                                    <a data-report-did="Video" href=""
                                                        title="Video Games">Video
                                                        Games</a>
                                                    <a data-report-did="Celebrities" href=""
                                                        title="Celebrities">Celebrities</a>
                                                    <a data-report-did="Music &amp; Bands" href=""
                                                        title="Music &amp; Bands">Music &amp; Bands</a>
                                                    <a data-report-did="Movies" href=""
                                                        title="Movies">Movies</a>
                                                    <a data-report-did="Book&amp;Literature" href=""
                                                        title="Book&amp;Literature">Book&amp;Literature</a>
                                                    <a data-report-did="TV" href="" title="TV">TV</a>
                                                    <a data-report-did="Theater" href=""
                                                        title="Theater">Theater</a>
                                                    <a data-report-did="Others" href=""
                                                        title="Others">Others</a>
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="ranking">
                                <a href="{{ route('reader.ranking') }}" class="g_hd_link">
                                    <svg viewBox="0 0 1024 1024" width="24" height="24">
                                        <path
                                            d="M896 289.706667V168.362667c0-22.186667-24.704-40.405333-54.869333-40.405334H182.869333C152.704 128 128 146.176 128 168.405333V289.706667c0 22.272 24.704 40.448 54.869333 40.448h658.261334c30.165333 0 54.869333-18.176 54.869333-40.448z m-256 565.888V734.293333c0-22.186667-24.704-40.405333-54.869333-40.405333H182.869333c-30.165333 0-54.869333 18.176-54.869333 40.405333v121.301334c0 22.186667 24.704 40.405333 54.869333 40.405333h402.261334c30.165333 0 54.869333-18.176 54.869333-40.405333z m128-282.965334V451.413333c0-22.229333-24.704-40.405333-54.869333-40.405333H182.869333c-30.165333 0-54.869333 18.176-54.869333 40.405333v121.258667c0 22.229333 24.704 40.405333 54.869333 40.405333h530.261334c30.165333 0 54.869333-18.176 54.869333-40.405333z">
                                        </path>
                                    </svg>
                                    <p class="mb-0 cl6 max_content">{{ __('frontpage.ranking') }}</p>
                                </a>
                                <div class="list-hover-2">
                                    <div>
                                        <a href="" title="Novels" data-report-dt="novels">
                                            {{ __('frontpage.novels_ranking') }}
                                        </a>
                                        <a href="" title="Comics" data-report-dt="comics">
                                            {{ __('frontpage.comics_ranking') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
                <form action="{{ route('reader.stories') }}" method="GET">
                    <div class="search col-3">
                        <input type="text" placeholder=" " name="search" />
                        <label for="name" class="fs14 max_content">{{ __('frontpage.search') }}</label>
                        <i class="fas fa-search fs14"></i>
                        <div class="products dropdown-menu dropdown-menu-animated dropdown-lg d-block">
                        </div>
                    </div>
                </form>
                <div class="library_forum d-flex align-items-center justify-content-center">
                    <a class="g_hd_link library cursor_pointer max_content">
                        <p class="mx-1">{{ __('frontpage.library') }}</p>
                    </a>
                    <a href="" class="g_hd_link max_content">
                        <p class="mx-1">{{ __('frontpage.forum') }}</p>
                    </a>
                    <div class="dropdown g_hd_link">
                        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('frontpage.languages') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-animated">
                            <a class="dropdown-item language @if (session('locale') == 'vi') active @endif"
                                href="{{ route('language', 'vi') }}">
                                <img src="{{ asset('images/vn.png') }}" alt="" width="26px"
                                    class="me-1">
                                <span>{{ __('frontpage.vietnamese') }}</span>
                            </a>
                            <a class="dropdown-item language @if (session('locale') == 'en') active @endif"
                                href="{{ route('language', 'en') }}">
                                <img src="{{ asset('images/us.jpg') }}" alt="" width="26px"
                                    class="me-1">
                                <span>{{ __('frontpage.english') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="user-function g_hd_link">
                    @if (!auth()->check())
                        <div class="log_in d-flex align-items-center justify-content-center" style="cursor: pointer;">
                            <a href="###">Sign In</a>
                        </div>
                    @else
                        <div class="user_login">
                            <input type="checkbox" id="user_up">
                            <label for="user_up">
                                <img src="{{ asset(user()->avatar) }}" alt="" id="h_avatar">
                            </label>
                            <div class="function">
                                <div class="d-flex py-3" style="padding: 5px 15px;">
                                    <a href="{{ route('reader.profiles.show', user()->id) }}">
                                        <img src="{{ asset(user()->avatar) }}" alt="" id="hc_avatar">
                                    </a>
                                    <div class="ms-3">
                                        <a id="name" href="{{ route('reader.profiles.show', user()->id) }}">
                                            <p class="c_fff fw700">{{ user()->name }}</p>
                                        </a>
                                    </div>
                                </div>
                                <ul id="user_down" class="mt-3 mb-0">
                                    <li>
                                        <strong class="lh_22">{{ __('frontpage.earn_rewards') }}</strong>
                                        <small
                                            class="fs12 c_xs lh_18">{{ __('frontpage.by_check_in_and_more') }}</small>
                                    </li>
                                    <li><a
                                            href="{{ route('reader.profiles.show', user()->id) }}">{{ __('frontpage.my_profile') }}</a>
                                    </li>
                                    <li><a href="">{{ __('frontpage.credit_card') }}</a></li>
                                    <li><a href="">{{ __('frontpage.help') }}</a></li>
                                    <li id="log_out_btn">
                                        <a href="{{ route('logout') }}">{{ __('frontpage.sign_out') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</section>
