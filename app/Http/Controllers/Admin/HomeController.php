<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Image, TemporaryFile};
use App\Repositories\ImageRepository;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use RahulHaque\Filepond\Facades\Filepond;


class HomeController extends Controller
{
    private $userRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function index()
    {
        $data = Image::orderBy('user_id')->get()->groupBy('user_id');
        //  foreach($data as $d){
        //     foreach($d as $d1){
        //         // dd($d1['image']);
        //     } 
        //  }
        return view('Admin.home', compact('data'));
    }

    public function create()
    {
        $data = TemporaryFile::get()->last();
        return view('Admin.imageform', compact('data'));
    }

    public function store(Request $request)
    {

        $image =  $request['avtar'];
        $imagedata = Image::get()->unique('user_id')->count();
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'avtar' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        for ($i = 0; $i < count($request->avtar); $i++) {
            $answers = [
                'title' => $request->title,
                'image' => $request->avtar[$i],
                'status' => $request->status,
                'user_id' => $imagedata + 1
            ];
             Image::insert($answers);
        }
        foreach ($image as $avt) {
            $imagename = json_decode($image[0])[0]->{'avtar'};
            $foldername = json_decode($image[0])[1]->{'folder'};
            $temporaryFile  =  TemporaryFile::where('filename', $imagename)->Where('folder', $foldername);

            if ($temporaryFile) {
                $temporaryFolder = Session::get('folder');
                $old_path = storage_path("app/public/avtars/tmp$temporaryFolder/$imagename");
                //    = public_path("app/public/storage/avtars/tmp$temporaryFolder/$imagename");
                $new_path = public_path("/images/$imagename");
                if (file_exists($old_path)) {
                    $move = file::move($old_path, $new_path);

                    File::deleteDirectory(public_path("storage/avtars/tmp$temporaryFolder"));
                }
                $temporaryFile->delete();
            }
        }
        return redirect('/')->with('message', "Image Added Successfully");
    }

    public function deletefilepond_image(request $request)
    {

        $temporaryFolder = Session::get('folder');
        //   $nameFile = Session::get('filename');
        $path = storage_path("app/public/avtars/tmp$temporaryFolder/{$request->filename}");
        if (file::exists($path)) {

            unlink($path);
            TemporaryFile::where([
                'folder' => $temporaryFolder,
                'filename' => $request->filename
            ])->delete();
            return "success";
        } else {
            return "notfound";
        }
    }

    public function filepond(request $request)
    {
        //  dd("filepond store");
        if ($request->hasfile('avtar')) {
            $files = $request->file('avtar');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $folder = uniqid() . '_' . now()->timestamp;
                Session::put('folder', $folder);
                Session::put('filename', $filename);
                $file->storeAs('public/avtars/tmp' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename
                ]);
            }
        }
        return response()->json([['avtar' => $filename], ['folder' => $folder]]);
    }

    public function delete($id)
    {

        $image = Image::where('user_id', $id);
        $imagedelete = $image->get();
        for ($i = 0; $i < count($imagedelete); $i++) {
            $dat =  json_decode($imagedelete[$i]->image)[0]->avtar;
            File::deleteDirectory(public_path('/images/' . $dat));
        }
        $image->delete();
        return back()->with('message', 'SuccessFully Deleted');
    }

    public function edit($id)
    {
        $image = Image::where('user_id', $id)->get();
        //   $image = Image::find($id);
        return view('Admin.imageeditform', compact('image'));
    }

    public function removeimage(Request $Request)
    {
        $image = Image::find($Request->id);
        $image->delete();
        return response()->json(["Image Deleted Succesfull"]);
    }

    public function status($id)
    { 
      $status =  Image::where('user_id',$id)->first()->status;
        $status = $status ? '0' : '1';
        Image::where('user_id',$id)->update([ 'status' => $status ]);
        return back()->with('message', " Status Updated Successfully");
    }

    public function update(request $request, $id)
    {
        //   return $request->all();
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }
        $imageupdate = Image::where('user_id', $request->id)->first();
        if ($request->avtar) {
            for ($i = 0; $i < count($request->avtar); $i++) {
                $answers = [
                    'title' => $request->title,
                    'image' => $request->avtar[$i],
                    'status' => $request->status,
                    'user_id' => $request->id
                ];
                Image::insert($answers);
            }
            $image =  $request['avtar'];
            foreach ($image as $avt) {
                $imagename = json_decode($image[0])[0]->{'avtar'};
                $foldername = json_decode($image[0])[1]->{'folder'};
                $temporaryFile  =  TemporaryFile::where('filename', $imagename)->Where('folder', $foldername);

                if ($temporaryFile) {
                    $temporaryFolder = Session::get('folder');
                    $old_path = storage_path("app/public/avtars/tmp$temporaryFolder/$imagename");
                    //    = public_path("app/public/storage/avtars/tmp$temporaryFolder/$imagename");
                    $new_path = public_path("/images/$imagename");
                    if (file_exists($old_path)) {
                        $move = file::move($old_path, $new_path);

                        File::deleteDirectory(public_path("storage/avtars/tmp$temporaryFolder"));
                    }
                    $temporaryFile->delete();
                }
            }
        }

        $dataimage = Image::where('user_id', $request->id)->first();
        $dataimages = [
            'status' => $request->status,
            'title' => $request->title
        ];
        $dataimage->update($dataimages);


        return redirect('/')->with('message', "Update Success Full");
    }
}
