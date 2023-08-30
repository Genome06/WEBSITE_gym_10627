<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        $users=Promo::all();

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
        $user=Promo::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Promo success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Promo not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama'=>'required|max:60',
            'potongan_promo' => 'required',
            'masa_aktif' => 'required',
            'status_aktif' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $storeData['password'] = bcrypt($request->password);  
            
        $pegawai = Promo::create($storeData);
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $user = Promo::find($id);
        if(is_null($user)){
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama'=>'required|max:60',
            'potongan_promo' => 'required',
            'masa_aktif' => 'required',
            'status_aktif' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);


        $user->nama = $updateData['nama'];
        $user->potongan_promo = $updateData['potongan_promo'];
        $user->masa_aktif = $updateData['masa_aktif'];
        $user->status_aktif = $updateData['status_aktif'];

        if($user->save()){
            return response([
                'message' => 'Update Promo Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Promo Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=Promo::find($id);

        if(is_null($user)){
            return response([
                'message'=>'Promo not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'delete Promo success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete Promo failed',
            'data'=>null
        ],400);
    }
}