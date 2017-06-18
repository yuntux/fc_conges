                        <div id="pied_page">
                        </div>
                </div>

                <script src="view/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
                <script src="view/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
                <script>
                   (function() {
                        $(".widget_calendar").datepicker({
                                        dateFormat: "yy-mm-dd"
                                }); 
                   })();
                /*
                   (function() {
                        $(".nbr").number(true, 2);
                   })();
                */
                </script>
        </body>
<?php $_SESSION['erreur'] = 0;?>
<?php $indice = 0 ;?>
</html>
