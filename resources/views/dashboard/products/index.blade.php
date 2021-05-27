@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1 style="margin-bottom: 15px ">@lang('site.products') <small style="font-size:15px;">{{$products->total()}}</small></h1>
            {{-- Start Searching Form      --}}
            <form action="{{route('dashboard.products.index')}}" class="mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" id="" class="form-control" style="padding-top:0">
                            <option value="" selected disabled>@lang('site.choose_category')</option>
                            @foreach($categories  as $category)
                                <option value="{{$category->id}}" {{request()->category_id ==  $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('products_create'))
                          <a href="{{route('dashboard.products.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                        @else
                            <button class="btn btn-success btn-sm disabled"> <i class="fa fa-plus"></i>  @lang('site.add')</button>
                        @endif
                    </div>

                </div>
            </form>
            {{-- End Searching Form      --}}

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.index")}}">@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.products')</li>
            </ol>
        </section>

        <section class="content">
            <!-- general form elements -->
            <div class="box box-primary px-3">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.products')</h3>
                </div>
                <!-- /.box-header -->
                @if($products->count() > 0 )
                    <table class="table table-hover table-responsive">
                        <thead>
                        <tr>
                            <th class="">#</th>
                            <th>@lang("site.product")</th>
                            <th>@lang("site.description")</th>
                            <th>@lang("site.category")</th>
                            <th>@lang("site.purchase_price")</th>
                            <th>@lang("site.sale_price")</th>
                            <th>@lang("site.profit")</th>
                            <th>@lang("site.profit_percent") %</th>
                            <th>@lang("site.image_product")</th>
                            <th>@lang("site.stock")</th>
                            <th>@lang("site.action")</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name}}</td>
                                    <td style="overflow-scrolling: auto;width:150px">{!! $product->description !!}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{ $product->purchase_price}}</td>
                                    <td>{{ $product->sale_price}}</td>
                                    <td>{{ $product->profit}}</td>
                                    <td>{{ $product->profit_percent}} %</td>
                                    <td><img src="{{ $product->image_path}}" alt="" style="width:50px; height:50px; border-radius:50%; border:1px solid #ccc; padding:2px; cursor:pointer;"></td>
                                    <td>{{ $product->stock}}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('products_update'))
                                          <a class="btn btn-primary btn-sm " href="{{ route('dashboard.products.edit', $product->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif

                                        @if(auth()->user()->hasPermission('products_delete'))
                                            <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post" style="display: inline-block">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn btn-danger btn-sm delete" ><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form>
                                         @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                         @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table> <!-- end of Table -->
                    {{$products->appends(request()->query()) ->links()}}
                @else
                    <h2 class="alert alert-danger">@lang('site.no_data_found')</h2>
                @endif


            </div> <!-- end of Box -->





        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
