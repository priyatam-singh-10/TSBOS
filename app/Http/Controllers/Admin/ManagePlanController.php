<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\ManagePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class ManagePlanController extends Controller
{

    public function index(Request $request)
    {
        ManagePlan::whereDate('expiry_date', '<', Carbon::today())
            ->where('status', 1)
            ->update(['status' => 0]);

        $query = ManagePlan::with('course', 'batch');

        // From date filter
        if ($request->from_date) {
            $query->whereDate('expiry_date', '>=', $request->from_date);
        }

        // To date filter
        if ($request->to_date) {
            $query->whereDate('expiry_date', '<=', $request->to_date);
        }

        // Status filter
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // ✅ Active first
        $plans = $query
            ->orderBy('status', 'desc') // active first
            ->orderBy('id', 'desc')
            ->get();
            
        foreach ($plans as $plan) {
            
            $plan->total_students = DB::table('plan_purchase_users')
                ->join('plan_payments', 'plan_payments.purchase_user_id', '=', 'plan_purchase_users.id')
                ->where('plan_purchase_users.course_id', $plan->course_id)
                ->where('plan_purchase_users.batch_id', $plan->batch_id)
                ->where('plan_payments.status', 'success')
                ->count();
        }

        return view('admin.manage_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.manage_plans.create');
    }

    public function store1(Request $request)
    {
        // Validation
        $request->validate([
            'c_id'   => 'required|integer|exists:courses,id',
            'c_price'  => 'required|numeric|min:0',
            'c_expiry' => 'required|date',
            'c_date'   => 'required|date',
            'c_batch'  => 'nullable|string|max:255',
            // 'c_status' => 'required|in:0,1'
        ]);

        $course = Course::findOrFail($request->c_id);

        $plan = new ManagePlan();
        $plan->course_id  = $request->c_id;
        $plan->batch_id  = $request->b_id;
        $plan->code  = Str::slug($course->title) . '-' . rand(100, 999);
        $plan->price = $request->c_price;
        $plan->expiry_date = $request->c_expiry;
        $plan->session_start_date = date('Y-m-d H:i:s', strtotime($request->c_date));
        $plan->batch_time = $request->c_batch;
        $plan->status = 1;
        $plan->save();

        return redirect()->route('admin.manage.plans')
            ->with('success', 'Plan created successfully');
    }
    
    // public function store(Request $request)
    // {
        
      
    //     $request->validate([
    //             'b_id'     => 'required|exists:batches,id',
    //             'c_price'  => 'required|numeric|min:0',
    //             'c_expiry' => 'required|date',
    //             'c_date'   => 'required|date',
    //             'c_batch'  => 'nullable|string|max:255',
    //         ]);
            
    //         $batch = Batch::findOrFail($request->b_id);
            
    //         //  course auto pick
    //         $courseIds = json_decode($batch->course_id, true);
    //         $courseId = is_array($courseIds) && count($courseIds) > 0 ? $courseIds[0] : null;
    //         $course = $courseId ? Course::find($courseId) : null;
              
    //         $plan = new ManagePlan();
    //         $plan->course_id  = $courseId; //  auto
    //         $plan->batch_id   = $request->b_id;
    //         $plan->code       = ($course ? Str::slug($course->title) : 'plan') . '-' . rand(100, 999);
    //         $plan->price      = $request->c_price;
    //         $plan->expiry_date = $request->c_expiry;
    //         $plan->session_start_date = date('Y-m-d H:i:s', strtotime($request->c_date));
    //         $plan->batch_time = $request->c_batch;
    //         $plan->status     = 1;
    //         $plan->save();
    //         // dd($request);
    //      return redirect()->route('admin.manage.plans')
    //         ->with('success', 'Plan created successfully');
    // }
    public function store(Request $request)
{
    $request->validate([
        'b_id'     => 'required|exists:batches,id',
        'c_price'  => 'required|numeric|min:0',
        'c_expiry' => 'required|date',
        'c_date'   => 'required|date',
        'c_batch'  => 'nullable|string|max:255',
    ]);

    // ✅ Duplicate batch check
    $alreadyExists = ManagePlan::where('batch_id', $request->b_id)->exists();

    if ($alreadyExists) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'This batch link already exists');
    }

    $batch = Batch::findOrFail($request->b_id);

    // course auto pick
    $courseIds = json_decode($batch->course_id, true);
    $courseId = is_array($courseIds) && count($courseIds) > 0 ? $courseIds[0] : null;

    $course = $courseId ? Course::find($courseId) : null;

    $plan = new ManagePlan();
    $plan->course_id  = $courseId;
    $plan->batch_id   = $request->b_id;
    $plan->code       = ($course ? Str::slug($course->title) : 'plan') . '-' . rand(100, 999);
    $plan->price      = $request->c_price;
    $plan->expiry_date = $request->c_expiry;
    $plan->session_start_date = date('Y-m-d H:i:s', strtotime($request->c_date));
    $plan->batch_time = $request->c_batch;
    $plan->status     = 1;
    $plan->save();

    return redirect()->route('admin.manage.plans')
        ->with('success', 'Plan created successfully');
}

    // function edit($id)
    // {
    //     return view('admin.manage_plans.edit');
    // }
    public function edit($id)
    {
        return view('admin.manage_plans.edit');
    }

    public function update(Request $request, $id)
    {
        $plan = ManagePlan::findOrFail($id);
        // $course = Course::findOrFail($request->course_id);
        
        $batch = Batch::findOrFail($request->b_id);
        
        $courseIds = json_decode($batch->course_id, true);
        $courseId = is_array($courseIds) && count($courseIds) > 0 ? $courseIds[0] : null;
        $course = $courseId ? Course::find($courseId) : null;

        // $plan->course_id = $request->course_id;
        // $plan->batch_id = $request->b_id;
        // $plan->code  = Str::slug($course->title) . '-' . rand(100, 999);
        
        $plan->course_id = $courseId;
        $plan->batch_id  = $request->b_id;
        $plan->code      = ($course ? Str::slug($course->title) : 'plan') . '-' . rand(100, 999);
        $plan->price = $request->c_price;
        $plan->expiry_date = $request->c_expiry;
        $plan->session_start_date = $request->c_date;
        $plan->batch_time = $request->c_batch;

        // Expire only if expiry date is before today
        $plan->status = Carbon::parse($request->c_expiry)->lt(Carbon::today()) ? 0 : 1;

        $plan->save();

        return redirect()->route('admin.manage.plans')
            ->with('success', 'Plan updated successfully');
    }

    function delete($id)
    {
        $plan = ManagePlan::findOrFail($id);
        $plan->delete();
        return redirect()->route('admin.manage.plans')
            ->with('success', 'Plan deleted successfully');
    }


    public function purchase_history(Request $request)
    {
        $query = DB::table('plan_purchase_users')
            ->join('plan_payments', 'plan_payments.purchase_user_id', '=', 'plan_purchase_users.id')
            ->join('courses', 'courses.id', '=', 'plan_purchase_users.course_id')
            ->leftJoin('batches', 'batches.id', '=', 'plan_purchase_users.batch_id') // ✅ ADD THIS
            ->select(
                'plan_purchase_users.*',
                'plan_payments.payment_id',
                'plan_payments.order_id',
                'plan_payments.amount',
                'plan_payments.status as payment_status',
                'courses.title as course_title',
                'batches.name as batch_name' // ✅ ADD THIS
            );


        // Course Filter
        if ($request->course_id) {
            $query->where('plan_purchase_users.course_id', $request->course_id);
        }
        if ($request->batch_id) {
            $query->where('plan_purchase_users.batch_id', $request->batch_id);
        }

        // Payment Status Filter
        if ($request->payment_status) {
            $query->where('plan_payments.status', $request->payment_status);
        }

        // Date From
        if ($request->from_date) {
            $query->whereDate('plan_purchase_users.created_at', '>=', $request->from_date);
        }

        // Date To
        if ($request->to_date) {
            $query->whereDate('plan_purchase_users.created_at', '<=', $request->to_date);
        }

        // Search
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('plan_purchase_users.first_name', 'like', "%{$search}%")
                    ->orWhere('plan_purchase_users.last_name', 'like', "%{$search}%")
                    ->orWhere('plan_purchase_users.mobile', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(plan_purchase_users.first_name,' ',plan_purchase_users.last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $purchase_history = $query->latest()->get();

        $courses = DB::table('courses')->get();

        return view('admin.manage_plans.purchase_history', compact('purchase_history', 'courses'));
    }
    public function setTop(Request $request)
    {
        // make all plans not top
        DB::table('manage_plans')->update([
            'is_top' => 0
        ]);

        // set selected plan as top
        DB::table('manage_plans')
            ->where('id', $request->plan_id)
            ->update([
                'is_top' => 1
            ]);

        return response()->json([
            'status' => true
        ]);
    }
    public function getCourseByBatch($id)
    {
        $batch = Batch::find($id);

        if (!$batch || empty($batch->course_id)) {
            return response()->json([]);
        }

        // JSON → Array convert
        $courseIds = json_decode($batch->course_id, true);

        if (!is_array($courseIds)) {
            return response()->json([]);
        }

        $courses = Course::whereIn('id', $courseIds)
            ->where('status', 'active')
            ->select('id', 'title')
            ->get();

        return response()->json($courses);
    }
}
