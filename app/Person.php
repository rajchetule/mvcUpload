<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Person extends Model
{
    protected $fillable = [
        'name', 'email', 'contact', 'city',
    ];

    public function getAllPersonList()
    {
        return Person::where('is_deleted', 0)->get();
    }

    public function savePerson(Request $request)
    {
        $saveResult = false;
        DB::beginTransaction();

        $data = $request->only('name', 'email', 'contact', 'city');
        // dd($data);
        $saveResult = Person::create($data);
        if ($saveResult) {
            DB::commit();
        }else{
            DB::rollback();
        }
        return $saveResult;
    }
}
