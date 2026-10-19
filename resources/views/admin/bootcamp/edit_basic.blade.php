<input type="hidden" name="course_type" value="general" required>
<input type="hidden" name="instructors[]" value="{{ auth()->user()->id }}" required>


<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Webinar title') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" value="{{ $bootcamp_details->title }}" class="form-control ol-form-control"
            id="title" required>
    </div>
</div>

<div class="row mb-3 d-none">
    <label for="short_description"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Short description') }}</label>
    <div class="col-sm-10">
        <textarea name="short_description" rows="3" class="form-control ol-form-control" id="short_description">{{ $bootcamp_details->short_description }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <label for="description"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Description') }}</label>
    <div class="col-sm-10">
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor" id="description">{!! $bootcamp_details->description !!}</textarea>
    </div>
</div>
<div class="row mb-3">
    <label for="thumbnail" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Thumbnail') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
    </div>

    <div class="offset-md-2 offset-lg-2 col-md-10 col-lg-6 fpb-7 mt-3">
        <div class="image_preview">
            <img src="{{ asset($bootcamp_details->thumbnail) }}" class="rounded-2" id="preview_thumbnail" width="100"
                alt="blog-thumbnail">
        </div>
    </div>
</div>

<div class="row mb-3 d-none">
    <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Category') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="ol-select2" name="category_id" data-minimum-results-for-search="Infinity">
            <option value="">{{ get_phrase('Select a category') }}</option>
            @foreach (App\Models\BootcampCategory::orderBy('title', 'asc')->get() as $category)
                <option value="{{ $category->id }}" @if ($bootcamp_details->category_id == $category->id) selected @endif>
                    {{ $category->title }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Pricing type') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <div class="eRadios">
            <div class="form-check">
                <input type="radio" name="is_paid" value="1" class="form-check-input eRadioSuccess"
                    id="paid" onchange="$('#paid-section').slideDown(200)"
                    @if ($bootcamp_details->is_paid == 1) checked @endif>
                <label for="paid" class="form-check-label">{{ get_phrase('Paid') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" name="is_paid" value="0" class="form-check-input eRadioSuccess"
                    id="free" onchange="$('#paid-section').slideUp(200)"
                    @if ($bootcamp_details->is_paid != 1) checked @endif>
                <label for="free" class="form-check-label">{{ get_phrase('Free') }}</label>
            </div>
        </div>
    </div>
</div>

<div class="paid-section @if ($bootcamp_details->is_paid != 1) d-hidden @endif" id="paid-section">
    <div class="row mb-3">
        <label for="price" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Price') }}
            <small>({{ currency() }})</small><span class="text-danger ms-1">*</span></label>
        <div class="col-sm-10">
            <input type="number" name="price" value="{{ $bootcamp_details->price }}"
                class="form-control ol-form-control" id="price" min="1" step=".01"
                placeholder="{{ get_phrase('Enter your webinar price') }} ({{ currency() }})">
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Discount type') }}</label>
        <div class="col-sm-10">
            <div class="eRadios">
                <div class="form-check">
                    <input type="checkbox" name="discount_flag" value="1"
                        class="form-check-input eRadioSuccess" id="discount_flag"
                        @if ($bootcamp_details->discount_flag == 1) checked @endif>
                    <label for="discount_flag"
                        class="form-check-label">{{ get_phrase('Check if this webinar has discount') }}</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="discounted_price"
            class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Discounted price') }}</label>
        <div class="col-sm-10">
            <input type="number" name="discounted_price" value="{{ $bootcamp_details->discounted_price }}"
                class="form-control ol-form-control" id="discounted_price" min="1" step=".01"
                placeholder="{{ get_phrase('Enter your discount price') }} ({{ currency() }})">
        </div>
    </div>
</div>

<input type="hidden" name="category_id" value="7">

<div class="row mb-3">
    <label for="title"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Publish Date') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="date" name="publish_date" value="{{ date('Y-m-d', $bootcamp_details->publish_date) }}"
            class="form-control ol-form-control" id="title" required>
    </div>
</div>
