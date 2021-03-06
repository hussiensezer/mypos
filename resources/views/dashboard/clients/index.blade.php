@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1 style="margin-bottom: 15px ">@lang('site.clients') <small style="font-size:15px;">{{$clients->total()}}</small></h1>
            {{-- Start Searching Form      --}}
            <form action="{{route('dashboard.clients.index')}}" class="mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('clients_create'))
                          <a href="{{route('dashboard.clients.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                        @else
                            <button class="btn btn-success btn-sm disabled"> <i class="fa fa-plus"></i>  @lang('site.add')</button>
                        @endif
                    </div>
                </div>
            </form>
            {{-- End Searching Form      --}}

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">
            <!-- general form elements -->
            <div class="box box-primary px-3">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.clients')</h3>
                </div>
                <!-- /.box-header -->
                @if($clients->count() > 0 )
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="">#</th>
                            <th>@lang("site.client")</th>
                            <th>@lang("site.phone")</th>
                            <th>@lang("site.address")</th>
                            <th>@lang("site.orders")</th>
                            <th>@lang("site.action")</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $index => $client)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $client->name}}</td>
                                    <td>{{implode(' - ',$client->phone)}}</td>
                                    <td>{{ $client->address}}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('orders_create'))
                                            <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>@lang('site.add_orders')</a>
                                        @else
                                            <button class="btn btn-primary" disabled>@lang('site.add_orders')</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('clients_update'))
                                          <a class="btn btn-primary btn-sm " href="{{ route('dashboard.clients.edit', $client->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif

                                        @if(auth()->user()->hasPermission('clients_delete'))
                                            <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="post" style="display: inline-block">
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
                    {{$clients->appends(request()->query()) ->links()}}
                @else
                    <h2 class="alert alert-danger">@lang('site.no_data_found')</h2>
                @endif


            </div> <!-- end of Box -->





        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
