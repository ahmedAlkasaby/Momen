@extends('web.profile.layouts.main')

@section('profile-content')
    <div id="PersonalInfo">
        <div class="PersonalInfo">
            @include('web.layouts.messages.displayErrors')
            @include('web.layouts.messages.success')
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="position-relative">

                    @if (Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" alt="personalInfo" class="PersonalInfo__img"
                            id="profileImage">
                    @else
                        <img src="{{ asset($user->image) }}" alt="personalInfo" class="PersonalInfo__img" id="profileImage">
                    @endif
                    <img src="{{ asset('website/assets/edit-icon.svg') }}" alt="edit" class="PersonalInfo__editIcon"
                        id="editIcon">
                    <input type="file" id="imageUpload" accept="image/*" class="d-none" name="image" >
                </div>

                <div class="PersonalInfo__form mt-4">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name='name_first'
                                value="{{ Auth::user()->name_first }}">
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name </label>
                            <input type="text" class="form-control" id="lastName" name='name_last'
                                value="{{ Auth::user()->name_last }}">
                        </div>
                    </div>
                    <button type="submit" class="PersonalInfo__button mt-4" id="save">Save</button>
            </form>
        </div>
        <div class="PersonalInfo__delete d-flex justify-content-end mt-5">
            <button class="PersonalInfo__deleteButton ms-2 mt-1" id="deleteButton"><img
                    src="{{ asset('website/assets/trash-icon.svg') }}" alt="trash-icon" class="me-2 mb-1">Delete
                Account</button>
        </div>
    </div>

    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-content">
            <img src="/assets/delete-confirm-icon.svg" alt="trash-icon">
            <h6>You are about to delete your account</h6>
            <p class="mb-0">This will delete your account forever</p>
            <p>Are you sure?</p>
            <div class="confirmation-buttons">
                <button id="cancelDelete">Cancel</button>
                <button id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
    </div>
@endsection
