<div class="row mb-3">
    <label for="email" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Email') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="email" name="email" class="form-control ol-form-control dfddfddffd" id="email"
            @isset($student->email) value="{{ $student->email }}" @endisset>
    </div>
</div>

@if (isset($student->email))
    <div class="row mb-3">
        <label for="password"
            class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Password') }}</label>
        <div class="col-sm-8">
            <input type="password" name="password" class="form-control ol-form-control" id="password">
        </div>
    </div>
@endisset
<div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn ol-btn-outline-secondary prev-tab" data-prev="#v-pills-tab1-tab">
        {{ get_phrase('Previous') }}
    </button>

    <button type="button" class="btn ol-btn-primary next-tab" data-next="#v-pills-tab4-tab">
        {{ get_phrase('Next') }}
    </button>
</div>
