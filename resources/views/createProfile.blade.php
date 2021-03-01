<!-- createProfile.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                </div>
                <div style="overflow-x:auto">
                    <form action="{{ route('profile.postCreate') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <table>
                            <tr>
                                <th colspan = "2"><label for="prof_name">Please fill up your profile below.</label></th>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_name">Name</label></td>
                                <td style="text-align: left"><input type="text" id="prof_name" name="prof_name" value="enter here"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_address">Address</label></td>
                                <td style="text-align: left"><input type="text" id="prof_address" name="prof_address" value="enter here"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_postcode">Postcode</label></td>
                                <td style="text-align: left"><input type="text" id="prof_postcode" name="prof_postcode" value="enter here"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_email">Email</label></td>
                                <td style="text-align: left"><input type="text" id="prof_email" name="prof_email" value="enter here"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_website">Website</label></td>
                                <td style="text-align: left"><input type="text" id="prof_website" name="prof_website" value="enter here"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><label for="prof_image">Image</label></td>
                                <td style="text-align: left"><input type="file" name="prof_image" id="prof_image"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">
                                </td>
                                <td style="text-align: left">
                                    <button type="submit" class="btn btn-primary" style="width:200px">Create Profile</button>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size:14px; color:red" colspan = "2">Note: If you are registering as a shop, after submitting profile please contact site administrator to enable posting/s.</td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
