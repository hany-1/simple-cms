<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $type = $this->returnType($request->route()->getName());
        if ($type == null) return abort(404);

        if (request()->ajax()) {
            $items = Term::with(['taxanomies'])
                ->when(isset($request->search['value']) && !empty($request->search), function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search['value'] . '%');
                })
                ->whereHas('taxanomies', function ($q) use ($type) {
                    $q->where('taxanomy',  $type);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $data['draw'] = isset($request->draw) ? intval($request->draw) : 0;
            $data['recordsTotal'] = count($items);
            $data['recordsFiltered'] = count($items);
            $data['data'] = $items;
            return response($data);
        }

        return view($this->viewName($type));
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
        $type = $this->returnType(request()->route()->getName());
        if ($type == null) return abort(404);

        if ($id == null) {
            $item = new Term;
        } else {
            $item = Term::find($id);
        }

        return view($this->viewName($type, true))->with(['item' => $item]);
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
        // 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validateType(Request $request)
    {
        $type = $this->returnType($request->route()->getName());
        if ($type == null) return abort(404);
    }

    private function returnType($route = null)
    {
        if ($route == null) return;
        $type = null;
        $prefix = explode('.', $route)[1];
        switch ($prefix) {
            case 'categories':
                $type = CATEGORY;
                break;
            case 'tags':
                $type = POST_TAG;
                break;
        }

        return $type;
    }

    private function routeName($type = null, $isEdit = false)
    {
        $view = null;
        switch ($type) {
            case CATEGORY:
                $view = $isEdit ? 'admin.categories.edit' : 'admin.categories.index';
                break;
            case POST_TAG:
            case PAGE_TAG:
                $view = $isEdit ? 'admin.tags.edit' : 'admin.tag.index';
                break;
            default:
                $view = null;
                break;
        }

        return $view;
    }

    private function viewName($type = null, $isEdit = false)
    {
        $view = null;
        switch ($type) {
            case CATEGORY:
                $view = $isEdit ? 'category.edit' : 'category.index';
                break;
            case POST_TAG:
            case PAGE_TAG:
                $view = $isEdit ? 'tag.edit' : 'tag.index';
                break;
        }

        return $view;
    }
}
