<?php
use yii\helpers\Html;

/* $contador */
/* $jugadores */
$contador = 0;
foreach ($jugadores as $jugador): ?>
    <?php
      $activo = $contador == 0 ? 'active' : '';
      $contador++;
    ?>
    <div class="item <?=$activo?>">
      <?=Html::img($jugador->foto)?>
      <div class="carousel-caption">
            <h3 itemprop="athlete"><?= $jugador->nombre ?> </h3>
            <p>Dorsal <?= $jugador->dorsal?></p>
        </div>
    </div>
<?php endforeach; ?>
