<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\services\PayUservice\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Person;
use App\Sallery;
use Session;

class PersonController extends Controller
{
    public function __construct(Sallery $sallery, Person $person)
    {

        $this->person = $person;
        $this->sallery = $sallery;
    }



    public function add(Request $request){


        if ($request->isMethod('post')) {
            // dd($request);
            $person_save_data = $this->person->savePerson($request);
            $person_id = $this->person->where('email', $request->email)->first()->id;
            // dd($person_id);

            $file = $request->file('file');
            $fileD = fopen($file,"r");
            $get_data = array();

            $column=fgetcsv($fileD);
            // dd($column);
            while(($data = fgetcsv($fileD, 200, ",")) !==FALSE ){
                $date = $data[1];
                $product = $data[2];
                $price = $data[3];

                $get_data[] = array($date, $product, $price);
            }
            fclose( $fileD );

            $inserted_data =[];
            foreach($get_data as $key => $value) {
                // dd($key[]);
                $inserted_data[] = array(
                    'person_id'=>$person_id,
                    'date'=>date("Y-m-d", strtotime($value[0])),
                    'product'=>$value[1],
                    'price'=>$value[2],
                );
                Sallery::create($inserted_data[$key]);
                // dd($inserted_data[$key]);
            }

        }
        $persons = $this->person->getAllPersonList();
        return view('person-list', compact('persons'));

    }
}


