@extends('layouts.admin.dashboard')


@section('css')
<link href="{{ asset('admin/libs/quill/quill.core.css' ) }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/quill/quill.bubble.css' ) }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/quill/quill.snow.css' ) }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/css/tagify.css' ) }}" rel="stylesheet" type="text/css" />

<style>
    #description{
        min-height: 200px;
    }
</style>
@stop


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Images</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Images</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
        <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <div>
                        <a href="{{url()->previous()}}" type="button" class="btn btn-dark add-btn" id="create-btn"><i class="ri-arrow-go-back-line align-bottom me-1"></i> Go Back</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Images</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form id="countryForm" method="post" action="{{route('image_store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                                        @error('title') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="year" class="form-label">Year</label>
                                        <input type="text" class="form-control" name="year" id="year" value="{{old('year')}}">
                                        @error('year') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="version" class="form-label">Version</label>
                                        <input type="text" class="form-control" name="version" id="version" value="{{old('version')}}">
                                        @error('version') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="deity" class="form-label">Deity</label>
                                        <input type="text" class="form-control" name="deity" id="deity" value="{{old('deity')}}">
                                        @error('deity') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" name="tags" id="tags" value="{{old('tags')}}">
                                        @error('tags') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="topics" class="form-label">Topics</label>
                                        <input type="text" class="form-control" name="topics" id="topics" value="{{old('topics')}}">
                                        @error('topics') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control" type="file" name="image" id="image">
                                        @error('image') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="description" class="form-label">Description</label>
                                        <div id="description"></div>
                                            @error('description') 
                                                <div class="invalid-message">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12 col-md-12">
                                    <div class="mt-4 mt-md-0">
                                        <div>
                                            <div class="form-check form-switch form-check-right mb-2">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRightDisabled" name="status" checked>
                                                <label class="form-check-label" for="flexSwitchCheckRightDisabled">Status</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 col-md-12">
                                    <div class="mt-4 mt-md-0">
                                        <div>
                                            <div class="form-check form-switch form-check-right mb-2">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRightDisabled2" name="restricted">
                                                <label class="form-check-label" for="flexSwitchCheckRightDisabled2">Restricted</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div><!--end col-->

                                <div class="col-xxl-12 col-md-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Create</button>
                                </div>
                                
                            </div>
                            </form>
                            <!--end row-->
                        </div>
                        
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        

    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop          
           

@section('javascript')
<script src="{{ asset('admin/libs/quill/quill.min.js' ) }}"></script>
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/tagify.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/tagify.polyfills.min.js') }}"></script>

<script type="text/javascript">
var quillDescription = new Quill('#description', {
    theme: 'snow'
});
</script>

<script type="text/javascript">
    var tagElem = [];
    @if($tags_exist)
        @foreach($tags_exist as $tag)
        tagElem.push("{{$tag}}")
        @endforeach
    @endif
var tagInput = document.getElementById('tags'),
tagify = new Tagify(tagInput, {
    whitelist : tagElem,
    dropdown : {
        classname     : "color-blue",
        enabled       : 0,              // show the dropdown immediately on focus
        position      : "text",         // place the dropdown near the typed text
        closeOnSelect : false,          // keep the dropdown open after selecting a suggestion
        highlightFirst: true
    }
});
</script>

<script type="text/javascript">
    var topicElem = [];
    @if($topics_exist)
        @foreach($topics_exist as $topic)
        topicElem.push("{{$topic}}")
        @endforeach
    @endif
var topicInput = document.getElementById('topics'),
tagifyTopic = new Tagify(topicInput, {
    whitelist : topicElem,
    dropdown : {
        classname     : "color-blue",
        enabled       : 0,              // show the dropdown immediately on focus
        position      : "text",         // place the dropdown near the typed text
        closeOnSelect : false,          // keep the dropdown open after selecting a suggestion
        highlightFirst: true
    }
});
</script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#title', [
    {
      rule: 'required',
      errorMessage: 'Title is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Title is invalid',
    },
  ])
  .addField('#year', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Year is invalid',
    },
  ])
  .addField('#version', [
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Version is invalid',
    },
  ])
  .addField('#deity', [
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Deity is invalid',
    },
  ])
  .addField('#image', [
    {
        rule: 'minFilesCount',
        value: 1,
        errorMessage: 'Please select an image',
    },
    {
        rule: 'files',
        value: {
            files: {
                extensions: ['jpeg', 'png', 'jpg', 'webp']
            },
        },
        errorMessage: 'Please select a valid image',
    },
  ])
  .onSuccess(async (event) => {
    // event.target.submit();

    const errorToast = (message) =>{
            iziToast.error({
                title: 'Error',
                message: message,
                position: 'bottomCenter',
                timeout:7000
            });
        }
        const successToast = (message) =>{
            iziToast.success({
                title: 'Success',
                message: message,
                position: 'bottomCenter',
                timeout:6000
            });
        }

        
        var submitBtn = document.getElementById('submitBtn')
        submitBtn.innerHTML = `
            <span class="d-flex align-items-center">
                <span class="spinner-border flex-shrink-0" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span class="flex-grow-1 ms-2">
                    Loading...
                </span>
            </span>
            `
        submitBtn.disabled = true;
    
      try {
        var formData = new FormData();
        formData.append('title',document.getElementById('title').value)
        formData.append('year',document.getElementById('year').value)
        formData.append('deity',document.getElementById('deity').value)
        formData.append('version',document.getElementById('version').value)
        formData.append('description_unformatted',quillDescription.getText())
        formData.append('description',quillDescription.root.innerHTML)
        formData.append('status',document.getElementById('flexSwitchCheckRightDisabled').checked === true ? 'on' : 'off')
        formData.append('restricted',document.getElementById('flexSwitchCheckRightDisabled2').checked === true ? 'on' : 'off')
        formData.append('image',document.getElementById('image').files[0])
        if(tagify.value.length > 0){
            var tags = tagify.value.map(item => item.value).join(',')
            // console.log(tags);
            formData.append('tags',tags)
        }
        if(tagifyTopic.value.length > 0){
            var topics = tagifyTopic.value.map(item => item.value).join(',')
            // console.log(topics);
            formData.append('topics',topics)
        }
        // formData.append('refreshUrl','{{URL::current()}}')
        
        const response = await axios.post('{{route('image_store')}}', formData)
        successToast(response.data.message)
        setTimeout(function(){
            window.location.replace(response.data.url);
        }, 1000);
      } catch (error) {
          console.log(error);
        if(error?.response?.data?.form_error?.title){
            errorToast(error?.response?.data?.form_error?.title[0])
        }
        if(error?.response?.data?.form_error?.year){
            errorToast(error?.response?.data?.form_error?.year[0])
        }
        if(error?.response?.data?.form_error?.deity){
            errorToast(error?.response?.data?.form_error?.deity[0])
        }
        if(error?.response?.data?.form_error?.version){
            errorToast(error?.response?.data?.form_error?.version[0])
        }
        if(error?.response?.data?.form_error?.description){
            errorToast(error?.response?.data?.form_error?.description[0])
        }
        if(error?.response?.data?.form_error?.image){
            errorToast(error?.response?.data?.form_error?.image[0])
        }
      } finally{
            submitBtn.innerHTML =  `
                Submit
                `
            submitBtn.disabled = false;
        }
  });
</script>

@stop