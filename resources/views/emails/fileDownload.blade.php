<html>
<head></head>
<body>
<p>
    Hi {{ $userName }},
</p>
<p>
    fileDownload
        {!! __('email.fileDownload.filesRequested',
        ['dateRequest' => $projectZip->dateRequest],
        ['projectName' => $projectName]) !!}
        <a href="{{ $link }}">download</a>.
<p>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Images</th>
            <th>Size</th>
            <th>Date Request</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td><a href="{{ $link }}">{{ $projectZip->idProjectZip }}</a></td>
        <td><a href="{{ $link }}">{{ $projectZip->type }}</a></td>
        <td><a href="{{ $link }}">{{ $projectZip->images }}</a></td>
        <td><a href="{{ $link }}">{{ round($projectZip->size/1000000, 2) }} MB</a></td>
        <td><a href="{{ $link }}">{{ $projectZip->dateRequest }}</a></td>
    </tr>
    </tbody>
</table>

<p>
    {!! __('email.fileDownload.experienceIssues', ['email' => env('MAIL_FROM_ADDRESS')]) !!}
</p>
<p>
    -- Device Pixel<br />
    {{ env('MAIL_FROM_ADDRESS') }}
</p>

</body>
</html>
