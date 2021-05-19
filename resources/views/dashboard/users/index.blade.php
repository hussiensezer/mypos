@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1></h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                <li class="active"></li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px"> <small></small></h3>

                    <form action="" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="" value="">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> </button>

                                    <a href="" class="btn btn-primary"><i class="fa fa-plus"></i></a>

                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i></a>

                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">



                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
{{--                            @foreach ($users as $index=>$user)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $index + 1 }}</td>--}}
{{--                                    <td>{{ $user->first_name }}</td>--}}
{{--                                    <td>{{ $user->last_name }}</td>--}}
{{--                                    <td>{{ $user->email }}</td>--}}
{{--                                    <td><img src="{{ $user->image_path }}" style="width: 100px;" class="img-thumbnail" alt=""></td>--}}
{{--                                    <td>--}}
{{--                                        @if (auth()->user()->hasPermission('update_users'))--}}
{{--                                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>--}}
{{--                                        @else--}}
{{--                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>--}}
{{--                                        @endif--}}
{{--                                        @if (auth()->user()->hasPermission('delete_users'))--}}
{{--                                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display: inline-block">--}}
{{--                                                {{ csrf_field() }}--}}
{{--                                                {{ method_field('delete') }}--}}
{{--                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>--}}
{{--                                            </form><!-- end of form -->--}}
{{--                                        @else--}}
{{--                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

{{--                            @endforeach--}}
                            </tbody>

                        </table><!-- end of table -->



{{--                    @else--}}

                        <h2></h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
