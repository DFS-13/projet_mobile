<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Poi;
use Illuminate\Validation\ValidationException;

class PoiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * List all POI in table
     */
    public function all()
    {
        $pois = Poi::all();
        return response()->json($pois, 200);
    }

    /**
     * Get one POI by ID
     * @param $id
     * @return JsonResponse
     */
    public function one($id)
    {
        try {
            $poi = Poi::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        return response()->json($poi, 200);
    }

    /**
     * Create a new POI
     * @param Request $req
     * @return JsonResponse
     */
    public function create(Request $req)
    {
        try {
            $this->validate($req,[
                'id' => 'required|integer|unique:poi',
                'zip_code' => 'integer|nullable',
                'email' => 'email|nullable',
                'pricemin' => 'numeric|nullable',
                'pricemax' => 'numeric|nullable',
                'phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'fax' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'fax_phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'gid' => 'integer|nullable',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
        } catch(ValidationException $e) {
            $response = [
                "message"=> "The server can't validate the request data",
                "errors"=> $e->response->original,
            ];
            return response()->json($response, 400);
        }

        $poi = new Poi();

        $poi->id = $req->id;
        $poi->id_sitra1 = (isset($req->id_sitra1)) ? $req->id_sitra1 : null;
        $poi->type = (isset($req->type)) ? $req->type : null;
        $poi->type_detail = (isset($req->type_detail)) ? $req->type_detail : null;
        $poi->name = (isset($req->name)) ? $req->name : null;
        $poi->address = (isset($req->address)) ? $req->address : null;
        $poi->zip_code = (isset($req->zip_code)) ? $req->zip_code : null;
        $poi->town = (isset($req->town)) ? $req->town : null;
        $poi->phone = (isset($req->phone)) ? $req->phone : null;
        $poi->fax = (isset($req->fax)) ? $req->fax : null;
        $poi->fax_phone = (isset($req->fax_phone)) ? $req->fax_phone : null;
        $poi->email = (isset($req->email)) ? $req->email : null;
        $poi->website = (isset($req->website)) ? $req->website : null;
        $poi->facebook = (isset($req->facebook)) ? $req->facebook : null;
        $poi->rank = (isset($req->rank)) ? $req->rank : null;
        $poi->opening_times = (isset($req->opening_times)) ? $req->opening_times : null;
        $poi->price = (isset($req->price)) ? $req->price : null;
        $poi->pricemin = (isset($req->pricemin)) ? $req->pricemin : null;
        $poi->pricemax = (isset($req->pricemax)) ? $req->pricemax : null;
        $poi->author = (isset($req->author)) ? $req->author : null;
        $poi->gid = (isset($req->gid)) ? $req->gid : null;
        try {
            $poi->creation_date = new \DateTime();
        } catch (\Exception $e) {
            $poi->creation_date = null;
        }
        try {
            $poi->last_update = new \DateTime();
        } catch (\Exception $e) {
            $poi->last_update = null;
        }
        $poi->latitude = $req->latitude;
        $poi->longitude = $req->longitude;

        $poi->save();

        return response()->json(null, 201);
    }

    /**
     * Update the selected POI
     * @param Request $req
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $req, $id)
    {
        // exist
        try {
            $poi = Poi::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        // is valid
        try {
            $this->validate($req,[
                'zip_code' => 'integer|nullable',
                'email' => 'email|nullable',
                'pricemin' => 'numeric|nullable',
                'pricemax' => 'numeric|nullable',
                'phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'fax' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'fax_phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
                'gid' => 'integer|nullable',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
        } catch(ValidationException $e) {
            $response = [
                "message"=> "The server can't validate the request data",
                "errors"=> $e->response->original,
            ];
            return response()->json($response, 400);
        }

        // update
        $poi->type = (isset($req->type)) ? $req->type : null;
        $poi->type_detail = (isset($req->type_detail)) ? $req->type_detail : null;
        $poi->name = (isset($req->name)) ? $req->name : null;
        $poi->address = (isset($req->address)) ? $req->address : null;
        $poi->zip_code = (isset($req->zip_code)) ? $req->zip_code : null;
        $poi->town = (isset($req->town)) ? $req->town : null;
        $poi->phone = (isset($req->phone)) ? $req->phone : null;
        $poi->fax = (isset($req->fax)) ? $req->fax : null;
        $poi->fax_phone = (isset($req->fax_phone)) ? $req->fax_phone : null;
        $poi->email = (isset($req->email)) ? $req->email : null;
        $poi->website = (isset($req->website)) ? $req->website : null;
        $poi->facebook = (isset($req->facebook)) ? $req->facebook : null;
        $poi->rank = (isset($req->rank)) ? $req->rank : null;
        $poi->opening_times = (isset($req->opening_times)) ? $req->opening_times : null;
        $poi->price = (isset($req->price)) ? $req->price : null;
        $poi->pricemin = (isset($req->pricemin)) ? $req->pricemin : null;
        $poi->pricemax = (isset($req->pricemax)) ? $req->pricemax : null;
        try {
            $poi->last_update = new \DateTime();
        } catch (\Exception $e) {
            $poi->last_update = null;
        }
        $poi->latitude = $req->latitude;
        $poi->longitude = $req->longitude;

        /** @noinspection PhpUndefinedMethodInspection */
        $poi->save();

        return response()->json(null, 204);
    }

    /**
     * Delete the selected POI
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $poi = Poi::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $poi->delete();

        return response()->json(null, 204);
    }
}
