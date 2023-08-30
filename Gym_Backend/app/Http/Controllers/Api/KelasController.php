<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $users = Kelas::with('promo')->latest()->get();

        if(count($users)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$users
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=Kelas::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Kelas success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Kelas not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama'=>'required|max:60',
            'jenis_kelas' => 'required',
            'id_promo' => 'required',
            'harga_kelas' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); 

        $instruktur = Kelas::create($storeData);
        return response([
            'message' => 'Add Instruktur Success',
            'data' => $instruktur
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $user = Kelas::find($id);
        if(is_null($user)){
            return response([
                'message' => 'Kelas Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama'=>'required|max:60',
            'jenis_kelas' => 'required',
            'id_promo' => 'required',
            'harga_kelas' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);


        $user->nama = $updateData['nama'];
        $user->jenis_kelas = $updateData['jenis_kelas'];
        $user->id_promo = $updateData['id_promo'];
        $user->harga_kelas = $updateData['harga_kelas'];

        if($user->save()){
            return response([
                'message' => 'Update KelasSuccess',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Kelas Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=Kelas::find($id);

        if(is_null($user)){
            return response([
                'message'=>'Kelas not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'delete Kelas success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete Kelas failed',
            'data'=>null
        ],400);
    }
}