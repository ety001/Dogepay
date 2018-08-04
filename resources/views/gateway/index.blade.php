@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('common.payment') }}</span>
                </div>

                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('err_msg'))
                        <div class="alert alert-danger">
                            {{ session('err_msg') }}
                        </div>
                    @endif

                    <div class="container">
                        <div class="row">
                            <div class="col col-sm-3">
                                <img width="200" src="{{ asset(Storage::url($dapp->icon)) }}" class="img-thumbnail">
                            </div>
                            <div class="col col-sm-auto">
                                <h1>
                                    {{ $dapp->app_name }}
                                </h1>
                                <div>{{ __('gateway.request') }}</div>
                                <h2>
                                    <span id="amount" style="color: red; font-weight: 900;">{{ $order->amount * pow(10, -1 * $order->precision) }}</span> XLM
                                </h2>
                                <div>{{ __('gateway.for') }}</div>
                                <h3><span style="color: green;">{{ $order->trade_no }}</span></h3>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col col-sm-12">
                                <h2>{{ __('gateway.info1') }}</h2>
                                <p style="color: red; font-weight: 900;">{{ __('gateway.info2') }}</p>
                                <div class="form-group">
                                    <label for="private_key" class="sr-only">{{ __('common.private_key') }}</label>
                                    <input type="text" class="form-control" id="private_key" placeholder="{{ __('common.private_key') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">{{ __('common.confirm') }} {{ __('common.topay') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
