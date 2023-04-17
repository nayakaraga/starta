@extends('layouts.main')

@section('title', 'Users')

@section('head')
    @parent

    <style>
        html:not([dir=rtl]) .modal-simple .btn-close {
            right: -2rem;
        }

        html:not([dir=rtl]) .modal .btn-close {
            transform: translate(23px, -25px);
        }

        .modal-simple .btn-close {
            position: absolute;
            top: -2rem;
        }

        .modal .btn-close {
            background-color: #fff;
            border-radius: 0.5rem;
            opacity: 1;
            padding: 0.635rem;
            box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, .4);
            transition: all .23s ease .1s;
        }

        .btn-close {
            box-sizing: content-box;
            width: 0.8em;
            height: 0.8em;
            padding: 0.25em 0.25em;
            color: #a1acb8;
            background: rgba(0, 0, 0, 0) url(data:image/svg+xml,%3Csvg width='150px' height='151px' viewBox='0 0 150 151' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cdefs%3E%3Cpolygon id='path-1' points='131.251657 0 74.9933705 56.25 18.7483426 0 0 18.75 56.2450278 75 0 131.25 18.7483426 150 74.9933705 93.75 131.251657 150 150 131.25 93.7549722 75 150 18.75'%3E%3C/polygon%3E%3C/defs%3E%3Cg id='🎨-%5BSetup%5D:-Colors-&amp;-Shadows' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E%3Cg id='Artboard' transform='translate%28-225.000000, -250.000000%29'%3E%3Cg id='Icon-Color' transform='translate%28225.000000, 250.500000%29'%3E%3Cuse fill='%23a1acb8' xlink:href='%23path-1'%3E%3C/use%3E%3Cuse fill-opacity='0.5' fill='%23a1acb8' xlink:href='%23path-1'%3E%3C/use%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E) center/0.8em auto no-repeat;
            border: 0;
            border-radius: 0.375rem;
            opacity: .95;
        }
    </style>

@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                            Client</a>
                    </li>
                </ul>
            </div>

            @php
                // dd(session()->all());
            @endphp

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

            <div class="col-md-12">
                <div class="card">
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <h5 class="card-header">Users</h5>
                        </div>
                        <div>
                            <button class="btn btn-secondary add-new btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalCreateUser"><span><i class="bx bx-plus me-0 me-sm-1"></i><span
                                        class="d-none d-sm-inline-block">Add New User</span></span></button>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap p-3">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    dd($data);
                                @endphp --}}
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <ul
                                                    class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                        title="" data-bs-original-title="{{ $item['name'] }}">
                                                        <img src="https://ui-avatars.com/api/?name={{ $item['name'] }}"
                                                            alt="Avatar" class="rounded-circle">
                                                    </li>
                                                </ul>
                                                <strong>{{ $item['name'] }}</strong>
                                            </div>
                                        </td>

                                        <td>{{ $item['email'] }}</td>
                                        <td>{{ $item['username'] }}</td>
                                        <td><span class="badge bg-label-primary me-1">{{ $item['role'] }}</span></td>
                                        <td>
                                            @if ($item['role'] != 'Superadmin')
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="users/{{ $item->id }}/edit"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <form id="form-delete-user-{{ $item->username }}"
                                                            action="/users/{{ $item->id }}" class="d-inline"
                                                            method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="dropdown-item"
                                                                title="Delete Post">
                                                                <i class="bx bx-trash me-1"></i> Delete</a>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer')
    @parent

    <div class="modal fade" id="modalCreateUser" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>New User Information</h3>
                        <p>Add new user information to database.</p>
                    </div>
                    <form id="createUserForm" class="needs-validation" action="/users" novalidate="novalidate"
                        method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalCreateUserName">Name</label>
                                <input type="text" id="modalCreateUserName" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalCreateUserUsername">Username</label>
                                <input type="text" id="modalCreateUserUsername" name="username"
                                    value="{{ old('username') }}" class="form-control" placeholder="johndoe007"
                                    required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalCreateEmail">Email</label>
                                <input type="email" id="modalCreateEmail" name="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="example@domain.com" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalCreateUserRole">Role</label>
                                <select id="modalCreateUserRole" name="role" class="form-select" aria-label="Role">
                                    <option selected disabled>Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="mb-3
                                    form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label>
                                        {{-- <a href="auth-forgot-password-basic.html">
                                        <small>Forgot Password?</small>
                                    </a> --}}
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('plugins')
    @parent
@endsection
