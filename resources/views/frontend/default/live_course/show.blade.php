@extends('layouts.default')

@push('title', $courses->pluck('title')->implode(', '))

@section('content')
<div class="liveCourse">
    <section class="breadcum-area pb-5">
        <div class="container">
            <div class="eNtry-breadcum">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active text-accent" aria-current="page">
                            <!-- {{ $courses->pluck('title')->implode(', ') }} -->
                              Live Course
                        </li>
                    </ol>
                    <h2 class="mb-3">{{ $courses->pluck('title')->implode(', ') }}</h2>
                </nav>
            </div>

            <p class="livecourse-card__badge px-4 mb-3"><strong>Batch :</strong> {{ $batch->name }}</p>

            {{-- Duration chip --}}
            <div class="bc-meta">
                <div class="bc-meta-chip">
                    <i class="fa-regular fa-calendar"></i>
                    <div>
                        <span class="bc-meta-lbl">Duration</span>
                        <div class="bc-date-range">
                            <span>{{ date('d M Y', strtotime($batch->start_date)) }}</span>
                            <span class="bc-arrow">→</span>
                            <span>{{ date('d M Y', strtotime($batch->end_date)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="row">
            {{-- ================= LEFT SIDE ================= --}}
            <div class="col-lg-8">
                {{-- ✅ ONLY DESCRIPTION --}}
                <div class="d-flex gap-2 align-items-center descTitle mb-3">
                    <i class="fa-solid fa-file-lines"></i>
                    <h1 class="fw-bold">Description</h1>
                </div>
                <div>{!! $batch->description !!}</div>
            </div>

            @php
                $is_enrolled = false;

                if (auth()->check()) {
                    $is_enrolled = DB::table('enrollments')
                        ->where('user_id', auth()->user()->id)
                        // ->where('course_id', $course->id)
                        ->where('batch_id', $batch->id)
                        ->where(function ($query) {
                            $query->where('expiry_date', '>', now()->timestamp)->orWhereNull('expiry_date');
                        })
                        ->exists();
                }
            @endphp

            {{-- ================= RIGHT SIDEBAR ================= --}}
            <div class="col-lg-4">
                <div class="gradient-border radius-22 page-static-sidebar mb-4 position-unset mt-0">
                    <div class="ps-box ps-sidebar">
                        <h2 class="fw-semibold">Course Price</h2>
                        <div class="ps-price d-flex mt-3">
                            <h4 class="g-title">₹ {{ $batch->batch_price }}</h4>
                        </div>
                        <ul class="course-meta d-grid gap-3 py-3">
                            <li>
                                <i class="fa fa-calendar"></i>
                                Batch: {{ $batch->name }}
                            </li>
                            <li>
                                <i class="fa fa-clock"></i>
                                Duration: 
                                <span>{{ date('d M Y', strtotime($batch->start_date)) }}</span>
                                <span class="bc-arrow">→</span>
                                <span>{{ date('d M Y', strtotime($batch->end_date)) }}</span>
                            </li>
                            <li>
                                <i class="fa fa-play-circle"></i>
                                Live Classes
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between mt-2">
                            @if (auth()->check())
                                @if ($is_enrolled)
                                    <a href="{{ route('my.batchwise.courses') }}" target="_blank"
                                        class="eBtn gradient w-100 mb-3">

                                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}">
                                        {{ get_phrase('In Collection') }}
                                    </a>
                                @else
                                    <a href="{{ route('purchase.batchwise.course', ['batch_id' => $batch->id]) }}"
                                        target="_blank" class="eBtn gradient w-100 mb-3">

                                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}">
                                        {{ get_phrase('Buy Now') }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('purchase.batchwise.course', ['batch_id' => $batch->id]) }}"
                                    class="eBtn gradient w-100 mb-3">

                                    <img src="{{ asset('assets/frontend/default/image/enroll.png') }}">
                                    {{ get_phrase('Buy Now') }}
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
