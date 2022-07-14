<div class="modal fade" id="profileModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action=" {{ route('user.profile') }}">
            @method('patch')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input value="{{ Auth::user()->name }}"
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
                        <input value="{{ Auth::user()->email }}"
                               type="email"
                               class="form-control"
                               name="email"
                               placeholder="Email address" required>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Password</label>
                        <input value="{{ old('password') }}"
                               type="password"
                               class="form-control"
                               name="password"
                               placeholder="Password" >
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
                               placeholder="Password Confirmation">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>

