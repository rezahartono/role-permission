@extends('layouts.index')

@push('heads')
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-4">
                    <form action="/settings/roles/create" method="post">
                        @csrf
                        @method('POST')
                        <div class="row py-4">
                            <div class="col-12 col-md-5">
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
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Description"></textarea>
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
                                            <input class="form-check-input" checked type="radio" name="access_type"
                                                id="all" value="all" onclick="setVisible(false)">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="access_type" id="custom"
                                                value="custom" onclick="setVisible(true)">
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
        $(document).ready(function() {
            setVisible(false)
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
