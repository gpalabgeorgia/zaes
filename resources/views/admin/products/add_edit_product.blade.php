@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>კატალოგი</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">დაფა</a></li>
              <li class="breadcrumb-item active">პროდუქტები</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if($errors->any())
            <div class="alert alert-danger" style="margin-top: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif
        @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> 
            </div>
        @endif
        <form @if(empty($productdata['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" @endif name="productForm" id="productForm" method="post" enctype="multipart/form-data">@csrf
            <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>აირჩიეთ კატეგორია</label>
                        <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id']==@old('category_id')) selected="" @endif>&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                    <option value="{{ $subcategory['id'] }}" @if(!empty(@old('category_id')) && $subcategory['id']==@old('category_id')) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_name">პროდუქტის სახელი</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="პროდუქტის სახელი" @if(!empty($productdata['product_name'])) value="{{ $productdata['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_code">პროდუქტის კოდი</label>
                        <input type="text" class="form-control" id="product_code" name="product_code" placeholder="პროდუქტის კოდი" @if(!empty($productdata['product_code'])) value="{{ $productdata['product_code'] }}" @else value="{{ old('product_code') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_name">პროდუქტის ფერი</label>
                        <input type="text" class="form-control" id="product_color" name="product_color" placeholder="პროდუქტის ფერი" @if(!empty($productdata['product_color'])) value="{{ $productdata['product_color'] }}" @else value="{{ old('product_color') }}" @endif>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_price">პროდუქტის ფასი</label>
                        <input type="text" class="form-control" id="product_code" name="product_price" placeholder="პროდუქტის ფასი" @if(!empty($productdata['product_price'])) value="{{ $productdata['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_discount">პროდუქტის ფასდაკლება (%)</label>
                        <input type="text" class="form-control" id="product_discount" name="product_discount" placeholder="პროდუქტის ფასდაკლება" @if(!empty($productdata['product_discount'])) value="{{ $productdata['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_weight">პროდუქტის წონა</label>
                        <input type="text" class="form-control" id="product_weight" name="product_weight" placeholder="პროდუქტის წონა" @if(!empty($productdata['product_weight'])) value="{{ $productdata['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="main_image">მთავარი ფოტო</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="main_image" name="main_image">
                                <label for="main_image" class="custom-file-label">აირჩიეთ ფაილი</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">ატვირთვა</span>
                            </div>
                        </div>
                        <div>ფოტოს რეკომენდირებული ზომა: width - 1040px, Height - 1200px;</div>
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="product_video">პროდუქტის ვიდეო</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="product_video" name="product_video">
                                <label for="product_video" class="custom-file-label">აირჩიეთ ფაილი</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">ატვირთვა</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">პროდუქტის აღწერა</label>
                        <textarea name="description" id="description" class="form-control" placeholder="პროდუქტის აღწერა" rows="3">
                            @if(!empty($productdata['description'])) {{ $productdata['description'] }} @else {{ old('description') }} @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords">Meta საკვანძო სიტყვები</label>
                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Meta საკვანძო სიტყვები" rows="3">
                            @if(!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif
                        </textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="wash_care">პროდუქტის მოვლა</label>
                        <textarea name="wash_care" id="wash_care" class="form-control" placeholder="პროდუქტის მოვლა" rows="3">
                            @if(!empty($productdata['wash_care'])) {{ $productdata['wash_care'] }} @else {{ old('wash_care') }} @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>აირჩიეთ მასალა</label>
                        <select class="form-control select2" name="fabric" id="fabric" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($fabricArray as $fabric)
                            <option value="{{ $fabric }}">{{ $fabric }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>აირჩიეთ მასალა</label>
                        <select class="form-control select2" name="fabric" id="fabric" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($fabricArray as $fabric)
                            <option value="{{ $fabric }}">{{ $fabric }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>აირჩიეთ სეზონი</label>
                        <select class="form-control select2" name="sleeve" id="sleeve" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($sleeveArray as $sleeve)
                            <option value="{{ $sleeve }}">{{ $sleeve }}</option>
                        @endforeach
                        </select>
                    </div> 
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>აირჩიეთ გაფორმება</label>
                        <select class="form-control select2" name="pattern" id="pattern" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($patternArray as $pattern)
                            <option value="{{ $pattern }}">{{ $pattern }}</option>
                        @endforeach
                        </select>
                    </div> 
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>აირჩიეთ ძირი</label>
                        <select class="form-control select2" name="fit" id="fit" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($fitArray as $fit)
                            <option value="{{ $fit }}">{{ $fit }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>აირჩიეთ სეზონი</label>
                        <select class="form-control select2" name="occasion" id="occasion" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($occasionArray as $occasion)
                            <option value="{{ $occasion }}">{{ $occasion }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="meta_title">Meta სათაური</label>
                        <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Meta სათაური" rows="3">
                            @if(!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }} @else {{ old('meta_title') }} @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_descrition">გაყიდვაშია</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="url">პროდუქტის URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="კატეგორიის URL" @if(!empty($productdata['url'])) value="{{ $productdata['url'] }}" @else value="{{ old('url') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="meta_descrition">Meta აღწერა</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Meta აღწერა" rows="3">
                            @if(!empty($productdata['meta_description'])) {{ $productdata['meta_descrption'] }} @else {{ old('meta_description') }} @endif
                        </textarea>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">დადასტურება</button>
            </div>
            </div>
        </form>
      </div>
    </section>
  </div>    
@endsection

