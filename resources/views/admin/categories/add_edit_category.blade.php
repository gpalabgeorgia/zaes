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
              <li class="breadcrumb-item active">კატეგორიები</li>
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
        <form @if(empty($categorydata['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @endif name="categoryForm" id="categoryForm" method="post" enctype="multipart/form-data">@csrf
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
                        <label for="category_name">კატეგორიის სახელი</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="კატეგორიის სახელი" @if(!empty($categorydata['category_name'])) value="{{ $categorydata['category_name'] }}" @else value="{{ old('category_name') }}" @endif>
                    </div>
                    <div id="appendCategoriesLevel">
                        @include('admin.categories.append_categories_level')
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>აირჩიეთ სექცია</label>
                        <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
                        <option value="">არჩევა</option>
                        @foreach($getSections as $section)
                            <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif>{{ $section->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_image">კატეგორიის ფოტო</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="category_image" name="category_image">
                                <label for="category_image" class="custom-file-label">აირჩიეთ ფაილი</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">ატვირთვა</span>
                            </div>
                        </div>
                        @if(!empty($categorydata['category_image']))
                            <div>
                                <img style="width: 80px; margin-top: 5px;" src="{{ asset('images/category_images/'.$categorydata['category_image']) }}" alt="">
                                &nbsp;
                                <a class="confirmDelete" href="javascript:void(0)" record="category-image"recordid="{{ $categorydata['id'] }}">ფოტოს წაშლა</a>
                            </div>
                        @endif
                        
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="category_discount">კატეგორიის ფასდაკლება</label>
                        <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="კატეგორიის ფასდაკლება" @if(!empty($categorydata['discount'])) value="{{ $categorydata['discount'] }}" @else value="{{ old('discount') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="description">კატეგორიის აღწერა</label>
                        <textarea name="description" id="description" class="form-control" placeholder="კატეგორის აღწერა" rows="3">
                            @if(!empty($categorydata['description'])) {{ $categorydata['description'] }} @else {{ old('description') }} @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords">Meta საკვანძო სიტყვები</label>
                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Meta საკვანძო სიტყვები" rows="3">
                            @if(!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif
                        </textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="url">კატეგორიის URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="კატეგორიის URL" @if(!empty($categorydata['url'])) value="{{ $categorydata['url'] }}" @else value="{{ old('url') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="meta_descrition">Meta აღწერა</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Meta აღწერა" rows="3">
                            @if(!empty($categorydata['meta_description'])) {{ $categorydata['meta_descrption'] }} @else {{ old('meta_description') }} @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_title">Meta სათაური</label>
                        <textarea name="meta_title" id="meta_title" class="form-control" placeholder="Meta სათაური" rows="3">
                            @if(!empty($categorydata['meta_title'])) {{ $categorydata['meta_title'] }} @else {{ old('meta_title') }} @endif
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