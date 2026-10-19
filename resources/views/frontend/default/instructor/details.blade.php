@extends('layouts.default')
@push('title', $instructor_details->name)
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <style>
        .eBar-card .courses-img img {
            height: 221px !important;
        }
    </style>
    <!------------------- Breadcum Area Start  ------>
    <section class="instructor-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Instructor Details') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-------------- List Item Start   --------------->
    <section class="instructor-wrappe bg-accent">
        <div class="container">
            <div class="single-details bg-accent">
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        <div class="info-card">
                            <div class="card-heading">About</div>
                            <div class="name-accent"></div>
                            <div class="card-heading-bar"></div>
                            <!--<p class="about-text">-->
                            <!--    Dr. Amara Osei-Bonsu is a globally recognised AI researcher and educator with over 14 years-->
                            <!--    of experience spanning MIT, Stanford, and the UN's Advisory Committee on Emerging-->
                            <!--    Technologies. Her pioneering work on ethical neural architecture design has been cited in-->
                            <!--    over 340 peer-reviewed publications.-->
                            <!--</p>-->
                            <p class="about-text">
                                {!! $instructor_details->about !!}
                            </p>
                            <!--<p class="about-text mt-3">-->
                            <!--    At the Academy, Amara brings her research depth directly into the classroom — making complex-->
                            <!--    machine learning concepts accessible and relevant to the real world. She is passionate about-->
                            <!--    responsible AI development and mentoring underrepresented voices in tech.-->
                            <!--</p>-->
                        </div>
                        {{-- <div class="right-profile">
                            <h3 class="g-title">{{ get_phrase('Hi, I’m') }} {{ $instructor_details->name }}</h3>
                            <span class="gradient color shadow-none">{{ $instructor_details->skill }}</span>
                            <p class="description">{{ $instructor_details->boigraphy }}</p>
                            <ul class="instruct-add">
                                <li>
                                    <p>{{ get_phrase('Experience') }}</p>
                                    <span>: {{ instructor_experience($instructor_details->id) }}</span>
                                    <!--<span>: 15 years</span>-->
                                </li>
                                @if ($instructor_details->email)
                                    <li>
                                        <p>{{ get_phrase('Email') }}</p><span>: {{ $instructor_details->email }}</span>
                                    </li>
                                @endif
                                @if ($instructor_details->phone)
                                    <li>
                                        <p>{{ get_phrase('Phone') }}</p><span>: {{ $instructor_details->phone }}</span>
                                    </li>
                                @endif
                                @if ($instructor_details->details)
                                    <li>
                                        <p>{{ get_phrase('Location') }}</p><span>:
                                            {{ $instructor_details->details }}</span>
                                    </li>
                                @endif
                            </ul>
                            <div class="w-100 pb-2 mt-3 d-flex">
                                <p class="insshare">Share</p>  
                                : <a href="https://www.facebook.com/profile.php?id=61586972910335" target="_blank" class="p-2 mx-2" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Share on Facebook" data-bs-original-title="Share on Facebook">
                                    <i class="fa-brands fa-facebook-f text-20"></i>
                                </a>
                                <a href="https://www.instagram.com/tsbos_official/" target="_blank" class="p-2 mx-2 " data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Share on Instagram" data-bs-original-title="Share on Instagram">
                                    <i class="fa-brands fa-instagram text-20"></i>
                                </a>
                                <a href="https://www.youtube.com/@SommnathBhattacharyaa-w6v" target="_blank" class="p-2 mx-2" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Share on Youtube" data-bs-original-title="Share on Youtube">
                                    <i class="fa-brands fa-youtube text-20"></i>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="left-profile">
                            <div class="instruct-img">
                                <div class="instructor-photo">
                                    <img src="{{ get_image($instructor_details->photo) }}" alt="{{ $instructor_details->name }}">
                                </div>
                            </div>
                            <div class="btn-wrap justify-content-center">
                                <!--<a href="javascript: void(0);" class="eBtn learn-btn">-->
                                <!--    {{ count_student_by_instructor($instructor_details->id) }}-->
                                <!--</a>-->
                                <a href="javascript: void(0);" class="eBtn gradient">
                                    {{ count_course_by_instructor($instructor_details->id) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-------------- List Item End  --------------->
    <!-------------- My Course Item Start  --------------->
    {{-- @if (count($instructor_courses) > 0)
        <section class="feature-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="res-control d-flex align-items-center justify-content-between">
                            <div class="section-title mb-0">
                                <h2 class="title">{{ get_phrase('My Courses') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-50">
                    @foreach ($instructor_courses as $course)
                        @include('frontend.default.course.course_grid', ['course' => $course])
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $instructor_courses->links() }}
                    </nav>
                </div>
                <!-- Pagination -->
            </div>
        </section>
    @endif --}}
    <!-------------- My Course  Item End  --------------->
@endsection
