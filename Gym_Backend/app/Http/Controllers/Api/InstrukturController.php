<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Instruktur;
use function PHPUnit\Framework\returnSelf;

class InstrukturController extends Controller
{
    public function index()
    {
        $instruktur=Instruktur::all();

        if(count($instruktur)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$instruktur
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=Instruktur::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Instruktur success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Instruktur not found',
            'data'=>null
        ],404);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'username'=>'required',
            'password'=>'required',
            'nama'=>'required|max:60',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
        $storeData['password'] = bcrypt($request->password);    

        $instruktur = Instruktur::create($storeData);
        return response([
            'message' => 'Add Instruktur Success',
            'data' => $instruktur
        ], 200);
    }

   
    public function update(Request $request, $id) 
    {
        $instruktur = Instruktur::find($id);
        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username'=>'required',
            'password'=>'required',
            'nama'=>'required|max:60',
            'no_hp' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $updateData['password'] = bcrypt($request->password);

        $instruktur->username = $updateData['username'];
        $instruktur->password = $updateData['password'];
        $instruktur->nama = $updateData['nama'];
        $instruktur->no_hp = $updateData['no_hp'];
        $instruktur->alamat = $updateData['alamat'];

        if($instruktur->save()){
            return response([
                'message' => 'Update Instruktur Success',
                'data' => $instruktur
            ], 200);
        }

        return response([
            'message' => 'Update Instruktur Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $instruktur=Instruktur::find($id);

        if(is_null($instruktur)){
            return response([
                'message'=>'Instruktur not found',
                'data'=>null
            ],404);
        }

        if($instruktur->delete()){
            return response([
                'message'=>'delete Instruktur success',
                'data'=>$instruktur
            ],200);
        }

        return response([
            'message'=>'deleteInstruktur failed',
            'data'=>null
        ],400);
    }

    public function search()
    {
        $searchQuery = request('query');

        $user= Instruktur::where('nama', 'LIKE', "%{$searchQuery}%")->get(); 

        if(!is_null($user)){
            return response([
                'message'=>'retrieve Instruktur success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'Instruktur not found',
            'data'=>null
        ],404);
    }
}