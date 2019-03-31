@extends('layouts.email')
@section('content')
<table data-module="module-6" data-thumb="thumbnails/06.png" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td data-bgcolor="bg-module" bgcolor="#eaeced">
            <table class="flexible" width="600"  style="margin:0 auto;" cellpadding="0" cellspacing="0">
                <tr>
                    <td data-bgcolor="bg-block" class="holder" style="padding:64px 60px 50px;" bgcolor="#f9f9f9">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td data-color="title" data-size="size title" data-min="20" data-max="40" data-link-color="link title color" data-link-style="text-decoration:none; color:#292c34;" class="title"  style="font:30px/33px Arial, Helvetica, sans-serif; color:#292c34; padding:0 0 23px;">
                                    Payment Due | Device Pixel
                                </td>
                            </tr>
                            <tr>
                                <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;"  style="font:16px/29px Arial, Helvetica, sans-serif; color:#888; padding:0 0 21px;">
                                    Hello {{ $companyName }}
                                    <br /><br />
                                    The invoice on your account is currently due:
                                    <table>
                                        <tr>
                                            <th>Plan</th>
                                            <th>Amount</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $planName }} (#{{ $planName }})</td>
                                            <td>{{ $amount }}</td>
                                        </tr>
                                    </table>
                                    <p>
                                        To make a payment, please log in with your email address
                                        and password at: https://portal.devicepixel.com
                                    </p>
                                    <p>
                                        Once paid no further action will be needed and your
                                        account will remain active.
                                    </p>
                                    <p>
                                        We thank you for your continued business and assistance
                                        in helping us to get this resolved. Feel free to contact
                                        us if you have any questions, comments, or concerns.
                                    </p>
                                    <p>
                                        Best regards,
                                        DevicePixel.com
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="28"></td></tr>
            </table>
        </td>
    </tr>
</table>
@endsection