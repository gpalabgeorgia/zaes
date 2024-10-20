<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\Sections;
use App\Models\Category;
use App\Models\Brand;
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
            $product = Product::find($id);
            $message = "პროდუქტი წარმატებით განახლდა";
        }
        if($request->isMethod('post')) {
            $data = $request->all();

            // Product Validations
            $rules = [
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'category_id.required' => 'კატეგორია სავალდებულოა',
                'brand_id.required' => 'ბრენდი სავალდებულოა',
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
            $product->brand_id = $data['brand_id'];
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

        // Get All Brands
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray','fitArray','occasionArray', 'categories', 'productdata', 'brands'));
    } 

    public function deleteProductImage($id) {
        // Get Product Image
        $productImage = Product::select('main_image')->where('id', $id)->first();
        // Get Product Image Path
        $small_image_path = 'images/product_images/small';
        $medium_image_path = 'images/product_images/medium';
        $large_image_path = 'images/product_images/large';
        // Delete Product Small Image if exsts in small folder
        if(file_exists($small_image_path.$productImage->main_image)) {
            unlink($small_image_path.$productImage->main_image);
        }
        // Delete Product Medium Image if exsts in small folder
        if(file_exists($medium_image_path.$productImage->main_image)) {
            unlink($medium_image_path.$productImage->main_image);
        }
        // Delete Product Large Image if exsts in small folder
        if(file_exists($large_image_path.$productImage->main_image)) {
            unlink($large_image_path.$productImage->main_image);
        }
        // Delete Product Image form product table
        Product::where('id', $id)->update(['main_image'=>'']);
        session::flash('success_message', $message);
        $message = 'პროდუქტის ფოტო წარმატებით წაიშალა!';
        return redirect()->back();
    }

    public function deleteProductVideo($id) {
        // Get Product Video
        $productVideo = Product::select('product_video')->where('id', $id)->first();
        // Get Product Video Path
        $product_video_path = 'videos/product_videos/';
        // Delete Product Video from  product_videos if exsts
        if(file_exists($cproduct_video_path.$productVideo->product_video)) {
            unlink($product_video_path.$productVideo->product_video);
        }
        // Delete Product Video form categories table
        Product::where('id', $id)->update(['product_video'=>'']);
        session::flash('success_message', $message);
        $message = 'პროდუქტის ფოტო წარმატებით წაიშალა!';
        return redirect()->back();
    }

    public function addAttributes(Request $request, $id) {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $value) {
                if(!empty($value)) {
                    // SKU already exists check
                    $attrCountSKU = ProductsAttribute::where('sku', $value)->count();
                    if($attrCountSKU > 0) {
                        $message = 'პროდქტი ასეთი კოდით უკვე არსებობს. გთხოვთ შეიყვანოთ სხვა კოდი';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }
                    // Size already exists check
                    $attrCountSize = ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if($attrCountSize > 0) {
                        $message = 'პროდქტი ასეთი ზომით უკვე არსებობს. გთხოვთ შეიყვანოთ სხვა ზომა';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key]; 
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $success_message = 'პროდუქტის ატრიბუტები წარმატებით დაემატა!';
            session::flash('success_message', $success_message);
            return redirect()->back();
        }
        $productdata = Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        $title = "პროდუქტის ატრიბუტები";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function editAttributes(Request $request, $id) {
        if($request->isMethod('post')) {
            $data = $request->all();
            foreach($data['attrId'] as $key => $attr) {
                if(!empty($attr)) {
                    ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $success_message = 'პროდუქტის ატრიბუტები წარმატებით გაახლდა!';
            session::flash('success_message', $success_message);
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            if($data['status']=="Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttribute($id) {
        // Delete Product Attribute
        ProductsAttribute::where('id', $id)->delete();
        $message = 'პროდუქტის ატრიბუტი წარმატებით წაიშალა!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id) {
        if($request->isMethod('post')) {
            if($request->hasFile('images')) {
                $images = $request->file('images');
                foreach($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    // $originalName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,99999).time().".".$extension;
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
                    $productImage->image = $imageName;
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
                $message = "პროდუქტის ფოტოები წარმატებით დაემატა!";
                session::flash('success_message', $message);
                return redirect()->back();
            }
        }
        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>";print_r($productdata); die;
        $title = "პროდუქტის ფოტოები";
        return view('admin.products.add_images')->with(compact('productdata', 'title'));
    }

    public function updateImageStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            if($data['status']=="Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id) {
        // Get Product Image
        $productImage = ProductsImage::select('image')->where('id', $id)->first();
        // Get Product Image Path
        $small_image_path = 'images/product_images/small';
        $medium_image_path = 'images/product_images/medium';
        $large_image_path = 'images/product_images/large';
        // Delete Product Small Image if exsts in small folder
        if(file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        // Delete Product Medium Image if exsts in small folder
        if(file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }
        // Delete Product Large Image if exsts in small folder
        if(file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }
        // Delete Product Image form product table
        ProductsImage::where('id', $id)->delete();
        
        $message = 'პროდუქტის ფოტო წარმატებით წაიშალა!';
        session::flash('success_message', $message);
        return redirect()->back();
    }
}