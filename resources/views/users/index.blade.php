@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Manager</div>
                    @section("custom_html")
                        <form action="" class="my-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                    Role
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($roles as $role)
                                        <button class="dropdown-item" name="role_id" value="{{ $role->id }}"
                                                type="submit">{{ $role->name }}</button>
                                    @endforeach
                                        <button class="dropdown-item btn-danger" name="role_id" value=""
                                                type="submit">Clear</button>
                                </div>
                            </div>
                        </form>
                    @endsection
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ $table }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
