<article class="post-preview post-preview-id-<?php the_ID(); ?>">
    <figure class="post-preview__thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'medium' ); ?>
        </a>
    </figure>
    <div class="post-preview__caption">
        <div class="post-preview__meta">
            <div class="post-preview__author post-author-card">
                <figure class="post-author-card__avatar-wrap">
                    <img src="<?php echo get_avatar_url( $post->post_author ); ?>" alt="" class="post-author-card__avatar">
                </figure>
                <div class="post-author-card__meta">
                    <div class="post-author-card__name">
                        <?php echo get_the_author_meta( 'user_firstname', $post->post_author ); ?>
                    </div>
                </div>
            </div>
            <div class="post-preview__date">
                <?php echo get_the_date( 'd.m.Y', get_the_ID() ); ?>
            </div>
        </div>
        <h5 class="post-preview__title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h5>
        <div class="post-preview__actions">
            <div class="post-social-data">
                <div class="post-social-data__indicators">
                    <a href="<?php the_permalink(); ?>" class="social-data-indicator social-data-indicator--likes">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" class="social-data-indicator__icon">
                            <path fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1"
                                d="M11.995 7.23319C10.5455 5.60999 8.12832 5.17335 6.31215 6.65972C4.49599 8.14609 4.2403 10.6312 5.66654 12.3892L11.995 18.25L18.3235 12.3892C19.7498 10.6312 19.5253 8.13046 17.6779 6.65972C15.8305 5.18899 13.4446 5.60999 11.995 7.23319Z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="social-data-indicator__value">25</span>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="social-data-indicator social-data-indicator--comments">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" class="social-data-indicator__icon">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1"
                                d="M4.75 6.75C4.75 5.64543 5.64543 4.75 6.75 4.75H17.25C18.3546 4.75 19.25 5.64543 19.25 6.75V14.25C19.25 15.3546 18.3546 16.25 17.25 16.25H14.625L12 19.25L9.375 16.25H6.75C5.64543 16.25 4.75 15.3546 4.75 14.25V6.75Z">
                            </path>
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.5 11C9.5 11.2761 9.27614 11.5 9 11.5C8.72386 11.5 8.5 11.2761 8.5 11C8.5 10.7239 8.72386 10.5 9 10.5C9.27614 10.5 9.5 10.7239 9.5 11Z">
                            </path>
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12.5 11C12.5 11.2761 12.2761 11.5 12 11.5C11.7239 11.5 11.5 11.2761 11.5 11C11.5 10.7239 11.7239 10.5 12 10.5C12.2761 10.5 12.5 10.7239 12.5 11Z">
                            </path>
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.5 11C15.5 11.2761 15.2761 11.5 15 11.5C14.7239 11.5 14.5 11.2761 14.5 11C14.5 10.7239 14.7239 10.5 15 10.5C15.2761 10.5 15.5 10.7239 15.5 11Z">
                            </path>
                        </svg>
                        <span class="social-data-indicator__value">10</span>
                    </a>
                </div>
                <div class="post-social-data__share">
                    <button class="post-share-btn" data-post-id="<?php the_ID(); ?>" data-post-link="<?php the_permalink(); ?>" title="Поделиться" type="button">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1"
                                d="M4.75 14.75V16.25C4.75 17.9069 6.09315 19.25 7.75 19.25H16.25C17.9069 19.25 19.25 17.9069 19.25 16.25V14.75">
                            </path>
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1" d="M12 14.25L12 5"></path>
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1"
                                d="M8.75 8.25L12 4.75L15.25 8.25"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>