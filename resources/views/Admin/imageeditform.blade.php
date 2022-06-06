<x-admin-layout>
    @section('content')
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
                                    </div>
                                @endif
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Create Employee</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <form enctype="multipart/form-data" action="{{route('admin.image.store')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="control-label" for="input-name">Title</label>
                                                      <input type="text" name="title" placeholder="Image Title" id="input-slug" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="control-label" for="input-name">Image</label>
                                                      <input type="file" name="image" accept=".jpg, .jpeg, .png" multiple class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <label class="control-label" for="input-status">Status of Image</label>
                                            <div class="form-group mb-3">
                                                <input type="radio" name="status" value="1" placeholder="Status" id="input-status">
                                                <label class="control-label" for="input-status">Active</label>
                                                <input type="radio" name="status" value="0" placeholder="Status" id="input-status">
                                                <label class="control-label" for="input-status">Inactive</label>
                                            </div>
                                        </div>
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
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
    @endsection
</x-admin_layout>