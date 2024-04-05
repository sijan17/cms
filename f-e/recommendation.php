<?php
require 'auth.php';
$recommendedContent = $obj_admin->recommendContent($_SESSION['user_id']);
?>

<div class="resource-content">
                <ul>
                    <?php foreach ($recommendedContent as $content) { ?>
                        <li><a href="<?php echo $content['link'] ?>" data-score="<?php echo $content['score'] ?>">🔰<?php echo $content['title'] ?></a></li>
                    <?php } ?>                
                </ul>
            </div>