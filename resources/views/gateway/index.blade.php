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
                        <stellar-pay
                            l-gateway-info1="{{ __('gateway.info1') }}"
                            l-gateway-info2="{{ __('gateway.info2') }}"
                            l-private-key="{{ __('common.private_key') }}"
                            l-confirm="{{ __('common.confirm') }}"
                            l-to-pay="{{ __('common.topay') }}"
                            >
                        </stellar-pay>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
