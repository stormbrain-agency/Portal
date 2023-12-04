<div class="wrap-content d-flex flex-column align-items-center">
    <div class="ic-phone mb-9">
        <img src="{{ asset('libs/images/smartphone.svg') }}" alt="">
    </div>
    <div class="title mb-9">Two Step Verification</div>
    <div class="sub-title mb-2">Enter the verification code we sent to </div>
    <div class="phone-number mb-9">{{ session('message') }}</div>

    <div class="mb-4 bg-red-500">
        @if (session()->has('error'))
            {{ session('error') }}
        @endif
    </div>

    <form>
        <label class="mb-4" for="btn-verify">Type your 6 digit security code</label>

        <div class="otp-input-fields d-flex align-items-center justify-content-between mb-9">
            <input type="number" class="otp__digit otp__field__1">
            <input type="number" class="otp__digit  otp__field__2">
            <input type="number" class="otp__digit  otp__field__3">
            <input type="number" class="otp__digit otp__field__4">
            <input type="number" class="otp__digit  otp__field__5">
            <input type="number" class="otp__digit otp__field__6">
        </div>
        <input type="submit" name="btn-verify" value="Submit" id="submitBtn">
        <a href="/logout">Back</a>
    </form>
</div>



<style>
    .wrap-content .title{
        color:#181C32;
        font-size: 30px;
        font-weight: 600;
        line-height: 30px;
        letter-spacing: -0.6px;
    }
    
    .wrap-content .sub-title{
        color: #A1A5B7;
        font-size: 18px;
        font-weight: 500;
        line-height: 27px;
    }

    .wrap-content .phone-number{
        color: #181C32;
        font-size: 18px;
        font-weight: 600;
        line-height: 18px;
        letter-spacing: -0.18px;
    }

    form{
        width: 100%;
    }

    form label {
        color: #181C32;
        font-size: 14px;
        font-weight: 600;
        line-height: 14px;
    }

    form input{
        width: calc(16.67% - 20px);
        padding: 4px 10px;
        border-radius: 6px;
        border: 2px solid  #E1E3EA;
        background: #FFF;
        font-size: 26px;
        font-weight: 600;
        color: #7E8299;
        text-align: center;
    }

    form input[type="submit"]{
        padding: 10px 24px;
        margin: 0px auto;
        background: #3E97FF;
        border: 1px solid #3E97FF;
        width: max-content;
        color: var(--bs-white);
        display: block;
        font-size: 16px;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none !important;
        margin: 0;
    }

</style>

<script>
    var otp_inputs = document.querySelectorAll(".otp__digit");
    var mykey = "0123456789".split("");

    otp_inputs.forEach(_ => {
        _.addEventListener("keyup", handle_next_input);
    });

    document.getElementById("submitBtn").addEventListener("click", function (event) {
        event.preventDefault();

        var _finalKey = "";
        for (let { value } of otp_inputs) {
            _finalKey += value;
        }
        console.log(_finalKey, 'click');
        Livewire.emit('submit_code', _finalKey);
    });

    function handle_next_input(event) {
        let current = event.target;
        let index = parseInt(current.classList[1].split("__")[2]);
        current.value = event.key;

        if (event.keyCode == 8 && index > 1) {
            current.previousElementSibling.focus();
        }
        if (index < 6 && mykey.indexOf("" + event.key + "") != -1) {
            var next = current.nextElementSibling;
            next.focus();
        }

        var _finalKey = "";
        for (let { value } of otp_inputs) {
            _finalKey += value;
        }
        console.log(_finalKey);
    }
</script>