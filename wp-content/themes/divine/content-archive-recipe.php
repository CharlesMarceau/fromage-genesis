<?php

echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
the_post_thumbnail('thumbnail');
the_excerpt();