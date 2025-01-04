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
              <li class="breadcrumb-item active">ბანერები</li>
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
        <form @if(empty($banner['id'])) action="{{ url('admin/add-edit-banners') }}" @else action="{{ url('admin/add-edit-banners/'.$banner['id']) }}" @endif name="bannerForm" id="bannerForm" method="post" enctype="multipart/form-data">@csrf
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
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">ბანერის ფოტო</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label for="image" class="custom-file-label">აირჩიეთ ფაილი</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">ატვირთვა</span>
                                </div>
                            </div>
                            <div>ფოტოს რეკომენდირებული ზომა: width - 1170px, Height - 480px;</div>
                            @if(!empty($banner['image']))
                                <div>
                                    <img style="width: 250px; margin-top: 15px; margin-bottom: 5px;" src="{{ asset('images/banner_images/'.$banner['image']) }}" alt="">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="title">ბანერის სახელი</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="ბანერის სახელი" @if(!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="link">ბანერის ლინკი</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="ბანერის ლინკი" @if(!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="alt">ალტერნატიული სახელი</label>
                            <input type="text" class="form-control" id="alt" name="alt" placeholder="ალტერნატიული სახელი" @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif>
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

