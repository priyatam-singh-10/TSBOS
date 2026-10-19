<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\LiveClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiveClassScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = LiveClassSchedule::with('batch')->latest();

        // Batch Filter
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        $schedules = $query->get();

        // batches dropdown ke liye
        $batches = Batch::select('id', 'name')->get();

        return view(
            'admin.live_class_schedule.index',
            compact('schedules', 'batches')
        );
    }

    public function admin_create()
    {
        $batches = Batch::all();

        return view('admin.live_class_schedule.create', compact('batches'));
    }

    public function live_class_start($id)
    {
        $live_class = LiveClassSchedule::where('id', $id)->first();

        if ($live_class->provider == 'zoom') {
            if (get_settings('zoom_web_sdk') == 'active') {
                return view('course_player.live_class.zoom_live_class', ['live_class' => $live_class]);
            } else {
                $meeting_info = json_decode($live_class->additional_info, true);
                return redirect($meeting_info['start_url']);
            }
        } else {
            return view('course_player.live_class.zoom_live_class', ['live_class' => $live_class]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
            'class_date_and_time' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        $thumbnail = null;

        /* Upload Thumbnail */
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('live_class_schedule', 'public');
        }

        /* ===== GET BATCH ===== */
        $batch = Batch::with('course')->findOrFail($request->batch_id);

        /* ===== AUTO COURSE FROM BATCH ===== */
        // $course = $batch->course;

        /* Default Provider */
        $provider = 'zoom';
        $additional_info = null;

        /* Topic auto generate */
        $topic = 'Live Class - '
            . ($batch->name ?? '')
            . ' | '
            . ($request->title ?? '');

        $meeting_info = $this->create_zoom_live_class(
            $topic,
            $request->class_date_and_time
        );

        $meeting_info_arr = json_decode($meeting_info, true);

        /* Zoom Error Handle */
        if (isset($meeting_info_arr['code'])) {
            return back()->with('error', $meeting_info_arr['message']);
        }

        $additional_info = $meeting_info;

        /* ===== SAVE ===== */
        $liveClass = LiveClassSchedule::create([
            // 'course_id' => $course->id,
            'batch_id' => $batch->id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'curriculum' => $request->curriculum,
            'provider' => $provider,
            'class_date_and_time' => $request->class_date_and_time,
            'additional_info' => $additional_info,
        ]);

        $this->sendBatchZoomReminder($liveClass->id);

        return redirect()
            ->route('admin.live-class-schedule.list')
            ->with('success', 'Live Class Created Successfully');
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'batch_id' => 'required',
    //         'class_date_and_time' => 'required',
    //         'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
    //     ]);

    //     $thumbnail = null;

    //     /* Upload Thumbnail */
    //     if ($request->hasFile('thumbnail')) {
    //         $thumbnail = $request->file('thumbnail')
    //             ->store('live_class_schedule', 'public');
    //     }

    //     /* ===== GET BATCH ===== */
    //     $batch = Batch::findOrFail($request->batch_id);

    //     /* ===== MULTIPLE COURSE IDS ===== */
    //     $course_ids = $batch->course_id;

    //     // safety (because JSON string store ho raha hai)
    //     if (is_string($course_ids)) {
    //         $course_ids = json_decode($course_ids, true);
    //     }

    //     if (is_int($course_ids)) {
    //         $course_ids = [$course_ids];
    //     }

    //     $course_ids = is_array($course_ids) ? $course_ids : [];

    //     /* Default Provider */
    //     $provider = 'zoom';

    //     /* Topic auto generate */
    //     $topic = 'Live Class - '
    //         . ($batch->name ?? '')
    //         . ' | '
    //         . ($request->title ?? '');

    //     $meeting_info = $this->create_zoom_live_class(
    //         $topic,
    //         $request->class_date_and_time
    //     );

    //     $meeting_info_arr = json_decode($meeting_info, true);

    //     /* Zoom Error Handle */
    //     if (isset($meeting_info_arr['code'])) {
    //         return back()->with('error', $meeting_info_arr['message']);
    //     }

    //     /* ===== SAVE FOR EACH COURSE ===== */
    //     foreach ($course_ids as $course_id) {

    //         $liveClass = LiveClassSchedule::create([
    //             'course_id' => $course_id,
    //             'batch_id' => $batch->id,
    //             'title' => $request->title,
    //             'price' => $request->price,
    //             'description' => $request->description,
    //             'thumbnail' => $thumbnail,
    //             'curriculum' => $request->curriculum,
    //             'provider' => $provider,
    //             'class_date_and_time' => $request->class_date_and_time,
    //             'additional_info' => $meeting_info,
    //         ]);

    //         $this->sendBatchZoomReminder($liveClass->id);
    //     }

    //     return redirect()
    //         ->route('admin.live-class-schedule.list')
    //         ->with('success', 'Live Class Created Successfully');
    // }

    public function admin_edit($id)
    {
        $liveClass = LiveClassSchedule::findOrFail($id);
        $batches = Batch::all();

        return view('admin.live_class_schedule.edit', compact('liveClass', 'batches'));
    }

    // public function update(Request $request, $id)
    // {
    //     $schedule = LiveClassSchedule::findOrFail($id);

    //     $request->validate([
    //         'course_id' => 'required',
    //         'batch_id' => 'required',
    //         'price' => 'required|numeric',
    //         'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
    //     ]);

    //     if ($request->hasFile('thumbnail')) {
    //         $schedule->thumbnail =
    //             $request->file('thumbnail')->store('live_class_schedule', 'public');
    //     }

    //     $schedule->update([
    //         'course_id' => $request->course_id,
    //         'batch_id' => $request->batch_id,
    //         'price' => $request->price,
    //         'description' => $request->description,
    //         'provider' => 'zoom',
    //         'class_date_and_time' => $request->class_date_and_time,
    //         // 'additional_info' => $request->additional_info,
    //     ]);

    //     return redirect()->route('admin.live-class-schedule.list')
    //         ->with('success', 'Updated Successfully');
    // }
    public function update(Request $request, $id)
    {
        $schedule = LiveClassSchedule::findOrFail($id);

        $request->validate([
            'batch_id' => 'required',
            'class_date_and_time' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ]);


        if ($request->hasFile('thumbnail')) {

            if (
                $schedule->thumbnail &&
                \Storage::disk('public')->exists($schedule->thumbnail)
            ) {
                \Storage::disk('public')->delete($schedule->thumbnail);
            }

            $schedule->thumbnail =
                $request->file('thumbnail')->store('live_class_schedule', 'public');
        }



        $batch = \App\Models\Batch::with('course')
            ->findOrFail($request->batch_id);

        // $course = $batch->course;

        $topic = 'Live Class - '
            . ($batch->name ?? '')
            . ' | '
            . ($request->title  ?? '');



        $additional_info = json_decode($schedule->additional_info, true);

        $meetingId = $additional_info['id'] ?? null;


        if ($meetingId) {

            $zoom_response = $this->update_zoom_live_class(
                $topic,
                $request->class_date_and_time,
                $meetingId
            );

            $zoom_response_arr = json_decode($zoom_response, true);

            if (isset($zoom_response_arr['code'])) {
                return back()->with('error', $zoom_response_arr['message']);
            }
        }


        $schedule->update([
            // 'course_id' => $course->id,
            'batch_id' => $batch->id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'provider' => 'zoom',
            'class_date_and_time' => $request->class_date_and_time,
            'thumbnail' => $schedule->thumbnail,
        ]);

        $this->sendBatchZoomReminder($schedule->id);

        return redirect()
            ->route('admin.live-class-schedule.list')
            ->with('success', 'Live Class Updated Successfully');
    }

    public function create_zoom_live_class($topic, $date_and_time)
    {
        $zoom_account_email = get_settings('zoom_account_email');
        $token              = $this->create_zoom_token();
        if (!$token) {
            return json_encode([
                'code' => 401,
                'message' => 'Zoom connection failed. Please check Zoom API credentials.',
            ]);
        }
        // API Endpoint for creating a meeting
        $zoomEndpoint = 'https://api.zoom.us/v2/users/me/meetings';

        // Meeting data
        $meetingData = [
            'topic'        => $topic,
            'schedule_for' => $zoom_account_email,
            'type'         => 2, // Scheduled meeting
            'start_time' => date('Y-m-d\TH:i:s', strtotime($date_and_time)), // Start time (in UTC)
            'duration' => 60, // Duration in minutes
            'timezone' => get_settings('timezone'), // Timezone
            'settings' => [
                'approval_type'    => 2,
                'join_before_host' => true,
                'jbh_time'         => 0,
            ],
        ];
        // Prepare headers
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        // Make POST request to create meeting
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoomEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON response
        return $response;
    }
    public function update_zoom_live_class($topic, $date_and_time, $meetingId)
    {
        $token = $this->create_zoom_token(); // Obtain the access token

        // API Endpoint for updating a meeting
        $zoomEndpoint = 'https://api.zoom.us/v2/meetings/' . $meetingId;

        // Meeting data with updated start time
        $meetingData = [
            'topic'      => $topic,
            'start_time' => date('Y-m-d\TH:i:s', strtotime($date_and_time)), // New start time (in UTC)
        ];

        // Prepare headers
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        // Make PATCH request to update meeting
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoomEndpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON response
        return $response;
    }

    public function create_zoom_token()
    {
        // Access the environment variables
        $clientId     = get_settings('zoom_client_id');
        $clientSecret = get_settings('zoom_client_secret');
        $accountId    = get_settings('zoom_account_id');

        if (!$clientId || !$clientSecret || !$accountId) {
            return null;
        }
        $oauthUrl     = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId; // Replace with your OAuth endpoint URL
        $authHeader = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $authHeader,
                'Cookie: __cf_bm=kn5ec2sntPlDgQWVWtSYdPeISb6bp6F7NHwuAFJQaGk-1736318967-1.0.1.1-SeM4z5pIb.nrMno35jg3y5BdXib.GPP13s2_yNnqz6LxbU9zsFTfZQc3a_Di94qx3DoyQjBT2Osz7idFMWWOrw; _zm_chtaid=816; _zm_ctaid=nbT15WlMTsCEAgCyUg3rYw.1736318967206.63747957ef3128f771210fb69e8d6831; _zm_mtk_guid=fa77ae1ac8e349bea690b72d942d6de6; _zm_page_auth=us04_c_uqPDVOshQQK6FRkhQPiPRA; _zm_ssid=us04_c_atJ4QboaQZG4Lw4U-Wpx6A; cred=A404810ADF33AFC21FF517216A4CB862'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if (!$response) {
            return null;
        }
        $oauthResponse = json_decode($response, true) ?? ['access_token' => ''];
        if (!isset($oauthResponse['access_token'])) {
            return null; //
        }
        $accessToken   = $oauthResponse['access_token'];
        return $accessToken;
    }

    public function destroy($id)
    {
        LiveClassSchedule::destroy($id);
        return back()->with('success', 'Deleted Successfully');
    }


    public function sendBatchZoomReminder($liveClassId)
    {

        $liveClass = DB::table('live_class_schedules')
            ->where('id', $liveClassId)
            ->first();

        if (!$liveClass) {
            Log::error("Live class not found for ID: {$liveClassId}");
            return false;
        }

        $batch = DB::table('batches')
            ->where('id', $liveClass->batch_id)
            ->first();

        $batchName = $batch ? $batch->name : 'N/A';

        // ✅ Decode Zoom data
        $additionalInfo = json_decode($liveClass->additional_info, true);

        $joinUrl = $additionalInfo['join_url'] ?? null;
        $classTopic = $additionalInfo['topic'] ?? ($liveClass->title ?? 'Live Class');

        $classDateTime = $liveClass->class_date_and_time;

        $formattedDate = date('d M Y', strtotime($classDateTime));
        $formattedTime = date('h:i A', strtotime($classDateTime));

        // Schedule me course_id save nahi hota (null), isliye batch_id se students lao
        $enrolledUsers = DB::table('enrollments')
            ->where('enrollments.batch_id', $liveClass->batch_id)
            ->join('users', 'enrollments.user_id', '=', 'users.id')
            ->whereNotNull('users.phone')
            ->where('users.phone', '!=', '')
            ->select('users.id as user_id', 'users.phone', 'users.name')
            ->distinct()
            ->get()
            ->unique('phone')
            ->values();

        if ($enrolledUsers->isEmpty()) {
            Log::warning("WhatsApp reminder skipped: no enrolled users with phone for live class ID {$liveClassId}, batch_id {$liveClass->batch_id}");
            return false;
        }

        foreach ($enrolledUsers as $user) {

            $phone = preg_replace('/\D+/', '', (string) $user->phone);
            if ($phone === '') {
                Log::warning("WhatsApp reminder skipped: empty phone for user {$user->name}");
                continue;
            }

            // In 2 students ko WhatsApp meeting link nahi bhejna
            $excludePhones = [
                '919827176645',
                '919644376393',

            ];
            if (in_array($phone, $excludePhones, true)) {
                Log::info("WhatsApp reminder skipped (excluded): {$user->name} ({$phone})");
                continue;
            }

            $message =
                "🔔 *Live Class Enrollment Confirmation* 🔔\n\n" .
                "Hello *{$user->name}*,\n\n" .
                "Your live class *\"{$classTopic}\"* for batch *\"{$batchName}\"* is scheduled for:\n\n" .
                "📅 *Date:* {$formattedDate}\n" .
                "⏰ *Time:* {$formattedTime}\n\n" .
                "🔗 *Join the class here:*\n{$joinUrl}\n\n" .
                "See you in class! 🚀\n" .
                "Team TSBOS";

            try {
                $response = \App\Services\WhatsappService::sendViaGet($phone, $message);
                if ($response === false) {
                    Log::error("WhatsApp send failed for {$user->name} ({$phone}): no response");
                    continue;
                }

                Log::info("WhatsApp reminder sent to {$user->name} ({$phone}). Response: {$response}");
            } catch (\Exception $e) {
                Log::error("WhatsApp send failed: " . $e->getMessage());
            }
        }

        return true;
    }
}
