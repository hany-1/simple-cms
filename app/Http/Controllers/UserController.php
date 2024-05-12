<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (request()->ajax()) {
            $items = User::orderBy('created_at', 'desc')
                ->get();

            $data['draw'] = isset($request->draw) ? intval($request->draw) : 0;
            $data['recordsTotal'] = count($items);
            $data['recordsFiltered'] = count($items);
            $data['data'] = $items;
            return response($data);
        }

        return view('users.index');
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
        if ($id == null) {
            $item = new User;
        } else {
            $item = User::find($id);
        }

        return view('users.edit')->with([
            'item' => $item,
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
        //
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'status' => ['required', Rule::in(User::user_statuses())]
        ];
        if (isset($request->password) && $request->password != null) {
            $rules['password'] = ['min:8', 'string', ($id == null ? 'required' : '')];
        }
        $request->validate($rules);

        $data = $request->except(['_method']);
        $isEdit = false;
        if ($id == null) {
            $item = User::create($data);
        } else {
            if ($data['password'] == null) {
                unset($data['password']);
            }
            $isEdit = true;
            $item = User::find($id);
            $item->update($data);
        }

        return redirect()->route('admin.users.index')->with([
            'message' =>  'User ' . $item->name . ' ' . ($isEdit ? 'updated' : 'created') . '!',
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
        $item = User::find($id);
        if ($item && $this->user && $item->id == $this->user->id) {
            return response(['message' => 'Invalid action!']);
        }
        $item->delete();
        return response(['message' => 'User deleted!']);
    }
}
