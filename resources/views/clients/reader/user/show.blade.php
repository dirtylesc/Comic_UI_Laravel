@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/style_user.css') }}">
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
                    <input type="file" style="display: none">
                </form>
                <label>
                    <a class="cursor_pointer" id="a_scale">
                        <img class="img_scale" src="{{ asset($user->avatar) }}" alt="">
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
        <div class="profile d-flex flex-column w_layout position-relative">
            <div class="name d-flex align-items-center">
                <h4 class="fs32 fw600 mb-0">{{ $user->name }}</h4>
                @if ($user->gender == 0)
                    <i class="fa-solid fa-mars ms-3 mb-1"></i>
                @else
                    <img class="ms-3 mb-1" src="{{ asset('images/female-icon.svg') }}" alt="">
                @endif
                @if (optional(user())->id === $user->id)
                    <a href="{{ route('reader.profiles.edit', $user->id) }}"
                        class="btn btn_gray text_uppercase position-absolute fs12 fw600">Edit
                        Profile</a>
                @endif
            </div>
            <p class="fs16 c_m">ID: {{ $user->id }}</p>
            <div class="fw700 fs16 c_m mt-2" id="description">{!! $user->description !!}</div>
            <div class="c_m d-flex align-items-center fs16 mt-1">
                <i class="fa-solid fa-calendar-days fs22"></i>
                <span class="ms-2">{{ date('d-m-Y', strtotime($user->created_at)) }} Joined</span>
                <i class="fa-solid fa-location-dot ms-4 fs22"></i>
                <span class="ms-2">{{ $user->location ?? 'Global' }}</span>
            </div>
        </div>
    </div>
    <div class="middle row">
    </div>
@endsection
@push('js')
@endpush
