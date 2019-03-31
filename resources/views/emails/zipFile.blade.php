@include('emails.layout.header')
<p>
    {!! __('email.hiUser', ['userName' => $userName]) !!}
</p>
<p>
    {!! __('email.ZipFile.zipFilesRequested') !!}
</p>
<table style="margin: 35px 0; font-size: 15px; border-spacing: 0; border-collapse: separate;" cellpadding="0" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="text-align:left; border-bottom: 0.5px solid #efefef; padding: 10px;">Type</th>
      <th style="text-align:left; border-bottom: 0.5px solid #efefef; padding: 10px;">Images</th>
      <th style="text-align:left; border-bottom: 0.5px solid #efefef; padding: 10px;">Size</th>
      <th style="text-align:left; border-bottom: 0.5px solid #efefef; padding: 10px;">Expiration Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach($zipFiles as  $zipFile)
    <tr>
      <td style="border-bottom: 0.5px solid #efefef; padding: 10px;">
        {{ $zipFile->deviceType }}
      </td>
      <td style="border-bottom: 0.5px solid #efefef; padding: 10px;">
        {{ $zipFile->images }}
      </td>
      <td style="border-bottom: 0.5px solid #efefef; padding: 10px;">
          {{ @formatFileSize($zipFile->size) }}
      </td>
      <td style="border-bottom: 0.5px solid #efefef; padding: 10px;">
        {{ @formatDateDay($zip->expire) }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<p>
    {!! __('email.ZipFile.zipReady', [
            'createdDate' => @formatDateDay($zip->created_at),
            'href' => $link,
            'style' => 'color: #008dff; text-decoration: none;'
        ])
    !!}
</p>
<p>
    {!! __('email.emailByMistake', ['email' => config('constants.supportEmail')]) !!}
</p>
@include('emails.layout.footer')
