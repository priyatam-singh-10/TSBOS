<head>
    <style>
        .copy-btn {
            background: #4CAF50;
            color: #fff;
            border: none;
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .copy-btn:hover {
            background: #43a047;
            transform: scale(1.05);
        }

        .copy-btn:active {
            transform: scale(0.95);
        }
    </style>
</head>
<div class="w-100">
    <!-- Tab-2-Content -->
    <div class="mb-3 d-flex gap-2 align-items-center flex-wrap">
        <a href="#"
            onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_module.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Add new module') }}')"
            class="d-none btn ol-btn-light ol-btn-sm">{{ get_phrase('Add detail') }}
        </a>

        @if ($modules->count() > 0)
            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_live_class.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Generate Link') }}', 'modal-lg')"
                class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Schedule Webinar') }}
            </a>
        @endif

        @if ($modules->count() > 0)
            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_module.sort', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Sort module') }}')"
                class="btn ol-btn-light ol-btn-sm d-none">{{ get_phrase('Sort Module') }}
            </a>
        @endif
    </div>



    <ul class="ol-my-accordion">
        @forelse ($modules as $key => $module)
            @php
                $live_classes = DB::table('bootcamp_live_classes')
                    ->join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
                    ->select('bootcamp_live_classes.*', 'bootcamp_modules.title as module_title')
                    ->where('bootcamp_live_classes.module_id', $module->id)
                    ->orderBy('sort')
                    ->get();
            @endphp
            <li class="single-accor-item p-2">
                <div class="lc-section">
                    @if ($live_classes->count() > 0)
                        @foreach ($live_classes as $key => $class)
                            @php
                                $statusClass = match ($class->status) {
                                    'live' => 'is-live',
                                    'upcoming' => 'is-upcoming',
                                    'completed' => 'is-completed',
                                    default => '',
                                };
                            @endphp

                            <div class="lc-item {{ $statusClass }}">
                                <div class="lc-inner">

                                    {{-- Icon --}}
                                    <div class="lc-icon">
                                        @if ($class->status === 'live')
                                            <span class="fi fi-rr-play"></span>
                                        @elseif($class->status === 'upcoming')
                                            <span class="fi fi-rr-clock"></span>
                                        @else
                                            <span class="fi fi-rr-check-circle"></span>
                                        @endif
                                    </div>

                                    {{-- Content --}}

                                    <div class="lc-content">
                                        
                                        @php
                                        $now = now('Asia/Kolkata');
                                    
                                        $start = \Carbon\Carbon::createFromTimestampUTC($class->start_time + 1800)->setTimezone('Asia/Kolkata');
                                        $end   = \Carbon\Carbon::createFromTimestampUTC($class->end_time + 1800)->setTimezone('Asia/Kolkata');
                                    
                                        if ($now->lt($start)) {
                                            $status = 'upcoming';
                                        } elseif ($now->gte($start) && $now->lte($end)) {
                                            $status = 'live';
                                        } else {
                                            $status = 'completed';
                                        }
                                    @endphp
                                        
                                      

                                        <div class="lc-title-row">
                                            <span class="lc-title">{{ $class->title }}</span>
                                        
                                            @if ($status  === 'live')
                                                <span class="lc-badge lc-badge--live">
                                                    <span class="live-dot"></span> Live
                                                </span>
                                        
                                            @elseif ($status  === 'upcoming')
                                                <span class="lc-badge lc-badge--upcoming">Upcoming</span>
                                        
                                            @else
                                                <span class="lc-badge lc-badge--completed">Completed</span>
                                            @endif
                                        </div>

                                        <div class="lc-meta">
                                            <span class="lc-meta__item">
                                                <span class="fi fi-rr-calendar"></span>
                                                {{ date('d M y', $class->start_time) }}
                                            </span>
                                            <span class="lc-meta__item">
                                                <span class="fi fi-rr-clock"></span>
                                                {{ date('h:i a', $class->start_time) }} â€“
                                                {{ date('h:i a', $class->end_time) }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="lc-actions">
                                        @if (class_started($class->id))
                                            <a href="{{ route('admin.webinar.live.class.join', slugify($class->title)) }}"
                                                class="lc-btn lc-btn--join" data-bs-toggle="tooltip"
                                                title="{{ get_phrase('Join Class') }}">
                                                <span class="fi fi-rr-sign-in-alt"></span>
                                            </a>
                                            <a href="{{ route('admin.webinar.class.end', $class->id) }}"
                                                class="lc-btn lc-btn--end" data-bs-toggle="tooltip"
                                                title="{{ get_phrase('End Class') }}">
                                                <span class="fi fi-rr-stop"></span>
                                            </a>
                                        @endif

                                        <a href="#" class="lc-btn"
                                            onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_live_class.edit', 'id' => $class->id]) }}', '{{ get_phrase('Edit class') }}', 'modal-lg')"
                                            data-bs-toggle="tooltip" title="{{ get_phrase('Edit class') }}">
                                            <span class="fi-rr-pencil"></span>
                                        </a>

                                        <a href="#" class="lc-btn lc-btn--danger"
                                            onclick="confirmModal('{{ route('admin.webinar.live.class.delete', $class->id) }}')"
                                            data-bs-toggle="tooltip" title="{{ get_phrase('Delete class') }}">
                                            <span class="fi-rr-trash"></span>
                                        </a>

                                        <a href="#" class="lc-btn"
                                            onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_resource.index', 'id' => $module->id]) }}', '{{ get_phrase('Vimeo') }}'); event.stopPropagation();"
                                            data-bs-toggle="tooltip" title="{{ get_phrase('Vimeo') }}">
                                            <span class="fi fi-rr-box-open-full"></span>
                                        </a>
                                    </div>

                                </div>

                                {{-- Copy Link Row --}}
                                 @php
                                        $joiningData = json_decode($class->joining_data);
                                    
                                        if (is_string($joiningData)) {
                                            $joiningData = json_decode($joiningData);
                                        }
                                    
                                        $joinUrl = $joiningData->join_url ?? null;
                                        $password = $joiningData->password ?? null;
                                    @endphp
                                    <!--@if (!empty(json_decode($class->joining_data)?->join_url))-->
                                    <!--    <div class="lc-copy">-->
                                    <!--        <div class="lc-copy__box">-->
                                    <!--            Meeting Link :-->
                                    <!--            <button type="button" class="lc-copy__btn"-->
                                    <!--                onclick="copyJoinLink('{{ json_decode($class->joining_data)->join_url ?? '' }}', this)">-->
                                    <!--                ðŸ“‹ Copy-->
                                    <!--            </button>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--@endif-->
                                    @if (!empty($joinUrl))
                                                <div class="lc-copy">
                                                    <div class="lc-copy__box">
                                                        Meeting Link :
                                                        <button type="button" class="lc-copy__btn"
                                                            onclick="copyJoinLink('{{ $joinUrl }}', this)">
                                                            📋 Copy Link
                                                        </button>
                                                    </div>
                                            
                                                    @if (!empty($password))
                                                        <div class="lc-copy__box mt-2">
                                                            Passcode :
                                                            <button type="button" class="lc-copy__btn"
                                                                onclick="copyJoinLink('{{ $password }}', this)">
                                                                🔑 Copy Passcode
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                            </div>
                        @endforeach
                    @else
                        <div class="lc-empty">
                            <i class="fa-regular fa-calendar-xmark"></i>
                            <p>{{ get_phrase('No classes available.') }}</p>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li>
                <div class="row">
                    <div class="offset-lg-2 col-md-8">
                        <a onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_module.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Add new module') }}')"
                            href="#" class="add-section-block text-center mt-4">
                            <p class="sub-title"><i class="fi-rr-add"></i></p>
                            <h3 class="title text-15px mt-2 fw-500">{{ get_phrase('Add new module') }}</h3>
                        </a>
                    </div>
                </div>
            </li>
        @endforelse
    </ul>
</div>
<script>
    function copyJoinLink(link, btn) {

        navigator.clipboard.writeText(link).then(function() {

            // Button permanently change
            btn.innerHTML = "âœ… Copied";
            btn.disabled = true; // optional (prevent multiple click)

        }).catch(function() {
            console.log('Copy failed');
        });
    }
</script>
