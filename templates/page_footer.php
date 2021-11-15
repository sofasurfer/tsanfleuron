

    </main>

    <!-- footer-->
    <footer class="c-footer" role="contentinfo">
        <div class="c-container c-footer-main">
            <div class="c-row">
                <div class="c-col-6 ">
                    <?= apply_filters('c_get_option','company_slogan'); ?><br/>
                    <div class="c-footer-line c-line">
                        <?= apply_filters('c_get_option','company_address'); ?>
                        <a href="mailto:<?= apply_filters('c_get_option','company_email'); ?>"><?= apply_filters('c_get_option','company_email'); ?></a></br>
                        <a href="tel:<?= apply_filters('c_get_option','company_phone'); ?>"><?= apply_filters('c_get_option','company_phone'); ?></a>
                    </div>
                </div>
                <div class="c-col-6 c-col-right">
                    <?= do_shortcode("[c_socialmedia_list]"); ?>
                </div>
            </div>
        </div>
        
        <div class="c-container c-container-no-padding c-footer-disclaimer">
            <div class="c-row c-row-reverse">
                <div class="c-col-6 c-text-right">
                    <?php wp_nav_menu( 
                        array( 
                            'theme_location'    => 'footer-menu',
                            'container'         => false,
                            'menu_class'        => 'c-footer-disclaimer-list',
                        )
                    ); ?>
                </div>
                <div class="c-col-6">
                    <?= __('&copy; tsanfleuron','ruffener');?>
                </div>                  

            </div>
        </div>
    </footer>


    <script type="text/javascript">
    var templateUrl = '<?= get_bloginfo("template_url"); ?>';
    /* <![CDATA[ */
    var myAjax = {"ajaxurl":"<?=  str_replace("/", "\/", admin_url('admin-ajax.php') ); ?>"};
    /* ]]> */
    </script>

    <script src="<?= get_stylesheet_directory_uri(); ?>/dist/assets/js/minimal.1.min.js?v=<?= do_shortcode('[wp_version]') ;?>"></script>


    <!-- Matomo -->
    <script>
      var _paq = window._paq = window._paq || [];
      /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
      _paq.push(["setCookieDomain", "*.tsanfleuron.com"]);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="//piwik.sofasurfer.org/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '45']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <noscript><p><img src="//piwik.sofasurfer.org/matomo.php?idsite=45&amp;rec=1" style="border:0;" alt="" /></p></noscript>
    <!-- End Matomo Code -->



</body>
</html>