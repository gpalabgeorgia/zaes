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
              <li class="breadcrumb-item active">პროდუქტის ფოტოები</li>
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
        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> 
            </div>
        @endif

        <form name="addImageForm" id="addImageForm" method="post" action="{{ url('admin/add-images/'.$productdata['id']) }}" enctype="multipart/form-data">@csrf
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
                                <label for="product_name">პროდუქტის სახელი: </label> &nbsp;{{ $productdata['product_name'] }}
                            </div>
                            <div class="form-group">
                                <label for="product_code">პროდუქტის კოდი: </label> &nbsp;{{ $productdata['product_code'] }}
                            </div>
                            <div class="form-group">
                                <label for="product_name">პროდუქტის ფერი: </label> &nbsp;{{ $productdata['product_color'] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <img style="width: 120px; margin-top: 5px;" src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrapper">
                                    <div>
                                        <input multiple="" id="images" name="images[]" type="file" value="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ფოტოების დამატება</button>
                </div>
            </div>
        </form>
        <form action="{{ url('admin/edit-images/'.$productdata['id']) }}" name="editImageForm" id="editImageForm" method="post">@csrf
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title">პროდუქტების დამატებული ფოტოები</h3>
              </div>
            <div class="card-body">
              <table id="products" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>ფოტო</th>
                  <th>მოქმედებები</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($productdata['images'] as $image)
                  <input style="display: none;" type="text" name="imageId[]" value="{{ $image['id']}} ">
                <tr>
                  <td>{{ $image['id'] }}</td>
                  <td>
                    <img style="width: 120px; margin-top: 5px;" src="{{ asset('images/product_images/small/'.$image['image']) }}" alt="">
                  </td>
                  <td>
                    @if($image['status']==1)
                          <a class="updateImageStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                          <a class="updateImageStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                      &nbsp;&nbsp;
                      <a title="პროდუქტის წაშლა" href="javascript:void(0)" class="confirmDelete" record="image" recordid="{{ $image['id'] }}"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">ფოტოების გაახლება</button>
          </div>
        </form>
        </div>
      </div>
    </section>
  </div>    
@endsection