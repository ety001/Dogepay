@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('common.dapp') }} {{ __('common.list') }}</span>
                    <a href="{{ route('dapp_create') }}" class="btn btn-success btn-sm float-right">{{ __('common.add') }}</a>
                </div>

                <div class="card-body">
                @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif
                    @if ($dapp_list->isNotEmpty())
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('common.dapp') }} {{ __('common.id') }}</th>
                                    <th scope="col">{{ __('common.dapp') }} {{ __('common.name') }}</th>
                                    <th scope="col">{{ __('common.dapp') }} {{ __('common.status') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($dapp_list as $dapp)
                                <tr>
                                    <td>{{ $dapp->id }}</td>
                                    <td>{{ $dapp->app_name }}</td>
                                    <td>
                                        @if ($dapp->status == \App\Models\Dapp::ONLINE)
                                        <span class="badge badge-success">{{ __('common.online') }}</span>
                                        @endif
                                        @if ($dapp->status == \App\Models\Dapp::TESTING)
                                        <span class="badge badge-warning">{{ __('common.testing') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm">{{ __('common.edit') }}</a>
                                        <a href="" class="btn btn-danger btn-sm">{{ __('common.del') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $dapp_list->links() }}
                    @else
                        <div class="alert alert-warning" role="alert">
                            {{ __('common.list_is_empty') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
