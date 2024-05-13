<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    //Public variables
    var $type = POST;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $items = Post::with(['author'])
                ->when(isset($request->search['value']) && !empty($request->search), function ($q) use ($request) {
                    $q->whereHas('author', function ($qq) use ($request) {
                        $qq->where('name', 'like', '%' . $request->search['value'] . '%');
                    })
                        ->orWhere('title', 'like', '%' . $request->search['value'] . '%')
                        ->orWhere('name', 'like', '%' . $request->search['value'] . '%');
                })
                ->where('post_type', $this->type)
                ->orderBy('created_at', 'desc')
                ->get();

            $data['draw'] = isset($request->draw) ? intval($request->draw) : 0;
            $data['recordsTotal'] = count($items);
            $data['recordsFiltered'] = count($items);
            $data['data'] = $items;
            return response($data);
        }

        return view($this->returnView());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $item = Post::with(['author'])->find($id);
        // return view('posts.show')->with([
        //     'item' => $item
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if ($id == null) {
            $item = new Post;
            $item->post_type = $this->type;
        } else {
            $item = Post::find($id);
        }

        $allPosts = Post::where('id', '!=', $id)->where('post_type', $this->type)->get();

        return view($this->returnView(true))->with([
            'item' => $item,
            'statuses' => Post::statuses(),
            'allPosts' => $allPosts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => ['required', Rule::unique(Post::class)->where('post_type', $this->type)->ignore($id)],
            'name' => 'required',
            'menu_order' => 'integer',
            'content' => 'required',
            'status' => Rule::in(Post::statuses()),
        ];
        $request->validate($rules);
        $data = $request->except(['_method']);
        if ($id == null) {
            $data['post_type'] = $this->type;
            $item = Post::create($data);
            $item->author()->associate($this->user);
            $item->save();
        } else {
            $item = Post::find($id);
            $item->update($data);
        }

        if ($item) {
            //generate slug here
            $item->slug = slugify($item->title);
            $item->save();
        }

        return redirect()->route($this->returnRoute())->with([
            'message' => $this->returnMessage(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Post::find($id);
        if ($item) {
            $item->delete();
            return response(['message' => 'Post deleted!']);
        }
        return response(['message' => 'Invalid post selected!']);
    }

    private function returnView($isEdit = false)
    {
        $view = null;
        switch ($this->type) {
            case POST:
                $view = $isEdit ? 'posts.edit' : 'posts.index';
                break;
            case PAGE:
                $view = $isEdit ? 'pages.edit' : 'pages.index';
                break;
            default:
                $view = null;
                break;
        }
        return $view;
    }

    private function returnRoute($isEdit = false)
    {
        $view = null;
        switch ($this->type) {
            case POST:
                $view = $isEdit ? 'admin.posts.edit' : 'admin.posts.index';
                break;
            case PAGE:
                $view = $isEdit ? 'admin.pages.edit' : 'admin.pages.index';
                break;
            default:
                $view = null;
                break;
        }
        return $view;
    }

    private function returnMessage()
    {
        $message = null;
        switch ($this->type) {
            case POST:
                $message = 'Post created!';
                break;
            case PAGE:
                $message = 'Page created!';
                break;
            default:
                $message = null;
                break;
        }
        return $message;
    }

    public function getPage(Request $request)
    {
        $page = Post::where('slug', $request->slug)->where('post_type', PAGE)->first();
        return view('templates.resume.index', ['page' => $page]);
    }
}
