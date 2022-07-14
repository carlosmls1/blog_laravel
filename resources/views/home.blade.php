@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            Name: {{$user->name}}<br>
                            Email: {{$user->email}}<br>
                            Last Login: {{$user->last_login}}<br>
                            Count Post: {{$post}}<br>
                            @role('admin')
                                Admin: {{$admins}}<br>
                                Supervisor: {{$supervisors}}<br>
                                Blogger: {{$bloggers}}<br>
                            @endrole
                            @role('supervisor')
                                Assigned users: {{$user->bloggers()->get()->count()}}<br>
                            @endrole
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#profileModal">
                            {{ __('Edit Profile') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        @if (count($errors) > 0)
        $( document ).ready(function() {
            $('#profileModal').modal('show');
        });
        @endif
    </script>
@endsection
