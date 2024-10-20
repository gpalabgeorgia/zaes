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
              <li class="breadcrumb-item active">პროდუქტის ატრიბუტი</li>
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

        <form name="attributeForm" id="attributeForm" method="post" action="{{ url('admin/add-attributes/'.$productdata['id']) }}">@csrf
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
                                        <input id="size" name="size[]" type="text" value="" placeholder="ზომა" style="width: 80px;" required="">
                                        <input id="sku" name="sku[]" type="text" value="" placeholder="კოდი" style="width: 80px;" required=""/>
                                        <input id="price" name="price[]" type="number" value="" placeholder="ფასი" style="width: 80px;" required=""/>
                                        <input id="stock" name="stock[]" type="number" value="" placeholder="მარაგი" style="width: 80px;" required=""/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field">დამატება</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ატრიბუტების დამატება</button>
                </div>
            </div>
        </form>
        <form action="{{ url('admin/edit-attributes/'.$productdata['id']) }}" name="editAttributeForm" id="editAttributeForm" method="post">@csrf
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title">პროდუქტების დამატებული ატრიბუტები</h3>
              </div>
            <div class="card-body">
              <table id="products" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>ზომა</th>
                  <th>კოდი</th>
                  <th>ფასი</th>
                  <th>მარაგი</th>
                  <th>მოქმედებები</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($productdata['attributes'] as $attribute)
                  <input style="display: none;" type="text" name="attrId[]" value="{{ $attribute['id']}} ">
                <tr>
                  <td>{{ $attribute['id'] }}</td>
                  <td>{{ $attribute['size'] }}</td>
                  <td>{{ $attribute['sku'] }}</td>
                  <td>
                    <input type="number" name="price[]" value="{{ $attribute['price'] }}" required="">
                  </td>
                  <td>
                    <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" required="">
                  </td>
                  <td>
                    @if($attribute['status']==1)
                          <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                          <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                      &nbsp;&nbsp;
                      <a title="პროდუქტის წაშლა" href="javascript:void(0)" class="confirmDelete" record="attribute" recordid="{{ $attribute['id'] }}"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">ატრიბუტების გაახლება</button>
          </div>
        </form>
        </div>
      </div>
    </section>
  </div>    
@endsection