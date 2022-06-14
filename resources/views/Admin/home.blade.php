<x-admin-layout>
    @section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Image</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Image</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            @if (session()->has('error'))

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> {{ session()->get('error') }} </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session()->has('message'))
            <!-- Success Alert -->
            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                <i class="ri-check-double-line me-3 align-middle"></i> <strong>{{ session()->get('message') }}</strong>
                <button type="button" class="btn-close" id="mybutton" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Image Info</h4>
                            <a href="{{route('admin.image.create')}}"><button class="btn btn-success ">Create Image</button></a>
                            
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <!-- <th scope="col"><input type="checkbox"></th> -->
                                                <th scope="col">ID</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" style="width: 150px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($data as $d)
                                            @foreach($d as $d1)
                                            <tr>
                                                <!-- <td><input type="checkbox" class="someid_1" value="{{$d1['user_id']}}" /></td> -->
                                                <td>{{$d1['user_id']}}</td>
                                                <td>{{$d1['title']}}</td>

                                                <td style="display: flex;">
                                                    @foreach($d as $image1)
                                                    <?php
                                                    $image =  $image1['image'];
                                                    $imageget = json_decode($image)[0]->{'avtar'} ?? '';
                                                    // print_r (json_decode(json_encode($d['image'])));
                                                    ?>
                                                    @php
                                                    $extension = pathinfo(storage_path($imageget), PATHINFO_EXTENSION);
                                                    // print_r($extension);
                                                    @endphp
                                                    @if ($extension == 'png')
                                                    <a href="{{URL::asset('/images/'.$imageget)}}"> <img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-min="2" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @elseif($extension == 'jpg')
                                                    <a href="{{URL::asset('/images/'.$imageget)}}"><img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @elseif($extension == 'jpeg')
                                                    <a href="{{URL::asset('/images/'.$imageget)}}"><img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @else
                                                    <a href="{{URL::asset('/images/'.$imageget)}}" data-toggle="tooltip" data-placement="top" title="View Pdf"> <i class="bx bxs-file-pdf" style="font-size:30px"></i></a>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($d1['status'] == '1')
                                                    <form action="{{ route('admin.image.status', $d1->user_id) }}" method="POST">
                                                        @csrf
                                                        @method('post')
                                                        <button class="btn btn-success" type="submit"><a>Active</a></button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('admin.image.status', $d1->user_id) }}" method="POST">
                                                        @csrf
                                                        @method('post')
                                                        <button class="btn btn-danger" type="submit"><a>Inactivate</a></button>
                                                    </form>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.image.edit',$d1->user_id)}}"><button class="btn btn-success" href="" type="submit">Edit</button></a>
                                                    <form action="{{route('admin.image.delete',$d1->user_id)}}" method="POST" style="display: inline-block">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit"><a>Delete</a></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @break
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>

    <script>
      
        const myTimeout = setTimeout(myGreeting, 5000);

        function myGreeting() {
            $("#mybutton").trigger("click");
        }
    </script>
    @endsection
</x-admin-layout>