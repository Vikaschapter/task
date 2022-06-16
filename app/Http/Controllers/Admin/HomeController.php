<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\
{
    Image, TemporaryFile
};
use App\Repositories\ImageRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    # pattern  Repository
    private $userRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    # Admin Home Page
    public function index()
    {
        try
        {
            $data = Image::orderBy('user_id')->get()
                ->groupBy('user_id');
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
        return view('Admin.home', compact('data'));
    }
    #image form
    public function create()
    {
        try
        {
            $data = TemporaryFile::get()->last();
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
        return view('Admin.imageform', compact('data'));
    }
    #image form Store
    public function store(Request $request)
    {
        try
        {
            $image = $request['avtar'];
            $imagedata = Image::get()->unique('user_id')
                ->count();
            $validation = Validator::make($request->all() , ['title' => 'required|string', 'avtar' => 'required', 'status' => 'required|boolean', ], ['avtar.required' => 'Please Select Atleast One Image.']);

            if ($validation->fails())
            {
                return back()
                    ->withInput()
                    ->withErrors($validation->errors());
            }

            for ($i = 0;$i < count($request->avtar);$i++)
            {
                $answers = ['title' => $request->title, 'image' => $request->avtar[$i], 'status' => $request->status, 'user_id' => $imagedata + 1];
                Image::insert($answers);
            }
            foreach ($image as $avt)
            {
                $imagename = json_decode($image[0]) [0]->{'avtar'};
                $foldername = json_decode($image[0]) [1]->{'folder'};
                $temporaryFile = TemporaryFile::where('filename', $imagename)->Where('folder', $foldername);

                if ($temporaryFile)
                {
                    $temporaryFolder = Session::get('folder');
                    $old_path = storage_path("app/public/avtars/tmp$temporaryFolder/$imagename");
                    //    = public_path("app/public/storage/avtars/tmp$temporaryFolder/$imagename");
                    $new_path = public_path("/images/$imagename");
                    if (file_exists($old_path))
                    {
                        $move = file::move($old_path, $new_path);

                        File::deleteDirectory(public_path("storage/avtars/tmp$temporaryFolder"));
                    }
                    $temporaryFile->delete();
                }
            }
            return redirect('/')
                ->with('message', "Image Added Successfully");
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #filepond Image Delete
    public function deletefilepond_image(request $request)
    {
        try
        {
            $temporaryFolder = Session::get('folder');
            $path = storage_path("app/public/avtars/tmp$temporaryFolder/{$request->filename}");
            if (file::exists($path))
            {
                unlink($path);
                TemporaryFile::where(['folder' => $temporaryFolder, 'filename' => $request
                    ->filename])
                    ->delete();
                return "success";
            }
            else
            {
                return "notfound";
            }
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    # Image store
    public function filepond(request $request)
    {
        try
        {
            if ($request->hasfile('avtar'))
            {
                $files = $request->file('avtar');
                foreach ($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $folder = uniqid() . '_' . now()->timestamp;
                    Session::put('folder', $folder);
                    Session::put('filename', $filename);
                    $file->storeAs('public/avtars/tmp' . $folder, $filename);

                    TemporaryFile::create(['folder' => $folder, 'filename' => $filename]);
                }
            }
            return response()->json([['avtar' => $filename], ['folder' => $folder]]);
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #Delete Image
    public function delete($id)
    {
        try
        {
            $image = Image::where('user_id', $id);
            $imagedelete = $image->get();
            for ($i = 0;$i < count($imagedelete);$i++)
            {
                $dat = json_decode($imagedelete[$i]->image) [0]->avtar;
                File::deleteDirectory(public_path('/images/' . $dat));
            }
            $image->delete();
            return back()
                ->with('message', 'SuccessFully Deleted');
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #Edit Form
    public function edit($id)
    {
        try
        {
            $image = Image::where('user_id', $id)->get();
            return view('Admin.imageeditform', compact('image'));
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }

    # Edit store
    public function update(request $request, $id)
    {
        try
        {

            $validation = Validator::make($request->all() , ['title' => 'required|string',

            'status' => 'required|boolean', ]);

            if ($validation->fails())
            {
                return back()
                    ->withErrors($validation->errors());
            }
            $imageupdate = Image::where('user_id', $request->id)
                ->first();
            if ($request->avtar)
            {
                for ($i = 0;$i < count($request->avtar);$i++)
                {
                    $answers = ['title' => $request->title, 'image' => $request->avtar[$i], 'status' => $request->status, 'user_id' => $request->id];
                    Image::insert($answers);
                }
                $image = $request['avtar'];
                foreach ($image as $avt)
                {
                    $imagename = json_decode($image[0]) [0]->{'avtar'};
                    $foldername = json_decode($image[0]) [1]->{'folder'};
                    $temporaryFile = TemporaryFile::where('filename', $imagename)->Where('folder', $foldername);

                    if ($temporaryFile)
                    {
                        $temporaryFolder = Session::get('folder');
                        $old_path = storage_path("app/public/avtars/tmp$temporaryFolder/$imagename");
                        //    = public_path("app/public/storage/avtars/tmp$temporaryFolder/$imagename");
                        $new_path = public_path("/images/$imagename");
                        if (file_exists($old_path))
                        {
                            $move = file::move($old_path, $new_path);

                            File::deleteDirectory(public_path("storage/avtars/tmp$temporaryFolder"));
                        }
                        $temporaryFile->delete();
                    }
                }
            }

            $dataimage = Image::where('user_id', $request->id)
                ->first();
            $dataimages = ['status' => $request->status, 'title' => $request->title];
            $dataimage->update($dataimages);

            return redirect('/')->with('message', "Update Success Full");
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #  Remove Image from Edit Image
    public function removeimage(Request $Request)
    {
        try
        {
            $image = Image::find($Request->id);
            $image->delete();
            return response()
                ->json(["Image Deleted Succesfull"]);
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    # Delete All From Multi Delete
    public function delete_all(Request $request)
    {
        try
        {
            $ids = $request->ids;
            Image::whereIn('user_id', explode(",", $ids))->delete();
            return response()
                ->json(['status' => true, 'message' => "Users deleted successfully."]);
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #Select all status activate
    public function status_activate(Request $request)
    {
        try
        {
            $ids = $request->ids;
            $status = Image::whereIn('user_id', explode(",", $ids));
            $statuss = $status ? '1' : '0';
            $status->update(['status' => $statuss]);
            return response()->json(['status' => true, 'message' => "Image Activate successfully."]);
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
    #Select all status inactivate
    public function status_inactivate(Request $request)
    {
        try
        {
            $ids = $request->ids;
            $status = Image::whereIn('user_id', explode(",", $ids));
            $statuss = $status ? '0' : '1';
            $status->update(['status' => $statuss]);
            return response()->json(['status' => true, 'message' => "Image Inactivate successfully."]);
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }

    #   status from single id
    public function status($id)
    {
        try
        {
            $status = Image::where('user_id', $id)->first()->status;
            $status = $status ? '0' : '1';
            Image::where('user_id', $id)->update(['status' => $status]);
            return back()->with('message', " Status Updated Successfully");
        }
        catch(Exception $exception)
        {
            return view('errors.404');
        }
    }
}

