<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermTaxanomy;
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
            $items = Term::with(['taxanomy'])
                ->when(isset($request->search['value']) && !empty($request->search), function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search['value'] . '%');
                })
                ->whereHas('taxanomy', function ($q) use ($type) {
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
            $item->taxanomy = new TermTaxanomy;
        } else {
            $item = Term::with(['taxanomy'])->find($id);
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
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];
        $request->validate($rules);

        $type = $this->returnType(request()->route()->getName());
        $data = $request->except(['_method']);
        $isEdit = false;
        if ($id == null) {
            $item = Term::create($data);
        } else {
            $item = Term::find($id);
            $item->update($data);
            $isEdit = true;
        }

        if ($item) {
            if ($isEdit) {
                $taxanomy = TermTaxanomy::where('taxanomy', $type)->where('term_id', $item->id)->first();
                $taxanomy->description = isset($data['description']) ? $data['description'] : null;
                $taxanomy->save();
            } else {
                $taxanomy = TermTaxanomy::create([
                    'taxanomy' => $type,
                    'description' => isset($data['description']) ? $data['description'] : null,
                ]);
                $item->taxanomy()->save($taxanomy);
            }
        }

        return redirect()->route($this->routeName($type))->with([
            'message' => 'Term created!',
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
        $item = Term::find($id);
        if ($item) {
            if ($item->taxanomy) {
                $item->taxanomy->delete();
            }
            $item->delete();
            return response(['message' => 'Term deleted!']);
        }
        return response(['message' => 'Invalid term!']);
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
                $view = $isEdit ? 'admin.tags.edit' : 'admin.tags.index';
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
