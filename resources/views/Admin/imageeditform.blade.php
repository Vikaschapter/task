<x-admin-layout>
    @section('content')
    <style>
        .image-area {
            position: relative;
            width: 17%;
            background: #333;
        }

        .image-area img {
            max-width: 100%;
            height: auto;
        }

        .remove-image {
            display: none;
            position: absolute;
            top: -10px;
            right: -10px;
            border-radius: 10em;
            padding: 2px 6px 3px;
            text-decoration: none;
            font: 700 21px/20px sans-serif;
            background: #555;
            border: 3px solid #fff;
            color: #FFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            -webkit-transition: background 0.5s;
            transition: background 0.5s;
        }

        .remove-image:hover {
            background: #E54E4E;
            padding: 3px 7px 5px;
            top: -11px;
            right: -11px;
        }

        .remove-image:active {
            background: #E54E4E;
            top: -10px;
            right: -11px;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Records</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Create Employee</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <!-- end page title -->
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                   
                                    @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                    @endif
                                </div>
                                @endif
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Create Employee</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    @foreach($image as $i)
                                    @php
                                    $iddata =  $i->user_id;
                                    @endphp   
                                    <!-- $imageget =  {{$d1->{'avtar'} ?? '' }} -->

                                    <form enctype="multipart/form-data" action="{{route('admin.image.update',['id' => $iddata])}}" method="POST" id="validate-me-plz"> 
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="control-label" for="input-name">Title</label>
                                                    <input type="text" name="title" value="{{$i->title}}" id="name" placeholder="Image Title" class="form-control" data-rule-required="true" data-rule-minlength="2" data-msg-required="Please enter Title.">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="control-label" for="input-name">Image</label>
                                                    <input type="file" id="fileuploads" name="avtar[]" require value="" data-rule-required="true" data-msg-required="Please Select Atleast One.." accept=".jpg, .jpeg, .png,.pdf" multiple class="form-control image" />
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <label class="control-label" for="input-status">Status of Image</label>
                                                <div class="form-group mb-3">
                                                    <input type="radio" name="status" value="1" placeholder="Status" id="input-status" checked="checked"> 
                                                    <label class="control-label"  for="input-status">Active</label>
                                                    <input type="radio" name="status" value="0" placeholder="Status" id="input-status">
                                                    <label class="control-label" for="input-status">Inactive</label>
                                                </div>
                                            </div>
                                            @foreach($image as $i1)
                                            @foreach(json_decode($i1['image']) as $d1)
                                            @php
                                            $imagename = $d1->avtar ?? '';
                                            @endphp
                                            @if($imagename)
                                            <div class="image-area">
                                                <img src="{{ URL::asset('/images/' . $imagename) }}" alt="{{ $imagename }}"  />
                                                <a class="remove-image " id="bksv" data-id="{{$i1['id']}}" style="display: inline;">&#215;</a>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            <input type="hidden" value="{{$iddata}}" name = "id">
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                    @break
                                    @endforeach
                                </div>
                                <!-- end card body -->
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end col -->
            </div>
        </div> <!-- container-fluid -->
    </div>
    <script>
   
   $(document).ready(function() {
            $("#bksv").click(function(e) {
                let id = $(this).attr('data-id')
                $.ajax({
                    url: "/image-remove",
                    type: 'GET',
                    data: {
                        'id': id
                    },
                    success:function(response){
                        console.log(response);
                    }
                })
            });
        });
   
    </script>




    <script>
        FilePond.registerPlugin(

            // encodes the file as base64 data
            FilePondPluginFileEncode,

            // validates the size of the file
            FilePondPluginFileValidateSize,

            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,

            // previews dropped images
            FilePondPluginImagePreview,
        );

        // Select the file input and use create() to turn it into a pond
        const pondElement = document.querySelector('input[name="avtar[]"]');
        const pond = FilePond.create(pondElement);

        FilePond.setOptions({
            server: {
                url: "{!! route('admin.image.upload') !!}",
                process: {
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                    }
                },
                onload: (response) => {
                    console.log(response);
                    $('.fileuploads').val(JSON.stringify(arrayUploadImage));
                    arrayUploadImage.push(response);
                    console.log(arrayUploadImage);
                    tempImagePreview(arrayUploadImage);
                    //         //     // onload: (response) => { arrayUploadImage.push(response); $('#overlay').fadeIn(); $('.image').val(response); console.log(arrayUploadImage); tempImagePreview(arrayUploadImage);  },
                },

            }

        });
        const filepond_root = document.querySelector('.filepond--root');
        filepond_root.addEventListener('FilePond:processfilerevert', e => {
            $.ajax({
                url: "{!! route('admin.image.delete.filepond') !!}",
                type: 'POST',
                data: {
                    '_token': '{!! csrf_token() !!}',
                    'filename': e.detail.file.filename
                }
            })

        });
    </script>



    <script>
        $('#validate-me-plz').validate({
            ignore: [],
            onfocusout: function(element) {
                this.element(element);
            },
            errorClass: 'error_validate',
            errorElement: 'lable',
            // highlight: function(element, errorClass) {
            // $(element).removeClass(errorClass);
            // }
        });
    </script>

    <!-- store image in session -->
    <script>
        document.querySelector("#myFileInput").addEventListener("change", function() {
            // console.log(this.files)
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                localStorage.setItem("recent-image", reader.result);
            });
            reader.readAsDataURL(this.files[0]);
        });
        document.addEventListener("DOMContentLoaded", () => {
            const recentImageDataUrl = localStorage.getItem("recent-image");
            if (recentImageDataUrl) {
                document.querySelector("#ImagePreview").setAttribute("src", recentImageDataUrl);
            }
        });
        document.addEventListener("DOMContentLoaded", () => {
            const recentImageDataUrl = localStorage.removeItem("recent-image");
            if (recentImageDataUrl) {
                document.querySelector("#ImageRemove").setAttribute("src", recentImageDataUrl);

            }
        })
    </script>
    @endsection
    </x-admin_layout>