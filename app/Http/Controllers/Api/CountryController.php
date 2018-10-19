<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Countries;
use Illuminate\Support\Collection;

/**
 * Provides information relating to countries and states.
 */
class CountryController extends Controller
{
    /**
     * Returns the complete list of countries.
     *
     * @return Collection
     */
    public function index()
    {
        return Countries::all()->map(function ($country) {
            return $country->get('name.common');
        });
    }

    /**
     * Returns the complete list of states for a country.
     *
     * @param string $country
     *
     * @return Collection
     */
    public function states(string $country)
    {
        $country = Countries::where('cca3', $country)->first();

        if ($country->isEmpty()) {
            abort(404);
        }

        return $country->hydrateStates()
            ->states
            ->pluck('name', 'postal');
    }
}
