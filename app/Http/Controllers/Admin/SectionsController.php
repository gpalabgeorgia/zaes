<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sections;
use Session;

class SectionsController extends Controller
{
    public function sections() {
        Session::put('page', 'sections');
        $sections = Sections::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionsStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            if($data['status']=="Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            Sections::where('id', $data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'section_id'=>$data['section_id']]);
        }
    }
}