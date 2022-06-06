<x-admin-layout>
    @section('content')
   <style>
        input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
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
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Create Employee</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif
                                     <form enctype="multipart/form-data" id="validate-me-plz" action="{{ route('admin.image.store') }}"
                                            method="POST" id="main_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="control-label" for="title">Title</label> 
                                                        <input type="text" name="title" id="name" placeholder="Image Title"
                                                            class="form-control" data-rule-required="true" data-rule-minlength="2" data-msg-required="Please enter Title.">
                                                        @error('title')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="control-label" for="email">Email</label>
                                                        <input type="text" name="email" id="Email" placeholder="Enter Your Email"
                                                            class="form-control"  data-rule-required="true" data-rule-email="true" >
                                                        @error('title')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                  

                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="control-label" for="input-name">Image</label>
                                                        <div class="field" align="left">
                                                                <input type="file" id="files" data-rule-required="true"  data-msg-required="Please Select Atleast One.." accept=".jpg, .jpeg, .png,.pdf" name="image[]" multiple class="form-control image"  />
                                                        </div>

                                                        @error('image')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                        <span class="invalid" id="image-status"></span>
                                                        <!-- <img id="previewImages" height /> -->
                                                        <div class="previewImages"></div>
                                                    </div>
                                                </div>
                                               
    
                                                <div class="col-md-6">
                                                    <label class="control-label" for="input-status">Status of Image</label>
                                                    <div class="form-group mb-3">
                                                        <input type="radio" name="status" value="1" placeholder="Status"
                                                            id="input-status" checked="checked">
                                                        <label class="control-label" for="input-status">Active</label>
                                                        <input type="radio" name="status" value="0" placeholder="Status"
                                                            id="imgInp">
                                                        <label class="control-label" for="input-status">Inactive</label>
                                                        @error('stathhbus')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                        <span class="invalid" id="status-status"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="control-label" for="input-name">Image Test</label>
                                                        <div class="field" align="left">
                                                                <input type="file" id="myFileInput" accept=".jpg, .jpeg, .png,.pdf" name="image[]" multiple class="form-control image"  />
                                                            <img  src="" alt="" id="ImagePreview">
                                                            <p id="ImageRemove">remove</p>
                                                            </div>

                                                        @error('image')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                      
                                                        <div class="previewImages"></div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
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
       <!-- script for preview image -->
        <script>
        $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>
<!-- for validation -->
<script>
	$('#validate-me-plz').validate({
		ignore: [],
        onfocusout: function(element) {
        this.element(element);
        },
        errorClass: 'error_validate',
        errorElement:'lable',
        // highlight: function(element, errorClass) {
        // $(element).removeClass(errorClass);
        // }
	});
</script>

    <!-- store image in session -->
    <script>
        document.querySelector("#myFileInput").addEventListener("change",function(){
            // console.log(this.files)
            const reader = new FileReader();
            reader.addEventListener("load",() =>{
                 localStorage.setItem("recent-image",reader.result);   
            });
            reader.readAsDataURL(this.files[0]);
        });

        document.addEventListener("DOMContentLoaded", () =>{
                const recentImageDataUrl = localStorage.getItem("recent-image");
                if(recentImageDataUrl){
                    document.querySelector("#ImagePreview").setAttribute("src",recentImageDataUrl);
                }
        });

        document.addEventListener("DOMContentLoaded",() =>{
            const recentImageDataUrl = localStorage.removeItem("recent-image");
            if(recentImageDataUrl){
                document.querySelector("#ImageRemove").setAttribute("src",recentImageDataUrl);
                
            }
        })
    </script>

    @endsection
    </x-admin_layout>
