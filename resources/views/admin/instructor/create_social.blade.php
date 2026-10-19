<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Facebook') }}</label>
    <div class="col-sm-8">
        <input type="text" name="facebook" class="form-control ol-form-control" id="title"
            @isset($instructor->facebook) value="{{ $instructor->facebook }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Twitter') }}</label>
    <div class="col-sm-8">
        <input type="text" name="twitter" class="form-control ol-form-control" id="title"
            @isset($instructor->twitter) value="{{ $instructor->twitter }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Linkedin') }}</label>
    <div class="col-sm-8">
        <input type="text" name="linkedin" class="form-control ol-form-control" id="title"
            @isset($instructor->linkedin) value="{{ $instructor->linkedin }}" @endisset>
    </div>
</div>
<div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn ol-btn-outline-secondary prev-tab" data-prev="#v-pills-tab3-tab">
        {{ get_phrase('Previous') }}
    </button>

    <button type="submit" class="btn ol-btn-primary">
        {{ get_phrase('Create Instructor') }}
    </button>
</div>

