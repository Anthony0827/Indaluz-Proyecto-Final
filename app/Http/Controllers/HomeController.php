<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio principal
     */
    public function index() 
    {
        return view('home');
    }

    /**
     * Mostrar la página "Nosotros"
     */
    public function nosotros()
    {
        return view('nosotros');
    }

    /**
     * Mostrar la página "Sostenibilidad"
     */
    public function sostenibilidad()
    {
        return view('sostenibilidad');
    }

    /**
     * Mostrar la página "Para Agricultores"
     */
    public function agricultores()
    {
        return view('agricultores');
    }

    /**
     * Mostrar la página "Contacto"
     */
    public function contacto()
    {
        return view('contacto');
    }
}