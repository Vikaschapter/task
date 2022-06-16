<x-admin-layout>
    @section('content')
    <div class="page-content">
        <div class="container-fluid">
    <style>
        	.success{
                background: green;
            }
    </style>
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
                            <!-- <a style="margin: 5px;" class="btn btn-outline-danger delete-all" data-url="">Delete All</a>  -->
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light" >
                                            <tr>
                                                <th scope="col">
                                                <div class="input-group">
                                                   
                                                        <button class="btn btn-success  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                                        <ul class="dropdown-menu dropdown-menu-end" >
                                                            <li>   <a  class="dropdown-item delete-all" href data-id="">Delete All</a></li>
                                                            <li>   <a  class="dropdown-item activate-all" href value="1">Activate All</a></li>
                                                            <li>   <a  class="dropdown-item inactivate-all" href value="0">Inactivate All</a></li>
                                                        </ul>
                                                        <input type="checkbox" id="check_all" style="margin-left: 20px;"/> 
                                                    </div>        
                                            </th>
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
                                            <tr style="text-align: center;">
                                                <td><input type="checkbox" class="checkbox" id="checkbox" value="{{$d1['user_id']}}" data-id="{{$d1['user_id']}}"/></td>
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
                                                    <a href="{{URL::asset('/images/'.$imageget)}}" target="_blank"> <img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-min="2" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @elseif($extension == 'jpg')
                                                    <a href="{{URL::asset('/images/'.$imageget)}}" target="_blank"><img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @elseif($extension == 'jpeg')
                                                    <a href="{{URL::asset('/images/'.$imageget)}}" target="_blank"><img src="{{URL::asset('/images/'.$imageget)}}" alt="{{$imageget}}" height="40px" width="70px" class="img-fluid d-block" data-toggle="tooltip" data-placement="top" title="View Image" style="margin-right: 10px;" />
                                                    </a>
                                                    @else
                                                    <a href="{{URL::asset('/images/'.$imageget)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Pdf"> <i class="bx bxs-file-pdf" style="font-size:30px"></i></a>
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
    <script type="text/javascript">
                $(document).ready(function() {
                    // console.log( "ready!" );
                    $('#check_all').on('click', function(e) {
                        if ($(this).is(':checked', true)) {
                            $(".checkbox").prop('checked', true);
                        } else {
                            $(".checkbox").prop('checked', false);
                        }
                    });

                    $('.checkbox').on('click', function() {
                        if ($('.checkbox:checked').length == $('.checkbox').length) {
                            $('#check_all').prop('checked', true);
                        } else {
                            $('#check_all').prop('checked', false);
                        }
                    });
                    $('.delete-all').on('click', function(e) {
                        var idsArr = [];
                        $(".checkbox:checked").each(function() {
                            idsArr.push($(this).attr('data-id'));
                            
                        });
                        if (idsArr.length <= 0) {
                            alert("Please select atleast one record to delete.");
                        } else {
                            if (confirm("Are you sure, you want to delete the selected Image?")) {
                                var strIds = idsArr.join(",");
                                $.ajax({
                                    url: "{{route('admin.image.delete.all')}}",
                                    type: 'GET',
                                    headers: {
                                        '_token': '{!! csrf_token() !!}',
                                    },
                                    data: 'ids=' + strIds,
                                    success: function(data) {
                                        if (data['status'] == true) {
                                            $(".checkbox:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            // alert(data['message']);
                                            toastr.options.timeOut = 15000; // 1.5s
                                            toastr.error('Image Deleted  successfully!');
                                        } else {
                                            alert('Whoops Something went wrong!!');
                                        }
                                    },
                                    error: function(data) {
                                        alert(data.responseText);
                                    }
                                });
                            }
                        }
                    });
                    $('.activate-all').on('click', function(e) {
                        var idsArr = [];
                        $(".checkbox:checked").each(function() {
                            // alert($(this).attr('value'));
                            idsArr.push($(this).attr('data-id'));
                        });
                        if (idsArr.length <= 0) {
                            alert("Please select atleast one record to activate.");
                        } else {
                            if (confirm("Are you sure, you want to activate the selected Image?")) {
                                var strIds = idsArr.join(",");
                                $.ajax({
                                    url: "{{route('admin.image.status.activate')}}",
                                    type: 'GET',
                                    headers: {
                                        '_token': '{!! csrf_token() !!}',
                                    },
                                    data: 'ids=' + strIds,
                                    success: function(data) {
                                        if (data['status'] == true) {
                                            $(".checkbox:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            alert(data['message']);
                                            toastr.options.timeOut = 15000; // 1.5s
                                            toastr.success('Image Activated successfully!');
                                        } else {
                                            alert('Whoops Something went wrong!!');
                                        }
                                    },
                                    error: function(data) {
                                        alert(data.responseText);
                                    }
                                });
                            }
                        }
                    });
                    $('.inactivate-all').on('click', function(e) {
                        var idsArr = [];
                        $(".checkbox:checked").each(function() {
                            // alert($(this).attr('value'))
                            idsArr.push($(this).attr('data-id'));
                        });
                        if (idsArr.length <= 0) {
                            alert("Please select atleast one record to Inactivate.");
                        } else {
                            if (confirm("Are you sure, you want to Inactivate the selected Image?")) {
                                var strIds = idsArr.join(",");
                                $.ajax({
                                    url: "{{route('admin.image.status.inactivate')}}",
                                    type: 'GET',
                                    headers: {
                                        '_token': '{!! csrf_token() !!}',
                                    },
                                    data: 'ids=' + strIds,
                                    success: function(data) {
                                        if (data['status'] == true) {
                                            $(".checkbox:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            alert(data['message']);
                                            toastr.options.timeOut = 15000; // 1.5s
                                            toastr.success('Image Inactivated successfully!');
                                        } else {
                                            alert('Whoops Something went wrong!!');
                                        }
                                    },
                                    error: function(data) {
                                        alert(data.responseText);
                                    }
                                });
                            }
                        }
                    });

                    $('[data-toggle=confirmation]').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        onConfirm: function(event, element) {
                            element.closest('form').submit();
                        }
                    });
                });
            </script>
<script type="text/javascript">
	// Default Configuration
		$(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '100000',
				'hideDuration': '100000',
				'timeOut': '500000',
				'extendedTimeOut': '100000',

				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		});
</script>

    <script>
       const myTimeout = setTimeout(myGreeting, 5000);
         function myGreeting() {
            $("#mybutton").trigger("click");
        }
    </script>
    @endsection
</x-admin-layout>