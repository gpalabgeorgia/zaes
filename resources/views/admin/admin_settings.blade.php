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
          </div>
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
                <h3 class="card-title">პაროლის განახლება</h3>
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
              <!-- form start -->
              <form method="post" role="form" action="{{ url('/admin/update-current-pwd') }}" id="updatePasswordform" name="updatePasswordForm">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">ელ.ფოსტა</label>
                    <input class="form-control" value="{{ $adminDetails->email }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="current_pwd">მიმდინარე პაროლი</label>
                    <input type="password" class="form-control" id="current_pwd" name="current_pwd" placeholder="შეიყვანეთ მიმდინარე პაროლი" required="">
                    <span id="chkCurentPwd"></span>
                  </div>
                  <div class="form-group">
                    <label for="new_pwd">ახალი პაროლი</label>
                    <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="შეიყვანეთ ახალი პაროლი" required="">
                  </div>
                  <div class="form-group">
                    <label for="confirm_pwd">ახალი პაროლი განმეორებით</label>
                    <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="შეიყვანეთ ახალი პაროლი განმეორებით პაროლი" required="">
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