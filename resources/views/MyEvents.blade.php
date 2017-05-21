<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<style>
    #map {
        height: 30%;
        width:100%;
    }
    #mapsIndicatie
    {
        font-size:10pt;
    }
    #locationView
    {
        height: 30%;
        width:100%;
    }
</style>
@extends('master user.Layout')
@section('generateScript')
    <script  src="{!! asset('js/views/loadSession.js') !!}"></script>
    <script  src="{!! asset('js/views/generateMyEvents.js') !!}"></script>
    <script  src="{!! asset('js/views/eventValidation.js') !!}"></script>
@stop
@section('googleMaps')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFMCLyivsWTU1Iv4iToM9fOdEWJLHfQOQ&callback=initGoogleMaps"
            async defer></script>
@stop
<div id="googleMapsModal" hidden class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Locatie van event</h4>
            </div>
            <div id="locationWindow" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>