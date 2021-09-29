<!-- quote -->
<div class="c-container c-quote <?= ($site_element['show_lines']) ? 'c-quote-line' : ''; ?> ">
    <?php if($site_element['show_lines']): ?>
        <hr class="c-separator-line" />
    <?php endif; ?>
    <div class="c-row c-row-justify-center animation-element fade-up">
        <div class="c-col-10 c-text-block animation">
            <blockquote>
                <p><?= $site_element['text']; ?></p>
                <cite class="c-text-small"><?= $site_element['author']; ?></cite>
            </blockquote>
        </div>
    </div>
    <?php if($site_element['show_lines']): ?>
        <hr class="c-separator-line" />
    <?php endif; ?>    
</div>