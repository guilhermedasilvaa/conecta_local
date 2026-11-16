<?php

namespace App\Controllers;

use App\Models\PublicCatalogModel;
use Config\BrazilianStates;

class HomeController extends BaseController
{
    public function index(): string
    {
        $catalog = new PublicCatalogModel();

        return view('public/home', [
            'categories'   => $catalog->activeCategories(),
            'professionals' => $catalog->featuredProfessionals(),
            'states'       => BrazilianStates::STATES,
        ]);
    }
}
