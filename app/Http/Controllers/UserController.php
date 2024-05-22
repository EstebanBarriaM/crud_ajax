<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {

            $data = User::latest()->get();

            return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row) {

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Editar</a>';
                            $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Eliminar</a>';

                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);

        };

        return view('users.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        User::updateOrCreate([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return back()->with('messagge', 'Registro Guardado');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
