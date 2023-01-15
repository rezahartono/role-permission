@extends('layouts.index')

@push('heads')
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-4">
                    <form action="/settings/menu-list/edit/{{ $menu->id }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="row py-4">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Name" value="{{ $menu->name }}">
                                </div>
                                @error('name')
                                    <div id="name" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="key">Key</label>
                                    <input type="text" name="key" class="form-control" id="key"
                                        placeholder="Key" value="{{ $menu->key }}">
                                </div>
                                @error('key')
                                    <div id="key" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Description">{{ $menu->description }}</textarea>
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
                                <x-lookup-input label="Parent" id="parent" name="parent" placeholder="Choose Parent"
                                    modal-id="parentModal" :menu="$menu->parentData"></x-lookup-input>
                                @error('parent')
                                    <div id="parent" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="icon">Icon Class</label>
                                    <input type="text" name="icon" class="form-control" id="icon"
                                        placeholder="Icon Class" value="{{ $menu->icon_class }}">
                                </div>
                                @error('icon')
                                    <div id="icon" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="text" name="order" class="form-control" id="order"
                                        placeholder="Order" value="{{ $menu->order }}">
                                </div>
                                @error('order')
                                    <div id="order" class="form-text text-danger error my-3">
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
    <x-master-data-modal id="parentModal" modal-title="Show Menu List" path="{{ route('lookup.menu_list') }}"
        input-id="parent">
    </x-master-data-modal>
@endsection
