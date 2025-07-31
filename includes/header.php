<?php
// para lumabas yung mga notification
// pakipalitan nalang yung class="message" ng design mo talaga 
// pwede mo rin palitan design ng span
// ty lang
if (isset($_SESSION['messages'])) 
{
    echo '<div class="message-container">'; // optional to pero pwede mo siya iwrap sa container
    foreach ($_SESSION['messages'] as $msg) 
    {
        echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span></div>';
    }
    echo '</div>';
    unset($_SESSION['messages']);
}
?>

<!-- header naman to, no need for html doctype ;) -->
<!-- gawin mo dito parang ganto. example lang to di need gayahin-->

<!-- <header class="header"> -->
    <!--  <section class="flex"> -->