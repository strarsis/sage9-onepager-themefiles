{{--
 * Template part for displaying pages on front page
--}}
@php global $onepagercounter; @endphp

{{-- (alternatively $onepagercounter as ID) --}}
<article id="{{ $post->post_name }}" {!! post_class( 'onepager-panel ' ) !!} >
  <div class="panel-content">
    @php \strarsis\Sage9Onepager\Controls::edit_link( get_the_ID() ) @endphp

    @include('partials.page-header')
    @include('partials.content-page')
  </div><!-- .panel-content -->
</article><!-- #post-## -->
