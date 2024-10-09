<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Category;
use Session;

class ProductController extends Controller
{
    public function products() {
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        // $products = json_decode(json_encode($products));
        // echo "<pre>"; print_r($products); die;
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
        }else {
            $title = "პროდუქტის რედაქტირება";
        }
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

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
                $is_featured = 0;
            } else {
                $is_featured = 1;
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
                $data['product_discount'] = "";
            } 
            if(empty($data['product_weight'])) {
                $data['product_weight'] = "";
            } 
            if(empty($data['main_image'])) {
                $data['main_image'] = "";
            } 

            // Save Product Details in products table
            // $product = new Product;
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
            $product->save();
            session::flash('success_message', 'პროდუქტი წარმატებით დაემატა');
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
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray','fitArray','occasionArray', 'categories'));
    } 
}
// https://youtu.be/pAA9avXhKh4?t=1718