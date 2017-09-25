<?php 
require_once( "woo/view/ViewHelper.php" );
$request = \woo\view\VH::getRequest();
?>

<html>
<head>
<title>Woo! it's WOO!</title>
</head>
<body>

<table>
<tr>
<td>
<?php print $request->getFeedbackString("</td></tr><tr><td>"); ?>
</td>
</tr>
</table>

</body>
</html>
