<?php

namespace App\Http\Controllers;

use App\Repositories\PartRepository;
use App\Repositories\SectionRepository;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function __construct(protected PartRepository $partRepository, protected SectionRepository $sectionRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $section = $this->sectionRepository->getById($id);
        return view('admin.section', ['section' => $section]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
