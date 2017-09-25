<?php
    $venue_name = $_REQUEST['venue_name'];
    $space_name = $_REQUEST['space_name'];
?>
<html>
<head>
<title>Here are the venues</title>
</head>
<body>

<h1>Here are the venues</h1>

<table>
<tr>
<td>
space '<?php print $space_name ?>' added (47)</td>
</tr>
<td>
<?php print $venue_name ?><br />
&nbsp;  <?php print $space_name ?><br />
</td>
<tr>
</tr>
</table>
</body>
</html>
