<?php

namespace App\Http\Controllers;

use App\Test;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;

class ClassroomsController extends Controller
{
    public function index(Request $request): Renderable
    {
        $classrooms = Classroom::status('archived')
        ->recent()
        ->orderBy('created_at', 'DESC')
        ->get(); //return Collection of Classroom
        // $classrooms = DB::table('classrooms')
        // ->whereNull('delete-at')
        // ->orderBy('created_at', 'DESC')->get();

        $success = session('success'); // return value of success in the session
        //Session::reflash();


        return view('classrooms.index', compact('classrooms', 'success'));
    }

    public function create()
    {
        return view('classrooms.create', [
            'classroom' => new Classroom()
        ]);
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

    public function show(classroom $classroom)
    {
        //$classroom = classroom::where('id','=',$id)->first();
        //$classroom = Classroom::find($id);
        return view::make('classrooms.show')
            ->with([
                'classroom' => $classroom,
            ]);
    }

    public function store(ClassroomRequest $request): RedirectResponse
    {

        // Validation
         



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

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image'); //Uploaded File
            // $path = $file->storeAs('/covers', 'name.png', 'uploads');
            // config > fileSystems > edit public
            $path = $file->store('/covers', 'public');
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

    public function update(ClassroomRequest $request, $id)
    {

        $validated = $request->validated();
        // Method 1
        $classroom = Classroom::findOrFail($id);

        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');

        // $classroom->save(); // update


        if ($request->hasFile('cover_image')) {
            // Solution 1 for updating image
            $file = $request->file('cover_image');
            $name = $classroom->cover_image_path ?? (Str::random(40) . '.' . $file->getClientOriginalExtension());
            $path = $file->storeAs('/covers', basename($name), [
                'disk' => Classroom::$disk
            ]);


            $validated['cover_image_path'] = $path;


            // Solution 2 for updating image

            // $path = Classroom::uploadCoverImage($file);
            // $request->merge([
            //     'cover_image_path' => $path
            // ]);
        }
        // Continue Solution 2
        // $old = $classroom->cover_image_path;

        // $img = $classroom->cover_image_path;

        // if($request->hasFile('cover_image')){

        //     $imagePath = public_path('storage/'. $img);
        //     if(File::exists($imagePath)){
        //         File::delete($imagePath);
        //     }

        //     $file = $request->file('cover_image'); //Uploaded File
        //     $img = $file->store('/covers', 'public');
        //     $request->merge([
        //         'cover_image_path' => $img,
        //     ]);
        // }
        // Mass assignment
        $classroom->update($validated);
        // $classroom->fill($request->all())->save();

        // Continue Solution 2
        // if ($old && $$old != $classroom->cover_image_path) {
        //     Classroom::deleteCoverImage($old);
        // }


        // Same result (->with('success', 'Classroom updated'))
        Session::flash('success', 'Classroom updated');
        Session::flash('error', 'Test for error message!');

        return Redirect::route('classrooms.index');
        // ->with('success', 'Classroom updated');
        // ->with('error', 'Classroom updated');
    }

    public function destroy(Classroom $classroom)
    {
        // Solution 1 for deleting image
        // $classroom = Classroom::find($id);
        // $imagePath = public_path('storage/' . $classroom->cover_image_path);
        // if (File::exists($imagePath)) {
        //     File::delete($imagePath);
        // }

        // Classroom::where('id', '=', $id)->delete(); // Same Result
        $classroom->delete();
        // Solution 2 for deleting image
        //if (File::exists(storage_path('app/public/' . $classroom->cover_image_path))) {

            // unlink(storage_path('app/public/' . $classroom->cover_image_path));
            //Classroom::deleteCoverImage($classroom->cover_image_path);
        //}
        // $count = Classroom::destroy($classroom->id);


        return redirect(route('classrooms.index'))->with('success', 'Classroom deleted');
    }

    public function trashed()
{
    $classrooms = Classroom::onlyTrashed()
    ->latest('deleted_at')
    ->get();

    return view('classrooms.trashed',compact('classrooms'));

}

public function restore($id){
    $classroom = Classroom::onlyTrashed()->findOrFail($id);
    $classroom->restore();

    return redirect()
    ->route('classrooms.index')
    ->with('success',"Classroom({$classroom->name}) restored");
}

public function forceDelete($id){
    $classroom = Classroom::onlyTrashed()->findOrFail($id);
    $classroom->forceDelete();
    Classroom::deleteCoverImage($classroom->cover_image_path);

    return redirect()
    ->route('classrooms.trashed')
    ->with('success',"Classroom({$classroom->name}) deleted forever!");
}
}
