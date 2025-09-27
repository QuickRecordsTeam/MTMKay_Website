<x-mail::message>
<img src="{{ asset($data['program_image']) }}" alt="Program Image" width="100%" height="250px"/><br><br>

Hi <b>{{ $data['student']->name }}</b>!<br>

We have received your payment for the <b>{{ $data['program']->title }}</b> training program with MTMKay.

Here are the details of your payment:

- **Amount Paid (this transaction):** {{ number_format($data['amount_paid']) }} XAF  
- **Total Paid So Far:** {{ number_format($data['total_paid']) }} XAF  
- **Remaining Balance:** {{ number_format($data['remaining']) }} XAF  

@if($data['remaining'] > 0)
⚠️ Please complete the remaining balance to finalize your enrollment.  
@else
✅ Congratulations! Your payment is complete, and your enrollment is now confirmed.  
@endif

<x-mail::button :url="$data['program_link']">
    View Program Details
</x-mail::button>

If you have any questions or concerns, feel free to contact support at  
<a class="dn_btn" href="mailto:support@mtmkay.com">support@mtmkay.com</a> or  
<a class="dn_btn" href="tel:+4400123654896">+1 612 224 1176.</a>

<br>

Best regards,<br>
MTMKay Team.<br>

<!-- Social Icons -->
<div style="display: flex;justify-content: center; margin: 30px 0">
    <a href="#" style="padding: 10px"><img src="{{ asset('/img/blog/facebook-logo.png') }}" alt="facebook logo" width="30px" height="30px"></a>
    <a href="#" style="padding: 10px"><img src="{{ asset('/img/blog/instagram-logo.png') }}" alt="instagram logo" width="30px" height="30px"></a>
    <a href="#" style="padding: 10px"><img src="{{ asset('/img/blog/twitter-logo.png') }}" alt="twitter logo" width="30px" height="30px"></a>
    <a href="#" style="padding: 10px"><img src="{{ asset('/img/blog/whatsapp-logo.png') }}" alt="whatsapp logo" width="30px" height="30px"></a>
</div>

<!-- Footer -->
<div style="background-color: #e2e8f0; padding: 10px; margin-top: 20px">
    <div style="text-align: center; font-weight: bold; margin-bottom: 5px">
        <a href="{{ route('home') }}" style="text-decoration: none">MTMKay</a>
    </div>
    <div style="text-align: center; margin-bottom: 5px">
        Opposite Alaska Street Buea Road Kumba, Cameroon.
    </div>
    <div style="text-align: center;">
        This email was sent to <a class="dn_btn">{{ $data['student']->email }}</a><br>
        You can subscribe to our newsletter to stay updated on news and events at MTMKay.
    </div>
    <div style="text-align: center; margin-top: 10px">
        | <a class="dn_btn" href="{{ $data['subscription_link'] }}">Subscribe</a>
    </div>
</div>
</x-mail::message>
