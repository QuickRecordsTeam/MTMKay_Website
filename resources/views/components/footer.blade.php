<footer class="footer-area p_120">
    <div class="container">
        <div class="row">
            <div class="col-lg-2  col-md-6 col-sm-6">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Top Services</h6>
                    <ul class="list">
                        <li><a href="#">IT Consulting</a></li>
                        <li><a href="#">IT Training and Certifications</a></li>
                        <li><a href="#">Website Development</a></li>
                        <li><a href="#">Cloud Hosting and Management</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2  col-md-6 col-sm-6">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Quick Links</h6>
                    <ul class="list">
                        <li><a href="{{route('about')}}" target="_blank">About Us</a></li>
                        <li><a href="{{route('services')}}" target="_blank">Services</a></li>
                        <li><a href="{{route('training')}}" target="_blank">Training</a></li>
                        <li><a href="{{route('blog')}}" target="_blank">Blogs</a></li>
                        <li><a href="{{route('contact')}}" target="_blank">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2  col-md-6 col-sm-6">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Resources</h6>
                    <ul class="list">
                        <li><a href="#">Linkedln</a></li>
                        <li><a href="#">Facebook Group</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <aside class="f_widget news_widget">
                    <div class="f_title">
                        <h3 class="footer_title">Newsletter</h3>
                    </div>
                    <p>Stay updated with our latest trainings and blogs</p>
                    <div id="mc_embed_signup">
                        <form id="myForm">
                            
                            <div class="input-group d-flex flex-row">
                                <input name="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required type="email"/>
                                <button class="btn  sub-btn" type="submit"  ><span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </form>
                        <div class="mt-10 info" id="show_subscription_process" style="display: none; background-color: #385abe !important;color: white!important;text-align: center">Subscribing...</div>
                    </div>
                </aside>
            </div>
        </div>
        <div class="row footer-bottom d-flex justify-content-between align-items-center">
            <p class="col-lg-8 col-md-8 footer-text m-0">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> | Designed with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.linkedin.com/in/suh-edmond-37aaa51aa" target="_blank">Suh Edmond</a>
            </p>
            <div class="col-lg-4 col-md-4 footer-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <div id="success_subscribe" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="text-primary">Thank you for subscribing to our newsletter</h4>
                    <p>You will receive notification emails for new blog posts and commencements of our training programs.<br>
                    You will receive a mail confirming your subscription.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="already_subscribe" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="text-primary">You have already subscribed to our newsletter</h4>
                    <p>You will receive notification emails for new blog posts and commencements of our training programs</p>
                </div>
            </div>
        </div>
    </div>
    <div id="error_subscribe" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="text-primary">Oops! Error</h4>
                    <p>An error occurred we could not complete your subscription. Please try agin</p>
                </div>
            </div>
        </div>
    </div>
</footer>
