

    </main>

    <!-- footer-->
    <footer class="c-footer" role="contentinfo">
        <div class="c-container c-footer-main">
            <div class="c-row">
                <div class="c-col-4 ">
                    <?= apply_filters('c_get_option','company_slogan'); ?><br/>
                    <div class="c-footer-line c-line">
                        <?= apply_filters('c_get_option','company_address'); ?>
                        <a href="mailto:<?= apply_filters('c_get_option','company_email'); ?>"><?= apply_filters('c_get_option','company_email'); ?></a></br>
                        <a href="tel:<?= apply_filters('c_get_option','company_phone'); ?>"><?= apply_filters('c_get_option','company_phone'); ?></a>
                    </div>
                    
                    

                </div>
                <!--div class="c-col-3">
                    <?php wp_nav_menu( 
                        array( 
                            'theme_location'    => 'header-menu',
                            'container'         => false,
                            'menu_class'        => 'c-footer-nav-list',
                        )
                    ); ?>                    
                </div-->                  
                <div class="c-col-4">

                </div>
                <div class="c-col-4" style="text-align:right;">
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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157866086-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-157866086-1');
    </script>

</body>
</html>