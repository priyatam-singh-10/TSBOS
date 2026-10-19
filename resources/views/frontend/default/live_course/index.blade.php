@extends('layouts.default')
@push('title', get_phrase('Live Courses'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ get_phrase('All Live Courses') }}
                                </li>
                            </ol>
                        </nav>

                        <div class="row row-gap-3">
                            <div class="col-auto col-md-4 col-lg-3">
                                <h3 class="g-title mt-2">{{ get_phrase('All Live Courses') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="eNtery-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-10">
                    <div class="row row-gap-3 mb-4">
                        <div class="col-auto col-md-6 col-lg-6">
                            <span
                                class="showing-text d-inline-block mt-3">{{ get_phrase('Showing') . ' ' . count($courses) . ' ' . get_phrase('of') . ' ' . $courses->total() . ' ' . get_phrase('data') }}</span>
                        </div>
                    </div>

                    <div class="search-container reveal active">
                        <form class="search-wrapper" action="{{ route('live-class-courses') }}" method="get">
                            <div class="widget">
                                <div class="search">
                                    <input type="text" class="search-input form-control" name="search"
                                        placeholder="{{ get_phrase('Search live course...') }}"
                                        @if (request()->has('search')) value="{{ request()->input('search') }}" @endif>
                                    <button type="submit" class="submit search-icon"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    

                 <div class="row pt-5">

    @foreach ($courses as $batch)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="livecourse-card h-100">

                {{-- Top gradient header --}}
                <div class="livecourse-card__top">
                    <div class="livecourse-card__topImg">
                        <img src="{{ asset($batch->thumbnail ?? 'assets/upload/no_image.jpg') }}"
                            alt="Batch Thumbnail"
                            class="livecourse-card__thumbnail rounded-4"
                            height="100%"
                            width="100%">
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3">
                        <div class="livecourse-card__badge me-2 mb-0">
                            <i class="fa-solid fa-users"></i> Batch
                        </div>

                        <h5 class="livecourse-card__title">
                            {{ $batch->name ?? 'N/A' }}
                        </h5>
                    </div>
                </div>

                {{-- Info rows --}}
                <div class="livecourse-card__body">

                    <div class="livecourse-card__row">
                        <!--<div class="livecourse-card__icon">-->
                        <!--    <i class="fa-solid fa-book-open fa-xs"></i>-->
                        <!--</div>-->
                        <div>
                            <span class="livecourse-card__label">Live Course</span>
                            <span class="livecourse-card__value">
                             @php
                        $batchCourses = $batch->livecourses();
                    @endphp
                    
                    @if ($batchCourses->count())
                        {{ $batchCourses->pluck('title')->implode(', ') }}
                    @else
                        —
                    @endif
                            </span>
                        </div>
                    </div>

                    <div class="livecourse-card__row">
                        <div class="livecourse-card__icon">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <span class="livecourse-card__label">Price</span>
                            <span class="livecourse-card__price">
                                ₹{{ $batch->batch_price ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <div class="livecourse-card__row">
                        <div class="livecourse-card__icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <div>
                            <span class="livecourse-card__label">Batch Duration</span>
                            <div class="livecourse-card__dates">
                                <span>
                                    {{ $batch->start_date ? date('d M Y', strtotime($batch->start_date)) : '—' }}
                                </span>
                                <span class="livecourse-card__arrow">→</span>
                                <span>
                                    {{ $batch->end_date ? date('d M Y', strtotime($batch->end_date)) : '—' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer button --}}
                <div class="livecourse-card__footer">
                    <a href="{{ route('live-course.show', ['batch' => $batch->id]) }}"
                        class="livecourse-card__btn">
                        View Details →
                    </a>
                </div>

            </div>
        </div>
    @endforeach

    @if ($courses->count() == 0)
        <div class="col-12 bg-white radius-10 py-5 text-center">
            No Live Classes Available
        </div>
    @endif

</div>

                    <!-- Pagination -->
                    <!--@if ($courses->count() > 0)-->
                    <!--    <div class="entry-pagination">-->
                    <!--        <nav aria-label="Page navigation example">-->
                    <!--            {{ $courses->links() }}-->
                    <!--        </nav>-->
                    <!--    </div>-->
                    <!--@endif-->
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
    <!------------------- Breadcum Area End  --------->
@endsection
