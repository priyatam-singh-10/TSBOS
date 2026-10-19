<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bootcamp;
use App\Models\BootcampLiveClass;
use App\Models\BootcampModule;
use App\Models\BootcampResource;
use App\Models\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BootcampResourceController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'module_id'   => 'required|numeric',
            'upload_type' => 'required|in:resource,record',
        ];

        if ($request->upload_type == 'resource') {
            $rules['files']   = 'required|array';
            $rules['files.*'] = 'required|file';
        }

        if ($request->upload_type == 'record') {
            $rules['vimeo_url'] = 'required|url';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $module = BootcampModule::join('bootcamps', 'bootcamp_modules.bootcamp_id', 'bootcamps.id')
            ->select('bootcamp_modules.*', 'bootcamps.title as bootcamp_title')
            ->where('bootcamp_modules.id', $request->module_id)
            ->first();

        if (!$module) {
            Session::flash('error', get_phrase('Module not found.'));
            return redirect()->back();
        }

        // =====================================
        // RECORD (VIMEO LINK)
        // =====================================
        if ($request->upload_type == 'record') {

            preg_match('/vimeo\.com\/(\d+)/', $request->vimeo_url, $matches);
            $videoId = $matches[1] ?? null;

            if (!$videoId) {
                Session::flash('error', get_phrase("Invalid Vimeo URL."));
                return redirect()->back();
            }

            $title = $module->title;

            $data = [
                'module_id'   => $module->id,
                'upload_type' => 'record',
                'title'       => $title,
                'video_url'   => $videoId,
                'file'        => $request->vimeo_url,
                'duration'    => $request->duration ?? 0
            ];

            //  Check if same module + title already exists
            $existing = BootcampResource::where('module_id', $module->id)
                ->where('title', $title)
                ->first();

            if ($existing) {

                // Just update existing record
                $existing->update($data);

                Session::flash('success', get_phrase('Video updated successfully.'));
                return redirect()->back();
            }

            // otherwise create new
            BootcampResource::create($data);

            Session::flash('success', get_phrase('Video added successfully.'));
            return redirect()->back();
        }
        // =====================================
        // RESOURCE (FILE UPLOAD)
        // =====================================
        if ($request->upload_type == 'resource') {

            $files = $request->file('files');

            foreach ($files as $file) {

                $file_name = $file->getClientOriginalName();
                $title     = replace_url_symbol($file_name);

                $filePath = 'uploads/bootcamp/resource/'
                    . auth()->user()->name . '/'
                    . $module->bootcamp_title . '/'
                    . $module->title . '/'
                    . $title;

                if (BootcampResource::where('title', $title)->exists()) {
                    Session::flash('error', get_phrase("File already exists."));
                    return redirect()->back();
                }

                $data = [
                    'module_id'   => $module->id,
                    'upload_type' => 'resource',
                    'title'       => $title,
                    'file'        => $filePath,
                ];

                BootcampResource::create($data);
                FileUploader::upload($file, $filePath);
            }

            Session::flash('success', get_phrase('Resource uploaded successfully.'));
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $resource = BootcampResource::where('id', $id)->first();
        if (! $resource) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file_path = public_path($resource->file);
        if (file_exists($file_path)) {
            remove_file($file_path);
        }
        $resource->delete();

        Session::flash('success', get_phrase(ucfirst($resource->upload_type) . ' has been deleted.'));
        return redirect()->back();
    }

    public function download($id)
    {
        $resource = BootcampResource::where('id', $id);
        if ($resource->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $file      = $resource->first();
        $file_path = public_path($file->file);
        if (! file_exists($file_path)) {
            Session::flash('error', get_phrase('File does not exists.'));
            return redirect()->back();
        }
        return response()->download($file_path);
    }
}
