<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Image,TemporaryFile};
use App\Repositories\ImageRepository;
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
       $data = Image::all();
        return view('Admin.home', compact('data'));
    }

    public function create()
    {
    // dd("here");
        $data = TemporaryFile::get()->last();
        return view('Admin.imageform' ,compact('data'));
    }

    public function store(Request $request)
    {
    //    dd($request);
        // return $request->all();
        // return $_FILES;
           $image =  $request['avtar'];

        //    return  (json_decode($image[0])[0]);
       
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'avtar'=>'required',
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }
       
        for ($i = 0; $i < count($request->avtar); $i++) {
            $answers[] = [
                'title' => $request->title,
                'image' => $request->avtar[$i],
                'status' => $request->status
            ];
            $ImageDetails = Image::insert($answers);
        }
       
            foreach($image as $avt){
                $imagename = json_decode($image[0])[0]->{'avtar'} ;
                $foldername = json_decode($image[0])[1]->{'folder'};
               $temporaryFile  =  TemporaryFile::where('filename',$imagename)->Where('folder',$foldername)->get(); 
            if($temporaryFile){
                $temporaryFolder = Session::get('folder');
                  $old_path = public_path("storage/avtars/tmp$temporaryFolder/$imagename");
                  $new_path = public_path('/images');
                 if (file_exists($old_path)){
                    $move = storage::move($old_path,$new_path);
                    dd('Copy File dont.');
                }
              
              }  
return "here";
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
           
        return redirect('/')->with('message', "Image Added Successfully");
    }

    public function deletefilepond_image(request $request)
    {   
        
      $temporaryFolder = Session::get('folder');
    //   $nameFile = Session::get('filename');
     $path = storage_path("public/avtars/tmp$temporaryFolder/{$request->filename}");
       if(file::exists($path)){
           unlink($path);
           TemporaryFile::where(['folder'=>$temporaryFolder,
                                  'filename'=> $request->filename    
            ])->delete();
            return "success";
       }else{
           return "notfound";
       }

       

         
    }

    public function filepond(request $request ){
        //  dd("filepond store");
        if($request->hasfile('avtar')){
            $files = $request->file('avtar');
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $folder = uniqid() . '_' . now()->timestamp; 
                Session::put('folder',$folder);
                Session::put('filename',$filename);
                $file->storeAs('public/avtars/tmp' . $folder,$filename);
               
                TemporaryFile::create([
                'folder' =>$folder,
                'filename' => $filename
               ]);
            }
           
           
        }
        return response()->json([['avtar' => $filename],['folder'=>$folder]]);

    }

    public function delete($id)
    {
        $image = Image::find($id);
        unlink(public_path('/images/' . $image['image']));
        $image->delete();
        return back()->with('message', 'SuccessFully Deleted');
    }
}