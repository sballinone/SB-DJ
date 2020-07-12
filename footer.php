<div id='footer'>

    <?php

    if($footernav) 
        echo "<small><a href='index.php'>FE</a> · <a href='backend.php'>BE</a></small>";

    if($showrelease)
        echo "<small>v".$release."</small>";
    
    if($credits) 
        echo "<small>SB DJ · Written by Saskia Brückner · <a href='https://saskiabrueckner.com' target='_blank'>saskiabrueckner.com</a></small>";
    
    ?>

</div>
