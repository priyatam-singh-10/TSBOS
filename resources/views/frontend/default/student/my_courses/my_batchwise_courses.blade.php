@extends('layouts.default')
@push('title', get_phrase('My Batch courses'))
<style>
    .batchthumb{height:122px;}
</style>
@section('content')
    <section class="my-course-content">
        <div class="profile-banner-area"></div>

        <div class="container profile-banner-area-container">
            <div class="row">

                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9 px-4">

                    <h4 class="g-title">{{ get_phrase('My Batch Courses') }}</h4>

                    <div class="row mt-5">

                        @foreach ($my_courses as $batch)
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-30">
                                <div class="card Ecard g-card c-card">
                                    <div class="card-body entry-details mt-0">

                                        {{-- Batch Thumbnail --}}
                                        <div class="mb-3 batchthumb">
                                            <img src="{{ asset($batch['batch_thumbnail'] ?? 'assets/upload/no_image.jpg') }}"
                                                width="100%" class="rounded">
                                        </div>

                                        {{-- Batch Name --}}
                                        <div class="mb-2">
                                            <span class="livecourse-card__badge text-dark">
                                                {{ get_phrase('Batch') }} :
                                                {{ $batch['batch_name'] }}
                                            </span>
                                        </div>

                                        {{-- Course Titles --}}
                                        <div class="mb-3 ellipsis-line-2">
                                            <strong>{{ get_phrase('Courses') }} :</strong>
                                            {{ $batch['course_titles'] }}
                                        </div>

                                        {{-- ========================= --}}
                                        {{-- BATCH PROGRESS (BLADE ONLY) --}}
                                        {{-- ========================= --}}
                                        @php
                                            $course_ids = $batch['course_ids'] ?? [];

                                            $total_progress = 0;
                                            $course_count = count($course_ids);

                                            foreach ($course_ids as $course_id) {
                                                $total_progress += progress_bar($course_id);
                                            }

                                            $batch_progress =
                                                $course_count > 0 ? round($total_progress / $course_count) : 0;
                                        @endphp

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>{{ get_phrase('Progress') }}</small>
                                                <small>{{ $batch_progress }}%</small>
                                            </div>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $batch_progress }}%">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Start Now Button --}}
                                        <a href="{{ route('student.live_class_player', ['batch_id' => $batch['batch_id']]) }}" class="eBtn learn-btn w-100 text-center">
                                            {{ get_phrase('Start Now') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- Empty --}}
                        @if ($my_courses->count() == 0)
                            <div class="row bg-white radius-10">
                                <div class="col-md-12">
                                    @include('frontend.default.empty')
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- Pagination --}}
                    @if ($my_courses->count() > 0)
                        <div class="entry-pagination">
                            {{ $my_courses->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection
