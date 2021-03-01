<!-- shop_home.blade.php -->

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

                <!-- Tab Define -->
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'Edit_Delete_Post')" id="defaultOpen"><b>Edit/Delete Post</b></button>
                    <button class="tablinks" onclick="openTab(event, 'Create_Post')"><b>Create Post</b></button>
                </div>

                <!-- User Edit/Delete Post Tab -->
                <div id="Edit_Delete_Post" class="tabcontent">
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>Main Category</th>
                                <th>Sub Category</th>
                                <th>Brand</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th colspan = "2">Image</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($posts as $Postkey => $post)
                            @if($post->user_id == Auth::user()->id)
                            <!-- filter only to show login shop's post -->
                            <tr>
                                <form action="{{ route('post.update',$post->id) }}" enctype="multipart/form-data" method="POST">
                                    <td>
                                        {{$post->main_cat}}
                                        <input type="hidden" id="post_main_cat" name="post_main_cat" value="{{$post->main_cat}}">
                                    </td>
                                    <td>
                                        {{$post->subcat_1}}
                                        <input type="hidden" id="post_subcat_1" name="post_subcat_1" value="{{$post->subcat_1}}">
                                    </td>
                                    <td><input type="text" id="post_brand" name="post_brand" value="{{$post->brand}}" required></td>
                                    <td><input type="text" id="post_description" name="post_description" value="{{$post->description}}" required></td>
                                    <td><input type="number" id="post_qty" name="post_qty" value="{{$post->qty}}" required></td>
                                    <td><input type="number" step="0.1" id="post_price" name="post_price" value="{{$post->price}}" placeholder="0.00" required></td>
                                    <td>
                                        <!-- => ME, for modal image -->
                                        @php ($myModal = "myModal_Post" . $Postkey)
                                        @php ($myImg = "myImg_Post" . $Postkey)
                                        @php ($img01 = "img01_Post" . $Postkey)
                                        @php ($mySpan = "mySpan_Post" . $Postkey)
                                        @php ($myCaption = "myCaption_Post" . $Postkey)
                                        <img id='{{ $myImg }}' src='/storage/{{ $post->image }}' alt='{{ $post->description }}' height='50' width='50' onload="onloadImageModal('{{ $myModal }}', '{{ $myImg }}', '{{ $img01 }}', '{{ $mySpan }}', '{{ $myCaption }}')">
                                        <div id='{{ $myModal }}' class='modal'>
                                            <span id='{{ $mySpan }}' class='close'>&times</span>
                                            <img class='modal-content' id='{{ $img01 }}'>
                                            <div id='{{ $myCaption }}'></div>
                                        </div>
                                        <!-- => ME, for modal image -->
                                    </td>
                                    <td><input type="file" name="post_image" id="prof_image"></td>
                                    <td>
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="far fa-edit btnEdit"></button>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{ route('post.destroy',$post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="far fa-trash-alt btnDelete"></button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- User Create Post Tab -->
                <div id="Create_Post" class="tabcontent">
                    <div class="tableScroll">
                        <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <table>
                                <tr>
                                    <td style="text-align: left">Main Category</td>
                                    <td style="text-align: left">
                                        <!-- => ME, to display only unique main categories item/s for selection -->
                                        @php ($temp_arrs = array("Select a Main Category"))
                                        @foreach($categories as $Categorykey => $category)
                                            @php(array_push($temp_arrs, $category->main_cat))
                                        @endforeach
                                        @php ($array_catResults = array_unique($temp_arrs))
                                        @php ($array_catResults = array_values($array_catResults))
                                        <select id="post_main_cat_sel" name="post_main_cat_sel" onchange="categoryChange(this, {{$categories}}, {{json_encode($array_catResults, TRUE)}}, 'shop')" required>
                                            @foreach($array_catResults as $key => $array_catResult)
                                                <option value="{{$array_catResult}}">{{$array_catResult}}</option>                                        
                                            @endforeach
                                        </select>                                    
                                    </td>
                                    <td style="text-align: left; font-size:14px;">Please contact site administrator if new main or sub category required.</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Sub Category</td>
                                    <td style="text-align: left">
                                        <select id="post_subcat_1_sel" name="post_subcat_1_sel" onchange="" required>
                                            <option value="First select a Main Category">First select a Main Category</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Brand</td>
                                    <td style="text-align: left"><input type="text" id="post_brand" name="post_brand" value="enter here" required></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Description</td>
                                    <td style="text-align: left"><input type="text" id="post_description" name="post_description" value="enter here" required></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Qty</td>
                                    <td style="text-align: left"><input type="number" id="post_qty" name="post_qty" value="0" required></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Price</td>
                                    <td style="text-align: left"><input type="number" step="0.1" id="post_price" name="post_price" value="0.00" placeholder="0.00" required></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Image</td>
                                    <td style="text-align: left"><input type="file" name="post_image" id="prof_image"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left"><button type="submit" class="btn btn-primary" style="width:200px">Create Post</button></td>
                                    <td></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
