@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('common.add') }} {{ __('common.dapp') }}</span>
                    <a href="{{ route('dapp_index') }}" class="btn btn-primary btn-sm float-right">{{ __('common.back') }}</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" enctype="multipart/form-data" action="{{ route('dapp_update', ['dapp' => $dapp]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="app_name">{{ __('common.dapp') }} {{ __('common.name') }}</label>
                            <input type="text" value="{{ $dapp->app_name }}" class="form-control" id="app_name" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="dapp_status">{{ __('common.dapp') }} {{ __('common.status') }} *</label>
                            <select name="status" class="form-control" id="dapp_status">
                                <option value="0" {{ $dapp->status == 0 ? 'selected' : '' }}>{{ __('common.testing') }}</option>
                                <option value="1" {{ $dapp->status == 1 ? 'selected' : '' }}>{{ __('common.online') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <img width="200" src="{{ asset(Storage::url($dapp->icon)) }}" class="img-thumbnail">
                        </div>
                        <div class="form-group">
                            <label for="dapp_icon">{{ __('common.dapp') }} {{ __('common.icon') }} (200 x 200)</label>
                            <input name="icon_file" type="file" class="form-control-file" id="dapp_icon">
                        </div>
                        <div class="form-group">
                            <label for="app_descp">{{ __('common.dapp') }} {{ __('common.description') }}</label>
                            <textarea name="description" value="{{ $dapp->description }}" class="form-control" id="app_descp" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="callback_url">{{ __('common.callback_url') }} *</label>
                            <input name="callback_url" value="{{ $dapp->callback_url }}" type="text" class="form-control" id="callback_url" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="withdraw_addr">{{ __('common.withdraw_addr') }} *</label>
                            <input name="withdraw_addr" value="{{ $dapp->withdraw_addr }}" type="text" class="form-control" id="withdraw_addr" placeholder="">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{  __('common.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
