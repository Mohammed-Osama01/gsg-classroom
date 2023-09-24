<?php

namespace App\Http\Controllers;

use App\Events\ClassworkUpdated;
use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\ClassworkCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Database\QueryException;

class ClassworkController extends Controller
{


    public function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_types = [
            classwork::TYPE_ASSIGNMENT,
            classwork::TYPE_MATERIAL,
            classwork::TYPE_QUESTION,
        ];

        if (!in_array($type, $allowed_types)) {
            $type = classwork::TYPE_ASSIGNMENT;
        };

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
        // $this->authorize('create',[Classwork::class,$classroom]);
        $type = $this->getType($request);
        $classwork = new Classwork();

        return view('classworks.create', compact('classroom', 'type','classwork' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        // dd($request);
        $type = $this->getType($request);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment' || $type == 'question'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);
        // dd($request->all());
        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
        ]);
        try {
            DB::transaction(function () use ($classroom, $request) {
                $classwork = $classroom->classworks()
                    ->create($request->all());
                $classwork->users()->attach($request->input('students'));
                // dd($request->all());
                // event(new ClassworkCreated($classwork));
                ClassworkCreated::dispatch($classwork);
            });
        } catch (\Exception $e) {
            // throw $e;
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('classrooms.classworks.index', $classroom->id)
            ->with('succes', __('classwork craeted successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        // dd($classwork->comments()->dd());
        // $classwork->load('commnets.user');
        return view('classworks.show', compact('classroom', 'classwork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $type = $this->getType($request);
        $assigned = $classwork->users()->pluck('id')->toArray();

        return view('classworks.edit', compact('classroom', 'type', 'assigned', 'classwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
            // $this->authorize('update', $classwork);
            $type = $classwork->type;

            $validate =  $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'topic_id' => ['nullable', 'int', 'exists:topics,id'],
                // 'student' => ['nullable'],
                'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment' || 'question'), 'numeric', 'min:0'],
                'options.due' => ['nullable', 'date', 'after:published_at'],
            ]);
            $classwork->update($request->all());

            // event(new ClassworkUpdated($classwork));
            ClassworkUpdated::dispatch($classwork);

            return View::make('classworks.show', compact('classroom', 'classwork'))
                ->with('success', __('Classwork Updated !'));
        }
        //
        // $classwork->update($request->all());
        // $classwork->users()->sync($request->input('students'));


        // return back()
        //     ->with('success', 'Classwork updated!');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        //
    }
}
