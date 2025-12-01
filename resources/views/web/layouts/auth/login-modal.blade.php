<div class="modal fade" id="exampleModalToggle" tabindex="-1" aria-labelledby="exampleModalToggleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content auth">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h4 class="modal-title mt-2 d-flex m-auto" id="loginModalLabel">Login</h4>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-4">
                        <input type="email" class="form-control" placeholder="Email or Phone Number" id="login_email" required>
                    </div>
                    <div class="mb-4 password-field">
                        <input type="password" class="form-control" placeholder="Password" id="password1" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password1', 'eye-icon1')">
                            <i id="eye-icon1" class="fa-regular fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="#" data-bs-target="#forgetPasswordModal" data-bs-toggle="modal" class="text-decoration-none">Forgot password?</a>
                    </div>

                    <button type="submit" class="button__primary__large d-none d-md-block m-auto">Login</button>
                    <button type="submit" class="button__primary__medium d-block d-md-none m-auto">Login</button>

                    <div id="loginError" style="color:red; display:none; text-align:center; margin-top:10px;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <p class="m-auto">Don't have an account? 
                    <a data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" href="#" class="text-decoration-none">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</div>
