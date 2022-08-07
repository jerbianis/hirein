<!DOCTYPE html>
<html lang="en">
<head>
    <title>Interview</title>
    <script src='https://meet.jit.si/external_api.js'></script>
</head>
<body>

<div id="interview_video_call"></div>
<script>
    const interviewName = '{{$positionName}}' + ' - ' + '{{$userName}}';
    const userName = '{{$userName}}';
    const domain = 'meet.jit.si';
    const options = {
        roomName: interviewName,
        width: 800,
        height: 800,
        userInfo: {
            displayName: userName
        },
        parentNode: document.querySelector('#interview_video_call')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
</script>
</body>
</html>
