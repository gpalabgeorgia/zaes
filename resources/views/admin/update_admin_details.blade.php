@extends('layouts.admin_layouts.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">მონაცემები</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">მთავარი</a></li>
              <li class="breadcrumb-item active">ადმინისტრატორის მონაცემები</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">ადმინისტრატორის მონაცემების განახლება</h3>
              </div>
              <!-- /.card-header -->
              @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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
              @if($errors->any())
                <div class="alert alert-danger" style="margin-top: 10px;">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
              @endif
              <!-- form start -->
              <form method="post" role="form" action="{{ url('/admin/update-admin-details') }}" id="updateAdminDetails" name="updateAdminDetails" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">ელ.ფოსტა</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="admin_name">სახელი/გვარი</label>
                    <input type="text" class="form-control" id="admin_name" name="admin_name" value="{{ Auth::guard('admin')->user()->name }}" placeholder="შეიყვანეთ სახელი/გვარი" required="">
                  </div>
                  <div class="form-group">
                    <label for="admin_mobile">ტელეფონის №</label>
                    <input type="text" class="form-control" id="admin_mobile" name="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="შეიყვანეთ ტელეფონის №" required="">
                  </div>
                  <div class="form-group">
                    <label for="admin_image">ფოტო</label>
                    <input type="file" class="form-control" id="admin_image" name="admin_image" accept="image/*">
                    @if(!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">ნახვა</a>
                        <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">დადასტურება</button>
                </div>
              </form>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   
  </div>
  <!-- /.content-wrapper -->
@endsection