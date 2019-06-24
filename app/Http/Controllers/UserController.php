<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Type;
use DB;

class UserController extends Controller
{
    public function getUsers()
    {
        
        $users = User::with('profiles')->get();

        $collection = collect();

        foreach ($users as $user) {

            $oneUser = [];

            $oneUser['id_number'] =  $user->id_number;
            $oneUser['first_names'] =  $user->first_names;
            $oneUser['last_name'] =  $user->last_name;

            foreach ($user->profiles as $profile) {
                $profile = $profile->load('type');
                $oneUser[$profile->type->type] = $profile->value;
            }    
            $collection->push($oneUser);
        }

        return response()->json($collection);
    }

    public function getUser($id)
    {
        $users = DB::table('tuser')
            ->leftJoin('tprofile', 'tuser.id', '=', 'tprofile.tUSER_id')
            ->leftJoin('ttypes', 'tprofile.tTYPES_id', '=', 'ttypes.id')
            ->select('id_number','first_names',  'last_name', 'type', 'value')
            ->where('tuser.id_number', $id)
            ->get();

        $collection = collect();

        foreach ($users as $user) {

            $collection->push(['id_number'  => $user->id_number]);
            $collection->push(['first_names' => $user->first_names]);
            $collection->push(['last_names' => $user->last_name]);
            $collection->push([$user->type  => $user->value]);
        }    

        $flattened = $collection->flatMap(function ($values) {
            return $values;
        });

        return response()->json($flattened);
    }

    public function create(Request $request)
    {
        $this->validate($request, [

            "first_names" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "id_number" => "required|numeric|digits:13",
            "profile_types.record_number" => "required|numeric",
            "profile_types.msisdn" => "required|numeric",
            "profile_types.network" => "required|string",
            "profile_types.points" => "required|numeric",
            "profile_types.card_number" => "required|digits:16",
            "profile_types.gender" => "required|in:M,F",

        ]);

        $user = User::create($request->only('id_number', 'first_names', 'last_name'));

        $profile_types = $request->only('profile_types')['profile_types'];

        $types = Type::all()->pluck('id', 'type');

        foreach ($profile_types as $key => $value) {

            if($key === 'msisdn') {
                $value = '0'.substr( preg_replace('/[^0-9]/', '', trim($value)), -9);
            }

            $user->profiles()->create([
                'tTYPES_id' => $types[$key],
                'value' => $value
            ]);
        }

        return response()->json($user, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            "first_names" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "id_number" => "required|numeric|digits:13",
            "profile_types.record_number" => "required|numeric",
            "profile_types.msisdn" => "required|numeric",
            "profile_types.network" => "required|string",
            "profile_types.points" => "required|numeric",
            "profile_types.card_number" => "required|digits:16",
            "profile_types.gender" => "required|in:M,F",
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('id_number', 'first_names', 'last_name'));

        $profile_types = $request->only('profile_types')['profile_types'];
        
        $types = Type::all()->pluck('id', 'type');

        foreach ($profile_types as $key => $value) {

            $profile = Profile::where([
                ['tUSER_id', '=', $user->id],
                ['tTYPES_id', '=', $types[$key]]
            ])->get();

            if(isset($profile->id)) {
                $profile->value = $value;
                $profile->save();
            } else {
                $user->profiles()->create([
                    'tTYPES_id' => $types[$key],
                    'value' => $value
                ]);                
            }
        }

        return response()->json($user, 200);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
