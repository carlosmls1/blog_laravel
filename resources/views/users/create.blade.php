@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Add new user</h1>
        <div class="lead">
            Add new user and assign role.
        </div>

        <div class="container mt-4">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
                           type="text"
                           class="form-control"
                           name="name"
                           placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ old('email') }}"
                           type="email"
                           class="form-control"
                           name="email"
                           placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control"
                            id="role"

                            name="role" required>
                        <option value="" disabled selected>Select role</option>
                        @foreach($roles as $role)
                            <option data-slug="{{ $role->slug }}"
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                <div class="mb-3" id="related_user" style="display: none">
                    <label for="users" class="form-label">Bloggers</label>
                    <users-component
                        :role="'blogger'"
                        :value='[]'
                    ></users-component>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Password</label>
                    <input value="{{ old('password') }}"
                           type="password"
                           class="form-control"
                           name="password"
                           placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Password Confirmation</label>
                    <input value="{{ old('password_confirmation') }}"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           placeholder="Password Confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>


                <button type="submit" class="btn btn-primary">Save user</button>
                <a href="{{ route("user.index") }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#role').on('change', function (e) {
                var option = $('option:selected', this).attr('data-slug');
                if (option === 'supervisor') {
                    $('#related_user').show()
                } else {
                    $('#related_user').hide()
                }
            });
        });
    </script>
@endsection
