<?php
namespace Hyroshut\Controllers;

class PagesController extends BaseController
{
    public function index($request, $response, $args)
    {
        return $this->render($response, "home");
    }
}