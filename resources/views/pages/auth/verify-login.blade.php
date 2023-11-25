<x-auth-layout>
    <div class="wrap-content d-flex flex-column align-items-center">
        <div class="ic-phone mb-9">
            <img src="{{ image('auth/smartphone.svg') }}" alt="">
        </div>
        <div class="title mb-9">Two Step Verification</div>
        <div class="sub-title mb-9">Enter the verification code we sent to </div>
        <div class="phone-number mb-9">******7859</div>
        <form action="get">
            <label class=" mb-9" for="btn-verify">Type your 6 digit security code</label>
            <div class="d-flex align-items-center justify-content-between mb-9">
                <input class="code" type="text" inputmode placeholder="0" min="0" max="9" required>
                <input class="code" type="text" placeholder="0" min="0" max="9" required>
                <input class="code" type="text" placeholder="0" min="0" max="9" required>
                <input class="code" type="text" placeholder="0" min="0" max="9" required>
                <input class="code" type="text" placeholder="0" min="0" max="9" required>
                <input class="code" type="text" placeholder="0" min="0" max="9" required>
            </div>
            <input type="submit" name="btn-verify" value="Submit">
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
            padding: 0px 24px;
            margin: 0px auto;
            background: #3E97FF;
            border: 1px solid #3E97FF;
            width: max-content;
            color: var(--bs-white);
            display: block;
        }

    </style>
    <script>
        
        const codes = document.querySelectorAll('.code');
        codes[0].focus();

        codes.forEach((code, idx) => {
            code.addEventListener('keydown', (e) => {
                if(e.key >= 0 && e.key <= 9) {
                    setTimeout(() => {
                        codes[idx+1].focus();
                    }, 10);
                } else if (e.key === 'Backspace') {
                    setTimeout(() => {
                        codes[idx-1].focus();
                    }, 10);
                }
            });
        });    
    </script>    
</x-auth-layout>
