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
            echo '<form action = "/person/" method = "GET">
<input type = "text" name = "q" placeholder = "Search..." />
<input type = "submit" value = "Go" />
</form>';
            echo '<table>
<thead>
<tr>
<th>First name (<a href = "/person/?order=firstName">+</a>/<a href = "/person/?order=-firsNname">-</a>)</th>
<th>Last name (<a href = "/person/?order=lastName">+</a>/<a href = "/person/?order=-lastName">-</a>)</th>
<th>Phones</th>
</tr>
</thead>
<tbody>';
            foreach ($persons as $person) {
                echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
                    $person->firstName,
                    $person->lastName,
                    empty($person->phones) ? 'None' : implode(', ', array_column($person->phones, 'value')));
            }
            echo '</tbody>
            </table>';
        }?>
    </p>

</div>
