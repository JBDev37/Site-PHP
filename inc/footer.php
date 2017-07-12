
    <div class="site-cache" id="site-cache"></div>
    </div> <!--  site-pusher -->
    </div><!--  site-container -->

    <script>
        (function($){
            $('#icon').click(function(e){
                e.preventDefault();
                $('body').toggleClass('width--sidebar');
            });
            $('#site-cache').click(function(e){
                $('body').removeClass('width--sidebar');
            });
        })(jQuery);
    </script>
  </body>

</html>