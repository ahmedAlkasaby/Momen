<div class="modal fade" id="forgetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content auth">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <h4 class="modal-title mt-2 ms-4">Forgot Password</h4>
            <p class="ms-4">Enter your email to receive the verification code</p>

            <div class="modal-body">
                <form id="forgetPasswordForm">
                    <div class="mb-4">
                        <input type="email" class="form-control" id="fp_email" placeholder="Email" required>
                    </div>

                    <button type="submit" class="button__primary__large d-none d-md-block m-auto">Send code</button>
                    <button type="submit" class="button__primary__medium d-block d-md-none m-auto">Send code</button>

                </form>

                <div id="fp_error" class="text-danger mt-2" style="display:none;"></div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="verifyOtpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content auth">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <h4 class="modal-title mt-2 ms-4">Verify Code</h4>
            <p class="ms-4">Enter the 4-digit verification code</p>

            <div class="modal-body">
                <form id="verifyOtpForm">
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" maxlength="1" class="otp-input form-control mx-1" autofocus>
                        <input type="text" maxlength="1" class="otp-input form-control mx-1">
                        <input type="text" maxlength="1" class="otp-input form-control mx-1">
                        <input type="text" maxlength="1" class="otp-input form-control mx-1">
                    </div>

                    <div class="text-center mb-3">
                        <span>Didn’t receive code? </span>
                        <a href="#" id="resendResetOtp">Resend Code</a>
                    </div>

                    <button type="submit" class="button__primary__large d-none d-md-block m-auto">Verify</button>
                    <button type="submit" class="button__primary__medium d-block d-md-none m-auto">Verify</button>
                </form>

                <div id="verifyOtp_error" class="text-danger mt-2" style="display:none;"></div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content auth">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <h4 class="modal-title mt-2 ms-4">Create New Password</h4>

            <div class="modal-body">
                <form id="resetPasswordForm">

                    <div class="mb-4 password-field">
                        <input type="password" class="form-control" id="new_password" placeholder="New Password"
                            required>
                        <button type="button" onclick="togglePasswordVisibility('new_password','eye-new')"
                            class="toggle-password">
                            <i id="eye-new" class="fa-regular fa-eye-slash"></i>
                        </button>
                    </div>

                    <div class="mb-4 password-field">
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password"
                            required>
                        <button type="button" onclick="togglePasswordVisibility('confirm_password','eye-confirm')"
                            class="toggle-password">
                            <i id="eye-confirm" class="fa-regular fa-eye-slash"></i>
                        </button>
                    </div>

                    <button type="submit" class="button__primary__large d-none d-md-block m-auto">Save</button>
                    <button type="submit" class="button__primary__medium d-block d-md-none m-auto">Save</button>

                </form>

                <div id="reset_error" class="text-danger mt-2" style="display:none;"></div>
            </div>

        </div>
    </div>
</div>
