<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\LiveClassSchedule;
use Illuminate\Http\Request;



class LiveClassController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = LiveClassSchedule::with(['course', 'batch'])
    //         ->select('course_id', 'batch_id')
    //         ->groupBy('course_id', 'batch_id');

    //     // Search by Course Name
    //     if ($request->filled('search')) {
    //         $query->whereHas('course', function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     $courses = $query->paginate(9)->withQueryString();

    //     $layout = 'grid';

    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.live_course.index';

    //     return view($view_path, compact('courses', 'layout'));
    // }
    // public function index(Request $request)
    // {
    //     $query = LiveClassSchedule::with(['batch'])
    //         ->distinct('batch_id');

    //     if ($request->filled('search')) {
    //         $query->whereHas('course', function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     $courses = $query
    //         ->latest()
    //         ->paginate(9)
    //         ->withQueryString();

    //     $layout = 'grid';

    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.live_course.index';

    //     return view($view_path, compact('courses', 'layout'));
    // }
    
    

// public function index(Request $request)
// {
//     $query = LiveClassSchedule::with(['batch'])
//         ->whereHas('batch', function ($q) {
//             $q->where('status', 1)
//               ->whereDate('end_date', '>=', now()); // FIX
//         })
//         ->distinct('batch_id');

//     if ($request->filled('search')) {
//         $query->whereHas('course', function ($q) use ($request) {
//             $q->where('title', 'like', '%' . $request->search . '%');
//         });
//     }

//     $courses = $query
//         ->latest()
//         ->paginate(9)
//         ->withQueryString();

//     return view('frontend.' . get_frontend_settings('theme') . '.live_course.index', compact('courses'));
// }

public function index(Request $request)
{
    $query = Batch::query()
        ->where('status', 1)
        ->whereDate('end_date', '>=', now())
        ->whereHas('liveClassSchedules');

    if ($request->filled('search')) {

        $query->get()->filter(function ($batch) use ($request) {

            $batchCourses = $batch->livecourses();

            return $batchCourses->pluck('title')
                ->implode(' ')
                ->contains($request->search);

        });
    }

    $courses = $query
        ->latest()
        ->paginate(9)
        ->withQueryString();

    return view(
        'frontend.' . get_frontend_settings('theme') . '.live_course.index',
        compact('courses')
    );
}
    // public function show($course_id, $batch_id)
    // {
    //     $course = Course::findOrFail($course_id);

    //     $batch = Batch::where('id', $batch_id)
    //         ->whereHas('course', function ($q) use ($course_id) {
    //             $q->where('course_id', $course_id);
    //         })
    //         ->firstOrFail();

    //     // All schedules of this course + batch
    //     $schedules = LiveClassSchedule::with(['lessons'])
    //         ->where('course_id', $course_id)
    //         ->where('batch_id', $batch_id)
    //         ->orderBy('class_date_and_time')
    //         ->get();


    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.live_course.show';

    //     return view($view_path, compact(
    //         'course',
    //         'batch',
    //         'schedules'
    //     ));
    // }
    public function show($batch_id)
    {
        // batch
        $batch = Batch::findOrFail($batch_id);

        // ALL courses from JSON
        $courses = $batch->livecourses(); // ✅ no first()

        // schedules
        $schedules = LiveClassSchedule::with('lessons')
            ->where('batch_id', $batch_id)
            ->orderBy('class_date_and_time')
            ->get();

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.live_course.show';

        return view($view_path, compact(
            'courses',
            'batch',
            'schedules'
        ));
    }
}
