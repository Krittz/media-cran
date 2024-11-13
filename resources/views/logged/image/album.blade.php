@extends('logged.home')
@section('title', 'Album')

@section('content')
@section('title-section', 'Album')
@section('section-type', 'Images')
@section('section-active', 'Albums')


<div class="wrapper">
    <div class="all-data">
        <div class="orders">
            <div class="header">
                <div class="header-left">
                    <i class="ph ph-images"></i>
                    <h3>Albums</h3>
                </div>
                <div class="header-right">
                    <form action="#">
                        <input type="search" name="search" id="search_album" placeholder="Search album">
                        <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
                    </form>
                    <i class="ph ph-funnel"></i>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th><i class="ph ph-funnel-simple"></i></th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Files</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td class="item-actions">
                            <i class="ph ph-dots-three-vertical"></i>
                            <div class="item-options">
                                <a href="#"><i class="ph ph-stack-plus"></i> Add image</a>
                                <a href="#"><i class="ph ph-stack-minus"></i> Remove image</a>
                                <a href="#"><i class="ph ph-trash"></i> Delete</a>
                            </div>
                        </td>
                        <td>
                            <p>
                                Album name
                            </p>
                        </td>
                        <td>
                            Date
                        </td>
                        <td>
                            <p>
                                Files
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection