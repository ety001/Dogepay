<template>
    <div class="row" style="margin-top: 30px">
        <div class="col col-sm-12">
            <h2>{{ lGatewayInfo1 }}</h2>
            <p style="color: red; font-weight: 900;">{{ lGatewayInfo2 }}</p>
            <div class="form-group mb-2">
                <label for="private_key" class="sr-only">{{ lPrivateKey }}</label>
                <input type="text" class="form-control" id="private_key" :placeholder="lPrivateKey">
            </div>
            <button class="btn btn-primary mb-2">{{ lConfirm }} {{ lToPay }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'lGatewayInfo1',
            'lGatewayInfo2',
            'lPrivateKey',
            'lConfirm',
            'lToPay'
        ]
    }
</script>
