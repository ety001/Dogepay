## Dogepay
DogePay is a payment gateway. If Stellar is a bank, DogePay will be Alipay or Paypal.
We want people who are running an online business to reduce troubles during using cryptocurrency
as one of their payment tools.
Now DogePay will give the solution to let the owners of online business easy to use cryptocurrency.

## Documents

The payment gateway page is `https://dogepay.top/payment/{dapp_id}?trade_no=&amount=&precision=`

#### Parameters
* dapp_id
Please visit [https://dogepay.top](https://dogepay.top) to register an account and create an dapp first.
And you can get dapp_id from the dapp list.
* trade_no
The `trade_no` is the order id on your website.
* amount
The `amount` is the order price. But the gateway only accepet integer.
* precision
The `precision` is the order price's decimal place.

#### Example
If your dapp id is 5 and you have an order `#123` which values 10.5 XLM, you can build the gateway url like this:

> https://dogepay.top/payment/5?trade_no=123&amount=1050&precision=2

#### Callback
If users paid success, the gateway will redirect users to the callback url which you configed in dapp.
**The gateway will send `tx` and `trade_no` to your callback url.** You need to check the transaction right
and update order status.

#### Demo
You can get help in demo.

The demo: <http://demo.dogepay.top>
The demo source code: <https://github.com/ety001/dogepay-demo>

## Issue

If you have any issue, please go to [https://github.com/ety001/Dogepay/issues] and leave a message.

## Contact

Email: work#domyself.me (change # to @)
