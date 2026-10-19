@extends('layouts.default')
@push('title', get_phrase('Live Class Player'))

@section('content')

<section class="lcp-section">
    <div class="container py-4">
    
        @php
            $batchId = $recorded_classes->first()->schedule->batch_id ?? null;
            $batch   = \App\Models\Batch::find($batchId);
        @endphp
    
        {{-- Batch Header Bar --}}
        <div class="lcp-batch-bar">
            <div class="lcp-batch-bar__icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="lcp-batch-bar__label">Current Batch</div>
                <div class="lcp-batch-bar__val">
                    {{ $batch->name ?? 'N/A' }}
                    <span class="lcp-batch-bar__id">#{{ $batchId ?? 'N/A' }}</span>
                </div>
            </div>
            <span class="lcp-batch-bar__badge">Active</span>
        </div>
    
        <div class="lcp-layout">
    
            {{-- ── SIDEBAR ── --}}
            <aside class="lcp-sidebar">
                <div class="lcp-sidebar__head">
                    <i class="fa-solid fa-film"></i>
                    <span>Recorded Classes</span>
                    <span class="lcp-sidebar__count">{{ $recorded_classes->count() }}</span>
                </div>
    
                @forelse($recorded_classes as $i => $recording)
                    <div class="lcp-rec-item {{ $loop->first ? 'active' : '' }}"
                         data-src="{{ $recording->lesson_src }}"
                         data-title="{{ $recording->schedule->title ?? 'No Title' }}"
                         onclick="playRecording(this)">
                        <div class="lcp-rec-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <div class="lcp-rec-title">{{ $recording->schedule->title ?? 'No Title' }}</div>
                            <div class="lcp-rec-dur">
                                <i class="fa-regular fa-clock"></i>
                                {{ $recording->duration ?? '00:00:00' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="lcp-empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>No recordings found</p>
                    </div>
                @endforelse
            </aside>
    
            {{-- ── MAIN ── --}}
            <div class="lcp-main">
    
                {{-- Video Player --}}
                <div class="lcp-player-card">
                    <div class="lcp-player-head">
                        <i class="fa-solid fa-circle-play" style="color:var(--primary-light)"></i>
                        <span>Now Playing</span>
                    </div>
                    <div class="lcp-player-screen">
                        <div class="ratio ratio-16x9">
                            <iframe id="video-frame" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="lcp-player-foot">
                        <span id="current-title" class="lcp-now-title">Select a class to play</span>
                    </div>
                </div>
                {{-- Live & Upcoming --}}
                <div class="lcp-live-section">
                    <div class="lcp-live-head">
                        <span class="live-dot"></span>
                        <span class="lcp-live-title">Live &amp; Upcoming Classes</span>
                    </div>
    
                    <div class="lcp-live-grid">
                        @forelse($upcoming_classes as $class)
                            @php
                                $info   = json_decode($class->additional_info);
                                $isLive = strtotime($class->class_date_and_time) <= time()
                                       && strtotime($class->class_date_and_time) + 3600 >= time();
                            @endphp
    
                            <div class="lcp-live-card {{ $isLive ? 'is-live' : '' }}">
                                <div class="lcp-live-card__top">
                                    <div>
                                    @if($isLive)
                                        <span class="lcp-badge lcp-badge--live">
                                            <span class="live-dot-sm"></span> Live Now
                                        </span>
                                    @else
                                        <span class="lcp-badge lcp-badge--wait">Upcoming</span>
                                    @endif
                                    </div>
                                    
                                    <div>
                                        <h4>Topic Name</h4>
                                        <div class="lcp-live-card__title mt-2">
                                            {{ $class->title }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4>Class Date & Time</h4>
                                        <div class="lcp-live-card__time mt-2">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ date('d M Y, h:i A', strtotime($class->class_date_and_time)) }}
                                        </div>
                                    </div>
                                    
                                    <div class="">
                                        <h4 class="text-center">Action</h4>
                                        <div class="lcp-live-card__foot mt-2">
                                            @if($isLive)
                                                <a href="{{ $info->join_url ?? '#' }}"
                                                   target="_blank"
                                                   class="lcp-btn-join">
                                                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Join Now
                                                </a>
                                            @else
                                                <span class="lcp-btn-wait">
                                                    <i class="fa-regular fa-hourglass-half"></i> Not Live Yet
                                                </span>
                                            @endif
            
                                            @if(isset($info->password))
                                                <div class="lcp-pass-box"
                                                     onclick="copyText('{{ $info->password }}')"
                                                     title="Click to copy">
                                                    <i class="fa-solid fa-lock"></i>
                                                    <span class="lcp-pass-val">{{ $info->password }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        @empty
                            <div class="lcp-empty">
                                <i class="fa-regular fa-calendar-xmark"></i>
                                <p>No live classes scheduled</p>
                            </div>
                        @endforelse
                    </div>
                </div>
    
            </div>{{-- end main --}}
        </div>{{-- end layout --}}
  </div>
</section>

<script>
    async function getEmbedUrl(url) {
        if (url.includes('vimeo.com')) {
            let match = url.match(/(?:player\.)?vimeo\.com\/(?:video\/)?(\d+)/);
            if (match) {
                return "https://player.vimeo.com/video/" + match[1];
            }

            // Old saved share/copy links resolve via backend
            if (url.includes('/share/')) {
                try {
                    const res = await fetch("{{ route('get.video.details') }}?url=" + encodeURIComponent(url));
                    const data = await res.json();
                    if (data && data.embed_video) return data.embed_video;
                    if (data && data.video_id) return "https://player.vimeo.com/video/" + data.video_id;
                } catch (e) {
                    console.error('Unable to resolve Vimeo share URL', e);
                }
            }

            let id = url.split('/').pop().split('?')[0];
            if (/^\d+$/.test(id)) {
                return "https://player.vimeo.com/video/" + id;
            }
        }
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let id = url.includes('youtu.be')
                ? url.split('/').pop()
                : new URL(url).searchParams.get('v');
            return "https://www.youtube.com/embed/" + id;
        }
        return url;
    }

    async function playRecording(el) {
        const recItems = document.querySelectorAll('.lcp-rec-item');
        const frame    = document.getElementById('video-frame');
        const titleBox = document.getElementById('current-title');

        recItems.forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        frame.src = await getEmbedUrl(el.dataset.src);
        titleBox.textContent = el.dataset.title;
        frame.closest('.ratio')?.classList.add('has-src');
    }

    // ── New sidebar items use .lcp-rec-item + data-src ──
    const recItems = document.querySelectorAll('.lcp-rec-item');

    recItems.forEach(item => {
        item.addEventListener('click', function () {
            playRecording(this);
        });
    });

    window.onload = () => {
        if (recItems.length) playRecording(recItems[0]);
    };

    // ── Copy passcode ──
    function copyText(text) {
        navigator.clipboard.writeText(text);
        alert("Passcode copied: " + text);
    }
</script>

@endsection