@extends('layouts.default')

@push('title', $course->title)

@section('content')

    <section class="breadcum-area">
        <div class="container">
            <p><strong>Batch :</strong> {{ $batch->name }}</p>
            <h3><strong>Course :</strong> {{ $course->title }}</h3>
            <p>
                <strong>Duration :</strong>
                {{ date('d M Y', strtotime($batch->start_date)) }}
                -
                {{ date('d M Y', strtotime($batch->end_date)) }}
            </p>
        </div>
    </section>

    <div class="container mt-4">

        <div class="row">

            {{-- ================= LEFT SIDE ================= --}}
            <div class="col-lg-8">

                {{-- ✅ ONLY DESCRIPTION --}}
                <h1 class="mb-3">Description</h1>
                <div>{!! $batch->description !!}</div>

            </div>


            @php
                $is_enrolled = false;

                if (auth()->check()) {
                    $is_enrolled = DB::table('enrollments')
                        ->where('user_id', auth()->user()->id)
                        ->where('course_id', $course->id)
                        ->where('batch_id', $batch->id)
                        ->where(function ($query) {
                            $query->where('expiry_date', '>', now()->timestamp)->orWhereNull('expiry_date');
                        })
                        ->exists();
                }
            @endphp


            {{-- ================= RIGHT SIDEBAR ================= --}}
            <div class="col-lg-4">

                <div class="gradient-border radius-22 page-static-sidebar mb-4 sticky-top">

                    <div class="ps-box ps-sidebar">

                        <div class="ps-price d-flex mt-3">
                            <h4 class="g-title">₹ {{ $batch->batch_price }}</h4>
                        </div>

                        <div class="d-flex justify-content-between">

                            @if (auth()->check())
                                @if ($is_enrolled)
                                    <a href="{{ route('my.batchwise.courses') }}" target="_blank"
                                        class="eBtn gradient w-100 mb-3">

                                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}">
                                        {{ get_phrase('In Collection') }}
                                    </a>
                                @else
                                    <a href="{{ route('purchase.batchwise.course', ['course_id' => $course->id, 'batch_id' => $batch->id]) }}"
                                        target="_blank" class="eBtn gradient w-100 mb-3">

                                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}">
                                        {{ get_phrase('Buy Now') }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('purchase.batchwise.course', ['course_id' => $course->id, 'batch_id' => $batch->id]) }}"
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

@endsection
