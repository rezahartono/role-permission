@extends('layouts.index')

@push('heads')
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-4">
                    <form action="/settings/access-list/edit/{{ $access->id }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="row py-4">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Name" value="{{ $access->name }}">
                                </div>
                                @error('name')
                                    <div id="name" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="key">Key</label>
                                    <input type="text" name="key" class="form-control" id="key"
                                        placeholder="Key" value="{{ $access->key }}">
                                </div>
                                @error('key')
                                    <div id="key" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Description">{{ $access->description }}</textarea>
                                </div>
                                @error('description')
                                    <div id="description" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-none d-md-block col-md-1"></div>
                            <div class="col-12 col-md-5">
                                {{-- <div class="form-group">
                                    <label for="path">Path</label>
                                    <input type="text" name="path" class="form-control" id="path"
                                        placeholder="Path">
                                </div>
                                @error('path')
                                    <div id="path" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                                <x-lookup-input label="Menu" id="menu" name="menu" placeholder="Choose Menu"
                                    modal-id="menuModal" :data="$access->parentMenu"></x-lookup-input>
                                @error('menu')
                                    <div id="menu" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="fas fa-save mr-3"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-master-data-modal id="menuModal" modal-title="Show Menu List" path="{{ route('lookup.menu_list') }}" input-id="menu">
    </x-master-data-modal>
@endsection
