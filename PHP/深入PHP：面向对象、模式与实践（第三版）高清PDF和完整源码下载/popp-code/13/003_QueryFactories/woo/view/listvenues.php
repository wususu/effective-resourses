<?php 
require_once( "woo/view/ViewHelper.php" );
$request = \woo\view\VH::getRequest();
$venues = $request->getObject('venues');
?>

<html>
<head>
<title>Here are the venues</title>
</head>
<body>

<table>
<tr>
<td>
<?php print $request->getFeedbackString("</td></tr><tr><td>"); ?>
</td>
</tr>
</table>
<?php
foreach( $venues as $venue ) {
    print "{$venue->getName()}<br />\n";
    foreach( $venue->getSpaces() as $space ) {
        print "&nbsp;  {$space->getName()}<br />\n";
        foreach ( $space->getEvents() as $event ) {
            print "&nbsp;&nbsp;{$event->getName()}\n";
        }
    }
}
?>

</body>
</html>
