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
    // public function index(Request $request)
    // {
    //     $query = Batch::withCount('liveClassLessons');

    //     // SEARCH
    //     if ($request->filled('search')) {

    //         $search = $request->search;

    //         // course ids nikalo
    //         $courseIds = \App\Models\Course::where('title', 'like', "%$search%")
    //             ->pluck('id');

    //         $query->where(function ($q) use ($search, $courseIds) {

    //             $q->where('name', 'like', "%$search%");

    //             foreach ($courseIds as $id) {
    //                 $q->orWhereJsonContains('course_id', $id);
    //             }
    //         });
    //     }

    //     // Filter Course
    //     if ($request->filled('course_id')) {
    //         $query->whereJsonContains('course_id', $request->course_id);
    //     }

    //     $batches = $query->latest()->paginate(10)->withQueryString();

    //     $courses = \App\Models\Course::orderBy('title')->get();

    //     return view('admin.batches.index', compact('batches', 'courses'));
    // }
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
    
        return view('admin.batches.index', compact('batches','courses','allBatches'));
    }

    // Create form
    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        // dd($courses);
        return view('admin.batches.create', compact('courses'));
    }

    // Store batch
    public function store(Request $request)
    {
        
       // dd($request);
        $request->validate([
            // 'course_id' => 'required|array',
            // 'course_id.*' => 'exists:courses,id',
           'bundle_id' => 'required|exists:course_bundles,id',
            'name'             => 'required|unique:batches,name',
            'no_of_live_class' => 'required|integer|min:1',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB limit
        ]);
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/batch/thumbnail'), $fileName);
            $thumbnailPath = 'uploads/batch/thumbnail/' . $fileName;
        }
           $bundle = CourseBundle::findOrFail($request->bundle_id);

            $courseIds = json_decode($bundle->course_ids, true);
        Batch::create([
            'user_id'          => auth()->id(),
            'course_id'        => json_encode($courseIds),
            'name'             => $request->name,
            'no_of_live_class' => $request->no_of_live_class,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'batch_price'      => $request->batch_price,
            'description'      => $request->description,
            'status'           => $request->status,
            'thumbnail'        => $thumbnailPath,
        ]);

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch created successfully');
    }

    // Edit
    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        $courses = Course::where('status', 'active')->get();
        return view('admin.batches.edit', compact('batch', 'courses'));
    }

    // Update
    // public function update(Request $request, $id)
    // {
    //     $batch = Batch::findOrFail($id);

    //     $request->validate([
    //         'course_id'   => 'required|array',
    //         'course_id.*' => 'exists:courses,id',

    //         'name' => [
    //             'required',
    //             'string',
    //             'max:50',
    //             Rule::unique('batches', 'name')->ignore($batch->id),
    //         ],

    //         'no_of_live_class' => 'required|integer|min:1',
    //         'start_date'       => 'required|date|after_or_equal:today',
    //         'end_date'         => 'required|date|after:start_date',
    //     ]);

    //     $batch->update([
    //         'course_id'        => json_encode($request->course_id),
    //         'user_id'          => auth()->id(),
    //         'name'             => trim($request->name),
    //         'start_date'       => $request->start_date,
    //         'end_date'         => $request->end_date,
    //         'no_of_live_class' => $request->no_of_live_class,
    //         'batch_price'      => $request->batch_price,
    //         'description'      => $request->description,
    //         'status'           => $request->status,
    //     ]);

    //     return redirect()->route('admin.batch.index')
    //         ->with('success', 'Batch updated successfully');
    // }
    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            // 'course_id'   => 'required|array',
            // 'course_id.*' => 'exists:courses,id',
             'bundle_id' => 'required|exists:course_bundles,id',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('batches', 'name')->ignore($batch->id),
            ],
            'no_of_live_class' => 'required|integer|min:1',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
            'thumbnail'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // optional on update
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($batch->thumbnail && file_exists(public_path($batch->thumbnail))) {
                unlink(public_path($batch->thumbnail));
            }

            $file = $request->file('thumbnail');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/batch/thumbnail'), $fileName);
            $batch->thumbnail = 'uploads/batch/thumbnail/' . $fileName;
        }
        
         $bundle = CourseBundle::findOrFail($request->bundle_id);
         $courseIds = json_decode($bundle->course_ids, true);


        $batch->update([
            // 'course_id'        => json_encode($request->course_id),
            'course_id'        => json_encode($courseIds),
            'user_id'          => auth()->id(),
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
        $batches = \App\Models\Batch::where('course_id', $request->course_id)
            ->where('status', 1)
            ->get();

        if ($batches->count() == 0) {
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
