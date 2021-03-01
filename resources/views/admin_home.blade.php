<!-- admin_home.blade.php -->

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

                <!-- Tabs Define-->
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'User')" id="defaultOpen"><b>User Admin</b></button>
                    <button class="tablinks" onclick="openTab(event, 'Profile')"><b>Profile Admin</b></button>
                    <button class="tablinks" onclick="openTab(event, 'Post')"><b>Post Admin</b></button>
                    <button class="tablinks" onclick="openTab(event, 'Create_Cat')"><b>Category Admin</b></button>
                </div>

                <!-- User Admin Tab -->
                <div id="User" class="tabcontent">
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($users as $Userkey => $user)
                                <!-- ME=>, do not allow admin to chnage it own role. -->
                                @if($user->id != Auth::user()->id)
                                <tr>
                                    <form action="{{ route('home.postEdit') }}" enctype="multipart/form-data" method="POST">
                                        <td>
                                            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
                                            {{$user->name}}
                                            <input type="hidden" id="user_name" name="user_name" value="{{$user->name}}">
                                        </td>
                                        <td>
                                            {{$user->email}}
                                            <input type="hidden" id="user_email" name="user_email" value="{{$user->email}}">
                                        </td>
                                        <td>
                                            <select name="user_role" id="user_role" required>
                                                <option value="" selected disabled hidden>{{$user->role}}</option>
                                                <option value="admin">Admin</option>
                                                <option value="shop">Shop</option>
                                                <option value="NULL">Guest</option>
                                            </select>
                                        </td>
                                        <td>
                                            @csrf
                                            <button type="submit" class="far fa-edit btnEdit"></button>
                                        </td>
                                    </form>
                                    <td>
                                        <form action="{{ route('home.destroy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
                                            <button type="submit" class="far fa-trash-alt btnDelete"></button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Profile Admin Tab -->
                <div id="Profile" class="tabcontent">
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Postcode</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th colspan = "2">Image</th>
                                <th></th>
                            </tr>
                            @foreach($profiles as $Profilekey => $profile)
                                <!-- ME=>, do not allow admin to chnage it profile here. -->
                                @if($profile->user_id != Auth::user()->id)
                                <tr>
                                    @foreach($users as $Userkey => $user)
                                        @if($user->id == $profile->user_id)
                                            <td>{{$user->name}}</td>
                                        @endif
                                    @endforeach
                                    <form action="{{ route('profile.postEdit') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                        <td><input type="text" id="prof_name" name="prof_name" value="{{$profile->name}}" required></td>
                                        <td><input type="text" id="prof_address" name="prof_address" value="{{$profile->address}}" required></td>
                                        <td><input type="text" id="prof_postcode" name="prof_postcode" value="{{$profile->postcode}}" required></td>
                                        <td><input type="text" id="prof_email" name="prof_email" value="{{$profile->email}}" required></td>
                                        <td><input type="text" id="prof_website" name="prof_website" value="{{$profile->website}}" required></td>
                                        <td>
                                            <!-- => ME, for modal image -->
                                            @php ($myModal = "myModal_Profile" . $Profilekey)
                                            @php ($myImg = "myImg_Profile" . $Profilekey)
                                            @php ($img01 = "img01_Profile" . $Profilekey)
                                            @php ($mySpan = "mySpan_Profile" . $Profilekey)
                                            @php ($myCaption = "myCaption_Profile" . $Profilekey)
                                            <img id='{{ $myImg }}' src='/storage/{{ $profile->image }}' alt='{{ $profile->name }}' height='50' width='50' onload="onloadImageModal('{{ $myModal }}', '{{ $myImg }}', '{{ $img01 }}', '{{ $mySpan }}', '{{ $myCaption }}')">
                                            <div id='{{ $myModal }}' class='modal'>
                                                <span id='{{ $mySpan }}' class='close'>&times</span>
                                                <img class='modal-content' id='{{ $img01 }}'>
                                                <div id='{{ $myCaption }}'></div>
                                            </div>
                                            <!-- => ME, for modal image -->
                                        </td>
                                        <td><input type="file" name="prof_image" id="prof_image"></td>
                                        <td>
                                            <input type="hidden" id="prof_id" name="prof_id" value="{{$profile->id}}">
                                            <button type="submit" class="far fa-edit btnEdit"></button>
                                        </td>
                                    </form>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Post Admin Tab -->
                <div id="Post" class="tabcontent">
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>User Name</th>
                                <th>Name</th>
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
                            <tr>
                                <!-- ME=> Get user's name from user table -->
                                @foreach($users as $Userkey => $userID)
                                    @if($userID->id == $post->user_id)
                                        <td>{{$userID->name}}</td>
                                    @endif
                                @endforeach
                                <form action="{{ route('post.update',$post->id) }}" method="POST">
                                    @foreach($profiles as $Profilekey => $profile)
                                        @if($post->user_id == $profile->user_id)
                                            <td>{{$profile->name}}</td>
                                        @endif
                                    @endforeach
                                    <td>
                                        {{$post->main_cat}}<input type="hidden" id="post_main_cat" name="post_main_cat" value="{{$post->main_cat}}">
                                    </td>
                                    <td>
                                        {{$post->subcat_1}}<input type="hidden" id="post_subcat_1" name="post_subcat_1" value="{{$post->subcat_1}}">
                                    </td>
                                    
                                    <!-- ME=> no show if created by Admin -->
                                    @if(!empty($post->description))
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
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <!-- ME=> disable as this is set for catergory create -->
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
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Category Admin Tab -->
                <div id="Create_Cat" class="tabcontent">
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>Main Category</th>
                                <th>Sub Category</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <form action="{{ route('category.store') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <tr>
                                    <td><input type="text" id="category_main_cat" name="category_main_cat" value="" required></td>
                                    <td><input type="text" id="category_subcat_1" name="category_subcat_1" value="" required></td>
                                    <td><button type="submit" class="far fa-plus-square btnCreate"></button></td>
                                    <td style="font-size:14px">Create a new main and sub category.</td>
                            </tr>
                            </form>
                        </table>
                    </div>
                    <div class="tableScroll">
                        <table>
                            <tr>
                                <th>User Name</th>
                                <th>Main Category</th>
                                <th>Sub Category</th>
                                <th></th>
                            </tr>
                            @foreach($categories as $Categorykey => $category)
                            <tr>
                                @foreach($users as $Userkey => $userID)
                                    @if($userID->id == $category->user_id)
                                        <td>{{$userID->name}}</td>
                                    @endif
                                @endforeach
                                <td>{{$category->main_cat}}</td>
                                <td>{{$category->subcat_1}}</td>
                                <td>
                                    <form action="{{ route('category.destroy',$category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="far fa-trash-alt btnDelete"></button>
                                    </form>                                       
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
