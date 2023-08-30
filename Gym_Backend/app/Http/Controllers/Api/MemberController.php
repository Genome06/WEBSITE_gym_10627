<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\members;

class MemberController extends Controller
{
    public function index()
    {
        $users=members::all();

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
        $user=members::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve member success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'member not found',
            'data'=>null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'username'=>'required',
            'password'=>'required',
            'nama'=>'required|max:60',
            'status' => 'required',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required',
            'sisa_deposit_uang' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $storeData['password'] = bcrypt($request->password);  

        $ulasan = members::create($storeData);
        return response([
            'message' => 'Add Member Success',
            'data' => $ulasan
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $user = members::find($id);
        if(is_null($user)){
            return response([
                'message' => 'member Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username'=>'required',
            'nama'=>'required|max:60',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $updateData['password'] = bcrypt($request->password);

        $user->username = $updateData['username'];
        $user->password = $updateData['password'];
        $user->nama = $updateData['nama'];
        $user->no_hp = $updateData['no_hp'];
        $user->alamat = $updateData['alamat'];
        $user->status = $updateData['status'];
        $user->sisa_deposit_uang = $updateData['sisa_deposit_uang'];

        if($user->save()){
            return response([
                'message' => 'Update Member Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Member Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=members::find($id);

        if(is_null($user)){
            return response([
                'message'=>'Member not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'delete Member success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete Member failed',
            'data'=>null
        ],400);
    }

    public function reset(Request $request, $id) 
    {
        $user = members::find($id);
        if(is_null($user)){
            return response([
                'message' => 'member Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $updateData['password'] = bcrypt($request->password);

        $user->password = $updateData['password'];
        if($user->save()){
            return response([
                'message' => 'Reset Password Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Reset Password Failed',
            'data' => null
        ], 400);
    }

    public function search()
    {
        $searchQuery = request('query');

        $user= members::where('nama', 'LIKE', "%{$searchQuery}%")->get(); 

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Member success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Instruktur not found',
            'data'=>null
        ],404);
    }

    public function updateSisa(Request $request, $id) 
    {
        $user = members::find($id);
        if(is_null($user)){
            return response([
                'message' => 'member Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'sisa_deposit_uang' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $user->sisa_deposit_uang = $updateData['sisa_deposit_uang'];

        if($user->save()){
            return response([
                'message' => 'Update Member Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Member Failed',
            'data' => null
        ], 400);
    }

    public function updateStatus(Request $request, $id) 
    {
        $user = members::find($id);
        if(is_null($user)){
            return response([
                'message' => 'member Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $user->status = $updateData['status'];

        if($user->save()){
            return response([
                'message' => 'Update Member Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Member Failed',
            'data' => null
        ], 400);
    }
}