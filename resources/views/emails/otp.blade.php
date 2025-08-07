<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
  <div style="margin:50px auto;width:70%;padding:20px 0">
    {{-- <div style="border-bottom:1px solid #eee">
      <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">AnCeega</a>
    </div> --}}
    <p style="font-size:1.1em">@lang('messages.hi'),{{ $recipientName }}</p>
    <p>@lang('otp_message',[],'ar')</p>
    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">
      @lang('messages.Your One-Time Password(OTP) is:') {{$otp}}</h2>
    <p style="font-size:0.9em;"> @lang('messages.This code is valid for') 15 @lang('messages.minutes and can be used to complete the verification process. Please do not share this code with anyone. If you did not request this code, please disregard this message or contact our support team immediately.') </p>
    <p style="font-size:0.9em;"> @lang('messages.thanks_for_you')</p>
    <p style="font-size:0.9em;">@lang('messages.An-theqa')</p>
    <p style="font-size:0.9em;">info@anceega.com</p>
    <hr style="border:none;border-top:1px solid #eee" />
    <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
    </div>
  </div>
</div>
