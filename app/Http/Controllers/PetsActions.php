<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPetForm;
use App\Http\Requests\updatePetForm;
use Exception;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PetsActions extends Controller
{
    private $url;
    private $petObjectProperties = ['id', 'category', 'name', 'photoUrls', 'tags', 'status'];

    public function __construct()
    {
        $this->url = config('app.destination_url');
    }

    private function fetchDataBy(string $url, string $method, $body = [])
    {
        try{
            $client = new Client(['verify' => false]);
            $response = $client->{$method}($url, ['json' => $body]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data;
        }
        catch(Exception $err)
        {
            return $err;
        }
    }

    private $availableFetchActions = ["id" => "", "status" => "findByStatus?status="];

    public function fetchPetBy(Request $request, $param)
    {
        $type = $request->input('type');
        $additionalUrlPart = $this->availableFetchActions["$type"];

        // Find pet
        $data = $this->fetchDataBy($this->url.$additionalUrlPart.$param, 'GET');
        if($data instanceof GuzzleException) return ['error' => 'Pet with included id could not be found.'];

        return $data;
    }

    public function addPet(AddPetForm $req)
    {
        $values = [];
        foreach($this->petObjectProperties as $name) $values["$name"] = $req->input("$name");

        $values['category'] = $values['category'][0];
        $values['photoUrls'] = $values['photoUrls']? explode(',', $values['photoUrls']): [];

        // Add new pet to database
        $data = $this->fetchDataBy($this->url, 'POST', $values);
        if($data instanceof GuzzleException) return ['error' => 'Somethink gone wrong, try again later.'];

        return ['done' => 'Pet has been added.'];
    }

    public function updatePet(updatePetForm $req)
    {
        $values = [];
        $id = $req->input('id');

        // check if exists pet with included id
        $data = $this->fetchDataBy($this->url.$id, 'GET');
        if($data instanceof GuzzleException) return ['error' => 'Pet with included id could not be found.'];

        foreach($this->petObjectProperties as $name) $values["$name"] = $req->input("$name");

        $values['category'] = $values['category'][0];
        $values['photoUrls'] = $values['photoUrls']? explode(',', $values['photoUrls']): [];

        // Swap choosen pet object
        $data = $this->fetchDataBy($this->url, 'PUT', $values);
        if($data instanceof GuzzleException) return ['error' => 'Somethink gone wrong, try again later.'];

        return ['done' => 'Pet has been updated.'];
    }

    public function deletePet(Request $req)
    {
        $id = $req->input('id');
        if(!is_numeric($id))return ['error' => 'Id should be integar value.'];

        // check if exists pet with included id
        $data = $this->fetchDataBy($this->url.$id, 'GET');
        if($data instanceof GuzzleException) return ['error' => 'Pet with included id could not be found.'];

        // delete choosen pet
        $data = $this->fetchDataBy($this->url.$id, 'DELETE');
        if($data instanceof GuzzleException) return ['error' => 'Somethink gone wrong, try again later.'];

        return ['done' => 'Pet has been deleted.'];
    }
}
