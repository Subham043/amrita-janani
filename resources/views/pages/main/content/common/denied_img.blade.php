<div class="main-denied-container" id="image-container">
    <div class="denied-container" data-toggle="tooltip" data-placement="bottom" title="You do not have permission to access this image. Kindly request access for this image from admin by clicking on the request access button">
        <div class="container denied-inner-wrapper">
            <div class="denied-text-container">
                <img src="{{asset('main/images/secure.png')}}" />
                <h4>Oops!!</h4>
                <p>The {{$text}} is restricted by the admin. In order to access this {{$text}}, Please click on the request access button given below.</p>
                <button class="request-access-button"  data-toggle="modal" data-target="#requestAccessModal" ><i class="far fa-question-circle"></i> Request Access</button>
            </div>
        </div>
    </div>
</div>