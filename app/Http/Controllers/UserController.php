<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function peticionesFirmadas()
    {
        return app(PeticioneController::class)->peticionesFirmadas();
    }
}
