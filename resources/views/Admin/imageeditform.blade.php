<x-admin-layout>
    @section('content')
    <style>
        .image-area {
            position: relative;
            width: 20%;
            margin-right: 10px;
            background: #333;
        }
        .pdf-area {
            position: relative;
            width: 221PX;
            height: 146PX;
            margin-right: 10px;
            background-image: url(data:image/png;base64,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);
        }
        .pdf-area a {
            max-width: 100%;
            height: auto;
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

                                @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> {{ session()->get('error') }} </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @if (session()->has('message'))
                                <!-- Success Alert -->
                                <div class="alert alert-success alert-border-left alert-dismissible fade show" id="message" role="alert">
                                    <i class="ri-check-double-line me-3 align-middle"></i> <strong>{{ session()->get('message') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Edit Image</h5>
                                    <div>
                                        <a href="/"> <button class="btn btn-success">Image List</button></a>
                                    </div>
                                </div>

                                <!-- end card header -->
                                <div class="card-body">
                                    @foreach($image as $i)
                                    @php
                                    $iddata = $i->user_id;
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
                                                    <input type="file" id="fileuploads" name="avtar[]" require value="" accept="image/png, image/jpeg" data-rule-required="true" data-msg-required="Please Select Atleast One.." accept=".jpg, .jpeg, .png,.pdf" multiple class="form-control image" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label" for="input-status">Status of Image</label>
                                                <div class="form-group mb-3">
                                                    <input type="radio" name="status" value="1" placeholder="Status" id="input-status" checked="checked">
                                                    <label class="control-label" for="input-status">Active</label>
                                                    <input type="radio" name="status" value="0" placeholder="Status" id="input-status">
                                                    <label class="control-label" for="input-status">Inactive</label>
                                                </div>
                                            </div>
                                            @foreach($image as $i1)
                                            @foreach(json_decode($i1['image']) as $d1)
                                            @php
                                            $imagename = $d1->avtar ?? '';
                                            @endphp
                                            @php
                                            $extension = pathinfo(storage_path($imagename), PATHINFO_EXTENSION);
                                            // print_r($extension);
                                            @endphp
                                            @if($imagename)
                                            @if ($extension == 'png')
                                            <div class="image-area ">
                                                <img src="{{ URL::asset('/images/' . $imagename) }}" alt="{{ $imagename }}" />
                                                <a class="remove-image " id="bksv" data-id="{{$i1['id']}}" style="display: inline;" data-toggle="tooltip" data-placement="top" title="Remove Image"> &#215;</a>
                                            </div>
                                            @elseif($extension == 'jpg')
                                            <div class="image-area">
                                                <img src="{{ URL::asset('/images/' . $imagename) }}" alt="{{ $imagename }}" />
                                                <a class="remove-image " id="bksv" data-id="{{$i1['id']}}" style="display: inline;" data-toggle="tooltip" data-placement="top" title="Remove Image">&#215;</a>
                                            </div>
                                            @elseif($extension == 'jpeg')
                                            <div class="image-area">
                                                <img src="{{ URL::asset('/images/' . $imagename) }}" alt="{{ $imagename }}" />
                                                <a class="remove-image " id="bksv" data-id="{{$i1['id']}}" style="display: inline;" data-toggle="tooltip" data-placement="top" title="Remove Image">&#215;</a>
                                            </div>
                                            @else
                                            <div class="pdf-area">
                                                <a src="{{ URL::asset('/images/' . $imagename) }}" alt="{{ $imagename }}" ></a>
                                                <a class="remove-image " id="bksv" data-id="{{$i1['id']}}" style="display: inline;" data-toggle="tooltip" data-placement="top" title="Remove Pdf">&#215;</a>
                                            </div>
                                            @endif
                                            @endif
                                            @endforeach
                                            @endforeach
                                            <input type="hidden" value="{{$iddata}}" name="id">
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
            $(".remove-image").click(function(e) {
                let id = $(this).attr('data-id')
                var html = $(this).closest('.image-area');
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    $.ajax({
                        url: "/image-remove",
                        type: 'GET',
                        data: {
                            'id': id
                        },
                        success: function(data)  {
                            html.remove();
                            $('.alert-success').html(data[0]);
                        },
                        
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
                    // onload: (response) => { arrayUploadImage.push(response); $('#overlay').fadeIn(); $('.image').val(response); console.log(arrayUploadImage); tempImagePreview(arrayUploadImage);  },
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