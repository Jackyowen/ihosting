<?php if($accordions): ?>
    <div class="tab-conten-accordion">
        <div class="ts-acordion ts-acordion-data wow <?php echo esc_attr($atts['css_animation']); ?>" data-icon-header="fa-chevron-circle-down" data-active="fa-minus" data-tab="1" data-wow-delay="<?php echo esc_attr($atts['animation_delay']); ?>">
            <?php foreach ($accordions as $i => $item){?>
                <h3 class="toggle-head"><?php echo esc_attr($item['title']) ?></h3>
                <div class="acordion-content">
                    <div class="acc-inner-content">
                        <?php echo esc_attr($item['description']) ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif; wp_reset_postdata();?>