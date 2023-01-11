@extends('layouts.index')

@push('heads')
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-4">
                    <form action="/settings/roles/edit/{{ $role->id }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="row py-4">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Name" value="{{ $role->name }}">
                                </div>
                                @error('name')
                                    <div id="name" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Description">{{ $role->description }}</textarea>
                                </div>
                                @error('description')
                                    <div id="description" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group d-flex flex-column">
                                    <label>Access Type</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" @if ($role->access_type == 'all') checked @endif
                                                type="radio" name="access_type" id="access_type" value="all"
                                                onclick="setVisible(false)">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                @if ($role->access_type == 'custom') checked @endif name="access_type"
                                                id="access_type" value="custom" onclick="setVisible(true)">
                                            <label class="form-check-label" for="custom">Custom</label>
                                        </div>
                                    </div>
                                </div>
                                @error('status')
                                    <div id="status" class="form-text text-danger error my-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-none d-md-block col-md-1"></div>
                            <div class="col-12 col-md-5">
                                <div class="row" id="tree_menu">
                                    <div class="col-12">
                                        <h5>Select Access Menu :</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="tree-container"></div>
                                        <div class="menu-input"></div>
                                    </div>
                                </div>
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
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dist/js/tree.min.js') }}" type="text/javascript"></script>
    <script>
        var activeMenu = {!! $active_menus !!};

        $(document).ready(function() {
            if ({!! json_encode($role->access_type) !!} == 'all') {
                setVisible(false)
            } else {
                setVisible(true)

            }

            activeMenu.forEach(element => {
                $('.menu-input').append(
                    '<input type="text" hidden id="menus" name="access[]" value="' +
                    element + '">')
            });
        })


        function setVisible(isVisible) {
            if (isVisible) {
                $('#tree_menu').removeClass('d-none')
            } else {
                $('#tree_menu').addClass('d-none')
            }
        }
        var jsonData = {!! json_encode($menus) !!}

        let tree = new Tree('.tree-container', {
            data: jsonData,
            closeDepth: 3,
            loaded: function() {
                this.values = activeMenu;
            },
            onChange: function() {
                $('.menu-input').empty();
                this.selectedNodes.forEach(element => {
                    $('.menu-input').append(
                        '<input type="text" hidden id="menus" name="access[]" value="' +
                        element.id + '">')
                });
            }
        })
    </script>
@endpush
