@extends('layouts.default')
@push('title', get_phrase('Webinars'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="AboutUs breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('All Webinars') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('All Webinars') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-lg-8 col-md-6 col-sm-6 col-6">
                    <p class="showing-text">
                        {{ get_phrase('Showing') . ' ' . count($bootcamps) . ' ' . get_phrase('of') . ' ' . $bootcamps->total() . ' ' . get_phrase('data') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->



    <!-------------- List Item Start   --------------->
    <div class="mt-5 eNtery-item">
        <div class="container">
            <div class="row">
                <div class="d-none col-lg-3 col-md-4">
                    @include('frontend.default.bootcamp.filter')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @forelse ($bootcamps as $bootcamp)
                            @include('frontend.default.bootcamp.bootcamp_grid')

                        @empty
                            <div class="col-12 py-5 text-white">
                                <h1>No webinars available</h1>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (count($bootcamps) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $bootcamps->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </div>
    <!-------------- List Item End  --------------->
@endsection
@push('js')@endpush
