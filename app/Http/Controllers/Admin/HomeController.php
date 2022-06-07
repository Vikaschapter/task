<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Image,TemporaryFile};
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
       $data = Image::all();
        return view('admin.home', compact('data'));
    }

    public function create()
    {
        $data = TemporaryFile::get()->last();
        return view('admin.imageform' ,compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request);
        return $request->all();
        // return $_FILES;
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        $ImageDetails =  Image::create([
                            'title' => $request['title'],
                            'status' => $request['status'],
                        ]);
       $temporaryFile  =  TemporaryFile::where('folder',$request->avtar)->first(); 
       if($temporaryFile){
         $ImageDetails->addMedia(storage_path('app/avtars/tmp/'.$request->avtar .'/'.$temporaryFile->filename))->toMediaCollection('avatars');
           rmdir(storage_path('app/avtars/tmp/'.$request->avtar .'/'.$temporaryFile->filename));
           $temporaryFile->delete();
       }               

        // if ($files = $request->file('image')) {
        //     foreach ($files as $file) {
        //         $fileName = $file->getClientOriginalName();
        //         $allowedfileExtension = ['png', 'pdf', 'dox', 'jpg', 'jpeg'];
        //         $extension = $file->getClientOriginalExtension();
        //         $check = in_array($extension, $allowedfileExtension);
        //         if ($check) {
        //             $destinationPath = public_path() . '/images';
        //             $file->move($destinationPath, $fileName);

        //              $ImageDetails =  ([
        //                 'title' => $request['title'],
        //                 'status' => $request['status'],
        //             ]);

        //                return $temporaryFile  =  TemporaryFile::where('folder',$request->avtar)->first();

        //             $ImageDetails = addmedia(storage_path('app/avtars/tmp/'.$request->avtar .'/'.$filename))->toMediaCollection('avatars');
        //              $data = $this->imageRepository->createImage($ImageDetails);
        //         } else {
        //             return back()->with('error', ' Sorry Only Allow png,pdf,dox,jpg,jpeg!');
        //             // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
        //         }
        //     }
        // }
            return "complete";
        return redirect('/')->with('message', "Image Added Successfully");
    }

    public function deletefilepond_image(request $request, $id)
    {   
      $temporaryFolder = Session::get('folder');
      $nameFile = Session::get('filename');

      $path = storage_path() .'/app/avtars/tmp/'. $temporaryFolder.'/'. $nameFile;
      if(file::exists($path)){
            file::delete($path);
            rmdir(storage_path('app/avtars/tmp/'. $temporaryFolder));
            TemporaryFile::where(['folder'=>$temporaryFolder,
                                  'image'=> $nameFile     
            ])->delete();
            return "success";
      }else{
          return 'not found';
      }

         
    }

    public function filepond(request $request ){
      
        if($request->hasfile('avtar')){
            $file = $request->file('avtar');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '_' . now()->timestamp; 
            Session::put('folder',$folder);
            Session::put('filename',$filename);
            $file->storeAs('avtars/tmp' . $folder,$filename);
           
            TemporaryFile::create([
            'folder' =>$folder,
            'filename' => $filename
           ]);
           
        }
        return response()->json(['avtar' => $filename]);

    }

    public function delete($id)
    {
        $image = Image::find($id);
        unlink(public_path('/images/' . $image['image']));
        $image->delete();
        return back()->with('message', 'SuccessFully Deleted');
    }
}
