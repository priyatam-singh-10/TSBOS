<form action="{{ route('admin.webinar.live.class.store') }}" method="post">@csrf
    <!--<div class="fpb7 mb-3">-->
    <!--    <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>-->
    <!--    <input class="form-control ol-form-control" type="text" id="title" name="title" required>-->
    <!--</div>-->
       @php
            $module = \App\Models\BootcampModule::where('bootcamp_id', $id)
                        ->orderBy('sort','asc')
                        ->first();
        
            $bootcamp = \App\Models\Bootcamp::find($id);
        @endphp
        
        @if($module && $bootcamp)
        
            {{-- Hidden Title (same as bootcamp/webinar title) --}}
            <input type="hidden" name="title" value="{{ $bootcamp->title }}">
        
            {{-- Date Prefilled From Module Publish Date --}}
            <div class="col-sm-4 fpb7">
                <label class="form-label ol-form-label d-block">
                    {{ get_phrase('Date') }}
                </label>
        
                <input type="date"
                       class="form-control ol-form-control"
                       name="date"
                       min="{{ date('Y-m-d') }}"
                       value="{{ date('Y-m-d') }}"
                       required />
            </div>
        
        @endif


    <div class="row mb-3">
        <!--<div class="col-sm-4 fpb7">-->
        <!--    <label class="form-label ol-form-label d-block">{{ get_phrase('Date') }}</label>-->
        <!--    <input type="date" class="form-control ol-form-control" name="date" required />-->
        <!--</div>-->

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('Start time') }}</label>
            <input type="time" class="form-control ol-form-control" name="start_time" required />
        </div>

        <div class="col-sm-4 fpb7">
            <label class="form-label ol-form-label d-block">{{ get_phrase('End time') }}</label>
            <input type="time" class="form-control ol-form-control" name="end_time" required />
        </div>
    </div>
    @php
    $firstModule = \App\Models\BootcampModule::where('bootcamp_id', $id)
                    ->orderBy('sort', 'asc')
                        ->first();
    @endphp


    <div class="row mb-3">
        <div class="col-sm-6 fpb-7 d-none">
            <label class="form-label ol-form-label">{{ get_phrase('Module') }}</label>
            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="module_id">
                <option value="">{{ get_phrase('Select an option') }}</option>
                @foreach (App\Models\BootcampModule::where('bootcamp_id', $id)->get() as $module)
                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                @endforeach
            </select>
        </div>
        
        @php
        $firstModule = \App\Models\BootcampModule::where('bootcamp_id', $id)->orderBy('sort', 'asc')->first();
        @endphp
        @if($firstModule)
            <input type="hidden" name="module_id" value="{{ $firstModule->id }}">
        @else
            <p class="text-danger">{{ get_phrase('No Details found for this webinar.') }}</p>
        @endif


        <!--<div class="col-sm-6 fpb-7">-->
        <!--    <label class="form-label ol-form-label">{{ get_phrase('Status') }}</label>-->
        <!--    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status">-->
        <!--        <option value="">{{ get_phrase('Select an option') }}</option>-->
        <!--        <option value="upcoming">{{ get_phrase('Upcoming') }}</option>-->
        <!--        <option value="live">{{ get_phrase('live') }}</option>-->
        <!--        <option value="completed">{{ get_phrase('Completed') }}</option>-->
        <!--    </select>-->
        <!--</div>-->
        
        <input type="hidden" name="status" id="status_input">
    </div>
    
<!--    <div class="row mb-3">-->

    <!-- Waiting Room -->
<!--    <div class="col-sm-4">-->
<!--        <label>Waiting Room</label>-->
<!--        <select name="waiting_room" class="form-control">-->
<!--            <option value="1">ON</option>-->
<!--            <option value="0">OFF</option>-->
<!--        </select>-->
<!--    </div>-->

    <!-- Join Before Host -->
<!--    <div class="col-sm-4">-->
<!--        <label>Join Before Host</label>-->
<!--        <select name="join_before_host" class="form-control">-->
<!--            <option value="1">YES</option>-->
<!--            <option value="0">NO</option>-->
<!--        </select>-->
<!--    </div>-->

    <!-- Host Video -->
<!--    <div class="col-sm-4">-->
<!--        <label>Host Video</label>-->
<!--        <select name="host_video" class="form-control">-->
<!--            <option value="1">ON</option>-->
<!--            <option value="0">OFF</option>-->
<!--        </select>-->
<!--    </div>-->

<!--</div>-->

<!--<div class="row mb-3">-->

    <!-- Participant Video -->
<!--    <div class="col-sm-4">-->
<!--        <label>Participant Video</label>-->
<!--        <select name="participant_video" class="form-control">-->
<!--            <option value="1">ON</option>-->
<!--            <option value="0">OFF</option>-->
<!--        </select>-->
<!--    </div>-->

    <!-- Mute on Entry -->
<!--    <div class="col-sm-4">-->
<!--        <label>Mute Participants</label>-->
<!--        <select name="mute_upon_entry" class="form-control">-->
<!--            <option value="1">YES</option>-->
<!--            <option value="0">NO</option>-->
<!--        </select>-->
<!--    </div>-->

    <!-- Auto Recording -->
<!--    <div class="col-sm-4">-->
<!--        <label>Auto Recording</label>-->
<!--        <select name="auto_recording" class="form-control">-->
<!--            <option value="none">None</option>-->
<!--            <option value="local">Local</option>-->
<!--            <option value="cloud">Cloud</option>-->
<!--        </select>-->
<!--    </div>-->

<!--</div>-->

<!--<div class="row mb-3">-->

    <!-- Approval Type -->
<!--    <div class="col-sm-4">-->
<!--        <label>Approval Type</label>-->
<!--        <select name="approval_type" class="form-control">-->
<!--            <option value="0">Auto Approve</option>-->
<!--            <option value="1">Manual Approve</option>-->
<!--            <option value="2">No Registration</option>-->
<!--        </select>-->
<!--    </div>-->

    <!-- Password -->
<!--    <div class="col-sm-4">-->
<!--        <label>Password</label>-->
<!--        <input type="text" name="password" class="form-control" placeholder="Optional">-->
<!--    </div>-->

<!--</div>-->

    <div class="fpb-7 mb-3">
        <label for="description"
            class="form-label ol-form-label col-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor"></textarea>
    </div>

    <div class="fpb7">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add') }}</button>
    </div>
</form>
    <script>
    function updateStatus() {
        let date = document.querySelector('[name="date"]').value;
        let startTime = document.querySelector('[name="start_time"]').value;
        let endTime = document.querySelector('[name="end_time"]').value;
    
        if (!date || !startTime || !endTime) return;
    
        let start = new Date(date + 'T' + startTime);
        let end = new Date(date + 'T' + endTime);
        let now = new Date();
    
        // 15 min grace
        let endWithGrace = new Date(end.getTime() + 15 * 60000);
    
        let status = '';
    
        if (now < start) {
            status = 'upcoming';
        } else if (now >= start && now <= endWithGrace) {
            status = 'live';
        } else {
            status = 'completed';
        }
    
        document.getElementById('status_input').value = status;
    }
    
    // trigger on change
    document.querySelector('[name="date"]').addEventListener('change', updateStatus);
    document.querySelector('[name="start_time"]').addEventListener('change', updateStatus);
    document.querySelector('[name="end_time"]').addEventListener('change', updateStatus);
    
    // also run before submit (IMPORTANT)
    document.querySelector('form').addEventListener('submit', function() {
        updateStatus();
    });
    </script>

@include('admin.init')
