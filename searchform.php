<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Type Keywords &hellip;', 'placeholder', 'philosophy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr( 'Search for:', 'philosophy' ); ?>" autocomplete="off">
    </label>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'philosophy' ); ?>">
</form>