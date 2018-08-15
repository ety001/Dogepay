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

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function checktx(Order $order, $tx, $test = false)
    {
        try {
            $net = 'https://horizon.stellar.org';
            $test_net = 'https://horizon-testnet.stellar.org';
            $url = ( $test === '1' ? $test_net : $net ) . "/transactions/{$tx}";
            $content = json_decode(file_get_contents($url), true);
            if (isset($content['memo']) && 'dogepay:'.$order->id === $content['memo']) {
                $content = json_decode(file_get_contents($url.'/payments'), true);
                if (isset($content['_embedded']['records'][0]['to'])) {
                    $from = $content['_embedded']['records'][0]['from'];
                    $to = $content['_embedded']['records'][0]['to'];
                    $amount = $content['_embedded']['records'][0]['amount'];
                    $dapp = Dapp::find($order->dapp_id);
                    if ($dapp->withdraw_addr == $to
                        && $order->amount * pow(10, 7 - $order->precision) == $amount * pow(10, 7)) {
                        $order->status = Order::PAID;
                        $order->save();
                        return response()->json([
                            'status' => true,
                            'msg' => 'ok',
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'msg' => 'wrong data',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'wrong address',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'wrong memo order id',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
