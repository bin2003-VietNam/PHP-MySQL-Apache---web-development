<?php
require 'db.inc.php';
require 'cms_output_functions.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) 
    or die('Unable to connect. Check your connection parameters.');

include 'cms_header.inc.php';

$sql = "SELECT article_id FROM cms_articles WHERE is_published = TRUE ORDER BY publish_date DESC";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) == 0) {
    echo '<p><strong>There are currently no articles to view.</strong></p>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        output_story($db, $row['article_id'], true);
    }
}

mysqli_free_result($result);
include 'cms_footer.inc.php';
?>
