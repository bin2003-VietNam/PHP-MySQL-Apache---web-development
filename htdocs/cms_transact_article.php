 <?php
 require_once 'db.inc.php';
 require_once 'cms_http_functions.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');
                                      
if (isset($_REQUEST['action'])) {
                   
    switch ($_REQUEST['action']) {
    case 'Submit New Article':
        $title = (isset($_POST['title'])) ? $_POST['title'] : '';
        $article_text = (isset($_POST['article_text'])) ? $_POST['article_text'] : '';
        if (isset($_SESSION['user_id'])  &&  !empty($title)  && 
            !empty($article_text)) {
            $sql = 'INSERT INTO cms_articles
                    (user_id, submit_date, title, article_text)
                    VALUES
                        (' . $_SESSION['user_id'] . ', 
                        “' . date('Y-m-d H:i:s') . '”,
                        “' . mysqli_real_escape_string($title, $db) . '”,
                        “' . mysqli_real_escape_string($article_text, $db) . '”)';
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
        redirect('cms_index.php');
        break;
                   
    case 'Edit':
        redirect('cms_compose.php?action=edit & article_id=' . 
$_POST['article_id']);
        break;
                   
    case 'Save Changes':
        $article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
        $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
        $title = (isset($_POST['title'])) ? $_POST['title'] : '';
        $article_text = (isset($_POST['article_text'])) ? $_POST['article_text'] : '';
        if (!empty($article_id)  &&  !empty($title)  &&  !empty($article_text)) {
            $sql = 'UPDATE cms_articles SET 
                    title = “' . mysqli_real_escape_string($title, $db) . '”,
                    article_text = “' . mysqli_real_escape_string($article_text,
                        $db) . '”,
                    submit_date = “' . date('Y-m-d H:i:s') . '”
                WHERE
                    article_id = ' . $article_id;
            if (!empty($user_id)) {
                $sql .= ' AND user_id = ' . $user_id;
            }
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
        if (empty($user_id)) {
            redirect('cms_pending.php');
        } else {
            redirect('cms_cpanel.php');
        }
        break;
                   
    case 'Publish':
        $article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
        if (!empty($article_id)) {
            $sql = 'UPDATE cms_articles SET 
                    is_published = TRUE,
                    publish_date = “' . date('Y-m-d H:i:s') . '”
                WHERE
                    article_id = ' . $article_id;
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
   redirect('cms_pending.php');
        break;
                   
    case 'Retract':
        $article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
        if (!empty($article_id)) {
            $sql = 'UPDATE cms_articles SET 
                    is_published = FALSE,
                    publish_date = “0000-00-00 00:00:00”
                WHERE
                    article_id = ' . $article_id;
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
        redirect('cms_pending.php');
        break;
                   
    case 'Delete':
        $article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
        if (!empty($article_id)) {
            $sql = 'DELETE a, c FROM
                    cms_articles a LEFT JOIN cms_comments c ON
                    a.article_id = c.article_id
                WHERE
                    a.article_id = ' . $article_id . ' AND
                    is_published = FALSE';
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
        redirect('cms_pending.php');
        break;
                   
    case 'Submit Comment':
        $article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
        $comment_text = (isset($_POST['comment_text'])) ?
            $_POST['comment_text'] : '';
        if (isset($_SESSION['user_id'])  &&  !empty($article_id)  && 
            !empty($comment_text)) {
            $sql = 'INSERT INTO cms_comments 
                    (article_id, user_id, comment_date, comment_text)
                VALUES
                    (' . $article_id . ',
                    ' . $_SESSION['user_id'] . ',
                    “' . date('Y-m-d H:i:s') . '”,
                    “' . mysqli_real_escape_string($comment_text, $db) . '”)';
            mysqli_query($db,$sql ) or die(mysqli_error($db));
        }
  redirect('cms_view_article.php?article_id=' . $article_id);
        break;
    default:
        redirect('cms_index.php');
    }
 } else {
    redirect('cms_index.php');
 }
 ?> 