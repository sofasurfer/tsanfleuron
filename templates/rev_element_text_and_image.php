<div class="c-container c-text-img-2col-symmetric">
    <div class="c-row">
        <div class="c-col-6">
            <figure>
                <?php $imageid = $site_element['image']; ?>
                <?= do_shortcode("[render_imagetag id=\"$imageid\"]"); ?>
            </figure>
        </div>
        <div class="c-col-6">
            <?= $site_element['text']; ?>
        </div>
    </div>
</div>