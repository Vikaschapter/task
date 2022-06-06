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

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Image Info</h4>
                                <a href="{{route('admin.image.create')}}"><button class="btn btn-warning ">Create Image</button></a>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="table-responsive table-card">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col" style="width: 150px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($data as $d)
                                                <tr>
                                                <td>{{$d['id']}}</td>
                                                <td>{{$d['title']}}</td>
                                                <td>
                                                    @php
                                                     $extension = pathinfo(storage_path($d['image']), PATHINFO_EXTENSION);
                                                    // print_r($extension);
                                                     @endphp
                                                     @if ($extension == 'png')
                                                       <a href="{{URL::asset('/images/'.$d['image'])}}"> <img src="{{URL::asset('/images/'.$d['image'])}}" alt="{{$d['image']}}" height="40px" width="70px" class="img-fluid d-block" data-min="2" data-toggle="tooltip" data-placement="top" title="View Image"/>
                                                       </a> 
                                                       @elseif($extension == 'jpg')
                                                       <a href="{{URL::asset('/images/'.$d['image'])}}"><img src="{{URL::asset('/images/'.$d['image'])}}" alt="{{$d['image']}}" height="40px" width="70px" class="img-fluid d-block" data-toggle="tooltip" data-placement="top" title="View Image" />
                                                       </a>
                                                       @else
                                                       <a href="{{URL::asset('/images/'.$d['image'])}}" data-toggle="tooltip" data-placement="top" title="View Pdf">  <i class="bx bxs-file-pdf" style="font-size:30px"></i></a>
                                                       @endif                                                       
                                               </td>
                                                
                                               <td>
                                                    
                                                    <form action="{{route('admin.image.delete',$d->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit"><a>Delete</a></button>
                                                    </form>
                                                </td>     
                                                </tr>
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
    @endsection
</x-admin-layout>
