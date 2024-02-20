<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

use function Laravel\Prompts\alert;

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

    public function index()
    {
        $pets = array_merge($this->getPetsByStatus('available'), $this->getPetsByStatus('pending'), $this->getPetsByStatus('sold'));
        // dd($pets);
        return view('index', ['pets' => $pets]);
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

    public function showEdit($id)
    {
        return view('edit', ['pet' => $this->getPetById($id)]);
    }

    public function editPet(Request $req, $id)
    {
        
    }

    public function deletePet($id)
    {
        $response = Http::setClient($this->http)->acceptJson()->delete('pet/' . $id);
        if ($response->successful()) {
            return $this->index();
        }
        return redirect()->back()->with('alert', 'Something went wrong, could not delete selected pet');
    }
}
