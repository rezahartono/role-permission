@extends('layouts.index')

@push('heads')
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="/master-data/users/create" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-6">
                                <div class="list-group list-group-horizontal" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action w-50 active" id="list-home-list"
                                        data-toggle="list" href="#list-home" role="tab" aria-controls="home">General</a>
                                    <a class="list-group-item list-group-item-action w-50" id="list-profile-list"
                                        data-toggle="list" href="#list-profile" role="tab"
                                        aria-controls="profile">Groups</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                                        aria-labelledby="list-home-list">
                                        <div class="row py-4">
                                            <div class="col-12 col-md-5 mt-3">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        placeholder="Name">
                                                </div>
                                                @error('name')
                                                    <div id="name" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control" id="email"
                                                        placeholder="Email">
                                                </div>
                                                @error('email')
                                                    <div id="email" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <select id="role" name="role" class="form-control">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('role')
                                                    <div id="role" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-group d-flex flex-column">
                                                    <label>Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" checked type="radio"
                                                                name="status" id="status-active" value="active">
                                                            <label class="form-check-label"
                                                                for="status-active">Active</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="status-inactive" value="inactive">
                                                            <label class="form-check-label"
                                                                for="status-inactive">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('status')
                                                    <div id="status" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-12 col-md-5 mt-3">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" placeholder="Password">
                                                </div>
                                                @error('password')
                                                    <div id="password" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="confirm-password">Confirm Password</label>
                                                    <input type="password" class="form-control" name="confirm_password"
                                                        id="confirm-password" placeholder="Confirm Password">
                                                </div>
                                                @error('confirm_password')
                                                    <div id="confirm_password" class="form-text text-danger error my-3">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="list-profile" role="tabpanel"
                                        aria-labelledby="list-profile-list">Group</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary"><i class="fas fa-save mr-3"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
