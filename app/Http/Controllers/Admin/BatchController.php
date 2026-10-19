<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CourseBundle;

class BatchController extends Controller
{
    // List batches
    public function index(Request $request)
    {
        $query = Batch::withCount('liveClassLessons');

        //Batch Filter
        if ($request->filled('batch_id')) {
            $query->where('id', $request->batch_id);
        }

        // course Filter
        if ($request->filled('course_id')) {
            $query->whereJsonContains('course_id', $request->course_id);
        }

        // FROM DATE
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // TO DATE
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $batches = $query->latest()->paginate(10)->withQueryString();

        $allBatches = Batch::orderBy('name')->get();
        $courses    = \App\Models\Course::orderBy('title')->get();

        return view('admin.batches.index', compact('batches', 'courses', 'allBatches'));
    }

    // Create form
    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        // dd($courses);
        return view('admin.batches.create', compact('courses'));
    }

    // Store batch
    // public function store(Request $request)
    // {
    //     // Validation
    //     $request->validate([
    //         'item_id'         => 'required',
    //         'name'            => 'required|unique:batches,name',
    //         'no_of_live_class' => 'required|integer|min:1',
    //         'start_date'      => 'required|date|after_or_equal:today',
    //         'end_date'        => 'required|date|after:start_date',
    //         'thumbnail'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //     ]);

    //     $item = $request->item_id;

    //     $type = explode('_', $item)[0];
    //     $id   = explode('_', $item)[1];

    //     $courseIds = [];

    //     // If Bundle Selected
    //     if ($type === 'bundle') {

    //         $bundle = CourseBundle::findOrFail($id);

    //         $courseIds = json_decode($bundle->course_ids, true);
    //         $bundleId = $id; // ✅ बस ये add/ensure करो
    //     }

    //     // If Single Course Selected
    //     if ($type === 'course') {

    //         Course::findOrFail($id);

    //         $courseIds = [$id]; // single course array
    //     }


    //     $thumbnailPath = null;

    //     if ($request->hasFile('thumbnail')) {
    //         $file = $request->file('thumbnail');

    //         $fileName = time() . '_' .
    //             preg_replace('/\s+/', '_', $request->name) . '.' .
    //             $file->getClientOriginalExtension();

    //         $file->move(public_path('uploads/batch/thumbnail'), $fileName);

    //         $thumbnailPath = 'uploads/batch/thumbnail/' . $fileName;
    //     }

    //     Batch::create([
    //         'user_id'          => auth()->id(),
    //         'course_id'        => json_encode($courseIds),
    //         'bundle_id'        => $bundleId ?? null, // ✅ important
    //         'name'             => $request->name,
    //         'no_of_live_class' => $request->no_of_live_class,
    //         'start_date'       => $request->start_date,
    //         'end_date'         => $request->end_date,
    //         'batch_price'      => $request->batch_price,
    //         'description'      => $request->description,
    //         'status'           => $request->status,
    //         'thumbnail'        => $thumbnailPath,
    //     ]);

    //     return redirect()->route('admin.batch.index')
    //         ->with('success', 'Batch created successfully');
    // }
    public function store(Request $request)
    {
        $request->validate([
            'item_id'          => 'required',
            'name'             => 'required|unique:batches,name',
            'no_of_live_class' => 'required|integer|min:1',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
            'thumbnail'        => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $item = $request->item_id;

        // ✅ SAFE EXPLODE (no error risk)
        $parts = explode('_', $item);

        $type = $parts[0] ?? null;
        $id   = $parts[1] ?? null;

        $courseIds = [];
        $bundleId  = null;

        // If Bundle Selected
        if ($type === 'bundle' && $id) {

            $bundle = CourseBundle::findOrFail($id);

            $courseIds = json_decode($bundle->course_ids, true) ?? [];

            $bundleId = (int) $id;
        }

        // If Course Selected
        if ($type === 'course' && $id) {

            Course::findOrFail($id);

            $courseIds = [$id];
        }

        // Thumbnail
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {

            $file = $request->file('thumbnail');

            $fileName = time() . '_' .
                preg_replace('/\s+/', '_', $request->name) . '.' .
                $file->getClientOriginalExtension();

            $file->move(public_path('uploads/batch/thumbnail'), $fileName);

            $thumbnailPath = 'uploads/batch/thumbnail/' . $fileName;
        }
        // echo $bundleId;
        // die('sdfsdfsd');
        // Save Batch
        Batch::create([
            'user_id'           => auth()->id(),
            'course_id'         => json_encode($courseIds),
            'bundle_id'         => $bundleId,
            'name'              => $request->name,
            'no_of_live_class'  => $request->no_of_live_class,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'batch_price'       => $request->batch_price,
            'description'       => $request->description,
            'status'            => $request->status,
            'thumbnail'         => $thumbnailPath,
        ]);

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch created successfully');
    }


    public function edit($id)
    {
        $batch = Batch::findOrFail($id);

        $courses = Course::where('status', 'active')->get();
        $bundles = CourseBundle::where('status', 'active')->get();

        /*
        |--------------------------------------------------------------------------
        | Detect Selected Course / Bundle
        |--------------------------------------------------------------------------
        */

        $courseIds = json_decode($batch->course_id, true);

        $selectedItem = null;

        // ✅ Check Bundle
        if (count($courseIds) > 1) {

            foreach ($bundles as $bundle) {

                $bundleCourses = json_decode($bundle->course_ids, true);

                if ($bundleCourses == $courseIds) {
                    $selectedItem = 'bundle_' . $bundle->id;
                    break;
                }
            }
        }

        // ✅ Single Course
        if (!$selectedItem && count($courseIds) == 1) {
            $selectedItem = 'course_' . $courseIds[0];
        }

        return view('admin.batches.edit', compact(
            'batch',
            'courses',
            'bundles',
            'selectedItem'
        ));
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            'item_id' => 'required',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('batches', 'name')->ignore($batch->id),
            ],
            'no_of_live_class' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Detect Course OR Bundle
        |--------------------------------------------------------------------------
        */

        $item = $request->item_id;

        $type = explode('_', $item)[0];
        $itemId = explode('_', $item)[1];

        $courseIds = [];

        // ✅ Bundle Selected
        if ($type === 'bundle') {

            $bundle = CourseBundle::findOrFail($itemId);
            $courseIds = json_decode($bundle->course_ids, true);
            $bundleId = (int) $bundle->id;
        }

        // ✅ Course Selected
        if ($type === 'course') {

            Course::findOrFail($itemId);
            $courseIds = [$itemId];
        }

        /*
        |--------------------------------------------------------------------------
        | Thumbnail Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            if ($batch->thumbnail && file_exists(public_path($batch->thumbnail))) {
                unlink(public_path($batch->thumbnail));
            }

            $file = $request->file('thumbnail');

            $fileName = time() . '_' .
                preg_replace('/\s+/', '_', $request->name) . '.' .
                $file->getClientOriginalExtension();

            $file->move(public_path('uploads/batch/thumbnail'), $fileName);

            $batch->thumbnail = 'uploads/batch/thumbnail/' . $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Batch
        |--------------------------------------------------------------------------
        */

        $batch->update([
            'course_id'        => json_encode($courseIds),
            'user_id'          => auth()->id(),
            'bundle_id'        => $bundleId ?? null,
            'name'             => trim($request->name),
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'no_of_live_class' => $request->no_of_live_class,
            'batch_price'      => $request->batch_price,
            'description'      => $request->description,
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch updated successfully');
    }

    // Delete
    public function destroy($id)
    {
        Batch::destroy($id);
        return back()->with('success', 'Batch deleted');
    }

    // Enroll student to batch
    public function enrollStudent(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
            'user_id'  => 'required'
        ]);

        $batch = Batch::findOrFail($request->batch_id);

        Enrollment::create([
            'user_id'    => $request->user_id,
            'course_id'  => $batch->course_id,
            'batch_id'   => $batch->id,
            'entry_date' => time(),
        ]);

        return back()->with('success', 'Student enrolled to batch');
    }

    public function getBatches(Request $request)
    {
        $batches = \App\Models\Batch::where('course_id', 'like', '%' . $request->course_id . '%')
            ->where('status', 1)
            ->get();

        if ($batches->isEmpty()) {
            return '<option value="">batch available soon</option>';
        }

        $html = '<option value="">Select Batch</option>';

        foreach ($batches as $batch) {
            $html .= '<option value="' . $batch->id . '">'
                . $batch->name . ' ('
                . date('d F Y', strtotime($batch->start_date))
                . ' - '
                . date('d F Y', strtotime($batch->end_date))
                . ')</option>';
        }

        return $html;
    }
}
