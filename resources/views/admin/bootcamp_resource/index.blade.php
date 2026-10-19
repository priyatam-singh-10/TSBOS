<form action="{{ route('admin.webinar.resource.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="module_id" value="{{ $id }}">

    <div class="fpb-7 mb-3">
        <label for="upload_type" class="form-label ol-form-label">{{ get_phrase('Upload File Type') }}
            <span class="text-danger">*</span>
        </label>
        <select class="ol-select2" name="upload_type" id="upload_type" required>
            <option value="">{{ get_phrase('Select an option') }}</option>
            {{-- <option value="resource">{{ get_phrase('Resource') }}</option> --}}
            <option value="record">{{ get_phrase('record') }}</option>
        </select>
    </div>

    <!--<div class="row">-->
    <!--    <div class="fpb-7 col-sm-9">-->
    <!--        <label for="files"-->
    <!--            class="form-label ol-form-label">{{ get_phrase('Files') }}-->
    <!--            <span class="text-danger">*</span>-->
    <!--        </label>-->
    <!--        <input type="file" name="files[]" class="form-control ol-form-control"-->
    <!--            id="files" multiple required />-->
    <!--    </div>-->

    <!--    <div class="col-sm-3 d-flex align-items-end">-->
    <!--        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Upload') }}</button>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="row">
        <div class="fpb-7 col-sm-9">
            <label class="form-label ol-form-label">
                {{ get_phrase('Vimeo Video URL') }}
                <span class="text-danger">*</span>
            </label>

            <input type="text" name="vimeo_url" id="vimeo_url" class="form-control" placeholder="vimeo url" required
                onblur="getVimeoDuration(this.value)">

            <input type="hidden" name="duration" id="duration">
        </div>

        <div class="col-sm-3 d-flex align-items-end">
            <button type="submit" class="btn ol-btn-primary">
                {{ get_phrase('Save') }}
            </button>
        </div>
    </div>
</form>

@php
    $files = App\Models\BootcampResource::where('module_id', $id)->latest('id')->get();
@endphp
@if ($files->count() > 0)
    <h4 class="mt-4 resource-title mb-3">{{ get_phrase('Resource files') }}</h4>
    <ul class="bootcamp-resource">
        @foreach ($files as $file)
            <li class="file">
                <span
                    class="badge {{ $file->upload_type == 'resource' ? 'bg-success' : 'bg-primary' }} text-white">{{ Str::ucfirst($file->upload_type) }}</span>
                <div class="d-flex justify-content-between align-items-center">

                    <!-- Title -->
                    <a href="{{ $file->file }}" target="_blank" class="text-decoration-none">
                        <p class="mb-0 cursor-pointer" data-bs-toggle="tooltip" title="{{ $file->title }}"
                            data-bs-placement="bottom">
                            {{ ellipsis($file->title, 40) }}
                        </p>
                    </a>

                    <!-- Preview Button -->
                    <a href="{{ $file->file }}" target="_blank" class="btn ol-btn-primary btn-sm ms-2">
                        <i class="fi-rr-play"></i> Preview
                    </a>

                </div>
                {{-- <div class="d-flex align-items-center gap-2 ms-auto action-btns d-none">
                    <a href="{{ route('admin.webinar.resource.download', $file->id) }}" data-bs-toggle="tooltip"
                        title="{{ get_phrase('Download') }}" data-bs-placement="bottom"><i
                            class="fi fi-rr-down-to-line"></i></a>
                    <a class="dropdown-item" href="javascript:void(0);"
                        onclick="confirmModal('{{ route('admin.webinar.resource.delete', $file->id) }}')"
                        data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" data-bs-placement="bottom"><span
                            class="fi-rr-trash"></span></a>
                </div> --}}
            </li>
        @endforeach
    </ul>
@endif
<script>
    function getVimeoDuration(url) {

        let match = url.match(/vimeo\.com\/(\d+)/);
        if (!match) {
            alert('Invalid Vimeo URL');
            return;
        }

        let videoId = match[1];

        fetch("{{ route('admin.get.vimeo.duration') }}?id=" + videoId)
            .then(res => res.json())
            .then(data => {
                if (data.duration) {
                    document.getElementById('duration').value = data.duration;
                }
            });
    }
</script>
@include('admin.init')
