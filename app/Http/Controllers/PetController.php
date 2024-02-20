<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{

    private $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => config('values.apiUrl'),
            'verify' => base_path('cacert.pem'),
        ]);
    }

    private function getPetById(int $id)
    {
        $response = Http::setClient($this->http)->acceptJson()->get('pet/' . $id);
        if ($response->successful()) {
            return $response->json();
        }
        return $response->throw();
    }

    private function getPetsByStatus(string $status = 'available')
    {
        $response = Http::setClient($this->http)->acceptJson()->get('pet/findByStatus?status=' . $status);
        if ($response->successful()) {
            return $response->json();
        }
        return $response->throw();
    }

    public function index()
    {
        $pets = array_merge($this->getPetsByStatus('available'), $this->getPetsByStatus('pending'), $this->getPetsByStatus('sold'));
        // dd($pets);
        return view('index', ['pets' => $pets]);
    }

    public function showCreate()
    {
        return view('create');
    }

    public function createPet(Request $req)
    {
        $rules = [
            'pet_id' => 'required|min:0',
            'pet_name' => 'required',
            'pet_category' => 'required',
            'pet_status' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('create')->with('failed', "{{$validator->errors()}}");
        }

        $formTags = $req->input('pet_tag');
        $tags = array_map(
            function ($tag, $index) {
                return [
                    'id' => $index,
                    'name' => $tag
                ];
            },
            $formTags,
            array_keys($formTags)
        );

        $response = Http::setClient($this->http)->acceptJson()->post('pet', [
            'id' => $req->input('pet_id'),
            'category' => [
                'id' => 0,
                'name' => $req->input('pet_category')
            ],
            'name' => $req->input('pet_name'),
            'photoUrls' => $req->input('pet_photo_url'),
            'tags' => $tags,
            'status' => $req->input('pet_status')
        ]);

        if ($response->successful()) {
            return redirect()->route('index')->with('alert', 'Successfully created new pet');
        }
        return redirect()->route('create')->with('failed', "operation failed");
    }

    public function showEdit($id)
    {
        return view('edit', ['pet' => $this->getPetById($id)]);
    }

    public function editPet(Request $req, $id)
    {
        $response = Http::setClient($this->http)->acceptJson()->asForm()->post('pet/' . $id, [
            'name' => $req->input('pet_name'),
            'status' => $req->input('pet_status')
        ]);
        if ($response->successful()) {
            return redirect()->route('index');
        }
        return redirect()->route('index')->with('alert', 'Something went wrong, could not edit selected pet');
    }

    public function deletePet($id)
    {
        $response = Http::setClient($this->http)->acceptJson()->delete('pet/' . $id);
        if ($response->successful()) {
            return redirect()->route('index');
        }
        return redirect()->back()->with('alert', 'Something went wrong, could not delete selected pet');
    }
}
