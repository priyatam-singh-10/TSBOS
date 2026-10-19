@php $current_route = Route::currentRouteName(); @endphp

<div class="sidebar-logo-area">
    <a href="{{ route('home') }}" class="sidebar-logos">
        <img class="sidebar-logo-lg" height="50px" src="{{ get_image(get_frontend_settings('dark_logo')) }}"
            alt="">
        <img class="sidebar-logo-sm" height="40px" src="{{ get_image(get_frontend_settings('favicon')) }}" alt="">
    </a>
    <button class="sidebar-cross menu-toggler d-block d-lg-none">
        <span class="fi-rr-cross"></span>
    </button>
</div>

<div class="sidebar-nav-area">
    <nav class="sidebar-nav">
        <ul class="px-14px pb-24px">

            @if (has_permission('admin.dashboard'))
                <li class="sidebar-first-li {{ $current_route == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="icon fi-rr-house-blank"></span>
                        <div class="text">
                            <span>{{ get_phrase('Dashboard') }}</span>
                        </div>
                    </a>
                </li>
            @endif
            @if (has_permission('admin.courses') || has_permission('admin.categories'))
                <li class="sidebar-first-li first-li-have-sub @if (
                    $current_route == 'admin.courses' ||
                        $current_route == 'admin.batch.index' ||
                        $current_route == 'admin.batch.create' ||
                        $current_route == 'admin.batch.edit' ||
                        $current_route == 'admin.batch.show' ||
                        $current_route == 'admin.categories' ||
                        $current_route == 'admin.course.create' ||
                        $current_route == 'admin.course.edit' ||
                        $current_route == 'admin.coupons' ||
                        $current_route == 'admin.course.bundles' ||
                        $current_route == 'admin.course.bundle.create' ||
                        $current_route == 'admin.course.bundle.edit' ||
                        $current_route == 'admin.course.bundle.subscription.report' ||
                        $current_route == 'admin.course_bundle.admin_revenue' ||
                        $current_route == 'admin.live-class-schedule.list' ||
                        $current_route == 'admin.live-class-schedule.create' ||
                        $current_route == 'admin.live-class-schedule.edit' ||
                        $current_route == 'admin.live-class-lessons.list' ||
                        $current_route == 'admin.live-class-lessons.create' ||
                        $current_route == 'admin.live-class-lessons.edit' ||
                        $current_route == 'admin.course_bundle.instructor_revenue') active showMenu @endif">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-e-learning"></span>
                        <div class="text">
                            <span>{{ get_phrase('Course') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">

                        <li class="first-sub-menu-title fs-14px mb-18px">
                            {{ get_phrase('Course') }}
                        </li>

                        {{-- ================= Recorded Course ================= --}}
                        <li
                            class="sidebar-second-li second-li-have-sub 
                            @if ($current_route == 'admin.categories' || $current_route == 'admin.courses' || $current_route == 'admin.course.edit') active showSubMenu @endif">

                            <a href="javascript:void(0);">
                                {{ get_phrase('Recorded Course') }}
                            </a>

                            <ul class="second-sub-menu">
                                <li class="@if ($current_route == 'admin.categories') active @endif">
                                    <a href="{{ route('admin.categories') }}">
                                        {{ get_phrase('Course Category') }}
                                    </a>
                                </li>

                                <li class="@if ($current_route == 'admin.courses' || $current_route == 'admin.course.edit') active @endif">
                                    <a href="{{ route('admin.courses') }}">
                                        {{ get_phrase('Manage Courses') }}
                                    </a>
                                </li>
                                @if (has_permission('admin.course.bundles'))
                                    <li class="sidebar-second-li @if (
                                        $current_route == 'admin.course.bundles' ||
                                            $current_route == 'admin.course.bundle.create' ||
                                            $current_route == 'admin.course.bundle.edit' ||
                                            $current_route == 'admin.course.bundle.subscription.report' ||
                                            $current_route == 'admin.course_bundle.admin_revenue' ||
                                            $current_route == 'admin.course_bundle.instructor_revenue') active @endif">

                                        <a href="{{ route('admin.course.bundles') }}">
                                            {{ get_phrase('Manage Bundle') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        {{-- ================= Live Course ================= --}}
                        <li
                            class="sidebar-second-li second-li-have-sub 
                            @if (
                                $current_route == 'admin.batch.index' ||
                                    $current_route == 'admin.batch.edit' ||
                                    $current_route == 'admin.batch.show' ||
                                    $current_route == 'admin.live-class-schedule.list' ||
                                    $current_route == 'admin.live-class-schedule.create' ||
                                    $current_route == 'admin.live-class-schedule.edit') active showSubMenu @endif">

                            <a href="javascript:void(0);">
                                {{ get_phrase('Live Course') }}
                            </a>

                            <ul class="second-sub-menu">

                                <li class="@if (
                                    $current_route == 'admin.batch.index' ||
                                        $current_route == 'admin.batch.edit' ||
                                        $current_route == 'admin.batch.show') active @endif">
                                    <a href="{{ route('admin.batch.index') }}">
                                        {{ get_phrase('Live Batch') }}
                                    </a>
                                </li>

                                @if (has_permission('admin.live-class-schedule.list'))
                                    <li class="@if (
                                        $current_route == 'admin.live-class-schedule.list' ||
                                            $current_route == 'admin.live-class-schedule.create' ||
                                            $current_route == 'admin.live-class-schedule.edit') active @endif">
                                        <a href="{{ route('admin.live-class-schedule.list') }}">
                                            {{ get_phrase('Manage Live Class') }}
                                        </a>
                                    </li>
                                @endif
                                @if (has_permission('admin.live-class-lessons.list'))
                                    <li class="sidebar-second-li @if (
                                        $current_route == 'admin.live-class-lessons.list' ||
                                            $current_route == 'admin.live-class-lessons.create' ||
                                            $current_route == 'admin.live-class-lessons.edit') active @endif">
                                        <a href="{{ route('admin.live-class-lessons.list') }}">
                                            {{ get_phrase('Upload Live class') }}
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>

                    </ul>
                </li>
            @endif


            @if (has_permission('admin.admins.index') ||
                    has_permission('admin.instructor.index') ||
                    has_permission('admin.student.index') ||
                    has_permission('admin.enroll.history') ||
                    has_permission('admin.student.enroll'))

                <li
                    class="sidebar-first-li first-li-have-sub 
        @if (
            $current_route == 'admin.instructor.index' ||
                $current_route == 'admin.instructor.create' ||
                $current_route == 'admin.instructor.edit' ||
                $current_route == 'admin.instructor.payout' ||
                $current_route == 'admin.instructor.payout.filter' ||
                $current_route == 'admin.instructor.setting' ||
                $current_route == 'admin.instructor.application' ||
                $current_route == 'admin.admins.index' ||
                $current_route == 'admin.admins.create' ||
                $current_route == 'admin.admins.edit' ||
                $current_route == 'admin.admins.permission' ||
                $current_route == 'admin.student.index' ||
                $current_route == 'admin.student.edit' ||
                $current_route == 'admin.student.create' ||
                $current_route == 'admin.student.deleted' ||
                $current_route == 'admin.enroll.history' ||
                $current_route == 'admin.student.enroll') active @endif">

                    <a href="javascript:void(0);">
                        <span class="icon fi-rr-users"></span>
                        <div class="text">
                            <span>{{ get_phrase('Students') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Students') }}</li>

                        @if (has_permission('admin.student.index'))
                            <li
                                class="sidebar-second-li 
                    @if ($current_route == 'admin.student.index' || $current_route == 'admin.student.edit') active @endif">
                                <a href="{{ route('admin.student.index') }}">
                                    {{ get_phrase('Manage Students') }}
                                </a>
                            </li>

                            {{-- <li
                                class="sidebar-second-li 
                    @if ($current_route == 'admin.student.deleted') active @endif">
                                <a href="{{ route('admin.student.deleted') }}">
                                    {{ get_phrase('Deleted Students') }}
                                </a>
                            </li> --}}
                        @endif


                        {{-- Course Enrollment Section --}}
                        @if (has_permission('admin.enroll.history') || has_permission('admin.student.enroll'))
                            <li class="first-sub-menu-title fs-14px mt-3 mb-2">
                                {{ get_phrase('Course Enrollment') }}
                            </li>

                            @if (has_permission('admin.enroll.history'))
                                <li
                                    class="sidebar-second-li 
                        @if ($current_route == 'admin.enroll.history') active @endif">
                                    <a href="{{ route('admin.enroll.history') }}">
                                        {{ get_phrase('Enrollment History') }}
                                    </a>
                                </li>
                            @endif

                        @endif

                    </ul>
                </li>

            @endif




            @if (has_permission('admin.webinars'))
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.webinars' || $current_route == 'admin.webinar.create' || $current_route == 'admin.webinar.edit' || $current_route == 'admin.webinar.purchase.history' || $current_route == 'admin.webinar.purchase.invoice' || $current_route == 'admin.webinar.categories' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-sr-users-alt"></span>
                        <div class="text">
                            <span>{{ get_phrase('Webinar') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Webinar') }}</li>
                        <li
                            class="d-none sidebar-second-li {{ $current_route == 'admin.webinar.categories' ? 'active' : '' }}">
                            <a href="{{ route('admin.webinar.categories') }}">{{ get_phrase('Webinar Category') }}</a>
                        </li>
                        <li class="sidebar-second-li @if (($current_route == 'admin.webinars' || $current_route == 'admin.webinar.edit') && request('type') == '') active @endif"><a
                                href="{{ route('admin.webinars') }}">{{ get_phrase('Manage Webinars') }}</a></li>
                        <li
                            class="sidebar-second-li {{ $current_route == 'admin.webinar.purchase.history' || $current_route == 'admin.webinar.purchase.invoice' ? 'active' : '' }}">
                            <a
                                href="{{ route('admin.webinar.purchase.history') }}">{{ get_phrase('Webinar Purchase History') }}</a>
                        </li>
                    </ul>
                </li>
            @endif



            @if (has_permission('admin.manage.plans') || has_permission('admin.plan.purchase.history'))
                <li
                    class="sidebar-first-li first-li-have-sub 
        @if ($current_route == 'admin.manage.plans' || $current_route == 'admin.plan.purchase.history') active showMenu @endif">

                    <a href="javascript:void(0);">
                        <span class="icon fi-rr-document"></span>
                        <div class="text">
                            <span>{{ get_phrase('Payment Plans') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Manage Plans') }}</li>

                        @if (has_permission('admin.manage.plans'))
                            <li class="sidebar-second-li @if ($current_route == 'admin.manage.plans') active @endif">
                                <a href="{{ route('admin.manage.plans') }}">
                                    {{ get_phrase('Plans') }}
                                </a>
                            </li>
                        @endif

                        @if (has_permission('admin.plan.purchase.history'))
                            <li class="sidebar-second-li @if ($current_route == 'admin.plan.purchase.history') active @endif">
                                <a href="{{ route('admin.plan.purchase.history') }}">
                                    {{ get_phrase('Purchase History') }}
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif


            @if (has_permission('admin.batch.index'))
                <li
                    class="d-none sidebar-first-li first-li-have-sub 
                @if (
                    $current_route == 'admin.batch.index' ||
                        $current_route == 'admin.batch.create' ||
                        $current_route == 'admin.batch.edit' ||
                        $current_route == 'admin.batch.show') active showMenu @endif">

                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-layers"></span>
                        <div class="text">
                            <span>{{ get_phrase('Batches') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">
                            {{ get_phrase('Batches') }}
                        </li>

                        {{-- Manage Batches --}}
                        <li
                            class="sidebar-second-li 
                        @if (
                            $current_route == 'admin.batch.index' ||
                                $current_route == 'admin.batch.edit' ||
                                $current_route == 'admin.batch.show') active @endif">
                            <a href="{{ route('admin.batch.index') }}">
                                {{ get_phrase('Manage Batches') }}
                            </a>
                        </li>

                        {{-- Add New Batch --}}
                        <li
                            class="sidebar-second-li 
                        @if ($current_route == 'admin.batch.create') active @endif">
                            <a href="{{ route('admin.batch.create') }}">
                                {{ get_phrase('Add New Batch') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (has_permission('admin.purchase.history'))
                <li
                    class="sidebar-first-li {{ $current_route == 'admin.purchase.history' || $current_route == 'admin.purchase.history.invoice' ? 'active' : '' }}">

                    <a href="{{ route('admin.purchase.history') }}">
                        <span class="icon fi-rr-comment-dollar"></span>
                        <div class="text">
                            <span>{{ get_phrase('Payment History') }}</span>
                        </div>
                    </a>

                </li>
            @endif
            @if (has_permission('admin.razorpay.transactions'))
                <li class="sidebar-first-li {{ $current_route == 'admin.razorpay.transactions' ? 'active' : '' }}">
                    <a href="{{ route('admin.razorpay.transactions') }}">
                        <span class="icon fi-rr-comment-dollar"></span>
                        <div class="text">
                            <span>{{ get_phrase('Razorpay Transactions') }}</span>
                        </div>
                    </a>
                </li>
            @endif


            @if (has_permission('admin.leads.list'))
                <li
                    class="sidebar-first-li first-li-have-sub 
                {{ in_array($current_route, ['admin.leads.list', 'admin.leads.purchase']) ? 'active' : '' }}">

                    <a href="javascript:void(0);">
                        <span class="icon fi fi-sr-users-alt"></span>
                        <div class="text">
                            <span>{{ get_phrase('Leads') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">
                            {{ get_phrase('Leads') }}
                        </li>

                        <li
                            class="sidebar-second-li 
                    {{ $current_route == 'admin.leads.list' ? 'active' : '' }}">
                            <a href="{{ route('admin.leads.list') }}">
                                {{ get_phrase('Manage Leads') }}
                            </a>
                        </li>

                        <li
                            class="sidebar-second-li 
                    {{ $current_route == 'admin.leads.purchase' ? 'active' : '' }}">
                            <a href="{{ route('admin.leads.purchase') }}">
                                {{ get_phrase('Leads Purchase History') }}
                            </a>
                        </li>
                    </ul>

                </li>
            @endif

            @if (has_permission('admin.contacts'))
                <li class="sidebar-first-li {{ $current_route == 'admin.contacts' ? 'active' : '' }}">
                    <a href="{{ route('admin.contacts') }}">
                        <span class="icon fi fi-br-portrait pt-1"></span>
                        <div class="text">
                            <span>{{ get_phrase('Inquiry') }}</span>
                        </div>
                    </a>
                </li>
            @endif


            @if (has_permission('admin.blogs') ||
                    has_permission('admin.blog.pending') ||
                    has_permission('admin.blog.category') ||
                    has_permission('admin.blog.category'))
                <li
                    class="d-none sidebar-first-li first-li-have-sub {{ $current_route == 'admin.blogs' || $current_route == 'admin.blog.create' || $current_route == 'admin.blog.edit' || $current_route == 'admin.blog.pending' || $current_route == 'admin.blog.category' || $current_route == 'admin.blog.settings' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-blog-text"></span>
                        <div class="text">
                            <span>{{ get_phrase('Blogs') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Blogs') }}</li>
                        @if (has_permission('admin.blog.category'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.blog.category' ? 'active' : '' }}">
                                <a href="{{ route('admin.blog.category') }}">{{ get_phrase('Category') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.blogs'))
                            <li class="sidebar-second-li {{ $current_route == 'admin.blogs' ? 'active' : '' }}">
                                <a href="{{ route('admin.blogs') }}">{{ get_phrase('Manage Blogs') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.blog.pending'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.blog.pending' ? 'active' : '' }}">
                                <a href="{{ route('admin.blog.pending') }}">{{ get_phrase('Pending Blogs') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.blog.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.blog.settings' ? 'active' : '' }}">
                                <a href="{{ route('admin.blog.settings') }}">{{ get_phrase('Settings') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (has_permission('admin.knowledge.base'))
                <li class="sidebar-first-li {{ $current_route == 'admin.knowledge.base' || $current_route == 'admin.articles' || $current_route == 'admin.articles.create' ? 'active' : '' }}"
                    style="display:none;">
                    <a href="{{ route('admin.knowledge.base') }}">
                        <span class="icon fi-rr-brain"></span>
                        <div class="text">
                            <span>{{ get_phrase('Knowledge Base') }}</span>
                        </div>
                        @if (
                            $unread_msg =
                                App\Models\Message::where('receiver_id', auth()->user()->id)->where('read', '')->count() > 0)
                            <span class="d-inline-block mt-2px badge bg-danger ms-auto">{{ $unread_msg }}</span>
                        @endif
                    </a>
                </li>
            @endif

        </ul>
    </nav>



    {{-- @if (has_permission('admin.system.settings') ||
    has_permission('admin.website.settings') ||
    has_permission('admin.payment.settings') ||
    has_permission('admin.manage.language') ||
    has_permission('admin.notification.settings') ||
    // has_permission('admin.zapier.settings') ||
    has_permission('admin.amazom_s3.settings') ||
    has_permission('admin.live.class.settings') ||
    has_permission('admin.certificate.settings') ||
    has_permission('admin.player.settings') ||
    has_permission('admin.open.ai.settings') ||
    has_permission('admin.pages') ||
    has_permission('admin.seo.settings') ||
    has_permission('admin.about'))
        <nav class="sidebar-nav">
            <h3 class="sidebar-title fs-12px px-30px text-uppercase pb-3">{{ get_phrase('Settings') }}</h3>
            <ul class="px-14px pb-24px mb-5 pb-5">
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.system.settings' || $current_route == 'admin.website.settings' || $current_route == 'admin.language.phrase.edit' || $current_route == 'admin.payment.settings' || $current_route == 'admin.manage.language' || $current_route == 'admin.notification.settings' || $current_route == 'admin.amazom_s3.settings' || $current_route == 'admin.live.class.settings' || $current_route == 'admin.live.class.settings' || $current_route == 'admin.certificate.settings' || $current_route == 'admin.player.settings' || $current_route == 'admin.open.ai.settings' || $current_route == 'admin.pages' || $current_route == 'admin.seo.settings' || $current_route == 'admin.about' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-settings"></span>
                        <div class="text">
                            <span>{{ get_phrase('System Settings') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('System Settings') }}</li>
                        @if (has_permission('admin.system.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.system.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.system.settings') }}">{{ get_phrase('System Settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.website.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.website.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.website.settings') }}">{{ get_phrase('Website Settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.payment.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.payment.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.payment.settings') }}">{{ get_phrase('Payment Settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.manage.language'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.manage.language' || $current_route == 'admin.language.phrase.edit' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.manage.language') }}">{{ get_phrase('Manage Language') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.live.class.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.live.class.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.live.class.settings') }}">{{ get_phrase('Live Class Settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.notification.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.notification.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.notification.settings') }}">{{ get_phrase('SMTP Settings') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.amazom_s3.settings'))
                            <li
                                class="sidebar-second-li {{ $current_route == 'admin.amazom_s3.settings' ? 'active' : '' }}">
                                <a
                                    href="{{ route('admin.amazom_s3.settings') }}">{{ get_phrase('Amazon s3 settings ') }}</a>
                            </li>
                        @endif
                        @if (has_permission('admin.zapier.settings'))
                            class="sidebar-second-li {{ $current_route == 'admin.zapier.settings' ? 'active' : '' }}">
                            <a-->
                                href="{{ route('admin.zapier.settings') }}">{{ get_phrase('Zapier Settings') }}</a>
                </li>
    @endif --}}
    {{-- @if (has_permission('admin.certificate.settings'))
        <li class="sidebar-second-li {{ $current_route == 'admin.certificate.settings' ? 'active' : '' }}">
            <a href="{{ route('admin.certificate.settings') }}">{{ get_phrase('Certificate Settings') }}</a>
        </li>
    @endif --}}
    {{-- @if (has_permission('admin.player.settings'))
        <li class="sidebar-second-li {{ $current_route == 'admin.player.settings' ? 'active' : '' }}">
            <a href="{{ route('admin.player.settings') }}">{{ get_phrase('Player Settings') }}</a>
        </li>
    @endif --}}
    {{-- @if (has_permission('admin.open.ai.settings'))
        <li class="d-none sidebar-second-li {{ $current_route == 'admin.open.ai.settings' ? 'active' : '' }}">
            <a href="{{ route('admin.open.ai.settings') }}">{{ get_phrase('Open AI Settings') }}</a>
        </li>
    @endif --}}
    {{-- @if (has_permission('admin.pages'))
        <li class="sidebar-second-li {{ $current_route == 'admin.pages' ? 'active' : '' }}"><a
                href="{{ route('admin.pages') }}">{{ get_phrase('Home Page Builder') }}</a>
        </li>
    @endif --}}
    {{-- @if (has_permission('admin.seo.settings'))
        <li class="sidebar-second-li {{ $current_route == 'admin.seo.settings' ? 'active' : '' }}">
            <a href="{{ route('admin.seo.settings') }}">{{ get_phrase('SEO Settings') }}</a>
        </li>
    @endif --}}
    {{-- @if (has_permission('admin.about'))
        <li class="sidebar-second-li {{ $current_route == 'admin.about' ? 'active' : '' }}"><a
                href="{{ route('admin.about') }}">{{ get_phrase('About') }}</a></li>
    @endif --}}
    </ul>
    </li>

    {{-- @if (has_permission('admin.manage.profile'))
        <li class="sidebar-first-li {{ $current_route == 'admin.manage.profile' ? 'active' : '' }}">
            <a href="{{ route('admin.manage.profile') }}">
                <span class="icon fi-rr-circle-user"></span>
                <div class="text">
                    <span>{{ get_phrase('Manage Profile') }}</span>
                </div>
            </a>
        </li>
    @endif --}}
    </ul>
    </nav>
    {{-- @endif --}}
</div>
<style>
    .second-sub-menu {
        display: none;
        padding-left: 15px;
    }

    .second-li-have-sub.showSubMenu>.second-sub-menu {
        display: block;
    }
</style>
<script>
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
        // Restore scroll position if it exists in localStorage
        const scrollPos = localStorage.getItem('navScrollPos');
        const sidebarNavArea = document.querySelector('.sidebar-nav-area');
        if (scrollPos) {
            sidebarNavArea.scrollTop = scrollPos;
        }

        // Ensure the active element is visible
        const activeElement = document.querySelector('.sidebar-nav-area .active');
        if (activeElement) {
            const activeElementTop = activeElement.getBoundingClientRect().top;
            const navAreaTop = sidebarNavArea.getBoundingClientRect().top;
            const navAreaBottom = navAreaTop + sidebarNavArea.clientHeight;

            if (activeElementTop < navAreaTop || activeElementTop > navAreaBottom) {
                sidebarNavArea.scrollTop = activeElement.offsetTop - sidebarNavArea.offsetTop;
            }
        }

        // Save scroll position before page unload
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('navScrollPos', sidebarNavArea.scrollTop);
        });
    });
</script>
