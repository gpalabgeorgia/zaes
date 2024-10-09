@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>პროდუქტები</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">მთავარი</a></li>
              <li class="breadcrumb-item active">პროდუქტები</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> 
                </div>
              @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">პროდუქტები</h3>
                    <a href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block;">დამატება</a>
                </div>
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>დასახელება</th>
                    <th>კოდი</th>
                    <th>ფერი</th>
                    <th>ფოტო</th>
                    <th>კატეგორია</th>
                    <th>სექცია</th>
                    <th>სტატუსი</th>
                    <th>მოქმედებები</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->product_color }}</td>
                    <td>
                      <?php $product_image_path = "images/product_images/small/".$product->main_image; ?>
                      @if(!empty($product->main_image) && file_exists($product_image_path))
                        <img style="width: 100px;" src="{{ asset('images/product_images/small/noimage.png') }}" alt="პროდუქტის ფოტო">
                      @else
                      <img style="width: 100px;" src="{{ asset('images/product_images/small/'.$product->main_image) }}" alt="პროდუქტის ფოტო">
                      @endif
                    </td>
                    <td>{{ $product->category->category_name }}</td>
                    <td>{{ $product->section->name }}</td>
                    <td>
                      @if($product->status==1)
                          <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)">Active</a>
                      @else
                          <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)">Inactive</a>
                      @endif
                    </td>
                    <td>
                      <a href="{{ url('admin/add-edit-product/'.$product->id) }}">რედაქტირება</a>
                      &nbsp;&nbsp;
                      <a href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{ $product->id }}">წაშლა</a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection