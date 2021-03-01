<!-- profile.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <img class="rounded-circle" width="150" src="/storage/{{ $profile->image }}">
                    {{ __(Auth::user()->name . ', Profile Dashboard')}}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                    @endif
                    <div style="overflow-x:auto">
                        <form action="{{ route('profile.postEdit') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <table style="text-align: left">
                            <tr>
                                <td style="text-align: left">Name</td>
                                <td style="text-align: left"><input type="text" id="prof_name" name="prof_name" value="{{$profile->name}}" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Address</td>
                                <td style="text-align: left"><input type="text" id="prof_address" name="prof_address" value="{{$profile->address}}" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Postcode</td>
                                <td style="text-align: left"><input type="text" id="prof_postcode" name="prof_postcode" value="{{$profile->postcode}}" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Email</td>
                                <td style="text-align: left"><input type="text" id="prof_email" name="prof_email" value="{{$profile->email}}" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Website</td>
                                <td style="text-align: left"><input type="text" id="prof_website" name="prof_website" value="{{$profile->website}}" required></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Image</td>
                                <td style="text-align: left"><input type="file" name="prof_image" id="prof_image"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">
                                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Back</a>
                                </td>
                                <td style="text-align: left">
                                    <input type="hidden" id="prof_id" name="prof_id" value="{{$profile->id}}">
                                    <button type="submit" class="btn btn-success" style="width:150px">Edit</button>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

