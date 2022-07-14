@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update user</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            <form method="post" action="{{ route("user.update", $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $user->name }}"
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
                    <input value="{{ $user->email }}"
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
                        <option value="" disabled>Select role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    data-slug="{{ $role->slug }}"
                                {{ in_array($role->slug, $userRole)
                                    ? 'selected'
                                    : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                <div class="" id="related_user"
                     @if(!in_array('supervisor', $userRole))
                         style="display: none"
                    @endif>
                    <label for="users" class="form-label">Bloggers</label>
                    <users-component
                        :role="'blogger'"
                        :value='{!! json_encode($users) !!}'
                    ></users-component>
                </div>

                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route("user.index") }}" class="btn btn-default">Cancel</a>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#role').on('change', function(e) {
                var option = $('option:selected', this).attr('data-slug');
                if(option === 'supervisor'){
                    $('#related_user').show()
                }else{
                    $('#related_user').hide()
                }
            });
        });
    </script>
@endsection
