<?php

entre_mikado_get_single_post_format_html($blog_single_type);

do_action('entre_mikado_after_article_content');

entre_mikado_get_module_template_part('templates/parts/single/author-info', 'blog');

entre_mikado_get_module_template_part('templates/parts/single/single-navigation', 'blog');

entre_mikado_get_module_template_part('templates/parts/single/related-posts', 'blog', '', $single_info_params);

entre_mikado_get_module_template_part('templates/parts/single/comments', 'blog');