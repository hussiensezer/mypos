@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route("dashboard.products.index")}}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang("site.edit")</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include("partials._errors")

                    <form action="{{route("dashboard.products.update",$product->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}

                    <!-- select -->
                        <div class="form-group">
                            <label>@lang('site.category')</label>
                            <select class="form-control" name="category_id">
                                <option disabled selected>@lang('site.choose_category')</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected': '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label> @lang('site.'. $locale.'.product_name')</label>
                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{$product->translate($locale)->name}}" >
                            </div> <!-- End Form-Group -->
                        @endforeach

                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label> @lang('site.'. $locale.'.description')</label>
                                <textarea name="{{$locale}}[description]" class="form-control ckeditor" > {{$product->translate($locale)->description}}</textarea>
                            </div> <!-- End Form-Group -->
                        @endforeach

                        <div class="form-group">
                            <label> @lang('site.image_product')</label>
                            <input type="file" name="image" class="form-control image" >
                        </div> <!-- End Form-Group -->
                        <div class="form-group">
                            <img src="{{$product->image_path}}" alt="" class="image-preview img-thumbnail" style="width:100px; ">
                        </div>

                        <div class="form-group">
                            <label> @lang('site.purchase_price')</label>
                            <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{$product->purchase_price}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.sale_price')</label>
                            <input type="number" name="sale_price" step="0.01" class="form-control" value="{{$product->sale_price}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{$product->stock}}" >
                        </div> <!-- End Form-Group -->






                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('site.edit')</button>
                        </div> <!-- End Form-Group -->

                    </form>  <!-- End Form-->
                </div> <!-- End Box Body-->

            </div>




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
