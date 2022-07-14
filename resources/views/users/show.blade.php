@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Show user</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            <div>
                Name: {{ $user->name }}
            </div>
            <div>
                Email: {{ $user->email }}
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Posts</div>
                    <div class="card-body">
                        {{$posts}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($user->isRole('supervisor'))
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Assigned users</div>
                        <div class="card-body">
                            {{$users}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('user.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
