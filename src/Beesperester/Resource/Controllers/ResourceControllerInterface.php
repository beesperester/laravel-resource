<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;

interface ResourceControllerInterface
{

    /**
    * Create new Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function create(Request $request);

    /**
    * Destroy Instance.
    *
    * @param Request $request
    * @return array
    */
    public function destroy(Request $request);

    /**
    * Edit Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function edit(Request $request);

    /**
    * Show all instances.
    *
    * @param Request $request
    * @return array
    */
    public function index(Request $request);

    /**
    * Show Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function show(Request $request);

    /**
    * Store new Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function store(Request $request);

    /**
    * Update Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function update(Request $request);
}
