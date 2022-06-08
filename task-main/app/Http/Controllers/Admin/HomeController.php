<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    private $userRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function index()
    {
       $data = $this->imageRepository->getAllImage();
        return view('Admin.home', compact('data'));
    }

    public function create()
    {
        return view('Admin.imageform');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        if ($files = $request->file('image')) {
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $allowedfileExtension = ['png', 'pdf', 'dox', 'jpg', 'jpeg'];
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $destinationPath = public_path() . '/images';
                    $file->move($destinationPath, $fileName);

                     $ImageDetails =  ([
                        'title' => $request['title'],
                        'image' => $fileName,
                        'status' => $request['status'],
                    ]);
                     $data = $this->imageRepository->createImage($ImageDetails);
                } else {
                    return back()->with('error', ' Sorry Only Allow png,pdf,dox,jpg,jpeg!');
                    // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                }
            }
        }

        return redirect('/')->with('message', "Image Added Successfully");
    }

    public function delete($id)
    {
        $image = Image::find($id);
        unlink(public_path('/images/' . $image['image']));
        $image->delete();
        return back()->with('message', 'SuccessFully Deleted');
    }
}
