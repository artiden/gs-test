<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Person list';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (empty($persons)){
            echo 'No saved person...';
        } else {
            echo '<ul>';
            foreach ($persons as $person) {
                echo sprintf('<li>%s</li>', $person->first_name);
            }
            echo '</ul>';
        }?>
    </p>

</div>
