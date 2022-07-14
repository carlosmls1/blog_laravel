<?php
namespace App\Http\Controllers;

use App\Posts;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Okipa\LaravelTable\Table;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $table = (new Table)->model(Posts::class)->routes([
            'index'   => ['name' => 'posts.index'],
            'show'   => ['name' => 'posts.show'],
            'create'  => ['name' => 'posts.create'],
            'edit'    => ['name' => 'posts.edit'],
            'destroy' => ['name' => 'posts.destroy'],
        ])->destroyConfirmationHtmlAttributes(function (Posts $post) {
            return [
                'data-confirm' => 'Are you sure you want to delete the admin ' . $post->name . ' ?',
            ];
        });
        $table->query(function (Builder $query) {
            $query->select('posts.*');
            $query->leftJoin('users', 'users.id', '=', 'posts.user_id');
            $query->addSelect('users.name as author');
        });
        $table->rowsNumber(20) ;
        $table->column('name')->title('Name')->sortable(true)->searchable();
        $table->column('description')->title('Description')->sortable()->searchable();
        $table->column('author')->title('Author');

        return view('posts.index', compact('table'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Posts::create(array_merge($request->only('name', 'description', 'body'),[
            'user_id' => auth()->id()
        ]));

        return redirect()->route('posts.index')
            ->withSuccess(__('Post created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $post)
    {
        $post->update($request->only('name', 'description', 'body'));

        return redirect()->route('posts.index')
            ->withSuccess(__('Post updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->withSuccess(__('Post deleted successfully.'));
    }
}
