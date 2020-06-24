<?php
namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class CitiesController extends Controller
{

    public function index(Request $request, $provinceId)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $cities = City::where('province_id', $provinceId)
            ->orderBy('id', 'ASC')
            ->pluck('name', 'id')
            ->toArray();

        return response($cities);
    }

}
