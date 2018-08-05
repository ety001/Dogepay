<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dapp;
use App\Models\Order;

class GatewayController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Dapp $dapp)
    {
        $trade_no = $request->get('trade_no');
        $amount = $request->get('amount');
        $precision = $request->get('precision');

        if (empty($trade_no)) {
            abort(500, 'trade_no err.');
        }

        if (empty($amount)) {
            abort(500, 'amount err.');
        }

        if (empty($precision)) {
            abort(500, 'precision err.');
        }

        if (!is_numeric($amount)) {
            abort(500, 'amount need integer.');
        }

        if (!is_numeric($precision)) {
            abort(500, 'precision need integer.');
        }

        $order = Order::where('dapp_id', $dapp->id)
                    ->where('trade_no', $trade_no)
                    ->first();

        if ($order) {
            if ($order->status === Order::CLOSED) {
                abort(500, 'order has been closed.');
            }
            if ($order->status === Order::PAID) {
                abort(500, 'order has been paid.');
            }
            if ($order->amount != $amount || $order->precision != $precision) {
                abort(500, 'order data unexcets.');
            }
        } else {
            $order = new Order;
            $order->dapp_id = $dapp->id;
            $order->trade_no = $trade_no;
            $order->amount = $amount;
            $order->precision = $precision;
            $order->remark = '{}';
            $order->save();
        }

        return view('gateway.index', [
            'hidden' => true,
            'dapp' => $dapp,
            'order' => $order,
        ]);
    }
}
