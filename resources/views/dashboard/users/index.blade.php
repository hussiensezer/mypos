@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1 style="margin-bottom: 15px ">@lang('site.users') <small style="font-size:15px;">{{$users->total()}}</small></h1>
            {{-- Start Searching Form      --}}
            <form action="{{route('dashboard.users.index')}}" class="mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('users_create'))
                          <a href="{{route('dashboard.users.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                        @else
                            <button class="btn btn-success btn-sm disabled"> <i class="fa fa-plus"></i>  @lang('site.add')</button>
                        @endif
                    </div>
                </div>
            </form>
            {{-- End Searching Form      --}}

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.index")}}">@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.users')</li>
            </ol>
        </section>

        <section class="content">
            <!-- general form elements -->
            <div class="box box-primary px-3">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px ">@lang('site.users')</h3>
                </div>
                <!-- /.box-header -->
                @if($users->count() > 0 )
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>@lang("site.first_name")</td>
                            <td>@lang("site.last_name")</td>
                            <td>@lang("site.email")</td>
                            <td>@lang("site.action")</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->first_name}}</td>
                                    <td>{{ $user->last_name}}</td>
                                    <td>{{ $user->email}}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('users_update'))
                                          <a class="btn btn-primary btn-sm " href="{{ route('dashboard.users.edit', $user->id) }}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif

                                        @if(auth()->user()->hasPermission('users_delete'))
                                            <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
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
                    {{$users->appends(request()->query()) ->links()}}
                @else
                    <h2 class="alert alert-danger">@lang('site.no_data_found')</h2>
                @endif


            </div> <!-- end of Box -->





        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
