<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassworkController extends Controller
{

    protected function getType(Request $request)
    {
        $type = request()->query('type');
        $allowed_types = [
            Classwork::TYPE_ASSIGNMENT, Classwork::TYPE_MATERIAL, Classwork::TYPE_QUESTION
        ];
        if (!in_array($type, $allowed_types)) {
            $type = Classwork::TYPE_ASSIGNMENT;
        }
        return $type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Classroom $classroom)
    {
        // $classworks = Classwork::where('classroom_id', '=', $classroom->id)->get();
        $classworks = $classroom->classworks()
            ->with('topic') //Eager load
            ->orderBy('published_at')
            ->get(); // same get but better in performance


        return view('classworks.index', [
            'classroom' => $classroom,
            'classworks' => $classworks->groupBy('topic_id')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {

        $type = $this->getType($request);

        return view('classworks.create', compact('classroom', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $type = $this->getType($request);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
            // 'classroom_id' => $classroom->id
        ]);


        DB::transaction(function () use ($classroom, $request) {
            $classwork = $classroom->classworks()->create($request->all());
            // $classwork = Classwork::create($request->all());

            $classwork->users()->attach($request->input('students'));
        });


        return redirect()
            ->route('classrooms.classworks.index', $classroom->id)
            ->with('success', 'Classwork created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        //$classwork->load('commnets.user');
        return view('classworks.show' , compact('classroom','classwork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $type = $this->getType($request);
        $assigned = $classwork->users()->pluck('id')->toArray();

        return view('classworks.edit', compact('classroom', 'type', 'assigned','classwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        //
        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));

        return back()
            ->with('success', 'Classwork updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        //
    }
}