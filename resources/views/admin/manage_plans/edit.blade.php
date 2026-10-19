<?php
$plan = App\Models\ManagePlan::findOrFail($id);

$batches = App\Models\Batch::where('status', 1)->get();
?>

<div class="ol-card">
    <div class="ol-card-body">

        <form action="{{ route('admin.manage.plans.update', $plan->id) }}" method="POST">
            @csrf


            <div class="row">

                {{-- ================= BATCH DROPDOWN ================= --}}
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">
                        {{ get_phrase('Batch') }}<span class="text-danger">*</span>
                    </label>

                    <select class="form-control ol-form-control ol-select2" name="b_id" id="b_id" required>

                        <option value="">Choose batch...</option>

                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}" {{ $plan->batch_id == $batch->id ? 'selected' : '' }}>
                                {{ $batch->name }}
                            </option>
                        @endforeach

                    </select>
                </div>



                {{-- ================= COURSE DROPDOWN ================= --}}
                <!--<div class="fpb-7 mb-3">-->
                <!--    <label class="form-label ol-form-label">-->
                <!--        {{ get_phrase('Course') }}<span class="text-danger">*</span>-->
                <!--    </label>-->

                <!--    <select class="form-control ol-form-control ol-select2" name="course_id" id="c_id" required>-->

                <!--        <option value="{{ $plan->course_id }}" selected>-->
                <!--            {{ App\Models\Course::find($plan->course_id)->title }}-->
                <!--        </option>-->

                <!--    </select>-->
                <!--</div>-->



                {{-- ================= PRICE ================= --}}
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">
                        Price (₹)<span class="text-danger">*</span>
                    </label>

                    <input type="number" class="form-control ol-form-control" name="c_price"
                        value="{{ $plan->price }}" required>
                </div>



                {{-- ================= EXPIRY ================= --}}
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">
                        Link Expiry<span class="text-danger">*</span>
                    </label>

                    <input type="date" class="form-control ol-form-control" name="c_expiry"
                        value="{{ \Carbon\Carbon::parse($plan->expiry_date)->format('Y-m-d') }}" required>
                </div>



                {{-- ================= SESSION DATE ================= --}}
                <div class="fpb-7 mb-3">
                    <label class="form-label ol-form-label">
                        Session Start Date & Time<span class="text-danger">*</span>
                    </label>

                    <input type="datetime-local" class="form-control ol-form-control" name="c_date"
                        value="{{ \Carbon\Carbon::parse($plan->session_start_date)->format('Y-m-d\TH:i') }}" required>
                </div>



                {{-- ================= BATCH TIME ================= --}}
                <div class="fpb-7 mb-3 d-none">
                    <label class="form-label ol-form-label">
                        Batch Timing(Label)
                    </label>

                    <input type="text" class="form-control ol-form-control" name="c_batch"
                        value="{{ $plan->batch_time }}">
                </div>

            </div>


            <div class="fpb-7 mb-2 d-flex justify-content-end">
                <button class="ol-btn-primary">
                    Update Plan
                </button>
            </div>

        </form>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>
//     $('#b_id').on('change', function() {

//         let batch_id = $(this).val();

//         $('#c_id').html('<option>Loading...</option>');

//         if (batch_id) {

//             let url = "{{ route('admin.get.course.by.batch', ':id') }}"
//                 .replace(':id', batch_id);

//             $.get(url, function(res) {

//                 let options = '<option value="">Choose course...</option>';

//                 if (res.length > 0) {

//                     res.forEach(function(course) {

//                         options += `
//                         <option value="${course.id}">
//                             ${course.title}
//                         </option>
//                     `;
//                     });

//                 } else {
//                     options = '<option>No course found</option>';
//                 }

//                 $('#c_id').html(options);

//                 // Select2 refresh (important)
//                 $('#c_id').trigger('change');

//             });
//         }

//     });
// </script>
