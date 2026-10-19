{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

@php
$activePlan = DB::table('manage_plans')
    ->where('status', 1)
    ->where('is_top', 1)
    ->orderBy('id','desc')
    ->first();
@endphp

<!-----------------  Sub Header Start ------------------->
<div class="sub-header">
    <div class="container">
        <div class="row">
             @php
                $contact_info = get_frontend_settings('contact_info');
                if ($contact_info) {
                    $contact_info = json_decode($contact_info, true);
                } else {
                    $contact_info = ['email' => '', 'phone' => ''];
                }
            @endphp
            <div class="col-lg-6 col-md-6">
                <div class="sub-header-left">
                    <ul class="d-flex drop-area">
                        <li class=" drop-area">
                            <a href="tel:{{ $contact_info['phone'] }}">
                                <i class="fas fa-phone-alt rotate454"></i>
                                {{ $contact_info['phone'] }}
                            </a>
                        </li>
                        <li class=" drop-area">
                            <a href="mailto:{{ $contact_info['phone'] }}">
                                <i class="fas fa-envelope"></i>
                                {{ $contact_info['email'] }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="sub-header-left right-sub">
                    <ul class="d-flex drop-area align-items-center">
                        <li class="primary-end d-none">
                            <form action="{{ route('select.lng') }}" method="get">
                                <select name="language" id="lng-selector" class="form-select nice-control">
                                    @php
                                        $activated_language = strtolower(session('language') ?? get_settings('language'));
                                    @endphp
                                    @foreach (App\Models\Language::all() as $lng)
                                        <option value="{{ $lng->name }}" {{ strtolower($lng->name) == $activated_language ? 'selected' : '' }} class='{{ $lng->name }}'>{{ $lng->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/profile.php?id=61586972910335" target="_black">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>

                        <li>
                            <a href="https://www.instagram.com/tsbos_official/" target="_black">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>

                        <li>
                            <a href="https://www.youtube.com/@SommnathBhattacharyaa-w6v" target="_black">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                        <!--@if (get_frontend_settings('twitter') != '')-->
                        <!--    <li class=" drop-area">-->
                        <!--        <a href="{{ get_frontend_settings('twitter') }}">-->
                        <!--            <i class="fa-brands fa-x-twitter"></i>-->
                        <!--        </a>-->
                        <!--    </li>-->
                        <!--@endif-->
                        <!--@if (get_frontend_settings('linkedin') != '')-->
                        <!--    <li class=" drop-area">-->
                        <!--        <a href="{{ get_frontend_settings('linkedin') }}">-->
                        <!--            <i class="fa-brands fa-linkedin"></i>-->
                        <!--        </a>-->
                        <!--    </li>-->
                        <!--@endif-->
                        <!--@if (get_frontend_settings('facebook') != '')-->
                        <!--    <li class=" drop-area">-->
                        <!--        <a href="{{ get_frontend_settings('facebook') }}">-->
                        <!--            <i class="fa-brands fa-square-facebook"></i>-->
                        <!--        </a>-->
                        <!--    </li>-->
                        <!--@endif-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-----------------  Sub Header End  ------------------->
