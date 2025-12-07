      <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
          tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content auth">
                  <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <h4 class="modal-title mt-2 d-flex m-auto" id="loginModalLabel">Sign up</h4>
                  <div class="modal-body">
                      <form id="signupForm">
                          <div class="mb-4">
                              <input type="text" class="form-control" placeholder="First Name" name="name_first"
                                  id="name_first" required>
                          </div>
                          <div class="mb-4">
                              <input type="text" class="form-control" placeholder="Second Name" name="name_last"
                                  id="name_last" required>
                          </div>
                          <div class="mb-4">
                              <input type="email" class="form-control" placeholder="Email" name="email"
                                  id="signup_email" required>
                          </div>
                          <div class="mb-4">
                              <input type="tel" class="form-control" placeholder="Phone Number" name="phone"
                                  id="phone" required>
                          </div>
                          <div class="mb-4 password-field">
                              <input type="password" class="form-control" placeholder="Password" name="password"
                                  id="password2" required>
                              <button type="button" class="toggle-password"
                                  onclick="togglePasswordVisibility('password2', 'eye-icon2')">
                                  <i id="eye-icon2" class="fa-regular fa-eye-slash"></i>
                              </button>
                          </div>
                          <div class="mb-5 password-field">
                              <input type="password" class="form-control" placeholder="Confirm Password"
                                  name="password_confirmation" id="password3" required>
                              <button type="button" class="toggle-password"
                                  onclick="togglePasswordVisibility('password3', 'eye-icon3')">
                                  <i id="eye-icon3" class="fa-regular fa-eye-slash"></i>
                              </button>
                          </div>
                          <button type="submit" class="button__primary__large d-none d-md-block m-auto">Create</button>
                          <button type="submit"
                              class="button__primary__medium d-block d-md-none m-auto">Create</button>
                      </form>

                      <div id="signupError" style="color:red; display:none; text-align:center; margin-top:10px;"></div>
                  </div>
                  <div class="modal-footer ">
                      <p class="m-auto ">Already have an account? <a data-bs-target="#exampleModalToggle"
                              data-bs-toggle="modal" href="#" class="text-decoration-none"> Login</a>
                      </p>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content auth">
                  <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <h2 class="modal-title ms-4" id="otpModalLabel">Verify Your Account</h2>
                  <p class="ms-4">Enter the 4-digit verification code sent to your email</p>
                  <div class="modal-body">
                      <div id="otpError" class="text-danger mb-3" style="display:none;"></div>
                      <form id="otpForm">
                          <div class="mb-5">
                              <div class="d-flex justify-content-between mb-3">
                                  <input type="text" maxlength="1" class="otp-input form-control mx-1" autofocus>
                                  <input type="text" maxlength="1" class="otp-input form-control mx-1">
                                  <input type="text" maxlength="1" class="otp-input form-control mx-1">
                                  <input type="text" maxlength="1" class="otp-input form-control mx-1">
                              </div>

                              <div class="text-center mb-3">
                                  <span>Didn't receive code? </span>
                                  <a href="#" id="resendOtp" class="text-decoration-none">Resend Code</a>
                              </div>

                              <button type="submit"
                                  class="button__primary__large d-none d-md-block m-auto">Verify</button>
                              <button type="submit"
                                  class="button__primary__medium d-block d-md-none m-auto">Verify</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
