<?php

namespace App\Http\Controllers;

use App\Test;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;

class ClassroomsController extends Controller
{
    public function index(Request $request): Renderable
    {
        $classrooms = Classroom::orderBy('created_at', 'DESC')->get(); //return Collection of Classroom

        $success = session('success');// return value of success in the session
        //Session::reflash();


        return view('classrooms.index', compact('classrooms','success'));
    }

    public function create()
    {
        return view('classrooms.create');
    }
    // public function store(Request $request): RedirectResponse
    // {
    //     //echo $request->course;
    //     //dd( $request->all()); //var_dump بترجع جميع الحقول
    //     //dd( $request->only('name','section')); //var_dump بترجع الحقول الي انا بدي ايها وبمرر اسمائهم
    //     //dd( $request->except('name','section')); //var_dump بترجع جميع الحقول ما عدا الي بمررهم

    //     $classroom = new Classroom();
    //     $classroom->name = $request->post('name');
    //     $classroom->section = $request->post('section');
    //     $classroom->subject = $request->post('subject');
    //     $classroom->room = $request->post('room');
    //     $classroom->code = Str::random(8);
    //     $classroom->save(); //insert

    //     //PRG:Post Redirect Get

    //     if($request->hasFile('cover_image')){
    //         $file = $request->file('cover_image'); //uploadedFile

    //         $path = $file->store('/covers','uploads');
    //         $request->merge([
    //             'cover_image_path'  =>  $path
    //         ]);
    //     }
    //     return redirect()->route('classrooms.index')
    //     ->with('success','Classroom created');
    // }

    // public function show(classroom $classroom)
    // {
    //     //$classroom = classroom::where('id','=',$id)->first();
    //     //$classroom = Classroom::find($id);
    //     return view::make('classrooms.show')
    //         ->with([
    //             'classroom' => $classroom,
    //         ]);
    // }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->except('name', 'cover_image'));
        // dd($request->only('name', 'cover_image'));

        // Method 1
        // $classroom = new Classroom();

        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');
        // $classroom->code = Str::random(8);

        // $classroom->save();

        // Method 2: Mass assignment


        // $data = $request->all();
        // $data['code'] = Str::random(8);

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image'); //Uploaded File
            // $path = $file->storeAs('/covers', 'name.png', 'uploads');
            // config > fileSystems > edit public
            $path = $file->store('/covers', 'uploads');
            $request->merge([
                'cover_image_path' => $path,
            ]);
        }
        $request->merge([
            'code' => Str::random(8)
        ]);
        $classroom = Classroom::create($request->all());

        // Alternative for Mass assignment
        // $classroom = new Classroom($request->all());
        // $classroom->save();

        // $classroom = new Classroom();
        // $classroom->fill($request->all())->save();
        // $classroom->forceFill($request->all())->save();

        //PRG => Post Redirect Get

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom created');
    }

    public function edit(classroom $classroom)
    {
        //$classroom = Classroom::findOrFail($id);
        return view('classrooms.edit', [
            'classroom' => $classroom,
        ]);
    }

    public function update(Request $request, classroom $classroom)
    {

        // Method 1
        //$classroom = Classroom::findOrFail($id);

        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');

        // $classroom->save(); // update

        // Mass assignment
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image'); //Uploaded File
            // $path = $file->storeAs('/covers', 'name.png', 'uploads');
            // config > fileSystems > edit public
            $path = $file->store('/covers', 'uploads');
            $request->merge([
                'cover_image_path' => $path,
            ]);
        }
        $request->merge([
            'code' => Str::random(8)
        ]);
        $classroom->update($request->all());
        // $classroom->fill($request->all())->save();

        Session::put('sucess','classroom updated');
        return Redirect::route('classrooms.index');
        //->with('success','Classroom updated');
    }

    public function destroy($id)
    {
        // Classroom::where('id', '=', $id)->delete(); // Same Result
        $count = Classroom::destroy($id);

        // $classroom = Classroom::find($id);
        // $classroom->delete();

        //Flash Message
        return redirect(route('classrooms.index'))
    ->with('success','Classroom deleted');
    }
}
