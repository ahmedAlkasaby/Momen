@extends('web.profile.layouts.main')

@section('profile-content')
    <div id="ChangePassword">
        <div class="ChangePassword">
            <h3 class="mb-3">Change Password</h3>
            <div class="ChangePassword__form">
                <div class="ChangePassword__form__input">
                    @include('web.layouts.messages.displayErrors')
                    @include('web.layouts.messages.success')
                    <form action="{{ route('profile.update.password') }}" method="POST">
                        @csrf
                        <label for="current-password" class="form-label">Current Password</label>
                        <div class="password-input-container">
                            <input type="password" class="form-control" id="current-password" required name="current_password">
                            <img src="/assets/show-password.svg" alt="show-password" class="password-toggle show-password">
                            <img src="/assets/hide-password.svg" alt="hide-password" class="password-toggle hide-password">
                        </div>

                        <label for="new-password" class="form-label">New Password</label>
                        <div class="password-input-container">
                            <input type="password" class="form-control" id="new-password" required name="new_password">
                            <img src="/assets/show-password.svg" alt="show-password" class="password-toggle show-password">
                            <img src="/assets/hide-password.svg" alt="hide-password" class="password-toggle hide-password">
                        </div>

                        <label for="confirm-password" class="form-label">Confirm New Password</label>
                        <div class="password-input-container">
                            <input type="password" class="form-control" id="confirm-password" required name="new_password_confirmation">
                            <img src="/assets/show-password.svg" alt="show-password" class="password-toggle show-password">
                            <img src="/assets/hide-password.svg" alt="hide-password" class="password-toggle hide-password">
                        </div>
                </div>
                <div class="ChangePassword__btn">
                    <button type="submit" class="button__primary__medium" onclick="validateForm(event)">Change</button>
                </div>
                </form>
            </div>
        </div>


    </div>
@endsection
