<?php
require 'db.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die('Unable to connect. Check your connection parameters.');

$action = 'Add';
$character = array(
    'alias' => '',
    'real_name' => '',
    'alignment' => 'good',
    'address' => '',
    'city' => '',
    'state' => '',
    'zipcode_id' => ''
);
$character_powers = array();
$rivalries = array();

// validate incoming character id value
$character_id = (isset($_GET['id']) && ctype_digit($_GET['id'])) ? $_GET['id'] : 0;

// retrieve information about the requested character
if ($character_id != 0) {
    $query = 'SELECT c.alias, c.real_name, c.alignment, l.address, z.city, z.state, z.zipcode_id 
              FROM comic_character c, comic_lair l, comic_zipcode z 
              WHERE z.zipcode_id = l.zipcode_id 
                AND c.lair_id = l.lair_id 
                AND c.character_id = ' . $character_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if (mysqli_num_rows($result) > 0) {
        $action = 'Edit';
        $character = mysqli_fetch_assoc($result);
    }
    mysqli_free_result($result);
    
    if ($action == 'Edit') {
        // get list of character's powers
        $query = 'SELECT power_id FROM comic_character_power WHERE character_id = ' . $character_id;
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $character_powers[$row['power_id']] = true;
            }
        }
        mysqli_free_result($result);
        
        // get list of character's rivalries
        $query = 'SELECT c2.character_id FROM comic_character c1 
                  JOIN comic_character c2 
                  JOIN comic_rivalry r ON (c1.character_id = r.hero_id AND c2.character_id = r.villain_id) 
                                       OR (c2.character_id = r.hero_id AND c1.character_id = r.villain_id) 
                  WHERE c1.character_id = ' . $character_id . ' 
                  ORDER BY c2.alias ASC';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        
        $rivalries = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $rivalries[$row['character_id']] = true;
            }
        }
        mysqli_free_result($result);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $action; ?> Character</title>
    <style type="text/css">
        td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" alt="Comic Book Appreciation Site" style="float: left;" />
    <h1>Comic Book<br/>Appreciation</h1>
    <h2><?php echo $action; ?> Character</h2>
    <hr style="clear: both;" />
    
    <form action="char_transaction.php" method="post">
        <table>
            <tr>
                <td>Character Name:</td>
                <td>
                    <input type="text" name="alias" size="40" maxlength="40" value="<?php echo $character['alias']; ?>">
                </td>
            </tr>
            <tr>
                <td>Real Name:</td>
                <td>
                    <input type="text" name="real_name" size="40" maxlength="80" value="<?php echo $character['real_name']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Powers:<br/>
                    <small><em>CTRL-click to select multiple powers</em></small>
                </td>
                <td>
                    <?php
                    // retrieve and present the list of powers
                    $query = 'SELECT power_id, power FROM comic_power ORDER BY power ASC';
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));
                    
                    if (mysqli_num_rows($result) > 0) {
                        echo '<select multiple name="powers[]">';
                        while ($row = mysqli_fetch_array($result)) {
                            if (isset($character_powers[$row['power_id']])) {
                                echo '<option value="' . $row['power_id'] . '" selected="selected">';
                            } else {
                                echo '<option value="' . $row['power_id'] . '">';
                            }
                            echo $row['power'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo '<p><strong>No Powers entered...</strong></p>';
                    }
                    mysqli_free_result($result);
                    ?>
                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    Lair Location:<br/>
                    <small><em>Address<br/>City, State, Zip Code</em></small>
                </td>
                <td>
                    <input type="text" name="address" size="40" maxlength="40" value="<?php echo $character['address']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="city" size="23" maxlength="40" value="<?php echo $character['city']; ?>">
                    <input type="text" name="state" size="2" maxlength="2" value="<?php echo $character['state']; ?>">
                    <input type="text" name="zipcode_id" size="5" maxlength="5" value="<?php echo $character['zipcode_id']; ?>">
                </td>
            </tr>
            <tr>
                <td>Alignment:</td>
                <td>
                    <input type="radio" name="alignment" value="good" <?php echo ($character['alignment'] == 'good') ? 'checked="checked"' : ''; ?>> Good<br/>
                    <input type="radio" name="alignment" value="evil" <?php echo ($character['alignment'] == 'evil') ? 'checked="checked"' : ''; ?>> Evil
                </td>
            </tr>
            <tr>
                <td>
                    Rivalries:<br/>
                    <small><em>CTRL-click to select multiple enemies</em></small>
                </td>
                <td>
                    <?php
                    // retrieve and present the list of existing characters (excluding the character being edited)
                    $query = 'SELECT character_id, alias FROM comic_character WHERE character_id != ' . $character_id . ' ORDER BY alias ASC';
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));
                    
                    if (mysqli_num_rows($result) > 0) {
                        echo '<select multiple name="rivalries[]">';
                        while ($row = mysqli_fetch_array($result)) {
                            if (isset($rivalries[$row['character_id']])) {
                                echo '<option value="' . $row['character_id'] . '" selected="selected">';
                            } else {
                                echo '<option value="' . $row['character_id'] . '">';
                            }
                            echo $row['alias'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo '<p><strong>No Characters entered...</strong></p>';
                    }
                    mysqli_free_result($result);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="action" value="<?php echo $action; ?> Character" />
                    <input type="reset" value="Reset">
                    <?php
                    if ($action == "Edit") {
                        echo '<input type="submit" name="action" value="Delete Character" />';
                        echo '<input type="hidden" name="character_id" value="' . $character_id . '" />';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>
    
    <p><a href="list_characters.php">Return to Home Page</a></p>
</body>
</html>