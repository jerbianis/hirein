@extends('layouts.app')
@section('head')
    <script src='https://meet.jit.si/external_api.js'></script>
@endsection
@section('content')
    <div class="container">
        <div id="interview_video_call"></div>
    </div>
<script>
    const interviewName = '{{$positionName}}' + ' - ' + '{{$userName}}';
    const userName = '{{$userName}}';
    const domain = 'meet.jit.si';
    const options = {
        roomName: interviewName,
        width: 1000,
        height: 800,
        userInfo: {
            displayName: userName
        },
        parentNode: document.querySelector('#interview_video_call')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
</script>
@endsection
