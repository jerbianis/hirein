@extends('layouts.app')

@section('head')
    <script type="text/javascript" src="https://unpkg.com/knockout/build/output/knockout-latest.js"></script>

    <!-- SurveyJS resources -->
    <link  href="https://unpkg.com/survey-core/defaultV2.min.css" type="text/css" rel="stylesheet">
    <script src="https://unpkg.com/survey-core/survey.core.min.js"></script>
    <script src="https://unpkg.com/survey-knockout-ui/survey-knockout-ui.min.js"></script>

    <!-- Survey Creator resources -->
    <link  href="https://unpkg.com/survey-creator-core/survey-creator-core.min.css" type="text/css" rel="stylesheet">
    <script src="https://unpkg.com/survey-creator-core/survey-creator-core.min.js"></script>
    <script src="https://unpkg.com/survey-creator-knockout/survey-creator-knockout.min.js"></script>
@endsection
@section('content')

    <div id="surveyCreator" style="height: 100vh;"></div>

    <script>
        const creatorOptions = {
            showLogicTab: true,
            isAutoSave: true
        };
        const creator = new SurveyCreator.SurveyCreator(creatorOptions);

        document.addEventListener("DOMContentLoaded", function() {
            creator.render("surveyCreator");
        });
    </script>

@endsection
