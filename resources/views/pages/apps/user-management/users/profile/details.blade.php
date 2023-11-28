<x-default-layout>
    <div class="page-profile">
        <div class="card p-15">
            <div class="wrap-content">
                <div class="title">Edit Profile</div>
            </div>
            <div class="wrap-content">
                <div class="title">Change User Password</div>
                <form action="" method="get">
                    <div class="wrap-input d-flex flex-column">
                        <label for="current_password">Current Password:</label>
                        <input type="text" id="current_password" name="current_password" placeholder="Please enter your current password" required>
                    </div>
                    <div class="wrap-input d-flex flex-column">
                        <label for="new_password">New Password:</label>
                        <input type="text" id="new_password" name="new_password" required>
                    </div>
                    <div class="wrap-input d-flex flex-column">
                        <label for="cf_new_password">Confirm New Password:</label>
                        <input type="text" id="cf_new_password" name="cf_new_password" required>
                    </div>
                    <div class="wrap-input d-flex align-items-center">
                        <input type="submit" id="save_rs" name="save_rs" value="SAVE" required>
                        <label class="mb-0" for="save_rs">Forgot password? <a class="text-decoration-underline" href="http://">Reset here</a></label>
                    </div>
                </form>
            </div>
            <div class="wrap-content">
                <div class="title">Change phone number:</div>
                <form action="" method="get">
                    <div class="wrap-input d-flex flex-column">
                        <label for="your_phone">Your Phone:</label>
                        <input type="text" id="your_phone" name="your_phone" placeholder="(619) 999-9999" required>
                    </div>
                    <div class="wrap-input d-flex align-items-center mb-0">
                        <input type="submit" id="save_phone" name="save_phone" value="SAVE" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>