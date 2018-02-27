{{-- https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentyseventeen/front-page.php --}}
{{-- Get each of our panels and show the post data. --}}
@if( 0 !== \strarsis\Sage9Onepager\Controls::panel_count() || is_customize_preview() ) {{-- If we have pages to show. --}}
    {{--
     * Filter number of front page sections in Twenty Seventeen.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param int $num_sections Number of front page sections.
     --}}
    @php
      $num_sections = apply_filters( 'onepager_front_page_sections', 4 );
      global $onepagercounter;
    @endphp
    {{-- Create a setting and control for each of the sections available in the theme. --}}
    @for ( $i = 1; $i < ( 1 + $num_sections ); $i++ )
      @php $onepagercounter = $i; @endphp
      {!! \strarsis\Sage9Onepager\Controls::front_page_section( null, $i ) !!}
    @endfor
@endif {{-- The if ( 0 !== onepager_panel_count() ) ends here. --}}
