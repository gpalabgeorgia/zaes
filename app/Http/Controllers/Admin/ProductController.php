<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Category;
use Session;
use Image;

class ProductController extends Controller
{
    public function products() {
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            if($data['status']=="Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id) {
        // Delete Product
        Product::where('id', $id)->delete();

        $message = 'პროდუქტი წარმატებით წაიშალა!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id=null) {
        if($id=="") {
            $title = "პროდუქტის დამატება";
            $product = new Product;
            $productdata = array();
            $message = "პროდუქტი წარმატებით დაემატა";
        }else {
            $title = "პროდუქტის რედაქტირება";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata), true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "პროდუქტი წარმატებით განახლდა";
        }
        if($request->isMethod('post')) {
            $data = $request->all();

            // Product Validations
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'category_id.required' => 'კატეგორია სავალდებულოა',
                'product_name.required' => 'გთხოვთ შეიყვანოთ პროდუქტის სახელი',
                'product_name.regex' => 'გთხოვთ შეიყვანოთ პროდუქტის ვალიდური სახელი',
                'product_code.required' => 'გთხოვთ შეიყვანოთ პროდუქტის კოდი',
                'product_code.regex' => 'გთხოვთ შეიყვანოთ პროდუქტის ვალიდური კოდი',
                'product_price.required' => 'გთხოვთ შეიყვანოთ პროდუქტის ფასი',
                'product_price.numeric' => 'გთხოვთ შეიყვანოთ პროდუქტის ვალიდური ფასი',
                'product_color.required' => 'გთხოვთ შეიყვანოთ პროდუქტის ფერი',
                'product_color.regex' => 'გთხოვთ შეიყვანოთ პროდუქტის ვალიდური ფერი',
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['is_featured'])) {
                $is_featured = "No";
            } else {
                $is_featured = "Yes";
            }
            if(empty($data['fabric'])) {
                $data['fabric'] = "";
            } 
            if(empty($data['pattern'])) {
                $data['fabric'] = "";
            } 
            if(empty($data['sleeve'])) {
                $data['sleeve'] = "";
            } 
            if(empty($data['fit'])) {
                $data['fit'] = "";
            } 
            if(empty($data['occasion'])) {
                $data['occasion'] = "";
            } 
            if(empty($data['meta_title'])) {
                $data['meta_title'] = "";
            } 
            if(empty($data['mea_keywords'])) {
                $data['meta_keywords'] = "";
            } 
            if(empty($data['meta_description'])) {
                $data['meta_description'] = "";
            } 
            if(empty($data['wash_care'])) {
                $data['wash_care'] = "";
            } 
            if(empty($data['pattern'])) {
                $data['pattern'] = "";
            } 
            if(empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            } 
            if(empty($data['product_weight'])) {
                $data['product_weight'] = 0;
            } 

            // Upload Product Image
            if($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()) {
                    // Get Original Image Name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    // set paths for small, medium and large images
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    // Upload Large Image after Resize
                    Image::make($image_tmp)->save($large_image_path); // W: 1040 H:1200
                    // Upload Medium and Small Image after Resize
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    // Save Main Image in products table
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video
            if($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()) {
                    // Upload Video
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path, $videoName);
                    // Save Video in products table
                    $product->product_video = $videoName;
                }
            }

            // Save Product Details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code']; 
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            $product->save();
            session::flash('success_message', $message);
            return redirect('admin/products');

        }
        // Filter Arrays
        $fabricArray = array('Cotton', 'Polyester', 'Wool');
        $sleeveArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve');
        $patternArray = array('Checked', 'Plain', 'Printed');
        $fitArray = array('Regular', 'Slim');
        $occasionArray = array('Casual', 'Formal');

        // Sections with Categories and Sub Categories
        $categories = Sections::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray','fitArray','occasionArray', 'categories', 'productdata'));
    } 
}