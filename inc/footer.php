<div class='row' id='footer'>
    <div class="box" style="text-align: left;">

        <?php
        
        if ($showlang) {
            echo "<small>";
            $data = scandir("./lang");

            foreach ($data as $language) {
                if ($language != "." && $language != ".." && $language != ".DS_Store") {
                    
                    $langcode = substr($language, 0, 2);

                    if ($language == $_SESSION['lang']) {
                        echo "<strong>";
                    }
                    
                    echo "<a href='?lang=".$language."'>".ucwords($langcode)."</a>";
                    
                    if ($language == $_SESSION['lang']) {
                        echo "</strong>";
                    }

                }
            }
            echo "</small> ";
        }

        echo "<small>";

        if ($footernav) {
            echo "<a href='index.php'>Frontend</a> <a href='backend.php'>Backend</a> ";
        }

        if ($showrelease && isset($_SESSION['backend'])) {
            echo "<a href='https://github.com/sballinone/SB-DJ' target='_blank'><i class='icofont-github'></i></a> v".$release;
        }

        echo "</small><br />";

        if ($credits) {
            echo "<small><strong>SB DJ</strong> · By Saskia Brückner · <a href='https://saskiabrueckner.com' target='_blank' style='border: 0; padding: 0;'>SaskiaBrueckner.com</a></small> ";
        }
        ?>
    
    </div>

</div>