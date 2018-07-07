<?php

namespace Backpack\CRUD\app\Http\Controllers;

use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;
use Illuminate\Http\Request as StoreRequest;
use Illuminate\Support\Facades\Form as Form;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request as UpdateRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Backpack\CRUD\app\Http\Controllers\Operations\Create;
use Backpack\CRUD\app\Http\Controllers\Operations\Delete;
use Backpack\CRUD\app\Http\Controllers\Operations\ListEntries;
use Backpack\CRUD\app\Http\Controllers\Operations\Reorder;
use Backpack\CRUD\app\Http\Controllers\Operations\Revisions;
use Backpack\CRUD\app\Http\Controllers\Operations\SaveActions;
use Backpack\CRUD\app\Http\Controllers\Operations\Show;
use Backpack\CRUD\app\Http\Controllers\Operations\Update;

class CrudController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use Create, Update, ListEntries, Delete, Show, Reorder, Revisions, SaveActions;

    public $data = [];
    public $request;

    /**
     * @var CrudPanel
     */
    public $crud;

    public function __construct()
    {
        if (! $this->crud) {
            $this->crud = app()->make(CrudPanel::class);

            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware(function ($request, $next) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next($request);
            });
        }
    }

    /**
     * Allow developers to set their configuration options for a CrudPanel.
     */
    public function setup()
    {
    }

}
