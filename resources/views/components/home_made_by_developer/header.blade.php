{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

@php
    $parent_categories = DB::table('categories')->where('parent_id', 0)->latest('id')->get();
    $current_route = Route::currentRouteName();
@endphp



<!-----------  Header Area Start  ------------->
<header class="header-area" id="mainNav">
    <div class="container">
        <div class="row d-flex flex-md-nowrap justify-content-between justify-content-md-end align-items-center">
            <div class="col-auto">
                <div class="logo-image d-flex justify-content-end align-items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="system logo"
                            class="object-fit-cover rounded header-dark-logo">
                        <img src="{{ get_image(get_frontend_settings('light_logo')) }}" alt="system logo"
                            class="object-fit-cover rounded header-light-logo d-none">
                    </a>
                </div>
            </div>
            <div class="ms-lg-auto col-auto">
                <div class="header-menu d-flex justify-content-end me-lg-auto ms-lg-0 ms-auto mt-2 pt-1">
                    <div class="nav-menu w-100">
                        <ul class="primary-menu main-menu-ul d-flex align-items-center w-100 drop-area">
                            <li><a href="{{ route('home') }}"
                                    class="@if ($current_route == 'home') active @endif">{{ get_phrase('Home') }}</a>
                            </li>

                            <li> <a href="{{ route('about.us') }}"> <span
                                        class="me-auto">{{ get_phrase('About Us') }}</span></a></li>
                            <li class="have-mega-menu"><a class="menu-parent-a">{{ get_phrase('Courses') }}</a>
                                <ul class="mega-dropdown-menu mega main-mega-menu">
                                    <div class="mega-menu-items">
                                        <ul class="mega_list">
                                            <li>
                                                <a href="{{ route('live-class-courses') }}"
                                                    class="me-auto {{ $current_route == 'live-class-courses' ? 'active' : '' }}">

                                                    <span class="me-3">
                                                        <i class="fas fa-list-ul"></i>
                                                    </span>

                                                    <span class="me-auto">
                                                        {{ get_phrase('Live Course') }}
                                                    </span>
                                                </a>
                                            </li>
                                            <li> <a href="{{ route('courses') }}"
                                                    class="me-auto @if ($current_route == 'courses' || $current_route == 'courses.details') active @endif">
                                                    <span class="me-3"><i class="fas fa-list-ul"></i></span>
                                                    <span class="me-auto">{{ get_phrase('Courses') }}</span>
                                                </a>
                                            </li>
                                            <li> <a href="{{ route('course.bundles') }}"
                                                    class="me-auto @if ($current_route == 'course.bundles' || $current_route == 'course.bundles.details') active @endif">
                                                    <span class="me-3"><i class="fas fa-list-ul"></i></span>
                                                    <span class="me-auto">{{ get_phrase('Course Bundle') }}</span>
                                                </a>
                                            </li>
                                            <li><a href="{{ route('webinars') }}"
                                                    class="me-auto @if ($current_route == 'webinars' || $current_route == 'webinar.details') active @endif">
                                                    <span class="me-3"><i class="fas fa-list-ul"></i></span>
                                                    <span class="me-auto">{{ get_phrase('Webinar') }}</span>
                                                </a>
                                            </li>

                                            <!--<li> <a href="{{ route('ebooks') }}" class="me-auto @if ($current_route == 'ebooks' || $current_route == 'ebooks.details') active @endif"> -->
                                            <!--        <span class="me-3"><i class="fas fa-list-ul"></i></span>-->
                                            <!--        <span class="me-auto">{{ get_phrase('Ebooks') }}</span>-->
                                            <!--    </a>-->
                                            <!--</li>-->
                                        </ul>
                                    </div>
                                </ul>
                            </li>
                            <!--<li class="pe-2 ps-5"><a href="{{ route('tutor_list') }}" class="@if ($current_route == 'tutor_list') active @endif">{{ get_phrase('Instructor') }}</a></li>-->
                            <li class="pe-2 ps-5"><a href="{{ route('instructors') }}" class="">Instructors</a>
                            </li>

                            <li> <a href="{{ route('contact.us') }}"> <span
                                        class="me-auto">{{ get_phrase('Contact') }}</span></a></li>

                            <!-- {{-- <li><a href="{{ route('ebooks') }}" class="@if ($current_route == 'ebooks' || $current_route == 'ebook.details') active @endif">{{ get_phrase('Ebooks') }}</a> --}}
                            </li>
                            {{-- <li><a href="{{ route('team.packages') }}" class="@if ($current_route == 'team.packages' || $current_route == 'team.package.details') active @endif">{{ get_phrase('Team Training') }}</a></li> --}}
                            {{-- <li><a href="{{ route('tutor_list') }}" class="@if ($current_route == 'tutor_list') active @endif">{{ get_phrase('Find A Tutor') }}</a></li> --}}
                            <li class="have-mega-menu"><a class="menu-parent-a @if ($current_route == 'courses') active @endif" href="{{ route('courses') }}">{{ get_phrase('More') }}</a>
                                <ul class="mega-dropdown-menu mega main-mega-menu">
                                    <div class="mega-menu-items">
                                        <ul class="mega_list">
                                            <li>
                                                <a href="{{ route('ebooks') }}">
                                                    <span class="light-iconbox me-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.4" d="M20.7129 4.85907C19.0679 4.07807 17.3291 3.86006 15.5171 4.08306C13.5101 4.33006 12 6.03811 12 8.06011V20.0001C14.785 18.1441 17.569 18.0101 20.354 18.8011C20.677 18.8931 21 18.661 21 18.325V5.31903C21 5.12603 20.8879 4.94207 20.7129 4.85907Z" fill="#998EFF"/>
                                                            <path d="M3.28711 4.85907C4.93211 4.07807 6.67091 3.86006 8.48291 4.08306C10.4899 4.33006 12 6.03811 12 8.06011V20.0001C9.215 18.1441 6.431 18.0101 3.646 18.8011C3.323 18.8931 3 18.661 3 18.325V5.31903C3 5.12603 3.11211 4.94207 3.28711 4.85907Z" fill="#943DFF"/>
                                                            <path d="M18 9.75H15C14.586 9.75 14.25 9.414 14.25 9C14.25 8.586 14.586 8.25 15 8.25H18C18.414 8.25 18.75 8.586 18.75 9C18.75 9.414 18.414 9.75 18 9.75ZM17.75 12C17.75 11.586 17.414 11.25 17 11.25H15C14.586 11.25 14.25 11.586 14.25 12C14.25 12.414 14.586 12.75 15 12.75H17C17.414 12.75 17.75 12.414 17.75 12Z" fill="#943DFF"/>
                                                            </svg>
                                                    </span>
                                                    <span class="me-auto">{{ get_phrase('Ebooks') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tutor_list') }}">
                                                    <span class="light-iconbox me-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.009 10.5C12.2182 10.5 14.009 8.70914 14.009 6.5C14.009 4.29086 12.2182 2.5 10.009 2.5C7.79989 2.5 6.00903 4.29086 6.00903 6.5C6.00903 8.70914 7.79989 10.5 10.009 10.5Z" fill="#943DFF"/>
                                                        <path opacity="0.4" d="M11.75 17.33C11.75 18.73 12.26 20.01 13.12 20.99C13.178 21.049 13.21 21.12 13.21 21.2C13.21 21.37 13.08 21.5 12.91 21.5H6C3.71 21.5 2.5 20.3 2.5 18.02C2.5 15.47 3.94 12.5 8 12.5H12C12.534 12.5 13.0249 12.5519 13.4709 12.6479C13.6769 12.6929 13.704 12.85 13.708 12.861C13.716 12.88 13.758 13.03 13.619 13.165C12.52 14.242 11.75 15.673 11.75 17.33Z" fill="#998EFF"/>
                                                        <path d="M22.53 21.47L20.699 19.639C21.15 18.983 21.417 18.19 21.417 17.334C21.417 15.083 19.585 13.251 17.333 13.251C15.082 13.251 13.25 15.083 13.25 17.334C13.25 19.585 15.082 21.417 17.333 21.417C18.188 21.417 18.9809 21.15 19.6379 20.699L21.469 22.531C21.615 22.677 21.807 22.751 21.999 22.751C22.191 22.751 22.3831 22.678 22.5291 22.531C22.8231 22.237 22.823 21.763 22.53 21.47ZM14.75 17.333C14.75 15.909 15.909 14.75 17.333 14.75C18.758 14.75 19.917 15.909 19.917 17.333C19.917 18.757 18.758 19.916 17.333 19.916C15.909 19.917 14.75 18.758 14.75 17.333Z" fill="#943DFF"/>
                                                        </svg>
                                                    </span>
                                                    <span class="me-auto">{{ get_phrase('Find A Tutor') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('course.bundles') }}">
                                                   <span class="light-iconbox me-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.4" d="M11.5 21H9.5C8.5 21 8 20.5 8 19.5V4.5C8 3.5 8.5 3 9.5 3H11.5C12.5 3 13 3.5 13 4.5V19.5C13 20.5 12.5 21 11.5 21Z" fill="#998EFF"/>
                                                            <path opacity="0.4" d="M5.5 21H3.5C2.5 21 2 20.5 2 19.5V4.5C2 3.5 2.5 3 3.5 3H5.5C6.5 3 7 3.5 7 4.5V19.5C7 20.5 6.5 21 5.5 21Z" fill="#998EFF"/>
                                                            <path opacity="0.4" d="M20.7972 20.533L18.855 20.9461C17.884 21.1521 17.2951 20.77 17.0891 19.799L13.993 5.23307C13.786 4.26207 14.1689 3.67308 15.1399 3.46708L17.0821 3.05399C18.0531 2.84799 18.6419 3.23009 18.8479 4.20109L21.9441 18.767C22.1501 19.738 21.7682 20.327 20.7972 20.533Z" fill="#998EFF"/>
                                                            <path d="M13 7.75H8V6.25H13V7.75ZM13 16.25H8V17.75H13V16.25ZM7 6.25H2V7.75H7V6.25ZM7 16.25H2V17.75H7V16.25ZM19.21 5.89001L14.3501 6.93005L14.6599 8.40002L19.52 7.35999L19.21 5.89001ZM21.28 15.6L16.4199 16.64L16.73 18.11L21.5901 17.0699L21.28 15.6Z" fill="#943DFF"/>
                                                        </svg>
                                                    </span>
                                                    <span class="me-auto">{{ get_phrase('Course Bundle') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="col-sm-5 col-md-3 col-xl-4 ms-lg-0 col-auto ms-auto">
                <form action="{{ route('courses') }}" method="get" class="Esearch_entry d-none d-sm-inline-block w-100 ms-4 mt-2">
                    <input type="text" name="search" class="form-control" placeholder="{{ get_phrase('Search...') }}" value="{{ request()->input('search') ?? '' }}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div class="floating-searchbar d-inline-block d-sm-none @auth loged-in @endauth">
                    <button type="button" class="mt-1 py-3" onclick="this.parentElement.querySelector('form').classList.toggle('show')"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <form action="{{ route('courses') }}" method="get">
                        <input type="text" name="search" class="form-control" value="{{ request()->input('search') ?? '' }}" placeholder="{{ get_phrase('Search courses') }}">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div> -->
            <div class="col-auto">
                <div class="primary-end d-flex align-items-center">
                    <div class="d-flex align-items-center gap-2">

                        @isset(auth()->user()->id)
                            <a href="{{ route('cart') }}" class="me-2 me-md-4 position-relative"
                                data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Cart') }}"
                                data-bs-placement="bottom">
                                @php
                                    $numberof_wishlist_item = App\Models\CartItem::where(
                                        'user_id',
                                        auth()->user()->id,
                                    )->count();
                                @endphp
                                @if ($numberof_wishlist_item > 0)
                                    <span class="cart-top-number">
                                        {{ $numberof_wishlist_item }}
                                    </span>
                                @endif
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 2H3.74001C4.82001 2 5.67 2.93 5.58 4L4.75 13.96C4.61 15.59 5.89999 16.99 7.53999 16.99H18.19C19.63 16.99 20.89 15.81 21 14.38L21.54 6.88C21.66 5.22 20.4 3.87 18.73 3.87H5.82001"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M16.25 22C16.9404 22 17.5 21.4404 17.5 20.75C17.5 20.0596 16.9404 19.5 16.25 19.5C15.5596 19.5 15 20.0596 15 20.75C15 21.4404 15.5596 22 16.25 22Z"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M8.25 22C8.94036 22 9.5 21.4404 9.5 20.75C9.5 20.0596 8.94036 19.5 8.25 19.5C7.55964 19.5 7 20.0596 7 20.75C7 21.4404 7.55964 22 8.25 22Z"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 8H21" stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <a href="{{ route('wishlist') }}"
                                class="wishlistMenu me-2 position-relative d-none d-lg-inline-block"
                                data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Wishlist') }}"
                                data-bs-placement="bottom">
                                @php
                                    $numberof_wishlist_item = App\Models\Wishlist::where(
                                        'user_id',
                                        auth()->user()->id,
                                    )->count();
                                @endphp
                                @if ($numberof_wishlist_item > 0)
                                    <span class="cart-top-number">
                                        {{ $numberof_wishlist_item }}
                                    </span>
                                @endif
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.8966 17.1611C9.6825 17.1611 9.46744 17.1226 9.25142 17.0457C9.03539 16.9688 8.84532 16.8483 8.68122 16.6842L7.24472 15.3784C5.47164 13.7618 3.88862 12.1736 2.49567 10.614C1.10273 9.0544 0.40625 7.38357 0.40625 5.60154C0.40625 4.18232 0.884775 2.99419 1.84182 2.03714C2.79887 1.08009 3.98701 0.601562 5.40622 0.601562C6.21262 0.601562 7.0091 0.787464 7.79565 1.15926C8.58218 1.53106 9.28571 2.13491 9.90622 2.97081C10.5267 2.13491 11.2303 1.53106 12.0168 1.15926C12.8033 0.787464 13.5998 0.601562 14.4062 0.601562C15.8254 0.601562 17.0136 1.08009 17.9706 2.03714C18.9277 2.99419 19.4062 4.18232 19.4062 5.60154C19.4062 7.4028 18.6979 9.09222 17.2812 10.6698C15.8645 12.2474 14.285 13.822 12.5427 15.3938L11.1216 16.6842C10.9575 16.8483 10.7658 16.9688 10.5466 17.0457C10.3274 17.1226 10.1107 17.1611 9.8966 17.1611ZM9.187 4.49001C8.64598 3.66565 8.07643 3.06148 7.47835 2.67751C6.88027 2.29353 6.18956 2.10154 5.40622 2.10154C4.40622 2.10154 3.57289 2.43487 2.90622 3.10154C2.23956 3.7682 1.90622 4.60154 1.90622 5.60154C1.90622 6.4041 2.16487 7.24321 2.68217 8.11884C3.19947 8.99447 3.84882 9.86497 4.63022 10.7303C5.41164 11.5957 6.25812 12.4412 7.16965 13.2669C8.08118 14.0925 8.92606 14.8598 9.70427 15.5688C9.76197 15.6201 9.82929 15.6458 9.90622 15.6458C9.98316 15.6458 10.0505 15.6201 10.1082 15.5688C10.8864 14.8598 11.7313 14.0925 12.6428 13.2669C13.5543 12.4412 14.4008 11.5957 15.1822 10.7303C15.9636 9.86497 16.613 8.99447 17.1303 8.11884C17.6476 7.24321 17.9062 6.4041 17.9062 5.60154C17.9062 4.60154 17.5729 3.7682 16.9062 3.10154C16.2396 2.43487 15.4062 2.10154 14.4062 2.10154C13.6229 2.10154 12.9322 2.29353 12.3341 2.67751C11.736 3.06148 11.1665 3.66565 10.6254 4.49001C10.5408 4.61821 10.4344 4.71437 10.3062 4.77849C10.178 4.84259 10.0447 4.87464 9.90622 4.87464C9.76777 4.87464 9.63444 4.84259 9.50622 4.77849C9.37802 4.71437 9.27162 4.61821 9.187 4.49001Z"
                                        fill="#192335" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('cart') }}" class="ms-4 me-4 me-md-5 position-relative"
                                data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Cart') }}"
                                data-bs-placement="bottom">
                                <span class="cart-top-number">
                                    0
                                </span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 2H3.74001C4.82001 2 5.67 2.93 5.58 4L4.75 13.96C4.61 15.59 5.89999 16.99 7.53999 16.99H18.19C19.63 16.99 20.89 15.81 21 14.38L21.54 6.88C21.66 5.22 20.4 3.87 18.73 3.87H5.82001"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M16.25 22C16.9404 22 17.5 21.4404 17.5 20.75C17.5 20.0596 16.9404 19.5 16.25 19.5C15.5596 19.5 15 20.0596 15 20.75C15 21.4404 15.5596 22 16.25 22Z"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M8.25 22C8.94036 22 9.5 21.4404 9.5 20.75C9.5 20.0596 8.94036 19.5 8.25 19.5C7.55964 19.5 7 20.0596 7 20.75C7 21.4404 7.55964 22 8.25 22Z"
                                        stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 8H21" stroke="#192335" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        @endisset

                    </div>


                    @if (isset(auth()->user()->id))
                        <div class="Userprofile me-0 me-md-2 ms-2 ms-md-3 d-none d-lg-inline-block">
                            <button class="us-btn dropdown-toggle py-1" type="button" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                <img class="image-40"
                                    src="{{ Auth()->user()->photo ? get_image(Auth()->user()->photo) : asset('uploads/system/default_user.png') }}"
                                    alt="user-img">
                            </button>
                            <ul class="dropdown-menu dropmenu-end " data-popper-placement="bottom-start">
                                <li class="figure_user d-flex">
                                    <img class="img-fluid rounded-circle image-45"width="45" height="45"
                                        src="{{ Auth()->user()->photo ? get_image(Auth()->user()->photo) : asset('uploads/system/default_user.png') }}"alt="User Image" />
                                    <div class="figure_text">
                                        <h4>{{ ucfirst(Auth()->user()->name) }}</h4>
                                        <p>{{ ucfirst(Auth()->user()->role) }}</p>
                                    </div>
                                </li>

                                @if (in_array(auth()->user()->role, ['admin', 'instructor']))
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route(auth()->user()->role . '.dashboard') }}">
                                            <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                                id="dashboard-icon" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_975_218)">
                                                    <path
                                                        d="M3 0H1.66667C0.747667 0 0 0.747667 0 1.66667V2.33333C0 2.701 0.299 3 0.666667 3H3C3.36767 3 3.66667 2.701 3.66667 2.33333V0.666667C3.66667 0.299 3.36767 0 3 0ZM0.666667 2.33333V1.66667C0.666667 1.11533 1.11533 0.666667 1.66667 0.666667H3L3.00067 2.33333H0.666667ZM7.33333 5H5C4.63233 5 4.33333 5.299 4.33333 5.66667V7.33333C4.33333 7.701 4.63233 8 5 8H6.33333C7.25233 8 8 7.25233 8 6.33333V5.66667C8 5.299 7.701 5 7.33333 5ZM7.33333 6.33333C7.33333 6.88467 6.88467 7.33333 6.33333 7.33333H5V5.66667H7.33333V6.33333ZM6.33333 0H5C4.63233 0 4.33333 0.299 4.33333 0.666667V3.66667C4.33333 4.03433 4.63233 4.33333 5 4.33333H7.33333C7.701 4.33333 8 4.03433 8 3.66667V1.66667C8 0.747667 7.25233 0 6.33333 0ZM5 3.66667V0.666667H6.33333C6.88467 0.666667 7.33333 1.11533 7.33333 1.66667L7.334 3.66667H5ZM3 3.66667H0.666667C0.299 3.66667 0 3.96567 0 4.33333V6.33333C0 7.25233 0.747667 8 1.66667 8H3C3.36767 8 3.66667 7.701 3.66667 7.33333V4.33333C3.66667 3.96567 3.36767 3.66667 3 3.66667ZM1.66667 7.33333C1.11533 7.33333 0.666667 6.88467 0.666667 6.33333V4.33333H3L3.00067 7.33333H1.66667Z"
                                                        fill="#747579" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_975_218">
                                                        <rect width="8" height="8" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            {{ get_phrase('Dashboard') }}
                                        </a>
                                    </li>
                                @endif

                                @if (Auth()->user()->role != 'admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('my.courses') }}">
                                            <i class="fi-rr-book text-18px me-2"></i>
                                            {{ get_phrase('My Courses') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('my.batchwise.courses') }}">
                                            <i class="fi-rr-book text-18px me-2"></i>
                                            {{ get_phrase('My Live Courses') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('my.profile') }}">
                                            <i class="fi-rr-user text-18px me-2"></i>
                                            {{ get_phrase('My Profile') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('my.webinars') }}" id="bootcamp-icon">
                                            <i class="fi-rr-video-camera text-18px me-2"></i>
                                            {{ get_phrase('My Webinars') }}
                                        </a>
                                    </li>
                                {{-- <li>
                                        <a class="dropdown-item" href="{{ route('my.ebooks') }}">
                                            <i class="fi-rr-book text-18px me-2"></i>
                                            {{ get_phrase('My Ebooks') }}
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('purchase.history') }}">
                                            <i class="fi-rr-receipt text-18px me-2"></i>
                                            {{ get_phrase('Purchase History') }}
                                        </a>
                                    </li>
                                    
                                    
                                    {{-- <li>
                                        <a class="dropdown-item" href="{{ route('my.team.packages') }}" id="team-training-header-menu-icon">
                                            <i class="fi-rr-users-alt text-18px"></i>
                                            {{ get_phrase('My Teams') }}
                                        </a>
                                    </li> 
                                    <li>
                                        <a class="dropdown-item" href="{{ route('wishlist') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.9904 20.9092C11.7763 20.9092 11.5612 20.8707 11.3452 20.7938C11.1291 20.7168 10.9391 20.5963 10.775 20.4322L9.33848 19.1265C7.56539 17.5098 5.98238 15.9217 4.58943 14.3621C3.19648 12.8024 2.5 11.1316 2.5 9.34959C2.5 7.93037 2.97852 6.74224 3.93558 5.78519C4.89263 4.82814 6.08076 4.34961 7.49998 4.34961C8.30638 4.34961 9.10285 4.53551 9.8894 4.90731C10.6759 5.27911 11.3795 5.88296 12 6.71886C12.6205 5.88296 13.324 5.27911 14.1105 4.90731C14.8971 4.53551 15.6936 4.34961 16.5 4.34961C17.9192 4.34961 19.1073 4.82814 20.0644 5.78519C21.0214 6.74224 21.5 7.93037 21.5 9.34959C21.5 11.1509 20.7916 12.8403 19.375 14.4178C17.9583 15.9954 16.3788 17.5701 14.6365 19.1419L13.2154 20.4322C13.0513 20.5963 12.8596 20.7168 12.6404 20.7938C12.4211 20.8707 12.2045 20.9092 11.9904 20.9092ZM11.2808 8.23806C10.7397 7.41369 10.1702 6.80953 9.5721 6.42556C8.97402 6.04158 8.28331 5.84958 7.49998 5.84958C6.49998 5.84958 5.66664 6.18292 4.99998 6.84959C4.33331 7.51625 3.99998 8.34959 3.99998 9.34959C3.99998 10.1522 4.25863 10.9913 4.77593 11.8669C5.29323 12.7425 5.94257 13.613 6.72398 14.4784C7.50539 15.3438 8.35187 16.1893 9.2634 17.0149C10.1749 17.8406 11.0198 18.6079 11.798 19.3169C11.8557 19.3682 11.923 19.3938 12 19.3938C12.0769 19.3938 12.1442 19.3682 12.2019 19.3169C12.9801 18.6079 13.825 17.8406 14.7366 17.0149C15.6481 16.1893 16.4946 15.3438 17.276 14.4784C18.0574 13.613 18.7067 12.7425 19.224 11.8669C19.7413 10.9913 20 10.1522 20 9.34959C20 8.34959 19.6666 7.51625 19 6.84959C18.3333 6.18292 17.5 5.84958 16.5 5.84958C15.7166 5.84958 15.0259 6.04158 14.4279 6.42556C13.8298 6.80953 13.2602 7.41369 12.7192 8.23806C12.6346 8.36626 12.5282 8.46242 12.4 8.52654C12.2718 8.59064 12.1384 8.62269 12 8.62269C11.8615 8.62269 11.7282 8.59064 11.6 8.52654C11.4718 8.46242 11.3654 8.36626 11.2808 8.23806Z"
                                                    fill="#6B7385" />
                                            </svg>
                                            {{ get_phrase('Wishlist') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('message') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.89841 14.1503H13.4984C13.6829 14.1503 13.8373 14.0886 13.9618 13.9652C14.0862 13.8418 14.1484 13.6886 14.1484 13.5056C14.1484 13.3226 14.0862 13.1677 13.9618 13.0408C13.8373 12.9138 13.6829 12.8504 13.4984 12.8504H6.89841C6.71393 12.8504 6.55948 12.9121 6.43506 13.0355C6.31065 13.1589 6.24844 13.3121 6.24844 13.4951C6.24844 13.6781 6.31065 13.833 6.43506 13.96C6.55948 14.0869 6.71393 14.1503 6.89841 14.1503ZM6.89841 10.8503H17.0984C17.2829 10.8503 17.4373 10.7886 17.5618 10.6652C17.6862 10.5418 17.7484 10.3886 17.7484 10.2056C17.7484 10.0226 17.6862 9.86768 17.5618 9.74077C17.4373 9.61385 17.2829 9.55039 17.0984 9.55039H6.89841C6.71393 9.55039 6.55948 9.61209 6.43506 9.73549C6.31065 9.85891 6.24844 10.0121 6.24844 10.1951C6.24844 10.3781 6.31065 10.533 6.43506 10.66C6.55948 10.7869 6.71393 10.8503 6.89841 10.8503ZM6.89841 7.55034H17.0984C17.2829 7.55034 17.4373 7.48864 17.5618 7.36524C17.6862 7.24182 17.7484 7.08862 17.7484 6.90564C17.7484 6.72264 17.6862 6.56768 17.5618 6.44077C17.4373 6.31385 17.2829 6.25039 17.0984 6.25039H6.89841C6.71393 6.25039 6.55948 6.31209 6.43506 6.43549C6.31065 6.55891 6.24844 6.71211 6.24844 6.89509C6.24844 7.07809 6.31065 7.23305 6.43506 7.35997C6.55948 7.48688 6.71393 7.55034 6.89841 7.55034ZM6.03689 17.5003L4.26291 19.2743C4.00968 19.5275 3.71896 19.5854 3.39076 19.4478C3.06255 19.3103 2.89844 19.0624 2.89844 18.7042V4.50809C2.89844 4.05796 3.05385 3.67747 3.36469 3.36664C3.67552 3.05581 4.056 2.90039 4.50614 2.90039H19.4907C19.9408 2.90039 20.3213 3.05581 20.6321 3.36664C20.943 3.67747 21.0984 4.05796 21.0984 4.50809V15.8926C21.0984 16.3428 20.943 16.7233 20.6321 17.0341C20.3213 17.3449 19.9408 17.5003 19.4907 17.5003H6.03689ZM4.89076 16.2004H19.4907C19.5676 16.2004 19.6381 16.1683 19.7023 16.1042C19.7664 16.0401 19.7984 15.9696 19.7984 15.8926V4.50809C19.7984 4.43116 19.7664 4.36063 19.7023 4.29652C19.6381 4.23242 19.5676 4.20037 19.4907 4.20037H4.50614C4.4292 4.20037 4.35868 4.23242 4.29456 4.29652C4.23046 4.36063 4.19841 4.43116 4.19841 4.50809V16.8927L4.89076 16.2004Z"
                                                    fill="#6B7385" />
                                            </svg>
                                            {{ get_phrase('Message') }}
                                        </a>
                                    </li> 
                                    <li>
                                        <a class="dropdown-item" href="{{ route('support.ticket.index') }}">
                                            <svg width="21" height="21" viewBox="0 0 24 24" fill="#6B7385"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.6424 19.649C2.6924 19.649 1.0424 17.999 1.0424 16.049V10.9157C1.00073 8.48231 1.90073 6.19064 3.58407 4.47398C5.2674 2.76564 7.52573 1.81564 9.95907 1.81564C14.9257 1.81564 18.9591 5.85731 18.9591 10.8157V15.949C18.9591 17.9323 17.3424 19.549 15.3591 19.549C13.4091 19.549 11.7591 17.899 11.7591 15.949V13.6073C11.7591 12.399 12.7091 11.449 13.9174 11.449C15.1257 11.449 18.9591 12.399 18.9591 13.6073V16.1323C18.9591 16.474 18.6757 16.7573 18.3341 16.7573C17.9924 16.7573 17.7091 16.474 17.7091 16.1323V13.6073C17.7091 13.0407 14.3674 12.699 13.9174 12.699C13.3507 12.699 13.0091 13.1573 13.0091 13.6073V15.949C13.0091 17.224 14.0841 18.299 15.3591 18.299C16.6341 18.299 17.7091 17.224 17.7091 15.949V10.8157C17.7091 6.54064 14.2341 3.06564 9.95907 3.06564C7.8674 3.06564 5.92573 3.87398 4.47573 5.34898C3.02573 6.82398 2.25073 8.79898 2.2924 10.899V16.049C2.2924 17.324 3.3674 18.399 4.6424 18.399C5.9174 18.399 6.9924 17.324 6.9924 16.049V13.7073C6.9924 13.1407 6.53407 12.799 6.08407 12.799C5.5174 12.799 2.2924 13.2573 2.2924 13.7073V16.1407C2.2924 16.4823 2.00907 16.7657 1.6674 16.7657C1.32573 16.7657 1.0424 16.4823 1.0424 16.1407V13.7073C1.0424 12.499 4.87573 11.549 6.08407 11.549C7.2924 11.549 8.2424 12.499 8.2424 13.7073V16.049C8.2424 17.999 6.5924 19.649 4.6424 19.649Z"
                                                    fill="#6B7385" />
                                            </svg>

                                            {{ get_phrase('Customer Support') }}
                                        </a>
                                    </li> --}}
                                @endif

                                <li>
                                    <a class="dropdown-item mb-0 logout-link ms-1" href="javascript:;">
                                        <i class="fi-rr-sign-out-alt text-18px me-2"></i>
                                        {{ get_phrase('Log Out') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        {{-- <a href="{{ route('login') }}"
                            class="d-none d-lg-inline-block eBtn btn gradient mb-1">{{ get_phrase('Login') }}</a> --}}
                        <a href="{{ route('student.login.form') }}"
                            class="d-none d-lg-inline-block eBtn btn gradient mb-1">{{ get_phrase('Login') }}</a>
                    @endif <span class="toggle-bar
                    text-dark ms-0"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                        aria-controls="offcanvasWithBothOptions"><i class="fa-sharp fa-solid fa-bars"></i></span>
                </div>
            </div>
        </div>

        <!-- Off Canves Menu For Mobile Device-->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <!--<div class="offcanvas-header">-->
            <!--    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"></h5>-->
            <!--</div>-->
            <div class="offcanvas-body px-4">
                <div class="off-menu">
                    <div class="logo-image d-flex align-items-center justify-content-between mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="system logo">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="mt-3 flex-shrink-0">
                        <ul class="list-unstyled ps-0">
                            @auth
                                <li>
                                    <div class="d-flex align-items-center my-4 mt-5">
                                        <img src="{{ get_image(Auth()->user()->photo) }}" alt="user-img"
                                            class="image-45">
                                        <div class="ms-3 pt-2">
                                            <h3>{{ Auth()->user()->name }}</h3>
                                            <small class="text-muted">{{ Auth()->user()->email }}</small>
                                        </div>
                                        <a data-bs-toggle="tooltip" title="{{ get_phrase('Logout') }}"
                                            class="btn btn-light text-14px me-3 ms-auto logout-link" href="javascript:;">
                                            <i class="fi-rr-arrow-right-to-bracket"></i> </a>
                                    </div>
                                </li>
                                @if ((auth()->user() && auth()->user()->role == 'student') || (auth()->user() && auth()->user()->role == 'instructor'))
                                    @php
                                        $numberof_wishlist_item = App\Models\Wishlist::where(
                                            'user_id',
                                            auth()->user()->id,
                                        )->count();
                                    @endphp
                                    <li>
                                        <a href="{{ route('my.courses') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            <i class="fi-rr-book text-18px me-2"></i> {{ get_phrase('My Courses') }}</a>
                                            </li>
                                    
                                    <li><a href="{{ route('my.profile') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            <i class="fi-rr-user text-18px me-2"></i> {{ get_phrase('My profile') }}</a></li>
                                    <li>
                                        <a href="{{ route('my.webinars') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            <i class="fi-rr-video-camera text-18px me-2"></i> {{ get_phrase('My Webinars') }}</a></li>  
                                            
                                    <li><a href="{{ route('my.ebooks') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            <i class="fi-rr-book text-18px me-2"></i>
                                            {{ get_phrase('My Ebooks') }}</a></li>      
                                            
                                    <li><a href="{{ route('purchase.history') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            <i class="fi-rr-receipt text-18px me-2"></i> {{ get_phrase('Purchase History') }}</a></li>
                                            
                                @elseif (auth()->user() && auth()->user()->role == 'admin')
                                    <li><a href="{{ route('admin.dashboard') }}"
                                            class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                            {{ get_phrase('Admin Dashboard') }}</a></li>
                                @endif
                                <li>
                                    <hr>
                            </li> @endauth

                            <li><a href="{{ route('home') }}"
                                    class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                    {{ get_phrase('Home') }}</a></li>
                            <li><a href="{{ route('about.us') }}"
                                    class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">
                                    {{ get_phrase('About Us') }}</a></li>
                            <li>
                                <button
                                    class="btn btn-toggle d-inline-flex align-items-center text-16px fw-500 w-100 collapsed rounded border-0 py-3"
                                    data-bs-toggle="collapse" data-bs-target="#category-collapse"
                                    aria-expanded="false">
                                    {{ get_phrase('Courses') }}
                                    <span class="icons float-end ms-auto"><i
                                            class="fa-solid fa-angle-down"></i></span>
                                </button>
                                <div class="collapse" id="category-collapse">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal small bg-white pb-1 pb-3 pt-0">
                                        <li>
                                            <a class="w-100 px-3 py-2"
                                                href="{{ route('live-class-courses') }}">{{ get_phrase('Live Course') }}</a>
                                        </li>
                                        <li>
                                            <a class="w-100 px-3 py-2"
                                                href="{{ route('courses') }}">{{ get_phrase('Courses') }}</a>
                                        </li>
                                        <li>
                                            <a class="w-100 px-3 py-2"
                                                href="{{ route('course.bundles') }}">{{ get_phrase('Course Bundle') }}</a>
                                        </li>
                                        <li>
                                            <a class="w-100 px-3 py-2"
                                                href="{{ route('webinars') }}">{{ get_phrase('Webinar') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="{{ route('instructors') }}"
                                    class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">Instructors</a>
                            </li>
                            <li><a href="{{ route('contact.us') }}"
                                    class="btn btn-toggle-list d-inline-flex align-items-center text-16px fw-500 w-100 rounded border-0 py-3">{{ get_phrase('Contact') }}</a>
                            </li>
                        </ul>
                    </div>
                    @guest
                        <div class="btn-off d-flex justify-content-between gap-10">
                            <a href="{{ route('student.login.form') }}" class="eBtn btn gradient">{{ get_phrase('Login') }}</a>
                            <!--<a href="{{ route('register.form') }}"-->
                            <!--    class="eBtn btn gradient sign">{{ get_phrase('Sign Up') }}</a>-->

                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</header>
<!-----------  Header Area End   ------------->

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#lng-selector').change(function(e) {
                e.preventDefault();
                $(this).parent().trigger('submit');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('device_token');
            const logoutLinks = document.querySelectorAll('.logout-link');

            logoutLinks.forEach(link => {
                if (token) {
                    const url = new URL("{{ route('logout') }}", window.location.origin);
                    url.searchParams.append('user_agent', token);
                    link.href = url.toString();
                } else {
                    link.href = "{{ route('logout') }}";
                }
            });
        });

        /*sidebar*/
        $(document).ready(function() {
            function checkOffcanvas() {
                if ($(".offcanvas").hasClass("show")) {
                    $("body").css("overflow", "hidden");
                } else {
                    $("body").css("overflow", "auto");
                }
            }

            // jab offcanvas open ho
            $(document).on("shown.bs.offcanvas", function() {
                checkOffcanvas();
            });

            // jab offcanvas close ho
            $(document).on("hidden.bs.offcanvas", function() {
                checkOffcanvas();
            });

        });
    </script>
@endpush
