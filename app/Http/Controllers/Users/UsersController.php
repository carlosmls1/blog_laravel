<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Posts;
use App\User;
use Illuminate\Http\Request;
use HttpOz\Roles\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Table;

class UsersController extends Controller
{

    public function index(Request $request) {
        $table = (new Table)->model(User::class)->routes([
            'index'   => ['name' => 'user.index'],
            'show'  => ['name' => 'user.show'],
            'create'  => ['name' => 'user.create'],
            'edit'    => ['name' => 'user.edit'],
            'destroy' => ['name' => 'user.destroy'],
        ])->destroyConfirmationHtmlAttributes(function (User $user) {
            return [
                'data-confirm' => 'Are you sure you want to delete the user ' . $user->name . ' ?',
            ];
        });

        $table->query(function (Builder $query) use ($request) {
            $query->select('users.*');
            if ($request->has('role_id') && $request->role_id != '') {
                $query->where('roles.id', $request->role_id);
            }
            $query->leftJoin('role_user', 'role_user.user_id', '=', 'users.id');
            $query->leftJoin('roles', 'roles.id', '=', 'role_user.role_id');
            $query->addSelect('roles.slug as role');
            $query->addSelect('roles.name as rolename');
        });
        $table->rowsNumber(20) ;
        $table->column('name')->title('Name')->sortable(true)->searchable();
        $table->column('email')->title('Email')->sortable()->searchable();
        $table->column('rolename')->title('Role');



        return view('users.index', [
            'table'=>$table,
            'roles' => Role::latest()->get()
        ]);
    }

    public function users(Request $request) {
        $users = Auth::user()->bloggers()->get()->pluck('id');
        $table = (new Table)->model(User::class)->routes([
            'index'   => ['name' => 'user.index'],
        ]);

        $table->query(function (Builder $query) use ($users) {
            $query->select('users.*');
            $query->whereIn('users.id', $users);
        });
        $table->rowsNumber(20) ;
        $table->column('name')->title('Name')->sortable(true)->searchable();
        $table->column('email')->title('Email')->sortable()->searchable();
        $table->column('rolename')->title('Role');



        return view('users.index', [
            'table'=>$table,
            'roles' => Role::latest()->get()
        ]);
    }
    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['roles' => Role::latest()->get()]);
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request)
    {
        $user = $user->create(array_merge($request->validated(), [
            'password' => $request->password
        ]));
        $user->attachRole($request->role);

        $bloggers = collect(json_decode($request->users))->pluck('id');
        $user->bloggers()->sync($bloggers);
        $user->save();
        return redirect()->route('user.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $table_post = (new Table)->model(Posts::class)->routes([
            'index'   => ['name' => 'posts.index'],
            'show'   => ['name' => 'posts.show'],
            'edit'    => ['name' => 'posts.edit'],
            'destroy' => ['name' => 'posts.destroy'],
        ])->destroyConfirmationHtmlAttributes(function (Posts $post) {
            return [
                'data-confirm' => 'Are you sure you want to delete the admin ' . $post->name . ' ?',
            ];
        });
        $table_post->query(function (Builder $query) use ($user) {
            $query->select('posts.*');
            $query->where('posts.user_id', $user->id);
        });
        $table_post->rowsNumber(20) ;
        $table_post->column('name')->title('Name')->sortable(true)->searchable();
        $table_post->column('description')->title('Description')->sortable()->searchable();

        $users = $user->bloggers()->get()->pluck('id');
        $table_users = (new Table)->model(User::class)->routes([
            'index'   => ['name' => 'user.index'],
        ]);

        $table_users->query(function (Builder $query) use ($users) {
            $query->select('users.*');
            $query->whereIn('users.id', $users);
        });
        $table_users->rowsNumber(20) ;
        $table_users->column('name')->title('Name')->sortable(true)->searchable();
        $table_users->column('email')->title('Email')->sortable()->searchable();

        return view('users.show', [
            'user' => $user,
            'posts'=>$table_post,
            'users'=>$table_users
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'users'=> new UserCollection($user->bloggers()->get()),
            'userRole' => $user->roles->pluck('slug')->toArray(),
            'roles' => Role::latest()->get(),
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());


        return redirect()->back()
            ->withSuccess(__('User profile updated successfully.'));
    }


    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        $bloggers = collect(json_decode($request->users))->pluck('id');
        $user->bloggers()->sync($bloggers);
        $user->save();

        return redirect()->route('user.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}
