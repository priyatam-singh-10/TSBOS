<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\LiveClassLesson;
use App\Models\LiveClassSchedule;
use Illuminate\Http\Request;

class LiveClassLessonController extends Controller
{
    public function index(Request $request)
    {
        $batches = Batch::all();

        // Course filter based on batch
        if ($request->filled('batch_id')) {
            $courses = Course::whereHas('batches', function ($q) use ($request) {
                $q->where('id', $request->batch_id);
            })->get();
        } else {
            $courses = Course::all();
        }

        $query = LiveClassLesson::with(['batch', 'liveSchedule'])->latest();
        $courseMap = Course::pluck('title', 'id');

        // Batch filter
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        // Course filter
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // ✅ FROM DATE FILTER
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // ✅ TO DATE FILTER
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $lessons = $query->paginate(10)->withQueryString();

        return view(
            'admin.live_class_lessons.index',
            compact('lessons', 'courses', 'batches', 'courseMap')
        );
    }

    public function create()
    {
        $courses = Course::all();
        $batches = Batch::all();

        return view(
            'admin.live_class_lessons.create',
            compact('courses', 'batches')
        );
    }


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'batch_id'   => 'required|exists:batches,id',
            'lesson_src' => 'required',
            'duration'   => 'nullable|string',
        ]);

        $batch = Batch::find($request->batch_id);

        // Check current live classes count
        $currentLiveClasses = LiveClassLesson::where('batch_id', $batch->id)->count();

        if ($currentLiveClasses >= $batch->no_of_live_class) {
            return redirect()
                ->back()
                ->with('error', 'You cannot upload more than ' . $batch->no_of_live_class . ' live classes for this batch.');
        }
        // Get clean Vimeo URL (share/copy links → canonical https://vimeo.com/{id})
        $videoDetails = app(\App\Http\Controllers\CommonController::class)
            ->get_video_details($request, $request->lesson_src);

        if ($videoDetails instanceof \Illuminate\Http\JsonResponse) {
            $videoDetails = $videoDetails->getData(true);
        }
        if (!is_array($videoDetails)) {
            $videoDetails = [];
        }

        $lessonSrc = !empty($videoDetails['video'])
            ? $videoDetails['video']
            : $request->lesson_src;

        // Prepare data array
        $data = [
            'created_by'   => auth()->user()->id,
            // 'course_id'    => $batch->course_id,
            'batch_id'     => $request->batch_id,
            'schedule_id'     => $request->schedule_id,
            'lesson_type'  => 'vimeo-url',
            'video_type'   => 'vimeo',
            'lesson_src'   => $lessonSrc,
        ];

        // Duration formatting
        if (!empty($request->duration)) {
            $duration_parts = explode(':', $request->duration);

            // Ensure 3 parts HH:MM:SS
            $hour = isset($duration_parts[0]) ? sprintf('%02d', $duration_parts[0]) : '00';
            $min  = isset($duration_parts[1]) ? sprintf('%02d', $duration_parts[1]) : '00';
            $sec  = isset($duration_parts[2]) ? sprintf('%02d', $duration_parts[2]) : '00';

            $data['duration'] = $hour . ':' . $min . ':' . $sec;
        } else {
            $data['duration'] = '00:00:00';
        }

        // Create record
        LiveClassLesson::create($data);

        return redirect()
            ->route('admin.live-class-lessons.list')
            ->with('success', 'Live class uploaded successfully');
    }

    public function edit($id)
    {
        $lesson = LiveClassLesson::findOrFail($id);
        $batches = Batch::all();

        $schedules = LiveClassSchedule::where(
            'batch_id',
            $lesson->batch_id
        )->get();

        return view(
            'admin.live_class_lessons.edit',
            compact('lesson', 'batches', 'schedules')
        );
    }

    public function update(Request $request, $id)
    {
        $lesson = LiveClassLesson::findOrFail($id);

        // Validation
        $request->validate([
            'batch_id'   => 'required|exists:batches,id',
            'lesson_src' => 'required',
            'duration'   => 'nullable|string',
        ]);

        $batch = Batch::find($request->batch_id);
        $videoDetails = app(\App\Http\Controllers\CommonController::class)
            ->get_video_details($request, $request->lesson_src);

        if ($videoDetails instanceof \Illuminate\Http\JsonResponse) {
            $videoDetails = $videoDetails->getData(true);
        }
        if (!is_array($videoDetails)) {
            $videoDetails = [];
        }

        $lessonSrc = !empty($videoDetails['video'])
            ? $videoDetails['video']
            : $request->lesson_src;
        // Prepare data array
        $data = [
            // 'course_id'   => $batch->course_id,
            'batch_id'    => $request->batch_id,
            'schedule_id'    => $request->schedule_id,
            'lesson_type' => 'vimeo-url',
            'video_type'  => 'vimeo',
            'lesson_src'  => $lessonSrc,
        ];

        // Duration formatting
        if (!empty($request->duration)) {
            $duration_parts = explode(':', $request->duration);

            $hour = isset($duration_parts[0]) ? sprintf('%02d', $duration_parts[0]) : '00';
            $min  = isset($duration_parts[1]) ? sprintf('%02d', $duration_parts[1]) : '00';
            $sec  = isset($duration_parts[2]) ? sprintf('%02d', $duration_parts[2]) : '00';

            $data['duration'] = $hour . ':' . $min . ':' . $sec;
        } else {
            $data['duration'] = '00:00:00';
        }

        // Update record
        $lesson->update($data);

        return redirect()
            ->route('admin.live-class-lessons.list')
            ->with('success', 'Live class updated successfully');
    }

    public function destroy($id)
    {
        LiveClassLesson::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }

    public function getCoursesByBatch($batchId)
    {
        $courses = Course::whereHas('batches', function ($q) use ($batchId) {
            $q->where('id', $batchId);
        })->get();

        return response()->json($courses);
    }
    public function getTitles($batch_id)
    {
        $titles = LiveClassSchedule::where('batch_id', $batch_id)
            ->select('id', 'title')
            ->get();

        return response()->json($titles);
    }
}
