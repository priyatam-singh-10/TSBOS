<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\BootcampCategory;
use App\Models\BootcampLiveClass;
use App\Models\BootcampModule;
use App\Models\BootcampPurchase;
use App\Models\FileUploader;
use App\Models\SeoField;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BootcampController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }

    public function index(Request $request, $type = '')
    {
        $query = Bootcamp::join('bootcamp_categories', 'bootcamps.category_id', 'bootcamp_categories.id')

            //  Live class join
            ->leftJoin('bootcamp_live_classes', 'bootcamp_live_classes.module_id', '=', 'bootcamps.id')

            ->select(
                'bootcamps.*',
                'bootcamp_categories.title as category',
                'bootcamp_categories.slug as category_slug',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(bootcamp_live_classes.joining_data,'$.start_url')) as start_url")
            )

            ->where('bootcamps.user_id', auth()->user()->id);

        // search
        if ($request->search) {
            $query->where('bootcamps.title', 'LIKE', "%{$request->search}%");
        }

        // category
        if ($request->category && $request->category != 'all') {
            $category = BootcampCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('bootcamps.category_id', $category->id);
            }
        }

        // status
        if ($request->status && $request->status != 'all') {
            $query->where('bootcamps.status', $request->status == 'active' ? 1 : 0);
        }

        // instructor
        if ($request->instructor && $request->instructor != 'all') {
            $query->where('bootcamps.user_id', $request->instructor);
        }

        // bootcamp filter
        if ($request->bootcamp_id && $request->bootcamp_id != 'all') {
            $query->where('bootcamps.id', $request->bootcamp_id);
        }

        // date filter
        if ($request->from_date) {
            $query->whereDate('bootcamps.created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('bootcamps.created_at', '<=', $request->to_date);
        }

        // price
        if ($request->price && $request->price != 'all') {
            if ($request->price == 'free') {
                $query->where('bootcamps.is_paid', 0);
            } elseif ($request->price == 'discounted') {
                $query->where('bootcamps.discount_flag', 1);
            } elseif ($request->price == 'paid') {
                $query->where('bootcamps.is_paid', 1);
            }
        }

        $page_data['bootcamps'] = $query->get();

        return view('admin.bootcamp.index', $page_data);
    }

    public function create()
    {
        return view('admin.bootcamp.create');
    }

    public function edit($id)
    {
        $bootcamp = Bootcamp::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$bootcamp) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->route('admin.bootcamps');
        }

        $modules = BootcampModule::where('bootcamp_id', $id)
            ->orderBy('sort', 'asc')
            ->get();

        // 👉 live classes nikal lo
        $live_classes = BootcampLiveClass::whereIn(
            'module_id',
            $modules->pluck('id')
        )->get();

        // 👉 URL add kar do
        foreach ($live_classes as $class) {

            $meeting_info = json_decode($class->joining_data, true);

            $class->join_url = get_settings('zoom_web_sdk') == 'active'
                ? route('admin.webinar.live.class.join', $class->slug)
                : ($meeting_info['start_url'] ?? '');
        }

        $page_data['bootcamp_details'] = $bootcamp;
        $page_data['modules'] = $modules;
        $page_data['live_classes'] = $live_classes;

        return view('admin.bootcamp.edit', $page_data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'            => 'required|string',
            'description'      => 'nullable|string',
            'category_id'      => 'nullable',
            'is_paid'          => Rule::in(['0', '1']),
            'price'            => 'required_if:is_paid,1|min:1|nullable|numeric',
            'discount_flag'    => Rule::in(['', '1']),
            'discounted_price' => 'required_if:discount_flag,1|min:1|nullable|numeric|lt:price',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = Bootcamp::where('user_id', auth()->user()->id)->where('title', $request->title)->first();
        if ($title) {
            Session::flash('error', get_phrase('This title has been taken.'));
            return redirect()->back();
        }

        $data['user_id']           = auth()->user()->id;
        $data['title']             = $request->title;
        $data['slug']              = slugify($request->title);
        $data['short_description'] = $request->short_description;
        $data['description']       = $request->description;
        $data['publish_date']      = Carbon::createFromFormat('Y-m-d', $request->publish_date)->timestamp;
        $data['category_id']       = $request->category_id;
        $data['is_paid']           = $request->is_paid;
        $data['price']             = $request->price;
        $data['discount_flag']     = $request->discount_flag;
        $data['discounted_price']  = $request->discounted_price;
        $data['status']            = 1;

        if ($request->thumbnail) {
            $data['thumbnail'] = "uploads/bootcamp/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
            FileUploader::upload($request->thumbnail, $data['thumbnail']);
        }

        $insert_id = Bootcamp::insertGetId($data);
        $module_data['title']       = $request->title; // same as bootcamp title
        $module_data['bootcamp_id'] = $insert_id;
        $module_data['restriction'] = null;
        $module_data['publish_date'] = strtotime($request->publish_date);
        $module_data['expiry_date']  = null; // or set same as publish_date if needed
        $module_data['sort']         = 1;

        BootcampModule::insert($module_data);

        Session::flash('success', get_phrase('Webinar has been created.'));
        return redirect()->route('admin.webinar.edit', [$insert_id, 'tab' => 'basic']);
    }

    public function delete($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);
        if ($bootcamp->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $bootcamp->delete();
        Session::flash('success', get_phrase('Webinar has been deleted.'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $query = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);

        if ($query->doesntExist() || $request->tab == '') {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $rules = $data = [];
        if ($request->tab == 'basic') {
            $rules = [
                'title'       => 'required|string',
                'description' => 'nullable|string',
                'category_id' => 'nullable',
            ];

            $data['title']             = $request->title;
            $data['slug']              = slugify($request->title);
            $data['short_description'] = $request->short_description;
            $data['description']       = $request->description;
            $data['publish_date']      = Carbon::createFromFormat('Y-m-d', $request->publish_date)->timestamp;
            $data['category_id']       = $request->category_id;

            $rules = [
                'is_paid'          => Rule::in(['0', '1']),
                'price'            => 'required_if:is_paid,1|min:1|nullable|numeric',
                'discount_flag'    => Rule::in(['', '1']),
                'discounted_price' => 'required_if:discount_flag,1|min:1|nullable|numeric|lt:price',
            ];

            $data['is_paid']          = $request->is_paid;
            $data['price']            = $request->price;
            $data['discount_flag']    = $request->discount_flag;
            $data['discounted_price'] = $request->discounted_price;

            $title = Bootcamp::where('user_id', auth()->user()->id)
                ->where('id', '!=', $id)
                ->where('title', $request->title)->first();
            if ($title) {
                Session::flash('error', get_phrase('This title has been taken.'));
                return redirect()->back();
            }
        } elseif ($request->tab == 'info') {
            $rules = [
                'requirements' => 'array',
                'outcomes'     => 'array',
                'faqs'         => 'array',
            ];

            //Remove empty value by using array filter function
            $data['requirements'] = json_encode(array_filter($request->requirements, fn($value) => ! is_null($value) && $value !== ''));
            $data['outcomes']     = json_encode(array_filter($request->outcomes, fn($value) => ! is_null($value) && $value !== ''));

            $faqs = [];
            foreach ($request->faq_title as $key => $title) {
                if ($title != '') {
                    $faqs[] = ['title' => $title, 'description' => $request->faq_description[$key]];
                }
            }
            $data['faqs'] = json_encode($faqs);
        } elseif ($request->tab == 'media') {
            if ($request->thumbnail) {
                $data['thumbnail'] = "uploads/bootcamp/thumbnail/" . nice_file_name($request->title, $request->thumbnail->extension());
                FileUploader::upload($request->thumbnail, $data['thumbnail']);
                remove_file($query->first()->thumbnail);
            }
        } elseif ($request->tab == 'seo') {
            $bootcamp_details = $query->first();
            $SeoField         = SeoField::where('bootcamp_id', $bootcamp_details->id)->first();

            $seo_data['bootcamp_id']        = $id;
            $seo_data['route']            = 'Webinar Details';
            $seo_data['name_route']       = 'webinar.details';
            $seo_data['meta_title']       = $request->meta_title;
            $seo_data['meta_description'] = $request->meta_description;
            $seo_data['meta_robot']       = $request->meta_robot;
            $seo_data['canonical_url']    = $request->canonical_url;
            $seo_data['custom_url']       = $request->custom_url;
            $seo_data['json_ld']          = $request->json_ld;
            $seo_data['og_title']         = $request->og_title;
            $seo_data['og_description']   = $request->og_description;
            $seo_data['created_at']       = date('Y-m-d H:i:s');
            $seo_data['updated_at']       = date('Y-m-d H:i:s');

            $meta_keywords_arr = json_decode($request->meta_keywords, true);
            $meta_keywords     = '';
            if (is_array($meta_keywords_arr)) {
                foreach ($meta_keywords_arr as $arr_key => $arr_val) {
                    $meta_keywords .= $meta_keywords == '' ? $arr_val['value'] : ', ' . $arr_val['value'];
                }
                $seo_data['meta_keywords'] = $meta_keywords;
            }

            if ($request->og_image) {
                $originalFileName = $bootcamp_details->id . '-' . $request->og_image->getClientOriginalName();
                $destinationPath  = 'uploads/seo-og-images/' . $originalFileName;
                // Move the file to the destination path
                FileUploader::upload($request->og_image, $destinationPath, 600);
                $seo_data['og_image'] = $destinationPath;
            }

            if ($SeoField) {
                if ($request->og_image) {
                    remove_file($SeoField->og_image);
                }
                SeoField::where('bootcamp_id', $bootcamp_details->id)->update($seo_data);
            } else {
                SeoField::insert($seo_data);
            }
        }

        //For ajax form submission
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $query->update($data);

        //For ajax form submission
        // return ['success' => get_phrase('Course updated successfully')];

        //for normal form submission
        Session::flash('success', get_phrase('Webinar has been updated successfully.'));
        return redirect()->back();
    }

    public function duplicate($id)
    {
        $bootcamp = Bootcamp::where('id', $id);
        if ($bootcamp->doesntExist()) {
            Session::flash('success', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $bootcamp            = $bootcamp->first()->toArray();
        $bootcamp['title']   = $bootcamp['title'] . ' copy';
        $bootcamp['slug']    = slugify($bootcamp['title']);
        $bootcamp['user_id'] = auth()->user()->id;
        $bootcamp['status']  = 1;
        unset($bootcamp['id'], $bootcamp['created_at'], $bootcamp['updated_at']);

        $insert_id = Bootcamp::insertGetId($bootcamp);

        Session::flash('success', get_phrase('Webinar has been duplicated.'));
        return redirect()->route('admin.bootcamp.edit', [$insert_id, 'tab' => 'basic']);
    }

    public function status($id)
    {
        $bootcamp = Bootcamp::where('id', $id)->where('user_id', auth()->user()->id);
        if ($bootcamp->doesntExist()) {
            $response = [
                'error' => get_phrase('Data not found.'),
            ];
            return json_encode($response);
        }

        $status = $bootcamp->first()->status ? 0 : 1;
        Bootcamp::where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with('success', get_phrase('Status has been updated.'));
    }

    public function purchase_history()
    {
        $page_data['purchases'] = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->select(
                'bootcamp_purchases.*',
                'bootcamps.user_id as author',
                'bootcamps.title',
                'bootcamps.slug',
                'bootcamps.price as amount',
            )
            ->latest('bootcamp_purchases.id')->paginate(20)->appends(request()->query());

        return view('admin.bootcamp.purchase_history', $page_data);
    }

    public function invoice($id)
    {
        $invoice = BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
            ->where('bootcamp_purchases.id', $id)
            ->select(
                'bootcamp_purchases.*',
                'bootcamps.title',
                'bootcamps.slug',
            )->first();

        if (! $invoice) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['invoice'] = $invoice;
        return view('admin.bootcamp.invoice', $page_data);
    }
}
