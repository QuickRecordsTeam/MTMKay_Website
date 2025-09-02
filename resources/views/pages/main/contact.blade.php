@section('title', 'MTMKay-Contact Us')
<x-guest-layout>
<!--================Home Banner Area =================-->
<section class="banner_area">
    <div class="banner_contact d-flex align-items-center">
        <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
        <div class="container">
            <div class="banner_content text-center">
                <h2>Contact Us</h2>
                <div class="page_link">
                    <a href="{{route('home')}}">Home</a>
                    <a href="{{route('contact')}}">Contact</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->

<!--================Contact Area =================-->
<section class="contact_area p_120">
    <div class="container">
        <div id="map" class="mapBox"></div>
        <div class="row">
            <div class="col-lg-3">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        <h6>Southwest Region, Cameroon</h6>
                        <p>Opposite Alaska Street Buea Road Kumba</p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        <h6><a href="#">+237 671 128 616</a></h6>
                        <p>Mon to Saturday 8 am to 9 pm</p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        <h6><a href="mailto:support@mtmkay.com">support@mtmkay.com</a></h6>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                @if(session('message'))
                    <div class="d-flex justify-content-center session_message">
                        <div class=" my-4 font-bold text-primary session_message">
                            {{session('message')}}
                        </div>
                    </div>
                @endif
                <form class="row contact_form" action="{{route('on-inquire')}}" method="post"  >
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control"  name="name" placeholder="Enter your name" required value="{{old('name')}}"/>
                            @if($errors->has('name'))
                                @foreach($errors->get('name') as $message )
                                    <span style="color: red">{{ $message }}</span><br>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control " name="email" placeholder="Enter email address" required value="{{old('email')}}"/>
                            @if($errors->has('email'))
                                @foreach($errors->get('email') as $message )
                                    <span style="color: red">{{ $message }}</span><br>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"   name="subject" placeholder="Enter Subject" value="{{old('subject')}}" required/>
                            @if($errors->has('subject'))
                                @foreach($errors->get('subject') as $message )
                                    <span style="color: red">{{ $message }}</span><br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea class="form-control" name="message"   rows="1" placeholder="Enter Message" required >{{old('message')}}</textarea>
                            @if($errors->has('message'))
                                @foreach($errors->get('message') as $message )
                                    <span style="color: red">{{ $message }}</span><br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" value="submit" class="btn main_btn">
                            <span class="btn-text">Send Message</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--================Contact Area =================-->

<!--================Contact Success and Error message Area =================-->
<div id="success" class="modal modal-message fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
                <h2>Thank you</h2>
                <p>Your message is successfully sent...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modals error -->

<div id="error" class="modal modal-message fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
                <h2>Sorry !</h2>
                <p> Something went wrong </p>
            </div>
        </div>
    </div>
</div>
<!--================End Contact Success and Error message Area =================-->



</x-guest-layout>
<script>
    $(document).ready(function () {
        setTimeout(showFeedback, 3000)
    });

    function showFeedback() {
        $(".session_message").css("display", "none");
    }
</script>
