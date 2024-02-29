<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;

class CompanyController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    protected $model = Company::class;
    // // public function index()
    // // {
    // //     return CompanyResource::collection(Company::all());
    // // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(CompanyRequest $request)
    // {
    //     $company = Company::create($request->all());

    //     return new CompanyResource($company);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Company  $company
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Company $company)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Company  $company
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Company $company)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Company  $company
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(CompanyRequest $request, Company $company)
    // {
    //     $company->update($request->all());

    //     return new CompanyResource($company);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Company  $company
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Company $company)
    // {
    //     $company->delete();

    //     return new CompanyResource($company);
    // }
}
