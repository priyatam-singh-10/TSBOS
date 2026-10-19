<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use App\Models\LiveClassLesson;
use App\Models\LiveClassSchedule;


class MyCoursesController extends Controller
{
    // public function index()
    // {

    //     $page_data['my_courses'] = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
    //         ->join('users', 'courses.user_id', '=', 'users.id')
    //         ->where('enrollments.user_id', auth()->user()->id)
    //         ->whereRaw('enrollments.id = (SELECT MAX(e.id) FROM enrollments e WHERE e.user_id = enrollments.user_id AND e.course_id = enrollments.course_id)')
    //         ->select('enrollments.*', 'courses.slug', 'courses.title', 'courses.thumbnail', 'users.name as user_name', 'users.photo as user_photo')
    //         ->paginate(6);

    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_courses.index';
    //     return view($view_path, $page_data);
    // }
    public function index()
    {
        $page_data['my_courses'] = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('users', 'courses.user_id', '=', 'users.id')
            ->where('enrollments.user_id', auth()->user()->id)

            // ✅ only course purchase (no batch)
            ->whereNull('enrollments.batch_id')

            ->whereRaw('enrollments.id = (
            SELECT MAX(e.id)
            FROM enrollments e
            WHERE e.user_id = enrollments.user_id
            AND e.course_id = enrollments.course_id
        )')

            ->select(
                'enrollments.*',
                'courses.slug',
                'courses.title',
                'courses.thumbnail',
                'users.name as user_name',
                'users.photo as user_photo'
            )
            ->paginate(6);

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_courses.index';

        return view($view_path, $page_data);
    }

    // public function MyBatchwiseCourse()
    // {
    //     $user_id = auth()->user()->id;

    //     // Get all enrollments for this user that have a batch
    //     $enrollments = Enrollment::where('user_id', $user_id)
    //         ->whereNotNull('batch_id')
    //         ->with([
    //             'batch' => function ($q) {
    //                 $q->select('id', 'name', 'course_id', 'thumbnail');
    //             }
    //         ])
    //         ->get();

    //     $my_courses = [];

    //     foreach ($enrollments as $enrollment) {
    //         $batch = $enrollment->batch;
    //         if (!$batch) continue;

    //         // Decode JSON course_id into array
    //         $course_ids = json_decode($batch->course_id, true) ?? [];
    //         if (!is_array($course_ids)) {
    //             $course_ids = [$course_ids];
    //         }

    //         if (count($course_ids) === 0) continue;

    //         // Fetch all courses in this batch
    //         $courses = \App\Models\Course::whereIn('id', $course_ids)
    //             ->with('creator:id,name,photo') // eager load creator
    //             ->get();

    //         // Prepare course titles as comma-separated string
    //         $course_titles = $courses->pluck('title')->implode(', ');

    //         // Optionally, you can also include thumbnails or other data in arrays if needed
    //         $my_courses[] = [
    //             'batch_id'    => $batch->id,
    //             'batch_name'  => $batch->name,
    //             'batch_thumbnail' => $batch->thumbnail,
    //             'course_ids'  => $courses->pluck('id')->toArray(),
    //             'course_titles' => $course_titles,
    //             'courses'     => $courses, // optional, you can keep full course objects if needed
    //         ];
    //     }

    //     // Manual pagination
    //     $page = request()->get('page', 1);
    //     $perPage = 6;
    //     $offset = ($page - 1) * $perPage;

    //     $paginated_courses = new \Illuminate\Pagination\LengthAwarePaginator(
    //         array_slice($my_courses, $offset, $perPage),
    //         count($my_courses),
    //         $perPage,
    //         $page,
    //         ['path' => request()->url(), 'query' => request()->query()]
    //     );

    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_courses.my_batchwise_courses';
    //     return view($view_path, ['my_courses' => $paginated_courses]);
    // }
    public function MyBatchwiseCourse()
    {
        $user_id = auth()->user()->id;

        $enrollments = Enrollment::where('user_id', $user_id)
            ->whereNotNull('batch_id')
            ->with([
                'batch' => function ($q) {
                    $q->select('id', 'name', 'course_id', 'thumbnail');
                }
            ])
            ->get();

        $my_courses = [];

        foreach ($enrollments as $enrollment) {

            $batch = $enrollment->batch;
            if (!$batch) continue;

            // JSON course ids
            $course_ids = json_decode($batch->course_id, true) ?? [];

            if (!is_array($course_ids)) {
                $course_ids = [$course_ids];
            }

            if (empty($course_ids)) continue;

            // 👉 Only course titles
            $course_titles = \App\Models\Course::whereIn('id', $course_ids)
                ->pluck('title')
                ->implode(', ');

            // 👉 Prevent duplicate batches
            if (!isset($my_courses[$batch->id])) {

                $my_courses[$batch->id] = [
                    'batch_id'        => $batch->id,
                    'batch_name'      => $batch->name,
                    'batch_thumbnail' => $batch->thumbnail,
                    'course_titles'   => $course_titles,
                ];
            }
        }

        // reset array index
        $my_courses = array_values($my_courses);

        // Pagination
        $page = request()->get('page', 1);
        $perPage = 6;

        $paginated_courses = new \Illuminate\Pagination\LengthAwarePaginator(
            array_slice($my_courses, ($page - 1) * $perPage, $perPage),
            count($my_courses),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
        
        //dd($paginated_courses);

        $view_path =
            'frontend.' .
            get_frontend_settings('theme') .
            '.student.my_courses.my_batchwise_courses';

        return view($view_path, [
            'my_courses' => $paginated_courses
        ]);
    }
    
  public function liveClassPlayer($batch_id)
{
    $recorded_classes = LiveClassLesson::with('schedule')
        ->where('batch_id', $batch_id)
        ->where('lesson_type', 'vimeo-url')
        ->whereNotNull('lesson_src')
        ->get();

    $upcoming_classes = LiveClassSchedule::where('batch_id', $batch_id)
        ->where('class_date_and_time', '>=', now()->subHours(1))
        ->orderBy('class_date_and_time', 'asc')
        ->get();

    return view('frontend.default.student.my_courses.live_class_player', compact('recorded_classes', 'upcoming_classes'));
}
}
