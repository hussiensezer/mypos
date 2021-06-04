@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1 style="margin-bottom: 15px ">@lang('site.orders') <small style="font-size:15px;">{{$orders->total()}}</small></h1>
            {{-- Start Searching Form      --}}
            <form action="{{route('dashboard.orders.index')}}" class="mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('orders_create'))
                            <a href="{{route('dashboard.orders.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                        @else
                            <button class="btn btn-success btn-sm disabled"> <i class="fa fa-plus"></i>  @lang('site.add')</button>
                        @endif
                    </div>
                </div>
            </form>
            {{-- End Searching Form      --}}

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.orders')</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">

            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary px-3">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.orders')</h3>
                    </div>
                    <!-- /.box-header -->
                    @if($orders->count() > 0 )
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="">#</th>
                                <th>@lang("site.client_name")</th>
                                <th>@lang("site.price")</th>
                                <th>@lang("site.status")</th>
                                <th>@lang("site.create_at")</th>
                                <th>@lang("site.action")</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->client->name}}</td>
                                    <td>{{ number_format($order->total_price,2)}}</td>
                                    <td>Empty</td>
                                    <td>{{  $order->created_at}}</td>
                                    <td>
                                        <button class="btn btn-bitbucket btn-sm order-products"  data-link="{{ route('dashboard.orders.products',$order->id)}}"  data-method="get" > <i class="fa fa-th"></i> @lang('site.show')</button>
                                    @if(auth()->user()->hasPermission('orders_update'))
                                            <a class="btn btn-primary btn-sm " href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif

                                        @if(auth()->user()->hasPermission('orders_delete'))
                                            <form action="{{route('dashboard.orders.destroy',$order->id)}}" method="post" style="display: inline-block">
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
                        {{$orders->appends(request()->query()) ->links()}}
                    @else
                        <h2 class="alert alert-danger">@lang('site.no_data_found')</h2>
                    @endif
                </div> <!-- end of Box -->
                </div><!-- col-md- 8-->
                <div class="col-md-4">
                    <!-- general form elements -->
                    <div class="box box-primary px-3" >
                      <div id="print_area">

                          <div class="box-header with-border">
                              <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.receipt')</h3>
                          </div> <!-- End Of HeaderBox-->
                          <div id="loading" style="display:none;flex-direction:column;align-items: center;margin-top: 10px;">
                              <div class="loader"></div>
                              <p style="margin-top: 10px">@lang('site.loading')</p>
                          </div>
                          <div class="box-body" id="order-product-list">

                          </div>
                      </div><!-- End Of Print Area-->
                        <div class="box-body">

                            <button class="btn btn-primary btn-bitbucket  print btn-block" type="submit"><i class="fa fa-print"></i>  @lang('site.print')</button>
                        </div>
                    </div> <!-- End Of Box-->
                </div> <!-- End Of Col4 -->
            </div> <!--End Of Row -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
