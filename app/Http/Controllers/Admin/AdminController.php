<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Admin;
use Hash;
use Image;

class AdminController extends Controller
{
    public function dashboard() {
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings() {
        Session::put('page', 'settings');
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                'email.required' => 'ელ.ფოსტის მისამართი სავალდებულოა',
                'email.email' => 'გთხოვთ შეიყვანოთ ვალიდური ელ.ფოსტის მისამართი',
                'password.required' => 'პაროლის შეყვანა სავალდებულოა',
            ];
            $this->validate($request,$rules,$customMessages);
            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                return redirect('admin/dashboard');
            }else {
                Session::flash('error_message', 'არასწორი ელ.ფოსტა ან პაროლი');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request) {
        $data = $request->all();
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            echo "true";
        }else {
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            // Check if current password is correct
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                // Check if new and confirm password is matching
                if($data['new_pwd']==$data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'პაროლი წარმატებით გაახლდა!');
                }else {
                    Session::flash('error_message', 'შეყვანილი ახალი პაროლები არ ემთხვევა!');
                }
            }else {
                Session::flash('error_message', 'მიმდინარე პაროლი არასწორია!');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request) {
        Session::put('page', 'update-admin-details');
        if($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];
            $customMessages = [
                'admin_name.required' => 'ადმინისტრატრის სახელი/გვარი სავალდებულოა',
                'admin_name.alpha' => 'გთხოვთ შეიყვანოთ ვალიდური სახელი/გვარი',
                'admin_mobile.required' => 'ტელეფონის ნომრის მითითება სავალდებულოა',
                'admin_mobile.numeric' => 'გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი',
                'admin_image.image' => 'გთხოვთ ატვირთოთ ვალიდური ფოტო'
            ];
            $this->validate($request, $rules, $customMessages);
            // Upload Image
            if($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()) {
                    // Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])) {
                    $imageName = $data['current_image_name'];
                }else {
                    $imageName = "";
                }
            }
            // Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            session::flash('success_message', 'ადმინისტრატორის მონაცემები განახლდა!');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}
