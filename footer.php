<div class='row' id='footer'>
    <div class="box">

        <?php

        if($footernav) 
            echo "<small><a href='index.php'>FE</a> <a href='backend.php'>BE</a></small>";
        
        if($credits) 
            echo "<small><strong>SB DJ</strong> · By Saskia Brückner</small><small><a href='https://saskiabrueckner.com' target='_blank'>saskiabrueckner.com</a></small>";

        if($showrelease)
            echo "<small>v".$release."</small>";
        
        ?>
    
    </div>

</div>
