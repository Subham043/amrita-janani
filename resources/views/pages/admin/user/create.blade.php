@extends('layouts.admin.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">User</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
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
                        <h4 class="card-title mb-0 flex-grow-1">User</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form id="countryForm" method="post" action="{{route('subadmin_store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                        @error('name') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
                                        @error('email') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{old('phone')}}">
                                        @error('phone') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="userType" class="form-label">User Type</label>
                                        <select id="userType" name="userType"></select>
                                        @error('userType') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" value="">
                                        @error('password') 
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <div>
                                        <label for="cpassword" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="cpassword" id="cpassword" value="">
                                        @error('cpassword') 
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

                                <div class="col-xxl-12 col-md-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
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
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>

<script type="text/javascript">
const choices = new Choices('#userType', {
    silent: false,
    items: [],
    choices: [
            {
                value: 'Select the user type',
                label: 'Select the user type',
                selected: {{empty(old('for')) ? 'true' : 'false'}},
                disabled: true,
            },
        @foreach($common['user_type'] as $key => $val)
            {
                value: '{{$key}}',
                label: '{{$val}}',
                @if($key==1)disabled: true,@endif
            },
        @endforeach
    ],
    renderChoiceLimit: -1,
    maxItemCount: -1,
    addItems: true,
    addItemFilter: null,
    removeItems: true,
    removeItemButton: false,
    editItems: false,
    allowHTML: true,
    duplicateItemsAllowed: true,
    delimiter: ',',
    paste: true,
    searchEnabled: true,
    searchChoices: true,
    searchFloor: 1,
    searchResultLimit: 4,
    searchFields: ['label', 'value'],
    position: 'auto',
    resetScrollPosition: true,
    shouldSort: true,
    shouldSortItems: false,
    // sorter: () => {...},
    placeholder: true,
    placeholderValue: 'Select the user type',
    searchPlaceholderValue: null,
    prependValue: null,
    appendValue: null,
    renderSelectedChoices: 'auto',
    loadingText: 'Loading...',
    noResultsText: 'No results found',
    noChoicesText: 'No choices to choose from',
    itemSelectText: 'Press to select',
    addItemText: (value) => {
      return `Press Enter to add <b>"${value}"</b>`;
    },
    maxItemText: (maxItemCount) => {
      return `Only ${maxItemCount} values can be added`;
    },
    valueComparer: (value1, value2) => {
      return value1 === value2;
    },
    classNames: {
      containerOuter: 'choices',
      containerInner: 'choices__inner',
      input: 'choices__input',
      inputCloned: 'choices__input--cloned',
      list: 'choices__list',
      listItems: 'choices__list--multiple',
      listSingle: 'choices__list--single',
      listDropdown: 'choices__list--dropdown',
      item: 'choices__item',
      itemSelectable: 'choices__item--selectable',
      itemDisabled: 'choices__item--disabled',
      itemChoice: 'choices__item--choice',
      placeholder: 'choices__placeholder',
      group: 'choices__group',
      groupHeading: 'choices__heading',
      button: 'choices__button',
      activeState: 'is-active',
      focusState: 'is-focused',
      openState: 'is-open',
      disabledState: 'is-disabled',
      highlightedState: 'is-highlighted',
      selectedState: 'is-selected',
      flippedState: 'is-flipped',
      loadingState: 'is-loading',
      noResults: 'has-no-results',
      noChoices: 'has-no-choices'
    },
    // Choices uses the great Fuse library for searching. You
    // can find more options here: https://fusejs.io/api/options.html
    fuseOptions: {
      includeScore: true
    },
    labelId: '',
    callbackOnInit: null,
    callbackOnCreateTemplates: null
  });
  </script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-zA-Z\s]*$/,
        errorMessage: 'Name is invalid',
    },
  ])
  .addField('#email', [
    {
      rule: 'required',
      errorMessage: 'Email is required',
    },
    {
      rule: 'email',
      errorMessage: 'Email is invalid!',
    },
  ])
  .addField('#phone', [
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Phone is invalid',
    },
  ])
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Password is invalid',
    },
  ])
  .addField('#cpassword', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    },
    {
        validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
            const repeatPasswordValue = fields['#password'].elem.value;

            return value === repeatPasswordValue;
        }

        return true;
        },
        errorMessage: 'Password and Confirm Password must be same',
    },
  ])
  .addField('#userType', [
    {
      rule: 'required',
      errorMessage: 'Please select the user type',
    },
    {
        validator: (value, fields) => {
        if (value === 'Select the user type') {
            return false;
        }
        return true;
        },
        errorMessage: 'Please select the user type',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop