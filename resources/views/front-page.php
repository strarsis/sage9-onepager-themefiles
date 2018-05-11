@php
  $frontpage_id   = get_option( 'page_on_front' );
  $frontpage_slug = get_post_field( 'post_name', $frontpage_id );
@endphp
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <div id="{{ $frontpage_slug }}" {!! post_class( 'onepager-panel home ' ) !!}>
      @include('partials.page-header')
      @include('partials.content-page')
    </div>

    @include('partials.panels')
  @endwhile
@endsection
