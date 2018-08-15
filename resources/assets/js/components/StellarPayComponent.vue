<template>
    <div class="row" style="margin-top: 30px">
        <div class="col col-sm-12">
            <h2>{{ lGatewayInfo1 }}</h2>
            <p style="color: red; font-weight: 900;">{{ lGatewayInfo2 }}</p>
            <div class="form-group mb-2">
                <label for="private_key" class="sr-only">{{ lPrivateKey }}</label>
                <input v-model="privateKey" type="password" class="form-control" id="private_key" :placeholder="lPrivateKey">
            </div>
            <div class="alert alert-danger" role="alert" v-if="alertMsg != null">{{ alertMsg }}</div>
            <div class="alert alert-success" role="alert" v-if="alertSuccMsg != null">{{ alertSuccMsg }}</div>
            <button type="button" class="btn btn-primary mb-2" v-on:click="topay">{{ lConfirm }} {{ lToPay }}</button>
        </div>
    </div>
</template>

<script>
    const StellarSdk = require('stellar-sdk');
    export default {
        data() {
            return {
                server: null,
                testNet: 'https://horizon-testnet.stellar.org',
                mainNet: 'https://horizon.stellar.org',
                privateKey: '',
                alertMsg: null,
                alertSuccMsg: null,
                receiverStatus: false,
                payStatus: false
            }
        },
        props: [
            'lGatewayInfo1',
            'lGatewayInfo2',
            'lPrivateKey',
            'lConfirm',
            'lToPay',
            'dappStatus',
            'receiver',
            'amount',
            'memo',
            'callbackUrl',
            'orderId',
            'tradeNo'
        ],
        methods: {
            topay: function(e) {
                if (this.payStatus == true) {
                    return;
                }
                if (this.receiverStatus === false) {
                    this.displayErrMsg('Unknown Receiver. Please contact to Dapp\'s manager.');
                    return;
                }
                console.log(this.privateKey);
                let keypair;
                try {
                    keypair = StellarSdk.Keypair.fromSecret(this.privateKey);
                } catch (err) {
                    console.log(err.message);
                    this.displayErrMsg('Wrong Private Key');
                    return;
                }
                let pubKey = keypair.publicKey();

                this.displaySuccMsg('Paying, please wait ...');
                this.payStatus = true;

                this.server.loadAccount(pubKey)
                    .then((account) => {
                        let transaction = new StellarSdk.TransactionBuilder(account)
                            // Add a payment operation to the transaction
                            .addOperation(StellarSdk.Operation.payment({
                                destination: this.receiver,
                                // The term native asset refers to lumens
                                asset: StellarSdk.Asset.native(),
                                amount: this.amount,
                            }))
                            .addMemo(StellarSdk.Memo.text(this.memo))
                            .build();

                        // Sign this transaction with the secret key
                        transaction.sign(keypair);

                        // see the XDR (encoded in base64) of the transaction we just built
                        console.log(transaction.toEnvelope().toXDR('base64'));

                        // Submit the transaction to the Horizon server. The Horizon server will then
                        // submit the transaction into the network for us.
                        this.server.submitTransaction(transaction)
                            .then((trans) => {
                                this.payStatus = false;
                                console.log(trans);
                                console.log('\nSuccess! View the transaction at: ');
                                console.log(trans._links.transaction.href);
                                const callbackURL = this.callbackUrl;
                                let updateURL = `/payment/${this.orderId}/${trans.hash}`;
                                const tradeNo = this.tradeNo;
                                if (this.dappStatus != 1) {
                                    updateURL = `${updateURL}/1`;
                                }
                                window.axios.get(updateURL)
                                    .then((res) => {
                                        console.log(res);
                                        if (res.status == 200 && res.data.msg == 'ok') {
                                            this.displaySuccMsg('Success! The page will redirect to the merchant\'s shop ...', function() {
                                                // console.log(callbackURL);
                                                window.location = `${callbackURL}?tx=${trans.hash}&trade_no=${tradeNo}`;
                                            });
                                        } else {
                                            this.displayErrMsg(res);
                                        }
                                    })
                                    .catch((err) => {
                                        console.log('update status err', err);
                                        this.displayErrMsg(err);
                                    });
                            })
                            .catch((err) => {
                                this.payStatus = false;
                                console.log('submitTransaction', err);
                                this.displayErrMsg(err);
                            });
                    })
                    .catch((e) => {
                        this.payStatus = false;
                        console.error(e);
                    });
            },
            displayErrMsg(msg) {
                this.alertMsg = msg;
                //setTimeout(() => {
                //    this.alertMsg = null;
                //}, 5000);
            },
            displaySuccMsg(msg, callback) {
                this.alertSuccMsg = msg;
                if (callback != undefined) {
                    setTimeout(() => {
                        callback();
                    }, 2000);
                }
            }
        },
        mounted: function () {
            if (this.dappStatus == 1) {
                this.server = new StellarSdk.Server(this.mainNet);
                StellarSdk.Network.usePublicNetwork();
            } else {
                this.server = new StellarSdk.Server(this.testNet);
                StellarSdk.Network.useTestNetwork();
            }
            this.server.loadAccount(this.receiver)
                .then((account) => {
                    this.receiverStatus = true;
                    console.log('receiver', account);
                })
                .catch((e) => {
                    console.log('receiver err', e);
                });
        }
    }
</script>
