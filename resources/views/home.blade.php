<!-- home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __(Auth::user()->name . ' Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- ME=> Show user profile -->
                    <div style="overflow: auto">
                        @foreach($profiles as $Profilekey => $profile)
                            @if($profile->user_id == (Auth::user()->id))
                                <table>
                                    <tr>
                                        <td rowspan="3"><img class="rounded-circle" width="150" src="/storage/{{ $profile->image }}"></td>
                                        <th style="text-align: left">Name</th>
                                        <td style="text-align: left">{{$profile->name}}</td>
                                        <th style="text-align: left">Email</th>
                                        <td style="text-align: left">{{$profile->email}}</td>                                   
                                    </tr>
                                    <tr>
                                        <th style="text-align: left">Address</th>
                                        <td style="text-align: left">{{$profile->address}}</td>
                                        <th style="text-align: left">Website</th>
                                        <td style="text-align: left"><a href="http://{{$profile->website}}" target="_blank">{{$profile->website}}</a></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: left">Postcode</th>
                                        <td style="text-align: left">{{$profile->postcode}}</td>
                                        <th style="text-align: left"></th>
                                        <td style="text-align: left"></td>
                                    </tr>
                                </table>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <div class="tableScroll">
                    <table>
                        <tr>
                            <th>Main Category</th>
                            <th>Sub Category</th>
                        </tr>
                        <form id="selectFilter">
                        <tr>
                            <td>
                                <!-- => ME, to display only unique main categories item/s for selection -->
                                @php ($temp_arrs = array("Select a Main Category", "All"))
                                @foreach($posts as $Postkey => $post)
                                    @php (array_push($temp_arrs, $post->main_cat))
                                @endforeach
                                @php ($array_catResults = array_unique($temp_arrs))
                                @php ($array_catResults = array_values($array_catResults))
                                <select id="post_main_cat_sel" name="post_main_cat_sel" onchange="categoryChange(this, {{$posts}}, {{json_encode($array_catResults, TRUE)}}, 'user')" required>
                                    @foreach($array_catResults as $Categorykey => $array_catResult)
                                        <option value="{{$array_catResult}}">{{$array_catResult}}</option>                                        
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="post_subcat_1_sel" id="post_subcat_1_sel" onchange="selectOnchangeFunction({{$posts}}, {{$profiles}}, 'no_sort')">
                                    <option value="First select a Main Category">First select a Main Category</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:14px" colspan="2">Select a main category and sub-category to search.</td>                            
                        </tr>
                        </form>
                    </table>
                </div>
                <div class="tableScroll">
                    <table id="postShowTable">
                        <tr>
                            <th>Main Category</th>
                            <th>Sub Category</th>
                            <th>Brand</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>
                                <button type="submit" class="far fa-caret-square-down btnArrow" onclick="selectOnchangeFunction({{$posts}}, {{$profiles}}, 'down')"> <!-- Sort down arrow -->
                            </th>
                            <th>Price</th>
                            <th>
                                <button type="submit" class="far fa-caret-square-up btnArrow" onclick="selectOnchangeFunction({{$posts}}, {{$profiles}}, 'up')"> <!-- Sort up arrow -->
                            </th>
                            <th>Image</th>
                            <th>Shop Name</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
