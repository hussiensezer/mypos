@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route("dashboard.products.index")}}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang("site.add")</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include("partials._errors")

                    <form action="{{route("dashboard.products.store")}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <!-- select -->
                            <div class="form-group">
                                <label>@lang('site.category')</label>
                                <select class="form-control" name="category_id">
                                    <option disabled selected>@lang('site.choose')</option>
                                    @foreach($categories as $category)
                                     <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected': '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label> @lang('site.'. $locale.'.product_name')</label>
                            <input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale .'.name')}}" >
                        </div> <!-- End Form-Group -->
                         @endforeach

                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label> @lang('site.'. $locale.'.description')</label>
                            <textarea name="{{$locale}}[description]" class="form-control ckeditor" > {{old($locale . '.description')}}</textarea>
                        </div> <!-- End Form-Group -->
                        @endforeach

                        <div class="form-group">
                            <label> @lang('site.image_product')</label>
                            <input type="file" name="image" class="form-control image" >
                        </div> <!-- End Form-Group -->
                        <div class="form-group">
                            <img src="{{asset('uploads/product_images/default.png')}}" alt="" class="image-preview img-thumbnail" style="width:100px; ">
                        </div>

                        <div class="form-group">
                            <label> @lang('site.purchase_price')</label>
                            <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{old('purchase_price')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.sale_price')</label>
                            <input type="number" name="sale_price" step="0.01" class="form-control" value="{{old('sale_price')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{old('stock')}}" >
                        </div> <!-- End Form-Group -->






                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('site.add')</button>
                        </div> <!-- End Form-Group -->

                    </form>  <!-- End Form-->
                </div> <!-- End Box Body-->

            </div>




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
