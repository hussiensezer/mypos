@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1 style="margin-bottom: 15px ">@lang('site.categories') <small style="font-size:15px;">{{$categories->total()}}</small></h1>
            {{-- Start Searching Form      --}}
            <form action="{{route('dashboard.categories.index')}}" class="mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('categories_create'))
                          <a href="{{route('dashboard.categories.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                        @else
                            <button class="btn btn-success btn-sm disabled"> <i class="fa fa-plus"></i>  @lang('site.add')</button>
                        @endif
                    </div>
                </div>
            </form>
            {{-- End Searching Form      --}}

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">
            <!-- general form elements -->
            <div class="box box-primary px-3">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.categories')</h3>
                </div>
                <!-- /.box-header -->
                @if($categories->count() > 0 )
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="">#</th>
                            <th>@lang("site.category")</th>
                            <th>@lang("site.product_quantity")</th>
                            <th>@lang("site.related_products")</th>
                            <th>@lang("site.action")</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name}}</td>
                                    <td>{{ $category->products->count() }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{route('dashboard.products.index',['category_id' =>$category->id] )}}">@lang('site.related_products')</a>
                                    </td>

                                    <td>
                                        @if(auth()->user()->hasPermission('categories_update'))
                                          <a class="btn btn-primary btn-sm " href="{{ route('dashboard.categories.edit', $category->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif

                                        @if(auth()->user()->hasPermission('categories_delete'))
                                            <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post" style="display: inline-block">
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
                    {{$categories->appends(request()->query()) ->links()}}
                @else
                    <h2 class="alert alert-danger">@lang('site.no_data_found')</h2>
                @endif


            </div> <!-- end of Box -->





        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
