<div class='row' id='footer'>
    <div class="box">

        <?php

        if ($footernav) {
            echo "<small><a href='index.php'>FE</a> <a href='backend.php'>BE</a></small>";
        }
        
        if ($credits) {
            echo "<small><strong>SB DJ</strong> · By Saskia Brückner</small><small><a href='https://saskiabrueckner.com' target='_blank'>saskiabrueckner.com</a></small>";
        }

        if ($showrelease) {
            echo "<small><a href='https://github.com/sballinone/SB-DJ' target='_blank'><i class='icofont-github'></i></a> v".$release."</small>";
        }
        
        if ($showlang) {
            echo "<small>";
            $data = scandir("./lang");

            foreach ($data as $language) {
                if ($language != "." && $language != "..") {
                    
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
        }
        ?>
    
    </div>

</div>