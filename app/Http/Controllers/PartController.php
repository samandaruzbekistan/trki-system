<?php

namespace App\Http\Controllers;

use App\Repositories\PartRepository;
use App\Repositories\SectionRepository;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function __construct(protected PartRepository $partRepository, protected SectionRepository $sectionRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'section_id' => 'required|numeric|exists:sections,id',
            'duration' => 'required|numeric',
            'max_score' => 'required|numeric',
            'type' => 'required|string',
            'video_frame' => 'nullable|string',
            'exam_id' => 'required|numeric|exists:exams,id',
        ]);
        if ($request->hasFile('audio')){
            $file = $request->file('audio')->getClientOriginalExtension();
            $name = md5(microtime());
            $audio_name = "audios/".$name.".".$file;
            $path = $request->file('audio')->move('audios/',$audio_name);
            $data['audio'] = $audio_name;
        }
        $part = $this->partRepository->create($data);

        return back()->with('successfully', "Part muvaffaqiyatli yaratildi");
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
