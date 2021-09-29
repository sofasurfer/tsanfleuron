<!-- text only, für rechts alinierung c-row-justify-right einfügen, siehe beispiel-->
<div class="c-container c-text-only">
    <div class="c-row">
        <div class="c-col-12 c-text-block">
            <h3 class="animation <?= ($site_element['small']) ? 'c-category-title' : ''; ?>"><?= $site_element['title']; ?></h3>
            <?= $site_element['description']; ?>
            <ul class="c-partner-list animation">
                <?php foreach($site_element['partners'] as $partner): ?>
                    <li>
                        <?php 
                        $imageid = get_post_thumbnail_id($partner);
                        $imagetitle = get_the_title($partner);
                        ?>
                        <?php if(empty(get_field('webseite',$partner))): ?>
                        <?= do_shortcode("[render_imagetag id=\"$imageid\" alt=\"$imagetitle\"]"); ?>
                        <?php else: ?>
                        <a href="<?= get_field('webseite',$partner);?>" title="<?= $imagetitle; ?>" target="_blank"><?= do_shortcode("[render_imagetag id=\"$imageid\" alt=\"$imagetitle\"]"); ?></a>
                        <?php endif; ?>              
                    </li>
                <?php endforeach; ?>
            </ul>      
        </div>
    </div>
</div>