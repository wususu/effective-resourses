<?php
$venue_name = null;
if ( isset( $_REQUEST['venue_name'] ) ) {
    $venue_name = $_REQUEST['venue_name'];
}
?>
<html>
<head>
<title> Add a Venue </title>
</head>
<body>
<?php if ( is_null( $venue_name ) ) { ?>
<table>
<tr>
<td>
no name provided</td>
</tr>
</table>

<form method="post">

    <input type="text" value="" name="venue_name" />
    <input type="submit" value="submit" />
</form>
<?php } else { ?>
<h1>Add a Space for Venue '<?php print $venue_name ?>'</h1>

<table>
<tr>
<td>
'<?php print $venue_name ?>' added (22)</td></tr><tr><td>please add name for the space</td>
</tr>

</table>
[add space]
<form method="post">
    <input type="text" value="" name="space_name"/>
    <input type="hidden" name="cmd" value="AddSpace" />
    <input type="hidden" name="venue_id" value="22" />
    <input type="hidden" name="venue_name" value="<?php print $venue_name ?>" />
    <input type="submit" value="submit" />
</form>
<?php } ?>

</body>
</html>
