<?php

namespace Indy\LaravelConfiguration\Http\Controllers;

use Indy\LaravelConfiguration\Configuration;
use Indy\LaravelConfiguration\Http\Requests\ConfigurationRequest;

use Illuminate\Routing\Controller;

class ConfigurationController extends Controller
{
    protected $confugrationTypes;
    /**
     * Create a new instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->configurationTypes = Configuration::getTypes();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configurations = Configuration::all();
        return view('configurations::index', [
          'configurations' => $configurations,
          'configurationTypes' => $this->configurationTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configurations::create', [
            'configuration' => new Configuration(),
            'configurationTypes' => $this->configurationTypes,
            'method' => 'POST',
            'label' => __('Record'),
            'title' => __('Add a new parameter'),
            'url' => route('configurations.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Indy\LaravelConfiguration\Http\Requests\ConfigurationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigurationRequest $request)
    {
        $data = $this->filters($request, 'POST');
        $configuration = Configuration::updateOrCreate($data);
        return redirect(route('configurations.edit', $configuration))->withSuccess(__('Data saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function show(Configuration $configuration)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuration $configuration)
    {
        return view('configurations::create', [
            'configuration' => $configuration,
            'configurationTypes' => $this->configurationTypes,
            'method' => 'PUT',
            'label' => __('Update'),
            'title' => __('Edit a parameter'),
            'url' => route('configurations.update', $configuration)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ConfigurationRequest  $request
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigurationRequest $request, Configuration $configuration)
    {
        $data = $this->filters($request, 'PUT');
        $configuration->update($data);
        return redirect(route('configurations.edit', $configuration))
          ->withSuccess(__('Data saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        return back()->withSuccess(__('Data removed'));
    }

    /**
     * Filter datas requests
     *
     * @param  \App\Http\Requests\ConfigurationRequest la requete après validation
     * @param  string $method
     * @return array The filtered data
     */
    protected function filters(ConfigurationRequest $request, $method = 'POST')
    {
        return $request->validated();
    }
}
