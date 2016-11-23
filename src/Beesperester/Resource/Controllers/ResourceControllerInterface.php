<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;

interface ResourceControllerInterface
{
    /**
    * Show all instances.
    *
    * @var Request $request
    * @return array
    */
    public function index(Request $request);

    /**
    * Create new Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function create(Request $request);

    /**
    * Store new Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function store(Request $request);

    /**
    * Show Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function show(Request $request);

    /**
    * Edit Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function edit(Request $request);

    /**
    * Update Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function update(Request $request);

    /**
    * Destroy Instance.
    *
    * @var Request $request
    * @return array
    */
    public function destroy(Request $request);
}
