@extends('layouts.main')

@section('title', $data['name'])

@section('head')
    @parent
@endsection

@section('content')
    <div class="container flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> {{ $data['email'] }}</h4>

        <div class="row">

            <div class="col-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i>
                            Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-connections.html"><i
                                class="bx bx-link-alt me-1"></i> Connections</a>
                    </li> --}}
                </ul>
            </div>

            <div class="col-12">
                @if (session()->has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (session()->has('errors'))
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{-- {{ session('errors') }} --}}
                            <ul class="list">
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    {{-- <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ $data }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div> --}}
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" action="/users/{{ $data['id'] }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="form-type" value="profile-updates">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ $data['name'] }}" autofocus />
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="text" name="username" id="username"
                                        value="{{ $data['username'] }}" />
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ $data['email'] }}" />
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="language" class="form-label">Role</label>
                                    <select id="language" class="select2 form-select" name="role">
                                        <option value="" selected disabled>Select roles</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                {{-- <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                                </p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                    id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">I confirm my account
                                    deactivation</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i>
                            Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-connections.html"><i
                                class="bx bx-link-alt me-1"></i> Connections</a>
                    </li> --}}

                    <div class="card mb-4">
                        <h5 class="card-header">Security Details</h5>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="formAccountSettings" action="/users/{{ $data['id'] }}" method="POST">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="form-type" value="security-updates">
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="password" class="form-label">Old Password</label>
                                        <input class="form-control" type="password" id="old_password" name="old_password"
                                            autofocus />
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input class="form-control" type="password" name="password" id="password" />
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="password_confirmation" class="form-label">New Password</label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="password_confirmation" />
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection

@section('plugins')
    @parent
@endsection
