@include('emails.layout.header')

<p>
    {!! __('email.activation.welcome', ['userName' => $user->name]) !!}
</p>
<h3 style="color:#37517e; font-weight: normal;">
    {!! __('email.activation.startOptimizing') !!}
</h3>
<p>
    {!! __('email.activation.confirmButton') !!}
</p>
<table style="margin: 35px 0;" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <th style="border-radius: 3px; line-height: 100%; mso-padding-alt: 5px 50px 10px; background-color: #1890ff;">
      <a
        href="{{ $link }}"
        style="color: #FFFFFF; display: block; padding: 15px 50px; text-decoration: none;"
      >
        Confirm my email address
      </a>
    </th>
  </tr>
</table>

<p>
    {!! __('email.emailByMistake', ['email' => config('constants.supportEmail')]) !!}
</p>
@include('emails.layout.footer')
