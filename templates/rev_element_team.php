<!-- text only, für rechts alinierung c-row-justify-right einfügen, siehe beispiel-->
<div class="c-container c-text-only">
    <div class="c-row">
        <div class="c-col-8 c-text-block">
            <ul class="c-team-list animation">
                <?php foreach($site_element['team_members'] as $member): ?>
                    <li>
                        <figure><img src="<?= get_the_post_thumbnail_url($member);?>" /></figure>
                        <div class="text">
                        <h4><?= get_the_title($member); ?></h4>
                        <p><?= get_the_excerpt($member); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>      
        </div>
        <div class="c-col-4">
            <p>
            <?= apply_filters('c_get_option','company_address'); ?>
            <a href="mailto:<?= apply_filters('c_get_option','company_email'); ?>"><?= apply_filters('c_get_option','company_email'); ?></a></br>
            <a href="tel:<?= apply_filters('c_get_option','company_phone'); ?>"><?= apply_filters('c_get_option','company_phone'); ?></a>
            </p>
            <h4 style="margin-top:2rem;"><?= __('Öffnungszeiten','ruffener');?></h4>
            <?= apply_filters('c_get_option','opening_hours'); ?>
        </div>
    </div>
</div>