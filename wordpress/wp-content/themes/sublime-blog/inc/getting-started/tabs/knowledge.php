<?php 

$knowledgebase = [
    'review' => [
        'icon'        => 'icon-st-donate-heart',
        'title'       => sprintf( __( 'Review %s', 'sublime-blog' ), SUBLIME_BLOG_NAME ),
        'subtitle'    => __( 'It makes us happy to hear from our users. We would appreciate a review.', 'sublime-blog' ),
        'buttonlabel' => __( 'Submit a Review', 'sublime-blog' ),
        'buttonlink'  => 'https://wordpress.org/support/theme/' . SUBLIME_BLOG_TEXTDOMAIN . '/reviews/',
    ],
    'knowledge-base' => [
        'icon'        => 'icon-st-bookmark',
        'title'       => __( 'Knowledge base', 'sublime-blog' ),
        'subtitle'    => __( 'Need help with using the WordPress as quickly as possible? Visit our well-organized Knowledge Base!', 'sublime-blog' ),
        'buttonlabel' => __( 'Visit Knowledge Base', 'sublime-blog' ),
        'buttonlink'  => 'https://sublimetheme.com/docs/' . SUBLIME_BLOG_TEXTDOMAIN . '/',
    ],
    'support' => [
        'icon'        => 'icon-st-headphone',
        'title'       => __( 'Support', 'sublime-blog' ),
        'subtitle'    => __( 'Got a question or need some help with the theme? You can always submit a support ticket, and our team will help you out.', 'sublime-blog' ),
        'buttonlabel' => __( 'Contact Support', 'sublime-blog' ),
        'buttonlink'  => 'https://sublimetheme.com/support/',
    ],
];

if( $knowledgebase ){ ?>
    <div class="st-gs-grid">
        <?php foreach( $knowledgebase as $knowledge ){ ?>
            <div class="st-gs-col">
                <h4 class="st-gs-col-title">
                    <span class="<?php echo esc_attr( $knowledge['icon'] ); ?>"></span>
                    <?php echo esc_html( $knowledge['title'] ); ?>
                </h4>
                <div class="st-gs-col-content">
                    <div class="st-gs-desc"><?php echo wp_kses_post( $knowledge['subtitle'] ); ?></div>
                    <a href="<?php echo esc_url( $knowledge['buttonlink'] ); ?>" target="_blank" class="st-gs-btn-transparent">
                        <?php echo esc_html( $knowledge['buttonlabel'] ); ?>
                        <span class="icon-st-arrow-right"></span>	
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
}